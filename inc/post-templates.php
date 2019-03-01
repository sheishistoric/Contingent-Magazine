<?php
/**
 * Adds ability to select a custom post template for single posts
 * Derived from Single Post Template 1.3 plugin by Nathan Rice (http://www.nathanrice.net/plugins)
 *
 * @since 0.3
 */

//	This function scans the template files of the active theme,
//	and returns an array of [Template Name => {file}.php]
if ( ! function_exists( 'get_post_templates' ) ) {
	function get_post_templates() {
		$theme = wp_get_theme();
		$templates = $theme->get_files( 'php', 1, true );
		$post_templates = array();

		$base = array( trailingslashit( get_template_directory() ), trailingslashit( get_stylesheet_directory() ) );

		foreach ( (array) $templates as $template ) {
			$template = WP_CONTENT_DIR . str_replace( WP_CONTENT_DIR, '', $template );
			$basename = str_replace( $base, '', $template );

			// don't allow template files in subdirectories
			// if (false !== strpos($basename, '/'))
			//	continue;

			$template_data = implode( '', file( $template ) );

			$name = '';
			if ( preg_match( '|Single Post Template:(.*)$|mi', $template_data, $name ) ) {
				$name = _cleanup_header_comment( $name[1] );
			}

			if ( ! empty( $name ) ) {
				if( basename( $template ) != basename(__FILE__) ) {
					$post_templates[trim($name)] = $basename;
				}
			}
		}

		return $post_templates;

	}
}

//	build the dropdown items
if( ! function_exists( 'post_templates_dropdown' ) ) {
	function post_templates_dropdown() {
		global $post;
		$post_templates = get_post_templates();

		foreach ( $post_templates as $template_name => $template_file ) { //loop through templates, make them options
			if ( $template_file == get_post_meta( $post->ID, '_wp_post_template', true ) ) {
				$selected = ' selected="selected"';
			} else {
				$selected = '';
			}
			$opt = '<option value="' . $template_file . '"' . $selected . '>' . $template_name . '</option>';
			echo $opt;
		}
	}
}

/**
 * Filter the single template value, and replace it with
 * the template chosen by the user, if they chose one.
 */
if ( ! function_exists( 'get_post_template' ) ) {
	function get_post_template( $template ) {
		global $post;
		if ( is_object( $post ) ) {
			$custom_field = get_post_meta( $post->ID, '_wp_post_template', true );
		}
		if ( ! empty( $custom_field ) ) {
			if ( file_exists( get_stylesheet_directory() . "/{$custom_field}" ) ) {
				$template = get_stylesheet_directory() . "/{$custom_field}";
			} else if ( file_exists( get_template_directory() . "/{$custom_field}" ) ) {
				$template = get_template_directory() . "/{$custom_field}";
			}
		}
		return $template;
	}
	add_filter( 'single_template', 'get_post_template' );
}

/**
 * Modelled on is_page_template, determine if we are in a single post template.
 * You can optionally provide a template name and then the check will be
 * specific to that template.
 *
 * @since 0.3
 * @uses $wp_query
 *
 * @param string $template The specific template name if specific matching is required.
 * @return bool True on success, false on failure.
 */
function is_post_template( $template = '' ) {
	if ( ! is_single() ) {
		return false;
	}

	$post_template = get_post_meta( get_queried_object_id(), '_wp_post_template', true );

	if ( empty( $template ) ) {
		return (bool) $post_template;
	}
	if ( $template == $post_template ) {
		return true;
	}
	if ( 'default' == $template && ! $post_template ) {
		return true;
	}
	return false;
}


/**
 * Remove potentially duplicated hero images in posts
 *
 * If the first paragraph of the post's content contains an img tag with a src,
 * and if the src is the same as the src as the post featured media image, or if
 * the src are different but the attachment IDs are the same, then remove the first
 * paragraph from the post's content to hide the duplicate image.
 *
 * This does catch img tags inside shortcodes.
 *
 * This does not remove leading images that are different from the post featured media
 *
 * @TODO The changes to the content in this function should eventually be made
 * permanent in the database. (@see https://github.com/INN/Largo/issues/354)
 *
 * If you would like to disable this function globally or on certain posts,
 * use the filter `largo_remove_hero`.
 *
 * @since 0.4 - in Largo's single-column template
 * @since 0.5.5 - in Largo's two-column template
 *
 * @param String $content the post content passed in by WordPress filter
 * @return String filtered post content.
 */
