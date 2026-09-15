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
                'default_value' => "O que dizem sobre a\nPacto Seguro",
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
                'default_value' => 'NOTÍCIAS & EVENTOS',
            ),
            array(
                'key' => 'field_news_title',
                'label' => __( 'Título', 'pacto-25' ),
                'name' => 'news_title',
                'type' => 'text',
                'default_value' => 'Presença de Rosalina Pereira CEO da Pacto Seguro no MAG Summit',
            ),
            array(
                'key' => 'field_news_description',
                'label' => __( 'Descrição', 'pacto-25' ),
                'name' => 'news_description',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'A CEO da Pacto Seguro partilhou a visão sobre o futuro do setor segurador e o papel da inovação na proximidade com os clientes.',
            ),
            array(
                'key' => 'field_news_btn_text',
                'label' => __( 'Texto do Botão', 'pacto-25' ),
                'name' => 'news_btn_text',
                'type' => 'text',
                'default_value' => 'LER MAIS NOTÍCIAS',
            ),
            array(
                'key' => 'field_news_btn_url',
                'label' => __( 'Link do Botão', 'pacto-25' ),
                'name' => 'news_btn_url',
                'type' => 'text',
                'default_value' => '#',
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
                'label' => __( 'Newsletter', 'pacto-25' ),
                'type' => 'tab',
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
                'default_value' => 'Subscreva a nossa newsletter e receba mensalmente as melhores dicas e informações sobre o setor segurador.',
            ),
            array(
                'key' => 'field_newsletter_consent',
                'label' => __( 'Texto de Consentimento', 'pacto-25' ),
                'name' => 'newsletter_consent',
                'type' => 'text',
                'default_value' => 'Concordo com os termos e a política de privacidade',
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
        'instruction_placement' => 'label',
    ) );
}
add_action( 'acf/init', 'pacto_25_register_acf_fields' );

/**
 * Remove strict validation from all ACF fields so changes can always be saved freely.
 */
add_filter( 'acf/validate_value', '__return_true', 99, 4 );

