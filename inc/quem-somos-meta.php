<?php
/**
 * Native Meta Box for Quem Somos Page
 * Theme: Pacto 25
 * 
 * Strict Agency Standard:
 * - 100% Core WordPress APIs (add_meta_box, wp.media)
 * - Allows editing "Porque o fazemos?" and "A Nossa Equipa" (Team members, photos, roles) directly on the Quem Somos page
 * - Works seamlessly with or without ACF
 * - Synchronizes with ACF fields if ACF is active
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Helper to determine if the currently edited page is Quem Somos
 *
 * @param WP_Post $post
 * @return bool
 */
function pacto_is_quem_somos_admin( $post ) {
    if ( ! $post ) {
        return false;
    }

    if ( in_array( $post->post_type, array( 'seguro_particular', 'seguro_empresa' ), true ) ) {
        return true;
    }

    if ( 'page' === $post->post_type ) {
        $template = get_post_meta( $post->ID, '_wp_page_template', true );
        if ( in_array( $template, array( 'page-quem-somos.php', 'page-landing.php' ), true ) ) {
            return true;
        }

        $slug = $post->post_name;
        if ( in_array( $slug, array( 'quem-somos', 'institucional', 'sobre', 'landing', 'modelo-seguro' ), true ) ) {
            return true;
        }

        $title = mb_strtolower( trim( $post->post_title ) );
        if ( strpos( $title, 'quem somos' ) !== false || strpos( $title, 'institucional' ) !== false || strpos( $title, 'sobre' ) !== false ) {
            return true;
        }
    }

    return false;
}

/**
 * Register Quem Somos Meta Boxes
 */
