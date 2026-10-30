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

            // --- TAB: HERO SLIDER (BANNER PRINCIPAL) ---
            array(
                'key' => 'field_tab_hero_slider',
                'label' => __( 'Hero Slider (Banner Principal)', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_hero_slider_native_notice',
                'label' => __( '🎯 Gestão Dinâmica de Slides (Arrastar, Adicionar e Remover)', 'pacto-25' ),
                'type' => 'message',
                'message' => 'Os slides do Banner Principal (Hero Slider) são geridos na caixa <strong>"🎯 Hero Slider — Banner Principal (Carrossel — Arrastar, Adicionar e Remover)"</strong> logo abaixo nesta página, onde pode adicionar novos slides, remover slides ou arrastar para alterar a ordem.',
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
            array(
                'key' => 'field_testimonials_cards_heading',
                'label' => __( '💬 Gestão Dinâmica de Testemunhos (Arrastar, Adicionar e Remover)', 'pacto-25' ),
                'type' => 'message',
                'message' => 'Os cartões de testemunhos do carrossel são geridos na caixa <strong>"💬 Testemunhos de Clientes (Carrossel — Arrastar, Adicionar e Remover)"</strong> logo abaixo nesta página, onde pode adicionar novos testemunhos, remover existentes ou arrastar para alterar a ordem.',
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
                array(
                    'param' => 'page_template',
                    'operator' => '!=',
                    'value' => 'page-landing.php',
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
                'label' => __( 'Subtítulo (Eyebrow)', 'pacto-25' ),
                'name' => 'qs_reasons_eyebrow',
                'type' => 'text',
                'default_value' => 'SEGURAMENTE CONSIGO',
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
                'default_value' => 'Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Enim amet nullam dictumst dui amet.',
            ),
            array(
                'key' => 'field_qs_reasons_p2',
                'label' => __( 'Parágrafo 2', 'pacto-25' ),
                'name' => 'qs_reasons_p2',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Enim amet nullam dictumst dui amet.',
            ),
            array(
                'key' => 'field_qs_reasons_p3',
                'label' => __( 'Parágrafo 3', 'pacto-25' ),
                'name' => 'qs_reasons_p3',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Enim amet nullam dictumst dui amet.',
            ),
            array(
                'key' => 'field_qs_reasons_cards_native_notice',
                'label' => __( '⭐ Gestão Dinâmica dos Cartões (Arrastar, Adicionar e Remover)', 'pacto-25' ),
                'type' => 'message',
                'message' => 'Os cartões do carrossel no círculo vermelho são geridos na caixa <strong>"Quem Somos — Porque o fazemos?, Porquê escolher-nos & A Nossa Equipa (Arrastar, Adicionar e Remover)"</strong> logo abaixo (Aba 2), onde pode adicionar novos cartões, remover cartões existentes ou arrastar para alterar a ordem.',
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
            array(
                'key' => 'field_qs_team_native_notice',
                'label' => __( '👥 Gestão Dinâmica dos Membros da Equipa (Arrastar, Adicionar e Remover)', 'pacto-25' ),
                'type' => 'message',
                'message' => 'Os membros da equipa (fotos circulares, nomes e funções) são geridos na caixa <strong>"Quem Somos — Porque o fazemos?, Porquê escolher-nos & A Nossa Equipa (Arrastar, Adicionar e Remover)"</strong> logo abaixo (Aba 3), onde pode adicionar novos membros, remover ou arrastar para alterar a ordem.',
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

    $particulares_locations = array(
        array(
            array(
                'param'    => 'page_template',
                'operator' => '==',
                'value'    => 'page-particulares.php',
            ),
        ),
        array(
            array(
                'param'    => 'page',
                'operator' => '==',
                'value'    => 'particulares',
            ),
        ),
    );
    $part_page = get_page_by_path( 'particulares' );
    if ( $part_page ) {
        $particulares_locations[] = array(
            array(
                'param'    => 'page',
                'operator' => '==',
                'value'    => (string) $part_page->ID,
            ),
        );
    }

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
        'location' => $particulares_locations,
        'menu_order' => 2,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
    ) );

    // =========================================================================
    // FIELD GROUP: EMPRESAS
    // =========================================================================
    $empresas_locations = array(
        array(
            array(
                'param'    => 'page_template',
                'operator' => '==',
                'value'    => 'page-empresas.php',
            ),
        ),
        array(
            array(
                'param'    => 'page',
                'operator' => '==',
                'value'    => 'empresas',
            ),
        ),
        array(
            array(
                'param'    => 'page',
                'operator' => '==',
                'value'    => 'empresas-2',
            ),
        ),
    );

    $emp_pages = get_posts( array(
        'post_type'      => 'page',
        'posts_per_page' => -1,
        'post_status'    => 'any',
        'meta_key'       => '_wp_page_template',
        'meta_value'     => 'page-empresas.php',
        'fields'         => 'ids',
    ) );
    if ( ! empty( $emp_pages ) ) {
        foreach ( $emp_pages as $emp_id ) {
            $empresas_locations[] = array(
                array(
                    'param'    => 'page',
                    'operator' => '==',
                    'value'    => (string) $emp_id,
                ),
            );
        }
    }

    $emp_by_path_1 = get_page_by_path( 'empresas' );
    if ( $emp_by_path_1 ) {
        $empresas_locations[] = array(
            array(
                'param'    => 'page',
                'operator' => '==',
                'value'    => (string) $emp_by_path_1->ID,
            ),
        );
    }
    $emp_by_path_2 = get_page_by_path( 'empresas-2' );
    if ( $emp_by_path_2 ) {
        $empresas_locations[] = array(
            array(
                'param'    => 'page',
                'operator' => '==',
                'value'    => (string) $emp_by_path_2->ID,
            ),
        );
    }
    $emp_by_path_3 = get_page_by_path( 'seguros-empresas' );
    if ( $emp_by_path_3 ) {
        $empresas_locations[] = array(
            array(
                'param'    => 'page',
                'operator' => '==',
                'value'    => (string) $emp_by_path_3->ID,
            ),
        );
    }

    acf_add_local_field_group( array(
        'key' => 'group_pacto_empresas',
        'title' => __( 'Empresas - Configuração de Secções', 'pacto-25' ),
        'fields' => array(
            // --- TAB: HERO ---
            array(
                'key' => 'field_tab_empresas_hero',
                'label' => __( 'Secção 1: Hero', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_empresas_hero_eyebrow',
                'label' => __( 'Eyebrow / Subtítulo Superior', 'pacto-25' ),
                'name' => 'empresas_hero_eyebrow',
                'type' => 'text',
                'default_value' => 'EMPRESAS — PACTO SEGURO',
            ),
            array(
                'key' => 'field_empresas_hero_title',
                'label' => __( 'Título Principal (H1)', 'pacto-25' ),
                'name' => 'empresas_hero_title',
                'type' => 'text',
                'default_value' => 'Seguros para Empresas',
            ),
            array(
                'key' => 'field_empresas_hero_description',
                'label' => __( 'Texto Introdutório / Descrição', 'pacto-25' ),
                'name' => 'empresas_hero_description',
                'type' => 'textarea',
                'rows' => 4,
                'default_value' => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
            ),
            array(
                'key' => 'field_empresas_hero_image',
                'label' => __( 'Imagem do Hero (Empresas)', 'pacto-25' ),
                'name' => 'empresas_hero_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),

            // --- TAB: SEGUROS ---
            array(
                'key' => 'field_tab_empresas_seguros',
                'label' => __( 'Secção 2: Lista de Seguros', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_empresas_seguros_per_page',
                'label' => __( 'Seguros por Página', 'pacto-25' ),
                'name' => 'empresas_seguros_per_page',
                'type' => 'number',
                'default_value' => 8,
                'min' => 1,
                'max' => 40,
            ),

            // --- TAB: CTA ---
            array(
                'key' => 'field_tab_empresas_cta',
                'label' => __( 'Secção 3: Banner CTA', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_empresas_cta_eyebrow',
                'label' => __( 'Eyebrow', 'pacto-25' ),
                'name' => 'empresas_cta_eyebrow',
                'type' => 'text',
                'default_value' => 'EXPERIMENTE-NOS!',
            ),
            array(
                'key' => 'field_empresas_cta_title',
                'label' => __( 'Título Principal', 'pacto-25' ),
                'name' => 'empresas_cta_title',
                'type' => 'text',
                'default_value' => 'Temos uma equipa preparada para responder a todas as suas dúvidas.',
            ),
            array(
                'key' => 'field_empresas_cta_subtitle',
                'label' => __( 'Texto Descritivo', 'pacto-25' ),
                'name' => 'empresas_cta_subtitle',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => 'Convidamo-lo a partilhar as suas experiências para que possamos melhorar produtos e serviços. Faça-nos chegar a sua história.',
            ),
            array(
                'key' => 'field_empresas_cta_btn_text',
                'label' => __( 'Texto do Botão', 'pacto-25' ),
                'name' => 'empresas_cta_btn_text',
                'type' => 'text',
                'default_value' => 'pedir simulação',
            ),
            array(
                'key' => 'field_empresas_cta_btn_link',
                'label' => __( 'Link do Botão', 'pacto-25' ),
                'name' => 'empresas_cta_btn_link',
                'type' => 'text',
                'default_value' => '#contactos',
            ),
        ),
        'location' => $empresas_locations,
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
            array(
                'key' => 'field_seguro_features_cards_native_notice',
                'label' => __( 'Cartões no Círculo Vermelho (Carrossel Dinâmico)', 'pacto-25' ),
                'type' => 'message',
                'message' => __( '💡 <strong>Nota:</strong> Os cartões deste carrossel são geridos na caixa <strong>"⭐ Vantagens, Coberturas e Serviços (Carrossel no Círculo Vermelho — Arrastar, Adicionar e Remover)"</strong> mais abaixo nesta página. Lá pode adicionar, remover e reordenar cartões livremente.', 'pacto-25' ),
            ),

            // --- TAB: SECÇÃO 4 - PASSOS PARA SUBSCRIÇÃO ---
            array(
                'key' => 'field_tab_seguro_steps',
                'label' => __( 'Secção 4: Passos para Subscrição', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_seguro_steps_native_notice',
                'label' => __( 'Passos para Subscrição (Lista Dinâmica)', 'pacto-25' ),
                'type' => 'message',
                'message' => __( '💡 <strong>Nota:</strong> Os passos para subscrição (título, descrição e foto circular) são geridos na caixa <strong>"👣 Passos para Subscrição (Arrastar, Adicionar e Remover)"</strong> mais abaixo nesta página. Lá pode adicionar, remover e reordenar quantos passos desejar.', 'pacto-25' ),
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
                'key' => 'field_seguro_docs_native_notice',
                'label' => __( 'Lista de Documentos PDF (Lista Dinâmica)', 'pacto-25' ),
                'type' => 'message',
                'message' => __( '💡 <strong>Nota:</strong> Os ficheiros PDF são geridos na caixa <strong>"📄 Documentos Legais PDF (Arrastar, Adicionar e Remover)"</strong> mais abaixo nesta página.', 'pacto-25' ),
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
                'key' => 'field_seguro_faq_native_notice',
                'label' => __( 'Lista de Questões e Respostas (Lista Dinâmica)', 'pacto-25' ),
                'type' => 'message',
                'message' => __( '💡 <strong>Nota:</strong> As perguntas e respostas (FAQs) são geridas na caixa <strong>"❓ Questões Mais Frequentes — FAQs (Arrastar, Adicionar e Remover)"</strong> mais abaixo nesta página.', 'pacto-25' ),
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
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'seguro_empresa',
                ),
            ),
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-landing.php',
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
                'key' => 'field_sinistro_steps_native_notice',
                'label' => __( 'Passos / Checklist (Lista Dinâmica)', 'pacto-25' ),
                'type' => 'message',
                'message' => __( '💡 <strong>Nota:</strong> Os passos da checklist são geridos na caixa <strong>"📋 Em Caso de Sinistro — Passos & Documentos Necessários PDF (Arrastar, Adicionar e Remover)"</strong> mais abaixo nesta página.', 'pacto-25' ),
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
                'key' => 'field_sinistro_docs_native_notice',
                'label' => __( 'Lista de Documentos PDF (Lista Dinâmica)', 'pacto-25' ),
                'type' => 'message',
                'message' => __( '💡 <strong>Nota:</strong> Os ficheiros PDF são geridos na caixa <strong>"📋 Em Caso de Sinistro — Passos & Documentos Necessários PDF (Arrastar, Adicionar e Remover)"</strong> mais abaixo nesta página.', 'pacto-25' ),
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

    // =========================================================================
    // FIELD GROUP: PÁGINA CONTACTOS
    // =========================================================================
    acf_add_local_field_group( array(
        'key' => 'group_pacto_contactos',
        'title' => __( 'Página Contactos - Configuração', 'pacto-25' ),
        'fields' => array(
            // --- TAB: HERO ---
            array(
                'key' => 'field_tab_contactos_hero',
                'label' => __( 'Secção 1: Hero', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_contactos_hero_eyebrow',
                'label' => __( 'Eyebrow', 'pacto-25' ),
                'name' => 'contactos_hero_eyebrow',
                'type' => 'text',
                'default_value' => 'PACTO SEGURO',
            ),
            array(
                'key' => 'field_contactos_hero_title',
                'label' => __( 'Título Principal', 'pacto-25' ),
                'name' => 'contactos_hero_title',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => "Entre em Contacto\ncom a Pacto Seguro",
            ),
            array(
                'key' => 'field_contactos_hero_email',
                'label' => __( 'Email de Contacto', 'pacto-25' ),
                'name' => 'contactos_hero_email',
                'type' => 'email',
                'default_value' => 'teresa.sousa@pactoseguro.com',
            ),
            array(
                'key' => 'field_contactos_hero_phone',
                'label' => __( 'Número de Telefone', 'pacto-25' ),
                'name' => 'contactos_hero_phone',
                'type' => 'text',
                'default_value' => '229 039 777',
            ),
            array(
                'key' => 'field_contactos_hero_phone_note',
                'label' => __( 'Nota do Telefone', 'pacto-25' ),
                'name' => 'contactos_hero_phone_note',
                'type' => 'text',
                'default_value' => '(Chamada para a rede fixa nacional)',
            ),
            array(
                'key' => 'field_contactos_hero_address_1',
                'label' => __( 'Morada - Linha 1', 'pacto-25' ),
                'name' => 'contactos_hero_address_1',
                'type' => 'text',
                'default_value' => 'Rua José Coutinho 262,',
            ),
            array(
                'key' => 'field_contactos_hero_address_2',
                'label' => __( 'Morada - Linha 2 (Código Postal e Cidade)', 'pacto-25' ),
                'name' => 'contactos_hero_address_2',
                'type' => 'text',
                'default_value' => '4465-180 S. Mamede de Infesta, Matosinhos',
            ),
            array(
                'key' => 'field_contactos_hero_hours_1',
                'label' => __( 'Horário - Linha 1', 'pacto-25' ),
                'name' => 'contactos_hero_hours_1',
                'type' => 'text',
                'default_value' => 'Dias úteis das 09h00 às 12h30',
            ),
            array(
                'key' => 'field_contactos_hero_hours_2',
                'label' => __( 'Horário - Linha 2', 'pacto-25' ),
                'name' => 'contactos_hero_hours_2',
                'type' => 'text',
                'default_value' => 'e das 14h00 às 17h30',
            ),
            array(
                'key' => 'field_contactos_hero_image',
                'label' => __( 'Foto Circular do Hero', 'pacto-25' ),
                'instructions' => __( 'Foto da equipa/casal exibida no círculo à direita.', 'pacto-25' ),
                'name' => 'contactos_hero_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),

            // --- TAB: FALE CONNOSCO ---
            array(
                'key' => 'field_tab_contactos_form',
                'label' => __( 'Secção 2: Formulário', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_contactos_form_eyebrow',
                'label' => __( 'Eyebrow', 'pacto-25' ),
                'name' => 'contactos_form_eyebrow',
                'type' => 'text',
                'default_value' => 'FALE CONNOSCO',
            ),
            array(
                'key' => 'field_contactos_form_title',
                'label' => __( 'Título', 'pacto-25' ),
                'name' => 'contactos_form_title',
                'type' => 'text',
                'default_value' => 'Como podemos ajudar?',
            ),
            array(
                'key' => 'field_contactos_form_description',
                'label' => __( 'Descrição', 'pacto-25' ),
                'name' => 'contactos_form_description',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => 'Enim amet nullam dictumst dui amet, sit tellus morbi ut auctor.',
            ),
            array(
                'key' => 'field_contactos_form_image',
                'label' => __( 'Foto Circular com Anel Vermelho', 'pacto-25' ),
                'name' => 'contactos_form_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),

            // --- TAB: ONDE ESTAMOS ---
            array(
                'key' => 'field_tab_contactos_map',
                'label' => __( 'Secção 3: Mapa', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_contactos_map_eyebrow',
                'label' => __( 'Eyebrow', 'pacto-25' ),
                'name' => 'contactos_map_eyebrow',
                'type' => 'text',
                'default_value' => 'ONDE ESTAMOS',
            ),
            array(
                'key' => 'field_contactos_map_title',
                'label' => __( 'Título', 'pacto-25' ),
                'name' => 'contactos_map_title',
                'type' => 'text',
                'default_value' => 'Venha Visitar-nos',
            ),
            array(
                'key' => 'field_contactos_map_desc',
                'label' => __( 'Descrição', 'pacto-25' ),
                'name' => 'contactos_map_desc',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => 'As nossas instalações estão abertas ao público durante os dias úteis. Teremos todo o gosto em recebê-lo.',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-contactos.php',
                ),
            ),
            array(
                array(
                    'param' => 'page',
                    'operator' => '==',
                    'value' => 'contactos',
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
    // FIELD GROUP: PÁGINA PROTOCOLOS
    // =========================================================================
    acf_add_local_field_group( array(
        'key' => 'group_pacto_protocolos',
        'title' => __( 'Página Protocolos - Configuração de Secções', 'pacto-25' ),
        'fields' => array(
            // --- TAB: HERO ---
            array(
                'key' => 'field_tab_protocolos_hero',
                'label' => __( 'Secção 1: Hero', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_protocolos_hero_eyebrow',
                'label' => __( 'Eyebrow', 'pacto-25' ),
                'name' => 'protocolos_hero_eyebrow',
                'type' => 'text',
                'default_value' => 'PROTOCOLOS - PACTO SEGURO',
            ),
            array(
                'key' => 'field_protocolos_hero_title',
                'label' => __( 'Título Principal', 'pacto-25' ),
                'name' => 'protocolos_hero_title',
                'type' => 'text',
                'default_value' => 'Os Protocolos da Pacto Seguro',
            ),
            array(
                'key' => 'field_protocolos_hero_text',
                'label' => __( 'Texto Descritivo', 'pacto-25' ),
                'name' => 'protocolos_hero_text',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur.',
            ),
            array(
                'key' => 'field_protocolos_hero_image',
                'label' => __( 'Foto do Hero (PNG Transparente)', 'pacto-25' ),
                'instructions' => __( 'Foto da equipa/profissional exibida à direita no hero.', 'pacto-25' ),
                'name' => 'protocolos_hero_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),

            // --- TAB: CONDIÇÕES ESPECIAIS ---
            array(
                'key' => 'field_tab_protocolos_condicoes',
                'label' => __( 'Secção 2: Condições Especiais', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_protocolos_cond_eyebrow',
                'label' => __( 'Eyebrow', 'pacto-25' ),
                'name' => 'protocolos_cond_eyebrow',
                'type' => 'text',
                'default_value' => 'PROTOCOLOS COM ORDENS PROFISSIONAIS E ASSOCIAÇÕES',
            ),
            array(
                'key' => 'field_protocolos_cond_title',
                'label' => __( 'Título', 'pacto-25' ),
                'name' => 'protocolos_cond_title',
                'type' => 'text',
                'default_value' => 'Condições Especiais para Membros de Ordens e Associações',
            ),
            array(
                'key' => 'field_protocolos_cond_text',
                'label' => __( 'Texto Introdutório', 'pacto-25' ),
                'name' => 'protocolos_cond_text',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'A Pacto Seguro disponibiliza uma vasta oferta de Seguros com Protocolo a desenvolver em colaboração com as Ordens e Associações Profissionais, em particular:',
            ),
            array(
                'key' => 'field_protocolos_cond_native_notice',
                'label' => __( 'Lista de Ordens e Associações (Lista Dinâmica)', 'pacto-25' ),
                'type' => 'message',
                'message' => __( '💡 <strong>Nota:</strong> A lista de Ordens Profissionais e Associações é gerida na caixa <strong>"🏛️ Protocolos — Lista de Ordens/Associações & Vantagens (Arrastar, Adicionar e Remover)"</strong> mais abaixo nesta página.', 'pacto-25' ),
            ),
            array(
                'key' => 'field_protocolos_cond_btn_text',
                'label' => __( 'Texto do Botão', 'pacto-25' ),
                'name' => 'protocolos_cond_btn_text',
                'type' => 'text',
                'default_value' => 'falar com um especialista',
            ),
            array(
                'key' => 'field_protocolos_cond_btn_url',
                'label' => __( 'Link do Botão', 'pacto-25' ),
                'name' => 'protocolos_cond_btn_url',
                'type' => 'text',
                'default_value' => '/contactos/',
            ),
            array(
                'key' => 'field_protocolos_vantagens_title',
                'label' => __( 'Título do Círculo de Vantagens', 'pacto-25' ),
                'name' => 'protocolos_vantagens_title',
                'type' => 'text',
                'default_value' => 'Vantagens dos Protocolos',
            ),
            array(
                'key' => 'field_protocolos_vantagens_native_notice',
                'label' => __( 'Lista de Vantagens no Círculo Vermelho (Lista Dinâmica)', 'pacto-25' ),
                'type' => 'message',
                'message' => __( '💡 <strong>Nota:</strong> A lista de vantagens é gerida na caixa <strong>"🏛️ Protocolos — Lista de Ordens/Associações & Vantagens (Arrastar, Adicionar e Remover)"</strong> mais abaixo nesta página.', 'pacto-25' ),
            ),

            // --- TAB: FORMULÁRIO DE CONDIÇÕES ---
            array(
                'key' => 'field_tab_protocolos_faq',
                'label' => __( 'Secção 3: Formulário de Condições', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_protocolos_faq_eyebrow',
                'label' => __( 'Eyebrow', 'pacto-25' ),
                'name' => 'protocolos_faq_eyebrow',
                'type' => 'text',
                'default_value' => '• PROTOCOLOS • PACTO SEGURO',
            ),
            array(
                'key' => 'field_protocolos_faq_title',
                'label' => __( 'Título', 'pacto-25' ),
                'name' => 'protocolos_faq_title',
                'type' => 'text',
                'default_value' => 'Descubra as Condições Disponíveis para a Sua Profissão',
            ),
            array(
                'key' => 'field_protocolos_faq_text',
                'label' => __( 'Descrição', 'pacto-25' ),
                'name' => 'protocolos_faq_text',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Sit tellus morbi ut auctor dui amet.',
            ),
            array(
                'key' => 'field_protocolos_faq_image',
                'label' => __( 'Foto Circular (com Anel Vermelho)', 'pacto-25' ),
                'instructions' => __( 'Foto exibida no círculo à esquerda na secção de formulário.', 'pacto-25' ),
                'name' => 'protocolos_faq_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
            ),

            // --- TAB: CTA ---
            array(
                'key' => 'field_tab_protocolos_cta',
                'label' => __( 'Secção 4: Banner CTA', 'pacto-25' ),
                'type' => 'tab',
            ),
            array(
                'key' => 'field_protocolos_cta_eyebrow',
                'label' => __( 'Eyebrow', 'pacto-25' ),
                'name' => 'protocolos_cta_eyebrow',
                'type' => 'text',
                'default_value' => 'FALE COM UM DE NÓS',
            ),
            array(
                'key' => 'field_protocolos_cta_title',
                'label' => __( 'Título', 'pacto-25' ),
                'name' => 'protocolos_cta_title',
                'type' => 'text',
                'default_value' => 'Temos uma equipa preparada para responder a todas as suas dúvidas.',
            ),
            array(
                'key' => 'field_protocolos_cta_text',
                'label' => __( 'Descrição', 'pacto-25' ),
                'name' => 'protocolos_cta_text',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => 'Com décadas de experiência, os nossos consultores garantem um acompanhamento ágil e profissional.',
            ),
            array(
                'key' => 'field_protocolos_cta_btn_text',
                'label' => __( 'Texto do Botão', 'pacto-25' ),
                'name' => 'protocolos_cta_btn_text',
                'type' => 'text',
                'default_value' => 'Contacte-nos',
            ),
            array(
                'key' => 'field_protocolos_cta_btn_url',
                'label' => __( 'Link do Botão', 'pacto-25' ),
                'name' => 'protocolos_cta_btn_url',
                'type' => 'text',
                'default_value' => '/contactos/',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-protocolos.php',
                ),
            ),
            array(
                array(
                    'param' => 'page',
                    'operator' => '==',
                    'value' => '71',
                ),
            ),
            array(
                array(
                    'param' => 'page',
                    'operator' => '==',
                    'value' => 'protocolos',
                ),
            ),
        ),
        'menu_order' => 1,
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

