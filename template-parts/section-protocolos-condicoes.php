<?php
/**
 * Template Part: Section Protocolos Condições Especiais
 * Theme: Pacto 25
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$page_id = get_the_ID();

$eyebrow   = pacto_get_field( 'protocolos_cond_eyebrow', $page_id, 'PROTOCOLOS COM ORDENS PROFISSIONAIS E ASSOCIAÇÕES' );
$title     = pacto_get_field( 'protocolos_cond_title', $page_id, 'Condições Especiais para Membros de Ordens e Associações' );
$text      = pacto_get_field( 'protocolos_cond_text', $page_id, 'A Pacto Seguro disponibiliza uma vasta oferta de Seguros com Protocolo a desenvolver em colaboração com as Ordens e Associações Profissionais, em particular:' );
$list      = pacto_get_field( 'protocolos_cond_list', $page_id );
$btn_text  = pacto_get_field( 'protocolos_cond_btn_text', $page_id, 'falar com um especialista' );
$btn_url   = pacto_get_field( 'protocolos_cond_btn_url', $page_id, '/contactos/' );

// Default list if ACF is empty
if ( empty( $list ) ) {
    $list = array(
        array( 'item' => 'Ordens dos Médicos, Médicos Dentistas e Enfermeiros;' ),
        array( 'item' => 'Ordens dos Engenheiros e Engenheiros Técnicos;' ),
        array( 'item' => 'Ordem dos Biólogos;' ),
        array( 'item' => 'Ordem dos Arquitetos;' ),
        array( 'item' => 'Ordem dos Economistas;' ),
        array( 'item' => 'Ordem dos Farmaceuticos;' ),
        array( 'item' => 'Ordem dos Psicologos;' ),
        array( 'item' => 'Ordem dos Ordem dos Solicitadores e Agentes de Execução;' ),
        array( 'item' => 'Sindicato Nacional dos Médicos Veterinários;' ),
        array( 'item' => 'Associação Sindical dos Juízes Portugueses.' ),
    );
}

$vantagens_title = pacto_get_field( 'protocolos_vantagens_title', $page_id, 'Vantagens dos Protocolos' );
$vantagens_list  = pacto_get_field( 'protocolos_vantagens_list', $page_id );

// Default vantagens if ACF is empty
if ( empty( $vantagens_list ) ) {
    $vantagens_list = array(
        array( 'item' => 'Condições exclusivas;' ),
        array( 'item' => 'Coberturas diferenciadas;' ),
        array( 'item' => 'Preços preferenciais;' ),
        array( 'item' => 'Acompanhamento especializado;' ),
        array( 'item' => 'Soluções adaptadas à profissão.' ),
    );
}
?>

<section class="section section-protocolos-condicoes" aria-label="<?php echo esc_attr( $title ); ?>">
    <div class="site-container">
        <div class="protocolos-condicoes-grid">
            
            <div class="protocolos-condicoes-content">
                <?php if ( $eyebrow ) : ?>
                    <span class="protocolos-condicoes-eyebrow"><span class="eyebrow-bullet">•</span> <?php echo esc_html( $eyebrow ); ?></span>
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
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/icon-protocolo.svg" alt="Protocolos" width="80" height="80" />
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
