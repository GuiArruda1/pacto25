<?php
/**
 * Native Hero Slider Repeater Meta Box
 * Theme: Pacto 25
 * 
 * Strict Agency Standard:
 * - 100% Core WordPress APIs (add_meta_box, wp.media, jQuery UI sortable)
 * - Zero Pro plugin dependencies
 * - Full sanitize & escape security
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Meta box registration is now integrated directly as an ACF Tab in group_pacto_homepage

/**
 * Enqueue Media Scripts and Styles for the Meta Box
 */
function pacto_hero_slider_admin_scripts( $hook ) {
    if ( 'post.php' !== $hook && 'post-new.php' !== $hook ) {
        return;
    }

    $front_page_id = (int) get_option( 'page_on_front' );
    $current_id    = isset( $_GET['post'] ) ? (int) $_GET['post'] : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
    $template      = $current_id ? get_page_template_slug( $current_id ) : '';

    // Do not load on Landing Page template
    if ( 'page-landing.php' === $template ) {
        return;
    }

    if ( $front_page_id && $current_id && $current_id !== $front_page_id ) {
        return;
    }

    wp_enqueue_media();
    wp_enqueue_script( 'jquery-ui-sortable' );

    // Inline script to dynamically hide meta box if template is switched to Landing Page in editor
    wp_add_inline_script(
        'jquery',
        "(function($){
            function handleTemplateChange(){
                var t = $('#page_template').val();
                if(!t && window.wp && wp.data && wp.data.select){
                    var ed = wp.data.select('core/editor');
                    if(ed && ed.getEditedPostAttribute){
                        t = ed.getEditedPostAttribute('template');
                    }
                }
                if(t === 'page-landing.php'){
                    $('#pacto_hero_slider_meta').hide();
                } else if($('#page_template').length || (window.wp && wp.data)) {
                    $('#pacto_hero_slider_meta').show();
                }
            }
            $(document).ready(function(){
                handleTemplateChange();
                $('#page_template').on('change', handleTemplateChange);
                if(window.wp && wp.data && wp.data.subscribe){
                    wp.data.subscribe(function(){
                        handleTemplateChange();
                    });
                }
            });
        })(jQuery);"
    );
}
add_action( 'admin_enqueue_scripts', 'pacto_hero_slider_admin_scripts' );

/**
 * Retrieve Slides with Graceful Fallback (from ACF Repeater hero_slides or post meta)
 *
 * @param int $post_id
 * @return array
 */
function pacto_get_hero_slides( $post_id = 0 ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID() ?: (int) get_option( 'page_on_front' ) ?: get_queried_object_id();
    }

    // 1. Try ACF Repeater field from the homepage ACF Tab
    $acf_slides = pacto_get_field( 'hero_slides', $post_id );
    if ( ! empty( $acf_slides ) && is_array( $acf_slides ) && count( $acf_slides ) > 0 ) {
        $clean_slides = array();
        foreach ( $acf_slides as $s ) {
            $img     = $s['image'] ?? null;
            $img_id  = 0;
            $img_url = '';
            if ( is_array( $img ) && ! empty( $img['ID'] ) ) {
                $img_id  = (int) $img['ID'];
                $img_url = $img['url'] ?? '';
            } elseif ( is_numeric( $img ) && (int) $img > 0 ) {
                $img_id  = (int) $img;
                $url     = wp_get_attachment_url( $img_id );
                if ( $url ) {
                    $img_url = $url;
                }
            } elseif ( is_string( $img ) && ! empty( $img ) ) {
                $img_url = $img;
            }

            $clean_slides[] = array(
                'eyebrow'     => $s['eyebrow'] ?? '',
                'title'       => $s['title'] ?? '',
                'description' => $s['description'] ?? '',
                'btn_text'    => $s['btn_text'] ?? '',
                'btn_url'     => $s['btn_url'] ?? '#',
                'image_id'    => $img_id,
                'image_url'   => $img_url,
            );
        }

        if ( ! empty( $clean_slides ) ) {
            return $clean_slides;
        }
    }

    // 2. Fallback to post meta if present
    $slides = $post_id ? get_post_meta( $post_id, 'pacto_hero_slides', true ) : array();

    if ( ! empty( $slides ) && is_array( $slides ) && count( $slides ) > 0 ) {
        return $slides;
    }

    // 3. Default fallback slides if none have been saved yet
    return array(
        array(
            'eyebrow'     => 'SEGURAMENTE CONSIGO',
            'title'       => 'Pacto Seguro 25 anos ao seu Lado',
            'description' => 'Construímos relações duradouras porque acreditamos que um seguro é muito mais do que uma apólice. É confiança quando mais precisa',
            'btn_text'    => 'conheça a nossa história',
            'btn_url'     => '#sobre',
            'image_id'    => 0,
            'image_url'   => get_template_directory_uri() . '/assets/images/home-hero-doctor.png',
        ),
        array(
            'eyebrow'     => 'PROTEÇÃO COMPLETA',
            'title'       => 'Soluções pensadas para a sua Família',
            'description' => 'Garantimos a segurança e o bem-estar de quem mais ama com planos flexíveis de saúde, vida e habitação adaptados ao seu dia a dia.',
            'btn_text'    => 'ver soluções particulares',
            'btn_url'     => home_url( '/particulares/' ),
            'image_id'    => 0,
            'image_url'   => get_template_directory_uri() . '/assets/images/sinistro/sinistro-hero-family.png',
        ),
        array(
            'eyebrow'     => 'SEGURANÇA & CONFIANÇA',
            'title'       => 'Protegemos o Futuro do seu Negócio',
            'description' => 'Parcerias sólidas e consultoria especializada para salvaguardar a sua empresa, equipa e património contra qualquer imprevisto.',
            'btn_text'    => 'ver soluções empresas',
            'btn_url'     => home_url( '/empresas/' ),
            'image_id'    => 0,
            'image_url'   => get_template_directory_uri() . '/assets/images/protocolos-doctor.png',
        ),
    );
}

