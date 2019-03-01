<?php

if ( ! function_exists( 'largo_enqueue_js' ) ) {
	/**
	 * Enqueue our core javascript and css files
	 *
	 * @since 1.0
	 * @global LARGO_DEBUG
	 */
	function largo_enqueue_js() {
		/*
		 * Use minified assets if LARGO_DEBUG is false.
		 */
		$suffix = ( LARGO_DEBUG ) ? '' : '.min';
		$version = largo_version();


		// Our primary stylesheet. Often overridden by custom-less-variables version.
		wp_enqueue_style(
			'largo-stylesheet',
			get_template_directory_uri() . '/css/style' . $suffix . '.css',
			null,
			$version
		);

		// Core JS includes some utilities, initializes carousels, search form behavior,
		// popovers, responsive header image, etc.
		wp_enqueue_script(
			'largoCore',
			get_template_directory_uri() . '/js/largoCore' . $suffix . '.js',
			array( 'jquery' ),
			$version,
			true
		);

		// Navigation-related JS
		wp_enqueue_script(
			'largo-navigation',
			get_template_directory_uri() . '/js/navigation' . $suffix . '.js',
			array( 'largoCore' ),
			$version,
			true
		);

		// Largo configuration object for use in frontend JS
		wp_localize_script(
			'largoCore', 'Largo', array(
			'is_home' => is_front_page(),
			'is_single' => is_single() || is_singular(),
			'sticky_nav_options' => array(
				//replace with copy that sets both sticky_nav and main_nav to true
				'sticky_nav_display' => (bool) of_get_option( 'sticky_nav_display', true ),
				'main_nav_hide_article' => (bool) of_get_option( 'main_nav_hide_article', true ),
				'nav_overflow_label' => of_get_option( 'nav_overflow_label', 'More' )
			)
		));

		/*
		 * The following files are already minified:
		 *
		 * - modernizr.custom.js
		 * - largoPlugins.js
		 * - jquery.idTabs.js
		 */
		wp_enqueue_script(
			'largo-modernizr',
			get_template_directory_uri() . '/js/modernizr.custom.js',
			null,
			$version
		);
		wp_enqueue_script(
			'largoPlugins',
			get_template_directory_uri() . '/js/largoPlugins.js',
			array( 'jquery' ),
			$version,
			true
		);

	}
}
add_action( 'wp_enqueue_scripts', 'largo_enqueue_js' );

if ( ! function_exists( 'largo_gallery_enqueue' ) ) {
	/**
	 * Enqueue Largo gallery CSS & JS
	 *
	 * @since 0.5.5.3
	 */
	function largo_gallery_enqueue() {
		$slick_css = get_template_directory_uri() . '/lib/navis-slideshows/vendor/slick/slick.css';
		wp_enqueue_style( 'navis-slick', $slick_css, array(), '1.0' );

		$slides_src = get_template_directory_uri() . '/lib/navis-slideshows/vendor/slick/slick.min.js';
		wp_enqueue_script( 'jquery-slick', $slides_src, array( 'jquery' ), '3.0', true );

		$slides_css = get_template_directory_uri() . '/lib/navis-slideshows/css/slides.css';
		wp_enqueue_style( 'navis-slides', $slides_css, array(), '1.0' );

		$show_src = get_template_directory_uri() . '/lib/navis-slideshows/js/navis-slideshows.js';
		wp_enqueue_script( 'navis-slideshows', $show_src, array( 'jquery-slick' ), '0.11', true );
	}
	add_action( 'wp_enqueue_scripts', 'largo_gallery_enqueue' );
}

if ( ! function_exists( 'largo_enqueue_child_theme_css' ) ) {
	/**
	 * Enqueue Largo child theme CSS
	 *
	 * @since 0.5.4
	 */
	function largo_enqueue_child_theme_css() {
		//Load the child theme's style.css if we're actually running a child theme of Largo
		$theme = wp_get_theme();

		if (is_object($theme->parent())) {
			wp_enqueue_style(
				'largo-child-styles',
				get_stylesheet_directory_uri() . '/style.css',
				array(),
				filemtime( get_stylesheet_directory() . '/style.css' )
			);
		}
	}
	add_action( 'wp_enqueue_scripts', 'largo_enqueue_child_theme_css' );
}

/**
 * Enqueue our admin javascript and css files
 *
 * @global LARGO_DEBUG
 */
function largo_enqueue_admin_scripts() {

	// Use minified assets if LARGO_DEBUG isn't true.
	$suffix = (LARGO_DEBUG)? '' : '.min';
	wp_enqueue_style(
		'largo-admin-widgets',
		get_template_directory_uri() . '/css/widgets-php' . $suffix . '.css',
		array(),
		largo_version()
	);
	wp_enqueue_script(
		'largo-admin-widgets',
		get_template_directory_uri() . '/js/widgets-php' . $suffix . '.js',
		array( 'jquery' ),
		largo_version(),
		true
	);
}
add_action( 'admin_enqueue_scripts', 'largo_enqueue_admin_scripts' );

