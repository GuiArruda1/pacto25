<?php
/**
 * Custom Post Type: Testemunhos (Testimonials)
 * Theme: Pacto 25
 * 
 * Creates a dedicated "Testemunhos" menu in WordPress Admin
 * with custom columns, avatar preview, role field, and query helper.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register Testemunho Post Type
 */
function pacto_register_cpt_testimonials() {
    $labels = array(
        'name'                  => _x( 'Testemunhos', 'Post type general name', 'pacto-25' ),
        'singular_name'         => _x( 'Testemunho', 'Post type singular name', 'pacto-25' ),
        'menu_name'             => _x( 'Testemunhos', 'Admin Menu text', 'pacto-25' ),
        'name_admin_bar'        => _x( 'Testemunho', 'Add New on Toolbar', 'pacto-25' ),
        'add_new'               => __( 'Adicionar Novo', 'pacto-25' ),
        'add_new_item'          => __( 'Adicionar Novo Testemunho', 'pacto-25' ),
        'new_item'              => __( 'Novo Testemunho', 'pacto-25' ),
        'edit_item'             => __( 'Editar Testemunho', 'pacto-25' ),
        'view_item'             => __( 'Ver Testemunho', 'pacto-25' ),
        'all_items'             => __( 'Todos os Testemunhos', 'pacto-25' ),
        'search_items'          => __( 'Pesquisar Testemunhos', 'pacto-25' ),
        'parent_item_colon'     => __( 'Testemunho Pai:', 'pacto-25' ),
        'not_found'             => __( 'Nenhum testemunho encontrado.', 'pacto-25' ),
        'not_found_in_trash'    => __( 'Nenhum testemunho no lixo.', 'pacto-25' ),
        'featured_image'        => _x( 'Foto do Autor / Avatar', 'Overrides the “Featured Image” phrase', 'pacto-25' ),
        'set_featured_image'    => _x( 'Definir foto do autor', 'Overrides the “Set featured image” phrase', 'pacto-25' ),
        'remove_featured_image' => _x( 'Remover foto do autor', 'Overrides the “Remove featured image” phrase', 'pacto-25' ),
        'use_featured_image'    => _x( 'Usar como foto do autor', 'Overrides the “Use as featured image” phrase', 'pacto-25' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => false,
        'rewrite'            => false,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 21,
        'menu_icon'          => 'dashicons-format-quote',
        'show_in_rest'       => true,
        'supports'           => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
    );

    register_post_type( 'testemunho', $args );
}
add_action( 'init', 'pacto_register_cpt_testimonials', 0 );

/**
 * Add Meta Box for Role / Cargo if ACF is inactive
 */
function pacto_testimonial_meta_box() {
    add_meta_box(
        'pacto_testimonial_details',
        __( 'Detalhes do Testemunho', 'pacto-25' ),
        'pacto_testimonial_meta_box_render',
        'testemunho',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'pacto_testimonial_meta_box' );

function pacto_testimonial_meta_box_render( $post ) {
    wp_nonce_field( 'pacto_testimonial_meta_save', 'pacto_testimonial_nonce' );
    $role = get_post_meta( $post->ID, '_testimonial_role', true );
    ?>
    <div style="margin: 10px 0;">
        <label for="testimonial_role" style="display: block; font-weight: 600; margin-bottom: 6px;">
            <?php esc_html_e( 'Cargo / Função / Empresa do Autor:', 'pacto-25' ); ?>
        </label>
        <input 
            type="text" 
            id="testimonial_role" 
            name="testimonial_role" 
            value="<?php echo esc_attr( $role ); ?>" 
            placeholder="<?php esc_attr_e( 'ex: CEO, Consultora e Formadora, Diretor', 'pacto-25' ); ?>" 
            style="width: 100%; max-width: 500px; padding: 8px 12px; font-size: 14px;"
        />
        <p class="description" style="margin-top: 6px; color: #666;">
            <?php esc_html_e( 'Insira o cargo ou empresa do autor. A foto deve ser enviada em "Foto do Autor / Avatar" na coluna lateral.', 'pacto-25' ); ?>
        </p>
    </div>
    <?php
}

/**
 * Save Testimonial Meta
 */
function pacto_save_testimonial_meta( $post_id ) {
    if ( ! isset( $_POST['pacto_testimonial_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pacto_testimonial_nonce'] ) ), 'pacto_testimonial_meta_save' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['testimonial_role'] ) ) {
        update_post_meta( $post_id, '_testimonial_role', sanitize_text_field( wp_unslash( $_POST['testimonial_role'] ) ) );
    }
}
add_action( 'save_post_testemunho', 'pacto_save_testimonial_meta' );

/**
 * Custom Columns in Testimonials Admin List Table
 */
