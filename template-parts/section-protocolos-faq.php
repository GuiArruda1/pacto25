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
$image_url = ! empty( $image_obj['url'] ) ? $image_obj['url'] : get_template_directory_uri() . '/assets/images/protocolos-doctor.png';
$image_alt = ! empty( $image_obj['alt'] ) ? $image_obj['alt'] : esc_attr( $title );

// Handle submission feedback
$form_submitted = false;
if ( 'POST' === $_SERVER['REQUEST_METHOD'] && isset( $_POST['protocolos_form_nonce_field'] ) ) {
    if ( wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['protocolos_form_nonce_field'] ) ), 'pacto_protocolos_form_nonce' ) ) {
        $form_submitted = true;
    }
}
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

                <?php if ( $form_submitted ) : ?>
                    <div class="protocolos-form-success" role="alert">
                        <?php esc_html_e( 'O seu pedido foi enviado com sucesso. Entraremos em contacto brevemente.', 'pacto-25' ); ?>
                    </div>
                <?php endif; ?>

                <form class="protocolos-form" method="post" action="#formulario-protocolos" id="formulario-protocolos">
                    <?php wp_nonce_field( 'pacto_protocolos_form_nonce', 'protocolos_form_nonce_field' ); ?>

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