function pacto_register_quem_somos_meta_box( $post_type = '', $post = null ) {
    if ( ! $post instanceof WP_Post ) {
        $current_id = isset( $_GET['post'] ) ? (int) $_GET['post'] : ( isset( $_POST['post_ID'] ) ? (int) $_POST['post_ID'] : 0 ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        if ( ! $current_id && isset( $GLOBALS['post'] ) && $GLOBALS['post'] instanceof WP_Post ) {
            $post = $GLOBALS['post'];
        } elseif ( $current_id ) {
            $post = get_post( $current_id );
        }
    }

    if ( ! $post || ! pacto_is_quem_somos_admin( $post ) ) {
        return;
    }

    $target_type = ! empty( $post->post_type ) ? $post->post_type : 'page';

    // Quem Somos Sections (Porque o fazemos & Equipa)
    if ( 'page' === $target_type ) {
        $template = get_post_meta( $post->ID, '_wp_page_template', true );
        if ( 'page-landing.php' === $template || in_array( $post->post_name, array( 'landing', 'modelo-seguro' ), true ) ) {
            add_meta_box(
                'pacto_reasons_slider_meta',
                __( '⭐ Vantagens, Coberturas e Serviços (Carrossel no Círculo Vermelho — Arrastar, Adicionar e Remover)', 'pacto-25' ),
                'pacto_render_reasons_standalone_meta_box',
                $target_type,
                'normal',
                'high'
            );
        } else {
            add_meta_box(
                'pacto_quem_somos_options_meta',
                __( 'Quem Somos — "Porque o fazemos?", "Porquê escolher-nos" & "A Nossa Equipa" (Arrastar, Adicionar e Remover)', 'pacto-25' ),
                'pacto_render_quem_somos_meta_box',
                $target_type,
                'normal',
                'high'
            );
        }
    } elseif ( in_array( $target_type, array( 'seguro_particular', 'seguro_empresa' ), true ) ) {
        add_meta_box(
            'pacto_reasons_slider_meta',
            __( '⭐ Vantagens, Coberturas e Serviços (Carrossel no Círculo Vermelho — Arrastar, Adicionar e Remover)', 'pacto-25' ),
            'pacto_render_reasons_standalone_meta_box',
            $target_type,
            'normal',
            'high'
        );
    }
}
add_action( 'add_meta_boxes', 'pacto_register_quem_somos_meta_box', 10, 2 );

/**
 * Enqueue Media Scripts on the Quem Somos edit screen
 */
function pacto_quem_somos_admin_scripts( $hook ) {
    if ( 'post.php' !== $hook && 'post-new.php' !== $hook ) {
        return;
    }

    $current_id = isset( $_GET['post'] ) ? (int) $_GET['post'] : ( isset( $_POST['post_ID'] ) ? (int) $_POST['post_ID'] : 0 ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
    if ( ! $current_id && isset( $GLOBALS['post'] ) && $GLOBALS['post'] instanceof WP_Post ) {
        $current_id = $GLOBALS['post']->ID;
    }

    if ( $current_id ) {
        $post = get_post( $current_id );
        if ( $post && ! pacto_is_quem_somos_admin( $post ) ) {
            return;
        }
    }

    wp_enqueue_media();
    wp_enqueue_script( 'jquery-ui-sortable' );
}
add_action( 'admin_enqueue_scripts', 'pacto_quem_somos_admin_scripts' );

/**
 * Render Quem Somos Meta Box
 */
function pacto_render_quem_somos_meta_box( $post ) {
    wp_nonce_field( 'pacto_quem_somos_meta_save', 'pacto_quem_somos_nonce' );

    // 1. Retrieve "Porque o fazemos?" values
    $why_image_val = pacto_get_field( 'qs_why_image', $post->ID, '' );
    $why_image_id  = 0;
    $why_image_url = '';

    if ( is_array( $why_image_val ) && ! empty( $why_image_val['ID'] ) ) {
        $why_image_id  = $why_image_val['ID'];
        $why_image_url = ! empty( $why_image_val['sizes']['medium'] ) ? $why_image_val['sizes']['medium'] : $why_image_val['url'];
    } elseif ( is_numeric( $why_image_val ) && (int) $why_image_val > 0 ) {
        $why_image_id  = (int) $why_image_val;
        $src           = wp_get_attachment_image_src( $why_image_id, 'medium' );
        $why_image_url = $src ? $src[0] : '';
    } elseif ( is_string( $why_image_val ) && ! empty( $why_image_val ) ) {
        $why_image_url = $why_image_val;
    }

    $why_default_fallback = get_template_directory_uri() . '/assets/images/quem-somos/qs-why-phone.png';
    $why_display_url      = ! empty( $why_image_url ) ? $why_image_url : $why_default_fallback;

    $why_eyebrow     = pacto_get_field( 'qs_why_eyebrow', $post->ID, 'PORQUE O FAZEMOS?' );
    $why_title       = pacto_get_field( 'qs_why_title', $post->ID, 'Porque o fazemos?' );
    $why_description = pacto_get_field( 'qs_why_description', $post->ID, 'Para provocar nas pessoas a responsabilidade e o sentido da melhor proteção das suas vidas e dos seus bens. Num mercado cada vez mais exigente, com um maior risco associado, entendemos sermos uma equipa multifacetada que acrescenta valor e credibilidade nas relações com os seus Clientes. Valorizamos as suas identidades, o seu negócio, o seu serviço com uma equipa especializada a cada caso. Trabalhamos sempre para prestar um serviço de alta qualidade com total independência e respeito por todos os intervenientes da relação.' );

    // 2. Retrieve "A Nossa Equipa" values
    $team_eyebrow = pacto_get_field( 'qs_team_eyebrow', $post->ID, 'A NOSSA EQUIPA' );
    $team_title   = pacto_get_field( 'qs_team_title', $post->ID, 'Profissionais dedicados ao seu lado' );

    $default_team = array(
        array(
            'name'  => 'Teresinha Pereira',
            'role'  => 'DIREÇÃO GERAL & MARKETING',
            'image' => '',
        ),
        array(
            'name'  => 'Nome Apelido',
            'role'  => 'FUNÇÃO & ÁREA',
            'image' => '',
        ),
        array(
            'name'  => 'Nome Apelido',
            'role'  => 'FUNÇÃO & ÁREA',
            'image' => '',
        ),
        array(
            'name'  => 'Nome Apelido',
            'role'  => 'FUNÇÃO & ÁREA',
            'image' => '',
        ),
    );

    $saved_team = pacto_get_field( 'qs_team_members', $post->ID, false );
    if ( ! is_array( $saved_team ) || empty( $saved_team ) ) {
        $saved_team = $default_team;
    }

    // 3. Retrieve "Porquê escolher-nos" values
    $reasons_eyebrow = pacto_get_field( 'qs_reasons_eyebrow', $post->ID, 'SEGURAMENTE CONSIGO' );
    $reasons_title   = pacto_get_field( 'qs_reasons_title', $post->ID, 'Porquê escolher-nos' );
    $reasons_p1      = pacto_get_field( 'qs_reasons_p1', $post->ID, 'Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Enim amet nullam dictumst dui amet.' );
    $reasons_p2      = pacto_get_field( 'qs_reasons_p2', $post->ID, 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Enim amet nullam dictumst dui amet.' );
    $reasons_p3      = pacto_get_field( 'qs_reasons_p3', $post->ID, 'Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Enim amet nullam dictumst dui amet.' );

    $default_cards = array(
        // Slide 1
        array(
            'icon'        => 'heart-check',
            'title'       => 'Simples e Fácil',
            'description' => 'Connosco pode subscrever um seguro rápido e sem complicações. Comunicamos de forma clara e objetiva.',
            'link'        => '',
        ),
        array(
            'icon'        => 'clock-check',
            'title'       => 'Rápidos',
            'description' => 'Simulamos e emitimos um seguro em menos de 10 minutos.',
            'link'        => '',
        ),
        array(
            'icon'        => 'heart-check',
            'title'       => 'Seguro à Medida',
            'description' => 'Adaptamos cada solução e cobertura às necessidades específicas da sua vida e da sua família.',
            'link'        => '',
        ),
        array(
            'icon'        => 'clock-check',
            'title'       => 'Confiança & Rigor',
            'description' => 'Mais de 25 anos de experiência e solidez no setor, com acompanhamento próximo em cada etapa.',
            'link'        => '',
        ),
        // Slide 2
        array(
            'icon'        => 'heart-check',
            'title'       => 'Transparência Total',
            'description' => 'Sem letras pequenas nem surpresas. Condições transparentes e rigorosas em todas as fases.',
            'link'        => '',
        ),
        array(
            'icon'        => 'clock-check',
            'title'       => 'Apoio Contínuo',
            'description' => 'Linha dedicada para esclarecimento de dúvidas e resolução ágil e proativa de sinistros.',
            'link'        => '',
        ),
        array(
            'icon'        => 'heart-check',
            'title'       => 'Soluções Integradas',
            'description' => 'Parcerias com as maiores seguradoras do mercado para garantir as melhores condições e garantias.',
            'link'        => '',
        ),
        array(
            'icon'        => 'clock-check',
            'title'       => 'Proximidade Humana',
            'description' => 'Uma equipa experiente sempre acessível e disponível para lhe dar total tranquilidade no dia a dia.',
            'link'        => '',
        ),
    );

    $saved_cards = pacto_get_field( 'qs_reasons_cards', $post->ID, false );
    if ( ! is_array( $saved_cards ) || empty( $saved_cards ) ) {
        $legacy_cards = array();
        $has_legacy   = false;
        for ( $i = 1; $i <= 8; $i++ ) {
            $c_title  = get_post_meta( $post->ID, "qs_card_{$i}_title", true );
            $c_desc   = get_post_meta( $post->ID, "qs_card_{$i}_desc", true );
            $c_icon   = get_post_meta( $post->ID, "qs_card_{$i}_icon", true );
            $c_custom = get_post_meta( $post->ID, "qs_card_{$i}_custom_icon", true );
            $c_link   = get_post_meta( $post->ID, "qs_card_{$i}_link", true );
            if ( ! empty( $c_title ) || ! empty( $c_desc ) ) {
                $has_legacy = true;
            }
            $def = isset( $default_cards[ $i - 1 ] ) ? $default_cards[ $i - 1 ] : array();
            $legacy_cards[] = array(
                'icon'        => ! empty( $c_icon ) ? $c_icon : ( isset( $def['icon'] ) ? $def['icon'] : 'heart-check' ),
                'custom_icon' => $c_custom,
                'title'       => ! empty( $c_title ) ? $c_title : ( isset( $def['title'] ) ? $def['title'] : "Cartão $i" ),
                'description' => ! empty( $c_desc ) ? $c_desc : ( isset( $def['description'] ) ? $def['description'] : '' ),
                'link'        => ! empty( $c_link ) ? $c_link : ( isset( $def['link'] ) ? $def['link'] : '' ),
            );
        }
        $saved_cards = $has_legacy ? $legacy_cards : $default_cards;
    }
    ?>
    <style>
        .pacto-qs-wrap { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif; margin: 6px 0; }
        
        /* Tabs Header */
        .pacto-qs-tabs-nav { display: flex; border-bottom: 2px solid #e2e8f0; margin-bottom: 24px; gap: 8px; flex-wrap: wrap; }
        .pacto-qs-tab-btn { background: none; border: none; padding: 12px 20px; font-size: 14px; font-weight: 600; color: #64748b; cursor: pointer; border-bottom: 3px solid transparent; margin-bottom: -2px; transition: all 0.2s ease; display: inline-flex; align-items: center; gap: 8px; }
        .pacto-qs-tab-btn:hover { color: #E84E38; }
        .pacto-qs-tab-btn.is-active { color: #E84E38; border-bottom-color: #E84E38; font-weight: 700; }
        
        /* Tab Panels */
        .pacto-qs-panel { display: none; }
        .pacto-qs-panel.is-active { display: block; }
        
        /* Why Section Grid */
        .pacto-qs-grid { display: grid; grid-template-columns: 240px 1fr; gap: 32px; align-items: start; }
        @media (max-width: 782px) { .pacto-qs-grid { grid-template-columns: 1fr; } }
        .pacto-qs-photo-col { text-align: center; background: #fafafa; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; }
        .pacto-qs-photo-preview { width: 140px; height: 140px; border-radius: 50%; border: 5px solid #E84E38; margin: 0 auto 16px; overflow: hidden; background: #fff; box-shadow: 0 4px 12px rgba(0,0,0,0.08); display: flex; align-items: center; justify-content: center; }
        .pacto-qs-photo-preview img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .pacto-qs-btn-group { display: flex; flex-direction: column; gap: 8px; }
        
        .pacto-qs-field-group { margin-bottom: 18px; }
        .pacto-qs-field-group label { display: block; font-weight: 600; font-size: 13px; margin-bottom: 6px; color: #1e293b; }
        .pacto-qs-field-group input[type="text"],
        .pacto-qs-field-group textarea { width: 100%; border: 1px solid #cbd5e1; border-radius: 6px; padding: 8px 12px; font-size: 14px; background: #fff; }
        .pacto-qs-field-group input[type="text"]:focus,
        .pacto-qs-field-group textarea:focus { border-color: #E84E38; outline: none; box-shadow: 0 0 0 2px rgba(232, 78, 56, 0.2); }
        .pacto-qs-tip { font-size: 12px; color: #64748b; margin-top: 4px; }

        /* Team Section UI */
        .pacto-team-intro { background: #f8fafc; border-left: 4px solid #E84E38; padding: 12px 16px; border-radius: 4px; margin-bottom: 24px; font-size: 13px; color: #334155; line-height: 1.5; }
        .pacto-team-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(240px, 1fr)); gap: 20px; margin-bottom: 24px; }
        .pacto-team-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 18px; text-align: center; position: relative; box-shadow: 0 2px 6px rgba(0,0,0,0.03); transition: box-shadow 0.2s ease, border-color 0.2s ease; }
        .pacto-team-card:hover { border-color: #cbd5e1; box-shadow: 0 6px 16px rgba(0,0,0,0.06); }
        
        .pacto-team-card__badge { position: absolute; top: 12px; left: 12px; background: #1e293b; color: #ffffff; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 12px; }
        .pacto-team-card__remove { position: absolute; top: 10px; right: 10px; background: transparent; border: none; color: #94a3b8; cursor: pointer; font-size: 16px; padding: 4px; border-radius: 4px; line-height: 1; }
        .pacto-team-card__remove:hover { color: #dc2626; background: #fee2e2; }
        
        .pacto-team-photo-wrap { width: 110px; height: 110px; border-radius: 50%; border: 4px solid #E84E38; margin: 12px auto 14px; overflow: hidden; background: #f1f5f9; box-shadow: 0 4px 10px rgba(0,0,0,0.08); display: flex; align-items: center; justify-content: center; }
        .pacto-team-photo-wrap img { width: 100%; height: 100%; object-fit: cover; display: block; }
        
        .pacto-team-card-actions { display: flex; justify-content: center; gap: 8px; margin-bottom: 14px; }
        .pacto-team-card-actions .button { font-size: 12px; height: 28px; line-height: 26px; padding: 0 10px; }
        
        .pacto-team-field { margin-bottom: 12px; text-align: left; }
        .pacto-team-field label { display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px; }
        .pacto-team-field input[type="text"] { width: 100%; border: 1px solid #cbd5e1; border-radius: 6px; padding: 6px 10px; font-size: 13px; }
        .pacto-team-field input[type="text"]:focus { border-color: #E84E38; outline: none; box-shadow: 0 0 0 2px rgba(232, 78, 56, 0.2); }
        .pacto-team-field-hint { font-size: 11px; color: #94a3b8; margin-top: 3px; }
        
        .pacto-team-bottom-bar { display: flex; justify-content: space-between; align-items: center; padding-top: 12px; border-top: 1px dashed #cbd5e1; }

        /* Reasons Section UI */
        .pacto-reasons-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 32px; align-items: start; }
        @media (max-width: 900px) { .pacto-reasons-grid { grid-template-columns: 1fr; } }
        .pacto-reasons-cards-list { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 18px; }
        @media (max-width: 600px) { .pacto-reasons-cards-list { grid-template-columns: 1fr; } }
        .pacto-reasons-card-item { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px; position: relative; box-shadow: 0 2px 6px rgba(0,0,0,0.03); }
        .pacto-reasons-card-item:hover { border-color: #cbd5e1; }
        .pacto-reasons-card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
        .pacto-reasons-card-badge { background: #E84E38; color: #fff; font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 12px; }
        .pacto-reasons-card-remove { background: transparent; border: none; color: #94a3b8; cursor: pointer; font-size: 18px; line-height: 1; padding: 2px 6px; border-radius: 4px; }
        .pacto-reasons-card-remove:hover { color: #dc2626; background: #fee2e2; }
    </style>

    <div class="pacto-qs-wrap">
        <!-- Tab Navigation -->
        <div class="pacto-qs-tabs-nav" role="tablist">
            <button type="button" class="pacto-qs-tab-btn is-active" data-tab="tab-why">
                <span class="dashicons dashicons-format-image"></span>
                <?php esc_html_e( '1. "Porque o fazemos?" (Foto e Texto)', 'pacto-25' ); ?>
            </button>
            <button type="button" class="pacto-qs-tab-btn" data-tab="tab-reasons">
                <span class="dashicons dashicons-star-filled"></span>
                <?php esc_html_e( '2. "Porquê escolher-nos" (Narrativa e Cartões)', 'pacto-25' ); ?>
            </button>
            <button type="button" class="pacto-qs-tab-btn" data-tab="tab-team">
                <span class="dashicons dashicons-groups"></span>
                <?php esc_html_e( '3. "A Nossa Equipa" (Membros e Funções)', 'pacto-25' ); ?>
            </button>
        </div>

        <!-- ========================================== -->
        <!-- TAB 1: PORQUE O FAZEMOS?                   -->
        <!-- ========================================== -->
        <div class="pacto-qs-panel is-active" id="tab-why">
            <div class="pacto-qs-grid">
                <!-- Left: Circular Photo Uploader -->
                <div class="pacto-qs-photo-col">
                    <label style="display:block; font-weight:700; margin-bottom:12px; font-size:14px; color:#0f172a;">
                        <?php esc_html_e( 'Foto "Porque o fazemos?"', 'pacto-25' ); ?>
                    </label>
                    <div class="pacto-qs-photo-preview" id="qs-why-preview">
                        <img src="<?php echo esc_url( $why_display_url ); ?>" alt="<?php esc_attr_e( 'Foto circular Porque o fazemos', 'pacto-25' ); ?>" />
                    </div>

                    <input type="hidden" id="qs_why_image" name="qs_why_image" value="<?php echo esc_attr( $why_image_id ? $why_image_id : $why_image_url ); ?>" />

                    <div class="pacto-qs-btn-group">
                        <button type="button" class="button button-primary pacto-single-upload-btn" data-target="qs_why_image" data-preview="qs-why-preview" data-remove="qs-why-remove-btn" data-title="<?php esc_attr_e( 'Selecionar Imagem para Porque o Fazemos', 'pacto-25' ); ?>">
                            <?php esc_html_e( 'Selecionar / Alterar Imagem', 'pacto-25' ); ?>
                        </button>
                        <button type="button" class="button button-link-delete pacto-single-remove-btn" id="qs-why-remove-btn" data-target="qs_why_image" data-preview="qs-why-preview" data-default="<?php echo esc_url( $why_default_fallback ); ?>" style="<?php echo empty( $why_image_url ) ? 'display:none;' : ''; ?>">
                            <?php esc_html_e( 'Restaurar Imagem Padrão', 'pacto-25' ); ?>
                        </button>
                    </div>
                    <p class="pacto-qs-tip"><?php esc_html_e( 'A imagem será recortada no círculo com anel vermelho.', 'pacto-25' ); ?></p>
                </div>

                <!-- Right: Section Texts -->
                <div class="pacto-qs-content-col">
                    <div class="pacto-qs-field-group">
                        <label for="qs_why_eyebrow"><?php esc_html_e( 'Subtítulo (Eyebrow)', 'pacto-25' ); ?></label>
                        <input type="text" id="qs_why_eyebrow" name="qs_why_eyebrow" value="<?php echo esc_attr( $why_eyebrow ); ?>" />
                    </div>

                    <div class="pacto-qs-field-group">
                        <label for="qs_why_title"><?php esc_html_e( 'Título da Secção', 'pacto-25' ); ?></label>
                        <input type="text" id="qs_why_title" name="qs_why_title" value="<?php echo esc_attr( $why_title ); ?>" />
                    </div>

                    <div class="pacto-qs-field-group">
                        <label for="qs_why_description"><?php esc_html_e( 'Texto Descritivo', 'pacto-25' ); ?></label>
                        <textarea id="qs_why_description" name="qs_why_description" rows="5"><?php echo esc_textarea( $why_description ); ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- TAB 2: A NOSSA EQUIPA (MEMBROS)            -->
        <!-- ========================================== -->
        <div class="pacto-qs-panel" id="tab-team">
            <div class="pacto-team-intro">
                <strong><?php esc_html_e( 'Constelação Visual da Equipa:', 'pacto-25' ); ?></strong>
                <?php esc_html_e( 'Edite aqui as fotos circulares, nomes e cargos dos profissionais da equipa. As fotos são automaticamente adaptadas ao formato circular com sombra e micro-interação.', 'pacto-25' ); ?>
            </div>

            <div class="pacto-team-grid" id="pacto-team-items-wrap">
                <?php foreach ( $saved_team as $i => $member ) : 
                    $m_name  = isset( $member['name'] ) ? $member['name'] : '';
                    $m_role  = isset( $member['role'] ) ? $member['role'] : '';
                    $m_img   = isset( $member['image'] ) ? $member['image'] : '';

                    // Resolve image preview URL
                    $fallback_num = ( $i % 4 ) + 1;
                    $fallback_img = get_template_directory_uri() . '/assets/images/quem-somos/qs-team-' . $fallback_num . '.png';
                    
                    $preview_src = $fallback_img;
                    if ( is_numeric( $m_img ) && (int) $m_img > 0 ) {
                        $src_arr = wp_get_attachment_image_src( (int) $m_img, 'medium' );
                        if ( $src_arr ) {
                            $preview_src = $src_arr[0];
                        }
                    } elseif ( is_string( $m_img ) && ! empty( $m_img ) ) {
                        $preview_src = $m_img;
                    }

                    $has_custom_img = ! empty( $m_img );
                ?>
                    <div class="pacto-team-card" data-index="<?php echo esc_attr( $i ); ?>">
                        <span class="pacto-team-card__badge" style="cursor:grab;" title="<?php esc_attr_e( 'Arrastar para reordenar', 'pacto-25' ); ?>">☰ <?php echo esc_html( sprintf( __( 'Membro #%d', 'pacto-25' ), $i + 1 ) ); ?></span>
                        
                        <button type="button" class="pacto-team-card__remove pacto-btn-delete-member" title="<?php esc_attr_e( 'Remover membro', 'pacto-25' ); ?>">
                            &times;
                        </button>

                        <!-- Member Photo Preview -->
                        <div class="pacto-team-photo-wrap" id="qs-team-preview-<?php echo esc_attr( $i ); ?>">
                            <img src="<?php echo esc_url( $preview_src ); ?>" alt="" />
                        </div>

                        <!-- Image Buttons -->
                        <input type="hidden" id="qs_team_img_<?php echo esc_attr( $i ); ?>" name="qs_team_members[<?php echo esc_attr( $i ); ?>][image]" value="<?php echo esc_attr( $m_img ); ?>" />
                        
                        <div class="pacto-team-card-actions">
                            <button type="button" class="button pacto-team-upload-btn" data-target="qs_team_img_<?php echo esc_attr( $i ); ?>" data-preview="qs-team-preview-<?php echo esc_attr( $i ); ?>" data-remove="qs-team-remove-<?php echo esc_attr( $i ); ?>">
                                <?php esc_html_e( 'Alterar Foto', 'pacto-25' ); ?>
                            </button>
                            <button type="button" class="button button-link-delete pacto-team-remove-btn" id="qs-team-remove-<?php echo esc_attr( $i ); ?>" data-target="qs_team_img_<?php echo esc_attr( $i ); ?>" data-preview="qs-team-preview-<?php echo esc_attr( $i ); ?>" data-default="<?php echo esc_url( $fallback_img ); ?>" style="<?php echo ! $has_custom_img ? 'display:none;' : ''; ?>">
                                <?php esc_html_e( 'Restaurar', 'pacto-25' ); ?>
                            </button>
                        </div>

                        <!-- Name Field -->
                        <div class="pacto-team-field">
                            <label for="qs_team_name_<?php echo esc_attr( $i ); ?>"><?php esc_html_e( 'Nome Completo', 'pacto-25' ); ?></label>
                            <input type="text" id="qs_team_name_<?php echo esc_attr( $i ); ?>" name="qs_team_members[<?php echo esc_attr( $i ); ?>][name]" value="<?php echo esc_attr( $m_name ); ?>" placeholder="<?php esc_attr_e( 'Ex: Teresinha Pereira', 'pacto-25' ); ?>" />
                        </div>

                        <!-- Role Field -->
                        <div class="pacto-team-field">
                            <label for="qs_team_role_<?php echo esc_attr( $i ); ?>"><?php esc_html_e( 'Cargo / Função', 'pacto-25' ); ?></label>
                            <input type="text" id="qs_team_role_<?php echo esc_attr( $i ); ?>" name="qs_team_members[<?php echo esc_attr( $i ); ?>][role]" value="<?php echo esc_attr( $m_role ); ?>" placeholder="<?php esc_attr_e( 'Ex: DIREÇÃO GERAL & MARKETING', 'pacto-25' ); ?>" />
                            <div class="pacto-team-field-hint"><?php esc_html_e( '* O ponto vermelho (•) é adicionado automaticamente.', 'pacto-25' ); ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="pacto-team-bottom-bar">
                <button type="button" class="button button-secondary" id="pacto-btn-add-member">
                    <span class="dashicons dashicons-plus-alt2" style="vertical-align: middle; margin-top:-2px;"></span>
                    <?php esc_html_e( 'Adicionar Outro Membro à Equipa', 'pacto-25' ); ?>
                </button>
                <span class="pacto-qs-tip"><?php esc_html_e( 'Lembre-se de clicar em "Actualizar" no canto superior direito para guardar as alterações.', 'pacto-25' ); ?></span>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- TAB 2: PORQUÊ ESCOLHER-NOS                 -->
        <!-- ========================================== -->
        <div class="pacto-qs-panel" id="tab-reasons">
            <div class="pacto-team-intro">
                <strong><?php esc_html_e( 'Porquê escolher-nos:', 'pacto-25' ); ?></strong>
                <?php esc_html_e( 'Edite aqui a narrativa do lado esquerdo (subtítulo, título e parágrafos) e os cartões com ícones exibidos dentro do grande círculo vermelho.', 'pacto-25' ); ?>
            </div>

            <div class="pacto-reasons-grid">
                <!-- Coluna Esquerda: Narrativa -->
                <div class="pacto-reasons-narrative-col">
                    <h4 style="margin: 0 0 16px; font-size: 14px; font-weight: 700; color: #1e293b; border-bottom: 2px solid #f1f5f9; padding-bottom: 8px;">
                        <?php esc_html_e( 'Narrativa (Lado Esquerdo)', 'pacto-25' ); ?>
                    </h4>

                    <div class="pacto-qs-field-group">
                        <label for="qs_reasons_eyebrow"><?php esc_html_e( 'Subtítulo (Eyebrow)', 'pacto-25' ); ?></label>
                        <input type="text" id="qs_reasons_eyebrow" name="qs_reasons_eyebrow" value="<?php echo esc_attr( $reasons_eyebrow ); ?>" />
                        <div class="pacto-qs-tip"><?php esc_html_e( 'Ex: SEGURAMENTE CONSIGO', 'pacto-25' ); ?></div>
                    </div>

                    <div class="pacto-qs-field-group">
                        <label for="qs_reasons_title"><?php esc_html_e( 'Título Principal', 'pacto-25' ); ?></label>
                        <input type="text" id="qs_reasons_title" name="qs_reasons_title" value="<?php echo esc_attr( $reasons_title ); ?>" />
                    </div>

                    <div class="pacto-qs-field-group">
                        <label for="qs_reasons_p1"><?php esc_html_e( 'Parágrafo 1', 'pacto-25' ); ?></label>
                        <textarea id="qs_reasons_p1" name="qs_reasons_p1" rows="3"><?php echo esc_textarea( $reasons_p1 ); ?></textarea>
                    </div>

                    <div class="pacto-qs-field-group">
                        <label for="qs_reasons_p2"><?php esc_html_e( 'Parágrafo 2', 'pacto-25' ); ?></label>
                        <textarea id="qs_reasons_p2" name="qs_reasons_p2" rows="3"><?php echo esc_textarea( $reasons_p2 ); ?></textarea>
                    </div>

                    <div class="pacto-qs-field-group">
                        <label for="qs_reasons_p3"><?php esc_html_e( 'Parágrafo 3', 'pacto-25' ); ?></label>
                        <textarea id="qs_reasons_p3" name="qs_reasons_p3" rows="3"><?php echo esc_textarea( $reasons_p3 ); ?></textarea>
                    </div>
                </div>

                <!-- Coluna Direita: Cartões no Círculo Vermelho -->
                <div class="pacto-reasons-cards-col">
                    <h4 style="margin: 0 0 16px; font-size: 14px; font-weight: 700; color: #1e293b; border-bottom: 2px solid #f1f5f9; padding-bottom: 8px;">
                        <?php esc_html_e( 'Cartões no Círculo Vermelho (Lado Direito)', 'pacto-25' ); ?>
                    </h4>

                    <div class="pacto-reasons-cards-list" id="pacto-reasons-cards-wrap">
                        <?php foreach ( $saved_cards as $c_idx => $card ) : 
                            $c_icon   = isset( $card['icon'] ) ? $card['icon'] : 'heart-check';
                            $c_custom = isset( $card['custom_icon'] ) ? $card['custom_icon'] : '';
                            $c_title  = isset( $card['title'] ) ? $card['title'] : '';
                            $c_desc   = isset( $card['description'] ) ? $card['description'] : '';
                            $c_link   = isset( $card['link'] ) ? $card['link'] : '';

                            $c_custom_src = '';
                            if ( is_numeric( $c_custom ) && (int) $c_custom > 0 ) {
                                $src_arr = wp_get_attachment_image_src( (int) $c_custom, 'thumbnail' );
                                if ( $src_arr ) {
                                    $c_custom_src = $src_arr[0];
                                }
                            } elseif ( is_string( $c_custom ) && ! empty( $c_custom ) ) {
                                $c_custom_src = $c_custom;
                            }
                        ?>
                            <div class="pacto-reasons-card-item" data-index="<?php echo esc_attr( $c_idx ); ?>">
                                <div class="pacto-reasons-card-header">
                                    <span class="pacto-reasons-card-badge"><?php echo esc_html( sprintf( __( 'Cartão #%d', 'pacto-25' ), $c_idx + 1 ) ); ?></span>
                                    <button type="button" class="pacto-reasons-card-remove pacto-btn-delete-card" title="<?php esc_attr_e( 'Remover cartão', 'pacto-25' ); ?>">&times;</button>
                                </div>

                                <div class="pacto-qs-field-group" style="margin-bottom: 10px;">
                                    <label for="qs_card_icon_<?php echo esc_attr( $c_idx ); ?>"><?php esc_html_e( 'Ícone Predefinido (SVG)', 'pacto-25' ); ?></label>
                                    <select id="qs_card_icon_<?php echo esc_attr( $c_idx ); ?>" name="qs_reasons_cards[<?php echo esc_attr( $c_idx ); ?>][icon]" style="width: 100%; border: 1px solid #cbd5e1; border-radius: 6px; padding: 6px 10px; font-size: 13px;">
                                        <option value="heart-check" <?php selected( $c_icon, 'heart-check' ); ?>><?php esc_html_e( '❤️ Coração com Check (Simples e Fácil)', 'pacto-25' ); ?></option>
                                        <option value="clock-check" <?php selected( $c_icon, 'clock-check' ); ?>><?php esc_html_e( '⏱️ Velocímetro / Relógio (Rápidos)', 'pacto-25' ); ?></option>
                                        <option value="shield-check" <?php selected( $c_icon, 'shield-check' ); ?>><?php esc_html_e( '🛡️ Escudo de Proteção', 'pacto-25' ); ?></option>
                                        <option value="users-check" <?php selected( $c_icon, 'users-check' ); ?>><?php esc_html_e( '👥 Equipa / Pessoas', 'pacto-25' ); ?></option>
                                    </select>
                                </div>

                                <div class="pacto-qs-field-group" style="margin-bottom: 10px;">
                                    <label><?php esc_html_e( 'Ou Carregar Ícone Personalizado (SVG / Imagem)', 'pacto-25' ); ?></label>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <input type="hidden" id="qs_card_custom_<?php echo esc_attr( $c_idx ); ?>" name="qs_reasons_cards[<?php echo esc_attr( $c_idx ); ?>][custom_icon]" value="<?php echo esc_attr( $c_custom ); ?>" />
                                        <div id="qs_card_custom_preview_<?php echo esc_attr( $c_idx ); ?>" style="width: 36px; height: 36px; border: 1px solid #cbd5e1; border-radius: 6px; display: flex; align-items: center; justify-content: center; background: #f8fafc; overflow: hidden; padding: 2px;">
                                            <?php if ( ! empty( $c_custom_src ) ) : ?>
                                                <img src="<?php echo esc_url( $c_custom_src ); ?>" alt="" style="max-width:100%; max-height:100%; object-fit:contain;" />
                                            <?php else : ?>
                                                <span class="dashicons dashicons-format-image" style="color: #94a3b8; font-size: 18px; width: 18px; height: 18px;"></span>
                                            <?php endif; ?>
                                        </div>
                                        <button type="button" class="button pacto-card-upload-btn" data-target="qs_card_custom_<?php echo esc_attr( $c_idx ); ?>" data-preview="qs_card_custom_preview_<?php echo esc_attr( $c_idx ); ?>" data-remove="qs_card_custom_remove_<?php echo esc_attr( $c_idx ); ?>"><?php esc_html_e( 'Carregar Ícone', 'pacto-25' ); ?></button>
                                        <button type="button" class="button button-link-delete pacto-card-remove-btn" id="qs_card_custom_remove_<?php echo esc_attr( $c_idx ); ?>" data-target="qs_card_custom_<?php echo esc_attr( $c_idx ); ?>" data-preview="qs_card_custom_preview_<?php echo esc_attr( $c_idx ); ?>" style="<?php echo empty( $c_custom ) ? 'display:none;' : ''; ?>"><?php esc_html_e( 'Remover', 'pacto-25' ); ?></button>
                                    </div>
                                    <div class="pacto-qs-tip"><?php esc_html_e( 'Se carregar um ficheiro, este substitui o ícone predefinido.', 'pacto-25' ); ?></div>
                                </div>

                                <div class="pacto-qs-field-group" style="margin-bottom: 10px;">
                                    <label for="qs_card_title_<?php echo esc_attr( $c_idx ); ?>"><?php esc_html_e( 'Título do Cartão', 'pacto-25' ); ?></label>
                                    <input type="text" id="qs_card_title_<?php echo esc_attr( $c_idx ); ?>" name="qs_reasons_cards[<?php echo esc_attr( $c_idx ); ?>][title]" value="<?php echo esc_attr( $c_title ); ?>" placeholder="<?php esc_attr_e( 'Ex: Simples e Fácil', 'pacto-25' ); ?>" />
                                </div>

                                <div class="pacto-qs-field-group" style="margin-bottom: 10px;">
                                    <label for="qs_card_desc_<?php echo esc_attr( $c_idx ); ?>"><?php esc_html_e( 'Descrição do Cartão', 'pacto-25' ); ?></label>
                                    <textarea id="qs_card_desc_<?php echo esc_attr( $c_idx ); ?>" name="qs_reasons_cards[<?php echo esc_attr( $c_idx ); ?>][description]" rows="2" placeholder="<?php esc_attr_e( 'Texto descritivo do cartão...', 'pacto-25' ); ?>"><?php echo esc_textarea( $c_desc ); ?></textarea>
                                </div>

                                <div class="pacto-qs-field-group" style="margin-bottom: 0;">
                                    <label for="qs_card_link_<?php echo esc_attr( $c_idx ); ?>"><?php esc_html_e( 'Link / URL de Destino (Opcional)', 'pacto-25' ); ?></label>
                                    <input type="text" id="qs_card_link_<?php echo esc_attr( $c_idx ); ?>" name="qs_reasons_cards[<?php echo esc_attr( $c_idx ); ?>][link]" value="<?php echo esc_attr( $c_link ); ?>" placeholder="<?php esc_attr_e( 'Ex: /particulares/ ou https://...', 'pacto-25' ); ?>" />
                                    <div class="pacto-qs-tip"><?php esc_html_e( 'Se preenchido, torna o cartão clicável com link direto.', 'pacto-25' ); ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div style="padding-top: 12px; border-top: 1px dashed #cbd5e1;">
                        <button type="button" class="button button-secondary" id="pacto-btn-add-card">
                            <span class="dashicons dashicons-plus-alt2" style="vertical-align: middle; margin-top:-2px;"></span>
                            <?php esc_html_e( 'Adicionar Outro Cartão', 'pacto-25' ); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden Template for Dynamic Reasons Card Adding -->
    <template id="pacto-reasons-card-template">
        <div class="pacto-reasons-card-item" data-index="__INDEX__">
            <div class="pacto-reasons-card-header">
                <span class="pacto-reasons-card-badge"><?php esc_html_e( 'Cartão #__NUM__', 'pacto-25' ); ?></span>
                <button type="button" class="pacto-reasons-card-remove pacto-btn-delete-card" title="<?php esc_attr_e( 'Remover cartão', 'pacto-25' ); ?>">&times;</button>
            </div>

            <div class="pacto-qs-field-group" style="margin-bottom: 10px;">
                <label for="qs_card_icon___INDEX__"><?php esc_html_e( 'Ícone Predefinido (SVG)', 'pacto-25' ); ?></label>
                <select id="qs_card_icon___INDEX__" name="qs_reasons_cards[__INDEX__][icon]" style="width: 100%; border: 1px solid #cbd5e1; border-radius: 6px; padding: 6px 10px; font-size: 13px;">
                    <option value="heart-check"><?php esc_html_e( '❤️ Coração com Check (Simples e Fácil)', 'pacto-25' ); ?></option>
                    <option value="clock-check"><?php esc_html_e( '⏱️ Velocímetro / Relógio (Rápidos)', 'pacto-25' ); ?></option>
                    <option value="shield-check"><?php esc_html_e( '🛡️ Escudo de Proteção', 'pacto-25' ); ?></option>
                    <option value="users-check"><?php esc_html_e( '👥 Equipa / Pessoas', 'pacto-25' ); ?></option>
                </select>
            </div>

            <div class="pacto-qs-field-group" style="margin-bottom: 10px;">
                <label><?php esc_html_e( 'Ou Carregar Ícone Personalizado (SVG / Imagem)', 'pacto-25' ); ?></label>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <input type="hidden" id="qs_card_custom___INDEX__" name="qs_reasons_cards[__INDEX__][custom_icon]" value="" />
                    <div id="qs_card_custom_preview___INDEX__" style="width: 36px; height: 36px; border: 1px solid #cbd5e1; border-radius: 6px; display: flex; align-items: center; justify-content: center; background: #f8fafc; overflow: hidden; padding: 2px;">
                        <span class="dashicons dashicons-format-image" style="color: #94a3b8; font-size: 18px; width: 18px; height: 18px;"></span>
                    </div>
                    <button type="button" class="button pacto-card-upload-btn" data-target="qs_card_custom___INDEX__" data-preview="qs_card_custom_preview___INDEX__" data-remove="qs_card_custom_remove___INDEX__"><?php esc_html_e( 'Carregar Ícone', 'pacto-25' ); ?></button>
                    <button type="button" class="button button-link-delete pacto-card-remove-btn" id="qs_card_custom_remove___INDEX__" data-target="qs_card_custom___INDEX__" data-preview="qs_card_custom_preview___INDEX__" style="display:none;"><?php esc_html_e( 'Remover', 'pacto-25' ); ?></button>
                </div>
            </div>

            <div class="pacto-qs-field-group" style="margin-bottom: 10px;">
                <label for="qs_card_title___INDEX__"><?php esc_html_e( 'Título do Cartão', 'pacto-25' ); ?></label>
                <input type="text" id="qs_card_title___INDEX__" name="qs_reasons_cards[__INDEX__][title]" value="" placeholder="<?php esc_attr_e( 'Ex: Simples e Fácil', 'pacto-25' ); ?>" />
            </div>

            <div class="pacto-qs-field-group" style="margin-bottom: 10px;">
                <label for="qs_card_desc___INDEX__"><?php esc_html_e( 'Descrição do Cartão', 'pacto-25' ); ?></label>
                <textarea id="qs_card_desc___INDEX__" name="qs_reasons_cards[__INDEX__][description]" rows="2" placeholder="<?php esc_attr_e( 'Texto descritivo do cartão...', 'pacto-25' ); ?>"></textarea>
            </div>

            <div class="pacto-qs-field-group" style="margin-bottom: 0;">
                <label for="qs_card_link___INDEX__"><?php esc_html_e( 'Link / URL de Destino (Opcional)', 'pacto-25' ); ?></label>
                <input type="text" id="qs_card_link___INDEX__" name="qs_reasons_cards[__INDEX__][link]" value="" placeholder="<?php esc_attr_e( 'Ex: /particulares/ ou https://...', 'pacto-25' ); ?>" />
            </div>
        </div>
    </template>

    <!-- Hidden Template for Dynamic Member Adding -->
    <template id="pacto-team-member-template">
        <div class="pacto-team-card" data-index="__INDEX__">
            <span class="pacto-team-card__badge"><?php esc_html_e( 'Membro #__NUM__', 'pacto-25' ); ?></span>
            <button type="button" class="pacto-team-card__remove pacto-btn-delete-member" title="<?php esc_attr_e( 'Remover membro', 'pacto-25' ); ?>">
                &times;
            </button>

            <div class="pacto-team-photo-wrap" id="qs-team-preview-__INDEX__">
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/quem-somos/qs-team-1.png' ); ?>" alt="" />
            </div>

            <input type="hidden" id="qs_team_img___INDEX__" name="qs_team_members[__INDEX__][image]" value="" />
            
            <div class="pacto-team-card-actions">
                <button type="button" class="button pacto-team-upload-btn" data-target="qs_team_img___INDEX__" data-preview="qs-team-preview-__INDEX__" data-remove="qs-team-remove-__INDEX__">
                    <?php esc_html_e( 'Alterar Foto', 'pacto-25' ); ?>
                </button>
                <button type="button" class="button button-link-delete pacto-team-remove-btn" id="qs-team-remove-__INDEX__" data-target="qs_team_img___INDEX__" data-preview="qs-team-preview-__INDEX__" data-default="<?php echo esc_url( get_template_directory_uri() . '/assets/images/quem-somos/qs-team-1.png' ); ?>" style="display:none;">
                    <?php esc_html_e( 'Restaurar', 'pacto-25' ); ?>
                </button>
            </div>

            <div class="pacto-team-field">
                <label for="qs_team_name___INDEX__"><?php esc_html_e( 'Nome Completo', 'pacto-25' ); ?></label>
                <input type="text" id="qs_team_name___INDEX__" name="qs_team_members[__INDEX__][name]" value="" placeholder="<?php esc_attr_e( 'Ex: Nome Apelido', 'pacto-25' ); ?>" />
            </div>

            <div class="pacto-team-field">
                <label for="qs_team_role___INDEX__"><?php esc_html_e( 'Cargo / Função', 'pacto-25' ); ?></label>
                <input type="text" id="qs_team_role___INDEX__" name="qs_team_members[__INDEX__][role]" value="" placeholder="<?php esc_attr_e( 'Ex: FUNÇÃO & ÁREA', 'pacto-25' ); ?>" />
                <div class="pacto-team-field-hint"><?php esc_html_e( '* O ponto vermelho (•) é adicionado automaticamente.', 'pacto-25' ); ?></div>
            </div>
        </div>
    </template>

    <script>
    jQuery(document).ready(function($) {
        // 1. Tab Switching
        $('.pacto-qs-tab-btn').on('click', function(e) {
            e.preventDefault();
            var targetTab = $(this).data('tab');
            
            $('.pacto-qs-tab-btn').removeClass('is-active');
            $(this).addClass('is-active');

            $('.pacto-qs-panel').removeClass('is-active');
            $('#' + targetTab).addClass('is-active');

            if (window.sessionStorage) {
                sessionStorage.setItem('pacto_qs_active_tab', targetTab);
            }
        });

        // Restore active tab if previously set
        if (window.sessionStorage) {
            var activeTab = sessionStorage.getItem('pacto_qs_active_tab');
            if (activeTab && $('#' + activeTab).length) {
                $('.pacto-qs-tab-btn[data-tab="' + activeTab + '"]').trigger('click');
            }
        }

        // 2. Single Image Uploader ("Porque o fazemos?")
        $('.pacto-single-upload-btn').on('click', function(e) {
            e.preventDefault();
            var btn = $(this);
            var targetInput = $('#' + btn.data('target'));
            var previewWrap = $('#' + btn.data('preview'));
            var removeBtn   = $('#' + btn.data('remove'));

            var customUploader = wp.media({
                title: btn.data('title') || 'Selecionar Imagem',
                button: { text: 'Usar esta imagem' },
                multiple: false,
                library: { type: 'image' }
            });

            customUploader.on('select', function() {
                var attachment = customUploader.state().get('selection').first().toJSON();
                targetInput.val(attachment.id);
                var imgUrl = attachment.sizes && attachment.sizes.medium ? attachment.sizes.medium.url : attachment.url;
                previewWrap.html('<img src="' + imgUrl + '" alt="" style="width:100%;height:100%;object-fit:cover;display:block;" />');
                removeBtn.show();
            });

            customUploader.open();
        });

        $('.pacto-single-remove-btn').on('click', function(e) {
            e.preventDefault();
            var btn = $(this);
            var targetInput = $('#' + btn.data('target'));
            var previewWrap = $('#' + btn.data('preview'));
            var defaultFallback = btn.data('default');
            
            targetInput.val('');
            previewWrap.html('<img src="' + defaultFallback + '" alt="" style="width:100%;height:100%;object-fit:cover;display:block;" />');
            btn.hide();
        });

        // 3. Team Member Image Uploaders (Delegated)
        $(document).on('click', '.pacto-team-upload-btn', function(e) {
            e.preventDefault();
            var btn = $(this);
            var targetInput = $('#' + btn.data('target'));
            var previewWrap = $('#' + btn.data('preview'));
            var removeBtn   = $('#' + btn.data('remove'));

            var uploader = wp.media({
                title: 'Selecionar Foto do Membro da Equipa',
                button: { text: 'Usar Foto' },
                multiple: false,
                library: { type: 'image' }
            });

            uploader.on('select', function() {
                var attachment = uploader.state().get('selection').first().toJSON();
                targetInput.val(attachment.id);
                var imgUrl = attachment.sizes && attachment.sizes.medium ? attachment.sizes.medium.url : attachment.url;
                previewWrap.html('<img src="' + imgUrl + '" alt="" style="width:100%;height:100%;object-fit:cover;display:block;" />');
                removeBtn.show();
            });

            uploader.open();
        });

        // 4. Team Member Remove Image
        $(document).on('click', '.pacto-team-remove-btn', function(e) {
            e.preventDefault();
            var btn = $(this);
            var targetInput = $('#' + btn.data('target'));
            var previewWrap = $('#' + btn.data('preview'));
            var defaultFallback = btn.data('default');

            targetInput.val('');
            previewWrap.html('<img src="' + defaultFallback + '" alt="" style="width:100%;height:100%;object-fit:cover;display:block;" />');
            btn.hide();
        });

        function reindexTeamCards() {
            $('#pacto-team-items-wrap .pacto-team-card').each(function(idx) {
                var card = $(this);
                var num = idx + 1;
                card.attr('data-index', idx);
                card.find('.pacto-team-card__badge').text('☰ Membro #' + num);
                card.find('input').each(function() {
                    var el = $(this);
                    var name = el.attr('name');
                    if (name) {
                        el.attr('name', name.replace(/qs_team_members\[\d+\]/, 'qs_team_members[' + idx + ']'));
                    }
                });
            });
        }

        function reindexReasonCards() {
            $('#pacto-reasons-cards-wrap .pacto-reasons-card-item').each(function(idx) {
                var card = $(this);
                var num = idx + 1;
                card.attr('data-index', idx);
                card.find('.pacto-reasons-card-badge').text('☰ Cartão #' + num);
                card.find('select, input, textarea').each(function() {
                    var el = $(this);
                    var name = el.attr('name');
                    if (name) {
                        el.attr('name', name.replace(/qs_reasons_cards\[\d+\]/, 'qs_reasons_cards[' + idx + ']'));
                    }
                });
            });
        }

        if ($.fn.sortable) {
            $('#pacto-team-items-wrap').sortable({
                items: '.pacto-team-card',
                cursor: 'grabbing',
                opacity: 0.85,
                tolerance: 'pointer',
                update: function() {
                    reindexTeamCards();
                }
            });

            $('#pacto-reasons-cards-wrap').sortable({
                items: '.pacto-reasons-card-item',
                cursor: 'grabbing',
                opacity: 0.85,
                tolerance: 'pointer',
                update: function() {
                    reindexReasonCards();
                }
            });
        }

        // 5. Add New Team Member
        $('#pacto-btn-add-member').on('click', function(e) {
            e.preventDefault();
            var container = $('#pacto-team-items-wrap');
            var nextIndex = container.find('.pacto-team-card').length;
            var nextNum   = nextIndex + 1;
            
            var templateHtml = $('#pacto-team-member-template').html();
            templateHtml = templateHtml.replace(/__INDEX__/g, nextIndex);
            templateHtml = templateHtml.replace(/__NUM__/g, nextNum);

            container.append(templateHtml);
            reindexTeamCards();
        });

        // 6. Delete Team Member
        $(document).on('click', '.pacto-btn-delete-member', function(e) {
            e.preventDefault();
            if ($('#pacto-team-items-wrap .pacto-team-card').length <= 1) {
                alert('Deve manter pelo menos 1 membro na equipa.');
                return;
            }
            if (confirm('Tem a certeza que pretende remover este membro da equipa?')) {
                $(this).closest('.pacto-team-card').fadeOut(250, function() {
                    $(this).remove();
                    reindexTeamCards();
                });
            }
        });
        // 7. Add New Reasons Card
        $('#pacto-btn-add-card').on('click', function(e) {
            e.preventDefault();
            var container = $('#pacto-reasons-cards-wrap');
            var nextIndex = container.find('.pacto-reasons-card-item').length;
            var nextNum   = nextIndex + 1;
            
            var templateHtml = $('#pacto-reasons-card-template').html();
            templateHtml = templateHtml.replace(/__INDEX__/g, nextIndex);
            templateHtml = templateHtml.replace(/__NUM__/g, nextNum);

            container.append(templateHtml);
            reindexReasonCards();
        });

        // 8. Delete Reasons Card
        $(document).on('click', '#pacto-reasons-cards-wrap .pacto-btn-delete-card', function(e) {
            e.preventDefault();
            if ($('#pacto-reasons-cards-wrap .pacto-reasons-card-item').length <= 1) {
                alert('Deve manter pelo menos 1 cartão.');
                return;
            }
            if (confirm('Tem a certeza que pretende remover este cartão?')) {
                $(this).closest('.pacto-reasons-card-item').fadeOut(250, function() {
                    $(this).remove();
                    reindexReasonCards();
                });
            }
        });
        // 9. Reasons Card Custom Icon Uploader (Delegated)
        $(document).on('click', '.pacto-card-upload-btn', function(e) {
            e.preventDefault();
            var btn = $(this);
            var targetInput = $('#' + btn.data('target'));
            var previewWrap = $('#' + btn.data('preview'));
            var removeBtn   = $('#' + btn.data('remove'));

            var uploader = wp.media({
                title: 'Selecionar Ícone do Cartão (SVG ou Imagem)',
                button: { text: 'Usar este ícone' },
                multiple: false,
                library: { type: 'image' }
            });

            uploader.on('select', function() {
                var attachment = uploader.state().get('selection').first().toJSON();
                targetInput.val(attachment.id);
                var imgUrl = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
                previewWrap.html('<img src="' + imgUrl + '" alt="" style="max-width:100%;max-height:100%;object-fit:contain;" />');
                removeBtn.show();
            });

            uploader.open();
        });

        // 10. Reasons Card Remove Custom Icon
        $(document).on('click', '.pacto-card-remove-btn', function(e) {
            e.preventDefault();
            var btn = $(this);
            var targetInput = $('#' + btn.data('target'));
            var previewWrap = $('#' + btn.data('preview'));

            targetInput.val('');
            previewWrap.html('<span class="dashicons dashicons-format-image" style="color: #94a3b8; font-size: 18px; width: 18px; height: 18px;"></span>');
            btn.hide();
        });
    });
    </script>
    <?php
}

/**
 * Save Quem Somos Meta Box Data
 */
function pacto_save_quem_somos_meta( $post_id ) {
    if ( ! isset( $_POST['pacto_quem_somos_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['pacto_quem_somos_nonce'] ), 'pacto_quem_somos_meta_save' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    // 1. Save "Porque o fazemos?" fields
    if ( isset( $_POST['qs_why_image'] ) ) {
        $img_val = sanitize_text_field( wp_unslash( $_POST['qs_why_image'] ) );
        update_post_meta( $post_id, 'qs_why_image', $img_val );
        delete_post_meta( $post_id, '_qs_why_image' );
        if ( function_exists( 'update_field' ) ) {
            update_field( 'qs_why_image', $img_val, $post_id );
        }
    }

    if ( isset( $_POST['qs_why_eyebrow'] ) ) {
        $eyebrow_val = sanitize_text_field( wp_unslash( $_POST['qs_why_eyebrow'] ) );
        update_post_meta( $post_id, 'qs_why_eyebrow', $eyebrow_val );
        if ( function_exists( 'update_field' ) ) {
            update_field( 'qs_why_eyebrow', $eyebrow_val, $post_id );
        }
    }

    if ( isset( $_POST['qs_why_title'] ) ) {
        $title_val = sanitize_text_field( wp_unslash( $_POST['qs_why_title'] ) );
        update_post_meta( $post_id, 'qs_why_title', $title_val );
        if ( function_exists( 'update_field' ) ) {
            update_field( 'qs_why_title', $title_val, $post_id );
        }
    }

    if ( isset( $_POST['qs_why_description'] ) ) {
        $desc_val = sanitize_textarea_field( wp_unslash( $_POST['qs_why_description'] ) );
        update_post_meta( $post_id, 'qs_why_description', $desc_val );
        if ( function_exists( 'update_field' ) ) {
            update_field( 'qs_why_description', $desc_val, $post_id );
        }
    }

    // 2. Save "A Nossa Equipa" fields
    if ( isset( $_POST['qs_team_members'] ) && is_array( $_POST['qs_team_members'] ) ) {
        $sanitized_team = array();
        
        foreach ( $_POST['qs_team_members'] as $raw_member ) {
            if ( ! is_array( $raw_member ) ) {
                continue;
            }

            $name  = isset( $raw_member['name'] ) ? sanitize_text_field( wp_unslash( $raw_member['name'] ) ) : '';
            $role  = isset( $raw_member['role'] ) ? sanitize_text_field( wp_unslash( $raw_member['role'] ) ) : '';
            $image = isset( $raw_member['image'] ) ? sanitize_text_field( wp_unslash( $raw_member['image'] ) ) : '';

            // Clean leading bullet point if user typed it manually
            $role = ltrim( $role, "•· \t\n\r\0\x0B" );

            if ( '' !== $name || '' !== $role || '' !== $image ) {
                $sanitized_team[] = array(
                    'name'  => $name,
                    'role'  => $role,
                    'image' => $image,
                );
            }
        }

        update_post_meta( $post_id, 'qs_team_members', $sanitized_team );
        delete_post_meta( $post_id, '_qs_team_members' );
    }

    // 3. Save "Porquê escolher-nos" / "Vantagens, Coberturas e Serviços" fields
    if ( isset( $_POST['qs_reasons_eyebrow'] ) ) {
        $reasons_eyebrow_val = sanitize_text_field( wp_unslash( $_POST['qs_reasons_eyebrow'] ) );
        update_post_meta( $post_id, 'qs_reasons_eyebrow', $reasons_eyebrow_val );
        update_post_meta( $post_id, 'seguro_features_eyebrow', $reasons_eyebrow_val );
    }

    if ( isset( $_POST['qs_reasons_title'] ) ) {
        $reasons_title_val = sanitize_text_field( wp_unslash( $_POST['qs_reasons_title'] ) );
        update_post_meta( $post_id, 'qs_reasons_title', $reasons_title_val );
        update_post_meta( $post_id, 'seguro_features_title', $reasons_title_val );
    }

    if ( isset( $_POST['qs_reasons_p1'] ) ) {
        $reasons_p1_val = sanitize_textarea_field( wp_unslash( $_POST['qs_reasons_p1'] ) );
        update_post_meta( $post_id, 'qs_reasons_p1', $reasons_p1_val );
        update_post_meta( $post_id, 'seguro_features_p1', $reasons_p1_val );
    }

    if ( isset( $_POST['qs_reasons_p2'] ) ) {
        $reasons_p2_val = sanitize_textarea_field( wp_unslash( $_POST['qs_reasons_p2'] ) );
        update_post_meta( $post_id, 'qs_reasons_p2', $reasons_p2_val );
        update_post_meta( $post_id, 'seguro_features_p2', $reasons_p2_val );
    }

    if ( isset( $_POST['qs_reasons_p3'] ) ) {
        $reasons_p3_val = sanitize_textarea_field( wp_unslash( $_POST['qs_reasons_p3'] ) );
        update_post_meta( $post_id, 'qs_reasons_p3', $reasons_p3_val );
        update_post_meta( $post_id, 'seguro_features_p3', $reasons_p3_val );
    }

    if ( isset( $_POST['qs_reasons_cards'] ) && is_array( $_POST['qs_reasons_cards'] ) ) {
        $sanitized_cards = array();
        
        foreach ( $_POST['qs_reasons_cards'] as $raw_card ) {
            if ( ! is_array( $raw_card ) ) {
                continue;
            }

            $icon        = isset( $raw_card['icon'] ) ? sanitize_text_field( wp_unslash( $raw_card['icon'] ) ) : 'heart-check';
            $custom_icon = isset( $raw_card['custom_icon'] ) ? sanitize_text_field( wp_unslash( $raw_card['custom_icon'] ) ) : '';
            $title       = isset( $raw_card['title'] ) ? sanitize_text_field( wp_unslash( $raw_card['title'] ) ) : '';
            $desc        = isset( $raw_card['description'] ) ? sanitize_textarea_field( wp_unslash( $raw_card['description'] ) ) : '';
            $link        = isset( $raw_card['link'] ) ? esc_url_raw( wp_unslash( $raw_card['link'] ) ) : '';

            if ( '' !== $title || '' !== $desc || '' !== $link || '' !== $custom_icon ) {
                $sanitized_cards[] = array(
                    'icon'        => $icon,
                    'custom_icon' => $custom_icon,
                    'title'       => $title,
                    'description' => $desc,
                    'link'        => $link,
                );
            }
        }

        update_post_meta( $post_id, 'qs_reasons_cards', $sanitized_cards );
        update_post_meta( $post_id, 'seguro_features_cards', $sanitized_cards );
        delete_post_meta( $post_id, '_qs_reasons_cards' );
        delete_post_meta( $post_id, '_seguro_features_cards' );
    }
}
add_action( 'save_post', 'pacto_save_quem_somos_meta' );

/**
 * Render Standalone Reasons Slider Meta Box
 */
function pacto_render_reasons_standalone_meta_box( $post ) {
    wp_nonce_field( 'pacto_quem_somos_meta_save', 'pacto_quem_somos_nonce' );

    $is_seguro = in_array( $post->post_type, array( 'seguro_particular', 'seguro_empresa' ), true ) || 'page-landing.php' === get_post_meta( $post->ID, '_wp_page_template', true );

    $eyebrow_val = pacto_get_field( $is_seguro ? 'seguro_features_eyebrow' : 'qs_reasons_eyebrow', $post->ID, '' );
    if ( empty( $eyebrow_val ) ) {
        $eyebrow_val = pacto_get_field( 'qs_reasons_eyebrow', $post->ID, $is_seguro ? 'VANTAGENS & COBERTURAS' : 'SEGURAMENTE CONSIGO' );
    }

    $title_val = pacto_get_field( $is_seguro ? 'seguro_features_title' : 'qs_reasons_title', $post->ID, '' );
    if ( empty( $title_val ) ) {
        $title_val = pacto_get_field( 'qs_reasons_title', $post->ID, $is_seguro ? 'Vantagens, Coberturas e Serviços' : 'Porquê escolher-nos' );
    }

    $p1_val = pacto_get_field( $is_seguro ? 'seguro_features_p1' : 'qs_reasons_p1', $post->ID, '' );
    if ( empty( $p1_val ) ) {
        $p1_val = pacto_get_field( 'qs_reasons_p1', $post->ID, 'Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Enim amet nullam dictumst dui amet.' );
    }

    $p2_val = pacto_get_field( $is_seguro ? 'seguro_features_p2' : 'qs_reasons_p2', $post->ID, '' );
    if ( empty( $p2_val ) ) {
        $p2_val = pacto_get_field( 'qs_reasons_p2', $post->ID, 'Enim amet nullam dictumst dui amet. Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Enim amet nullam dictumst dui amet.' );
    }

    $p3_val = pacto_get_field( $is_seguro ? 'seguro_features_p3' : 'qs_reasons_p3', $post->ID, '' );
    if ( empty( $p3_val ) ) {
        $p3_val = pacto_get_field( 'qs_reasons_p3', $post->ID, 'Sit tellus morbi ut auctor. Aliquet eu proin non netus nisl nascetur sed duis in, lorem ipsum dolor sit amet consectetur. Enim amet nullam dictumst dui amet.' );
    }

    $default_cards = array(
        // Slide 1
        array( 'icon' => 'heart-check', 'title' => 'Simples e Fácil', 'description' => 'Connosco pode subscrever um seguro rápido e sem complicações. Comunicamos de forma clara e objetiva.', 'link' => '' ),
        array( 'icon' => 'clock-check', 'title' => 'Rápidos', 'description' => 'Simulamos e emitimos um seguro em menos de 10 minutos.', 'link' => '' ),
        array( 'icon' => 'heart-check', 'title' => 'Seguro à Medida', 'description' => 'Adaptamos cada solução e cobertura às necessidades específicas da sua vida e da sua família.', 'link' => '' ),
        array( 'icon' => 'clock-check', 'title' => 'Confiança & Rigor', 'description' => 'Mais de 25 anos de experiência e solidez no setor, com acompanhamento próximo em cada etapa.', 'link' => '' ),
        // Slide 2
        array( 'icon' => 'heart-check', 'title' => 'Transparência Total', 'description' => 'Sem letras pequenas nem surpresas. Condições transparentes e rigorosas em todas as fases.', 'link' => '' ),
        array( 'icon' => 'clock-check', 'title' => 'Apoio Contínuo', 'description' => 'Linha dedicada para esclarecimento de dúvidas e resolução ágil e proativa de sinistros.', 'link' => '' ),
        array( 'icon' => 'heart-check', 'title' => 'Soluções Integradas', 'description' => 'Parcerias com as maiores seguradoras do mercado para garantir as melhores condições e garantias.', 'link' => '' ),
        array( 'icon' => 'clock-check', 'title' => 'Proximidade Humana', 'description' => 'Uma equipa experiente sempre acessível e disponível para lhe dar total tranquilidade no dia a dia.', 'link' => '' ),
    );

    $cards = pacto_get_field( $is_seguro ? 'seguro_features_cards' : 'qs_reasons_cards', $post->ID, false );
    if ( ! is_array( $cards ) || empty( $cards ) ) {
        $cards = pacto_get_field( 'qs_reasons_cards', $post->ID, false );
    }
    if ( ! is_array( $cards ) || empty( $cards ) ) {
        $legacy_cards = array();
        $has_legacy   = false;
        for ( $i = 1; $i <= 8; $i++ ) {
            $c_title  = get_post_meta( $post->ID, "qs_card_{$i}_title", true ) ?: get_post_meta( $post->ID, "seguro_card_{$i}_title", true );
            $c_desc   = get_post_meta( $post->ID, "qs_card_{$i}_desc", true ) ?: get_post_meta( $post->ID, "seguro_card_{$i}_desc", true );
            $c_icon   = get_post_meta( $post->ID, "qs_card_{$i}_icon", true ) ?: get_post_meta( $post->ID, "seguro_card_{$i}_icon", true );
            $c_custom = get_post_meta( $post->ID, "qs_card_{$i}_custom_icon", true ) ?: get_post_meta( $post->ID, "seguro_card_{$i}_custom_icon", true );
            $c_link   = get_post_meta( $post->ID, "qs_card_{$i}_link", true ) ?: get_post_meta( $post->ID, "seguro_card_{$i}_link", true );
            if ( ! empty( $c_title ) || ! empty( $c_desc ) ) {
                $has_legacy = true;
            }
            $def = isset( $default_cards[ $i - 1 ] ) ? $default_cards[ $i - 1 ] : array();
            $legacy_cards[] = array(
                'icon'        => ! empty( $c_icon ) ? $c_icon : ( isset( $def['icon'] ) ? $def['icon'] : 'heart-check' ),
                'custom_icon' => $c_custom,
                'title'       => ! empty( $c_title ) ? $c_title : ( isset( $def['title'] ) ? $def['title'] : "Cartão $i" ),
                'description' => ! empty( $c_desc ) ? $c_desc : ( isset( $def['description'] ) ? $def['description'] : '' ),
                'link'        => ! empty( $c_link ) ? $c_link : ( isset( $def['link'] ) ? $def['link'] : '' ),
            );
        }
        $cards = $has_legacy ? $legacy_cards : $default_cards;
    }
    ?>
    <style>
        .pacto-reasons-standalone-wrap { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif; padding: 6px 0; }
        .pacto-reasons-info-banner { background: #eff6ff; border-left: 4px solid #3b82f6; padding: 12px 16px; border-radius: 4px; margin-bottom: 20px; font-size: 13px; color: #1e3a8a; line-height: 1.5; }
        .pacto-reasons-info-banner strong { color: #1d4ed8; }
        .pacto-reasons-cards-grid-admin { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px; margin-bottom: 20px; }
        .pacto-reasons-admin-card { background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px; position: relative; box-shadow: 0 2px 6px rgba(0,0,0,0.03); }
        .pacto-reasons-admin-card:hover { border-color: #cbd5e1; }
        .pacto-reasons-admin-card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; cursor: grab; }
        .pacto-slide-badge { background: #E84E38; color: #fff; font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 12px; }
        .pacto-slide-badge-secondary { background: #1e293b; color: #fff; font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 12px; margin-left: 6px; }
        .pacto-reasons-card-remove { background: transparent; border: none; color: #94a3b8; cursor: pointer; font-size: 18px; line-height: 1; padding: 2px 6px; border-radius: 4px; }
        .pacto-reasons-card-remove:hover { color: #dc2626; background: #fee2e2; }
    </style>

    <div class="pacto-reasons-standalone-wrap">
        <div class="pacto-reasons-info-banner">
            <strong><?php esc_html_e( '💡 Carrossel / Slider Interativo (Arrastar, Adicionar e Remover):', 'pacto-25' ); ?></strong>
            <?php esc_html_e( 'Os cartões abaixo são agrupados automaticamente de 4 em 4 em cada slide (grid 2x2 do Figma). Pode arrastar qualquer cartão para reordenar, adicionar novos cartões ou remover existentes.', 'pacto-25' ); ?>
        </div>

        <div style="background: #fafafa; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px 20px; margin-bottom: 24px;">
            <h4 style="margin: 0 0 14px; font-size: 14px; font-weight: 700; color: #1e293b;">
                <?php esc_html_e( '1. Textos da Narrativa (Lado Esquerdo)', 'pacto-25' ); ?>
            </h4>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 14px;">
                <div class="pacto-qs-field-group">
                    <label for="standalone_reasons_eyebrow" style="display:block; font-weight:600; font-size:12px; margin-bottom:4px;"><?php esc_html_e( 'Subtítulo (Eyebrow)', 'pacto-25' ); ?></label>
                    <input type="text" id="standalone_reasons_eyebrow" name="qs_reasons_eyebrow" value="<?php echo esc_attr( $eyebrow_val ); ?>" style="width:100%; border:1px solid #cbd5e1; border-radius:6px; padding:6px 10px;" />
                </div>
                <div class="pacto-qs-field-group">
                    <label for="standalone_reasons_title" style="display:block; font-weight:600; font-size:12px; margin-bottom:4px;"><?php esc_html_e( 'Título Principal', 'pacto-25' ); ?></label>
                    <input type="text" id="standalone_reasons_title" name="qs_reasons_title" value="<?php echo esc_attr( $title_val ); ?>" style="width:100%; border:1px solid #cbd5e1; border-radius:6px; padding:6px 10px;" />
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px;">
                <div class="pacto-qs-field-group">
                    <label for="standalone_reasons_p1" style="display:block; font-weight:600; font-size:12px; margin-bottom:4px;"><?php esc_html_e( 'Parágrafo 1', 'pacto-25' ); ?></label>
                    <textarea id="standalone_reasons_p1" name="qs_reasons_p1" rows="3" style="width:100%; border:1px solid #cbd5e1; border-radius:6px; padding:6px 10px; font-size:12px;"><?php echo esc_textarea( $p1_val ); ?></textarea>
                </div>
                <div class="pacto-qs-field-group">
                    <label for="standalone_reasons_p2" style="display:block; font-weight:600; font-size:12px; margin-bottom:4px;"><?php esc_html_e( 'Parágrafo 2', 'pacto-25' ); ?></label>
                    <textarea id="standalone_reasons_p2" name="qs_reasons_p2" rows="3" style="width:100%; border:1px solid #cbd5e1; border-radius:6px; padding:6px 10px; font-size:12px;"><?php echo esc_textarea( $p2_val ); ?></textarea>
                </div>
                <div class="pacto-qs-field-group">
                    <label for="standalone_reasons_p3" style="display:block; font-weight:600; font-size:12px; margin-bottom:4px;"><?php esc_html_e( 'Parágrafo 3', 'pacto-25' ); ?></label>
                    <textarea id="standalone_reasons_p3" name="qs_reasons_p3" rows="3" style="width:100%; border:1px solid #cbd5e1; border-radius:6px; padding:6px 10px; font-size:12px;"><?php echo esc_textarea( $p3_val ); ?></textarea>
                </div>
            </div>
        </div>

        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px;">
                <h4 style="margin: 0; font-size: 14px; font-weight: 700; color: #1e293b;">
                    <?php esc_html_e( '2. Cartões do Slider no Círculo Vermelho', 'pacto-25' ); ?>
                </h4>
                <span style="font-size: 12px; color: #64748b;">
                    <?php echo esc_html( sprintf( __( 'Total: %d cartões (%d slides de 4)', 'pacto-25' ), count( $cards ), ceil( count( $cards ) / 4 ) ) ); ?>
                </span>
            </div>

            <div class="pacto-reasons-cards-grid-admin" id="standalone-reasons-cards-wrap">
                <?php foreach ( $cards as $c_idx => $card ) : 
                    $c_icon   = isset( $card['icon'] ) ? $card['icon'] : 'heart-check';
                    $c_custom = isset( $card['custom_icon'] ) ? $card['custom_icon'] : '';
                    $c_title  = isset( $card['title'] ) ? $card['title'] : '';
                    $c_desc   = isset( $card['description'] ) ? $card['description'] : '';
                    $c_link   = isset( $card['link'] ) ? $card['link'] : '';

                    $slide_num = floor( $c_idx / 4 ) + 1;
                    $card_num  = ( $c_idx % 4 ) + 1;

                    $c_custom_src = '';
                    if ( is_numeric( $c_custom ) && (int) $c_custom > 0 ) {
                        $src_arr = wp_get_attachment_image_src( (int) $c_custom, 'thumbnail' );
                        if ( $src_arr ) {
                            $c_custom_src = $src_arr[0];
                        }
                    } elseif ( is_string( $c_custom ) && ! empty( $c_custom ) ) {
                        $c_custom_src = $c_custom;
                    }
                ?>
                    <div class="pacto-reasons-admin-card" data-index="<?php echo esc_attr( $c_idx ); ?>">
                        <div class="pacto-reasons-admin-card-header" title="<?php esc_attr_e( 'Arrastar para reordenar', 'pacto-25' ); ?>">
                            <div>
                                <span class="pacto-slide-badge">☰ <?php echo esc_html( sprintf( __( 'Slide %d', 'pacto-25' ), $slide_num ) ); ?></span>
                                <span class="pacto-slide-badge-secondary"><?php echo esc_html( sprintf( __( 'Cartão #%d', 'pacto-25' ), $card_num ) ); ?></span>
                            </div>
                            <button type="button" class="pacto-reasons-card-remove pacto-btn-delete-standalone-card" title="<?php esc_attr_e( 'Remover cartão', 'pacto-25' ); ?>">&times;</button>
                        </div>

                        <div style="margin-bottom: 10px;">
                            <label style="display:block; font-size:12px; font-weight:600; color:#475569; margin-bottom:4px;"><?php esc_html_e( 'Ícone Predefinido (SVG)', 'pacto-25' ); ?></label>
                            <select name="qs_reasons_cards[<?php echo esc_attr( $c_idx ); ?>][icon]" style="width: 100%; border: 1px solid #cbd5e1; border-radius: 6px; padding: 6px 10px; font-size: 13px;">
                                <option value="heart-check" <?php selected( $c_icon, 'heart-check' ); ?>><?php esc_html_e( '❤️ Coração com Check (Simples e Fácil)', 'pacto-25' ); ?></option>
                                <option value="clock-check" <?php selected( $c_icon, 'clock-check' ); ?>><?php esc_html_e( '⏱️ Velocímetro / Relógio (Rápidos)', 'pacto-25' ); ?></option>
                                <option value="shield-check" <?php selected( $c_icon, 'shield-check' ); ?>><?php esc_html_e( '🛡️ Escudo de Proteção', 'pacto-25' ); ?></option>
                                <option value="users-check" <?php selected( $c_icon, 'users-check' ); ?>><?php esc_html_e( '👥 Equipa / Pessoas', 'pacto-25' ); ?></option>
                            </select>
                        </div>

                        <div style="margin-bottom: 10px;">
                            <label style="display:block; font-size:12px; font-weight:600; color:#475569; margin-bottom:4px;"><?php esc_html_e( 'Ou Ícone Personalizado (Upload)', 'pacto-25' ); ?></label>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <input type="hidden" id="standalone_card_custom_<?php echo esc_attr( $c_idx ); ?>" name="qs_reasons_cards[<?php echo esc_attr( $c_idx ); ?>][custom_icon]" value="<?php echo esc_attr( $c_custom ); ?>" />
                                <div id="standalone_card_custom_preview_<?php echo esc_attr( $c_idx ); ?>" style="width: 36px; height: 36px; border: 1px solid #cbd5e1; border-radius: 6px; display: flex; align-items: center; justify-content: center; background: #f8fafc; overflow: hidden; padding: 2px;">
                                    <?php if ( ! empty( $c_custom_src ) ) : ?>
                                        <img src="<?php echo esc_url( $c_custom_src ); ?>" alt="" style="max-width:100%; max-height:100%; object-fit:contain;" />
                                    <?php else : ?>
                                        <span class="dashicons dashicons-format-image" style="color: #94a3b8; font-size: 18px; width: 18px; height: 18px;"></span>
                                    <?php endif; ?>
                                </div>
                                <button type="button" class="button pacto-card-upload-btn" data-target="standalone_card_custom_<?php echo esc_attr( $c_idx ); ?>" data-preview="standalone_card_custom_preview_<?php echo esc_attr( $c_idx ); ?>" data-remove="standalone_card_custom_remove_<?php echo esc_attr( $c_idx ); ?>"><?php esc_html_e( 'Carregar', 'pacto-25' ); ?></button>
                                <button type="button" class="button button-link-delete pacto-card-remove-btn" id="standalone_card_custom_remove_<?php echo esc_attr( $c_idx ); ?>" data-target="standalone_card_custom_<?php echo esc_attr( $c_idx ); ?>" data-preview="standalone_card_custom_preview_<?php echo esc_attr( $c_idx ); ?>" style="<?php echo empty( $c_custom ) ? 'display:none;' : ''; ?>"><?php esc_html_e( 'Remover', 'pacto-25' ); ?></button>
                            </div>
                        </div>

                        <div style="margin-bottom: 10px;">
                            <label style="display:block; font-size:12px; font-weight:600; color:#475569; margin-bottom:4px;"><?php esc_html_e( 'Título do Cartão', 'pacto-25' ); ?></label>
                            <input type="text" name="qs_reasons_cards[<?php echo esc_attr( $c_idx ); ?>][title]" value="<?php echo esc_attr( $c_title ); ?>" placeholder="<?php esc_attr_e( 'Ex: Simples e Fácil', 'pacto-25' ); ?>" style="width:100%; border:1px solid #cbd5e1; border-radius:6px; padding:6px 10px; font-size:13px;" />
                        </div>

                        <div style="margin-bottom: 10px;">
                            <label style="display:block; font-size:12px; font-weight:600; color:#475569; margin-bottom:4px;"><?php esc_html_e( 'Descrição do Cartão', 'pacto-25' ); ?></label>
                            <textarea name="qs_reasons_cards[<?php echo esc_attr( $c_idx ); ?>][description]" rows="2" placeholder="<?php esc_attr_e( 'Texto descritivo...', 'pacto-25' ); ?>" style="width:100%; border:1px solid #cbd5e1; border-radius:6px; padding:6px 10px; font-size:12px;"><?php echo esc_textarea( $c_desc ); ?></textarea>
                        </div>

                        <div style="margin-bottom: 0;">
                            <label style="display:block; font-size:12px; font-weight:600; color:#475569; margin-bottom:4px;"><?php esc_html_e( 'Link / URL (Opcional)', 'pacto-25' ); ?></label>
                            <input type="text" name="qs_reasons_cards[<?php echo esc_attr( $c_idx ); ?>][link]" value="<?php echo esc_attr( $c_link ); ?>" placeholder="<?php esc_attr_e( 'Ex: /particulares/ ou https://...', 'pacto-25' ); ?>" style="width:100%; border:1px solid #cbd5e1; border-radius:6px; padding:6px 10px; font-size:13px;" />
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div style="padding-top: 14px; border-top: 1px dashed #cbd5e1; display:flex; justify-content:space-between; align-items:center;">
                <button type="button" class="button button-primary" id="pacto-btn-add-standalone-card">
                    <span class="dashicons dashicons-plus-alt2" style="vertical-align: middle; margin-top:-2px;"></span>
                    <?php esc_html_e( 'Adicionar Outro Cartão ao Slider', 'pacto-25' ); ?>
                </button>
                <span style="font-size: 12px; color: #64748b;"><?php esc_html_e( 'Clique em "Actualizar" no canto superior direito para guardar.', 'pacto-25' ); ?></span>
            </div>
        </div>
    </div>

    <!-- Hidden Template for Standalone Reasons Card Adding -->
    <template id="pacto-standalone-reasons-card-template">
        <div class="pacto-reasons-admin-card" data-index="__INDEX__">
            <div class="pacto-reasons-admin-card-header" title="<?php esc_attr_e( 'Arrastar para reordenar', 'pacto-25' ); ?>">
                <div>
                    <span class="pacto-slide-badge">☰ <?php esc_html_e( 'Novo Cartão', 'pacto-25' ); ?></span>
                    <span class="pacto-slide-badge-secondary">#__NUM__</span>
                </div>
                <button type="button" class="pacto-reasons-card-remove pacto-btn-delete-standalone-card" title="<?php esc_attr_e( 'Remover cartão', 'pacto-25' ); ?>">&times;</button>
            </div>

            <div style="margin-bottom: 10px;">
                <label style="display:block; font-size:12px; font-weight:600; color:#475569; margin-bottom:4px;"><?php esc_html_e( 'Ícone Predefinido (SVG)', 'pacto-25' ); ?></label>
                <select name="qs_reasons_cards[__INDEX__][icon]" style="width: 100%; border: 1px solid #cbd5e1; border-radius: 6px; padding: 6px 10px; font-size: 13px;">
                    <option value="heart-check"><?php esc_html_e( '❤️ Coração com Check (Simples e Fácil)', 'pacto-25' ); ?></option>
                    <option value="clock-check"><?php esc_html_e( '⏱️ Velocímetro / Relógio (Rápidos)', 'pacto-25' ); ?></option>
                    <option value="shield-check"><?php esc_html_e( '🛡️ Escudo de Proteção', 'pacto-25' ); ?></option>
                    <option value="users-check"><?php esc_html_e( '👥 Equipa / Pessoas', 'pacto-25' ); ?></option>
                </select>
            </div>

            <div style="margin-bottom: 10px;">
                <label style="display:block; font-size:12px; font-weight:600; color:#475569; margin-bottom:4px;"><?php esc_html_e( 'Ou Ícone Personalizado (Upload)', 'pacto-25' ); ?></label>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <input type="hidden" id="standalone_card_custom___INDEX__" name="qs_reasons_cards[__INDEX__][custom_icon]" value="" />
                    <div id="standalone_card_custom_preview___INDEX__" style="width: 36px; height: 36px; border: 1px solid #cbd5e1; border-radius: 6px; display: flex; align-items: center; justify-content: center; background: #f8fafc; overflow: hidden; padding: 2px;">
                        <span class="dashicons dashicons-format-image" style="color: #94a3b8; font-size: 18px; width: 18px; height: 18px;"></span>
                    </div>
                    <button type="button" class="button pacto-card-upload-btn" data-target="standalone_card_custom___INDEX__" data-preview="standalone_card_custom_preview___INDEX__" data-remove="standalone_card_custom_remove___INDEX__"><?php esc_html_e( 'Carregar', 'pacto-25' ); ?></button>
                    <button type="button" class="button button-link-delete pacto-card-remove-btn" id="standalone_card_custom_remove___INDEX__" data-target="standalone_card_custom___INDEX__" data-preview="standalone_card_custom_preview___INDEX__" style="display:none;"><?php esc_html_e( 'Remover', 'pacto-25' ); ?></button>
                </div>
            </div>

            <div style="margin-bottom: 10px;">
                <label style="display:block; font-size:12px; font-weight:600; color:#475569; margin-bottom:4px;"><?php esc_html_e( 'Título do Cartão', 'pacto-25' ); ?></label>
                <input type="text" name="qs_reasons_cards[__INDEX__][title]" value="" placeholder="<?php esc_attr_e( 'Ex: Simples e Fácil', 'pacto-25' ); ?>" style="width:100%; border:1px solid #cbd5e1; border-radius:6px; padding:6px 10px; font-size:13px;" />
            </div>

            <div style="margin-bottom: 10px;">
                <label style="display:block; font-size:12px; font-weight:600; color:#475569; margin-bottom:4px;"><?php esc_html_e( 'Descrição do Cartão', 'pacto-25' ); ?></label>
                <textarea name="qs_reasons_cards[__INDEX__][description]" rows="2" placeholder="<?php esc_attr_e( 'Texto descritivo...', 'pacto-25' ); ?>" style="width:100%; border:1px solid #cbd5e1; border-radius:6px; padding:6px 10px; font-size:12px;"></textarea>
            </div>

            <div style="margin-bottom: 0;">
                <label style="display:block; font-size:12px; font-weight:600; color:#475569; margin-bottom:4px;"><?php esc_html_e( 'Link / URL (Opcional)', 'pacto-25' ); ?></label>
                <input type="text" name="qs_reasons_cards[__INDEX__][link]" value="" placeholder="<?php esc_attr_e( 'Ex: /particulares/ ou https://...', 'pacto-25' ); ?>" style="width:100%; border:1px solid #cbd5e1; border-radius:6px; padding:6px 10px; font-size:13px;" />
            </div>
        </div>
    </template>

    <script>
    jQuery(document).ready(function($) {
        function reindexStandaloneCards() {
            $('#standalone-reasons-cards-wrap .pacto-reasons-admin-card').each(function(idx) {
                var card = $(this);
                var slideNum = Math.floor(idx / 4) + 1;
                var cardNum  = (idx % 4) + 1;
                card.attr('data-index', idx);
                card.find('.pacto-slide-badge').text('☰ Slide ' + slideNum);
                card.find('.pacto-slide-badge-secondary').text('Cartão #' + cardNum);
                card.find('select, input, textarea').each(function() {
                    var el = $(this);
                    var name = el.attr('name');
                    if (name) {
                        el.attr('name', name.replace(/qs_reasons_cards\[\d+\]/, 'qs_reasons_cards[' + idx + ']'));
                    }
                });
            });
        }

        if ($.fn.sortable) {
            $('#standalone-reasons-cards-wrap').sortable({
                items: '.pacto-reasons-admin-card',
                handle: '.pacto-reasons-admin-card-header',
                cursor: 'grabbing',
                opacity: 0.85,
                tolerance: 'pointer',
                update: function() {
                    reindexStandaloneCards();
                }
            });
        }

        // Add card in standalone box
        $('#pacto-btn-add-standalone-card').on('click', function(e) {
            e.preventDefault();
            var container = $('#standalone-reasons-cards-wrap');
            var template = $('#pacto-standalone-reasons-card-template').html();
            var currentCards = container.find('.pacto-reasons-admin-card');
            var nextIndex = currentCards.length;
            var nextNum = nextIndex + 1;

            var html = template.replace(/__INDEX__/g, nextIndex).replace(/__NUM__/g, nextNum);
            container.append(html);
            reindexStandaloneCards();
        });

        // Delete card in standalone box
        $(document).on('click', '.pacto-btn-delete-standalone-card', function(e) {
            e.preventDefault();
            if ($('#standalone-reasons-cards-wrap .pacto-reasons-admin-card').length <= 1) {
                alert('Deve manter pelo menos 1 cartão no slider.');
                return;
            }
            if (confirm('Tem a certeza que pretende remover este cartão?')) {
                $(this).closest('.pacto-reasons-admin-card').fadeOut(200, function() {
                    $(this).remove();
                    reindexStandaloneCards();
                });
            }
        });

        // Upload & Remove Custom Icon in standalone box
        $(document).on('click', '#standalone-reasons-cards-wrap .pacto-card-upload-btn', function(e) {
            e.preventDefault();
            var btn = $(this);
            var targetInput = $('#' + btn.data('target'));
            var previewWrap = $('#' + btn.data('preview'));
            var removeBtn   = $('#' + btn.data('remove'));

            var uploader = wp.media({
                title: 'Selecionar Ícone do Cartão (SVG ou Imagem)',
                button: { text: 'Usar este ícone' },
                multiple: false,
                library: { type: 'image' }
            });

            uploader.on('select', function() {
                var attachment = uploader.state().get('selection').first().toJSON();
                targetInput.val(attachment.id);
                var imgUrl = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
                previewWrap.html('<img src="' + imgUrl + '" alt="" style="max-width:100%;max-height:100%;object-fit:contain;" />');
                removeBtn.show();
            });

            uploader.open();
        });

        $(document).on('click', '#standalone-reasons-cards-wrap .pacto-card-remove-btn', function(e) {
            e.preventDefault();
            var btn = $(this);
            var targetInput = $('#' + btn.data('target'));
            var previewWrap = $('#' + btn.data('preview'));

            targetInput.val('');
            previewWrap.html('<span class="dashicons dashicons-format-image" style="color: #94a3b8; font-size: 18px; width: 18px; height: 18px;"></span>');
            btn.hide();
        });
    });
    </script>
    <?php
}