function pacto_testimonial_custom_columns( $columns ) {
    $new_columns = array();
    $new_columns['cb']          = $columns['cb'];
    $new_columns['avatar']      = __( 'Foto', 'pacto-25' );
    $new_columns['title']       = __( 'Nome do Autor', 'pacto-25' );
    $new_columns['role']        = __( 'Cargo / Empresa', 'pacto-25' );
    $new_columns['quote']       = __( 'Depoimento', 'pacto-25' );
    $new_columns['menu_order']   = __( 'Ordem', 'pacto-25' );
    $new_columns['date']        = $columns['date'];
    return $new_columns;
}
add_filter( 'manage_testemunho_posts_columns', 'pacto_testimonial_custom_columns' );

function pacto_testimonial_custom_columns_data( $column, $post_id ) {
    switch ( $column ) {
        case 'avatar':
            if ( has_post_thumbnail( $post_id ) ) {
                echo get_the_post_thumbnail( $post_id, array( 48, 48 ), array(
                    'style' => 'border-radius: 50%; width: 48px; height: 48px; object-fit: cover; border: 2px solid #D42E12;',
                ) );
            } else {
                echo '<div style="width: 48px; height: 48px; border-radius: 50%; background: #eee; display: flex; align-items: center; justify-content: center; color: #999; font-size: 10px;">Sem foto</div>';
            }
            break;

        case 'role':
            $role = '';
            if ( function_exists( 'get_field' ) ) {
                $role = get_field( 'testimonial_role', $post_id );
            }
            if ( ! $role ) {
                $role = get_post_meta( $post_id, 'testimonial_role', true );
            }
            if ( ! $role || strpos( $role, 'field_' ) === 0 ) {
                $role = get_post_meta( $post_id, '_testimonial_role_plain', true );
            }
            echo esc_html( $role ? $role : '—' );
            break;

        case 'quote':
            $quote = get_post_field( 'post_content', $post_id );
            if ( empty( $quote ) && function_exists( 'get_field' ) ) {
                $quote = get_field( 'testimonial_quote', $post_id );
            }
            $clean_quote = wp_strip_all_tags( $quote );
            echo esc_html( wp_trim_words( $clean_quote, 15, '...' ) );
            break;

        case 'menu_order':
            $post = get_post( $post_id );
            echo esc_html( $post->menu_order );
            break;
    }
}
add_action( 'manage_testemunho_posts_custom_column', 'pacto_testimonial_custom_columns_data', 10, 2 );

/**
 * Make Order Column Sortable
 */
function pacto_testimonial_sortable_columns( $columns ) {
    $columns['menu_order'] = 'menu_order';
    $columns['role']       = 'role';
    return $columns;
}
add_filter( 'manage_edit-testemunho_sortable_columns', 'pacto_testimonial_sortable_columns' );

/**
 * Default Figma Testimonials
 *
 * @return array
 */
function pacto_get_default_testimonials() {
    $default_avatars = array(
        1 => get_template_directory_uri() . '/assets/images/testimonials/avatar-1.png',
        2 => get_template_directory_uri() . '/assets/images/testimonials/avatar-2.png',
        3 => get_template_directory_uri() . '/assets/images/testimonials/avatar-3.png',
        4 => get_template_directory_uri() . '/assets/images/testimonials/avatar-4.png',
        5 => get_template_directory_uri() . '/assets/images/testimonials/avatar-5.png',
    );

    return array(
        1 => array(
            'id'     => 1,
            'name'   => 'Helena Sequeira',
            'role'   => 'Consultora e Formadora',
            'quote'  => '“A Pacto Seguro tem sido uma ótima parceira em todas as vertentes da minha vida. A confiança é um ponto fulcral e nesta equipa confio ao ponto de pedir conselhos, pois, confesso, não tenho muito tempo para resolver problemas ou pesquisar. Estou grata por me ajudarem no meu Caminho.”',
            'avatar' => $default_avatars[1],
        ),
        2 => array(
            'id'     => 2,
            'name'   => 'Sérgio Simões',
            'role'   => 'Chief Operations',
            'quote'  => '“A Pacto Seguro construiu uma relação de confiança com a nossa empresa, dando uma resposta séria a todas as nossas solicitações e necessidades, mas também oferecendo melhores soluções para a nossa actividade. A verdadeira parceria!”',
            'avatar' => $default_avatars[2],
        ),
        3 => array(
            'id'     => 3,
            'name'   => 'Maria do Carmo',
            'role'   => 'CEO',
            'quote'  => '“Para além da diversidade dos produtos disponíveis, a deferência que têm para connosco é para nós crucial nesta relação.”',
            'avatar' => $default_avatars[3],
        ),
        4 => array(
            'id'     => 4,
            'name'   => 'Ricardo Flaminio',
            'role'   => 'Diretor',
            'quote'  => 'A Pacto Seguro sempre respondeu com prontidão a todos os pedidos realizados e alterações necessárias. Destaco a rapidez e prontidão como as principais características de trabalho desta empresa.',
            'avatar' => $default_avatars[4],
        ),
        5 => array(
            'id'     => 5,
            'name'   => 'Anabela Ferreira',
            'role'   => 'General Manager',
            'quote'  => 'Temos na Pacto Seguro todos os nossos seguros há vários anos, é um parceiro transparente e honesto com quem nos identificamos. Sentimos sempre um tratamento personalizado e não somente mais um cliente! Obrigado por toda a vossa ajuda e amizade ao longo dos anos.',
            'avatar' => $default_avatars[5],
        ),
    );
}

