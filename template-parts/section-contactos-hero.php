<?php
/**
 * Template Part: Section Contactos Hero ("Entre em Contacto com a Pacto Seguro")
 * Theme: Pacto 25
 * 
 * Strict Agency SOP:
 * - Decoupled ACF fields with complete fallback defaults
 * - Left narrative & structured contact meta blocks (Contactos, Morada, Horário)
 * - Right circular photo with top-right organic red canopy & ambient bubbles
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

// ACF Fields with fallbacks matching Figma
$eyebrow    = pacto_get_field( 'contactos_hero_eyebrow', $page_id, 'PACTO SEGURO' );
$title      = pacto_get_field( 'contactos_hero_title', $page_id, 'Entre em Contacto com a Pacto Seguro' );

// Block 1: Contactos
$email      = pacto_get_field( 'contactos_hero_email', $page_id, 'teresa.sousa@pactoseguro.com' );
$phone      = pacto_get_field( 'contactos_hero_phone', $page_id, '229 035 777' );
$phone_note = pacto_get_field( 'contactos_hero_phone_note', $page_id, '(Chamada para a rede fixa nacional)' );

// Block 2: Morada
$address_1  = pacto_get_field( 'contactos_hero_address_1', $page_id, 'Rua José Coutinho 252,' );
$address_2  = pacto_get_field( 'contactos_hero_address_2', $page_id, '4465-180 S. Mamede de Infesta, Matosinhos' );

// Block 3: Horário
$hours_1    = pacto_get_field( 'contactos_hero_hours_1', $page_id, 'Dias úteis: das 09h00 às 12h30' );
$hours_2    = pacto_get_field( 'contactos_hero_hours_2', $page_id, 'e das 14h30 às 17h30' );

// Visual
$image_obj  = pacto_get_field( 'contactos_hero_image', $page_id );
$image_url  = ! empty( $image_obj['url'] ) ? $image_obj['url'] : get_template_directory_uri() . '/assets/images/contactos/contactos-hero-couple.png';
$image_alt  = ! empty( $image_obj['alt'] ) ? $image_obj['alt'] : esc_attr( $title );
?>

<section class="section section-contactos-hero" aria-label="<?php echo esc_attr( $title ); ?>">
    <!-- Top Right Background Red Canopy (1400x1400) -->
    <div class="contactos-hero-canopy" aria-hidden="true"></div>

    <!-- Ambient Floating Red Bubble Matching Figma -->
    <div class="contactos-hero-bubble" aria-hidden="true"></div>

    <div class="site-container">
        <div class="contactos-hero-grid">
            <!-- Left Column: Title & Structured Information Blocks -->
            <div class="contactos-hero-content">
                <?php if ( $eyebrow ) : ?>
                    <span class="eyebrow contactos-hero-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
                <?php endif; ?>

                <?php if ( $title ) : ?>
                    <h1 class="h1 contactos-hero-title"><?php echo esc_html( $title ); ?></h1>
                <?php endif; ?>

                <div class="contactos-hero-blocks">
                    <!-- Block 1: Contactos -->
                    <div class="contactos-meta-block">
                        <span class="contactos-meta-label"><?php esc_html_e( 'CONTACTOS', 'pacto-25' ); ?></span>
                        <div class="contactos-meta-values">
                            <?php if ( $email ) : ?>
                                <a href="<?php echo esc_url( 'mailto:' . $email ); ?>" class="contactos-meta-link">
                                    <?php echo esc_html( $email ); ?>
                                </a>
                            <?php endif; ?>
                            <?php if ( $phone ) : ?>
                                <div class="contactos-meta-phone-wrap">
                                    <a href="<?php echo esc_url( 'tel:' . preg_replace( '/\s+/', '', $phone ) ); ?>" class="contactos-meta-link contactos-meta-phone">
                                        <?php echo esc_html( $phone ); ?>
                                    </a>
                                    <?php if ( $phone_note ) : ?>
                                        <span class="contactos-meta-note"><?php echo esc_html( $phone_note ); ?></span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Block 2: Morada -->
                    <div class="contactos-meta-block">
                        <span class="contactos-meta-label"><?php esc_html_e( 'MORADA', 'pacto-25' ); ?></span>
                        <div class="contactos-meta-values">
                            <?php if ( $address_1 ) : ?>
                                <span class="contactos-meta-text"><?php echo esc_html( $address_1 ); ?></span>
                            <?php endif; ?>
                            <?php if ( $address_2 ) : ?>
                                <span class="contactos-meta-text"><?php echo esc_html( $address_2 ); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Block 3: Horário -->
                    <div class="contactos-meta-block contactos-meta-block--full">
                        <span class="contactos-meta-label"><?php esc_html_e( 'HORÁRIO', 'pacto-25' ); ?></span>
                        <div class="contactos-meta-values">
                            <?php if ( $hours_1 ) : ?>
                                <span class="contactos-meta-text"><?php echo esc_html( $hours_1 ); ?></span>
                            <?php endif; ?>
                            <?php if ( $hours_2 ) : ?>
                                <span class="contactos-meta-text"><?php echo esc_html( $hours_2 ); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Circular Photo Visual -->
            <div class="contactos-hero-visual">
                <div class="contactos-hero-photo-wrap">
                    <img src="<?php echo esc_url( $image_url ); ?>" 
                         alt="<?php echo esc_attr( $image_alt ); ?>" 
                         class="contactos-hero-photo"
                         loading="eager" 
                         fetchpriority="high" />
                </div>
            </div>
        </div>
    </div>
</section>
