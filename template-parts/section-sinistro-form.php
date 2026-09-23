<?php
/**
 * Template Part: Section Sinistro Form ("Participar Sinistro")
 * Theme: Pacto 25
 * 
 * Strict Agency SOP:
 * - Left Giant Red Circle containing the claim submission form
 * - Right Large Circular photo with floating red bubbles
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow     = pacto_get_field( 'sinistro_form_eyebrow', false, '• SINISTROS' );
$title       = pacto_get_field( 'sinistro_form_title', false, 'Participar Sinistro' );
$description = pacto_get_field( 'sinistro_form_description', false, 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Enim amet nullam dictumst dui amet.' );
$image_obj   = pacto_get_field( 'sinistro_form_image', false );

$image_url = ! empty( $image_obj['url'] ) ? $image_obj['url'] : get_template_directory_uri() . '/assets/images/sinistro/sinistro-form-couple.png';
$image_alt = ! empty( $image_obj['alt'] ) ? $image_obj['alt'] : esc_attr( $title );
?>

<section class="section section-ball-left section-sinistro-form" id="participar" aria-label="<?php echo esc_attr( $title ); ?>">
    <!-- Self-Contained Left Red Ball Canopy -->
    <div class="ball-left-canopy big-orange-ball circle-bg-orange" aria-hidden="true"></div>

    <!-- Ambient Floating Red Bubbles Matching Figma -->
    <div class="ball-left-bubble ball-left-bubble--1" aria-hidden="true"></div>
    <div class="ball-left-bubble ball-left-bubble--2" aria-hidden="true"></div>
    <div class="ball-left-bubble ball-left-bubble--3" aria-hidden="true"></div>

    <div class="site-container ball-left-container sinistro-form-container">
        <!-- Content Column (Inside Red Ball) -->
        <div class="ball-left-content sinistro-form-content">
            <?php if ( $eyebrow ) : ?>
                <span class="eyebrow eyebrow--light"><?php echo esc_html( $eyebrow ); ?></span>
            <?php endif; ?>

            <?php if ( $title ) : ?>
                <h2 class="h2 ball-left-title sinistro-form-title"><?php echo esc_html( $title ); ?></h2>
            <?php endif; ?>

            <?php if ( $description ) : ?>
                <p class="ball-left-text sinistro-form-desc"><?php echo nl2br( esc_html( $description ) ); ?></p>
            <?php endif; ?>

            <!-- Participation Form -->
            <form class="sinistro-claim-form" method="post" action="#participar">
                <div class="sinistro-form-group">
                    <label for="sinistro-nome" class="sr-only"><?php esc_html_e( 'Nome', 'pacto-25' ); ?></label>
                    <input type="text" id="sinistro-nome" name="nome" class="sinistro-form-input" placeholder="nome" required />
                </div>

                <div class="sinistro-form-group">
                    <label for="sinistro-email" class="sr-only"><?php esc_html_e( 'E-mail', 'pacto-25' ); ?></label>
                    <input type="email" id="sinistro-email" name="email" class="sinistro-form-input" placeholder="email" required />
                </div>

                <div class="sinistro-form-group">
                    <label for="sinistro-telefone" class="sr-only"><?php esc_html_e( 'Telemóvel', 'pacto-25' ); ?></label>
                    <input type="tel" id="sinistro-telefone" name="telefone" class="sinistro-form-input" placeholder="telemóvel" required />
                </div>

                <div class="sinistro-form-group">
                    <label for="sinistro-tipo" class="sr-only"><?php esc_html_e( 'Tipo de Sinistro', 'pacto-25' ); ?></label>
                    <select id="sinistro-tipo" name="tipo_sinistro" class="sinistro-form-input sinistro-form-select" required>
                        <option value="" disabled selected><?php esc_html_e( 'tipo de sinistro', 'pacto-25' ); ?></option>
                        <option value="automovel"><?php esc_html_e( 'Automóvel', 'pacto-25' ); ?></option>
                        <option value="saude"><?php esc_html_e( 'Saúde', 'pacto-25' ); ?></option>
                        <option value="multirriscos"><?php esc_html_e( 'Multirriscos Casa', 'pacto-25' ); ?></option>
                        <option value="acidentes"><?php esc_html_e( 'Acidentes Pessoais', 'pacto-25' ); ?></option>
                        <option value="outro"><?php esc_html_e( 'Outro', 'pacto-25' ); ?></option>
                    </select>
                </div>

                <div class="sinistro-form-group">
                    <label for="sinistro-mensagem" class="sr-only"><?php esc_html_e( 'Mensagem', 'pacto-25' ); ?></label>
                    <textarea id="sinistro-mensagem" name="mensagem" class="sinistro-form-textarea" placeholder="mensagem" rows="3"></textarea>
                </div>

                <div class="sinistro-form-consent">
                    <label class="sinistro-form-checkbox-label">
                        <input type="checkbox" name="consent" required />
                        <span><?php esc_html_e( 'Li e aceito a ', 'pacto-25' ); ?><a href="<?php echo esc_url( get_privacy_policy_url() ?: '#' ); ?>" target="_blank"><?php esc_html_e( 'Política de Privacidade', 'pacto-25' ); ?></a>.</span>
                    </label>
                </div>

                <div class="sinistro-form-submit-wrap">
                    <button type="submit" class="btn btn--dark sinistro-form-btn">
                        <span><?php esc_html_e( 'submeter', 'pacto-25' ); ?></span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Visual Column (Right Circular Photo) -->
        <div class="ball-left-visual sinistro-form-visual team-circle-wrap">
            <img src="<?php echo esc_url( $image_url ); ?>" 
                 alt="<?php echo esc_attr( $image_alt ); ?>" 
                 loading="lazy" 
                 class="ball-left-photo" />
        </div>
    </div>
</section>
