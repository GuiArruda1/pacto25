<?php
/**
 * Programmatic ACF Field Groups
 * Theme: Pacto 25
 * Strict Agency SOP: Fully decoupled text & media. Zero static hardcoded strings.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function pacto_25_register_acf_fields() {
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    acf_add_local_field_group( array(
        'key' => 'group_pacto_homepage',
        'title' => __( 'Página Inicial - Configuração de Secções', 'pacto-25' ),
        'fields' => array(
            // --- TAB: CABEÇALHO & IDENTIDADE ---
            array(
                'key' => 'field_tab_header_branding',
                'label' => __( 'Cabeçalho & Logótipo', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_header_logo',
                'label' => __( 'Logótipo do Cabeçalho', 'pacto-25' ),
                'instructions' => __( 'Faça upload da imagem do logótipo para substituir a marca predefinida no cabeçalho. (Recomendado: PNG ou SVG transparente, altura ~48px)', 'pacto-25' ),
                'name' => 'header_logo',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),
            array(
                'key' => 'field_footer_logo',
                'label' => __( 'Logótipo do Rodapé', 'pacto-25' ),
                'instructions' => __( 'Opcional: Versão branca ou clara do logótipo para o rodapé vermelho.', 'pacto-25' ),
                'name' => 'footer_logo',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),
            array(
                'key' => 'field_header_phone',
                'label' => __( 'Número de Telefone (Botão do Cabeçalho)', 'pacto-25' ),
                'instructions' => __( 'Número de telefone exibido no botão do cabeçalho com o ícone de chamada.', 'pacto-25' ),
                'name' => 'header_phone',
                'type' => 'text',
                'default_value' => '212 946 630',
            ),
            array(
                'key' => 'field_header_phone_link',
                'label' => __( 'Link de Chamada (tel:)', 'pacto-25' ),
                'instructions' => __( 'Opcional: Ex: tel:+351212946630. Se deixar vazio, é gerado automaticamente a partir do número.', 'pacto-25' ),
                'name' => 'header_phone_link',
                'type' => 'text',
                'default_value' => 'tel:212946630',
            ),
            array(
                'key' => 'field_header_cta_text',
                'label' => __( 'Texto do Botão Alternativo / Secundário', 'pacto-25' ),
                'name' => 'header_cta_text',
                'type' => 'text',
                'default_value' => '',
            ),
            array(
                'key' => 'field_header_cta_url',
                'label' => __( 'Link do Botão Alternativo', 'pacto-25' ),
                'name' => 'header_cta_url',
                'type' => 'text',
                'default_value' => '',
            ),

            // --- TAB: MEGA MENU PARTICULARES ---
            array(
                'key'   => 'field_tab_mega_menu',
                'label' => __( 'Mega Menu Particulares', 'pacto-25' ),
                'type'  => 'tab',
            ),
            array(
                'key'           => 'field_mm_particulares_eyebrow',
                'label'         => __( 'Eyebrow / Título da Coluna 1', 'pacto-25' ),
                'instructions'  => __( 'Texto exibido no topo da primeira coluna (ex: PARTICULARES). O ponto vermelho é inserido automaticamente.', 'pacto-25' ),
                'name'          => 'mm_particulares_eyebrow',
                'type'          => 'text',
                'default_value' => 'PARTICULARES',
            ),
            array(
                'key'           => 'field_mm_col1_links',
                'label'         => __( 'Coluna 1 - Seguros', 'pacto-25' ),
                'instructions'  => __( 'Um seguro por linha no formato: Nome do Seguro | Link (Ex: seguro automóvel | #seguro-automovel). Se omitir o link, o URL é gerado automaticamente.', 'pacto-25' ),
                'name'          => 'mm_col1_links',
                'type'          => 'textarea',
                'rows'          => 6,
                'default_value' => "seguro automóvel | #seguro-automovel\nseguro multirriscos casa | #seguro-multirriscos-casa\nseguro multirriscos condomínio | #seguro-multirriscos-condominio\nseguro poupança reforma | #seguro-poupanca-reforma\nseguro embarcações de recreio | #seguro-embarcacoes-recreio",
            ),
            array(
                'key'           => 'field_mm_col2_links',
                'label'         => __( 'Coluna 2 - Seguros', 'pacto-25' ),
                'instructions'  => __( 'Um seguro por linha no formato: Nome do Seguro | Link. Alinhado no topo com a primeira linha da Coluna 1.', 'pacto-25' ),
                'name'          => 'mm_col2_links',
                'type'          => 'textarea',
                'rows'          => 6,
                'default_value' => "seguro de vida | #seguro-vida\nseguro empregada doméstica | #seguro-empregada-domestica\nseguro acidentes pessoais | #seguro-acidentes-pessoais\nseguro de saúde | #seguro-saude",
            ),
            array(
                'key'           => 'field_mm_col3_links',
                'label'         => __( 'Coluna 3 - Seguros', 'pacto-25' ),
                'instructions'  => __( 'Um seguro por linha no formato: Nome do Seguro | Link.', 'pacto-25' ),
                'name'          => 'mm_col3_links',
                'type'          => 'textarea',
                'rows'          => 6,
                'default_value' => "seguro para desporto | #seguro-desporto\nseguro de viagem | #seguro-viagem\nseguro de reposição salarial | #seguro-reposicao-salarial\nseguro erasmus | #seguro-erasmus",
            ),
            array(
                'key'           => 'field_mm_col4_links',
                'label'         => __( 'Coluna 4 - Seguros', 'pacto-25' ),
                'instructions'  => __( 'Um seguro por linha no formato: Nome do Seguro | Link.', 'pacto-25' ),
                'name'          => 'mm_col4_links',
                'type'          => 'textarea',
                'rows'          => 6,
                'default_value' => "seguro para animais de estimação | #seguro-animais-estimacao\nseguro caçadores e porte de arma | #seguro-cacadores-porte-arma\nseguro alojamento local | #seguro-alojamento-local\nseguro senhorios | #seguro-senhorios",
            ),

            // --- TAB: HERO ---
            array(
                'key' => 'field_tab_hero',
                'label' => __( 'Hero Principal', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_hero_eyebrow',
                'label' => __( 'Eyebrow / Pré-título', 'pacto-25' ),
                'name' => 'hero_eyebrow',
                'type' => 'text',
                'default_value' => 'SEGURAMENTE CONSIGO',
            ),
            array(
                'key' => 'field_hero_title',
                'label' => __( 'Título Principal (H1)', 'pacto-25' ),
                'name' => 'hero_title',
                'type' => 'text',
                'default_value' => 'Pacto Seguro 25 anos ao seu Lado',
            ),
            array(
                'key' => 'field_hero_description',
                'label' => __( 'Texto Descritivo', 'pacto-25' ),
                'name' => 'hero_description',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Construímos relações duradouras porque acreditamos que um seguro é muito mais do que uma apólice. É confiança quando mais precisa',
            ),
            array(
                'key' => 'field_hero_btn_text',
                'label' => __( 'Texto do Botão', 'pacto-25' ),
                'instructions' => __( 'Opcional. Se deixar vazio, o botão não será exibido no banner.', 'pacto-25' ),
                'name' => 'hero_btn_text',
                'type' => 'text',
                'default_value' => '',
            ),
            array(
                'key' => 'field_hero_btn_url',
                'label' => __( 'Link do Botão', 'pacto-25' ),
                'instructions' => __( 'Link de destino do botão.', 'pacto-25' ),
                'name' => 'hero_btn_url',
                'type' => 'text',
                'default_value' => '#',
            ),
            array(
                'key' => 'field_hero_image',
                'label' => __( 'Imagem do Hero (Corte Circular)', 'pacto-25' ),
                'name' => 'hero_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),

            // --- TAB: SOBRE NÓS ---
            array(
                'key' => 'field_tab_about',
                'label' => __( 'Sobre Nós', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_about_eyebrow',
                'label' => __( 'Eyebrow / Pré-título', 'pacto-25' ),
                'name' => 'about_eyebrow',
                'type' => 'text',
                'default_value' => 'SOBRE NÓS',
            ),
            array(
                'key' => 'field_about_title',
                'label' => __( 'Título da Secção', 'pacto-25' ),
                'name' => 'about_title',
                'type' => 'text',
                'default_value' => 'Sobre a Pacto Seguro',
            ),
            array(
                'key' => 'field_about_description',
                'label' => __( 'Texto Narrativo', 'pacto-25' ),
                'name' => 'about_description',
                'type' => 'textarea',
                'rows' => 4,
                'default_value' => 'A Pacto Seguro celebra 25 anos de dedicação na proteção do que é mais importante para as famílias e empresas. Uma equipa especializada, focada na proximidade e na confiança em cada momento.',
            ),
            array(
                'key' => 'field_about_btn_text',
                'label' => __( 'Texto do Botão', 'pacto-25' ),
                'name' => 'about_btn_text',
                'type' => 'text',
                'default_value' => 'VER MAIS SOBRE NÓS',
            ),
            array(
                'key' => 'field_about_btn_url',
                'label' => __( 'Link do Botão', 'pacto-25' ),
                'name' => 'about_btn_url',
                'type' => 'text',
                'default_value' => '#',
            ),
            array(
                'key' => 'field_about_image',
                'label' => __( 'Imagem Sobre Nós (Poltrona Circular)', 'pacto-25' ),
                'name' => 'about_image',
                'type' => 'image',
                'return_format' => 'array',
            ),

            // --- TAB: SOLUÇÕES GLOBAIS ---
            array(
                'key' => 'field_tab_solutions_global',
                'label' => __( 'Soluções Globais', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_solutions_global_eyebrow',
                'label' => __( 'Eyebrow', 'pacto-25' ),
                'name' => 'solutions_global_eyebrow',
                'type' => 'text',
                'default_value' => 'SOLUÇÕES INTEGRADAS',
            ),
            array(
                'key' => 'field_solutions_global_title',
                'label' => __( 'Título', 'pacto-25' ),
                'name' => 'solutions_global_title',
                'type' => 'text',
                'default_value' => 'Conheça as nossas Soluções Globais',
            ),
            array(
                'key' => 'field_solutions_global_description',
                'label' => __( 'Descrição', 'pacto-25' ),
                'name' => 'solutions_global_description',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Descubra a gama completa de coberturas adaptadas a cada fase da sua vida ou do seu negócio. Segurança personalizada com atendimento ágil.',
            ),
            array(
                'key' => 'field_solutions_global_btn_text',
                'label' => __( 'Texto do Botão', 'pacto-25' ),
                'name' => 'solutions_global_btn_text',
                'type' => 'text',
                'default_value' => 'VER TODAS AS SOLUÇÕES',
            ),
            array(
                'key' => 'field_solutions_global_btn_url',
                'label' => __( 'Link do Botão', 'pacto-25' ),
                'name' => 'solutions_global_btn_url',
                'type' => 'text',
                'default_value' => '#',
            ),
            array(
                'key' => 'field_solutions_bubble_center',
                'label' => __( 'Bolha 1: Central (Reunião / Soluções Globais)', 'pacto-25' ),
                'name' => 'solutions_bubble_center',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),
            array(
                'key' => 'field_solutions_bubble_top_left',
                'label' => __( 'Bolha 2: Superior Esquerda (Animal / Pet)', 'pacto-25' ),
                'name' => 'solutions_bubble_top_left',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
            ),
            array(
                'key' => 'field_solutions_bubble_top_right',
                'label' => __( 'Bolha 3: Superior Direita (Profissional / Negócios)', 'pacto-25' ),
                'name' => 'solutions_bubble_top_right',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
            ),
            array(
                'key' => 'field_solutions_bubble_bottom_left',
                'label' => __( 'Bolha 4: Inferior Esquerda (Família / Seniores)', 'pacto-25' ),
                'name' => 'solutions_bubble_bottom_left',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
            ),
            array(
                'key' => 'field_solutions_bubble_bottom_right',
                'label' => __( 'Bolha 5: Inferior Direita (Automóvel / Viagem)', 'pacto-25' ),
                'name' => 'solutions_bubble_bottom_right',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
            ),

            // --- TAB: SOLUÇÕES EMPRESAS ---
            array(
                'key' => 'field_tab_solutions_biz',
                'label' => __( 'Seguros Empresas', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_solutions_biz_eyebrow',
                'label' => __( 'Eyebrow', 'pacto-25' ),
                'name' => 'solutions_biz_eyebrow',
                'type' => 'text',
                'default_value' => 'PROTEÇÃO EMPRESARIAL',
            ),
            array(
                'key' => 'field_solutions_biz_title',
                'label' => __( 'Título', 'pacto-25' ),
                'name' => 'solutions_biz_title',
                'type' => 'text',
                'default_value' => 'Soluções de Seguros para Empresas',
            ),
            array(
                'key' => 'field_solutions_biz_description',
                'label' => __( 'Descrição', 'pacto-25' ),
                'name' => 'solutions_biz_description',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Protegemos o seu negócio, os seus colaboradores e o seu património com seguros desenhados à medida das suas necessidades operacionais.',
            ),
            array(
                'key' => 'field_solutions_biz_btn_text',
                'label' => __( 'Texto do Botão', 'pacto-25' ),
                'name' => 'solutions_biz_btn_text',
                'type' => 'text',
                'default_value' => 'VER SEGUROS EMPRESAS',
            ),
            array(
                'key' => 'field_solutions_biz_btn_url',
                'label' => __( 'Link do Botão', 'pacto-25' ),
                'name' => 'solutions_biz_btn_url',
                'type' => 'text',
                'default_value' => '#',
            ),
            array(
                'key' => 'field_solutions_biz_image',
                'label' => __( 'Imagem Empresas (Corte Circular)', 'pacto-25' ),
                'name' => 'solutions_biz_image',
                'type' => 'image',
                'return_format' => 'array',
            ),

            // --- TAB: SOLUÇÕES PARTICULARES ---
            array(
                'key' => 'field_tab_solutions_part',
                'label' => __( 'Seguros Particulares', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_solutions_part_eyebrow',
                'label' => __( 'Eyebrow', 'pacto-25' ),
                'name' => 'solutions_part_eyebrow',
                'type' => 'text',
                'default_value' => 'PROTEÇÃO FAMILIAR',
            ),
            array(
                'key' => 'field_solutions_part_title',
                'label' => __( 'Título', 'pacto-25' ),
                'name' => 'solutions_part_title',
                'type' => 'text',
                'default_value' => 'Soluções de Seguros para Particulares',
            ),
            array(
                'key' => 'field_solutions_part_description',
                'label' => __( 'Descrição', 'pacto-25' ),
                'name' => 'solutions_part_description',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'A tranquilidade de quem mais ama com seguros de saúde, vida, habitação e automóvel adaptados à realidade da sua família.',
            ),
            array(
                'key' => 'field_solutions_part_btn_text',
                'label' => __( 'Texto do Botão', 'pacto-25' ),
                'name' => 'solutions_part_btn_text',
                'type' => 'text',
                'default_value' => 'VER MAIS PARTICULARES',
            ),
            array(
                'key' => 'field_solutions_part_btn_url',
                'label' => __( 'Link do Botão', 'pacto-25' ),
                'name' => 'solutions_part_btn_url',
                'type' => 'text',
                'default_value' => '#',
            ),
            array(
                'key' => 'field_solutions_part_image',
                'label' => __( 'Imagem Particulares (Corte Circular)', 'pacto-25' ),
                'name' => 'solutions_part_image',
                'type' => 'image',
                'return_format' => 'array',
            ),

            // --- TAB: TESTEMUNHOS ---
            array(
                'key' => 'field_tab_testimonials',
                'label' => __( 'Testemunhos', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_testimonials_eyebrow',
                'label' => __( 'Eyebrow', 'pacto-25' ),
                'name' => 'testimonials_eyebrow',
                'type' => 'text',
                'default_value' => 'PORQUÊ ESCOLHER-NOS',
            ),
            array(
                'key' => 'field_testimonials_title',
                'label' => __( 'Título', 'pacto-25' ),
                'name' => 'testimonials_title',
                'type' => 'text',
                'default_value' => 'O que dizem sobre a Pacto Seguro',
            ),
            array(
                'key' => 'field_testimonials_description',
                'label' => __( 'Descrição', 'pacto-25' ),
                'name' => 'testimonials_description',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
            ),
            // Testemunho 1
            array(
                'key' => 'field_testimonial_1_avatar',
                'label' => __( 'Testemunho 1 - Foto / Avatar', 'pacto-25' ),
                'name' => 'testimonial_1_avatar',
                'type' => 'image',
                'return_format' => 'array',
            ),
            array(
                'key' => 'field_testimonial_1_name',
                'label' => __( 'Testemunho 1 - Nome', 'pacto-25' ),
                'name' => 'testimonial_1_name',
                'type' => 'text',
                'default_value' => 'Helena Sequeira',
            ),
            array(
                'key' => 'field_testimonial_1_role',
                'label' => __( 'Testemunho 1 - Cargo / Função', 'pacto-25' ),
                'name' => 'testimonial_1_role',
                'type' => 'text',
                'default_value' => 'Consultora e Formadora',
            ),
            array(
                'key' => 'field_testimonial_1_quote',
                'label' => __( 'Testemunho 1 - Texto', 'pacto-25' ),
                'name' => 'testimonial_1_quote',
                'type' => 'textarea',
                'rows' => 4,
                'default_value' => '“A Pacto Seguro tem sido uma ótima parceira em todas as vertentes da minha vida. A confiança é um ponto fulcral e nesta equipa confio ao ponto de pedir conselhos, pois, confesso, não tenho muito tempo para resolver problemas ou pesquisar. Estou grata por me ajudarem no meu Caminho.”',
            ),
            // Testemunho 2
            array(
                'key' => 'field_testimonial_2_avatar',
                'label' => __( 'Testemunho 2 - Foto / Avatar', 'pacto-25' ),
                'name' => 'testimonial_2_avatar',
                'type' => 'image',
                'return_format' => 'array',
            ),
            array(
                'key' => 'field_testimonial_2_name',
                'label' => __( 'Testemunho 2 - Nome', 'pacto-25' ),
                'name' => 'testimonial_2_name',
                'type' => 'text',
                'default_value' => 'Sérgio Simões',
            ),
            array(
                'key' => 'field_testimonial_2_role',
                'label' => __( 'Testemunho 2 - Cargo / Função', 'pacto-25' ),
                'name' => 'testimonial_2_role',
                'type' => 'text',
                'default_value' => 'Chief Operations',
            ),
            array(
                'key' => 'field_testimonial_2_quote',
                'label' => __( 'Testemunho 2 - Texto', 'pacto-25' ),
                'name' => 'testimonial_2_quote',
                'type' => 'textarea',
                'rows' => 4,
                'default_value' => '“A Pacto Seguro construiu uma relação de confiança com a nossa empresa, dando uma resposta séria a todas as nossas solicitações e necessidades, mas também oferecendo melhores soluções para a nossa actividade. A verdadeira parceria!”',
            ),
            // Testemunho 3
            array(
                'key' => 'field_testimonial_3_avatar',
                'label' => __( 'Testemunho 3 - Foto / Avatar', 'pacto-25' ),
                'name' => 'testimonial_3_avatar',
                'type' => 'image',
                'return_format' => 'array',
            ),
            array(
                'key' => 'field_testimonial_3_name',
                'label' => __( 'Testemunho 3 - Nome', 'pacto-25' ),
                'name' => 'testimonial_3_name',
                'type' => 'text',
                'default_value' => 'Maria do Carmo',
            ),
            array(
                'key' => 'field_testimonial_3_role',
                'label' => __( 'Testemunho 3 - Cargo / Função', 'pacto-25' ),
                'name' => 'testimonial_3_role',
                'type' => 'text',
                'default_value' => 'CEO',
            ),
            array(
                'key' => 'field_testimonial_3_quote',
                'label' => __( 'Testemunho 3 - Texto', 'pacto-25' ),
                'name' => 'testimonial_3_quote',
                'type' => 'textarea',
                'rows' => 4,
                'default_value' => '“Para além da diversidade dos produtos disponíveis, a deferência que têm para connosco é para nós crucial nesta relação.”',
            ),
            // Testemunho 4
            array(
                'key' => 'field_testimonial_4_avatar',
                'label' => __( 'Testemunho 4 - Foto / Avatar', 'pacto-25' ),
                'name' => 'testimonial_4_avatar',
                'type' => 'image',
                'return_format' => 'array',
            ),
            array(
                'key' => 'field_testimonial_4_name',
                'label' => __( 'Testemunho 4 - Nome', 'pacto-25' ),
                'name' => 'testimonial_4_name',
                'type' => 'text',
                'default_value' => 'Ricardo Flaminio',
            ),
            array(
                'key' => 'field_testimonial_4_role',
                'label' => __( 'Testemunho 4 - Cargo / Função', 'pacto-25' ),
                'name' => 'testimonial_4_role',
                'type' => 'text',
                'default_value' => 'Diretor',
            ),
            array(
                'key' => 'field_testimonial_4_quote',
                'label' => __( 'Testemunho 4 - Texto', 'pacto-25' ),
                'name' => 'testimonial_4_quote',
                'type' => 'textarea',
                'rows' => 4,
                'default_value' => 'A Pacto Seguro sempre respondeu com prontidão a todos os pedidos realizados e alterações necessárias. Destaco a rapidez e prontidão como as principais características de trabalho desta empresa.',
            ),
            // Testemunho 5
            array(
                'key' => 'field_testimonial_5_avatar',
                'label' => __( 'Testemunho 5 - Foto / Avatar', 'pacto-25' ),
                'name' => 'testimonial_5_avatar',
                'type' => 'image',
                'return_format' => 'array',
            ),
            array(
                'key' => 'field_testimonial_5_name',
                'label' => __( 'Testemunho 5 - Nome', 'pacto-25' ),
                'name' => 'testimonial_5_name',
                'type' => 'text',
                'default_value' => 'Anabela Ferreira',
            ),
            array(
                'key' => 'field_testimonial_5_role',
                'label' => __( 'Testemunho 5 - Cargo / Função', 'pacto-25' ),
                'name' => 'testimonial_5_role',
                'type' => 'text',
                'default_value' => 'General Manager',
            ),
            array(
                'key' => 'field_testimonial_5_quote',
                'label' => __( 'Testemunho 5 - Texto', 'pacto-25' ),
                'name' => 'testimonial_5_quote',
                'type' => 'textarea',
                'rows' => 4,
                'default_value' => 'Temos na Pacto Seguro todos os nossos seguros há vários anos, é um parceiro transparente e honesto com quem nos identificamos. Sentimos sempre um tratamento personalizado e não somente mais um cliente! Obrigado por toda a vossa ajuda e amizade ao longo dos anos.',
            ),

            // --- TAB: NOTÍCIAS & DESTAQUE ---
            array(
                'key' => 'field_tab_news',
                'label' => __( 'Notícias & Eventos', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_news_eyebrow',
                'label' => __( 'Eyebrow', 'pacto-25' ),
                'name' => 'news_eyebrow',
                'type' => 'text',
                'default_value' => 'NOTÍCIAS MAIS RECENTES',
            ),
            array(
                'key' => 'field_news_title',
                'label' => __( 'Título', 'pacto-25' ),
                'name' => 'news_title',
                'type' => 'text',
                'default_value' => 'Presença de Teresinha Pereira, CEO da Pacto Seguro no MAE Summit',
            ),
            array(
                'key' => 'field_news_description',
                'label' => __( 'Descrição', 'pacto-25' ),
                'name' => 'news_description',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
            ),
            array(
                'key' => 'field_news_btn_text',
                'label' => __( 'Texto do Botão', 'pacto-25' ),
                'name' => 'news_btn_text',
                'type' => 'text',
                'default_value' => 'ver todas as notícias',
            ),
            array(
                'key' => 'field_news_btn_url',
                'label' => __( 'Link do Botão', 'pacto-25' ),
                'name' => 'news_btn_url',
                'type' => 'text',
                'default_value' => '#noticias',
            ),
            array(
                'key' => 'field_news_image',
                'label' => __( 'Imagem Destaque Notícia', 'pacto-25' ),
                'name' => 'news_image',
                'type' => 'image',
                'return_format' => 'array',
            ),

            // --- TAB: NEWSLETTER ---
            array(
                'key' => 'field_tab_newsletter',
                'label' => __( 'Newsletter / Ebook', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_newsletter_eyebrow',
                'label' => __( 'Eyebrow', 'pacto-25' ),
                'name' => 'newsletter_eyebrow',
                'type' => 'text',
                'default_value' => 'FAÇA DOWNLOAD DO NOSSO EBOOK',
            ),
            array(
                'key' => 'field_newsletter_title',
                'label' => __( 'Título da Newsletter', 'pacto-25' ),
                'name' => 'newsletter_title',
                'type' => 'text',
                'default_value' => 'Dicas para Escolher o seu Seguro',
            ),
            array(
                'key' => 'field_newsletter_description',
                'label' => __( 'Descrição', 'pacto-25' ),
                'name' => 'newsletter_description',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
            ),
            array(
                'key' => 'field_newsletter_btn_text',
                'label' => __( 'Texto do Botão', 'pacto-25' ),
                'name' => 'newsletter_btn_text',
                'type' => 'text',
                'default_value' => 'receber ebook gratuito',
            ),
            array(
                'key' => 'field_newsletter_consent',
                'label' => __( 'Texto de Consentimento', 'pacto-25' ),
                'name' => 'newsletter_consent',
                'type' => 'text',
                'default_value' => 'Li e aceito a Política de Privacidade.',
            ),
            array(
                'key' => 'field_newsletter_image',
                'label' => __( 'Imagem do Ebook / Bolha Esquerda', 'pacto-25' ),
                'name' => 'newsletter_image',
                'type' => 'image',
                'return_format' => 'array',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_type',
                    'operator' => '==',
                    'value' => 'front_page',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
    ) );

    // --- FIELD GROUP: QUEM SOMOS (PAGE TEMPLATE) ---
    acf_add_local_field_group( array(
        'key' => 'group_pacto_quem_somos',
        'title' => __( 'Página Quem Somos - Configuração', 'pacto-25' ),
        'fields' => array(
            array(
                'key' => 'field_qs_eyebrow',
                'label' => __( 'Eyebrow / Pré-título', 'pacto-25' ),
                'name' => 'qs_eyebrow',
                'type' => 'text',
                'default_value' => 'INSTITUCIONAL — PACTO SEGURO',
            ),
            array(
                'key' => 'field_qs_title',
                'label' => __( 'Título Principal (H1)', 'pacto-25' ),
                'name' => 'qs_title',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => "Quem Somos\nSeguros à Medida",
            ),
            array(
                'key' => 'field_qs_description',
                'label' => __( 'Texto Descritivo', 'pacto-25' ),
                'name' => 'qs_description',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
            ),
            array(
                'key' => 'field_qs_image',
                'label' => __( 'Imagem da Equipa (Corte Circular)', 'pacto-25' ),
                'name' => 'qs_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-quem-somos.php',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
    ) );
    // --- FIELD GROUP: TESTEMUNHO (CUSTOM POST TYPE) ---
    acf_add_local_field_group( array(
        'key' => 'group_pacto_testemunho',
        'title' => __( 'Dados do Testemunho', 'pacto-25' ),
        'fields' => array(
            array(
                'key' => 'field_cpt_testimonial_role',
                'label' => __( 'Cargo / Função / Empresa', 'pacto-25' ),
                'name' => 'testimonial_role',
                'type' => 'text',
                'placeholder' => 'ex: CEO, Consultora e Formadora, Diretor',
                'instructions' => 'Insira o cargo ou empresa do autor para exibição no cartão.',
            ),
            array(
                'key' => 'field_cpt_testimonial_quote',
                'label' => __( 'Depoimento / Testemunho', 'pacto-25' ),
                'name' => 'testimonial_quote',
                'type' => 'textarea',
                'rows' => 4,
                'instructions' => 'O texto do depoimento. Se deixado em branco, utiliza o conteúdo principal do editor.',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'testemunho',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
    ) );

    // =========================================================================
    // FIELD GROUP: QUEM SOMOS / INSTITUCIONAL PAGE
    // =========================================================================
    $qs_locations = array(
        array(
            array(
                'param'    => 'page_template',
                'operator' => '==',
                'value'    => 'page-quem-somos.php',
            ),
        ),
    );
    $qs_page = get_page_by_path( 'quem-somos' );
    if ( ! $qs_page ) {
        $qs_page = get_page_by_path( 'institucional' );
    }
    if ( ! $qs_page ) {
        $qs_page = get_page_by_path( 'sobre' );
    }
    if ( $qs_page ) {
        $qs_locations[] = array(
            array(
                'param'    => 'page',
                'operator' => '==',
                'value'    => $qs_page->ID,
            ),
        );
    }

    acf_add_local_field_group( array(
        'key' => 'group_pacto_quem_somos',
        'title' => __( 'Quem Somos - Configuração da Página', 'pacto-25' ),
        'fields' => array(
            // --- TAB 1: HERO ---
            array(
                'key' => 'field_tab_qs_hero',
                'label' => __( '1. Apresentação (Hero)', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_qs_hero_eyebrow',
                'label' => __( 'Subtítulo Superior (Eyebrow)', 'pacto-25' ),
                'name' => 'qs_hero_eyebrow',
                'type' => 'text',
                'default_value' => 'INSTITUCIONAL — PACTO SEGURO',
            ),
            array(
                'key' => 'field_qs_hero_title',
                'label' => __( 'Título Principal', 'pacto-25' ),
                'name' => 'qs_hero_title',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => "Quem Somos\nSeguros à Medida",
            ),
            array(
                'key' => 'field_qs_hero_description',
                'label' => __( 'Descrição / Lead', 'pacto-25' ),
                'name' => 'qs_hero_description',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Com mais de duas décadas de experiência no mercado segurador, temos vindo a consolidar o nosso papel como mediador de seguros de confiança para famílias e empresas.',
            ),
            array(
                'key' => 'field_qs_hero_image',
                'label' => __( 'Foto da Equipa (Círculo)', 'pacto-25' ),
                'name' => 'qs_hero_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),

            // --- TAB 2: PORQUE O FAZEMOS ---
            array(
                'key' => 'field_tab_qs_why',
                'label' => __( '2. Porque o Fazemos?', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_qs_why_eyebrow',
                'label' => __( 'Subtítulo', 'pacto-25' ),
                'name' => 'qs_why_eyebrow',
                'type' => 'text',
                'default_value' => 'PORQUE O FAZEMOS?',
            ),
            array(
                'key' => 'field_qs_why_title',
                'label' => __( 'Título', 'pacto-25' ),
                'name' => 'qs_why_title',
                'type' => 'text',
                'default_value' => 'Porque o fazemos?',
            ),
            array(
                'key' => 'field_qs_why_description',
                'label' => __( 'Parágrafo 1', 'pacto-25' ),
                'name' => 'qs_why_description',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'O nosso propósito nasce da paixão por proteger o que mais importa. Num mundo em constante mudança, acreditamos que a segurança financeira e o bem-estar das pessoas e empresas devem ser construídos com base na confiança, na transparência e no acompanhamento próximo.',
            ),
            array(
                'key' => 'field_qs_why_desc_secondary',
                'label' => __( 'Parágrafo 2', 'pacto-25' ),
                'name' => 'qs_why_desc_secondary',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Não nos limitamos a mediar seguros: estamos ao seu lado nos momentos decisivos, simplificando processos e garantindo que tem sempre a proteção certa à medida das suas necessidades reais.',
            ),
            array(
                'key' => 'field_qs_why_image',
                'label' => __( 'Foto Circular — Porque o fazemos? (Telefone / Mulher)', 'pacto-25' ),
                'name' => 'qs_why_image',
                'type' => 'image',
                'instructions' => __( 'Fotografia circular com anel vermelho na secção Porque o fazemos.', 'pacto-25' ),
                'return_format' => 'array',
                'preview_size' => 'medium',
                'library' => 'all',
            ),

            // --- TAB 3: MISSÃO, VISÃO E VALORES ---
            array(
                'key' => 'field_tab_qs_mission',
                'label' => __( '3. Missão, Visão e Valores', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_qs_mission_eyebrow',
                'label' => __( 'Subtítulo', 'pacto-25' ),
                'name' => 'qs_mission_eyebrow',
                'type' => 'text',
                'default_value' => 'MISSÃO, VISÃO E VALORES',
            ),
            array(
                'key' => 'field_qs_mission_title',
                'label' => __( 'Título', 'pacto-25' ),
                'name' => 'qs_mission_title',
                'type' => 'text',
                'default_value' => 'Missão, Visão e Valores',
            ),
            array(
                'key' => 'field_qs_mission_desc_1',
                'label' => __( 'Texto Missão', 'pacto-25' ),
                'name' => 'qs_mission_desc_1',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'A nossa missão é proporcionar tranquilidade e segurança através de soluções de seguros rigorosas, personalizadas e transparentes, adaptadas à realidade de cada cliente.',
            ),
            array(
                'key' => 'field_qs_mission_desc_2',
                'label' => __( 'Texto Visão e Valores', 'pacto-25' ),
                'name' => 'qs_mission_desc_2',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Aspiramos a ser a referência de confiança no setor da mediação de seguros, pautando a nossa atuação pelo rigor ético, proximidade humana e inovação constante na resposta aos desafios dos nossos clientes.',
            ),
            array(
                'key' => 'field_qs_mission_btn_text',
                'label' => __( 'Texto do Botão', 'pacto-25' ),
                'name' => 'qs_mission_btn_text',
                'type' => 'text',
                'default_value' => 'FALE COM A NOSSA EQUIPA',
            ),
            array(
                'key' => 'field_qs_mission_btn_link',
                'label' => __( 'Link do Botão', 'pacto-25' ),
                'name' => 'qs_mission_btn_link',
                'type' => 'text',
                'default_value' => '#contactos',
            ),
            array(
                'key' => 'field_qs_mission_image',
                'label' => __( 'Foto da Equipa (Círculo)', 'pacto-25' ),
                'name' => 'qs_mission_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),

            // --- TAB 4: PORQUÊ ESCOLHER-NOS ---
            array(
                'key' => 'field_tab_qs_reasons',
                'label' => __( '4. Porquê Escolher-nos', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_qs_reasons_eyebrow',
                'label' => __( 'Subtítulo', 'pacto-25' ),
                'name' => 'qs_reasons_eyebrow',
                'type' => 'text',
                'default_value' => 'PORQUÊ ESCOLHER-NOS',
            ),
            array(
                'key' => 'field_qs_reasons_title',
                'label' => __( 'Título', 'pacto-25' ),
                'name' => 'qs_reasons_title',
                'type' => 'text',
                'default_value' => 'Porquê escolher-nos',
            ),
            array(
                'key' => 'field_qs_reasons_p1',
                'label' => __( 'Parágrafo 1', 'pacto-25' ),
                'name' => 'qs_reasons_p1',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Compreendemos que a escolha de um mediador de seguros é uma decisão de confiança. Por isso, aliamos mais de 25 anos de experiência prática a um atendimento genuinamente personalizado e humanizado.',
            ),
            array(
                'key' => 'field_qs_reasons_p2',
                'label' => __( 'Parágrafo 2', 'pacto-25' ),
                'name' => 'qs_reasons_p2',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Analisamos minuciosamente o mercado segurador para lhe apresentar as melhores soluções, negociando coberturas robustas e condições vantajosas para que nunca pague mais do que o estritamente necessário.',
            ),
            array(
                'key' => 'field_qs_reasons_p3',
                'label' => __( 'Parágrafo 3', 'pacto-25' ),
                'name' => 'qs_reasons_p3',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Em caso de sinistro ou dúvida, assumimos toda a gestão burocrática por si. A nossa equipa assegura uma resposta célere e eficaz, defendendo sempre e em primeiro lugar os seus legítimos interesses.',
            ),

            // --- TAB 5: A NOSSA EQUIPA ---
            array(
                'key' => 'field_tab_qs_team',
                'label' => __( '5. A Nossa Equipa', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_qs_team_eyebrow',
                'label' => __( 'Subtítulo', 'pacto-25' ),
                'name' => 'qs_team_eyebrow',
                'type' => 'text',
                'default_value' => 'A NOSSA EQUIPA',
            ),
            array(
                'key' => 'field_qs_team_title',
                'label' => __( 'Título', 'pacto-25' ),
                'name' => 'qs_team_title',
                'type' => 'text',
                'default_value' => 'Profissionais dedicados ao seu lado',
            ),

            // --- TAB 6: BANNER CTA ---
            array(
                'key' => 'field_tab_qs_cta',
                'label' => __( '6. Banner CTA', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_qs_cta_eyebrow',
                'label' => __( 'Subtítulo', 'pacto-25' ),
                'name' => 'qs_cta_eyebrow',
                'type' => 'text',
                'default_value' => 'FALE CONNOSCO',
            ),
            array(
                'key' => 'field_qs_cta_title',
                'label' => __( 'Título', 'pacto-25' ),
                'name' => 'qs_cta_title',
                'type' => 'text',
                'default_value' => 'Temos uma equipa preparada para responder a todas as suas dúvidas.',
            ),
            array(
                'key' => 'field_qs_cta_subtitle',
                'label' => __( 'Texto Descritivo', 'pacto-25' ),
                'name' => 'qs_cta_subtitle',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => 'Descubra a solução ideal para si ou para a sua empresa. Estamos disponíveis para o apoiar em todas as etapas.',
            ),
            array(
                'key' => 'field_qs_cta_btn_text',
                'label' => __( 'Texto do Botão', 'pacto-25' ),
                'name' => 'qs_cta_btn_text',
                'type' => 'text',
                'default_value' => 'CONTACTE-NOS',
            ),
            array(
                'key' => 'field_qs_cta_btn_link',
                'label' => __( 'Link do Botão', 'pacto-25' ),
                'name' => 'qs_cta_btn_link',
                'type' => 'text',
                'default_value' => '#contactos',
            ),
        ),
        'location' => $qs_locations,
        'menu_order' => 1,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
    ) );

    // =========================================================================
    // FIELD GROUP: PARTICULARES
    // =========================================================================
    acf_add_local_field_group( array(
        'key' => 'group_pacto_particulares',
        'title' => __( 'Particulares - Configuração de Secções', 'pacto-25' ),
        'fields' => array(
            // --- TAB: HERO ---
            array(
                'key' => 'field_tab_particulares_hero',
                'label' => __( 'Secção 1: Hero', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_particulares_hero_eyebrow',
                'label' => __( 'Eyebrow / Subtítulo Superior', 'pacto-25' ),
                'name' => 'particulares_hero_eyebrow',
                'type' => 'text',
                'default_value' => 'PARTICULARES — PACTO SEGURO',
            ),
            array(
                'key' => 'field_particulares_hero_title',
                'label' => __( 'Título Principal (H1)', 'pacto-25' ),
                'name' => 'particulares_hero_title',
                'type' => 'text',
                'default_value' => 'Seguros para Particulares',
            ),
            array(
                'key' => 'field_particulares_hero_description',
                'label' => __( 'Texto Introdutório / Descrição', 'pacto-25' ),
                'name' => 'particulares_hero_description',
                'type' => 'textarea',
                'rows' => 4,
                'default_value' => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
            ),
            array(
                'key' => 'field_particulares_hero_image',
                'label' => __( 'Imagem do Hero (Família à Mesa Redonda)', 'pacto-25' ),
                'name' => 'particulares_hero_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),
            array(
                'key' => 'field_tab_particulares_seguros',
                'label' => __( 'Secção 2: Lista de Seguros', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_particulares_seguros_per_page',
                'label' => __( 'Seguros por Página', 'pacto-25' ),
                'name' => 'particulares_seguros_per_page',
                'type' => 'number',
                'default_value' => 8,
                'min' => 1,
                'max' => 40,
            ),
            array(
                'key' => 'field_tab_particulares_cta',
                'label' => __( 'Secção 3: Banner CTA', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_particulares_cta_eyebrow',
                'label' => __( 'Eyebrow', 'pacto-25' ),
                'name' => 'particulares_cta_eyebrow',
                'type' => 'text',
                'default_value' => 'EXPERIMENTE-NOS!',
            ),
            array(
                'key' => 'field_particulares_cta_title',
                'label' => __( 'Título Principal', 'pacto-25' ),
                'name' => 'particulares_cta_title',
                'type' => 'text',
                'default_value' => 'Temos uma equipa preparada para responder a todas as suas dúvidas.',
            ),
            array(
                'key' => 'field_particulares_cta_subtitle',
                'label' => __( 'Texto Descritivo', 'pacto-25' ),
                'name' => 'particulares_cta_subtitle',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => 'Convidamo-lo a partilhar as suas experiências para que possamos melhorar produtos e serviços. Faça-nos chegar a sua história.',
            ),
            array(
                'key' => 'field_particulares_cta_btn_text',
                'label' => __( 'Texto do Botão', 'pacto-25' ),
                'name' => 'particulares_cta_btn_text',
                'type' => 'text',
                'default_value' => 'pedir simulação',
            ),
            array(
                'key' => 'field_particulares_cta_btn_link',
                'label' => __( 'Link do Botão', 'pacto-25' ),
                'name' => 'particulares_cta_btn_link',
                'type' => 'text',
                'default_value' => '#contactos',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-particulares.php',
                ),
            ),
        ),
        'menu_order' => 2,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
    ) );

    /* ==========================================================================
       Field Group: Detalhes do Seguro Particular (CPT seguro_particular)
       ========================================================================== */
    acf_add_local_field_group( array(
        'key' => 'group_pacto_seguro_particular_cpt',
        'title' => __( 'Configuração do Seguro Particular (Single Page)', 'pacto-25' ),
        'fields' => array(
            // --- TAB: CARD / LISTAGEM ---
            array(
                'key' => 'field_tab_seguro_card',
                'label' => __( 'Listagem / Card', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_seguro_btn_text',
                'label' => __( 'Texto do Link no Card', 'pacto-25' ),
                'name' => 'seguro_btn_text',
                'type' => 'text',
                'default_value' => 'saber mais',
                'placeholder' => 'saber mais',
            ),
            array(
                'key' => 'field_seguro_btn_url',
                'label' => __( 'Link Personalizado no Card (Opcional)', 'pacto-25' ),
                'name' => 'seguro_btn_url',
                'type' => 'text',
                'placeholder' => 'https://... ou # ou /contatos/',
                'instructions' => __( 'Se vazio, utilizará o link direto para esta página.', 'pacto-25' ),
            ),

            // --- TAB: SECÇÃO 1 - HERO ---
            array(
                'key' => 'field_tab_seguro_hero',
                'label' => __( 'Secção 1: Hero', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_seguro_hero_eyebrow',
                'label' => __( 'Eyebrow do Hero', 'pacto-25' ),
                'name' => 'seguro_hero_eyebrow',
                'type' => 'text',
                'placeholder' => 'SEGURO MULTIRRISCOS CASA — PACTO SEGURO',
            ),
            array(
                'key' => 'field_seguro_hero_title',
                'label' => __( 'Título Principal (H1)', 'pacto-25' ),
                'name' => 'seguro_hero_title',
                'type' => 'text',
                'placeholder' => 'Encontre o melhor Seguro Multirriscos para a sua casa.',
            ),
            array(
                'key' => 'field_seguro_hero_description',
                'label' => __( 'Texto do Hero', 'pacto-25' ),
                'name' => 'seguro_hero_description',
                'type' => 'textarea',
                'rows' => 4,
            ),
            array(
                'key' => 'field_seguro_hero_btn_text',
                'label' => __( 'Texto do Botão Hero', 'pacto-25' ),
                'name' => 'seguro_hero_btn_text',
                'type' => 'text',
                'default_value' => 'pedir simulação',
            ),
            array(
                'key' => 'field_seguro_hero_btn_link',
                'label' => __( 'Link do Botão Hero', 'pacto-25' ),
                'name' => 'seguro_hero_btn_link',
                'type' => 'text',
                'default_value' => '#simulacao',
            ),
            array(
                'key' => 'field_seguro_hero_image',
                'label' => __( 'Imagem Circular Hero (Direita)', 'pacto-25' ),
                'name' => 'seguro_hero_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),

            // --- TAB: SECÇÃO 2 - O QUE É O SEGURO ---
            array(
                'key' => 'field_tab_seguro_about',
                'label' => __( 'Secção 2: O que é o Seguro?', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_seguro_about_eyebrow',
                'label' => __( 'Eyebrow', 'pacto-25' ),
                'name' => 'seguro_about_eyebrow',
                'type' => 'text',
                'placeholder' => 'SEGURO MULTIRRISCOS CASA — PACTO SEGURO',
            ),
            array(
                'key' => 'field_seguro_about_title',
                'label' => __( 'Título (H2)', 'pacto-25' ),
                'name' => 'seguro_about_title',
                'type' => 'text',
                'default_value' => 'O que é o Seguro?',
            ),
            array(
                'key' => 'field_seguro_about_p1',
                'label' => __( 'Parágrafo 1', 'pacto-25' ),
                'name' => 'seguro_about_p1',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Um Seguro Multirriscos para a casa é uma opção muito completa de seguro que cobre vários riscos que podem afetar o seu imóvel e o seu recheio. Inclui cobertura para incêndios, inundações, danos por água, roubo, atos de vandalismo e danos causados por tempestades entre muitas outras coberturas.',
            ),
            array(
                'key' => 'field_seguro_about_p2',
                'label' => __( 'Parágrafo 2', 'pacto-25' ),
                'name' => 'seguro_about_p2',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Além disso, também pode incluir cobertura para responsabilidade civil, o que significa que se alguém se magoar em sua propriedade, você estará protegido contra possíveis processos.',
            ),
            array(
                'key' => 'field_seguro_about_btn_text',
                'label' => __( 'Texto do Botão', 'pacto-25' ),
                'name' => 'seguro_about_btn_text',
                'type' => 'text',
                'default_value' => 'pedir simulação',
            ),
            array(
                'key' => 'field_seguro_about_btn_link',
                'label' => __( 'Link do Botão', 'pacto-25' ),
                'name' => 'seguro_about_btn_link',
                'type' => 'text',
                'default_value' => '#simulacao',
            ),
            array(
                'key' => 'field_seguro_about_image',
                'label' => __( 'Imagem Circular Esquerda', 'pacto-25' ),
                'name' => 'seguro_about_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),

            // --- TAB: SECÇÃO 3 - VANTAGENS, COBERTURAS E SERVIÇOS ---
            array(
                'key' => 'field_tab_seguro_features',
                'label' => __( 'Secção 3: Vantagens e Coberturas', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_seguro_features_eyebrow',
                'label' => __( 'Eyebrow', 'pacto-25' ),
                'name' => 'seguro_features_eyebrow',
                'type' => 'text',
                'placeholder' => 'SEGURO MULTIRRISCOS CASA — PACTO SEGURO',
            ),
            array(
                'key' => 'field_seguro_features_title',
                'label' => __( 'Título (H2)', 'pacto-25' ),
                'name' => 'seguro_features_title',
                'type' => 'text',
                'default_value' => 'Vantagens, Coberturas e Serviços',
            ),
            array(
                'key' => 'field_seguro_features_p1',
                'label' => __( 'Parágrafo 1', 'pacto-25' ),
                'name' => 'seguro_features_p1',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Enim amet nullam dictumst dui amet.',
            ),
            array(
                'key' => 'field_seguro_features_p2',
                'label' => __( 'Parágrafo 2', 'pacto-25' ),
                'name' => 'seguro_features_p2',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Enim amet nullam dictumst dui amet.',
            ),
            array(
                'key' => 'field_seguro_features_p3',
                'label' => __( 'Parágrafo 3', 'pacto-25' ),
                'name' => 'seguro_features_p3',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Enim amet nullam dictumst dui amet.',
            ),
            array(
                'key' => 'field_seguro_features_btn_text',
                'label' => __( 'Texto do Botão', 'pacto-25' ),
                'name' => 'seguro_features_btn_text',
                'type' => 'text',
                'default_value' => 'pedir simulação',
            ),
            array(
                'key' => 'field_seguro_features_btn_link',
                'label' => __( 'Link do Botão', 'pacto-25' ),
                'name' => 'seguro_features_btn_link',
                'type' => 'text',
                'default_value' => '#simulacao',
            ),

            // --- TAB: SECÇÃO 4 - PASSOS PARA SUBSCRIÇÃO ---
            array(
                'key' => 'field_tab_seguro_steps',
                'label' => __( 'Secção 4: Passos para Subscrição', 'pacto-25' ),
                'type' => 'tab',
            ),
            // Passo 1
            array(
                'key' => 'field_seguro_step_1_title',
                'label' => __( 'Título Passo 1', 'pacto-25' ),
                'name' => 'seguro_step_1_title',
                'type' => 'text',
                'default_value' => '1º Passo',
            ),
            array(
                'key' => 'field_seguro_step_1_desc',
                'label' => __( 'Descrição Passo 1', 'pacto-25' ),
                'name' => 'seguro_step_1_desc',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => 'Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
            ),
            array(
                'key' => 'field_seguro_step_1_image',
                'label' => __( 'Foto Passo 1', 'pacto-25' ),
                'name' => 'seguro_step_1_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
            ),
            // Passo 2
            array(
                'key' => 'field_seguro_step_2_title',
                'label' => __( 'Título Passo 2', 'pacto-25' ),
                'name' => 'seguro_step_2_title',
                'type' => 'text',
                'default_value' => '2º Passo',
            ),
            array(
                'key' => 'field_seguro_step_2_desc',
                'label' => __( 'Descrição Passo 2', 'pacto-25' ),
                'name' => 'seguro_step_2_desc',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => 'Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
            ),
            array(
                'key' => 'field_seguro_step_2_image',
                'label' => __( 'Foto Passo 2', 'pacto-25' ),
                'name' => 'seguro_step_2_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
            ),
            // Passo 3
            array(
                'key' => 'field_seguro_step_3_title',
                'label' => __( 'Título Passo 3', 'pacto-25' ),
                'name' => 'seguro_step_3_title',
                'type' => 'text',
                'default_value' => '3º Passo',
            ),
            array(
                'key' => 'field_seguro_step_3_desc',
                'label' => __( 'Descrição Passo 3', 'pacto-25' ),
                'name' => 'seguro_step_3_desc',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => 'Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
            ),
            array(
                'key' => 'field_seguro_step_3_image',
                'label' => __( 'Foto Passo 3', 'pacto-25' ),
                'name' => 'seguro_step_3_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
            ),

            // --- TAB: SECÇÃO 5 - FORMULÁRIO DE SIMULAÇÃO ---
            array(
                'key' => 'field_tab_seguro_form',
                'label' => __( 'Secção 5: Formulário de Simulação', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_seguro_form_eyebrow',
                'label' => __( 'Eyebrow do Formulário', 'pacto-25' ),
                'name' => 'seguro_form_eyebrow',
                'type' => 'text',
                'default_value' => 'ALIQUET EU PROIN NON NETUS',
            ),
            array(
                'key' => 'field_seguro_form_title',
                'label' => __( 'Título Principal (H2)', 'pacto-25' ),
                'name' => 'seguro_form_title',
                'type' => 'text',
                'default_value' => 'Enim amet nullam dui?',
            ),
            array(
                'key' => 'field_seguro_form_description',
                'label' => __( 'Texto Descritivo do Formulário', 'pacto-25' ),
                'name' => 'seguro_form_description',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Enim amet nullam dictumst dui amet.',
            ),
            array(
                'key' => 'field_seguro_form_image',
                'label' => __( 'Imagem Circular do Formulário (Direita)', 'pacto-25' ),
                'name' => 'seguro_form_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),

            // --- TAB: SECÇÃO 6 - DOCUMENTOS LEGAIS ---
            array(
                'key' => 'field_tab_seguro_docs',
                'label' => __( 'Secção 6: Documentos Legais', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_seguro_docs_eyebrow',
                'label' => __( 'Eyebrow dos Documentos', 'pacto-25' ),
                'name' => 'seguro_docs_eyebrow',
                'type' => 'text',
                'default_value' => 'LOREM IPSUM DOLOR SIT AMET',
            ),
            array(
                'key' => 'field_seguro_docs_title',
                'label' => __( 'Título Principal (H2)', 'pacto-25' ),
                'name' => 'seguro_docs_title',
                'type' => 'text',
                'default_value' => 'Documentos Legais',
            ),
            array(
                'key' => 'field_seguro_docs_description',
                'label' => __( 'Texto Descritivo', 'pacto-25' ),
                'name' => 'seguro_docs_description',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
            ),
            array(
                'key' => 'field_seguro_docs_image',
                'label' => __( 'Imagem Circular com Bolha Vermelha (Esquerda)', 'pacto-25' ),
                'name' => 'seguro_docs_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),
            array(
                'key' => 'field_seguro_docs_list',
                'label' => __( 'Lista de Documentos PDF', 'pacto-25' ),
                'name' => 'seguro_docs_list',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => __( 'Adicionar Documento', 'pacto-25' ),
                'sub_fields' => array(
                    array(
                        'key' => 'field_seguro_doc_name',
                        'label' => __( 'Nome do Documento', 'pacto-25' ),
                        'name' => 'name',
                        'type' => 'text',
                        'default_value' => 'Nome do Documento (2010-2023)',
                    ),
                    array(
                        'key' => 'field_seguro_doc_file',
                        'label' => __( 'Ficheiro PDF', 'pacto-25' ),
                        'name' => 'file',
                        'type' => 'file',
                        'return_format' => 'array',
                    ),
                ),
            ),

            // --- TAB: SECÇÃO 7 - QUESTÕES MAIS FREQUENTES (FAQS) ---
            array(
                'key' => 'field_tab_seguro_faq',
                'label' => __( 'Secção 7: Questões Frequentes (FAQs)', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_seguro_faq_eyebrow',
                'label' => __( 'Eyebrow', 'pacto-25' ),
                'name' => 'seguro_faq_eyebrow',
                'type' => 'text',
                'default_value' => '• FAQS',
            ),
            array(
                'key' => 'field_seguro_faq_title',
                'label' => __( 'Título Principal (H2)', 'pacto-25' ),
                'name' => 'seguro_faq_title',
                'type' => 'text',
                'default_value' => 'Questões Mais Frequentes',
            ),
            array(
                'key' => 'field_seguro_faq_description',
                'label' => __( 'Texto Descritivo', 'pacto-25' ),
                'name' => 'seguro_faq_description',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Enim amet nullam dictumst dui amet.',
            ),
            array(
                'key' => 'field_seguro_faq_list',
                'label' => __( 'Lista de Questões e Respostas', 'pacto-25' ),
                'name' => 'seguro_faq_list',
                'type' => 'repeater',
                'layout' => 'row',
                'button_label' => __( 'Adicionar Pergunta', 'pacto-25' ),
                'sub_fields' => array(
                    array(
                        'key' => 'field_seguro_faq_question',
                        'label' => __( 'Pergunta / Questão', 'pacto-25' ),
                        'name' => 'question',
                        'type' => 'text',
                        'placeholder' => 'ex: Que elementos terei de apresentar para subscrever...',
                    ),
                    array(
                        'key' => 'field_seguro_faq_answer',
                        'label' => __( 'Resposta', 'pacto-25' ),
                        'name' => 'answer',
                        'type' => 'textarea',
                        'rows' => 3,
                        'placeholder' => 'ex: Para subscrever o seguro multirriscos...',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'seguro_particular',
                ),
            ),
        ),
        'menu_order' => 1,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
    ) );

    // =========================================================================
    // FIELD GROUP: EM CASO DE SINISTRO (PAGE TEMPLATE)
    // =========================================================================
    acf_add_local_field_group( array(
        'key' => 'group_pacto_sinistro',
        'title' => __( 'Página Em Caso de Sinistro - Configuração', 'pacto-25' ),
        'fields' => array(
            // --- TAB: HERO ---
            array(
                'key' => 'field_tab_sinistro_hero',
                'label' => __( 'Secção 1: Hero', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_sinistro_hero_eyebrow',
                'label' => __( 'Eyebrow', 'pacto-25' ),
                'name' => 'sinistro_hero_eyebrow',
                'type' => 'text',
                'default_value' => 'INSTITUCIONAL — PACTO SEGURO',
            ),
            array(
                'key' => 'field_sinistro_hero_title',
                'label' => __( 'Título Principal (H1)', 'pacto-25' ),
                'name' => 'sinistro_hero_title',
                'type' => 'text',
                'default_value' => 'Em Caso de Sinistro',
            ),
            array(
                'key' => 'field_sinistro_hero_description',
                'label' => __( 'Texto Descritivo', 'pacto-25' ),
                'name' => 'sinistro_hero_description',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Enim amet nullam dictumst dui amet.',
            ),
            array(
                'key' => 'field_sinistro_hero_image',
                'label' => __( 'Imagem do Hero (Mala do Carro / Família)', 'pacto-25' ),
                'name' => 'sinistro_hero_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),

            // --- TAB: COMO PARTICIPAR ---
            array(
                'key' => 'field_tab_sinistro_steps',
                'label' => __( 'Secção 2: Como Participar', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_sinistro_steps_eyebrow',
                'label' => __( 'Eyebrow', 'pacto-25' ),
                'name' => 'sinistro_steps_eyebrow',
                'type' => 'text',
                'default_value' => 'PARTICULARES — PACTO SEGURO',
            ),
            array(
                'key' => 'field_sinistro_steps_title',
                'label' => __( 'Título (H2)', 'pacto-25' ),
                'name' => 'sinistro_steps_title',
                'type' => 'text',
                'default_value' => 'Como Participar um Sinistro',
            ),
            array(
                'key' => 'field_sinistro_steps_image',
                'label' => __( 'Foto Circular Esquerda', 'pacto-25' ),
                'name' => 'sinistro_steps_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),
            array(
                'key' => 'field_sinistro_steps_list',
                'label' => __( 'Passos / Checklist', 'pacto-25' ),
                'name' => 'sinistro_steps_list',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => __( 'Adicionar Passo', 'pacto-25' ),
                'sub_fields' => array(
                    array(
                        'key' => 'field_sinistro_step_text',
                        'label' => __( 'Texto do Passo', 'pacto-25' ),
                        'name' => 'text',
                        'type' => 'text',
                    ),
                ),
            ),

            // --- TAB: FORMULÁRIO ---
            array(
                'key' => 'field_tab_sinistro_form',
                'label' => __( 'Secção 3: Formulário (Círculo Vermelho)', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_sinistro_form_eyebrow',
                'label' => __( 'Eyebrow', 'pacto-25' ),
                'name' => 'sinistro_form_eyebrow',
                'type' => 'text',
                'default_value' => '• PARTICIPAR',
            ),
            array(
                'key' => 'field_sinistro_form_title',
                'label' => __( 'Título Principal (H2)', 'pacto-25' ),
                'name' => 'sinistro_form_title',
                'type' => 'text',
                'default_value' => 'Participar Sinistro',
            ),
            array(
                'key' => 'field_sinistro_form_description',
                'label' => __( 'Texto Descritivo', 'pacto-25' ),
                'name' => 'sinistro_form_description',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Enim amet nullam dictumst dui amet.',
            ),
            array(
                'key' => 'field_sinistro_form_image',
                'label' => __( 'Foto Circular Direita', 'pacto-25' ),
                'name' => 'sinistro_form_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),

            // --- TAB: DOCUMENTOS ---
            array(
                'key' => 'field_tab_sinistro_docs',
                'label' => __( 'Secção 4: Documentos Necessários', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_sinistro_docs_eyebrow',
                'label' => __( 'Eyebrow', 'pacto-25' ),
                'name' => 'sinistro_docs_eyebrow',
                'type' => 'text',
                'default_value' => 'LEGAL — PACTO SEGURO 25 ANOS',
            ),
            array(
                'key' => 'field_sinistro_docs_title',
                'label' => __( 'Título Principal (H2)', 'pacto-25' ),
                'name' => 'sinistro_docs_title',
                'type' => 'text',
                'default_value' => 'Documentos Necessários',
            ),
            array(
                'key' => 'field_sinistro_docs_description',
                'label' => __( 'Texto Descritivo', 'pacto-25' ),
                'name' => 'sinistro_docs_description',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Enim amet nullam dictumst dui amet.',
            ),
            array(
                'key' => 'field_sinistro_docs_image',
                'label' => __( 'Foto Circular Esquerda', 'pacto-25' ),
                'name' => 'sinistro_docs_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),
            array(
                'key' => 'field_sinistro_docs_list',
                'label' => __( 'Lista de Documentos PDF', 'pacto-25' ),
                'name' => 'sinistro_docs_list',
                'type' => 'repeater',
                'layout' => 'table',
                'button_label' => __( 'Adicionar Documento', 'pacto-25' ),
                'sub_fields' => array(
                    array(
                        'key' => 'field_sinistro_doc_name',
                        'label' => __( 'Nome do Documento', 'pacto-25' ),
                        'name' => 'name',
                        'type' => 'text',
                        'default_value' => 'Nome do Documento (2010-2023)',
                    ),
                    array(
                        'key' => 'field_sinistro_doc_file',
                        'label' => __( 'Ficheiro PDF', 'pacto-25' ),
                        'name' => 'file',
                        'type' => 'file',
                        'return_format' => 'array',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-sinistro.php',
                ),
            ),
        ),
        'menu_order' => 2,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
    ) );

    // =========================================================================
    // FIELD GROUP: ARQUIVO DE NOTÍCIAS (PAGE TEMPLATE & BLOG ARCHIVE)
    // =========================================================================
    acf_add_local_field_group( array(
        'key' => 'group_pacto_noticias_archive',
        'title' => __( 'Arquivo de Notícias - Configuração', 'pacto-25' ),
        'fields' => array(
            array(
                'key' => 'field_noticias_archive_eyebrow',
                'label' => __( 'Eyebrow / Pré-título', 'pacto-25' ),
                'name' => 'noticias_archive_eyebrow',
                'type' => 'text',
                'default_value' => '• NOTÍCIAS — PACTO SEGURO',
            ),
            array(
                'key' => 'field_noticias_archive_title',
                'label' => __( 'Título Principal (H1)', 'pacto-25' ),
                'name' => 'noticias_archive_title',
                'type' => 'text',
                'default_value' => 'Fique a par das nossas Notícias',
            ),
            array(
                'key' => 'field_noticias_archive_description',
                'label' => __( 'Texto Descritivo', 'pacto-25' ),
                'name' => 'noticias_archive_description',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-noticias.php',
                ),
            ),
            array(
                array(
                    'param' => 'page_type',
                    'operator' => '==',
                    'value' => 'posts_page',
                ),
            ),
        ),
        'menu_order' => 3,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
    ) );
}
add_action( 'acf/init', 'pacto_25_register_acf_fields' );

/**
 * Remove strict validation from all ACF fields so changes can always be saved freely.
 */
add_filter( 'acf/validate_value', '__return_true', 99, 4 );

