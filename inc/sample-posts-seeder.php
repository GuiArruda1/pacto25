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
 * Admin notice for post seeding.
 */
function pacto_25_seeder_admin_notice() {
    if ( isset( $_GET['pacto_seeded'] ) && '1' === $_GET['pacto_seeded'] ) {
        echo '<div class="notice notice-success is-dismissible"><p><strong>Pacto 25:</strong> 6 Notícias de demonstração foram criadas com sucesso!</p></div>';
    }
    if ( isset( $_GET['pacto_seeded_empresas'] ) && '1' === $_GET['pacto_seeded_empresas'] ) {
        echo '<div class="notice notice-success is-dismissible"><p><strong>Pacto 25:</strong> 8 Seguros para Empresas de demonstração foram criados com sucesso!</p></div>';
    }
}
add_action( 'admin_notices', 'pacto_25_seeder_admin_notice' );
