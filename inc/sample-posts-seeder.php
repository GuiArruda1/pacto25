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
 * Admin notice for post seeding.
 */
function pacto_25_seeder_admin_notice() {
    if ( isset( $_GET['pacto_seeded'] ) && '1' === $_GET['pacto_seeded'] ) {
        echo '<div class="notice notice-success is-dismissible"><p><strong>Pacto 25:</strong> 6 Notícias de demonstração foram criadas com sucesso!</p></div>';
    }
}
add_action( 'admin_notices', 'pacto_25_seeder_admin_notice' );
