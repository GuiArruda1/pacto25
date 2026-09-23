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
    if ( ! $post || 'page' !== $post->post_type ) {
        return false;
    }

    $template = get_post_meta( $post->ID, '_wp_page_template', true );
    if ( 'page-quem-somos.php' === $template ) {
        return true;
    }

    $slug = $post->post_name;
    if ( in_array( $slug, array( 'quem-somos', 'institucional', 'sobre' ), true ) ) {
        return true;
    }

    $title = mb_strtolower( trim( $post->post_title ) );
    if ( strpos( $title, 'quem somos' ) !== false || strpos( $title, 'institucional' ) !== false ) {
        return true;
    }

    return false;
}

/**
 * Register Quem Somos Meta Box
 */
function pacto_register_quem_somos_meta_box() {
    $current_id = isset( $_GET['post'] ) ? (int) $_GET['post'] : ( isset( $_POST['post_ID'] ) ? (int) $_POST['post_ID'] : 0 ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
    if ( ! $current_id ) {
        return;
    }

    $post = get_post( $current_id );
    if ( ! pacto_is_quem_somos_admin( $post ) ) {
        return;
    }

    add_meta_box(
        'pacto_quem_somos_options_meta',
        __( 'Quem Somos — Conteúdo & A Nossa Equipa', 'pacto-25' ),
        'pacto_render_quem_somos_meta_box',
        'page',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'pacto_register_quem_somos_meta_box' );

/**
 * Enqueue Media Scripts on the Quem Somos edit screen
 */
function pacto_quem_somos_admin_scripts( $hook ) {
    if ( 'post.php' !== $hook && 'post-new.php' !== $hook ) {
        return;
    }

    $current_id = isset( $_GET['post'] ) ? (int) $_GET['post'] : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
    if ( ! $current_id ) {
        return;
    }

    $post = get_post( $current_id );
    if ( ! pacto_is_quem_somos_admin( $post ) ) {
        return;
    }

    wp_enqueue_media();
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
    ?>
    <style>
        .pacto-qs-wrap { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif; margin: 6px 0; }
        
        /* Tabs Header */
        .pacto-qs-tabs-nav { display: flex; border-bottom: 2px solid #e2e8f0; margin-bottom: 24px; gap: 8px; }
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
    </style>

    <div class="pacto-qs-wrap">
        <!-- Tab Navigation -->
        <div class="pacto-qs-tabs-nav" role="tablist">
            <button type="button" class="pacto-qs-tab-btn is-active" data-tab="tab-why">
                <span class="dashicons dashicons-format-image"></span>
                <?php esc_html_e( '1. "Porque o fazemos?" (Foto e Texto)', 'pacto-25' ); ?>
            </button>
            <button type="button" class="pacto-qs-tab-btn" data-tab="tab-team">
                <span class="dashicons dashicons-groups"></span>
                <?php esc_html_e( '2. "A Nossa Equipa" (Membros e Funções)', 'pacto-25' ); ?>
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
                        <span class="pacto-team-card__badge"><?php echo esc_html( sprintf( __( 'Membro #%d', 'pacto-25' ), $i + 1 ) ); ?></span>
                        
                        <?php if ( $i >= 4 ) : ?>
                            <button type="button" class="pacto-team-card__remove pacto-btn-delete-member" title="<?php esc_attr_e( 'Remover membro', 'pacto-25' ); ?>">
                                &times;
                            </button>
                        <?php endif; ?>

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
    </div>

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
        });

        // 6. Delete Team Member
        $(document).on('click', '.pacto-btn-delete-member', function(e) {
            e.preventDefault();
            if (confirm('Tem a certeza que pretende remover este membro da equipa?')) {
                $(this).closest('.pacto-team-card').fadeOut(250, function() {
                    $(this).remove();
                    // Re-index remaining cards
                    $('#pacto-team-items-wrap .pacto-team-card').each(function(idx) {
                        var card = $(this);
                        var num = idx + 1;
                        card.attr('data-index', idx);
                        card.find('.pacto-team-card__badge').text('Membro #' + num);
                    });
                });
            }
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
        if ( function_exists( 'update_field' ) ) {
            update_field( 'qs_team_members', $sanitized_team, $post_id );
        }
    }
}
add_action( 'save_post_page', 'pacto_save_quem_somos_meta' );