/**
 * Helper: Fetch Testimonials combining Homepage ACF Tab fields, CPT posts, and Figma defaults
 *
 * @return array
 */
function pacto_get_testimonials_list() {
    $defaults = pacto_get_default_testimonials();
    $front_id = (int) get_option( 'page_on_front' );
    if ( ! $front_id ) {
        $front_id = get_the_ID();
    }

    // 1. Query published 'testemunho' CPT posts
    $args = array(
        'post_type'      => 'testemunho',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => array( 'menu_order' => 'ASC', 'ID' => 'ASC' ),
    );

    $query     = new WP_Query( $args );
    $cpt_items = array();

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $post_id = get_the_ID();

            // Avatar photo: Featured Image or ACF field
            $avatar_url = '';
            if ( has_post_thumbnail( $post_id ) ) {
                $avatar_url = get_the_post_thumbnail_url( $post_id, 'medium' );
            } elseif ( function_exists( 'get_field' ) ) {
                $acf_img    = get_field( 'testimonial_avatar', $post_id );
                $avatar_url = pacto_get_image_url( $acf_img, '', 'medium' );
            }

            // Role / Cargo
            $role = '';
            if ( function_exists( 'get_field' ) ) {
                $role = get_field( 'testimonial_role', $post_id );
            }
            if ( ! $role ) {
                $role = get_post_meta( $post_id, 'testimonial_role', true );
            }
            if ( ! $role || strpos( (string) $role, 'field_' ) === 0 ) {
                $role = get_post_meta( $post_id, '_testimonial_role_plain', true );
            }
            if ( ! $role || strpos( (string) $role, 'field_' ) === 0 ) {
                $role = get_post_meta( $post_id, '_testimonial_role', true );
                if ( strpos( (string) $role, 'field_' ) === 0 ) {
                    $role = '';
                }
            }

            // Quote / Depoimento
            $quote = '';
            if ( function_exists( 'get_field' ) ) {
                $quote = get_field( 'testimonial_quote', $post_id );
            }
            if ( empty( $quote ) ) {
                $quote = get_post_meta( $post_id, 'testimonial_quote', true );
            }
            if ( empty( $quote ) ) {
                $quote = get_the_content();
            }
            $quote = wp_strip_all_tags( (string) $quote );

            $cpt_items[] = array(
                'id'     => $post_id,
                'name'   => get_the_title(),
                'role'   => $role ? $role : '',
                'quote'  => $quote,
                'avatar' => $avatar_url,
            );
        }
        wp_reset_postdata();
    }

    // 2. Check Native Meta Box Repeater items ('pacto_testimonials_items') on Front Page first
    if ( $front_id ) {
        $native_items = get_post_meta( $front_id, 'pacto_testimonials_items', true );
        if ( ! empty( $native_items ) && is_array( $native_items ) ) {
            $resolved_native = array();
            foreach ( $native_items as $idx => $n_item ) {
                $slot       = ( $idx % 5 ) + 1;
                $def_avatar = isset( $defaults[ $slot ]['avatar'] ) ? $defaults[ $slot ]['avatar'] : $defaults[1]['avatar'];
                $avatar_url = '';

                if ( ! empty( $n_item['avatar_id'] ) && is_numeric( $n_item['avatar_id'] ) ) {
                    $avatar_url = wp_get_attachment_image_url( (int) $n_item['avatar_id'], 'medium' );
                }
                if ( empty( $avatar_url ) && ! empty( $n_item['avatar'] ) ) {
                    $avatar_url = pacto_get_image_url( $n_item['avatar'], '', 'medium' );
                }
                if ( empty( $avatar_url ) ) {
                    $avatar_url = $def_avatar;
                }

                $resolved_native[] = array(
                    'id'        => $idx + 1,
                    'name'      => ! empty( $n_item['name'] ) ? $n_item['name'] : '',
                    'role'      => ! empty( $n_item['role'] ) ? $n_item['role'] : '',
                    'quote'     => ! empty( $n_item['quote'] ) ? $n_item['quote'] : '',
                    'avatar'    => $avatar_url,
                    'avatar_id' => ! empty( $n_item['avatar_id'] ) ? (int) $n_item['avatar_id'] : 0,
                );
            }
            if ( ! empty( $resolved_native ) ) {
                return $resolved_native;
            }
        }
    }

    // 3. Merge legacy Homepage ACF Tab slots (1 to 5) with CPT and Figma defaults
    $items = array();
    for ( $i = 1; $i <= 5; $i++ ) {
        $def = isset( $defaults[ $i ] ) ? $defaults[ $i ] : array(
            'id'     => $i,
            'name'   => '',
            'role'   => '',
            'quote'  => '',
            'avatar' => '',
        );
        $cpt = isset( $cpt_items[ $i - 1 ] ) ? $cpt_items[ $i - 1 ] : null;

        $acf_name   = $front_id ? pacto_get_field( "testimonial_{$i}_name", $front_id, '' ) : '';
        $acf_role   = $front_id ? pacto_get_field( "testimonial_{$i}_role", $front_id, '' ) : '';
        $acf_quote  = $front_id ? pacto_get_field( "testimonial_{$i}_quote", $front_id, '' ) : '';
        $acf_avatar = $front_id ? pacto_get_field( "testimonial_{$i}_avatar", $front_id, '' ) : '';

        $avatar_id  = 0;
        if ( is_array( $acf_avatar ) && ! empty( $acf_avatar['ID'] ) ) {
            $avatar_id = (int) $acf_avatar['ID'];
        } elseif ( is_numeric( $acf_avatar ) && (int) $acf_avatar > 0 ) {
            $avatar_id = (int) $acf_avatar;
        } elseif ( $cpt && has_post_thumbnail( $cpt['id'] ) ) {
            $avatar_id = (int) get_post_thumbnail_id( $cpt['id'] );
        }

        $avatar_url = pacto_get_image_url( $acf_avatar, '', 'medium' );
        if ( empty( $avatar_url ) && $cpt && ! empty( $cpt['avatar'] ) ) {
            $avatar_url = $cpt['avatar'];
        }
        if ( empty( $avatar_url ) ) {
            $avatar_url = $def['avatar'];
        }

        $name  = ! empty( $acf_name ) ? $acf_name : ( $cpt && ! empty( $cpt['name'] ) ? $cpt['name'] : $def['name'] );
        $role  = ! empty( $acf_role ) ? $acf_role : ( $cpt && ! empty( $cpt['role'] ) ? $cpt['role'] : $def['role'] );
        $quote = ! empty( $acf_quote ) ? $acf_quote : ( $cpt && ! empty( $cpt['quote'] ) ? $cpt['quote'] : $def['quote'] );

        $items[] = array(
            'id'        => $cpt ? $cpt['id'] : $i,
            'name'      => $name,
            'role'      => $role,
            'quote'     => $quote,
            'avatar'    => $avatar_url,
            'avatar_id' => $avatar_id,
        );
    }

    // 4. Append any additional CPT testimonials beyond the first 5
    if ( count( $cpt_items ) > 5 ) {
        for ( $j = 5; $j < count( $cpt_items ); $j++ ) {
            $extra = $cpt_items[ $j ];
            if ( empty( $extra['avatar'] ) ) {
                $fallback_idx    = ( $j % 5 ) + 1;
                $extra['avatar'] = $defaults[ $fallback_idx ]['avatar'];
            }
            $items[] = $extra;
        }
    }

    return $items;
}

