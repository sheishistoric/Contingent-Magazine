<?php
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );

function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

add_action( 'wp_enqueue_scripts', 'wpshout_dequeue_and_then_enqueue', 100 );

function wpshout_dequeue_and_then_enqueue() {
    wp_dequeue_script( 'largo-navigation' );
    wp_deregister_script( 'largo-navigation' );
    // Enqueue replacement child theme script
    wp_register_script('');
    wp_enqueue_script('largo-navigation-2', get_stylesheet_directory_uri() . '/js/navigation.js',
        array( 'jquery' )
    );
}
remove_filter('pre_user_description', 'wp_filter_kses');remove_filter('pre_user_description', 'wp_filter_kses');

?>
