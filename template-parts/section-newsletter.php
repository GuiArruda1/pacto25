<?php
/**
 * Template Part: Newsletter & Tips Section
 * Theme: Pacto 25
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$title       = pacto_get_field( 'newsletter_title', false, 'Dicas para Escolher o seu Seguro' );
$description = pacto_get_field( 'newsletter_description', false, 'Subscreva a nossa newsletter e receba mensalmente as melhores dicas e informações sobre o setor segurador.' );
$consent_txt = pacto_get_field( 'newsletter_consent', false, 'Concordo com os termos e a política de privacidade' );
?>

<section class="section section-newsletter" aria-label="<?php esc_attr_e( 'Subscrição de Newsletter', 'pacto-25' ); ?>">
    <div class="site-container">
        <!-- Floating Red Rings for Design Accent -->
        <div class="newsletter-card">
            <div class="decorative-ring" style="width: 44px; height: 44px; top: -20px; right: 10%;"></div>
            <div class="decorative-dot" style="width: 16px; height: 16px; bottom: 10px; left: 8%;"></div>
            <div class="decorative-ring" style="width: 32px; height: 32px; bottom: -10px; right: 15%;"></div>

            <!-- Small Round Icon/Image Accent -->
            <div style="width: 64px; height: 64px; margin: 0 auto var(--space-sm); border-radius: 50%; overflow: hidden; border: 3px solid var(--color-primary);">
                <img src="https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?q=80&w=200&auto=format&fit=crop" alt="<?php esc_attr_e( 'Dicas de Seguros', 'pacto-25' ); ?>" width="64" height="64" loading="lazy" style="width: 100%; height: 100%; object-fit: cover;" />
            </div>

            <?php if ( $title ) : ?>
                <h2 class="h2"><?php echo esc_html( $title ); ?></h2>
            <?php endif; ?>

            <?php if ( $description ) : ?>
                <p class="lead" style="max-width: 540px; margin-left: auto; margin-right: auto;">
                    <?php echo esc_html( $description ); ?>
                </p>
            <?php endif; ?>

            <form class="newsletter-form" action="#" method="post">
                <div class="newsletter-form__row">
                    <input 
                        type="email" 
                        name="newsletter_email" 
                        class="newsletter-form__input" 
                        placeholder="<?php esc_attr_e( 'O seu endereço de email...', 'pacto-25' ); ?>" 
                        aria-label="<?php esc_attr_e( 'Endereço de email', 'pacto-25' ); ?>"
                    />
                    <button type="submit" class="btn btn--dark">
                        <?php esc_html_e( 'SUBSCREVER', 'pacto-25' ); ?>
                    </button>
                </div>

                <label class="newsletter-form__consent">
                    <input type="checkbox" name="newsletter_consent" />
                    <span><?php echo esc_html( $consent_txt ); ?></span>
                </label>
            </form>
        </div>
    </div>
</section>
