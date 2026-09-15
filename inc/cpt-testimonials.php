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
 * Helper: Fetch Testimonials from CPT with Fallback to Figma defaults
 *
 * @return array
 */
function pacto_get_testimonials_list() {
    $args = array(
        'post_type'      => 'testemunho',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
    );

    $query = new WP_Query( $args );
    $items = array();

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $post_id = get_the_ID();

            // Avatar photo: Featured Image, ACF field, or fallback
            $avatar_url = '';
            if ( has_post_thumbnail( $post_id ) ) {
                $avatar_url = get_the_post_thumbnail_url( $post_id, 'medium' );
            } elseif ( function_exists( 'get_field' ) ) {
                $acf_img = get_field( 'testimonial_avatar', $post_id );
                if ( is_array( $acf_img ) && ! empty( $acf_img['url'] ) ) {
                    $avatar_url = $acf_img['url'];
                }
            }

            // Role / Cargo
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

            // Quote / Depoimento
            $quote = get_the_content();
            if ( empty( $quote ) && function_exists( 'get_field' ) ) {
                $quote = get_field( 'testimonial_quote', $post_id );
            }
            $quote = wp_strip_all_tags( $quote );

            $items[] = array(
                'id'     => $post_id,
                'name'   => get_the_title(),
                'role'   => $role ? $role : '',
                'quote'  => $quote,
                'avatar' => $avatar_url,
            );
        }
        wp_reset_postdata();
    }

    // Fallback to 5 authentic Figma testimonials if no posts are published yet
    if ( empty( $items ) ) {
        $default_avatars = array(
            1 => get_template_directory_uri() . '/assets/images/testimonials/avatar-1.png',
            2 => get_template_directory_uri() . '/assets/images/testimonials/avatar-2.png',
            3 => get_template_directory_uri() . '/assets/images/testimonials/avatar-3.png',
            4 => get_template_directory_uri() . '/assets/images/testimonials/avatar-4.png',
            5 => get_template_directory_uri() . '/assets/images/testimonials/avatar-5.png',
        );

        $items = array(
            array(
                'id'     => 1,
                'name'   => 'Helena Sequeira',
                'role'   => 'Consultora e Formadora',
                'quote'  => '“A Pacto Seguro tem sido uma ótima parceira em todas as vertentes da minha vida. A confiança é um ponto fulcral e nesta equipa confio ao ponto de pedir conselhos, pois, confesso, não tenho muito tempo para resolver problemas ou pesquisar. Estou grata por me ajudarem no meu Caminho.”',
                'avatar' => $default_avatars[1],
            ),
            array(
                'id'     => 2,
                'name'   => 'Sérgio Simões',
                'role'   => 'Chief Operations',
                'quote'  => '“A Pacto Seguro construiu uma relação de confiança com a nossa empresa, dando uma resposta séria a todas as nossas solicitações e necessidades, mas também oferecendo melhores soluções para a nossa actividade. A verdadeira parceria!”',
                'avatar' => $default_avatars[2],
            ),
            array(
                'id'     => 3,
                'name'   => 'Maria do Carmo',
                'role'   => 'CEO',
                'quote'  => '“Para além da diversidade dos produtos disponíveis, a deferência que têm para connosco é para nós crucial nesta relação.”',
                'avatar' => $default_avatars[3],
            ),
            array(
                'id'     => 4,
                'name'   => 'Ricardo Flaminio',
                'role'   => 'Diretor',
                'quote'  => 'A Pacto Seguro sempre respondeu com prontidão a todos os pedidos realizados e alterações necessárias. Destaco a rapidez e prontidão como as principais características de trabalho desta empresa.',
                'avatar' => $default_avatars[4],
            ),
            array(
                'id'     => 5,
                'name'   => 'Anabela Ferreira',
                'role'   => 'General Manager',
                'quote'  => 'Temos na Pacto Seguro todos os nossos seguros há vários anos, é um parceiro transparente e honesto com quem nos identificamos. Sentimos sempre um tratamento personalizado e não somente mais um cliente! Obrigado por toda a vossa ajuda e amizade ao longo dos anos.',
                'avatar' => $default_avatars[5],
            ),
        );
    }

    return $items;
}
