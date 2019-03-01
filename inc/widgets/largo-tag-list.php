<?php
/*
 * List all of the terms in a custom taxonomy
 */
class largo_tag_list_widget extends WP_Widget {

	function __construct() {
		$widget_ops = array(
			'classname' 	=> 'largo-tag-list',
			'description' 	=> __('A list of tags for the current post; formerly a theme option.', 'largo')
		);
		parent::__construct( 'largo-tag-list-widget', __('Largo Tag List', 'largo'), $widget_ops);
	}

	function widget( $args, $instance ) {
		global $post;

		// only useful on post pages
		if ( !is_single() ) return;

		$title = apply_filters('widget_title', empty( $instance['title'] ) ? __( 'Tags ', 'largo' ) : $instance['title'], $instance, $this->id_base);

		echo $args['before_widget'];
		?>
		  <!-- Post tags -->
		<?php if ( largo_has_categories_or_tags() ): ?>
			<div class="tags clearfix">
				<h5><?php echo $title; ?></h5>
				<ul>
					<?php largo_categories_and_tags( $instance['tag_limit'], true, true, false, '', 'li' ); ?>
				</ul>
			</div>
		<?php endif;

		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		$instance['tag_limit'] = (int) $new_instance['tag_limit'];
		return $instance;
	}

	function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title' => __('Filed Under:', 'largo'), 'tag_limit' => 20) );
		$title = esc_attr( $instance['title'] );
		$tag_limit = $instance['tag_limit'];
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'largo' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>

		<p>
			<label for="<?php echo $this->get_field_id('tag_limit'); ?>"><?php _e('Max # of tags to show:', 'largo'); ?></label>
			<select name="<?php echo $this->get_field_name('tag_limit'); ?>" id="<?php echo $this->get_field_id('tag_limit'); ?>">
			<?php
			for ($i = 5; $i < 41; $i+=5) {
				echo '<option value="', $i, '"', selected($tag_limit, $i, FALSE), '>', $i, '</option>';
			} ?>
			</select>
		</p>

	<?php
	}

}
