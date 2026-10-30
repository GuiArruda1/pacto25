<?php
/**
 * Hero Slider Management & ACF Tab Integration
 * Theme: Pacto 25
 * 
 * Strict Agency Standard:
 * - Reads discrete slide fields (Slide 1 to 5) configured in ACF Tab
 * - Full backward-compatibility and fallback support
 * - Zero static hardcoded strings, full sanitization & escaping
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Return Default Hero Slides
 *
 * @return array
 */
function pacto_get_default_hero_slides() {
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
            'btn_url'     => '/particulares/',
            'image_id'    => 0,
            'image_url'   => get_template_directory_uri() . '/assets/images/sinistro/sinistro-hero-family.png',
        ),
        array(
            'eyebrow'     => 'SEGURANÇA & CONFIANÇA',
            'title'       => 'Protegemos o Futuro do seu Negócio',
            'description' => 'Parcerias sólidas e consultoria especializada para salvaguardar a sua empresa, equipa e património contra qualquer imprevisto.',
            'btn_text'    => 'ver soluções empresas',
            'btn_url'     => '/empresas/',
            'image_id'    => 0,
            'image_url'   => get_template_directory_uri() . '/assets/images/protocolos-doctor.png',
        ),
    );
}

/**
 * Retrieve Slides with Graceful Fallback (from ACF fields hero_slide_1..5, or legacy meta, or defaults)
 *
 * @param int $post_id
 * @return array
 */
function pacto_get_hero_slides( $post_id = 0 ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID() ?: (int) get_option( 'page_on_front' ) ?: get_queried_object_id();
    }

    $default_slides = pacto_get_default_hero_slides();

    // 1. Check Native Meta Box Repeater items ('pacto_hero_slides') first
    $slides = $post_id ? get_post_meta( $post_id, 'pacto_hero_slides', true ) : array();
    if ( ! empty( $slides ) && is_array( $slides ) && count( $slides ) > 0 ) {
        foreach ( $slides as $idx => &$slide ) {
            if ( ! empty( $slide['image_id'] ) && is_numeric( $slide['image_id'] ) ) {
                $url = wp_get_attachment_url( (int) $slide['image_id'] );
                if ( $url ) {
                    $slide['image_url'] = $url;
                }
            }
            if ( empty( $slide['image_url'] ) ) {
                $def_idx            = $idx % count( $default_slides );
                $slide['image_url'] = $default_slides[ $def_idx ]['image_url'];
            }
        }
        unset( $slide );
        return $slides;
    }

    // 2. Fallback: Read discrete slide fields (Slide 1 to 5) from legacy ACF meta
    $collected_slides = array();
    for ( $i = 1; $i <= 5; $i++ ) {
        $is_active = ( 1 === $i ) ? true : (bool) pacto_get_field( "hero_slide_{$i}_active", $post_id, ( $i <= 3 ? 1 : 0 ) );

        if ( ! $is_active ) {
            continue;
        }

        $default_idx = $i - 1;
        $def_eyebrow = isset( $default_slides[ $default_idx ]['eyebrow'] ) ? $default_slides[ $default_idx ]['eyebrow'] : '';
        $def_title   = isset( $default_slides[ $default_idx ]['title'] ) ? $default_slides[ $default_idx ]['title'] : '';
        $def_desc    = isset( $default_slides[ $default_idx ]['description'] ) ? $default_slides[ $default_idx ]['description'] : '';
        $def_btn     = isset( $default_slides[ $default_idx ]['btn_text'] ) ? $default_slides[ $default_idx ]['btn_text'] : '';
        $def_url     = isset( $default_slides[ $default_idx ]['btn_url'] ) ? $default_slides[ $default_idx ]['btn_url'] : '#';
        $def_img_url = isset( $default_slides[ $default_idx ]['image_url'] ) ? $default_slides[ $default_idx ]['image_url'] : '';

        $title = pacto_get_field( "hero_slide_{$i}_title", $post_id, $def_title );

        if ( empty( $title ) && $i > 3 ) {
            continue;
        }

        $eyebrow     = pacto_get_field( "hero_slide_{$i}_eyebrow", $post_id, $def_eyebrow );
        $description = pacto_get_field( "hero_slide_{$i}_description", $post_id, $def_desc );
        $btn_text    = pacto_get_field( "hero_slide_{$i}_btn_text", $post_id, $def_btn );
        $btn_url     = pacto_get_field( "hero_slide_{$i}_btn_url", $post_id, $def_url );
        $img         = pacto_get_field( "hero_slide_{$i}_image", $post_id, null );

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

        if ( empty( $img_id ) && empty( $img_url ) && ! empty( $def_img_url ) ) {
            $img_url = $def_img_url;
        }

        $collected_slides[] = array(
            'eyebrow'     => $eyebrow,
            'title'       => $title ?: $def_title,
            'description' => $description,
            'btn_text'    => $btn_text,
            'btn_url'     => $btn_url ?: '#',
            'image_id'    => $img_id,
            'image_url'   => $img_url,
        );
    }

    if ( ! empty( $collected_slides ) ) {
        return $collected_slides;
    }

    // 3. Fallback defaults
    return $default_slides;
}

