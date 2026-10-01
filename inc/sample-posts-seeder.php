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

    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
    require_once( ABSPATH . 'wp-admin/includes/media.php' );

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
                    }
                }
            }
        }
    }

    flush_rewrite_rules( false );
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

    flush_rewrite_rules( false );
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