/**
 * Render Meta Box Content
 *
 * @param WP_Post $post
 */
function pacto_render_hero_slider_meta_box( $post ) {
    wp_nonce_field( 'pacto_save_hero_slides', 'pacto_hero_slides_nonce' );

    $slides = pacto_get_hero_slides( $post->ID );
    ?>
    <div id="pacto-hero-slider-app" class="pacto-slider-meta">
        <p class="description" style="margin-bottom: 16px;">
            <?php esc_html_e( 'Faça a gestão dos slides do banner principal (Hero). Pode arrastar os cartões para reordenar, adicionar novos slides ou remover existentes.', 'pacto-25' ); ?>
        </p>

        <div id="pacto-slides-container">
            <?php foreach ( $slides as $index => $slide ) : ?>
                <?php pacto_render_single_slide_row( $index, $slide ); ?>
            <?php endforeach; ?>
        </div>

        <div class="pacto-slider-actions" style="margin-top: 18px; padding-top: 14px; border-top: 1px solid #ddd; display: flex; justify-content: space-between; align-items: center;">
            <button type="button" class="button button-primary button-large" id="pacto-add-slide-btn">
                <span class="dashicons dashicons-plus-alt2" style="vertical-align: middle; margin-top: -2px;"></span>
                <?php esc_html_e( 'Adicionar Novo Slide', 'pacto-25' ); ?>
            </button>
            <span class="pacto-slide-counter description">
                <?php
                /* translators: %d: slide count */
                printf( esc_html__( 'Total de slides: %d', 'pacto-25' ), count( $slides ) );
                ?>
            </span>
        </div>
    </div>

    <!-- Template for new slide insertion via JS -->
    <template id="pacto-slide-template">
        <?php
        pacto_render_single_slide_row(
            '__INDEX__',
            array(
                'eyebrow'     => 'SEGURAMENTE CONSIGO',
                'title'       => '',
                'description' => '',
                'btn_text'    => '',
                'btn_url'     => '#',
                'image_id'    => 0,
                'image_url'   => home_url( '/wp-content/uploads/2026/09/Group-7-1.png' ),
            )
        );
        ?>
    </template>

    <style>
        .pacto-slide-card {
            background: #fff;
            border: 1px solid #ccd0d4;
            border-left: 4px solid #D42E12;
            border-radius: 4px;
            margin-bottom: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            transition: box-shadow 0.2s;
        }
        .pacto-slide-card:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.08);
        }
        .pacto-slide-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            background: #f6f7f7;
            border-bottom: 1px solid #eee;
            cursor: move;
            user-select: none;
        }
        .pacto-slide-title {
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #1d2327;
        }
        .pacto-slide-body {
            padding: 16px;
            display: grid;
            grid-template-columns: 1fr 280px;
            gap: 20px;
        }
        @media (max-width: 900px) {
            .pacto-slide-body {
                grid-template-columns: 1fr;
            }
        }
        .pacto-field-group {
            margin-bottom: 12px;
        }
        .pacto-field-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 4px;
            font-size: 13px;
        }
        .pacto-field-group input[type="text"],
        .pacto-field-group textarea {
            width: 100%;
        }
        .pacto-image-preview-box {
            background: #f9f9f9;
            border: 2px dashed #ddd;
            border-radius: 6px;
            padding: 12px;
            text-align: center;
            min-height: 180px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .pacto-image-preview-box img {
            max-width: 100%;
            max-height: 140px;
            height: auto;
            display: block;
            margin-bottom: 10px;
            object-fit: contain;
            border-radius: 4px;
        }
        .pacto-sortable-placeholder {
            border: 2px dashed #D42E12;
            background: #FDF2F0;
            height: 120px;
            margin-bottom: 16px;
            border-radius: 4px;
        }
    </style>

    <script>
    jQuery(document).ready(function($) {
        const container = $('#pacto-slides-container');

        // Drag & drop sortable
        container.sortable({
            handle: '.pacto-slide-header',
            placeholder: 'pacto-sortable-placeholder',
            opacity: 0.8,
            update: updateIndices
        });

        // Add Slide
        $('#pacto-add-slide-btn').on('click', function(e) {
            e.preventDefault();
            const count = container.children('.pacto-slide-card').length;
            const template = $('#pacto-slide-template').html();
            const newHtml = template.replace(/__INDEX__/g, count);
            const $newSlide = $(newHtml).hide();
            container.append($newSlide);
            $newSlide.fadeIn(300);
            updateIndices();
            $('html, body').animate({ scrollTop: $newSlide.offset().top - 80 }, 400);
        });

        // Remove Slide
        container.on('click', '.pacto-remove-slide-btn', function(e) {
            e.preventDefault();
            const total = container.children('.pacto-slide-card').length;
            if (total <= 1) {
                alert('<?php echo esc_js( __( 'O hero deve ter pelo menos um slide ativo.', 'pacto-25' ) ); ?>');
                return;
            }
            if (confirm('<?php echo esc_js( __( 'Tem a certeza que deseja remover este slide?', 'pacto-25' ) ); ?>')) {
                $(this).closest('.pacto-slide-card').fadeOut(250, function() {
                    $(this).remove();
                    updateIndices();
                });
            }
        });

        // Toggle Collapse/Expand
        container.on('click', '.pacto-toggle-slide-btn', function(e) {
            e.preventDefault();
            const card = $(this).closest('.pacto-slide-card');
            const body = card.find('.pacto-slide-body');
            const icon = $(this).find('.dashicons');
            body.slideToggle(200, function() {
                if (body.is(':visible')) {
                    icon.removeClass('dashicons-arrow-down-alt2').addClass('dashicons-arrow-up-alt2');
                } else {
                    icon.removeClass('dashicons-arrow-up-alt2').addClass('dashicons-arrow-down-alt2');
                }
            });
        });

        // Media Library Frame
        let file_frame;
        container.on('click', '.pacto-select-image-btn', function(e) {
            e.preventDefault();
            const btn = $(this);
            const card = btn.closest('.pacto-slide-card');
            const idInput = card.find('.pacto-image-id-input');
            const urlInput = card.find('.pacto-image-url-input');
            const previewBox = card.find('.pacto-image-preview-wrap');
            const removeBtn = card.find('.pacto-remove-image-btn');

            file_frame = wp.media({
                title: '<?php echo esc_js( __( 'Selecionar Imagem do Slide Hero', 'pacto-25' ) ); ?>',
                button: { text: '<?php echo esc_js( __( 'Utilizar esta Imagem', 'pacto-25' ) ); ?>' },
                multiple: false
            });

            file_frame.on('select', function() {
                const attachment = file_frame.state().get('selection').first().toJSON();
                idInput.val(attachment.id);
                urlInput.val(attachment.url);
                previewBox.html('<img src="' + attachment.url + '" alt="" />');
                removeBtn.show();
            });

            file_frame.open();
        });

        // Remove Image
        container.on('click', '.pacto-remove-image-btn', function(e) {
            e.preventDefault();
            const btn = $(this);
            const card = btn.closest('.pacto-slide-card');
            card.find('.pacto-image-id-input').val('');
            card.find('.pacto-image-url-input').val('');
            card.find('.pacto-image-preview-wrap').html('<span class="description"><?php echo esc_js( __( 'Nenhuma imagem selecionada', 'pacto-25' ) ); ?></span>');
            btn.hide();
        });

        function updateIndices() {
            container.children('.pacto-slide-card').each(function(idx) {
                $(this).find('.pacto-slide-num').text(idx + 1);
                $(this).find('input, textarea').each(function() {
                    const name = $(this).attr('name');
                    if (name) {
                        const updatedName = name.replace(/pacto_hero_slides\[\d+\]/, 'pacto_hero_slides[' + idx + ']');
                        $(this).attr('name', updatedName);
                    }
                });
            });
            $('.pacto-slide-counter').text('<?php echo esc_js( __( 'Total de slides: ', 'pacto-25' ) ); ?>' + container.children('.pacto-slide-card').length);
        }
    });
    </script>
    <?php
}

