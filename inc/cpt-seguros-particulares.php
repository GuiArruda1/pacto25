<?php
/**
 * Custom Post Type: Seguros Particulares
 * Theme: Pacto 25
 * 
 * Strict Agency SOP:
 * - Dedicated Custom Post Type with dashicons-shield-alt
 * - Meta boxes & ACF field support for custom CTA text / URL
 * - Admin columns with thumbnail preview, title, menu_order
 * - Seed helper to auto-populate default items if empty
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register Seguros Particulares Post Type
 */
function pacto_register_cpt_seguros_particulares() {
    $labels = array(
        'name'                  => _x( 'Seguros Particulares', 'Post type general name', 'pacto-25' ),
        'singular_name'         => _x( 'Seguro Particular', 'Post type singular name', 'pacto-25' ),
        'menu_name'             => _x( 'Seguros Particulares', 'Admin Menu text', 'pacto-25' ),
        'name_admin_bar'        => _x( 'Seguro Particular', 'Add New on Toolbar', 'pacto-25' ),
        'add_new'               => __( 'Adicionar Novo', 'pacto-25' ),
        'add_new_item'          => __( 'Adicionar Novo Seguro', 'pacto-25' ),
        'new_item'              => __( 'Novo Seguro Particular', 'pacto-25' ),
        'edit_item'             => __( 'Editar Seguro Particular', 'pacto-25' ),
        'view_item'             => __( 'Ver Seguro', 'pacto-25' ),
        'all_items'             => __( 'Todos os Seguros Particulares', 'pacto-25' ),
        'search_items'          => __( 'Pesquisar Seguros', 'pacto-25' ),
        'parent_item_colon'     => __( 'Seguro Pai:', 'pacto-25' ),
        'not_found'             => __( 'Nenhum seguro encontrado.', 'pacto-25' ),
        'not_found_in_trash'    => __( 'Nenhum seguro no lixo.', 'pacto-25' ),
        'featured_image'        => _x( 'Imagem do Seguro', 'Overrides the “Featured Image” phrase', 'pacto-25' ),
        'set_featured_image'    => _x( 'Definir imagem do seguro', 'Overrides the “Set featured image” phrase', 'pacto-25' ),
        'remove_featured_image' => _x( 'Remover imagem do seguro', 'Overrides the “Remove featured image” phrase', 'pacto-25' ),
        'use_featured_image'    => _x( 'Usar como imagem do seguro', 'Overrides the “Use as featured image” phrase', 'pacto-25' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'seguros-particulares', 'with_front' => false ),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 22,
        'menu_icon'          => 'dashicons-shield-alt',
        'show_in_rest'       => true,
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
    );

    register_post_type( 'seguro_particular', $args );
}
add_action( 'init', 'pacto_register_cpt_seguros_particulares', 0 );

/**
 * Add Meta Box for Button Details if ACF is not active
 */
function pacto_seguro_particular_meta_box() {
    add_meta_box(
        'pacto_seguro_particular_details',
        __( 'Opções do Seguro', 'pacto-25' ),
        'pacto_seguro_particular_meta_box_render',
        'seguro_particular',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'pacto_seguro_particular_meta_box' );

function pacto_seguro_particular_meta_box_render( $post ) {
    wp_nonce_field( 'pacto_seguro_particular_meta_save', 'pacto_seguro_particular_nonce' );
    $btn_text = get_post_meta( $post->ID, '_seguro_btn_text', true );
    $btn_url  = get_post_meta( $post->ID, '_seguro_btn_url', true );

    if ( empty( $btn_text ) ) {
        $btn_text = 'saber mais';
    }
    ?>
    <div style="margin: 10px 0;">
        <label for="seguro_btn_text" style="display: block; font-weight: 600; margin-bottom: 6px;">
            <?php esc_html_e( 'Texto do Botão / Link:', 'pacto-25' ); ?>
        </label>
        <input 
            type="text" 
            id="seguro_btn_text" 
            name="seguro_btn_text" 
            value="<?php echo esc_attr( $btn_text ); ?>" 
            placeholder="<?php esc_attr_e( 'saber mais', 'pacto-25' ); ?>" 
            style="width: 100%; max-width: 400px; padding: 8px 12px; font-size: 14px;"
        />
    </div>

    <div style="margin: 15px 0;">
        <label for="seguro_btn_url" style="display: block; font-weight: 600; margin-bottom: 6px;">
            <?php esc_html_e( 'Link Personalizado (Opcional - deixe vazio para link padrão):', 'pacto-25' ); ?>
        </label>
        <input 
            type="url" 
            id="seguro_btn_url" 
            name="seguro_btn_url" 
            value="<?php echo esc_attr( $btn_url ); ?>" 
            placeholder="<?php esc_attr_e( 'https://... ou /contatos/', 'pacto-25' ); ?>" 
            style="width: 100%; max-width: 500px; padding: 8px 12px; font-size: 14px;"
        />
    </div>
    <?php
}

/**
 * Save Seguro Particular Meta
 */
function pacto_save_seguro_particular_meta( $post_id ) {
    if ( ! isset( $_POST['pacto_seguro_particular_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['pacto_seguro_particular_nonce'] ), 'pacto_seguro_particular_meta_save' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['seguro_btn_text'] ) ) {
        update_post_meta( $post_id, '_seguro_btn_text', sanitize_text_field( wp_unslash( $_POST['seguro_btn_text'] ) ) );
    }
    if ( isset( $_POST['seguro_btn_url'] ) ) {
        update_post_meta( $post_id, '_seguro_btn_url', esc_url_raw( wp_unslash( $_POST['seguro_btn_url'] ) ) );
    }
}
add_action( 'save_post_seguro_particular', 'pacto_save_seguro_particular_meta' );

/**
 * Custom Admin Columns for Seguros Particulares
 */
function pacto_seguro_particular_columns( $columns ) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['thumb'] = __( 'Imagem', 'pacto-25' );
    $new_columns['title'] = __( 'Nome do Seguro', 'pacto-25' );
    $new_columns['menu_order'] = __( 'Ordem', 'pacto-25' );
    $new_columns['date'] = $columns['date'];
    return $new_columns;
}
add_filter( 'manage_seguro_particular_posts_columns', 'pacto_seguro_particular_columns' );

function pacto_seguro_particular_custom_column( $column, $post_id ) {
    switch ( $column ) {
        case 'thumb':
            if ( has_post_thumbnail( $post_id ) ) {
                echo get_the_post_thumbnail( $post_id, array( 50, 50 ), array( 'style' => 'border-radius: 8px; object-fit: cover;' ) );
            } else {
                echo '<span style="color: #999;">—</span>';
            }
            break;
        case 'menu_order':
            $post = get_post( $post_id );
            echo esc_html( $post->menu_order );
            break;
    }
}
add_action( 'manage_seguro_particular_posts_custom_column', 'pacto_seguro_particular_custom_column', 10, 2 );

/**
 * Make Order Column Sortable
 */
function pacto_seguro_particular_sortable_columns( $columns ) {
    $columns['menu_order'] = 'menu_order';
    return $columns;
}
add_filter( 'manage_edit-seguro_particular_sortable_columns', 'pacto_seguro_particular_sortable_columns' );
