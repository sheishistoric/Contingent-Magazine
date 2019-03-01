<?php

/**
 * Check if the Series taxonomy is enabled
 *
 * Is the series equivalent of the WordPress function is_category();
 * We didn't call the function is_series() because it needs the largo_ prefix.
 *
 * @uses global $post
 * @uses largo_is_series_enabled
 * @since 0.4
 * @return bool Whether or not the Series taxonomy option is enabled in the Theme Options > Advanced
 */
function largo_is_series_enabled() {
	$series_enabled = of_get_option( 'series_enabled' );
	return !empty( $series_enabled );
}

/**
 * Check if Series landing pages are enabled
 *
 * @since 0.5.2
 * @return bool Whether or not the Series Landing Page  option is enabled in the Theme Options > Advanced
 */
function largo_is_series_landing_enabled() {
	$series_landing_enabled = of_get_option( 'custom_landing_enabled' );
	return !empty( $series_landing_enabled );
}

/**
 * Register the prominence and series custom taxonomies
 * Insert the default terms
 *
 * @uses  largo_is_series_enabled
 * @since 0.3
 */
function largo_custom_taxonomies() {

	/*
	 * Register the "Post Prominence" taxonomy, which is used to determine where posts display
	 */
	if ( !taxonomy_exists( 'prominence' ) ) {
		register_taxonomy(
			'prominence',
			'post',
			array(
				'hierarchical'  => true,
				'labels'        => array(
					'name'              => _x( 'Post Prominence', 'taxonomy general name' ),
					'singular_name'     => _x( 'Post Prominence', 'taxonomy singular name' ),
					'search_items'      => __( 'Search Post Prominences' ),
					'all_items'         => __( 'All Post Prominences' ),
					'parent_item'       => __( 'Parent Post Prominence' ),
					'parent_item_colon' => __( 'Parent Post Prominence:' ),
					'edit_item'         => __( 'Edit Post Prominence' ),
					'view_item'         => __( 'View Post Prominence' ),
					'update_item'       => __( 'Update Post Prominence' ),
					'add_new_item'      => __( 'Add New Post Prominence' ),
					'new_item_name'     => __( 'New Post Prominence Name' ),
					'menu_name'         => __( 'Post Prominence' ),
				),
				'query_var'     => true,
				'rewrite'       => true,
				'show_in_rest'  => true,
			)
		);
	}

	$termsDefinitions = array(
		array(
			'name' => __( 'Featured in Category', 'largo' ),
			'description' => __( 'This will allow you to designate a story to appear more prominently on category archive pages.', 'largo' ),
			'slug' => 'category-featured'
		),
		array(
			'name' => __( 'Homepage Featured', 'largo' ),
			'description' => __( 'Add this label to posts to display them in the featured area on the homepage.', 'largo' ),
			'slug' => 'homepage-featured'
		)
	);

	if (largo_is_series_enabled()) {
		$termsDefinitions[] = array(
			'name' => __( 'Featured in Series', 'largo' ),
			'description' => __( 'Select this option to allow this post to float to the top of any/all series landing pages sorting by Featured first.', 'largo' ),
			'slug' => 'series-featured'
		);
	}

	$largoProminenceTerms = apply_filters( 'largo_prominence_terms', $termsDefinitions );

	$changed = false;
	$terms = get_terms( 
		'prominence', 
		array(
			'hide_empty' => false,
			'fields' => 'all'
		)
	);
	$names = array_map( function( $arg ) { return $arg->name; }, $terms );

	$term_ids = array();
	foreach ( $largoProminenceTerms as $term ) {
		if ( !in_array( $term['name'], $names ) ) {
			wp_insert_term(
				$term['name'], 'prominence',
				array(
					'description' => $term['description'],
					'slug' => $term['slug']
				)
			);
			$changed = true;
		}
	}

	if ( $changed ) {
		delete_option('prominence_children');
	}

	do_action( 'largo_after_create_prominence_taxonomy', $largoProminenceTerms );

	/*
	 * Register the "Post Types" taxonomy, used for icons. This is not enabled by default in Largo.
	 *
	 * Replaces Largo_Term_Icons::register_post_type and unregister_post_types_taxonomy()
	 * @since 0.5.5
	 * @link https://github.com/INN/Largo/issues/1173
	 */
	if ( !taxonomy_exists('post-type') ) {
		$enabled = ( ! of_get_option( 'post_types_enabled' ) == 0 );
		register_taxonomy(
			'post-type',
			array( 'post' ),
			array(
				'label' => __( 'Post Types', 'largo' ),
				'labels' => array(
					'name' => __( 'Post Types', 'largo' ),
					'singular_name' => __( 'Post Type', 'largo' ),
					'all_items' => __( 'All Post Types', 'largo' ),
					'edit_item' => __( 'Edit Post Type', 'largo' ),
					'update_item' => __( 'Update Post Type', 'largo' ),
					'view_item' => __( 'View Post Type', 'largo' ),
					'add_new_item' => __( 'Add New Post Type', 'largo' ),
					'new_item_name' => __( 'New Post Type Name', 'largo' ),
					'search_items' => __( 'Search Post Type'),
				),
				'public' => $enabled,
				'show_admin_column' => $enabled,
				'show_in_nav_menus' => $enabled,
				'hierarchical' => true,
				'show_in_rest'  => true,
			)
		);
	}

	/**
	 * Register the "Series" taxonomy, used to group posts together by ongoing coverage. This is not enabled by default in Largo.
	 *
	 */
	if ( ! taxonomy_exists( 'series' ) ) {
		$series_enabled = largo_is_series_enabled();
		register_taxonomy(
			'series',
			'post',
			array(
				'hierarchical' => true,
				'labels' => array(
					'name' => _x( 'Series', 'taxonomy general name' ),
					'singular_name' => _x( 'Series', 'taxonomy singular name' ),
					'search_items' => __( 'Search Series' ),
					'all_items' => __( 'All Series' ),
					'parent_item' => __( 'Parent Series' ),
					'parent_item_colon' => __( 'Parent Series:' ),
					'edit_item' => __( 'Edit Series' ),
					'view_item' => __( 'View Series' ),
					'update_item' => __( 'Update Series' ),
					'add_new_item' => __( 'Add New Series' ),
					'new_item_name' => __( 'New Series Name' ),
					'menu_name' => __( 'Series' ),
				),
				'public' => $series_enabled,
				'show_admin_column' => $series_enabled,
				'show_in_nav_menus' => $series_enabled,
				'query_var' => true,
				'rewrite' => true,
				'show_in_rest'  => true,
			)
		);
	}
}
add_action( 'init', 'largo_custom_taxonomies' );


