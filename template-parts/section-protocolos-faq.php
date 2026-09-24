<?php
/**
 * Template Part: Section Protocolos Descubra (FAQ/Accordion)
 * Theme: Pacto 25
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$page_id = get_the_ID();

$eyebrow = pacto_get_field( 'protocolos_faq_eyebrow', $page_id, 'CONDIÇÕES ESPECIAIS' );
$title   = pacto_get_field( 'protocolos_faq_title', $page_id, 'Descubra as Condições Disponíveis para a Sua Profissão' );
$text    = pacto_get_field( 'protocolos_faq_text', $page_id, 'As parcerias estabelecidas oferecem um leque alargado de condições exclusivas. Selecione a sua ordem ou associação para conhecer os detalhes.' );
$faqs    = pacto_get_field( 'protocolos_faq_list', $page_id );

$image_obj = pacto_get_field( 'protocolos_faq_image', $page_id );
$image_url = ! empty( $image_obj['url'] ) ? $image_obj['url'] : get_template_directory_uri() . '/assets/images/protocolos-doctor.png';
$image_alt = ! empty( $image_obj['alt'] ) ? $image_obj['alt'] : esc_attr( $title );

// Default FAQs if ACF is empty
if ( empty( $faqs ) ) {
    $faqs = array(
        array(
            'question' => 'Saúde',
            'answer'   => 'Acesso a uma rede médica de excelência com condições e preços protocolados para si e para o seu agregado familiar. Sem limite de idade e sem agravamento por sinistralidade.'
        ),
        array(
            'question' => 'Vida e Acidentes Pessoais',
            'answer'   => 'Proteção financeira em caso de imprevisto, garantindo estabilidade para si e para a sua família, com capitais adequados às suas necessidades profissionais.'
        ),
        array(
            'question' => 'Auto e Habitação',
            'answer'   => 'Beneficie de descontos exclusivos na contratação de seguros para as suas viaturas e proteção multirriscos para o seu património imobiliário.'
        ),
        array(
            'question' => 'Responsabilidade Civil Profissional',
            'answer'   => 'Coberturas desenhadas para os riscos específicos da sua atividade, assegurando a proteção do seu património perante eventuais reclamações de terceiros.'
        ),
        array(
            'question' => 'Multirriscos Empresa e Acidentes de Trabalho',
            'answer'   => 'Soluções completas para a sua clínica, escritório ou empresa, incluindo a proteção obrigatória dos seus colaboradores.'
        ),
    );
}
?>

<section class="section section-protocolos-faq" aria-label="<?php echo esc_attr( $title ); ?>">
    <div class="site-container">
        <div class="protocolos-faq-grid">
            
            <div class="protocolos-faq-visual">
                <!-- Circular Photo with Red Border -->
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
                
                <?php if ( ! empty( $faqs ) ) : ?>
                    <div class="protocolos-accordion" data-accordion>
                        <?php foreach ( $faqs as $index => $faq ) : $faq_id = 'faq-' . wp_generate_password( 4, false ) . '-' . $index; ?>
                            <div class="protocolos-accordion-item">
                                <button type="button" 
                                        class="protocolos-accordion-btn" 
                                        aria-expanded="false" 
                                        aria-controls="<?php echo esc_attr( $faq_id ); ?>"
                                        id="<?php echo esc_attr( $faq_id ); ?>-btn">
                                    <span class="protocolos-accordion-title"><?php echo esc_html( $faq['question'] ); ?></span>
                                    <span class="protocolos-accordion-icon" aria-hidden="true"></span>
                                </button>
                                <div id="<?php echo esc_attr( $faq_id ); ?>" 
                                     class="protocolos-accordion-content" 
                                     role="region" 
                                     aria-labelledby="<?php echo esc_attr( $faq_id ); ?>-btn"
                                     hidden>
                                    <div class="protocolos-accordion-content-inner">
                                        <div class="protocolos-accordion-body">
                                            <p><?php echo wp_kses_post( $faq['answer'] ); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <div class="protocolos-faq-extra-info">
                    <svg class="protocolos-faq-extra-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <path d="M12 16v-4"></path>
                        <path d="M12 8h.01"></path>
                    </svg>
                    <span>As condições podem variar conforme a apólice escolhida e a respetiva entidade.</span>
                </div>
            </div>
            
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const accordions = document.querySelectorAll('.protocolos-accordion');
    
    accordions.forEach(accordion => {
        const buttons = accordion.querySelectorAll('.protocolos-accordion-btn');
        
        buttons.forEach(button => {
            button.addEventListener('click', () => {
                const isExpanded = button.getAttribute('aria-expanded') === 'true';
                const content = document.getElementById(button.getAttribute('aria-controls'));
                
                // Close all other accordions
                buttons.forEach(otherBtn => {
                    if (otherBtn !== button) {
                        otherBtn.setAttribute('aria-expanded', 'false');
                        const otherContent = document.getElementById(otherBtn.getAttribute('aria-controls'));
                        if (otherContent) {
                            otherContent.hidden = true;
                        }
                    }
                });
                
                // Toggle current
                button.setAttribute('aria-expanded', !isExpanded);
                if (content) {
                    content.hidden = isExpanded;
                }
            });
        });
    });
});
</script>
