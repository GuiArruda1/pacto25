<?php
/**
 * Template Part: Reusable FAQ Accordion Section ("Questões Mais Frequentes")
 * Theme: Pacto 25
 * 
 * Strict Agency SOP:
 * - Reusable across Single Seguro Particular, Quem Somos, Particulares, Protocolos, etc.
 * - Dynamic ACF bindings with page-specific overrides & custom $args support
 * - Accessible pill-shaped accordion with smooth animations and ambient red rings
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// 1. Check custom $args passed to get_template_part()
$eyebrow     = ! empty( $args['eyebrow'] )     ? $args['eyebrow']     : '';
$title       = ! empty( $args['title'] )       ? $args['title']       : '';
$description = ! empty( $args['description'] ) ? $args['description'] : '';
$faqs        = ! empty( $args['faqs'] )        ? $args['faqs']        : array();

// 2. Fallback to ACF fields if not passed in $args
if ( empty( $eyebrow ) ) {
    $eyebrow = pacto_get_field( 'seguro_faq_eyebrow', false, pacto_get_field( 'faq_eyebrow', false, '• FAQS' ) );
}
if ( empty( $title ) ) {
    $title = pacto_get_field( 'seguro_faq_title', false, pacto_get_field( 'faq_title', false, 'Questões Mais Frequentes' ) );
}
if ( empty( $description ) ) {
    $description = pacto_get_field( 'seguro_faq_description', false, pacto_get_field( 'faq_description', false, 'Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Enim amet nullam dictumst dui amet.' ) );
}

// 3. Fallback to ACF repeater list or default FAQs
if ( empty( $faqs ) ) {
    $acf_faqs = pacto_get_field( 'seguro_faq_list', false, pacto_get_field( 'faq_list', false, array() ) );
    if ( ! empty( $acf_faqs ) && is_array( $acf_faqs ) ) {
        $faqs = $acf_faqs;
    } else {
        $faqs = array(
            array(
                'question' => 'Que elementos terei de apresentar para subscrever o seguro multirriscos para o imóvel?',
                'answer'   => 'Para subscrever o seguro multirriscos, necessitará de apresentar o documento de identificação, NIF, comprovativo de morada do imóvel e a caderneta predial ou certidão do registo predial atualizada.',
            ),
            array(
                'question' => 'Como posso calcular o valor do meu recheio para o seguro multirriscos?',
                'answer'   => 'O cálculo do recheio deve contemplar o valor de substituição em novo de todos os bens mobiliários, eletrodomésticos, equipamentos eletrónicos e objetos de uso pessoal presentes no imóvel.',
            ),
            array(
                'question' => 'Devo descriminar os objetos especiais?',
                'answer'   => 'Sim, objetos de valor especial tais como joias, obras de arte, coleções ou relógios de elevado valor devem ser discriminados na apólice com a respetiva avaliação para garantia de cobertura total.',
            ),
            array(
                'question' => 'Qual deve ser o capital seguro relativo ao imóvel?',
                'answer'   => 'O capital seguro para o edifício deve corresponder ao custo de reconstrução do imóvel (excluindo o valor do terreno), tendo em conta a área bruta de construção e a respetiva localização geográfica.',
            ),
        );
    }
}

// Generate unique ID prefix for accessibility
$uid = 'faq-' . wp_unique_id();
?>

<section class="section section-faq" id="faqs" aria-label="<?php echo esc_attr( $title ); ?>">
    <!-- Ambient Floating Red Rings (Matching Figma Specification) -->
    <div class="faq-ring faq-ring--bleed-left" aria-hidden="true"></div>
    <div class="faq-ring faq-ring--left-mid" aria-hidden="true"></div>
    <div class="faq-ring faq-ring--right-top" aria-hidden="true"></div>
    <div class="faq-ring faq-ring--right-large" aria-hidden="true"></div>
    <div class="faq-ring faq-ring--right-bottom" aria-hidden="true"></div>

    <div class="site-container faq-container">
        <!-- Section Header -->
        <div class="faq-header text-center">
            <?php if ( $eyebrow ) : ?>
                <span class="eyebrow faq-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
            <?php endif; ?>

            <?php if ( $title ) : ?>
                <h2 class="h2 faq-title"><?php echo esc_html( $title ); ?></h2>
            <?php endif; ?>

            <?php if ( $description ) : ?>
                <p class="faq-desc"><?php echo nl2br( esc_html( $description ) ); ?></p>
            <?php endif; ?>
        </div>

        <!-- FAQs Accordion List -->
        <?php if ( ! empty( $faqs ) ) : ?>
            <div class="faq-accordion" data-accordion>
                <?php foreach ( $faqs as $index => $faq ) : 
                    $q = ! empty( $faq['question'] ) ? $faq['question'] : '';
                    $a = ! empty( $faq['answer'] )   ? $faq['answer']   : '';
                    if ( empty( $q ) ) continue;
                    $item_id = $uid . '-' . $index;
                ?>
                    <div class="faq-item">
                        <button type="button" 
                                class="faq-trigger" 
                                aria-expanded="false" 
                                aria-controls="<?php echo esc_attr( $item_id ); ?>" 
                                id="btn-<?php echo esc_attr( $item_id ); ?>">
                            <span class="faq-question"><?php echo esc_html( $q ); ?></span>
                            <span class="faq-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M6 9l6 6 6-6"/>
                                </svg>
                            </span>
                        </button>
                        <div class="faq-collapse" 
                             id="<?php echo esc_attr( $item_id ); ?>" 
                             role="region" 
                             aria-labelledby="btn-<?php echo esc_attr( $item_id ); ?>" 
                             hidden>
                            <div class="faq-content">
                                <p><?php echo nl2br( esc_html( $a ) ); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
