<?php
/**
 * Standalone Script: Seed Seguros Empresas into WordPress
 * Theme: Pacto 25
 * 
 * Usage:
 * 1. Via WP-CLI:
 *    wp eval-file wp-content/themes/pacto-25/scripts/seed-empresas.php
 * 
 * 2. Via Admin Browser:
 *    https://your-domain.com/wp-admin/?pacto_seed_empresas=1
 * 
 * 3. Via direct PHP CLI:
 *    php seed-empresas.php
 */

// If running standalone outside WP context, locate wp-load.php
if ( ! defined( 'ABSPATH' ) ) {
    $wp_load_paths = array(
        __DIR__ . '/../../../../wp-load.php',
        __DIR__ . '/../../../wp-load.php',
        __DIR__ . '/../../wp-load.php',
        dirname( dirname( dirname( dirname( __DIR__ ) ) ) ) . '/wp-load.php',
    );

    foreach ( $wp_load_paths as $path ) {
        if ( file_exists( $path ) ) {
            require_once $path;
            break;
        }
    }
}

if ( ! defined( 'ABSPATH' ) ) {
    die( "Error: Could not locate wp-load.php. Please run via WP-CLI or inside WordPress admin.\n" );
}

echo "=== Pacto 25: Seeding Seguros Empresas ===\n\n";

