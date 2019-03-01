<?php

/**
 * Setup the Largo custom widgets
 *
 * @package Largo
 * @since 1.0
 */
function largo_widgets() {
	$unregister = array(
		'WP_Widget_Pages',
		'WP_Widget_Calendar',
		'WP_Widget_Links',
		'WP_Widget_Tag_Cloud',
		'WP_Widget_Meta',
		'WP_Widget_Recent_Comments',
		'WP_Widget_Recent_Posts'
	);
	foreach ( $unregister as $widget ) {
		unregister_widget( $widget );
	}
	$register = array(
		'largo_about_widget' => '/inc/widgets/largo-about.php',
		'largo_donate_widget' => '/inc/widgets/largo-donate.php',
		'largo_facebook_widget' => '/inc/widgets/largo-facebook.php',
		'largo_follow_widget' => '/inc/widgets/largo-follow.php',
		'largo_image_widget' => '/inc/widgets/largo-image-widget.php',
		'largo_recent_comments_widget' => '/inc/widgets/largo-recent-comments.php',
		'largo_recent_posts_widget' => '/inc/widgets/largo-recent-posts.php',
		'largo_taxonomy_list_widget' => '/inc/widgets/largo-taxonomy-list.php',
		'largo_twitter_widget' => '/inc/widgets/largo-twitter.php',
		'largo_related_posts_widget' => '/inc/widgets/largo-related-posts.php',
		'largo_author_widget' => '/inc/widgets/largo-author-bio.php',
		'largo_tag_list_widget' => '/inc/widgets/largo-tag-list.php',
		'largo_prev_next_post_links_widget' => '/inc/widgets/largo-prev-next-post-links.php',
		'largo_staff_widget' => '/inc/widgets/largo-staff.php'
	);

	// If series are enabled
	if ( of_get_option('series_enabled') !== false ) {
		$register['largo_series_posts_widget'] = '/inc/widgets/largo-series-posts.php';
		$register['largo_post_series_links_widget'] = '/inc/widgets/largo-post-series-links.php';
	}

	/* If disclaimer is enabled */
	if( of_get_option('disclaimer_enabled') )
		$register['largo_disclaimer_widget'] = '/inc/widgets/largo-disclaimer-widget.php';

	foreach ( $register as $key => $val ) {
		require_once( get_template_directory() . $val );
		register_widget( $key );
	}
}
add_action( 'widgets_init', 'largo_widgets', 1 );


/**
 * Add custom CSS classes to sidebar widgets
 *
 * In addition to the usual WordPress widget classes, we add:
 *  - iterative classes (widget-1, widget-2, etc.) reset for each sidebar
 *  - odd/even classes
 *  - default/rev/no-bg classes
 *  - Bootstrap's responsive classes
 * To give use a lot more styling hooks
 *
 * Partially adapted from Illimar Tambek's Widget Title Links plugin
 * https://github.com/ragulka/widget-title-links
 *
 * @package Largo
 * @since 1.0
 */
function largo_add_widget_classes( $params ) {
	global $wp_registered_widgets;
	$widget_id	= $params[0]['widget_id'];
	$widget = $wp_registered_widgets[$widget_id];
	$number = $widget['params'][0]['number'];
	$option_name = get_option($widget['callback'][0]->option_name);

	global $widget_num;

	// Widget class
	$class = array();
	$class[] = 'widget';

	// Iterated class
	$widget_num++;
	$class[] = 'widget-' . $widget_num;

	// Alt class
	if ($widget_num % 2)
		$class[] = 'odd';
	else
		$class[] = 'even';

	// Default, Reverse or No Background Classes (used as CSS hooks)
	if (!empty($option_name[$number]['widget_class']))
		$class[] = $option_name[$number]['widget_class'];

	// Bootstrap responsive classes to control display of content on various screen sizes
	if (array_key_exists('hidden_desktop', $option_name[$number]) && $option_name[$number]['hidden_desktop'] === 1)
		$class[] = 'hidden-desktop';
	if (array_key_exists('hidden_tablet', $option_name[$number]) && $option_name[$number]['hidden_tablet'] === 1)
		$class[] = 'hidden-tablet';
	if (array_key_exists('hidden_phone', $option_name[$number]) && $option_name[$number]['hidden_phone'] === 1)
		$class[] = 'hidden-phone';

	// Join the classes in the array
	$class = join(' ', $class);

	// Interpolate the 'my_widget_class' placeholder
	$params[0]['before_widget'] = preg_replace('/class="/', 'class="' . $class . ' ', $params[0]['before_widget']);
	return $params;
}
add_filter('dynamic_sidebar_params', 'largo_add_widget_classes');


