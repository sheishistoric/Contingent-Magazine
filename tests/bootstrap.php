<?php

$wp_tests_dir = getenv('WP_TESTS_DIR');
require_once $wp_tests_dir . '/includes/functions.php';

$basename = basename(dirname(__DIR__));

$GLOBALS['wp_tests_options'] = array(
	'stylesheet' => $basename,
	'template' => $basename
);

tests_add_filter('set_current_user', function($arg) {
	$user = wp_get_current_user();
	$user->set_role('administrator');
	return $arg;
}, 1, 10);

tests_add_filter('filesystem_method', function($arg) {
	return 'direct';
}, 1, 10);

// require and activate gutenberg
tests_add_filter( 'muplugins_loaded', function($arg) {
	if ( getenv( 'GUTENBERG' ) == 1 ) {
		require ABSPATH . 'wp-content/plugins/gutenberg/gutenberg.php';
		$plugins = get_option( 'active_plugins' );
		$plugins[] = 'gutenberg/gutenberg.php';
		$ret = update_option( 'active_plugins', $plugins );
	}
	return $arg;
});

require dirname(__FILE__) . '/mock/mock-options-framework.php';
require dirname(__FILE__) . '/mock/mock-admin-functions.php';
require $wp_tests_dir . '/includes/bootstrap.php';
