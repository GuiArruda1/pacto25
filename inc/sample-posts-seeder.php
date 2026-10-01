<?php
/**
 * Utility: Sample News Posts Seeder
 * Theme: Pacto 25
 * Strict Agency SOP: Creates realistic demo posts for WordPress 'post' type matching Figma design.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Seed sample news posts into WordPress if requested by admin.
 */
function pacto_25_seed_sample_posts() {
    // Only allow administrators
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    // Check for trigger via query param: /wp-admin/?pacto_seed_news=1
    if ( ! isset( $_GET['pacto_seed_news'] ) || '1' !== $_GET['pacto_seed_news'] ) {
        return;
    }

    $sample_posts = array(
        array(
            'title'   => 'Presença de Teresinha Pereira, CEO da Pacto Seguro no MAE Summit',
            'date'    => '2026-06-25 10:00:00',
            'excerpt' => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
            'content' => '<p>A CEO da Pacto Seguro, Teresinha Pereira, marcou presença no MAE Summit, destacando a importância da inovação e da proximidade no setor da mediação de seguros.</p><p>Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Durante o evento, foram debatidos os principais desafios da transformação digital e da personalização das soluções de proteção para famílias e empresas.</p><p>Com 25 anos de experiência no mercado segurador, a Pacto Seguro reafirma o seu compromisso contínuo em estar sempre ao lado dos seus clientes, oferecendo aconselhamento transparente e soluções à medida.</p>',
        ),
        array(
            'title'   => 'Pacto Seguro Celebra 25 Anos de Confiança e Proximidade',
            'date'    => '2026-06-25 09:30:00',
            'excerpt' => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
            'content' => '<p>Celebrar 25 anos é celebrar milhares de histórias de confiança mútua. A Pacto Seguro agradece a todos os clientes, parceiros e colaboradores que tornaram esta caminhada possível.</p><p>Continuamos focados em oferecer o melhor atendimento personalizado e as coberturas mais completas para o seu dia a dia.</p>',
        ),
        array(
            'title'   => 'Novas Soluções de Seguros para Empresas e PMEs',
            'date'    => '2026-06-25 08:45:00',
            'excerpt' => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
            'content' => '<p>Lançamos um conjunto reforçado de soluções de seguros empresariais, desenhadas especificamente para apoiar a continuidade e segurança das empresas portuguesas.</p><p>Consulte a nossa equipa especializada para conhecer todos os detalhes e vantagens.</p>',
        ),
        array(
            'title'   => 'Dicas Essenciais para Escolher o Seguro de Habitação Ideal',
            'date'    => '2026-06-25 08:00:00',
            'excerpt' => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
            'content' => '<p>Proteger o seu lar é proteger o seu património mais valioso. Saiba quais as coberturas essenciais e como avaliar corretamente o valor do imóvel e recheio.</p>',
        ),
        array(
            'title'   => 'Guia Rápido: O que Fazer em Caso de Sinistro Automóvel',
            'date'    => '2026-06-24 16:20:00',
            'excerpt' => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
            'content' => '<p>Em momentos de imprevisto, a calma e a informação certa fazem toda a diferença. Conheça o passo a passo para preencher a declaração amigável e acionar a sua assistência com rapidez.</p>',
        ),
        array(
            'title'   => 'Inovação e Sustentabilidade no Setor Segurador',
            'date'    => '2026-06-24 14:10:00',
            'excerpt' => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
            'content' => '<p>A sustentabilidade é um pilar estratégico para o futuro. Saiba como a Pacto Seguro está a adotar práticas ecológicas e digitais em todos os processos de mediação.</p>',
        ),
    );

    // Create posts
    foreach ( $sample_posts as $post_data ) {
        // Check if post already exists by title
        $existing = get_page_by_title( $post_data['title'], OBJECT, 'post' );
        if ( ! $existing ) {
            $inserted_id = wp_insert_post( array(
                'post_title'   => $post_data['title'],
                'post_content' => $post_data['content'],
                'post_excerpt' => $post_data['excerpt'],
                'post_status'  => 'publish',
                'post_type'    => 'post',
                'post_date'    => $post_data['date'],
            ) );
        }
    }

    // Redirect to posts list with success notice
    wp_safe_redirect( admin_url( 'edit.php?pacto_seeded=1' ) );
    exit;
}
add_action( 'admin_init', 'pacto_25_seed_sample_posts' );