/**
 * Resets the counter for each subsequent sidebar
 *
 * @since 1.0
 */
function largo_widget_counter_reset() {
   global $widget_num;
   $widget_num = 0;
}
add_action('dynamic_sidebar_after', 'largo_widget_counter_reset', 99);
add_action('get_sidebar', 'largo_widget_counter_reset', 99);


/**
 * Add custom fields to widget forms
 *
 * @since 1.0
 * @uses add_action() 'in_widget_form'
 */
function largo_widget_custom_fields_form( $widget, $args, $instance ) {
	$desktop = ! empty( $instance['hidden_desktop'] ) ? 'checked="checked"' : '';
	$tablet = ! empty( $instance['hidden_tablet'] ) ? 'checked="checked"' : '';
	$phone = ! empty( $instance['hidden_phone'] ) ? 'checked="checked"' : '';
?>
  <label for="<?php echo $widget->get_field_id( 'widget_class' ); ?>"><?php _e('Widget Background', 'largo'); ?></label>
  <select id="<?php echo $widget->get_field_id('widget_class'); ?>" name="<?php echo $widget->get_field_name('widget_class'); ?>" class="widefat" style="width:90%;">
  	<option <?php selected( $instance['widget_class'], 'default'); ?> value="default"><?php _e('Default', 'largo'); ?></option>
  	<option <?php selected( $instance['widget_class'], 'rev'); ?> value="rev"><?php _e('Reverse', 'largo'); ?></option>
  	<option <?php selected( $instance['widget_class'], 'no-bg'); ?> value="no-bg"><?php _e('No Background', 'largo'); ?></option>
  </select>

  <p style="margin:15px 0 10px 5px">
	<input class="checkbox" type="checkbox" <?php echo $desktop; ?> id="<?php echo $widget->get_field_id('hidden_desktop'); ?>" name="<?php echo $widget->get_field_name('hidden_desktop'); ?>" /> <label for="<?php echo $widget->get_field_id('hidden_desktop'); ?>"><?php _e('Hidden on Desktops?', 'largo'); ?></label>
	<br />
	<input class="checkbox" type="checkbox" <?php echo $tablet; ?> id="<?php echo $widget->get_field_id('hidden_tablet'); ?>" name="<?php echo $widget->get_field_name('hidden_tablet'); ?>" /> <label for="<?php echo $widget->get_field_id('hidden_tablet'); ?>"><?php _e('Hidden on Tablets?', 'largo'); ?></label>
	<br />
	<input class="checkbox" type="checkbox" <?php echo $phone; ?> id="<?php echo $widget->get_field_id('hidden_phone'); ?>" name="<?php echo $widget->get_field_name('hidden_phone'); ?>" /> <label for="<?php echo $widget->get_field_id('hidden_phone'); ?>"><?php _e('Hidden on Phones?', 'largo'); ?></label>
  </p>

  <p>
  	<label for="<?php echo $widget->get_field_id('title_link'); ?>"><?php _e('Widget Title Link <small class="description">(Example: https://google.com)</small>', 'largo'); ?></label>
    <input type="text" name="<?php echo $widget->get_field_name('title_link'); ?>" id="<?php echo $widget->get_field_id('title_link'); ?>"" class="widefat" value="<?php echo esc_attr( $instance['title_link'] ); ?>"" />
  </p>
<?php
}
add_action('in_widget_form', 'largo_widget_custom_fields_form', 1, 3);


