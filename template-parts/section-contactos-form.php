<?php
/**
 * Template Part: Section Contactos Form ("Como podemos ajudar?")
 * Theme: Pacto 25
 * 
 * Strict Agency SOP:
 * - Decoupled ACF fields with fallback defaults
 * - Left circular photo frame with thick red border ring
 * - Right narrative & modern 2-column contact form
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$page_id = get_the_ID() ?: get_queried_object_id();
if ( ! $page_id ) {
    $contact_page = get_page_by_path( 'contactos' );
    if ( $contact_page ) {
        $page_id = $contact_page->ID;
    }
}

$eyebrow     = pacto_get_field( 'contactos_form_eyebrow', $page_id, 'FALE CONNOSCO' );
$title       = pacto_get_field( 'contactos_form_title', $page_id, 'Como podemos ajudar?' );
$description = pacto_get_field( 'contactos_form_description', $page_id, 'Enim amet nullam dictumst dui amet, sit tellus morbi ut auctor.' );
$image_obj   = pacto_get_field( 'contactos_form_image', $page_id );

$image_url = ! empty( $image_obj['url'] ) ? $image_obj['url'] : get_template_directory_uri() . '/assets/images/contactos/contactos-help-couple.png';
$image_alt = ! empty( $image_obj['alt'] ) ? $image_obj['alt'] : esc_attr( $title );
?>

<section class="section section-contactos-help" id="formulario" aria-label="<?php echo esc_attr( $title ); ?>">
    <div class="site-container">
        <div class="contactos-help-grid">
            <!-- Left Column: Circular Photo (720x720) with Thick Red Ring -->
            <div class="contactos-help-visual">
                <div class="contactos-help-circle-frame">
                    <div class="contactos-help-circle-ring" aria-hidden="true"></div>
                    <div class="contactos-help-circle-photo">
                        <img src="<?php echo esc_url( $image_url ); ?>" 
                             alt="<?php echo esc_attr( $image_alt ); ?>" 
                             loading="lazy" />
                    </div>
                </div>
                <!-- Ambient Bubble Dot Below Circle Matching Figma -->
                <div class="contactos-help-bubble contactos-help-bubble--bottom" aria-hidden="true"></div>
            </div>

            <!-- Right Column: Heading & Contact Form -->
            <div class="contactos-help-content">
                <?php if ( $eyebrow ) : ?>
                    <span class="eyebrow contactos-help-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
                <?php endif; ?>

                <?php if ( $title ) : ?>
                    <h2 class="h2 contactos-help-title"><?php echo esc_html( $title ); ?></h2>
                <?php endif; ?>

                <?php if ( $description ) : ?>
                    <p class="contactos-help-desc"><?php echo esc_html( $description ); ?></p>
                <?php endif; ?>

                <!-- Contact Form -->
                <form class="contactos-inquiry-form" method="post" action="#formulario">
                    <div class="contactos-form-row">
                        <div class="contactos-form-group">
                            <label for="contactos-nome" class="sr-only"><?php esc_html_e( 'Nome', 'pacto-25' ); ?></label>
                            <input type="text" id="contactos-nome" name="nome" class="contactos-input" placeholder="nome" required />
                        </div>
                        <div class="contactos-form-group">
                            <label for="contactos-email" class="sr-only"><?php esc_html_e( 'E-mail', 'pacto-25' ); ?></label>
                            <input type="email" id="contactos-email" name="email" class="contactos-input" placeholder="email" required />
                        </div>
                    </div>

                    <div class="contactos-form-row">
                        <div class="contactos-form-group">
                            <label for="contactos-telemovel" class="sr-only"><?php esc_html_e( 'Telemóvel', 'pacto-25' ); ?></label>
                            <input type="tel" id="contactos-telemovel" name="telemovel" class="contactos-input" placeholder="telemovel" required />
                        </div>
                        <div class="contactos-form-group">
                            <label for="contactos-assunto" class="sr-only"><?php esc_html_e( 'Assunto', 'pacto-25' ); ?></label>
                            <select id="contactos-assunto" name="assunto" class="contactos-input contactos-select" required>
                                <option value="" disabled selected><?php esc_html_e( 'assunto', 'pacto-25' ); ?></option>
                                <option value="geral"><?php esc_html_e( 'Informações Gerais', 'pacto-25' ); ?></option>
                                <option value="particulares"><?php esc_html_e( 'Seguros Particulares', 'pacto-25' ); ?></option>
                                <option value="empresas"><?php esc_html_e( 'Seguros Empresas', 'pacto-25' ); ?></option>
                                <option value="sinistros"><?php esc_html_e( 'Sinistros', 'pacto-25' ); ?></option>
                                <option value="protocolos"><?php esc_html_e( 'Protocolos', 'pacto-25' ); ?></option>
                                <option value="outro"><?php esc_html_e( 'Outro', 'pacto-25' ); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="contactos-form-group contactos-form-group--full">
                        <label for="contactos-mensagem" class="sr-only"><?php esc_html_e( 'Mensagem', 'pacto-25' ); ?></label>
                        <textarea id="contactos-mensagem" name="mensagem" class="contactos-textarea" placeholder="mensagem" rows="4"></textarea>
                    </div>

                    <div class="contactos-form-consent">
                        <label class="contactos-checkbox-label">
                            <input type="checkbox" name="consent" required />
                            <span><?php esc_html_e( 'Li e aceito a ', 'pacto-25' ); ?><a href="<?php echo esc_url( get_privacy_policy_url() ?: '#' ); ?>" target="_blank"><?php esc_html_e( 'Política de Privacidade', 'pacto-25' ); ?></a>.</span>
                        </label>
                    </div>

                    <div class="contactos-form-submit-wrap">
                        <button type="submit" class="btn btn--dark contactos-form-btn">
                            <span><?php esc_html_e( 'submeter', 'pacto-25' ); ?></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