/**
 * Seed sample Seguros Empresas into WordPress if requested by admin.
 * Trigger via /wp-admin/?pacto_seed_empresas=1
 */
function pacto_25_seed_sample_seguros_empresas() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    if ( ! isset( $_GET['pacto_seed_empresas'] ) || '1' !== $_GET['pacto_seed_empresas'] ) {
        return;
    }

    $sample_empresas = array(
        array(
            'title'       => 'Seguro Multirriscos Empresa',
            'excerpt'     => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
            'content'     => '<p>Proteja as instalações, máquinas, equipamentos e mercadorias da sua empresa com uma cobertura abrangente contra incêndios, tempestades, inundações e danos por água.</p><p>Garantia de reposição e assistência rápida para que o seu negócio não pare perante imprevistos operacionais.</p>',
            'order'       => 1,
            'slug'        => 'multirriscos-empresa',
        ),
        array(
            'title'       => 'Seguro Acidentes de Trabalho',
            'excerpt'     => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
            'content'     => '<p>Obrigatório por lei e fundamental para a segurança e valorização da sua equipa de trabalho. Garante cuidados médicos de excelência e indemnizações devidas em caso de acidente.</p><p>Gestão simples e acompanhamento clínico rigoroso dos sinistros com a máxima rapidez.</p>',
            'order'       => 2,
            'slug'        => 'acidentes-trabalho',
        ),
        array(
            'title'       => 'Seguro Responsabilidade Civil',
            'excerpt'     => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
            'content'     => '<p>Salvaguarde o património da sua empresa contra danos materiais ou corporais involuntariamente causados a terceiros ou clientes durante a atividade profissional.</p><p>Soluções adaptadas a cada ramo de negócio, indústria, serviços ou comércio.</p>',
            'order'       => 3,
            'slug'        => 'responsabilidade-civil',
        ),
        array(
            'title'       => 'Seguro Frota Automóvel',
            'excerpt'     => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
            'content'     => '<p>Gestão unificada e inteligente para todos os veículos da sua empresa, desde comerciais ligeiros a veículos pesados de mercadorias.</p><p>Assistência em viagem 24/7, viatura de substituição e condições preferenciais de oficina parceira.</p>',
            'order'       => 4,
            'slug'        => 'frota-automovel',
        ),
        array(
            'title'       => 'Seguro de Saúde Grupo',
            'excerpt'     => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
            'content'     => '<p>Um dos benefícios mais valorizados pelos colaboradores. Acesso facilitado à melhor rede privada de saúde, consultas, exames e hospitalização com custos reduzidos.</p><p>Aumente a retenção e a motivação do talento da sua empresa com planos modulares.</p>',
            'order'       => 5,
            'slug'        => 'saude-grupo',
        ),
        array(
            'title'       => 'Seguro D&O (Administradores)',
            'excerpt'     => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
            'content'     => '<p>Proteção do património pessoal dos administradores, gerentes e diretores perante processos judiciais ou reclamações de terceiros relacionadas com atos de gestão.</p><p>Cobertura de despesas de defesa jurídica, fianças e eventuais indemnizações.</p>',
            'order'       => 6,
            'slug'        => 'do-administradores',
        ),
        array(
            'title'       => 'Seguro Cyber Riscos',
            'excerpt'     => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
            'content'     => '<p>Responda com eficácia a ataques informáticos, fugas de dados confidenciais e sequestro de sistemas (ransomware). Cobertura de perdas de exploração e custos de peritagem forense.</p><p>Apoio 24 horas por dia de especialistas em cibersegurança.</p>',
            'order'       => 7,
            'slug'        => 'cyber-riscos',
        ),
        array(
            'title'       => 'Seguro Mercadorias e Transporte',
            'excerpt'     => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
            'content'     => '<p>Garante a proteção das suas cargas e produtos quer em transporte rodoviário, marítimo ou aéreo, a nível nacional e internacional.</p><p>Cobertura de perdas, roubo ou avarias durante o trajeto e operações de carga e descarga.</p>',
            'order'       => 8,
            'slug'        => 'mercadorias-transporte',
        ),
    );

    foreach ( $sample_empresas as $item ) {
        $existing = get_page_by_title( $item['title'], OBJECT, 'seguro_empresa' );
        if ( ! $existing ) {
            $inserted_id = wp_insert_post( array(
                'post_title'   => $item['title'],
                'post_name'    => $item['slug'],
                'post_content' => $item['content'],
                'post_excerpt' => $item['excerpt'],
                'post_status'  => 'publish',
                'post_type'    => 'seguro_empresa',
                'menu_order'   => $item['order'],
            ) );

            if ( $inserted_id && ! is_wp_error( $inserted_id ) ) {
                update_post_meta( $inserted_id, '_seguro_btn_text', 'saber mais' );
                update_post_meta( $inserted_id, '_seguro_btn_url', get_permalink( $inserted_id ) );
            }
        }
    }

    wp_safe_redirect( admin_url( 'edit.php?post_type=seguro_empresa&pacto_seeded_empresas=1' ) );
    exit;
}
add_action( 'admin_init', 'pacto_25_seed_sample_seguros_empresas' );

