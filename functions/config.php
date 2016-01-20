<?php
/**
 * This file is responsible for setting up the basic configuration items for the theme. 
 * Theme configurations (those that can be set by the user) - should be defined here.
 */
 
function __init__() {
    register_nav_menu( 'header-menu', __( 'Header Menu' ) );
    register_nav_menu( 'footer-menu', __( 'Footer Menu' ) );
    register_nav_menu( 'social-menu', __( 'Social Icons Menu' ) );

    register_sidebar(
        array(
            'name'          => __( 'Primary Sidebar' ),
            'id'            => 'primary-sidebar',
            'description'   => 'This is the primary sidebar.',
            'before_widget' => '<aside class="primary-sidebar">',
            'after_widget'  => '</aside>'
        )
    );

    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'html5' );
}
 
add_action( 'init', '__init__' );

define( 'THEME_URL', get_bloginfo( 'stylesheet_directory' ) );
define( 'THEME_ADMIN_URL', get_admin_url() );
define( 'THEME_DIR', get_stylesheet_directory() );
define( 'THEME_RES_URL', THEME_URL . '/res' );
define( 'THEME_CSS_URL', THEME_RES_URL . '/css' );
define( 'THEME_JS_URL', THEME_RES_URL . '/js' );
define( 'THEME_CUSTOMIZER_PREFIX', 'tlc_' );

function enqueue_frontend_theme_assets() {
    wp_enqueue_style('frontend-style', THEME_CSS_URL . '/style.min.css');
    
    wp_deregister_script( 'jquery' );
    wp_enqueue_script( 'jquery', '//code.jquery.com/jquery-1.11.0.min.js', null, null, True );
    wp_enqueue_script( 'script', THEME_JS_URL . '/script.min.js', ['jquery'], null, True );
}

add_action( 'wp_enqueue_scripts', 'enqueue_frontend_theme_assets' );

function enqueue_backend_theme_assets() {
    wp_register_script( 'admin-custom', THEME_JS_URL . '/admin.min.js', ['jquery', 'mce-view'], null, True );
    wp_enqueue_script( 'admin-custom' );

    wp_enqueue_style('backend-style', THEME_CSS_URL . '/admin.min.css');
}

add_action( 'admin_enqueue_scripts', 'enqueue_backend_theme_assets' );

function define_customizer_panels( $wp_customize ) {
    $wp_customize->add_panel(
        THEME_CUSTOMIZER_PREFIX . 'home',
        array(
            'title'           => __( 'Home Page' ),
            'active_callback' => function() { return is_home() || is_front_page(); }
        )
    );
}

add_action( 'customizer_register', 'define_customizer_panels' );

function define_customizer_sections( $wp_customize ) {
    // Home Page section
    $wp_customize->add_section(
        THEME_CUSTOMIZER_PREFIX . 'homepage',
        array(
            'title' => __( 'Home Page' ),
            'panel' => THEME_CUSTOMIZER_PREFIX / 'home'
        )
    );

    // Header section
    $wp_customize->add_section(
        THEME_CUSTOMIZER_PREFIX . 'header',
        array(
            'title' => __( 'Header' )
        )
    );

    // Footer section
    $wp_customize->add_section(
        THEME_CUSTOMIZER_PREFIX . 'footer',
        array(
            'title' => __( 'Footer' )
        )
    );

    // Social Section
    $wp_customize->add_section(
        THEME_CUSTOMIZER_PREFIX . 'social',
        array(
            'title' => __( 'Social' )
        )
    );
}

add_action( 'customize_register', 'define_customizer_sections' );

Config::$setting_defaults = array(
    'footer_address'      => '1525 South State Road 15-A<br>DeLand, FL 32720',
    'footer_phone'        => '386-734-5380'
);

function get_setting_default( $setting, $fallback=null ) {
    return isset( Config::$setting_defaults[$setting] ) ? Config::$setting_defaults[$setting] : $fallback;
}