$sample_empresas = array(
    array(
        'title'       => 'Seguro Multirriscos Empresa',
        'slug'        => 'multirriscos-empresa',
        'order'       => 1,
        'image_file'  => 'multirriscos-empresa.png',
        'excerpt'     => 'Blindagem patrimonial integral para edifícios, equipamentos industriais, stock e lucros cessantes da sua empresa.',
        'content'     => '<p>O património da sua empresa representa anos de investimento e trabalho árduo. O Seguro Multirriscos Empresa da Pacto Seguro protege as instalações, máquinas industriais, equipamentos tecnológicos, mobiliário e matérias-primas contra incêndios, inundações, tempestades, atos de vandalismo e roubo.</p><p>Inclui ainda a cobertura essencial de <strong>Perda de Exploração (Lucros Cessantes)</strong>, garantindo que as despesas fixas e a margem de lucro continuam asseguradas caso a atividade seja temporariamente interrompida por um sinistro.</p>',
        'eyebrow'     => 'SEGURO MULTIRRISCOS EMPRESA',
        'hero_title'  => 'Proteja o Património e a Continuidade do seu Negócio',
        'hero_desc'   => 'Cobertura integral para edifícios, equipamentos industriais e mercadorias com garantia de lucros cessantes e assistência técnica urgente 24/7.',
        'about_title' => 'O que é o Seguro Multirriscos Empresa?',
        'about_desc'  => 'Uma solução modular de alta performance desenhada para blindar os ativos físicos e financeiros de qualquer negócio — desde pequenas lojas e escritórios até complexos industriais e centros logísticos.',
    ),
    array(
        'title'       => 'Seguro Acidentes de Trabalho',
        'slug'        => 'acidentes-trabalho',
        'order'       => 2,
        'image_file'  => 'acidentes-trabalho.png',
        'excerpt'     => 'Obrigatoriedade legal cumprida com rigor: a melhor rede hospitalar privada, reabilitação física e indemnizações por incapacidade.',
        'content'     => '<p>A sua equipa é o ativo mais valioso da organização. O Seguro de Acidentes de Trabalho da Pacto Seguro assegura o cumprimento integral da legislação portuguesa (Lei n.º 98/2009), disponibilizando aos seus colaboradores a melhor assistência médica, cirúrgica e farmacêutica na rede hospitalar privada.</p><p>Garante indemnizações diárias por incapacidade temporária, pensões vitalícias por incapacidade permanente e acompanhamento clínico personalizado para uma recuperação célere e humanizada.</p>',
        'eyebrow'     => 'SEGURO ACIDENTES DE TRABALHO',
        'hero_title'  => 'Cuide do seu Maior Ativo: a sua Equipa de Colaboradores',
        'hero_desc'   => 'Cumprimento escrupuloso da obrigação legal com a melhor assistência médica hospitalar privada, reabilitação física e gestão célere de sinistros.',
        'about_title' => 'O que é o Seguro de Acidentes de Trabalho?',
        'about_desc'  => 'Obrigatoriedade legal em Portugal para todos os colaboradores por conta de outrem e independentes. Cobre ocorrências no local de trabalho e no trajeto de ida e volta (in itinere), garantindo tranquilidade jurídica e humana.',
    ),
    array(
        'title'       => 'Seguro Responsabilidade Civil',
        'slug'        => 'responsabilidade-civil',
        'order'       => 3,
        'image_file'  => 'responsabilidade-civil.png',
        'excerpt'     => 'Proteção jurídica e financeira contra indemnizações decorrentes de danos corporais ou materiais causados a terceiros.',
        'content'     => '<p>Qualquer atividade económica está exposta a imprevistos operacionais que podem gerar prejuízos a terceiros, clientes ou fornecedores. O Seguro de Responsabilidade Civil da Pacto Seguro assume as indemnizações legalmente exigidas por danos involuntários causados no exercício da atividade.</p><p>Disponibilizamos modalidades para Responsabilidade Civil Exploração, Produtos, Profissional (para prestadores de serviços e profissões liberais) e Ambiental, salvaguardando a estabilidade financeira e a reputação da sua marca.</p>',
        'eyebrow'     => 'RESPONSABILIDADE CIVIL EMPRESARIAL',
        'hero_title'  => 'Salvaguarde a Reputação e a Solidez da sua Empresa',
        'hero_desc'   => 'Proteção jurídica e financeira para cobrir prejuízos materiais, corporais ou patrimoniais involuntariamente causados a clientes, fornecedores ou ao público.',
        'about_title' => 'O que é a Responsabilidade Civil Empresarial?',
        'about_desc'  => 'Uma proteção jurídica indispensável que assume as despesas com indemnizações, custas judiciais e honorários de advogados decorrentes de reclamações de terceiros por falhas operacionais.',
    ),
    array(
        'title'       => 'Seguro Frota Automóvel',
        'slug'        => 'frota-automovel',
        'order'       => 4,
        'image_file'  => 'frota-automovel.png',
        'excerpt'     => 'Gestão integrada e inteligente para viaturas comerciais ligeiras e pesadas com assistência 24/7 e viatura de substituição.',
        'content'     => '<p>Mantenha a sua operação logística e comercial sempre em movimento. O Seguro Frota Automóvel da Pacto Seguro unifica a gestão de todas as viaturas da empresa numa única apólice inteligente, com condições comerciais altamente competitivas.</p><p>Beneficie de assistência em viagem prioritária desde o km zero, viatura de substituição de categoria comercial compatível e gestão desmaterializada de sinistros para reduzir ao mínimo o tempo de imobilização dos veículos.</p>',
        'eyebrow'     => 'SEGURO FROTA AUTOMÓVEL',
        'hero_title'  => 'Mantenha a Mobilidade do seu Negócio em Pleno Rendimento',
        'hero_desc'   => 'Gestão simplificada e unificada para veículos ligeiros, comerciais, pesados de mercadorias ou frotas de passageiros com assistência 24/7.',
        'about_title' => 'O que é o Seguro Frota Automóvel?',
        'about_desc'  => 'Uma apólice global com condições comerciais exclusivas para empresas com 2 ou mais viaturas. Inclui viatura de substituição comercial imediata, assistência de alta prioridade e acompanhamento de peritagens.',
    ),
    array(
        'title'       => 'Seguro de Saúde Grupo',
        'slug'        => 'saude-grupo',
        'order'       => 5,
        'image_file'  => 'saude-grupo.png',
        'excerpt'     => 'O benefício corporativo mais valorizado: cuidados médicos premium, consultas, exames e cirurgias com vantagens fiscais diretas.',
        'content'     => '<p>A saúde e o bem-estar dos colaboradores refletem-se diretamente na produtividade, no clima organizacional e na atração dos melhores talentos. O Seguro de Saúde Grupo da Pacto Seguro oferece planos flexíveis adaptados à dimensão da sua empresa.</p><p>Acesso à mais conceituada rede privada de saúde para consultas de clínica geral e especialidades, exames de diagnóstico, tratamentos estomatológicos, partos e hospitalização, com prémios dedutíveis em sede de IRC.</p>',
        'eyebrow'     => 'SEGURO SAÚDE GRUPO CORPORATIVO',
        'hero_title'  => 'Valorize os seus Talentos com Benefícios de Saúde Premium',
        'hero_desc'   => 'Acesso aos melhores hospitais e clínicas privadas em todo o país, reforçando a retenção de talentos e a produtividade da sua organização.',
        'about_title' => 'O que é o Seguro de Saúde para Empresas?',
        'about_desc'  => 'Um plano corporativo que oferece aos trabalhadores e respetivas famílias acesso imediato a cuidados de saúde privados de excelência, sem burocracias e com fortes deduções fiscais para a empresa.',
    ),
    array(
        'title'       => 'Seguro D&O (Administradores)',
        'slug'        => 'do-administradores',
        'order'       => 6,
        'image_file'  => 'do-administradores.png',
        'excerpt'     => 'Blindagem do património pessoal dos administradores e gerentes contra processos e reclamações de atos de gestão.',
        'content'     => '<p>No atual ambiente regulatório e de negócios, as decisões de liderança acarretam riscos jurídicos consideráveis. O Seguro D&O (Directors and Officers Liability) protege o património pessoal e familiar dos administradores, membros da gerência e diretores contra reclamações de acionistas, reguladores, clientes ou concorrentes.</p><p>Garante o pagamento de custas judiciais, honorários de advogados de topo, custos de investigação e eventuais indemnizações fixadas por tribunal.</p>',
        'eyebrow'     => 'SEGURO D&O — DIRECTORS & OFFICERS',
        'hero_title'  => 'Proteção Pessoal e Patrimonial para Líderes e Gestores',
        'hero_desc'   => 'Blindagem contra reclamações de acionistas, reguladores, credores ou concorrentes por alegados erros de gestão ou incumprimento de deveres fiduciários.',
        'about_title' => 'O que é o Seguro D&O (Directors & Officers)?',
        'about_desc'  => 'Na gestão executiva, administradores e gerentes respondem com o seu património pessoal por atos de gestão. O D&O suporta a defesa jurídica e protege os líderes para que possam inovar com segurança.',
    ),
    array(
        'title'       => 'Seguro Cyber Riscos',
        'slug'        => 'cyber-riscos',
        'order'       => 7,
        'image_file'  => 'cyber-riscos.png',
        'excerpt'     => 'Resposta pericial 24/7 a ataques informáticos, resgates ransomware, violação de dados (RGPD) e paragens digitais.',
        'content'     => '<p>Com a digitalização dos processos de negócio, os ciberataques são uma das ameaças mais graves à sobrevivência das empresas. O Seguro Cyber Riscos da Pacto Seguro atua como um escudo protetor contra intrusões, sequestro de dados (ransomware), fugas de informação confidencial e quebras do RGPD.</p><p>Mobilização imediata de equipas de peritagem informática forense 24/7, apoio jurídico especializado, notificação de clientes afetados e compensação das perdas financeiras resultantes da paragem dos sistemas informáticos.</p>',
        'eyebrow'     => 'SEGURO CYBER RISCOS & PROTEÇÃO DIGITAL',
        'hero_title'  => 'Proteja os Dados e a Infraestrutura Digital da sua Organização',
        'hero_desc'   => 'Resposta técnica e jurídica imediata a incidentes de segurança cibernética, ransomware, violação de dados sensíveis e lucros cessantes.',
        'about_title' => 'O que é o Seguro Cyber Riscos?',
        'about_desc'  => 'Uma salvaguarda abrangente contra crimes cibernéticos que financia a recuperação de ficheiros, assessoria de comunicação de crise, custos de peritagem forense e multas regulatórias aplicáveis.',
    ),
    array(
        'title'       => 'Seguro Mercadorias e Transporte',
        'slug'        => 'mercadorias-transporte',
        'order'       => 8,
        'image_file'  => 'mercadorias-transporte.png',
        'excerpt'     => 'Garantia total para cargas e produtos em trânsito rodoviário, marítimo ou aéreo, a nível nacional e internacional.',
        'content'     => '<p>Assegure que as suas encomendas e matérias-primas chegam ao destino intactas e no prazo previsto. O Seguro de Transporte de Mercadorias da Pacto Seguro cobre perdas e danos sofridos pela carga durante o transporte por via terrestre, marítima, aérea ou ferroviária em qualquer rota mundial.</p><p>Cobertura integral desde o momento da expedição até à entrega final no armazém do cliente, incluindo operações de carga, descarga e transbordo.</p>',
        'eyebrow'     => 'SEGURO MERCADORIAS & TRANSPORTE',
        'hero_title'  => 'Segurança Inabalável para as suas Cargas em Trânsito Global',
        'hero_desc'   => 'Cobertura completa para mercadorias em transporte rodoviário, marítimo ou aéreo contra acidentes, avarias e roubo em qualquer parte do mundo.',
        'about_title' => 'O que é o Seguro de Mercadorias e Transporte?',
        'about_desc'  => 'Concebido para produtores, importadores, exportadores e transportadores. Garante indemnizações rápidas por avarias particulares, avaria grossa no mar, extravios ou furto de produtos.',
    ),
);

