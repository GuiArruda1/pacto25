<?php
/**
 * Template Part: Newsletter & Tips Section
 * Theme: Pacto 25
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow     = pacto_get_field( 'newsletter_eyebrow', false, 'FAÇA DOWNLOAD DO NOSSO EBOOK' );
$title       = pacto_get_field( 'newsletter_title', false, 'Dicas para Escolher o seu Seguro' );
$description = pacto_get_field( 'newsletter_description', false, 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.' );
$btn_text    = pacto_get_field( 'newsletter_btn_text', false, 'receber ebook gratuito' );
$consent_txt = pacto_get_field( 'newsletter_consent', false, 'Li e aceito a Política de Privacidade.' );
$image       = pacto_get_field( 'newsletter_image' );
$default_img = get_template_directory_uri() . '/assets/home/01-Homepage/home-ebook-pacto-seguro.webp';
$privacy_url = function_exists( 'get_privacy_policy_url' ) && get_privacy_policy_url() ? get_privacy_policy_url() : '#';
?>

<section class="section section-newsletter" aria-label="<?php esc_attr_e( 'Subscrição de Newsletter e Ebook', 'pacto-25' ); ?>">
    <!-- Floating Red Rings circulating around like Figma -->
    <div class="newsletter-bubbles" aria-hidden="true">
        <!-- 2. Small Ring Top-Left -->
        <div class="newsletter-bubble newsletter-bubble--ring-tl"></div>

        <!-- 3. Medium Ring Far-Left -->
        <div class="newsletter-bubble newsletter-bubble--ring-fl"></div>

        <!-- 4. Thick Ring Bottom-Left -->
        <div class="newsletter-bubble newsletter-bubble--ring-bl"></div>

        <!-- 5. Large Ring Top-Right -->
        <div class="newsletter-bubble newsletter-bubble--ring-tr"></div>

        <!-- 6. Small Ring Middle-Right -->
        <div class="newsletter-bubble newsletter-bubble--ring-mr"></div>

        <!-- 7. Large Ring Bottom-Right -->
        <div class="newsletter-bubble newsletter-bubble--ring-br"></div>

        <!-- 8. Small Ring Bottom-Center-Right -->
        <div class="newsletter-bubble newsletter-bubble--ring-bcr"></div>
    </div>

    <div class="site-container newsletter-container">
        <div class="newsletter-card">
            <!-- 1. Left Image Bubble (Couple on red pool float, 170x195) -->
            <div class="newsletter-bubble newsletter-bubble--image" aria-hidden="true">
                <?php pacto_render_image( $image, 'medium', 'newsletter-bubble__img', $default_img ); ?>
            </div>

            <?php if ( $eyebrow ) : ?>
                <div class="eyebrow"><?php echo esc_html( $eyebrow ); ?></div>
            <?php endif; ?>

            <?php if ( $title ) : ?>
                <h2 class="h2"><?php echo esc_html( $title ); ?></h2>
            <?php endif; ?>

            <?php if ( $description ) : ?>
                <p class="lead newsletter-desc">
                    <?php echo esc_html( $description ); ?>
                </p>
            <?php endif; ?>

            <form class="newsletter-form" action="#" method="post">
                <div class="newsletter-form__row">
                    <input 
                        type="email" 
                        name="newsletter_email" 
                        class="newsletter-form__input" 
                        placeholder="<?php esc_attr_e( 'Email', 'pacto-25' ); ?>" 
                        aria-label="<?php esc_attr_e( 'Endereço de email', 'pacto-25' ); ?>"
                        required
                    />
                    <button type="submit" class="btn btn--dark newsletter-form__btn">
                        <span><?php echo esc_html( $btn_text ); ?></span>
                    </button>
                </div>

                <label class="newsletter-form__consent">
                    <input type="checkbox" name="newsletter_consent" required />
                    <span>Li e aceito a <a href="<?php echo esc_url( $privacy_url ); ?>">Política de Privacidade</a>.</span>
                </label>
            </form>
        </div>
    </div>
</section>