/**
 * ============================================================================
 * NATIVE WORDPRESS META BOX REPEATER FOR HOMEPAGE TESTIMONIALS
 * Follows @skill:wp-native-repeaters (wp.media + jquery-ui-sortable)
 * ============================================================================
 */
function pacto_add_testimonials_repeater_metabox( $post_type, $post ) {
    if ( 'page' !== $post_type || ! ( $post instanceof WP_Post ) ) {
        return;
    }

    $front_id = (int) get_option( 'page_on_front' );
    $template = get_post_meta( $post->ID, '_wp_page_template', true );

    if ( ( $front_id && (int) $post->ID === $front_id && 'page-landing.php' !== $template ) || 'front-page.php' === $template ) {
        add_meta_box(
            'pacto_testimonials_repeater_metabox',
            __( '💬 Testemunhos de Clientes (Carrossel — Arrastar, Adicionar e Remover)', 'pacto-25' ),
            'pacto_render_testimonials_repeater_metabox',
            'page',
            'normal',
            'high'
        );
    }
}
add_action( 'add_meta_boxes', 'pacto_add_testimonials_repeater_metabox', 10, 2 );

function pacto_testimonials_repeater_admin_scripts( $hook ) {
    if ( 'post.php' === $hook || 'post-new.php' === $hook ) {
        wp_enqueue_media();
        wp_enqueue_script( 'jquery-ui-sortable' );
    }
}
add_action( 'admin_enqueue_scripts', 'pacto_testimonials_repeater_admin_scripts' );

