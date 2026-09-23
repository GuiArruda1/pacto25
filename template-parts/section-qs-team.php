<?php
/**
 * Template Part: Quem Somos - A Nossa Equipa Section
 * Theme: Pacto 25
 * Strict Agency SOP: Staggered team constellation, ACF support, clean responsive layout.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$eyebrow = pacto_get_field( 'qs_team_eyebrow', false, 'A NOSSA EQUIPA' );
$title   = pacto_get_field( 'qs_team_title', false, 'Profissionais dedicados ao seu lado' );

$default_members = array(
    array(
        'name'  => 'Teresinha Pereira',
        'role'  => 'DIREÇÃO GERAL & MARKETING',
        'image' => get_template_directory_uri() . '/assets/images/quem-somos/qs-team-1.png',
    ),
    array(
        'name'  => 'Nome Apelido',
        'role'  => 'FUNÇÃO & ÁREA',
        'image' => get_template_directory_uri() . '/assets/images/quem-somos/qs-team-2.png',
    ),
    array(
        'name'  => 'Nome Apelido',
        'role'  => 'FUNÇÃO & ÁREA',
        'image' => get_template_directory_uri() . '/assets/images/quem-somos/qs-team-3.png',
    ),
    array(
        'name'  => 'Nome Apelido',
        'role'  => 'FUNÇÃO & ÁREA',
        'image' => get_template_directory_uri() . '/assets/images/quem-somos/qs-team-4.png',
    ),
);

$members = pacto_get_field( 'qs_team_members', false, $default_members );
if ( ! is_array( $members ) || empty( $members ) ) {
    $members = $default_members;
}
?>

<section class="section section-qs-team" aria-label="<?php esc_attr_e( 'A Nossa Equipa', 'pacto-25' ); ?>">
    <!-- Ambient Floating Dots & Decorative Rings (Exact Figma Constellation) -->
    <div class="qs-team-dot qs-team-dot--1" aria-hidden="true"></div>
    <div class="qs-team-dot qs-team-dot--2" aria-hidden="true"></div>
    <div class="qs-team-dot qs-team-dot--3" aria-hidden="true"></div>
    <div class="qs-team-ring qs-team-ring--1" aria-hidden="true"></div>
    <div class="qs-team-ring qs-team-ring--2" aria-hidden="true"></div>

    <div class="site-container">
        <!-- Staggered Team Constellation Grid -->
        <div class="section-qs-team__constellation">
            <?php foreach ( $members as $idx => $member ) : 
                $num        = $idx + 1;
                $name       = ! empty( $member['name'] ) ? $member['name'] : 'Nome Apelido';
                $role       = ! empty( $member['role'] ) ? ltrim( $member['role'], "•· \t\n\r\0\x0B" ) : 'Cargo / Função';
                $photo_val  = ! empty( $member['image'] ) ? $member['image'] : ( isset( $default_members[ $idx ]['image'] ) ? $default_members[ $idx ]['image'] : '' );
            ?>
                <div class="qs-member qs-member--<?php echo esc_attr( $num ); ?>">
                    <div class="qs-member__circle-wrap">
                        <div class="qs-member__backdrop-dot" aria-hidden="true"></div>
                        <div class="qs-member__photo-circle">
                            <?php pacto_render_image( $photo_val, 'medium', 'qs-member-photo', $default_members[ $idx ]['image'] ?? '', false ); ?>
                        </div>
                    </div>
                    <div class="qs-member__info">
                        <h4 class="qs-member__name"><?php echo esc_html( $name ); ?></h4>
                        <span class="qs-member__role"><?php echo esc_html( $role ); ?></span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