function largo_remove_hero( $content ) {

	global $post;
	// Abort if there is no global $post
	if ( ! isset( $post ) ) {
		return $content;
	}

	// 1: Only worry about this if:
	// - it's a single template, and
	// - there's a feature image, and
	// - we haven't overridden the post display, and
	// - we're not using a Largo layout

	/**
	 * Filter to disable largo_remove_hero based on the global $post at the time the function is run
	 *
	 * When building your own filter, you must set the fourth parameter of add_filter to 2:
	 *
	 *     function filter_largo_remove_hero( $run, $post ) {
	 *         # determine whether or not to run largo_remove_hero based on $post
	 *         return $run;
	 *     }
	 *     add_filter( 'largo_remove_hero', 'filter_largo_remove_hero', 10, 2 );
	 *                                                                     ^
	 *
	 * @param Bool $run Whether `largo_remove_hero()` should be run
	 * @param WP_Object $post The global $post at the time the function is run.
	 * @since 0.5.5
	 */
	$do_run = apply_filters( 'largo_remove_hero', true, $post );

	if ( ! $do_run ) {
		return $content;
	}

	if ( ! has_post_thumbnail( $post->ID ) ) {
		return $content;
	}

	$options = get_post_custom( $post->ID );

	if ( isset( $options['featured-image-display'][0] ) ) {
		return $content;
	}

	if ( of_get_option( 'single_template' ) != 'normal' && of_get_option( 'single_template' ) != 'classic' ) {
		return $content;
	}

	$p = explode( "\n", $content );

	// 2: Find an image (regex)
	//
	// Creates the array:
	// 		$matches[0] = <img src="..." class="..." id="..." />
	//		$matches[1] = image id from class="wp-image-[id]"
	$pattern = '/<img\s+[^>]*class="[^"]*?wp-image-(\d+)[^"]*?"\s+[^>]*[^>]*>/';
	$has_img = preg_match( $pattern, $p[0], $matches );

	// 3: if there's no image, there's nothing to worry about.
	if ( ! $has_img ) {
		return $content;
	}

	$featured_img_id = get_post_thumbnail_id();
	$post_img_id = $matches[1];

	if ( $featured_img_id === $post_img_id ) {
		$minus_image = str_replace( $matches[0], '', $content );
		// remove leading <p></p> tag, even if it contains HTML attributes,
		// but not if it's not empty
		return trim( preg_replace( '/^<p[^>]?><\/p>/m', '', $minus_image, 1 ) );
	}

	return $content;

}
add_filter( 'the_content', 'largo_remove_hero', 1 );

/**
 * Given a post type and an optional context, return the partial that should be loaded for that sort of post.
 *
 * The default context is search, and the context isn't actually used by this function,
 * but it is passed to the filter this function runs, largo_partial_by_post_type.
 *
 * @link https://github.com/INN/Largo/issues/1023
 * @param string $partial Required, the default partial in this context.
 * @param string $post_type Required, the given post's post type
 * @param string $context Required, the context of this partial.
 * @return string The partial that should be loaded. This defaults to 'search'.
 * @filter largo_partial_by_post_type
 * @since 0.5.4
 */
function largo_get_partial_by_post_type( $partial, $post_type, $context ) {
	/**
	 * Filter the output of largo_get_partial_by_post_type
	 *
	 * When building your own filter, you must set the fourth parameter of add_filter to 3:
	 *
	 *     function your_filter_name($partial, $post_type, $context) {
	 *         // things
	 *         return $partial;
	 *     }
	 *     add_filter('largo_partial_by_post_type', 'your_filter_name', 10, 3);
	 *                                                                      ^
	 * Without setting '3', your filter will not be passed the $post_type or $context arguments.
	 * In order to set '3', you must set the third parameter of add_filter, which defaults to 10. it is safe to leave that at 10.
	 *
	 * @since 0.5.4
	 * @param string $partial The string representing the template partial to use for the current post
	 * @param string $post_type The current post's post_type
	 * @param string $context The context in which this filter is being called, defaulting to search.
	 */
	$partial = apply_filters( 'largo_partial_by_post_type', $partial, $post_type, $context );

	return $partial;
}
