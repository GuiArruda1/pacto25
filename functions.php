<?php
/**
 * Theme Functions & Bootstrap
 * Theme: Pacto 25
 * 
 * Strict Agency SOP:
 * - Decoupled content via ACF
 * - Modern Vanilla CSS / JS (Zero jQuery / Tailwind)
 * - Strict escaping and security
 * - Privacy-first (no embedded tracking cookies)
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Define Theme Constants
define( 'PACTO_THEME_VERSION', '1.0.0' );
define( 'PACTO_THEME_DIR', get_template_directory() );
define( 'PACTO_THEME_URI', get_template_directory_uri() );

// Include Modular Architecture
require_once PACTO_THEME_DIR . '/inc/helpers.php';
require_once PACTO_THEME_DIR . '/inc/setup.php';
require_once PACTO_THEME_DIR . '/inc/acf-fields.php';
require_once PACTO_THEME_DIR . '/inc/svg-support.php';
require_once PACTO_THEME_DIR . '/inc/hero-slider-meta.php';
require_once PACTO_THEME_DIR . '/inc/cpt-testimonials.php';
require_once PACTO_THEME_DIR . '/inc/cpt-seguros-particulares.php';
require_once PACTO_THEME_DIR . '/inc/quem-somos-meta.php';
require_once PACTO_THEME_DIR . '/inc/sample-posts-seeder.php';