require_once( ABSPATH . 'wp-admin/includes/image.php' );
require_once( ABSPATH . 'wp-admin/includes/file.php' );
require_once( ABSPATH . 'wp-admin/includes/media.php' );

$count_created = 0;
$count_existing = 0;

foreach ( $sample_empresas as $item ) {
    $existing = get_page_by_title( $item['title'], OBJECT, 'seguro_empresa' );
    if ( $existing ) {
        echo " - [EXISTS] {$item['title']} (ID: {$existing->ID})\n";
        $count_existing++;
        $inserted_id = $existing->ID;
    } else {
        $inserted_id = wp_insert_post( array(
            'post_title'   => $item['title'],
            'post_name'    => $item['slug'],
            'post_content' => $item['content'],
            'post_excerpt' => $item['excerpt'],
            'post_status'  => 'publish',
            'post_type'    => 'seguro_empresa',
            'menu_order'   => $item['order'],
        ) );

        if ( is_wp_error( $inserted_id ) ) {
            echo " - [ERROR] Failed to insert {$item['title']}: " . $inserted_id->get_error_message() . "\n";
            continue;
        }

        echo " + [CREATED] {$item['title']} (ID: {$inserted_id})\n";
        $count_created++;
    }

    if ( $inserted_id ) {
        update_post_meta( $inserted_id, '_seguro_btn_text', 'saber mais' );
        update_post_meta( $inserted_id, '_seguro_btn_url', get_permalink( $inserted_id ) );

        // Meta fields for single landing page
        update_post_meta( $inserted_id, 'seguro_hero_eyebrow', $item['eyebrow'] );
        update_post_meta( $inserted_id, 'seguro_hero_title', $item['hero_title'] );
        update_post_meta( $inserted_id, 'seguro_hero_desc', $item['hero_desc'] );
        update_post_meta( $inserted_id, 'seguro_about_title', $item['about_title'] );
        update_post_meta( $inserted_id, 'seguro_about_desc', $item['about_desc'] );

        // Attach featured image if exists in theme assets
        $image_rel_path = 'assets/images/empresas/seguros/' . $item['image_file'];
        $image_abs_path = get_template_directory() . '/' . $image_rel_path;

        if ( file_exists( $image_abs_path ) ) {
            $filename   = basename( $image_abs_path );

            global $wpdb;
            $attachment_id = $wpdb->get_var( $wpdb->prepare(
                "SELECT ID FROM $wpdb->posts WHERE post_type = 'attachment' AND guid LIKE %s LIMIT 1",
                '%' . $wpdb->esc_like( $filename ) . '%'
            ) );

            if ( ! $attachment_id ) {
                $file_content = file_get_contents( $image_abs_path );
                $upload_res   = wp_upload_bits( $filename, null, $file_content );

                if ( empty( $upload_res['error'] ) ) {
                    $wp_filetype   = wp_check_filetype( $filename, null );
                    $attachment    = array(
                        'post_mime_type' => $wp_filetype['type'],
                        'post_title'     => sanitize_file_name( $item['title'] ),
                        'post_content'   => '',
                        'post_status'    => 'inherit'
                    );
                    $attachment_id = wp_insert_attachment( $attachment, $upload_res['file'], $inserted_id );
                    $attach_data   = wp_generate_attachment_metadata( $attachment_id, $upload_res['file'] );
                    wp_update_attachment_metadata( $attachment_id, $attach_data );
                }
            }

            if ( $attachment_id ) {
                set_post_thumbnail( $inserted_id, $attachment_id );
                update_post_meta( $inserted_id, 'seguro_hero_image', $attachment_id );
                echo "   -> Attached image: {$filename} (Attachment ID: {$attachment_id})\n";
            }
        }
    }
}

flush_rewrite_rules( false );

echo "\nSummary: {$count_created} posts created, {$count_existing} already existed.\n";
echo "Permalinks rewrite rules flushed successfully.\n";
echo "Done!\n";
