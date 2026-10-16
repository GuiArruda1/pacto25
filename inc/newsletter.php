<?php
/**
 * Newsletter Subscribers
 * Theme: Pacto 25
 *
 * - Custom DB table: {prefix}pacto_newsletter
 * - AJAX endpoint (nonce + honeypot + email validation + duplicate check)
 * - Admin page "Newsletter" listing subscribers, delete, and CSV export
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'PACTO_NEWSLETTER_DB_VERSION', '1.0.0' );

/**
 * Table name helper.
 */
function pacto_newsletter_table() {
    global $wpdb;
    return $wpdb->prefix . 'pacto_newsletter';
}

/**
 * Create / upgrade the subscribers table (runs once per DB version).
 */
function pacto_newsletter_install() {
    if ( get_option( 'pacto_newsletter_db_version' ) === PACTO_NEWSLETTER_DB_VERSION ) {
        return;
    }

    global $wpdb;
    $table   = pacto_newsletter_table();
    $charset = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE {$table} (
        id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        email VARCHAR(190) NOT NULL,
        consent TINYINT(1) NOT NULL DEFAULT 0,
        source VARCHAR(190) NOT NULL DEFAULT '',
        ip_address VARCHAR(45) NOT NULL DEFAULT '',
        user_agent VARCHAR(255) NOT NULL DEFAULT '',
        created_at DATETIME NOT NULL,
        PRIMARY KEY  (id),
        UNIQUE KEY email (email)
    ) {$charset};";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta( $sql );

    update_option( 'pacto_newsletter_db_version', PACTO_NEWSLETTER_DB_VERSION );
}
add_action( 'after_switch_theme', 'pacto_newsletter_install' );
add_action( 'init', 'pacto_newsletter_install' );

/**
 * Expose AJAX URL + nonce to main.js.
 */
function pacto_newsletter_localize() {
    wp_localize_script( 'pacto-main', 'pactoNewsletter', array(
        'ajaxUrl' => admin_url( 'admin-ajax.php' ),
        'nonce'   => wp_create_nonce( 'pacto_newsletter' ),
        'i18n'    => array(
            'success'   => __( 'Obrigado! A sua subscrição foi registada com sucesso.', 'pacto-25' ),
            'duplicate' => __( 'Este email já se encontra registado.', 'pacto-25' ),
            'invalid'   => __( 'Por favor, introduza um email válido.', 'pacto-25' ),
            'consent'   => __( 'Tem de aceitar a Política de Privacidade.', 'pacto-25' ),
            'error'     => __( 'Ocorreu um erro. Por favor, tente novamente.', 'pacto-25' ),
        ),
    ) );
}
add_action( 'wp_enqueue_scripts', 'pacto_newsletter_localize', 20 );

/**
 * AJAX handler (logged-in and guests).
 */