/**
 * Render HTML for a Single Slide Row
 *
 * @param int|string $index
 * @param array      $slide
 */
function pacto_render_single_slide_row( $index, $slide ) {
    $eyebrow     = isset( $slide['eyebrow'] ) ? $slide['eyebrow'] : '';
    $title       = isset( $slide['title'] ) ? $slide['title'] : '';
    $description = isset( $slide['description'] ) ? $slide['description'] : '';
    $btn_text    = isset( $slide['btn_text'] ) ? $slide['btn_text'] : '';
    $btn_url     = isset( $slide['btn_url'] ) ? $slide['btn_url'] : '#';
    $image_id    = isset( $slide['image_id'] ) ? (int) $slide['image_id'] : 0;
    $image_url   = isset( $slide['image_url'] ) ? $slide['image_url'] : '';

    $display_num = is_numeric( $index ) ? ( (int) $index + 1 ) : 1;
    ?>
    <div class="pacto-slide-card" data-index="<?php echo esc_attr( $index ); ?>">
        <div class="pacto-slide-header">
            <div class="pacto-slide-title">
                <span class="dashicons dashicons-menu" style="color: #888;"></span>
                <span><?php esc_html_e( 'Slide #', 'pacto-25' ); ?><span class="pacto-slide-num"><?php echo esc_html( $display_num ); ?></span></span>
                <span style="font-weight: 400; color: #666; margin-left: 8px;">
                    <?php echo esc_html( $title ? wp_trim_words( $title, 6, '...' ) : __( '(Sem título)', 'pacto-25' ) ); ?>
                </span>
            </div>
            <div class="pacto-slide-header-actions" style="display: flex; gap: 8px; align-items: center;">
                <button type="button" class="button-link pacto-toggle-slide-btn" title="<?php esc_attr_e( 'Minimizar / Expandir', 'pacto-25' ); ?>" style="text-decoration: none;">
                    <span class="dashicons dashicons-arrow-up-alt2"></span>
                </button>
                <button type="button" class="button-link-delete pacto-remove-slide-btn" title="<?php esc_attr_e( 'Remover Slide', 'pacto-25' ); ?>">
                    <span class="dashicons dashicons-trash" style="color: #b32d2e;"></span>
                </button>
            </div>
        </div>

        <div class="pacto-slide-body">
            <!-- Content Inputs -->
            <div class="pacto-slide-fields">
                <div class="pacto-field-group">
                    <label><?php esc_html_e( 'Eyebrow / Pré-título', 'pacto-25' ); ?></label>
                    <input type="text" name="pacto_hero_slides[<?php echo esc_attr( $index ); ?>][eyebrow]" value="<?php echo esc_attr( $eyebrow ); ?>" placeholder="SEGURAMENTE CONSIGO" />
                </div>

                <div class="pacto-field-group">
                    <label><?php esc_html_e( 'Título Principal (H1)', 'pacto-25' ); ?></label>
                    <input type="text" name="pacto_hero_slides[<?php echo esc_attr( $index ); ?>][title]" value="<?php echo esc_attr( $title ); ?>" placeholder="Pacto Seguro 25 anos ao seu Lado" />
                </div>

                <div class="pacto-field-group">
                    <label><?php esc_html_e( 'Descrição', 'pacto-25' ); ?></label>
                    <textarea name="pacto_hero_slides[<?php echo esc_attr( $index ); ?>][description]" rows="3" placeholder="Construímos relações duradouras..."><?php echo esc_textarea( $description ); ?></textarea>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div class="pacto-field-group">
                        <label><?php esc_html_e( 'Texto do Botão (Opcional)', 'pacto-25' ); ?></label>
                        <input type="text" name="pacto_hero_slides[<?php echo esc_attr( $index ); ?>][btn_text]" value="<?php echo esc_attr( $btn_text ); ?>" placeholder="conheça a nossa história" />
                    </div>
                    <div class="pacto-field-group">
                        <label><?php esc_html_e( 'Link do Botão (Slug, URL Relativa ou Completa)', 'pacto-25' ); ?></label>
                        <input type="text" name="pacto_hero_slides[<?php echo esc_attr( $index ); ?>][btn_url]" value="<?php echo esc_attr( $btn_url ); ?>" placeholder="ex: particulares ou /particulares/ ou #sobre ou https://..." />
                    </div>
                </div>
            </div>

            <!-- Image Selection Box -->
            <div class="pacto-slide-image-col">
                <div class="pacto-field-group">
                    <label><?php esc_html_e( 'Imagem / Ilustração do Slide', 'pacto-25' ); ?></label>
                    <div class="pacto-image-preview-box">
                        <div class="pacto-image-preview-wrap">
                            <?php if ( ! empty( $image_url ) ) : ?>
                                <img src="<?php echo esc_url( $image_url ); ?>" alt="" />
                            <?php else : ?>
                                <span class="description"><?php esc_html_e( 'Nenhuma imagem selecionada', 'pacto-25' ); ?></span>
                            <?php endif; ?>
                        </div>
                        <input type="hidden" class="pacto-image-id-input" name="pacto_hero_slides[<?php echo esc_attr( $index ); ?>][image_id]" value="<?php echo esc_attr( $image_id ); ?>" />
                        <input type="hidden" class="pacto-image-url-input" name="pacto_hero_slides[<?php echo esc_attr( $index ); ?>][image_url]" value="<?php echo esc_attr( $image_url ); ?>" />
                        <div style="margin-top: 8px; display: flex; gap: 6px;">
                            <button type="button" class="button button-secondary pacto-select-image-btn">
                                <?php esc_html_e( 'Alterar Imagem', 'pacto-25' ); ?>
                            </button>
                            <button type="button" class="button-link-delete pacto-remove-image-btn" style="<?php echo empty( $image_url ) ? 'display:none;' : ''; ?>">
                                <?php esc_html_e( 'Remover', 'pacto-25' ); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Save Meta Box Data Securely
 *
 * @param int $post_id
 */
function pacto_save_hero_slides_meta( $post_id ) {
    if ( ! isset( $_POST['pacto_hero_slides_nonce'] ) ) {
        return;
    }

    if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pacto_hero_slides_nonce'] ) ), 'pacto_save_hero_slides' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_page', $post_id ) ) {
        return;
    }

    if ( ! isset( $_POST['pacto_hero_slides'] ) || ! is_array( $_POST['pacto_hero_slides'] ) ) {
        return;
    }

    $raw_slides = wp_unslash( $_POST['pacto_hero_slides'] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
    $clean_slides = array();

    foreach ( $raw_slides as $slide ) {
        if ( ! is_array( $slide ) ) {
            continue;
        }

        $clean_slides[] = array(
            'eyebrow'     => sanitize_text_field( $slide['eyebrow'] ?? '' ),
            'title'       => sanitize_text_field( $slide['title'] ?? '' ),
            'description' => sanitize_textarea_field( $slide['description'] ?? '' ),
            'btn_text'    => sanitize_text_field( $slide['btn_text'] ?? '' ),
            'btn_url'     => sanitize_text_field( trim( $slide['btn_url'] ?? '#' ) ),
            'image_id'    => isset( $slide['image_id'] ) ? (int) $slide['image_id'] : 0,
            'image_url'   => esc_url_raw( $slide['image_url'] ?? '' ),
        );
    }

    if ( ! empty( $clean_slides ) ) {
        update_post_meta( $post_id, 'pacto_hero_slides', $clean_slides );
    } else {
        delete_post_meta( $post_id, 'pacto_hero_slides' );
    }
}
add_action( 'save_post', 'pacto_save_hero_slides_meta' );
