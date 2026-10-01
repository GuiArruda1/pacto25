<?php
/**
 * Standalone Script: Seed Seguros Particulares into WordPress
 * Theme: Pacto 25
 * 
 * Usage:
 * 1. Via WP-CLI:
 *    wp eval-file wp-content/themes/pacto-25/scripts/seed-particulares.php
 * 
 * 2. Via Admin Browser:
 *    https://your-domain.com/wp-admin/?pacto_seed_particulares=1
 * 
 * 3. Via direct PHP CLI:
 *    php seed-particulares.php
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

echo "=== Pacto 25: Seeding Seguros Particulares ===\n\n";

$sample_particulares = array(
    array(
        'title'       => 'Seguro Multirriscos Casa',
        'slug'        => 'multirriscos-casa',
        'order'       => 1,
        'image_file'  => 'multirriscos-casa.png',
        'excerpt'     => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
        'content'     => '<p>O seu lar é o seu refúgio mais precioso. O Seguro Multirriscos Habitação da Pacto Seguro protege as paredes do seu imóvel e todo o recheio contra incêndios, inundações, tempestades, danos por água, roubo e responsabilidade civil.</p><p>Conte com assistência ao domicílio 24 horas por dia para reparações urgentes de canalização, eletricidade e fechaduras, garantindo a tranquilidade total da sua família.</p>',
        'eyebrow'     => 'SEGURO MULTIRRISCOS CASA',
        'hero_title'  => 'Encontre o melhor Seguro Multirriscos para o seu Lar',
        'hero_desc'   => 'Proteção completa para o seu imóvel e recheio, com coberturas abrangentes e assistência 24/7.',
        'about_title' => 'O que é o Seguro Multirriscos Casa?',
        'about_desc'  => 'Uma solução abrangente pensada para proteger a sua habitação própria ou arrendada contra imprevistos climáticos, acidentes domésticos e responsabilidade civil perante terceiros.',
    ),
    array(
        'title'       => 'Seguro Automóvel',
        'slug'        => 'automovel',
        'order'       => 2,
        'image_file'  => 'automovel.png',
        'excerpt'     => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
        'content'     => '<p>Conduza com a máxima segurança e liberdade. O Seguro Automóvel da Pacto Seguro vai muito além da responsabilidade civil obrigatória, oferecendo coberturas contra danos próprios, quebra isolada de vidros, choque, colisão e capotamento, furto ou roubo e fenómenos da natureza.</p><p>Beneficie de assistência em viagem premium desde o quilómetro zero e viatura de substituição equivalente em caso de sinistro ou avaria.</p>',
        'eyebrow'     => 'SEGURO AUTOMÓVEL',
        'hero_title'  => 'Encontre o melhor Seguro Automóvel para a sua Viagem',
        'hero_desc'   => 'Conduza tranquilo com assistência em viagem a partir do km 0, viatura de substituição e proteção total contra todos os riscos.',
        'about_title' => 'O que é o Seguro Automóvel?',
        'about_desc'  => 'Uma proteção indispensável para o seu veículo pessoal ou familiar, com opções modulares desde a responsabilidade civil essencial até danos próprios completos.',
    ),
    array(
        'title'       => 'Seguro para Animais de Estimação',
        'slug'        => 'animais-estimacao',
        'order'       => 3,
        'image_file'  => 'animais-estimacao.png',
        'excerpt'     => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
        'content'     => '<p>Os animais de estimação são parte integrante da nossa família. Garanta o melhor acompanhamento veterinário para o seu cão ou gato com o Seguro de Saúde Animal da Pacto Seguro.</p><p>Cobertura de consultas, cirurgias, internamento, exames de diagnóstico, vacinação, além de responsabilidade civil e assistência em caso de desaparecimento.</p>',
        'eyebrow'     => 'SEGURO ANIMAIS DE ESTIMAÇÃO',
        'hero_title'  => 'Cuide de quem cuida de si com o melhor Seguro Animal',
        'hero_desc'   => 'Acesso aos melhores hospitais veterinários com cobertura de consultas, cirurgias, medicamentos e responsabilidade civil.',
        'about_title' => 'O que é o Seguro para Animais de Estimação?',
        'about_desc'  => 'Um plano de saúde e proteção dedicado a cães e gatos de todas as raças, garantindo reembolsos rápidos de despesas veterinárias.',
    ),
    array(
        'title'       => 'Seguro Poupança Reforma',
        'slug'        => 'poupanca-reforma',
        'order'       => 4,
        'image_file'  => 'poupanca-reforma.png',
        'excerpt'     => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
        'content'     => '<p>Prepare hoje o amanhã com toda a estabilidade financeira e conforto. Os Planos Poupança Reforma (PPR) da Pacto Seguro combinam rentabilidade competitiva com benefícios fiscais atrativos quer à entrada quer à saída.</p><p>Flexibilidade total de entregas pontuais ou periódicas, adaptando-se ao seu perfil e objetivos de longo prazo.</p>',
        'eyebrow'     => 'SEGURO POUPANÇA REFORMA',
        'hero_title'  => 'Garanta o seu Futuro com o Seguro Poupança Reforma',
        'hero_desc'   => 'Planos flexíveis de poupança e investimento com benefícios fiscais e capital garantido para uma reforma dourada.',
        'about_title' => 'O que é o Seguro Poupança Reforma?',
        'about_desc'  => 'Uma ferramenta financeira estratégica para acumular capital ao longo do tempo, beneficiando de deduções no IRS e rentabilidades sólidas.',
    ),
    array(
        'title'       => 'Seguro de Saúde',
        'slug'        => 'saude',
        'order'       => 5,
        'image_file'  => 'saude.png',
        'excerpt'     => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
        'content'     => '<p>A sua saúde e a da sua família merecem cuidados médicos de excelência sem longas listas de espera. Tenha acesso à maior rede privada de clínicas, hospitais e médicos especialistas em todo o país.</p><p>Planos flexíveis com coberturas de hospitalização, ambulatório, estomatologia, parto, ótica e assistência médica domiciliária 24/7.</p>',
        'eyebrow'     => 'SEGURO DE SAÚDE',
        'hero_title'  => 'O Melhor Seguro de Saúde para Si e para a sua Família',
        'hero_desc'   => 'Consultas, exames e cirurgias na rede privada com comparticipações elevadas e atendimento rápido sem burocracias.',
        'about_title' => 'O que é o Seguro de Saúde?',
        'about_desc'  => 'A proteção ideal para aceder aos melhores cuidados médicos privados, com descontos imediatos e reembolsos simples de despesas de saúde.',
    ),
    array(
        'title'       => 'Seguro de Viagem',
        'slug'        => 'viagem',
        'order'       => 6,
        'image_file'  => 'viagem.png',
        'excerpt'     => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
        'content'     => '<p>Viaje pelo mundo com total serenidade e apoio contínuo. O Seguro de Viagem da Pacto Seguro assegura assistência médica no estrangeiro, despesas de hospitalização, repatriamento, cancelamento antecipado de viagem e extravio de bagagem.</p><p>Válido para viagens de lazer ou trabalho, individuais ou em família, em qualquer continente.</p>',
        'eyebrow'     => 'SEGURO DE VIAGEM',
        'hero_title'  => 'Explore o Mundo com a Segurança do Seguro de Viagem',
        'hero_desc'   => 'Despesas médicas no estrangeiro, cancelamento de voos, perda de bagagem e apoio em viagem 24 horas por dia.',
        'about_title' => 'O que é o Seguro de Viagem?',
        'about_desc'  => 'A salvaguarda indispensável para qualquer destino internacional, garantindo que imprevistos de saúde ou logística não arruínem as suas férias.',
    ),
    array(
        'title'       => 'Seguro Acidentes Pessoais',
        'slug'        => 'acidentes-pessoais',
        'order'       => 7,
        'image_file'  => 'acidentes-pessoais.png',
        'excerpt'     => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
        'content'     => '<p>Os imprevistos do quotidiano podem acontecer a qualquer momento. O Seguro de Acidentes Pessoais garante apoio financeiro e médico imediato em caso de acidente na vida privada ou profissional.</p><p>Indemnizações por incapacidade temporária ou permanente, cobertura de despesas de tratamento e subsídio diário de internamento hospitalar.</p>',
        'eyebrow'     => 'SEGURO ACIDENTES PESSOAIS',
        'hero_title'  => 'Proteção Diária com o Seguro de Acidentes Pessoais',
        'hero_desc'   => 'Salvaguarda financeira e cuidados médicos imediatos para imprevistos domésticos, profissionais ou de lazer.',
        'about_title' => 'O que é o Seguro de Acidentes Pessoais?',
        'about_desc'  => 'Uma cobertura essencial que compensa a perda de rendimentos e cobre tratamentos médicos decorrentes de acidentes súbitos.',
    ),
    array(
        'title'       => 'Seguro para Desporto',
        'slug'        => 'desporto',
        'order'       => 8,
        'image_file'  => 'desporto.png',
        'excerpt'     => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
        'content'     => '<p>Viva a sua paixão pelo desporto com a máxima confiança. Quer pratique corrida, ciclismo, futebol, padel, surf ou desportos de montanha, o Seguro Desportivo cobre lesões, tratamentos de fisioterapia, cirurgias e responsabilidade civil.</p><p>Planos ajustados para atletas amadores ou federados, individuais ou para equipas e clubes.</p>',
        'eyebrow'     => 'SEGURO PARA DESPORTO',
        'hero_title'  => 'Pratique Desporto em Segurança com o Seguro Desportivo',
        'hero_desc'   => 'Cobertura de lesões desportivas, fisioterapia, internamento e responsabilidade civil para atletas de todas as modalidades.',
        'about_title' => 'O que é o Seguro para Desporto?',
        'about_desc'  => 'Uma proteção específica para entusiastas e praticantes de atividade física, garantindo recuperação rápida e apoio clínico especializado.',
    ),
);

require_once( ABSPATH . 'wp-admin/includes/image.php' );
require_once( ABSPATH . 'wp-admin/includes/file.php' );
require_once( ABSPATH . 'wp-admin/includes/media.php' );

$count_created = 0;
$count_existing = 0;

foreach ( $sample_particulares as $item ) {
    $existing = get_page_by_title( $item['title'], OBJECT, 'seguro_particular' );
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
            'post_type'    => 'seguro_particular',
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
        $image_rel_path = 'assets/images/particulares/seguros/' . $item['image_file'];
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