function pacto_newsletter_subscribe() {
    if ( ! check_ajax_referer( 'pacto_newsletter', 'nonce', false ) ) {
        wp_send_json_error( array( 'code' => 'error' ), 403 );
    }

    // Honeypot: bots fill hidden field
    if ( ! empty( $_POST['newsletter_website'] ) ) {
        wp_send_json_success( array( 'code' => 'success' ) );
    }

    $email   = isset( $_POST['newsletter_email'] ) ? sanitize_email( wp_unslash( $_POST['newsletter_email'] ) ) : '';
    $consent = ! empty( $_POST['newsletter_consent'] ) ? 1 : 0;
    $source  = isset( $_POST['source'] ) ? esc_url_raw( wp_unslash( $_POST['source'] ) ) : '';

    if ( ! $email || ! is_email( $email ) ) {
        wp_send_json_error( array( 'code' => 'invalid' ), 422 );
    }

    if ( ! $consent ) {
        wp_send_json_error( array( 'code' => 'consent' ), 422 );
    }

    global $wpdb;
    $table = pacto_newsletter_table();
    $email = strtolower( $email );

    $exists = $wpdb->get_var( $wpdb->prepare( "SELECT id FROM {$table} WHERE email = %s", $email ) );
    if ( $exists ) {
        wp_send_json_error( array( 'code' => 'duplicate' ), 409 );
    }

    $inserted = $wpdb->insert(
        $table,
        array(
            'email'      => $email,
            'consent'    => $consent,
            'source'     => substr( $source, 0, 190 ),
            'ip_address' => isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '',
            'user_agent' => isset( $_SERVER['HTTP_USER_AGENT'] ) ? substr( sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ), 0, 255 ) : '',
            'created_at' => current_time( 'mysql' ),
        ),
        array( '%s', '%d', '%s', '%s', '%s', '%s' )
    );

    if ( false === $inserted ) {
        wp_send_json_error( array( 'code' => 'error' ), 500 );
    }

    /**
     * Hook for integrations (e.g. send ebook email, Mailchimp sync).
     */
    do_action( 'pacto_newsletter_subscribed', $email, $wpdb->insert_id );

    wp_send_json_success( array( 'code' => 'success' ) );
}
add_action( 'wp_ajax_pacto_newsletter_subscribe', 'pacto_newsletter_subscribe' );
add_action( 'wp_ajax_nopriv_pacto_newsletter_subscribe', 'pacto_newsletter_subscribe' );

/**
 * Admin menu.
 */
function pacto_newsletter_admin_menu() {
    add_menu_page(
        __( 'Newsletter', 'pacto-25' ),
        __( 'Newsletter', 'pacto-25' ),
        'manage_options',
        'pacto-newsletter',
        'pacto_newsletter_admin_page',
        'dashicons-email-alt',
        26
    );
}
add_action( 'admin_menu', 'pacto_newsletter_admin_menu' );

/**
 * Handle CSV export + delete before any output.
 */
function pacto_newsletter_admin_actions() {
    if ( ! is_admin() || ! current_user_can( 'manage_options' ) || empty( $_GET['page'] ) || 'pacto-newsletter' !== $_GET['page'] ) {
        return;
    }

    global $wpdb;
    $table = pacto_newsletter_table();

    // CSV export
    if ( isset( $_GET['pacto_export'] ) && check_admin_referer( 'pacto_newsletter_export' ) ) {
        $rows = $wpdb->get_results( "SELECT email, consent, source, created_at FROM {$table} ORDER BY created_at DESC", ARRAY_A );

        nocache_headers();
        header( 'Content-Type: text/csv; charset=utf-8' );
        header( 'Content-Disposition: attachment; filename=newsletter-' . gmdate( 'Y-m-d' ) . '.csv' );

        $out = fopen( 'php://output', 'w' );
        fprintf( $out, chr( 0xEF ) . chr( 0xBB ) . chr( 0xBF ) ); // UTF-8 BOM for Excel
        fputcsv( $out, array( 'Email', 'Consentimento', 'Origem', 'Data' ) );
        foreach ( $rows as $row ) {
            fputcsv( $out, array( $row['email'], $row['consent'] ? 'Sim' : 'Não', $row['source'], $row['created_at'] ) );
        }
        fclose( $out );
        exit;
    }

    // Delete single subscriber
    if ( isset( $_GET['pacto_delete'] ) ) {
        $id = absint( $_GET['pacto_delete'] );
        check_admin_referer( 'pacto_newsletter_delete_' . $id );
        $wpdb->delete( $table, array( 'id' => $id ), array( '%d' ) );
        wp_safe_redirect( admin_url( 'admin.php?page=pacto-newsletter&deleted=1' ) );
        exit;
    }
}
add_action( 'admin_init', 'pacto_newsletter_admin_actions' );

/**
 * Admin page output.
 */