/**
 * Determines whether a post is in a series.
 * Expects to be called from within The Loop.
 * Is the series equivalent of the WordPress function is_category();
 * We didn't call the function is_series() because it needs the largo_ prefix.
 *
 * @uses global $post
 * @uses largo_is_series_enabled
 * @return bool
 * @since 0.3
 */
function largo_post_in_series( $post_id = NULL ) {
	if ( ! largo_is_series_enabled() ) return false;
	global $post;
	$the_id = ( $post_id ) ? $post_id : $post->ID ;
	$features = get_the_terms( $the_id, 'series' );
	return ( $features ) ? true : false;
}

/**
 * Outputs custom taxonomy terms attached to a post
 *
 * @return array of terms
 * @since 0.3
 */
function largo_custom_taxonomy_terms( $post_id ) {
	$taxonomies = apply_filters( 'largo_custom_taxonomies', array( 'series' ) );
	$post_terms = array();
	foreach ( $taxonomies as $tax ) {
		if ( taxonomy_exists( $tax ) ) {
			$terms = get_the_terms( $post_id, $tax );
			if ( $terms )
				$post_terms = array_merge( $post_terms, $terms );
		}
	}
	return $post_terms;
}

/**
 * Output format for the series custom taxonomy at the bottom of single posts
 *
 * @param $term array the term we want to output
 * @since 0.3
 */
if ( ! function_exists( 'largo_term_to_label' ) ) {
	function largo_term_to_label( $term ) {
	    return sprintf( '<div class="series-label"><h5><a href="%1$s">%2$s</a><a class="rss-link" href="%3$s"></a></h5><p>%4$s</p></div>',
	    	get_term_link( $term, $term->taxonomy ),
	    	esc_attr( $term->name ),
	    	get_term_feed_link( $term->term_id, $term->taxonomy ),
	    	esc_attr( strip_tags ( $term->description )
	    ));
	}
}