function define_customizer_fields( $wp_customize ) {
    // Home Page Features
    $wp_customize->add_setting(
        'homepage_title'
    );

    $wp_customize->add_control(
        'homepage_title',
        array(
            'type'        => 'text',
            'label'       => 'Home Page Title',
            'description' => 'The title that will appear above the text on the home page.',
            'section'     => THEME_CUSTOMIZER_PREFIX . 'homepage'
        )
    );

    $wp_customize->add_setting(
        'homepage_content'
    );

    $wp_customize->add_control(
        'homepage_content',
        array(
            'type'        => 'textarea',
            'label'       => 'Home Page Content',
            'description' => 'The text that will appear on the home page.',
            'section'     => THEME_CUSTOMIZER_PREFIX . 'homepage'
        )
    );

    // Header
    $wp_customize->add_setting(
        'header_image'
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'header_image',
            array(
                'label'       => __( 'Header Image' ),
                'description' => __( 'The image that will appear in the header on every page' ),
                'section'     => THEME_CUSTOMIZER_PREFIX . 'header',
                'settings'    => 'header_image'
            )
        )
    );

    // Footer
    $wp_customize->add_setting(
        'footer_address',
        array(
            'default' => get_setting_default( 'footer_address' )
        )
    );

    $wp_customize->add_control(
        'footer_address',
        array(
            'type'        => 'textarea',
            'label'       => 'Footer Address',
            'description' => 'Defines the address in the footer',
            'section'     => THEME_CUSTOMIZER_PREFIX . 'footer'
        )
    );

    $wp_customize->add_setting(
        'footer_phone',
        array(
            'default' => get_setting_default( 'footer_phone' )
        )
    );

    $wp_customize->add_control(
        'footer_phone',
        array(
            'type'        => 'text',
            'label'       => 'Footer Phone',
            'description' => 'Defines the phone in the footer',
            'section'     => THEME_CUSTOMIZER_PREFIX . 'footer'
        )
    );

    $wp_customize->add_setting(
        'footer_contact_page'
    );

    $wp_customize->add_control(
        'footer_contact_page',
        array(
            'type'        => 'dropdown-pages',
            'label'       => 'Footer Contact Page',
            'description' => 'Defines the contact page link in the footer',
            'section'     => THEME_CUSTOMIZER_PREFIX . 'footer'
        )
    );

    $wp_customize->add_setting(
        'footer_menu',
        array(
            'default' => 'social-menu'
        )
    );

    $wp_customize->add_control(
        'footer_menu',
        array(
            'type'        => 'select',
            'label'       => __( 'Footer Menu' ),
            'description' => __( 'Defines the menu to use in the footer.' ),
            'section'     => THEME_CUSTOMIZER_PREFIX . 'footer',
            'choices'     => array(
                'header-menu' => __( 'Header Menu' ),
                'footer-menu' => __( 'Footer Menu' ),
                'social-menu' => __( 'Social Menu' )
            )
        )
    );

    // Social
    $wp_customize->add_setting(
        'googleplus_url'
    );

    $wp_customize->add_control(
        'googleplus_url',
        array(
            'type'        => 'url',
            'label'       => __( 'Google+ Url' ),
            'section'     => THEME_CUSTOMIZER_PREFIX . 'social'
        )
    );

    $wp_customize->add_setting(
        'twitter_url'
    );

    $wp_customize->add_control(
        'twitter_url',
        array(
            'type'        => 'url',
            'label'       => __( 'Twitter Url' ),
            'section'     => THEME_CUSTOMIZER_PREFIX . 'social'
        )
    );

    $wp_customize->add_setting(
        'facebook_url'
    );

    $wp_customize->add_control(
        'facebook_url',
        array(
            'type'        => 'url',
            'label'       => __( 'Facebook Url' ),
            'section'     => THEME_CUSTOMIZER_PREFIX . 'social'
        )
    );

    $wp_customize->add_setting(
        'instagram_url'
    );

    $wp_customize->add_control(
        'instagram_url',
        array(
            'type'        => 'url',
            'label'       => __( 'Instagram Url' ),
            'section'     => THEME_CUSTOMIZER_PREFIX . 'social'
        )
    );

    $wp_customize->add_setting(
        'youtube_url'
    );

    $wp_customize->add_control(
        'youtube_url',
        array(
            'type'        => 'url',
            'label'       => __( 'YouTube Url' ),
            'section'     => THEME_CUSTOMIZER_PREFIX . 'social'
        )
    );
}

add_action( 'customize_register', 'define_customizer_fields' );

Config::$custom_post_types = array(
    'Event'
);

Config::$shortcodes = array(
    'IconButton'
);

?>