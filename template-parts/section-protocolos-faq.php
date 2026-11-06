<?php
/**
 * Template Part: Section Protocolos Descubra as Condições (Lead Form)
 * Theme: Pacto 25
 * Strict Agency SOP: Dynamic ACF bindings, clean single-column pill input form, circular doctor visual frame.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$page_id = get_the_ID();

$eyebrow = pacto_get_field( 'protocolos_faq_eyebrow', $page_id, '• PROTOCOLOS • PACTO SEGURO' );
$title   = pacto_get_field( 'protocolos_faq_title', $page_id, 'Descubra as Condições Disponíveis para a Sua Profissão' );
$text    = pacto_get_field( 'protocolos_faq_text', $page_id, 'Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Sit tellus morbi ut auctor dui amet.' );

$image_obj = pacto_get_field( 'protocolos_faq_image', $page_id );
$image_url = pacto_get_image_url( $image_obj, 'large', get_template_directory_uri() . '/assets/images/protocolos-doctor.png' );
$image_alt = is_array( $image_obj ) && ! empty( $image_obj['alt'] ) ? $image_obj['alt'] : esc_attr( $title );

$status_code = isset( $_GET['protocolos_status'] ) ? sanitize_key( $_GET['protocolos_status'] ) : '';
?>

<section class="section section-protocolos-faq" aria-label="<?php echo esc_attr( $title ); ?>">
    <div class="site-container">
        <div class="protocolos-faq-grid">
            
            <div class="protocolos-faq-visual">
                <!-- Circular Photo with Red Border Matching Figma -->
                <div class="protocolos-faq-photo-wrap">
                    <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" class="protocolos-faq-photo" loading="lazy" />
                </div>
            </div>
            
            <div class="protocolos-faq-content">
                <?php if ( $eyebrow ) : ?>
                    <span class="protocolos-faq-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
                <?php endif; ?>
                
                <h2 class="h2 protocolos-faq-title"><?php echo esc_html( $title ); ?></h2>
                
                <?php if ( $text ) : ?>
                    <div class="protocolos-faq-text">
                        <p><?php echo wp_kses_post( $text ); ?></p>
                    </div>
                <?php endif; ?>

                <!-- Feedback Container (AJAX and Post-Redirect) -->
                <?php if ( 'success' === $status_code ) : ?>
                    <div class="protocolos-form-feedback pacto-form-feedback--success" role="alert" style="display:block;">
                        <p><?php echo esc_html( pacto_get_field( 'protocolos_form_success_message', get_the_ID(), __( 'Obrigado! O seu pedido de informação sobre protocolos foi enviado com sucesso. Entraremos em contacto brevemente.', 'pacto-25' ) ) ); ?></p>
                    </div>
                <?php elseif ( ! empty( $status_code ) && 'success' !== $status_code ) : ?>
                    <div class="protocolos-form-feedback pacto-form-feedback--error" role="alert" style="display:block;">
                        <p><?php esc_html_e( 'Por favor verifique os campos obrigatórios e aceite a Política de Privacidade antes de submeter.', 'pacto-25' ); ?></p>
                    </div>
                <?php else : ?>
                    <div class="protocolos-form-feedback" role="alert" style="display:none;"></div>
                <?php endif; ?>

                <form class="protocolos-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" id="formulario-protocolos">
                    <?php wp_nonce_field( 'pacto_protocolos_form_action', 'protocolos_form_nonce_field' ); ?>
                    <input type="hidden" name="action" value="pacto_submit_protocolos" />
                    <input type="hidden" name="page_id" value="<?php echo esc_attr( get_the_ID() ); ?>" />
                    
                    <!-- Anti-spam Honeypot -->
                    <input type="text" name="protocolos_website" style="display:none !important; position:absolute; left:-9999px;" tabindex="-1" autocomplete="off" />

                    <div class="protocolos-form-group">
                        <label for="protocolos_input_nome" class="screen-reader-text"><?php esc_html_e( 'Nome', 'pacto-25' ); ?></label>
                        <input type="text" id="protocolos_input_nome" name="nome" placeholder="<?php esc_attr_e( 'nome', 'pacto-25' ); ?>" required class="protocolos-form-input" />
                    </div>

                    <div class="protocolos-form-group">
                        <label for="protocolos_input_email" class="screen-reader-text"><?php esc_html_e( 'Email', 'pacto-25' ); ?></label>
                        <input type="email" id="protocolos_input_email" name="email" placeholder="<?php esc_attr_e( 'email', 'pacto-25' ); ?>" required class="protocolos-form-input" />
                    </div>

                    <div class="protocolos-form-group">
                        <label for="protocolos_input_telemovel" class="screen-reader-text"><?php esc_html_e( 'Telemóvel', 'pacto-25' ); ?></label>
                        <input type="tel" id="protocolos_input_telemovel" name="telemovel" placeholder="<?php esc_attr_e( 'telemóvel', 'pacto-25' ); ?>" required class="protocolos-form-input" />
                    </div>

                    <div class="protocolos-form-group">
                        <label for="protocolos_input_mensagem" class="screen-reader-text"><?php esc_html_e( 'Mensagem', 'pacto-25' ); ?></label>
                        <textarea id="protocolos_input_mensagem" name="mensagem" placeholder="<?php esc_attr_e( 'mensagem', 'pacto-25' ); ?>" rows="4" class="protocolos-form-textarea"></textarea>
                    </div>

                    <div class="protocolos-form-consent">
                        <label class="protocolos-consent-label">
                            <input type="checkbox" name="privacy_consent" required class="protocolos-consent-checkbox" />
                            <span>
                                <?php esc_html_e( 'Li e aceito a', 'pacto-25' ); ?>
                                <a href="<?php echo esc_url( get_privacy_policy_url() ?: home_url( '/politica-de-privacidade/' ) ); ?>" target="_blank" rel="noopener noreferrer">
                                    <?php esc_html_e( 'Política de Privacidade', 'pacto-25' ); ?>
                                </a>
                            </span>
                        </label>
                    </div>

                    <div class="protocolos-form-submit-wrap">
                        <button type="submit" class="btn btn--dark protocolos-form-btn">
                            <span><?php esc_html_e( 'submeter', 'pacto-25' ); ?></span>
                        </button>
                    </div>
                </form>

            </div>
            
        </div>
    </div>
</section>