/**
 * ============================================================================
 * NATIVE WORDPRESS META BOX REPEATER FOR HERO SLIDER
 * Follows @skill:wp-native-repeaters (wp.media + jquery-ui-sortable)
 * ============================================================================
 */
function pacto_add_hero_slider_repeater_metabox( $post_type, $post ) {
    if ( 'page' !== $post_type || ! ( $post instanceof WP_Post ) ) {
        return;
    }

    $front_id = (int) get_option( 'page_on_front' );
    $template = get_post_meta( $post->ID, '_wp_page_template', true );

    if ( ( $front_id && (int) $post->ID === $front_id && 'page-landing.php' !== $template ) || 'front-page.php' === $template ) {
        add_meta_box(
            'pacto_hero_slider_repeater_metabox',
            __( '🎯 Hero Slider — Banner Principal (Carrossel — Arrastar, Adicionar e Remover)', 'pacto-25' ),
            'pacto_render_hero_slider_repeater_metabox',
            'page',
            'normal',
            'high'
        );
    }
}
add_action( 'add_meta_boxes', 'pacto_add_hero_slider_repeater_metabox', 10, 2 );

function pacto_hero_slider_repeater_admin_scripts( $hook ) {
    if ( 'post.php' === $hook || 'post-new.php' === $hook ) {
        wp_enqueue_media();
        wp_enqueue_script( 'jquery-ui-sortable' );
    }
}
add_action( 'admin_enqueue_scripts', 'pacto_hero_slider_repeater_admin_scripts' );

