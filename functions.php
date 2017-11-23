<?php

/**
 * Register our sidebars and widgetized areas.
 *
 */
function arphabet_widgets_init() {

    register_sidebar( array(
        'name'          => 'Home right sidebar',
        'id'            => 'home_right_1',
        'before_widget' => '<div>',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="rounded">',
        'after_title'   => '</h2>',
    ) );

}
add_action( 'widgets_init', 'arphabet_widgets_init' );

function register_my_menu()
{
    register_nav_menu('header-menu', __('Header Menu'));
}

add_action('init', 'register_my_menu');

function mytheme_customize_register($wp_customize)
{
    /**************************************
     * Section:  Color Scheme
     ***************************************/
    $wp_customize->add_section('textcolors', array(
        'title' => 'Color Scheme',
    ));

    // main color ( site title, h1, h2, h4. h6, widget headings, nav links, footer headings )
    $txtcolors[] = array(
        'slug' => 'color_scheme_1',
        'default' => '#000',
        'label' => 'Main Color'
    );

    // secondary color ( site description, sidebar headings, h3, h5, nav links on hover )
    $txtcolors[] = array(
        'slug' => 'color_scheme_2',
        'default' => '#666',
        'label' => 'Secondary Color'
    );

    // link color
    $txtcolors[] = array(
        'slug' => 'link_color',
        'default' => '#008AB7',
        'label' => 'Link Color'
    );

    // link color ( hover, active )
    $txtcolors[] = array(
        'slug' => 'hover_link_color',
        'default' => '#9e4059',
        'label' => 'Link Color (on hover)'
    );

    // add the settings and controls for each color
    foreach( $txtcolors as $txtcolor ) {
        $wp_customize->add_setting(
            $txtcolor['slug'], array(
                'default' => $txtcolor['default'],
                'type' => 'option',
                'capability' =>  'edit_theme_options'
            )
        );

        $wp_customize->add_control(
            new WP_Customize_Color_Control(
                $wp_customize,
                $txtcolor['slug'],
                array('label' => $txtcolor['label'],
                    'section' => 'textcolors',
                    'settings' => $txtcolor['slug'])
            )
        );
    }

    /**************************************
     * Section:  Solid background colors
     ***************************************/
    // add the section to contain the settings
    $wp_customize->add_section( 'background' , array(
        'title' =>  'Solid Backgrounds',
    ) );

    // add the setting for the header background
    $wp_customize->add_setting( 'header-background' );

    // add the control for the header background
    $wp_customize->add_control( 'header-background', array(
        'label'      => 'Add a solid background to the header?',
        'section'    => 'background',
        'settings'   => 'header-background',
        'type'       => 'radio',
        'choices'    => array(
            'header-background-off'   => 'no',
            'header-background-on'  => 'yes',
        ) ) );


    // add the setting for the footer background
    $wp_customize->add_setting( 'footer-background' );

    // add the control for the footer background
    $wp_customize->add_control( 'footer-background', array(
            'label'      => 'Add a solid background to the footer?',
            'section'    => 'background',
            'settings'   => 'footer-background',
            'type'       => 'radio',
            'choices'    => array(
                'footer-background-off'   => 'no',
                'footer-background-on'  => 'yes',
            )
        )
    );
}

add_action('customize_register', 'mytheme_customize_register');


function wptutsplus_customize_colors() {
    // main color
    $color_scheme_1 = get_option( 'color_scheme_1' );

    // secondary color
    $color_scheme_2 = get_option( 'color_scheme_2' );

    // link color
    $link_color = get_option( 'link_color' );

    // hover or active link color
    $hover_link_color = get_option( 'hover_link_color' );
    ?>

<style>
    /* color scheme */

    /* main color */
    #site-title a, h1, h2, h2.page-title, h2.post-title, h2 a:link, h2 a:visited, .menu.main a:link, .menu.main a:visited, footer h3 {
        color:  <?php echo $color_scheme_1; ?>;
    }

    /* secondary color */
    #site-description, .sidebar h3, h3, h5, .menu.main a:active, .menu.main a:hover {
        color:  <?php echo $color_scheme_2; ?>;
    }

    /* links color */
    a:link, a:visited {
        color:  <?php echo $link_color; ?>;
    }

    /* hover links color */
    a:hover, a:active {
        color:  <?php echo $hover_link_color; ?>;
    }

    /* header */
    .header-background-on .header-wrapper {
        background-color: <?php echo $color_scheme_1; ?>;
    }
    .header-background-on #site-title a, .header-background-on h1, .header-background-on #site-description, .header-background-on address, .header-background-on header a:link, .header-background-on header a:visited, .header-background-on header a:active, .header-background-on header a:hover {
        color: #fff;
    }
    .header-background-on header a:link, .header-background-on header a:visited {
        text-decoration: underline;
    }
    .header-background-on header a:active, .header-background-on header a:hover {
        text-decoration: none;
    }

    /* footer */
    .footer-background-on footer {
        background-color: <?php echo $color_scheme_1; ?>;
    }
    .footer-background-on footer, .footer-background-on footer h3, .footer-background-on footer a:link, .footer-background-on footer a:visited, .footer-background-on footer a:active, .footer-background-on footer a:hover {
        color: #fff;
    }
    .footer-background-on footer a:link, .footer-background-on footer a:visited {
        text-decoration: underline;
    }
    .footer-background-on footer a:active, .footer-background-on footer a:hover {
        text-decoration: none;
    }
    .footer-background-on .fatfooter {
        border: none;
    }

</style>
    <?php
}

add_action( 'wp_head', 'wptutsplus_customize_colors' );


/*******************************************************************************
 * Add class to body if backgrounds turned on using the body_class filter
 ********************************************************************************/
function wptutsplus_add_background_color_style( $classes ) {

    // set the header background
    $header_background = get_theme_mod( 'header-background' );
    $classes[] = $header_background;

    // set the footer background
    $footer_background = get_theme_mod( 'footer-background' );
    $classes[] = $footer_background;

    return $classes;
}

add_filter('body_class', 'wptutsplus_add_background_color_style');
?>