/**
 * Register widget custom fields
 *
 * @since 1.0
 * @uses add_filter() 'widget_form_callback'
 */
function largo_register_widget_custom_fields ( $instance, $widget ) {
  if ( !isset($instance['widget_class']) )
    $instance['widget_class'] = 'default';
  if ( !isset($instance['hidden_desktop']) )
    $instance['hidden_desktop'] = null;
  if ( !isset($instance['hidden_tablet']) )
    $instance['hidden_tablet'] = null;
  if ( !isset($instance['hidden_phone']) )
    $instance['hidden_phone'] = null;
  if ( !isset($instance['title_link']) )
    $instance['title_link'] = null;
  return $instance;
}
add_filter('widget_form_callback', 'largo_register_widget_custom_fields', 10, 2);


/**
 * Add additional fields to widget update callback
 *
 * @since 1.0
 * @uses add_filter() 'widget_update_callback'
 */
function largo_widget_update_extend ( $instance, $new_instance ) {
  $instance['widget_class'] = sanitize_key( $new_instance['widget_class'] );
  $instance['hidden_desktop'] = ! empty( $new_instance['hidden_desktop'] ) ? 1 : 0;
  $instance['hidden_tablet'] = ! empty( $new_instance['hidden_tablet'] ) ? 1 : 0;
  $instance['hidden_phone'] = ! empty( $new_instance['hidden_phone'] ) ? 1 : 0;
  $instance['title_link'] = esc_url_raw( $new_instance['title_link'] );
  return $instance;
}
add_filter( 'widget_update_callback', 'largo_widget_update_extend', 10, 2 );


/**
 * Make it possible for widget titles to be links
 *
 * @since 1.0
 * @uses add_filter() 'widget_title'
 */
function largo_add_link_to_widget_title( $title, $instance = null ) {
  if (!empty($title) && !empty($instance['title_link'])) {
    $title = '<a href="' . esc_url( $instance['title_link'] ) . '">' . $title . '</a>';
  }
  return $title;
}
add_filter( 'widget_title', 'largo_add_link_to_widget_title', 99, 2 );

/**
 * Check to see if a widget area is registered and has widgets assigned
 *
 * @since 0.5.2
 */
function largo_is_sidebar_registered_and_active($sidebar) {
	$sidebars_widgets = get_option('sidebars_widgets', array());

	if (in_array($sidebar, array_keys($sidebars_widgets))) {
		if (count($sidebars_widgets[$sidebar]) > 0)
			return true;
	}

	return false;
}

/**
 * When activating the theme, make sure the article bottom widget area has widgets assigned
 *
 * @since 0.5.3
 */
function largo_populate_article_bottom_widget_area($theme) {
	// If the old article bottom settings are present, we'll skip populating the article bottom
	// area as those are handled during the migration/update.
	$old_largo_article_bottom_settings = array(
		'show_tags', 'show_author_box', 'show_related_content', 'show_next_prev_nav_single');

	$old_largo_article_bottom_settings_check = false;
	foreach ($old_largo_article_bottom_settings as $option_name) {
		$option = of_get_option($option_name);
		if (!empty($option)) {
			$old_largo_article_bottom_settings_check = true;
			break;
		}
	}

	if ($old_largo_article_bottom_settings_check)
		return;

	// Otherwise, if there's no largo_version or the 'article-bottom' area is empty,
	// we're on a clean install and should set the default widgets
	if (!of_get_option('largo_version') || !is_active_sidebar('article-bottom')) {
		largo_instantiate_widget('largo-author', array(), 'article-bottom');
		largo_instantiate_widget('largo-related-posts', array(), 'article-bottom');
	}
}
add_action('after_switch_theme', 'largo_populate_article_bottom_widget_area');