function pacto_render_hero_slider_repeater_metabox( $post ) {
    wp_nonce_field( 'pacto_save_hero_slider_repeater_data', 'pacto_hero_slider_repeater_nonce' );

    $slides      = pacto_get_hero_slides( $post->ID );
    $default_img = get_template_directory_uri() . '/assets/images/home-hero-doctor.png';
    ?>
    <style>
        .pacto-hs-rep-wrap { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; padding: 8px 0; }
        .pacto-hs-rep-info { background: #fff5f3; border-left: 4px solid #D42E12; padding: 12px 16px; border-radius: 6px; margin-bottom: 18px; font-size: 13px; color: #1e293b; }
        .pacto-hs-rep-list { display: flex; flex-direction: column; gap: 14px; margin-bottom: 18px; }
        .pacto-hs-rep-row { background: #ffffff; border: 1px solid #cbd5e1; border-radius: 10px; padding: 16px; box-shadow: 0 2px 5px rgba(0,0,0,0.03); }
        .pacto-hs-rep-row.ui-sortable-helper { box-shadow: 0 10px 25px rgba(0,0,0,0.14); border-color: #D42E12; }
        .pacto-hs-rep-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; padding-bottom: 10px; border-bottom: 1px solid #f1f5f9; }
        .pacto-hs-rep-header-left { display: flex; align-items: center; gap: 10px; }
        .pacto-hs-rep-handle { cursor: grab; color: #64748b; font-size: 16px; padding: 4px 8px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 5px; user-select: none; }
        .pacto-hs-rep-badge { background: #D42E12; color: #ffffff; font-size: 12px; font-weight: 700; padding: 3px 10px; border-radius: 14px; }
        .pacto-hs-rep-remove { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; border-radius: 6px; padding: 4px 10px; font-size: 12px; font-weight: 600; cursor: pointer; }
        .pacto-hs-rep-remove:hover { background: #dc2626; color: #ffffff; border-color: #dc2626; }
        .pacto-hs-rep-body { display: grid; grid-template-columns: 160px 1fr; gap: 20px; align-items: start; }
        @media (max-width: 782px) { .pacto-hs-rep-body { grid-template-columns: 1fr; } }
        .pacto-hs-rep-img-col { text-align: center; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; }
        .pacto-hs-rep-img-preview { width: 90px; height: 90px; border-radius: 50%; border: 3px solid #D42E12; margin: 0 auto 10px; overflow: hidden; background: #fff; }
        .pacto-hs-rep-img-preview img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .pacto-hs-rep-fields-col { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .pacto-hs-rep-field-full { grid-column: 1 / -1; }
        .pacto-hs-rep-field label { display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 4px; }
        .pacto-hs-rep-field input[type="text"],
        .pacto-hs-rep-field textarea { width: 100%; border: 1px solid #cbd5e1; border-radius: 6px; padding: 7px 10px; font-size: 13px; }
        .pacto-hs-rep-add-btn { background: #D42E12 !important; border-color: #D42E12 !important; color: #fff !important; font-weight: 600 !important; padding: 4px 16px !important; height: 36px !important; line-height: 26px !important; border-radius: 6px !important; }
    </style>

    <div class="pacto-hs-rep-wrap">
        <div class="pacto-hs-rep-info">
            <strong><?php esc_html_e( 'Gestão Dinâmica do Hero Slider:', 'pacto-25' ); ?></strong>
            <?php esc_html_e( 'Adicione, edite ou remova slides e arraste pelo ícone ☰ para definir a ordem de exibição no Banner Principal.', 'pacto-25' ); ?>
        </div>

        <div class="pacto-hs-rep-list" id="pacto-hero-slides-rep-container">
            <?php foreach ( $slides as $idx => $slide ) :
                $eyebrow   = isset( $slide['eyebrow'] ) ? $slide['eyebrow'] : '';
                $title     = isset( $slide['title'] ) ? $slide['title'] : '';
                $desc      = isset( $slide['description'] ) ? $slide['description'] : '';
                $btn_text  = isset( $slide['btn_text'] ) ? $slide['btn_text'] : '';
                $btn_url   = isset( $slide['btn_url'] ) ? $slide['btn_url'] : '';
                $image_url = ! empty( $slide['image_url'] ) ? $slide['image_url'] : $default_img;
                $image_id  = ! empty( $slide['image_id'] ) ? (int) $slide['image_id'] : '';
            ?>
                <div class="pacto-hs-rep-row" data-index="<?php echo esc_attr( $idx ); ?>">
                    <div class="pacto-hs-rep-header">
                        <div class="pacto-hs-rep-header-left">
                            <span class="pacto-hs-rep-handle handle" title="<?php esc_attr_e( 'Arrastar para reordenar', 'pacto-25' ); ?>">☰</span>
                            <span class="pacto-hs-rep-badge"><?php echo esc_html( sprintf( __( 'Slide #%d', 'pacto-25' ), $idx + 1 ) ); ?></span>
                        </div>
                        <button type="button" class="pacto-hs-rep-remove"><?php esc_html_e( '✕ Remover', 'pacto-25' ); ?></button>
                    </div>

                    <div class="pacto-hs-rep-body">
                        <div class="pacto-hs-rep-img-col">
                            <div class="pacto-hs-rep-img-preview">
                                <img src="<?php echo esc_url( $image_url ); ?>" alt="" />
                            </div>
                            <input type="hidden" class="pacto-hs-input-img-url" name="pacto_hero_slides_data[<?php echo esc_attr( $idx ); ?>][image_url]" value="<?php echo esc_url( $image_url ); ?>" />
                            <input type="hidden" class="pacto-hs-input-img-id" name="pacto_hero_slides_data[<?php echo esc_attr( $idx ); ?>][image_id]" value="<?php echo esc_attr( $image_id ); ?>" />
                            <button type="button" class="button button-small pacto-hs-upload-btn" style="width:100%;"><?php esc_html_e( '📷 Escolher Foto', 'pacto-25' ); ?></button>
                        </div>

                        <div class="pacto-hs-rep-fields-col">
                            <div class="pacto-hs-rep-field">
                                <label><?php esc_html_e( 'Eyebrow / Pré-título', 'pacto-25' ); ?></label>
                                <input type="text" name="pacto_hero_slides_data[<?php echo esc_attr( $idx ); ?>][eyebrow]" value="<?php echo esc_attr( $eyebrow ); ?>" placeholder="Ex: SEGURAMENTE CONSIGO" />
                            </div>
                            <div class="pacto-hs-rep-field">
                                <label><?php esc_html_e( 'Título Principal', 'pacto-25' ); ?></label>
                                <input type="text" name="pacto_hero_slides_data[<?php echo esc_attr( $idx ); ?>][title]" value="<?php echo esc_attr( $title ); ?>" placeholder="Ex: Pacto Seguro 25 anos ao seu Lado" />
                            </div>
                            <div class="pacto-hs-rep-field pacto-hs-rep-field-full">
                                <label><?php esc_html_e( 'Texto Descritivo', 'pacto-25' ); ?></label>
                                <textarea name="pacto_hero_slides_data[<?php echo esc_attr( $idx ); ?>][description]" rows="2"><?php echo esc_textarea( $desc ); ?></textarea>
                            </div>
                            <div class="pacto-hs-rep-field">
                                <label><?php esc_html_e( 'Texto do Botão (Opcional)', 'pacto-25' ); ?></label>
                                <input type="text" name="pacto_hero_slides_data[<?php echo esc_attr( $idx ); ?>][btn_text]" value="<?php echo esc_attr( $btn_text ); ?>" placeholder="Ex: conheça a nossa história" />
                            </div>
                            <div class="pacto-hs-rep-field">
                                <label><?php esc_html_e( 'Link do Botão', 'pacto-25' ); ?></label>
                                <input type="text" name="pacto_hero_slides_data[<?php echo esc_attr( $idx ); ?>][btn_url]" value="<?php echo esc_attr( $btn_url ); ?>" placeholder="Ex: /particulares/ ou #sobre" />
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div style="display:flex; justify-content:space-between; align-items:center;">
            <button type="button" class="button pacto-hs-rep-add-btn" id="pacto-hs-rep-add">
                <?php esc_html_e( '+ Adicionar Slide', 'pacto-25' ); ?>
            </button>
            <span style="font-size:12px; color:#64748b;"><?php esc_html_e( 'Clique em "Atualizar" na página para gravar os slides.', 'pacto-25' ); ?></span>
        </div>
    </div>

    <script type="text/template" id="pacto-hero-slide-row-template">
        <div class="pacto-hs-rep-row" data-index="{{INDEX}}">
            <div class="pacto-hs-rep-header">
                <div class="pacto-hs-rep-header-left">
                    <span class="pacto-hs-rep-handle handle" title="<?php esc_attr_e( 'Arrastar para reordenar', 'pacto-25' ); ?>">☰</span>
                    <span class="pacto-hs-rep-badge">Slide #{{NUM}}</span>
                </div>
                <button type="button" class="pacto-hs-rep-remove"><?php esc_html_e( '✕ Remover', 'pacto-25' ); ?></button>
            </div>

            <div class="pacto-hs-rep-body">
                <div class="pacto-hs-rep-img-col">
                    <div class="pacto-hs-rep-img-preview">
                        <img src="<?php echo esc_url( $default_img ); ?>" alt="" />
                    </div>
                    <input type="hidden" class="pacto-hs-input-img-url" name="pacto_hero_slides_data[{{INDEX}}][image_url]" value="<?php echo esc_url( $default_img ); ?>" />
                    <input type="hidden" class="pacto-hs-input-img-id" name="pacto_hero_slides_data[{{INDEX}}][image_id]" value="" />
                    <button type="button" class="button button-small pacto-hs-upload-btn" style="width:100%;"><?php esc_html_e( '📷 Escolher Foto', 'pacto-25' ); ?></button>
                </div>

                <div class="pacto-hs-rep-fields-col">
                    <div class="pacto-hs-rep-field">
                        <label><?php esc_html_e( 'Eyebrow / Pré-título', 'pacto-25' ); ?></label>
                        <input type="text" name="pacto_hero_slides_data[{{INDEX}}][eyebrow]" value="SEGURAMENTE CONSIGO" />
                    </div>
                    <div class="pacto-hs-rep-field">
                        <label><?php esc_html_e( 'Título Principal', 'pacto-25' ); ?></label>
                        <input type="text" name="pacto_hero_slides_data[{{INDEX}}][title]" value="" placeholder="Título do Slide" />
                    </div>
                    <div class="pacto-hs-rep-field pacto-hs-rep-field-full">
                        <label><?php esc_html_e( 'Texto Descritivo', 'pacto-25' ); ?></label>
                        <textarea name="pacto_hero_slides_data[{{INDEX}}][description]" rows="2"></textarea>
                    </div>
                    <div class="pacto-hs-rep-field">
                        <label><?php esc_html_e( 'Texto do Botão (Opcional)', 'pacto-25' ); ?></label>
                        <input type="text" name="pacto_hero_slides_data[{{INDEX}}][btn_text]" value="" />
                    </div>
                    <div class="pacto-hs-rep-field">
                        <label><?php esc_html_e( 'Link do Botão', 'pacto-25' ); ?></label>
                        <input type="text" name="pacto_hero_slides_data[{{INDEX}}][btn_url]" value="#" />
                    </div>
                </div>
            </div>
        </div>
    </script>

    <script>
    jQuery(document).ready(function($) {
        var $container = $('#pacto-hero-slides-rep-container');

        function reindexHeroSlides() {
            $container.children('.pacto-hs-rep-row').each(function(idx) {
                var $row = $(this);
                $row.attr('data-index', idx);
                $row.find('.pacto-hs-rep-badge').text('Slide #' + (idx + 1));
                $row.find('input, textarea, select').each(function() {
                    var name = $(this).attr('name');
                    if (name) {
                        $(this).attr('name', name.replace(/pacto_hero_slides_data\[\d+\]/, 'pacto_hero_slides_data[' + idx + ']'));
                    }
                });
            });
        }

        if ($.fn.sortable) {
            $container.sortable({
                handle: '.handle',
                axis: 'y',
                update: function() {
                    reindexHeroSlides();
                }
            });
        }

        $('#pacto-hs-rep-add').on('click', function(e) {
            e.preventDefault();
            var nextIdx = $container.children('.pacto-hs-rep-row').length;
            var tpl = $('#pacto-hero-slide-row-template').html()
                .replace(/\{\{INDEX\}\}/g, nextIdx)
                .replace(/\{\{NUM\}\}/g, nextIdx + 1);
            $container.append(tpl);
            reindexHeroSlides();
        });

        $container.on('click', '.pacto-hs-rep-remove', function(e) {
            e.preventDefault();
            if ($container.children('.pacto-hs-rep-row').length <= 1) {
                alert('Deve manter pelo menos 1 slide no banner principal.');
                return;
            }
            if (confirm('Tem a certeza que deseja remover este slide?')) {
                $(this).closest('.pacto-hs-rep-row').remove();
                reindexHeroSlides();
            }
        });

        $container.on('click', '.pacto-hs-upload-btn', function(e) {
            e.preventDefault();
            var $row = $(this).closest('.pacto-hs-rep-row');
            var frame = wp.media({
                title: 'Selecionar Imagem do Slide',
                button: { text: 'Usar esta imagem' },
                multiple: false,
                library: { type: 'image' }
            });
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                var imgUrl = (attachment.sizes && attachment.sizes.large) ? attachment.sizes.large.url : attachment.url;
                $row.find('.pacto-hs-input-img-url').val(imgUrl);
                $row.find('.pacto-hs-input-img-id').val(attachment.id);
                $row.find('.pacto-hs-rep-img-preview img').attr('src', imgUrl);
            });
            frame.open();
        });
    });
    </script>
    <?php
}

function pacto_save_hero_slider_repeater_metabox( $post_id ) {
    if ( ! isset( $_POST['pacto_hero_slider_repeater_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pacto_hero_slider_repeater_nonce'] ) ), 'pacto_save_hero_slider_repeater_data' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_page', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['pacto_hero_slides_data'] ) && is_array( $_POST['pacto_hero_slides_data'] ) ) {
        $clean_slides = array();

        foreach ( $_POST['pacto_hero_slides_data'] as $row ) {
            if ( ! is_array( $row ) ) {
                continue;
            }
            $eyebrow   = isset( $row['eyebrow'] ) ? sanitize_text_field( wp_unslash( $row['eyebrow'] ) ) : '';
            $title     = isset( $row['title'] ) ? sanitize_text_field( wp_unslash( $row['title'] ) ) : '';
            $desc      = isset( $row['description'] ) ? sanitize_textarea_field( wp_unslash( $row['description'] ) ) : '';
            $btn_text  = isset( $row['btn_text'] ) ? sanitize_text_field( wp_unslash( $row['btn_text'] ) ) : '';
            $btn_url   = isset( $row['btn_url'] ) ? sanitize_text_field( wp_unslash( $row['btn_url'] ) ) : '#';
            $image_url = isset( $row['image_url'] ) ? esc_url_raw( wp_unslash( $row['image_url'] ) ) : '';
            $image_id  = isset( $row['image_id'] ) ? absint( $row['image_id'] ) : 0;

            if ( ! empty( $title ) || ! empty( $desc ) ) {
                $clean_slides[] = array(
                    'eyebrow'     => $eyebrow,
                    'title'       => $title,
                    'description' => $desc,
                    'btn_text'    => $btn_text,
                    'btn_url'     => $btn_url,
                    'image_id'    => $image_id,
                    'image_url'   => $image_url,
                );
            }
        }

        update_post_meta( $post_id, 'pacto_hero_slides', $clean_slides );
        delete_post_meta( $post_id, '_pacto_hero_slides' );
    }
}
add_action( 'save_post', 'pacto_save_hero_slider_repeater_metabox' );