/**
 * Helper function for getting posts in proper landing-page order for a series
 *
 * @uses largo_is_series_enabled
 * @param integer series term id
 * @param integer number of posts to fetch, defaults to all
 * @since 0.4
 */
function largo_get_series_posts( $series_id, $number = -1 ) {

	// If series are not enabled, then there are no posts in a series.
	if ( !largo_is_series_enabled() ) return;

	// get the cf-tax-landing
	$args = array(
		'post_type' => 'cftl-tax-landing',
		'posts_per_page' => 1,
		'tax_query' => array( array(
			'taxonomy' => 'series',
			'field' => 'id',
			'terms' => $series_id
		)),
	);
	$landing = new WP_Query( $args );

	$series_args = array(
		'post_type' 		=> 'post',
		'tax_query' => array(
			array(
				'taxonomy' => 'series',
				'field' => 'id',
				'terms' => $series_id
			)
		),
		'order' 			=> 'DESC',
		'orderby' 		=> 'date',
		'posts_per_page' 	=> $number
	);

	if ( $landing->found_posts ) {
		$landing->next_post();
		$order = get_post_meta( $landing->post->ID, 'post_order', TRUE );
		switch ( $order ) {
			case 'ASC':
				$series_args['order'] = 'ASC';
				break;
			case 'custom':
				$series_args['orderby'] = 'series_custom';
				break;
			case 'featured, DESC':
			case 'featured, ASC':
				$series_args['orderby'] = $order;
				break;
		}
	}

	$series_posts = new WP_Query( $series_args );

	if ( $series_posts->found_posts ) return $series_posts;

	return false;

}

/**
* Filter: post_type_link
*
* Filter post permalinks for the Landing Page custom post type.
* Replace direct post link with the link for the associated
* Series taxonomy term, using the most recently created term
* if multiple are set.
*
* This filter overrides the wp-taxonomy-landing filter,
* which attempts to use the link for ANY term from ANY taxonomy.
* Largo really only cares about the Series taxonomy.
*
* @since 0.5
* @return filtered $post_link, replacing a Landing Page link with its Series link as needed
*/
function largo_series_landing_link( $post_link, $post ) {
	// Get configuration setting for Custom Landing Pages
	$opt_custom_landing_enabled = of_get_option( 'custom_landing_enabled', 0 );
	$custom_landing_enabled = !empty( $opt_custom_landing_enabled );

	// Only process Landing Page post type when Series Landing Pages are enabled
	if ( "cftl-tax-landing" == $post->post_type && $custom_landing_enabled ) {
		// Get all series taxonomy terms for this landing page
		$series_terms = wp_get_object_terms(
			$post->ID,
			'series',
			array(
				'orderby' => 'term_id',
				'order' => 'DESC',
				'fields' => 'slugs'
			)
		);
		// Only proceed if we successfully found at least 1 series term
		if ( ! is_wp_error( $series_terms ) && ! empty( $series_terms ) ) {
			// Get the link for the first series term
			// (ordered by the highest ID in the case of multiple terms)
			$term_link = get_term_link( $series_terms[0], 'series' );
			// Only proceed if we successfully found the term link
			if ( ! is_wp_error( $term_link ) && strlen( trim( $term_link ) ) ) {
				$post_link = esc_url( $term_link );
			}
		}
	}
	// Return the filtered link
	return $post_link;
}
// wp-taxonomy-landing library filters at priority 10.
// We must filter AFTER that.
add_filter( 'post_type_link', 'largo_series_landing_link', 22, 2 );

/**
 * Helper to get the Series Landing Page for a given series.
 *
 * @param Object|id|string $series
 * @return array An array of all WP_Post objects answering the description of this series. May be 0, 1 or conceivably many.
 */
function largo_get_series_landing_page_by_series( $series ) {
	if ( ! is_object( $series ) ) {
		if ( is_int( $series ) ) {
			$series = get_term( $series, $taxonomy );
		} else {
			$series = get_term_by( 'slug', $series, $taxonomy );
		}
	}

	// get the cftl-tax-landing
	$args = array(
		'post_type' => 'cftl-tax-landing',
		'posts_per_page' => 1,
		'tax_query' => array( array(
			'taxonomy' => 'series',
			'field' => 'id',
			'terms' => $series->term_id
		)),
	);

	$landing = new WP_Query( $args );

	return $landing->posts;
}