if ( ! function_exists( 'largo_header_js' ) ) {
	/**
	 * Determine which size of the banner image to load based on the window width
	 *
	 * @since 1.0
	 */
	function largo_header_js() { ?>
		<script>
			function whichHeader() {
				var screenWidth = document.documentElement.clientWidth,
				header_img;
				if (screenWidth <= 767) {
					header_img = '<?php echo of_get_option( 'banner_image_sm' ); ?>';
				} else if (screenWidth > 767 && screenWidth <= 979) {
					header_img = '<?php echo of_get_option( 'banner_image_med' ); ?>';
				} else {
					header_img = '<?php echo of_get_option( 'banner_image_lg' ); ?>';
				}
				return header_img;
			}
			var banner_img_src = whichHeader();
		</script>
	<?php
	}
}
add_action( 'wp_enqueue_scripts', 'largo_header_js' );

if ( ! function_exists( 'largo_footer_js' ) ) {
	/**
	 * Additional scripts to load in the footer (mostly for various social widgets)
	 *
	 * @since 1.0
	 */
	function largo_footer_js() {

		if ( largo_facebook_widget::is_rendered() ) { ?>
			<!--Facebook-->
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/<?php echo get_locale() ?>/all.js#xfbml=1";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
		<?php }

		/*
		 * Load Facebook Tracking Pixel if defined in Theme Options
		 *
		 * Function loads Facebook's JavaScript (circa September 2015) for
		 * conversion tracking and send the default event.
		 *
		 * @link https://developers.facebook.com/docs/ads-for-websites/drive-conversions
		 * @since 0.5.4
		 */
		$fb_pixel_id = of_get_option( 'fb_tracking_pixel' );
		if( !empty($fb_pixel_id) ) { ?>
			<script>
				(function() {
					var _fbq = window._fbq || (window._fbq = []);
					if (!_fbq.loaded) {
						var fbds = document.createElement('script');
						fbds.async = true;
						fbds.src = '//connect.facebook.net/<?php echo get_locale() ?>/fbds.js';
						var s = document.getElementsByTagName('script')[0];
						s.parentNode.insertBefore(fbds, s);
						_fbq.loaded = true;
					}
					_fbq.push(['addPixelId', '<?php echo $fb_pixel_id; ?>']);
				})();
				window._fbq = window._fbq || [];
				window._fbq.push(['track', 'PixelInitialized', {}]);
			</script>
			<!-- Fallback for environments not friendly to script -->
			<noscript>
				<img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?id=<?php echo $fb_pixel_id; ?>&amp;ev=PixelInitialized" />
			</noscript>
		<?php /* END tracking pixel code */ }
	}
}
add_action( 'wp_footer', 'largo_footer_js' );

if ( ! function_exists( 'largo_google_analytics' ) ) {
	/**
	 * Add Google Analytics code to the footer
	 *
	 * You need to add your GA ID to the theme settings for this to work.
	 *
	 * Through version 0.5.5.4, this function output a Google Analytics
	 * tag even if the site didn't have GA configured in the theme. This
	 * tag was used to send GA tracking events to properties for INN and
	 * for the Largo Project.
	 *
	 * In this current version of the plugin, it only outputs a GA tag
	 * if you've added a GA ID to the theme settings. If you're using a different
	 * GA script, leave that setting blank.
	 *
	 * If you're using Largo, please send us an email to say hi!
	 * https://labs.inn.org/contact/
	 *
	 * @since 0.3
	 */
	function largo_google_analytics() {
		if ( ! current_user_can( 'edit_posts' ) ) { // don't track editors or authors or admins.
			if ( of_get_option( 'ga_id', true ) ) { // make sure the ga_id setting is defined.
				?>
				<script>
					var _gaq = _gaq || [];
					_gaq.push(['_setAccount', '<?php echo of_get_option( 'ga_id' ); ?>']);
					_gaq.push(['_trackPageview']);
					(function() {
						var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
						ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
						var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
					})();
				</script>
				<?php
			}
		}
	}
}
add_action( 'wp_head', 'largo_google_analytics' );


/**
 * Enqueue Largo's Gutenberg-supporting stylesheets and scripts, for the frontend
 *
 * @since 0.6
 */
function largo_gutenberg_frontend_css_js() {
	$suffix = ( LARGO_DEBUG ) ? '' : '.min';
	$version = largo_version();

	if (
		function_exists( 'register_block_type' )
		// @todo add a conditional that checks that we're on a Gutenberg post
	) {
		// Gutenberg support stylesheet
		wp_enqueue_style(
			'largo-stylesheet-gutenberg',
			get_template_directory_uri() . '/css/gutenberg' . $suffix . '.css',
			array(),
			$version
		);
	}
}
add_action( 'wp_enqueue_scripts', 'largo_gutenberg_frontend_css_js' );

/**
 * Enqueue Largo's Gutenberg-supporting stylesheets and scripts, for the admin editor
 *
 * @since 0.6
 * @see https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type/#enqueuing-block-scripts
 */
function largo_gutenberg_editor_css_js() {
	$suffix = ( LARGO_DEBUG ) ? '' : '.min';
	$version = largo_version();
	if (
		function_exists( 'register_block_type' )
		// @todo add a conditional that checks that we're on a Gutenberg post
	) {
		// Gutenberg support stylesheet
		wp_enqueue_style(
			'largo-stylesheet-gutenberg',
			get_template_directory_uri() . '/css/gutenberg' . $suffix . '.css',
			array(),
			$version
		);
	}
	// wp_register_script()
	// see what we do in pym shortcode
}
add_action( 'enqueue_block_editor_assets', 'largo_gutenberg_editor_css_js' );