/**
 * Seed sample Seguros Particulares into WordPress if requested by admin.
 * Trigger via /wp-admin/?pacto_seed_particulares=1
 */
function pacto_25_seed_sample_seguros_particulares() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    if ( ! isset( $_GET['pacto_seed_particulares'] ) || '1' !== $_GET['pacto_seed_particulares'] ) {
        return;
    }

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

    foreach ( $sample_particulares as $item ) {
        $existing = get_page_by_title( $item['title'], OBJECT, 'seguro_particular' );
        if ( ! $existing ) {
            $inserted_id = wp_insert_post( array(
                'post_title'   => $item['title'],
                'post_name'    => $item['slug'],
                'post_content' => $item['content'],
                'post_excerpt' => $item['excerpt'],
                'post_status'  => 'publish',
                'post_type'    => 'seguro_particular',
                'menu_order'   => $item['order'],
            ) );

            if ( $inserted_id && ! is_wp_error( $inserted_id ) ) {
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
                    $upload_dir = wp_upload_dir();
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
                    }
                }
            }
        }
    }

    wp_safe_redirect( admin_url( 'edit.php?post_type=seguro_particular&pacto_seeded_particulares=1' ) );
    exit;
}
add_action( 'admin_init', 'pacto_25_seed_sample_seguros_particulares' );

/**
 * Admin notice for post seeding.
 */
function pacto_25_seeder_admin_notice() {
    if ( isset( $_GET['pacto_seeded'] ) && '1' === $_GET['pacto_seeded'] ) {
        echo '<div class="notice notice-success is-dismissible"><p><strong>Pacto 25:</strong> 6 Notícias de demonstração foram criadas com sucesso!</p></div>';
    }
    if ( isset( $_GET['pacto_seeded_empresas'] ) && '1' === $_GET['pacto_seeded_empresas'] ) {
        echo '<div class="notice notice-success is-dismissible"><p><strong>Pacto 25:</strong> 8 Seguros para Empresas de demonstração foram criados com sucesso!</p></div>';
    }
    if ( isset( $_GET['pacto_seeded_particulares'] ) && '1' === $_GET['pacto_seeded_particulares'] ) {
        echo '<div class="notice notice-success is-dismissible"><p><strong>Pacto 25:</strong> 8 Seguros Particulares com imagens e páginas single foram criados com sucesso!</p></div>';
    }
}
add_action( 'admin_notices', 'pacto_25_seeder_admin_notice' );
