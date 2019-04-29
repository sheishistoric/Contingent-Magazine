<?php
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );

function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

add_action( 'wp_enqueue_scripts', 'wpshout_dequeue_and_then_enqueue', 100 );

function wpshout_dequeue_and_then_enqueue() {
    wp_dequeue_script( 'navigation' );
    // Enqueue replacement child theme script
    wp_enqueue_script(
        'navigation',
        get_stylesheet_directory_uri() . '/js/navigation.js',
        array( 'jquery' )
    );
}
remove_filter('pre_user_description', 'wp_filter_kses');remove_filter('pre_user_description', 'wp_filter_kses');

?>
