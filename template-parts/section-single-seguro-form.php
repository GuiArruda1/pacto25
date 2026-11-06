<?php
/**
 * Template Part: Single Seguro Particular - Formulário de Simulação
 * Theme: Pacto 25
 * Strict Agency SOP: Dynamic ACF bindings, pill inputs, privacy consent, clean right red circle photo frame.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$post_id     = get_the_ID();
$post_title  = get_the_title();

$is_page_landing = is_page_template( 'page-landing.php' ) || is_page( 'landing' ) || is_page( 'modelo-seguro' );
$clean_name      = $post_title;
if ( $is_page_landing && ( empty( $clean_name ) || stripos( $clean_name, 'landing' ) !== false || stripos( $clean_name, 'modelo' ) !== false ) ) {
    $clean_name = 'Seguro Multirriscos Casa';
}

$eyebrow     = pacto_get_field( 'seguro_form_eyebrow', $post_id, 'ALIQUET EU PROIN NON NETUS' );
$title       = pacto_get_field( 'seguro_form_title', $post_id, 'Enim amet nullam dui?' );
$description = pacto_get_field( 'seguro_form_description', $post_id, 'Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Enim amet nullam dictumst dui amet.' );

$image       = pacto_get_field( 'seguro_form_image', $post_id );
$default_img = get_template_directory_uri() . '/assets/images/single-seguro/seguro-form-couple.png';

$status_code = isset( $_GET['simulacao_status'] ) ? sanitize_key( $_GET['simulacao_status'] ) : '';
?>

<section class="section section-single-seguro-form" id="simulacao" aria-label="<?php echo esc_attr( $title ); ?>">
    <div class="site-container">
        <div class="section-single-seguro-form__layout">
            <!-- Left Form & Narrative Column -->
            <div class="section-single-seguro-form__content">
                <?php if ( $eyebrow ) : ?>
                    <span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
                <?php endif; ?>

                <?php if ( $title ) : ?>
                    <h2 class="h2 section-single-seguro-form__title"><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>

                <?php if ( $description ) : ?>
                    <p class="section-single-seguro-form__desc"><?php echo esc_html( $description ); ?></p>
                <?php endif; ?>

                <!-- Feedback Container (AJAX and Post-Redirect) -->
                <?php if ( 'success' === $status_code ) : ?>
                    <div class="seguro-form-feedback pacto-form-feedback--success" role="alert" style="display:block;">
                        <p><?php echo esc_html( pacto_get_field( 'seguro_form_success_message', $post_id, __( 'Obrigado! O seu pedido de simulação foi enviado com sucesso. Entraremos em contacto consigo com a máxima brevidade.', 'pacto-25' ) ) ); ?></p>
                    </div>
                <?php elseif ( ! empty( $status_code ) && 'success' !== $status_code ) : ?>
                    <div class="seguro-form-feedback pacto-form-feedback--error" role="alert" style="display:block;">
                        <p><?php esc_html_e( 'Por favor verifique os campos obrigatórios e aceite a Política de Privacidade antes de submeter.', 'pacto-25' ); ?></p>
                    </div>
                <?php else : ?>
                    <div class="seguro-form-feedback" role="alert" style="display:none;"></div>
                <?php endif; ?>

                <!-- Form -->
                <form class="seguro-simulacao-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                    <?php wp_nonce_field( 'pacto_simulacao_form_action', 'seguro_simulacao_nonce_field' ); ?>
                    <input type="hidden" name="action" value="pacto_submit_simulacao" />
                    <input type="hidden" name="post_id" value="<?php echo esc_attr( $post_id ); ?>" />
                    <input type="hidden" name="seguro_nome" value="<?php echo esc_attr( $clean_name ); ?>" />
                    
                    <!-- Anti-spam Honeypot -->
                    <input type="text" name="simulacao_website" style="display:none !important; position:absolute; left:-9999px;" tabindex="-1" autocomplete="off" />

                    <div class="seguro-form-group">
                        <label for="seguro_input_nome" class="screen-reader-text"><?php esc_html_e( 'Nome', 'pacto-25' ); ?></label>
                        <input type="text" id="seguro_input_nome" name="nome" placeholder="<?php esc_attr_e( 'nome', 'pacto-25' ); ?>" required class="seguro-form-input" />
                    </div>

                    <div class="seguro-form-group">
                        <label for="seguro_input_email" class="screen-reader-text"><?php esc_html_e( 'Email', 'pacto-25' ); ?></label>
                        <input type="email" id="seguro_input_email" name="email" placeholder="<?php esc_attr_e( 'email', 'pacto-25' ); ?>" required class="seguro-form-input" />
                    </div>

                    <div class="seguro-form-group">
                        <label for="seguro_input_telemovel" class="screen-reader-text"><?php esc_html_e( 'Telemóvel', 'pacto-25' ); ?></label>
                        <input type="tel" id="seguro_input_telemovel" name="telemovel" placeholder="<?php esc_attr_e( 'telemóvel', 'pacto-25' ); ?>" required class="seguro-form-input" />
                    </div>

                    <div class="seguro-form-group">
                        <label for="seguro_input_mensagem" class="screen-reader-text"><?php esc_html_e( 'Mensagem', 'pacto-25' ); ?></label>
                        <textarea id="seguro_input_mensagem" name="mensagem" placeholder="<?php esc_attr_e( 'mensagem', 'pacto-25' ); ?>" rows="4" class="seguro-form-textarea"></textarea>
                    </div>

                    <div class="seguro-form-consent">
                        <label class="seguro-consent-label">
                            <input type="checkbox" name="privacy_consent" required class="seguro-consent-checkbox" />
                            <span>
                                <?php esc_html_e( 'Li e aceito a', 'pacto-25' ); ?>
                                <a href="<?php echo esc_url( home_url( '/politica-de-privacidade/' ) ); ?>" target="_blank" rel="noopener noreferrer">
                                    <?php esc_html_e( 'Política de Privacidade.', 'pacto-25' ); ?>
                                </a>
                            </span>
                        </label>
                    </div>

                    <div class="seguro-form-submit-wrap">
                        <button type="submit" class="btn btn--dark seguro-form-submit-btn">
                            <span><?php esc_html_e( 'submeter', 'pacto-25' ); ?></span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Right Visual Column (Clean Large Circular Frame with Red Border) -->
            <div class="section-single-seguro-form__visual">
                <div class="seguro-form-circle-wrap">
                    <div class="seguro-form-circle-frame">
                        <?php pacto_render_image( $image, 'full', 'seguro-form-img', $default_img, true ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