function pacto_render_testimonials_repeater_metabox( $post ) {
    wp_nonce_field( 'pacto_save_testimonials_repeater_data', 'pacto_testimonials_repeater_nonce' );

    $items = pacto_get_testimonials_list();
    $default_avatar_placeholder = get_template_directory_uri() . '/assets/images/testimonials/avatar-1.png';
    ?>
    <style>
        .pacto-t-rep-wrap { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; padding: 8px 0; }
        .pacto-t-rep-info { background: #fff5f3; border-left: 4px solid #D42E12; padding: 12px 16px; border-radius: 6px; margin-bottom: 18px; font-size: 13px; color: #1e293b; }
        .pacto-t-rep-list { display: flex; flex-direction: column; gap: 14px; margin-bottom: 18px; }
        .pacto-t-rep-row { background: #ffffff; border: 1px solid #cbd5e1; border-radius: 10px; padding: 16px; box-shadow: 0 2px 5px rgba(0,0,0,0.03); transition: border-color 0.2s, box-shadow 0.2s; }
        .pacto-t-rep-row:hover { border-color: #94a3b8; box-shadow: 0 4px 12px rgba(0,0,0,0.06); }
        .pacto-t-rep-row.ui-sortable-helper { box-shadow: 0 10px 25px rgba(0,0,0,0.14); border-color: #D42E12; }
        .pacto-t-rep-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; padding-bottom: 10px; border-bottom: 1px solid #f1f5f9; }
        .pacto-t-rep-header-left { display: flex; align-items: center; gap: 10px; }
        .pacto-t-rep-handle { cursor: grab; color: #64748b; font-size: 16px; padding: 4px 8px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 5px; user-select: none; }
        .pacto-t-rep-handle:active { cursor: grabbing; }
        .pacto-t-rep-badge { background: #1e293b; color: #ffffff; font-size: 12px; font-weight: 700; padding: 3px 10px; border-radius: 14px; }
        .pacto-t-rep-remove { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; border-radius: 6px; padding: 4px 10px; font-size: 12px; font-weight: 600; cursor: pointer; }
        .pacto-t-rep-remove:hover { background: #dc2626; color: #ffffff; border-color: #dc2626; }
        .pacto-t-rep-body { display: grid; grid-template-columns: 150px 1fr; gap: 20px; align-items: start; }
        @media (max-width: 782px) { .pacto-t-rep-body { grid-template-columns: 1fr; } }
        .pacto-t-rep-avatar-col { text-align: center; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; }
        .pacto-t-rep-avatar-preview { width: 76px; height: 76px; border-radius: 50%; border: 3px solid #D42E12; margin: 0 auto 10px; overflow: hidden; background: #fff; display: flex; align-items: center; justify-content: center; }
        .pacto-t-rep-avatar-preview img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .pacto-t-rep-fields-col { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .pacto-t-rep-field-full { grid-column: 1 / -1; }
        .pacto-t-rep-field label { display: block; font-size: 12px; font-weight: 600; color: #334155; margin-bottom: 4px; }
        .pacto-t-rep-field input[type="text"],
        .pacto-t-rep-field textarea { width: 100%; border: 1px solid #cbd5e1; border-radius: 6px; padding: 7px 10px; font-size: 13px; }
        .pacto-t-rep-field input[type="text"]:focus,
        .pacto-t-rep-field textarea:focus { border-color: #D42E12; outline: none; box-shadow: 0 0 0 2px rgba(212,46,18,0.15); }
        .pacto-t-rep-footer { display: flex; justify-content: space-between; align-items: center; padding-top: 8px; }
        .pacto-t-rep-add-btn { background: #D42E12 !important; border-color: #D42E12 !important; color: #fff !important; font-weight: 600 !important; padding: 4px 16px !important; height: 36px !important; line-height: 26px !important; border-radius: 6px !important; }
        .pacto-t-rep-add-btn:hover { background: #b5240d !important; border-color: #b5240d !important; }
    </style>

    <div class="pacto-t-rep-wrap">
        <div class="pacto-t-rep-info">
            <strong><?php esc_html_e( 'Gestão Dinâmica de Testemunhos:', 'pacto-25' ); ?></strong>
            <?php esc_html_e( 'Adicione quantos testemunhos desejar, altere a fotografia circular de cada autor e arraste pelo ícone ☰ para reordenar a exibição no carrossel.', 'pacto-25' ); ?>
        </div>

        <div class="pacto-t-rep-list" id="pacto-testimonials-rep-container">
            <?php foreach ( $items as $idx => $item ) :
                $name      = isset( $item['name'] ) ? $item['name'] : '';
                $role      = isset( $item['role'] ) ? $item['role'] : '';
                $quote     = isset( $item['quote'] ) ? $item['quote'] : '';
                $avatar    = ! empty( $item['avatar'] ) ? $item['avatar'] : $default_avatar_placeholder;
                $avatar_id = ! empty( $item['avatar_id'] ) ? (int) $item['avatar_id'] : '';
            ?>
                <div class="pacto-t-rep-row" data-index="<?php echo esc_attr( $idx ); ?>">
                    <div class="pacto-t-rep-header">
                        <div class="pacto-t-rep-header-left">
                            <span class="pacto-t-rep-handle handle" title="<?php esc_attr_e( 'Arrastar para reordenar', 'pacto-25' ); ?>">☰</span>
                            <span class="pacto-t-rep-badge"><?php echo esc_html( sprintf( __( 'Testemunho #%d', 'pacto-25' ), $idx + 1 ) ); ?></span>
                        </div>
                        <button type="button" class="pacto-t-rep-remove"><?php esc_html_e( '✕ Remover', 'pacto-25' ); ?></button>
                    </div>

                    <div class="pacto-t-rep-body">
                        <div class="pacto-t-rep-avatar-col">
                            <div class="pacto-t-rep-avatar-preview">
                                <img src="<?php echo esc_url( $avatar ); ?>" alt="" />
                            </div>
                            <input type="hidden" class="pacto-t-input-avatar" name="pacto_testimonials[<?php echo esc_attr( $idx ); ?>][avatar]" value="<?php echo esc_url( $avatar ); ?>" />
                            <input type="hidden" class="pacto-t-input-avatar-id" name="pacto_testimonials[<?php echo esc_attr( $idx ); ?>][avatar_id]" value="<?php echo esc_attr( $avatar_id ); ?>" />
                            <button type="button" class="button button-small pacto-t-upload-btn" style="width:100%; margin-bottom:4px;"><?php esc_html_e( '📷 Escolher Foto', 'pacto-25' ); ?></button>
                        </div>

                        <div class="pacto-t-rep-fields-col">
                            <div class="pacto-t-rep-field">
                                <label><?php esc_html_e( 'Nome do Autor', 'pacto-25' ); ?></label>
                                <input type="text" class="pacto-t-input-name" name="pacto_testimonials[<?php echo esc_attr( $idx ); ?>][name]" value="<?php echo esc_attr( $name ); ?>" placeholder="Ex: Helena Sequeira" />
                            </div>
                            <div class="pacto-t-rep-field">
                                <label><?php esc_html_e( 'Cargo / Função / Empresa', 'pacto-25' ); ?></label>
                                <input type="text" class="pacto-t-input-role" name="pacto_testimonials[<?php echo esc_attr( $idx ); ?>][role]" value="<?php echo esc_attr( $role ); ?>" placeholder="Ex: Consultora e Formadora" />
                            </div>
                            <div class="pacto-t-rep-field pacto-t-rep-field-full">
                                <label><?php esc_html_e( 'Texto do Testemunho / Depoimento', 'pacto-25' ); ?></label>
                                <textarea class="pacto-t-input-quote" name="pacto_testimonials[<?php echo esc_attr( $idx ); ?>][quote]" rows="3" placeholder="Insira o depoimento do cliente..."><?php echo esc_textarea( $quote ); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="pacto-t-rep-footer">
            <button type="button" class="button pacto-t-rep-add-btn" id="pacto-t-rep-add">
                <?php esc_html_e( '+ Adicionar Testemunho', 'pacto-25' ); ?>
            </button>
            <span style="font-size:12px; color:#64748b;"><?php esc_html_e( 'Clique em "Atualizar" na página para gravar as alterações.', 'pacto-25' ); ?></span>
        </div>
    </div>

    <script type="text/template" id="pacto-testimonial-row-template">
        <div class="pacto-t-rep-row" data-index="{{INDEX}}">
            <div class="pacto-t-rep-header">
                <div class="pacto-t-rep-header-left">
                    <span class="pacto-t-rep-handle handle" title="<?php esc_attr_e( 'Arrastar para reordenar', 'pacto-25' ); ?>">☰</span>
                    <span class="pacto-t-rep-badge">Testemunho #{{NUM}}</span>
                </div>
                <button type="button" class="pacto-t-rep-remove"><?php esc_html_e( '✕ Remover', 'pacto-25' ); ?></button>
            </div>

            <div class="pacto-t-rep-body">
                <div class="pacto-t-rep-avatar-col">
                    <div class="pacto-t-rep-avatar-preview">
                        <img src="<?php echo esc_url( $default_avatar_placeholder ); ?>" alt="" />
                    </div>
                    <input type="hidden" class="pacto-t-input-avatar" name="pacto_testimonials[{{INDEX}}][avatar]" value="<?php echo esc_url( $default_avatar_placeholder ); ?>" />
                    <input type="hidden" class="pacto-t-input-avatar-id" name="pacto_testimonials[{{INDEX}}][avatar_id]" value="" />
                    <button type="button" class="button button-small pacto-t-upload-btn" style="width:100%; margin-bottom:4px;"><?php esc_html_e( '📷 Escolher Foto', 'pacto-25' ); ?></button>
                </div>

                <div class="pacto-t-rep-fields-col">
                    <div class="pacto-t-rep-field">
                        <label><?php esc_html_e( 'Nome do Autor', 'pacto-25' ); ?></label>
                        <input type="text" class="pacto-t-input-name" name="pacto_testimonials[{{INDEX}}][name]" value="" placeholder="Ex: Nome do Cliente" />
                    </div>
                    <div class="pacto-t-rep-field">
                        <label><?php esc_html_e( 'Cargo / Função / Empresa', 'pacto-25' ); ?></label>
                        <input type="text" class="pacto-t-input-role" name="pacto_testimonials[{{INDEX}}][role]" value="" placeholder="Ex: CEO / Diretor" />
                    </div>
                    <div class="pacto-t-rep-field pacto-t-rep-field-full">
                        <label><?php esc_html_e( 'Texto do Testemunho / Depoimento', 'pacto-25' ); ?></label>
                        <textarea class="pacto-t-input-quote" name="pacto_testimonials[{{INDEX}}][quote]" rows="3" placeholder="Insira o depoimento do cliente..."></textarea>
                    </div>
                </div>
            </div>
        </div>
    </script>

    <script>
    jQuery(document).ready(function($) {
        var $container = $('#pacto-testimonials-rep-container');

        function reindexTestimonials() {
            $container.children('.pacto-t-rep-row').each(function(idx) {
                var $row = $(this);
                $row.attr('data-index', idx);
                $row.find('.pacto-t-rep-badge').text('Testemunho #' + (idx + 1));
                $row.find('input, textarea, select').each(function() {
                    var name = $(this).attr('name');
                    if (name) {
                        $(this).attr('name', name.replace(/pacto_testimonials\[\d+\]/, 'pacto_testimonials[' + idx + ']'));
                    }
                });
            });
        }

        if ($.fn.sortable) {
            $container.sortable({
                handle: '.handle',
                axis: 'y',
                update: function() {
                    reindexTestimonials();
                }
            });
        }

        $('#pacto-t-rep-add').on('click', function(e) {
            e.preventDefault();
            var nextIdx = $container.children('.pacto-t-rep-row').length;
            var tpl = $('#pacto-testimonial-row-template').html()
                .replace(/\{\{INDEX\}\}/g, nextIdx)
                .replace(/\{\{NUM\}\}/g, nextIdx + 1);
            $container.append(tpl);
            reindexTestimonials();
        });

        $container.on('click', '.pacto-t-rep-remove', function(e) {
            e.preventDefault();
            if ($container.children('.pacto-t-rep-row').length <= 1) {
                alert('Deve manter pelo menos 1 testemunho.');
                return;
            }
            if (confirm('Tem a certeza que deseja remover este testemunho?')) {
                $(this).closest('.pacto-t-rep-row').remove();
                reindexTestimonials();
            }
        });

        $container.on('click', '.pacto-t-upload-btn', function(e) {
            e.preventDefault();
            var $row = $(this).closest('.pacto-t-rep-row');
            var frame = wp.media({
                title: 'Selecionar Foto / Avatar do Testemunho',
                button: { text: 'Usar esta foto' },
                multiple: false,
                library: { type: 'image' }
            });
            frame.on('select', function() {
                var attachment = frame.state().get('selection').first().toJSON();
                var imgUrl = (attachment.sizes && attachment.sizes.medium) ? attachment.sizes.medium.url : attachment.url;
                $row.find('.pacto-t-input-avatar').val(imgUrl);
                $row.find('.pacto-t-input-avatar-id').val(attachment.id);
                $row.find('.pacto-t-rep-avatar-preview img').attr('src', imgUrl);
            });
            frame.open();
        });
    });
    </script>
    <?php
}

function pacto_save_testimonials_repeater_metabox( $post_id ) {
    if ( ! isset( $_POST['pacto_testimonials_repeater_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['pacto_testimonials_repeater_nonce'] ) ), 'pacto_save_testimonials_repeater_data' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_page', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['pacto_testimonials'] ) && is_array( $_POST['pacto_testimonials'] ) ) {
        $clean_items = array();

        foreach ( $_POST['pacto_testimonials'] as $row ) {
            if ( ! is_array( $row ) ) {
                continue;
            }
            $name      = isset( $row['name'] ) ? sanitize_text_field( wp_unslash( $row['name'] ) ) : '';
            $role      = isset( $row['role'] ) ? sanitize_text_field( wp_unslash( $row['role'] ) ) : '';
            $quote     = isset( $row['quote'] ) ? sanitize_textarea_field( wp_unslash( $row['quote'] ) ) : '';
            $avatar    = isset( $row['avatar'] ) ? esc_url_raw( wp_unslash( $row['avatar'] ) ) : '';
            $avatar_id = isset( $row['avatar_id'] ) ? absint( $row['avatar_id'] ) : 0;

            if ( ! empty( $name ) || ! empty( $quote ) ) {
                $clean_items[] = array(
                    'name'      => $name,
                    'role'      => $role,
                    'quote'     => $quote,
                    'avatar'    => $avatar,
                    'avatar_id' => $avatar_id,
                );
            }
        }

        update_post_meta( $post_id, 'pacto_testimonials_items', $clean_items );
        delete_post_meta( $post_id, '_pacto_testimonials_items' );

        // Sync first 5 items back to legacy meta keys for full compatibility
        foreach ( $clean_items as $idx => $item ) {
            $slot = $idx + 1;
            if ( $slot <= 5 ) {
                update_post_meta( $post_id, "testimonial_{$slot}_name", $item['name'] );
                update_post_meta( $post_id, "testimonial_{$slot}_role", $item['role'] );
                update_post_meta( $post_id, "testimonial_{$slot}_quote", $item['quote'] );
                if ( ! empty( $item['avatar_id'] ) ) {
                    update_post_meta( $post_id, "testimonial_{$slot}_avatar", $item['avatar_id'] );
                }
            }
        }
    }
}
add_action( 'save_post', 'pacto_save_testimonials_repeater_metabox' );

/**
 * Ensure Homepage ACF testimonial avatar fields are pre-populated from CPT thumbnails if empty
 */
function pacto_sync_testimonials_avatars_on_admin() {
    if ( ! is_admin() ) {
        return;
    }

    $front_id = (int) get_option( 'page_on_front' );
    if ( ! $front_id ) {
        return;
    }

    $cpt_posts = get_posts( array(
        'post_type'      => 'testemunho',
        'post_status'    => 'publish',
        'posts_per_page' => 5,
        'orderby'        => array( 'menu_order' => 'ASC', 'ID' => 'ASC' ),
    ) );

    if ( empty( $cpt_posts ) ) {
        return;
    }

    foreach ( $cpt_posts as $index => $cpt_post ) {
        $slot     = $index + 1;
        $existing = get_post_meta( $front_id, "testimonial_{$slot}_avatar", true );
        if ( empty( $existing ) ) {
            $thumb_id = get_post_thumbnail_id( $cpt_post->ID );
            if ( $thumb_id ) {
                update_post_meta( $front_id, "testimonial_{$slot}_avatar", (int) $thumb_id );
                update_post_meta( $front_id, "_testimonial_{$slot}_avatar", "field_testimonial_{$slot}_avatar" );
            }
        }
    }
}
add_action( 'admin_init', 'pacto_sync_testimonials_avatars_on_admin' );

/**
 * Two-way sync: When Homepage ACF fields are saved, sync Testemunho 1..5 to CPT posts
 */
function pacto_sync_homepage_testimonials_to_cpt( $post_id ) {
    $front_id = (int) get_option( 'page_on_front' );
    if ( ! $front_id || (int) $post_id !== $front_id ) {
        return;
    }

    $cpt_posts = get_posts( array(
        'post_type'      => 'testemunho',
        'post_status'    => 'publish',
        'posts_per_page' => 5,
        'orderby'        => array( 'menu_order' => 'ASC', 'ID' => 'ASC' ),
    ) );

    if ( empty( $cpt_posts ) ) {
        return;
    }

    remove_action( 'save_post_testemunho', 'pacto_save_testimonial_meta' );

    foreach ( $cpt_posts as $index => $cpt_post ) {
        $slot   = $index + 1;
        $name   = get_post_meta( $front_id, "testimonial_{$slot}_name", true );
        $role   = get_post_meta( $front_id, "testimonial_{$slot}_role", true );
        $quote  = get_post_meta( $front_id, "testimonial_{$slot}_quote", true );
        $avatar = get_post_meta( $front_id, "testimonial_{$slot}_avatar", true );

        $update_args = array( 'ID' => $cpt_post->ID );
        $needs_post_update = false;

        if ( ! empty( $name ) && $name !== $cpt_post->post_title ) {
            $update_args['post_title'] = sanitize_text_field( $name );
            $needs_post_update = true;
        }
        if ( ! empty( $quote ) && $quote !== $cpt_post->post_content ) {
            $update_args['post_content'] = wp_kses_post( $quote );
            $needs_post_update = true;
        }
        if ( $needs_post_update ) {
            wp_update_post( $update_args );
        }

        if ( '' !== $role && false !== $role ) {
            update_post_meta( $cpt_post->ID, 'testimonial_role', sanitize_text_field( $role ) );
            update_post_meta( $cpt_post->ID, '_testimonial_role_plain', sanitize_text_field( $role ) );
        }
        if ( '' !== $quote && false !== $quote ) {
            update_post_meta( $cpt_post->ID, 'testimonial_quote', sanitize_textarea_field( $quote ) );
        }
        if ( is_numeric( $avatar ) && (int) $avatar > 0 ) {
            set_post_thumbnail( $cpt_post->ID, (int) $avatar );
        }
    }

    add_action( 'save_post_testemunho', 'pacto_save_testimonial_meta' );
}
add_action( 'acf/save_post', 'pacto_sync_homepage_testimonials_to_cpt', 20 );