function pacto_newsletter_admin_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    global $wpdb;
    $table    = pacto_newsletter_table();
    $per_page = 50;
    $paged    = max( 1, isset( $_GET['paged'] ) ? absint( $_GET['paged'] ) : 1 );
    $search   = isset( $_GET['s'] ) ? sanitize_text_field( wp_unslash( $_GET['s'] ) ) : '';
    $offset   = ( $paged - 1 ) * $per_page;

    $where = '';
    if ( $search ) {
        $where = $wpdb->prepare( 'WHERE email LIKE %s', '%' . $wpdb->esc_like( $search ) . '%' );
    }

    $total = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$table} {$where}" );
    $rows  = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$table} {$where} ORDER BY created_at DESC LIMIT %d OFFSET %d", $per_page, $offset ) );
    $pages = (int) ceil( $total / $per_page );

    $export_url = wp_nonce_url( admin_url( 'admin.php?page=pacto-newsletter&pacto_export=1' ), 'pacto_newsletter_export' );
    ?>
    <div class="wrap">
        <h1 class="wp-heading-inline"><?php esc_html_e( 'Subscritores da Newsletter', 'pacto-25' ); ?></h1>
        <a href="<?php echo esc_url( $export_url ); ?>" class="page-title-action"><?php esc_html_e( 'Exportar CSV', 'pacto-25' ); ?></a>
        <hr class="wp-header-end">

        <?php if ( isset( $_GET['deleted'] ) ) : ?>
            <div class="notice notice-success is-dismissible"><p><?php esc_html_e( 'Subscritor removido.', 'pacto-25' ); ?></p></div>
        <?php endif; ?>

        <form method="get" style="margin: 12px 0;">
            <input type="hidden" name="page" value="pacto-newsletter" />
            <p class="search-box">
                <input type="search" name="s" value="<?php echo esc_attr( $search ); ?>" placeholder="<?php esc_attr_e( 'Pesquisar email…', 'pacto-25' ); ?>" />
                <input type="submit" class="button" value="<?php esc_attr_e( 'Pesquisar', 'pacto-25' ); ?>" />
            </p>
        </form>

        <p><strong><?php echo esc_html( number_format_i18n( $total ) ); ?></strong> <?php esc_html_e( 'subscritores', 'pacto-25' ); ?></p>

        <table class="widefat striped">
            <thead>
                <tr>
                    <th><?php esc_html_e( 'Email', 'pacto-25' ); ?></th>
                    <th><?php esc_html_e( 'Consentimento', 'pacto-25' ); ?></th>
                    <th><?php esc_html_e( 'Origem', 'pacto-25' ); ?></th>
                    <th><?php esc_html_e( 'Data', 'pacto-25' ); ?></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if ( empty( $rows ) ) : ?>
                    <tr><td colspan="5"><?php esc_html_e( 'Ainda não existem subscritores.', 'pacto-25' ); ?></td></tr>
                <?php else : foreach ( $rows as $row ) :
                    $del_url = wp_nonce_url( admin_url( 'admin.php?page=pacto-newsletter&pacto_delete=' . $row->id ), 'pacto_newsletter_delete_' . $row->id );
                ?>
                    <tr>
                        <td><a href="mailto:<?php echo esc_attr( $row->email ); ?>"><?php echo esc_html( $row->email ); ?></a></td>
                        <td><?php echo $row->consent ? '✔' : '—'; ?></td>
                        <td><?php echo esc_html( $row->source ); ?></td>
                        <td><?php echo esc_html( mysql2date( 'd/m/Y H:i', $row->created_at ) ); ?></td>
                        <td><a href="<?php echo esc_url( $del_url ); ?>" class="submitdelete" style="color:#b32d2e;" onclick="return confirm('<?php echo esc_js( __( 'Remover este subscritor?', 'pacto-25' ) ); ?>');"><?php esc_html_e( 'Remover', 'pacto-25' ); ?></a></td>
                    </tr>
                <?php endforeach; endif; ?>
            </tbody>
        </table>

        <?php if ( $pages > 1 ) : ?>
            <div class="tablenav"><div class="tablenav-pages">
                <?php
                echo paginate_links( array( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                    'base'    => add_query_arg( 'paged', '%#%' ),
                    'format'  => '',
                    'current' => $paged,
                    'total'   => $pages,
                ) );
                ?>
            </div></div>
        <?php endif; ?>
    </div>
    <?php
}
