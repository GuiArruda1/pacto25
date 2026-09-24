<?php
/**
 * Template Part: Section Protocolos Condições Especiais
 * Theme: Pacto 25
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$page_id = get_the_ID();

$eyebrow   = pacto_get_field( 'protocolos_cond_eyebrow', $page_id, 'COBERTURAS COM ATENDIMENTO PERSONALIZADO' );
$title     = pacto_get_field( 'protocolos_cond_title', $page_id, 'Condições Especiais para Membros de Ordens e Associações' );
$text      = pacto_get_field( 'protocolos_cond_text', $page_id, 'A Pacto Seguro disponibiliza uma vasta oferta de Seguros com Protocolo a desenvolver em colaboração com as Ordens e Associações Profissionais, em particular:' );
$list      = pacto_get_field( 'protocolos_cond_list', $page_id );
$btn_text  = pacto_get_field( 'protocolos_cond_btn_text', $page_id, 'Fale com um consultor' );
$btn_url   = pacto_get_field( 'protocolos_cond_btn_url', $page_id, '/contactos/' );

// Default list if ACF is empty
if ( empty( $list ) ) {
    $list = array(
        array( 'item' => 'Ordem dos Médicos, Enfermeiros e Farmacêuticos' ),
        array( 'item' => 'Ordem dos Engenheiros e Engenheiros Técnicos' ),
        array( 'item' => 'Ordem dos Advogados' ),
        array( 'item' => 'Ordem dos Arquitectos' ),
        array( 'item' => 'Ordem dos Solicitadores' ),
        array( 'item' => 'Ordem dos Psicólogos' ),
        array( 'item' => 'Ordem dos Contabilistas Certificados' ),
        array( 'item' => 'Sindicato dos Jogadores Profissionais de Futebol' ),
        array( 'item' => 'Sindicato dos Magistrados do Ministério Público' ),
        array( 'item' => 'Sindicato dos Quadros Técnicos Bancários' ),
        array( 'item' => 'Associação Sindical dos Juízes Portugueses' ),
    );
}

$vantagens_title = pacto_get_field( 'protocolos_vantagens_title', $page_id, 'Vantagens dos Protocolos' );
$vantagens_list  = pacto_get_field( 'protocolos_vantagens_list', $page_id );

// Default vantagens if ACF is empty
if ( empty( $vantagens_list ) ) {
    $vantagens_list = array(
        array( 'item' => 'Condições exclusivas.' ),
        array( 'item' => 'Coberturas diferenciadas.' ),
        array( 'item' => 'Preços preferenciais.' ),
        array( 'item' => 'Acompanhamento especializado.' ),
        array( 'item' => 'Soluções adaptadas à profissão.' ),
    );
}
?>

<section class="section section-protocolos-condicoes" aria-label="<?php echo esc_attr( $title ); ?>">
    <div class="site-container">
        <div class="protocolos-condicoes-grid">
            
            <div class="protocolos-condicoes-content">
                <?php if ( $eyebrow ) : ?>
                    <span class="protocolos-condicoes-eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
                <?php endif; ?>
                
                <h2 class="h2 protocolos-condicoes-title"><?php echo esc_html( $title ); ?></h2>
                
                <?php if ( $text ) : ?>
                    <div class="protocolos-condicoes-text">
                        <p><?php echo wp_kses_post( $text ); ?></p>
                    </div>
                <?php endif; ?>
                
                <?php if ( ! empty( $list ) ) : ?>
                    <ul class="protocolos-condicoes-list">
                        <?php foreach ( $list as $row ) : ?>
                            <li><?php echo esc_html( $row['item'] ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
                
                <?php if ( $btn_text && $btn_url ) : ?>
                    <a href="<?php echo esc_url( $btn_url ); ?>" class="protocolos-condicoes-btn"><?php echo esc_html( $btn_text ); ?></a>
                <?php endif; ?>
            </div>
            
            <div class="protocolos-condicoes-visual">
                <div class="protocolos-cond-bubble-1" aria-hidden="true"></div>
                <div class="protocolos-cond-bubble-2" aria-hidden="true"></div>
                <div class="protocolos-cond-bubble-3" aria-hidden="true"></div>
                <div class="protocolos-cond-bubble-4" aria-hidden="true"></div>
                
                <!-- Giant Red Circle with Vantagens -->
                <div class="protocolos-condicoes-red-circle">
                    <div class="protocolos-condicoes-vantagens">
                        <div class="vantagens-icon">
                            <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="24" cy="24" r="23" stroke="white" stroke-width="2"/>
                                <path d="M33 17L21 29L15 23" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h3 class="vantagens-title"><?php echo esc_html( $vantagens_title ); ?></h3>
                        
                        <?php if ( ! empty( $vantagens_list ) ) : ?>
                            <ul class="vantagens-list">
                                <?php foreach ( $vantagens_list as $row ) : ?>
                                    <li><?php echo esc_html( $row['item'] ); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>
