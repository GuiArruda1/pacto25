<?php
/**
 * Native Meta Box for Quem Somos Page
 * Theme: Pacto 25
 * 
 * Strict Agency Standard:
 * - 100% Core WordPress APIs (add_meta_box, wp.media)
 * - Allows editing the "Porque o fazemos?" photo directly on the Quem Somos page
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
        __( 'Quem Somos — Conteúdo & Foto "Porque o fazemos?"', 'pacto-25' ),
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

    // Retrieve values from ACF or post meta
    $why_image_val = pacto_get_field( 'qs_why_image', $post->ID, '' );
    $image_id      = 0;
    $image_url     = '';

    if ( is_array( $why_image_val ) && ! empty( $why_image_val['ID'] ) ) {
        $image_id  = $why_image_val['ID'];
        $image_url = ! empty( $why_image_val['sizes']['medium'] ) ? $why_image_val['sizes']['medium'] : $why_image_val['url'];
    } elseif ( is_numeric( $why_image_val ) && (int) $why_image_val > 0 ) {
        $image_id  = (int) $why_image_val;
        $src       = wp_get_attachment_image_src( $image_id, 'medium' );
        $image_url = $src ? $src[0] : '';
    } elseif ( is_string( $why_image_val ) && ! empty( $why_image_val ) ) {
        $image_url = $why_image_val;
    }

    if ( empty( $image_url ) ) {
        $default_fallback = get_template_directory_uri() . '/assets/images/quem-somos/qs-why-phone.png';
    } else {
        $default_fallback = $image_url;
    }

    $eyebrow     = pacto_get_field( 'qs_why_eyebrow', $post->ID, 'PORQUE O FAZEMOS?' );
    $title       = pacto_get_field( 'qs_why_title', $post->ID, 'Porque o fazemos?' );
    $description = pacto_get_field( 'qs_why_description', $post->ID, 'Para provocar nas pessoas a responsabilidade e o sentido da melhor proteção das suas vidas e dos seus bens. Num mercado cada vez mais exigente, com um maior risco associado, entendemos sermos uma equipa multifacetada que acrescenta valor e credibilidade nas relações com os seus Clientes. Valorizamos as suas identidades, o seu negócio, o seu serviço com uma equipa especializada a cada caso. Trabalhamos sempre para prestar um serviço de alta qualidade com total independência e respeito por todos os intervenientes da relação.' );
    ?>
    <style>
        .pacto-qs-box { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif; padding: 12px 0; }
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
    </style>

    <div class="pacto-qs-box">
        <div class="pacto-qs-grid">
            <!-- Left: Circular Photo Uploader -->
            <div class="pacto-qs-photo-col">
                <label style="display:block; font-weight:700; margin-bottom:12px; font-size:14px; color:#0f172a;">
                    <?php esc_html_e( 'Foto "Porque o fazemos?"', 'pacto-25' ); ?>
                </label>
                <div class="pacto-qs-photo-preview" id="qs-why-preview">
                    <?php if ( ! empty( $image_url ) ) : ?>
                        <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php esc_attr_e( 'Foto circular Porque o fazemos', 'pacto-25' ); ?>" />
                    <?php else : ?>
                        <img src="<?php echo esc_url( $default_fallback ); ?>" alt="<?php esc_attr_e( 'Foto circular padrão', 'pacto-25' ); ?>" />
                    <?php endif; ?>
                </div>

                <input type="hidden" id="qs_why_image" name="qs_why_image" value="<?php echo esc_attr( $image_id ? $image_id : $image_url ); ?>" />

                <div class="pacto-qs-btn-group">
                    <button type="button" class="button button-primary pacto-media-upload-btn" data-target="qs_why_image" data-preview="qs-why-preview" data-remove="qs-why-remove-btn" data-title="<?php esc_attr_e( 'Selecionar Imagem para Porque o Fazemos', 'pacto-25' ); ?>">
                        <?php esc_html_e( 'Selecionar / Alterar Imagem', 'pacto-25' ); ?>
                    </button>
                    <button type="button" class="button button-link-delete pacto-media-remove-btn" id="qs-why-remove-btn" data-target="qs_why_image" data-preview="qs-why-preview" style="<?php echo empty( $image_url ) ? 'display:none;' : ''; ?>">
                        <?php esc_html_e( 'Restaurar Imagem Padrão', 'pacto-25' ); ?>
                    </button>
                </div>
                <p class="pacto-qs-tip"><?php esc_html_e( 'A imagem será recortada no círculo com anel vermelho.', 'pacto-25' ); ?></p>
            </div>

            <!-- Right: Section Texts -->
            <div class="pacto-qs-content-col">
                <div class="pacto-qs-field-group">
                    <label for="qs_why_eyebrow"><?php esc_html_e( 'Subtítulo (Eyebrow)', 'pacto-25' ); ?></label>
                    <input type="text" id="qs_why_eyebrow" name="qs_why_eyebrow" value="<?php echo esc_attr( $eyebrow ); ?>" />
                </div>

                <div class="pacto-qs-field-group">
                    <label for="qs_why_title"><?php esc_html_e( 'Título da Secção', 'pacto-25' ); ?></label>
                    <input type="text" id="qs_why_title" name="qs_why_title" value="<?php echo esc_attr( $title ); ?>" />
                </div>

                <div class="pacto-qs-field-group">
                    <label for="qs_why_description"><?php esc_html_e( 'Texto Descritivo', 'pacto-25' ); ?></label>
                    <textarea id="qs_why_description" name="qs_why_description" rows="5"><?php echo esc_textarea( $description ); ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <script>
    jQuery(document).ready(function($) {
        var defaultFallbackImg = <?php echo wp_json_encode( get_template_directory_uri() . '/assets/images/quem-somos/qs-why-phone.png' ); ?>;

        $('.pacto-media-upload-btn').on('click', function(e) {
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

        $('.pacto-media-remove-btn').on('click', function(e) {
            e.preventDefault();
            var btn = $(this);
            var targetInput = $('#' + btn.data('target'));
            var previewWrap = $('#' + btn.data('preview'));
            targetInput.val('');
            previewWrap.html('<img src="' + defaultFallbackImg + '" alt="" style="width:100%;height:100%;object-fit:cover;display:block;" />');
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

    if ( isset( $_POST['qs_why_image'] ) ) {
        $img_val = sanitize_text_field( wp_unslash( $_POST['qs_why_image'] ) );
        update_post_meta( $post_id, 'qs_why_image', $img_val );
        update_post_meta( $post_id, '_qs_why_image', $img_val );
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
}
add_action( 'save_post_page', 'pacto_save_quem_somos_meta' );
