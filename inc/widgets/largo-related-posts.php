<?php
/*
 * List all of the terms in a custom taxonomy
 */
class largo_related_posts_widget extends WP_Widget {

	function __construct() {
		$widget_ops = array(
			'classname' 	=> 'largo-related-posts',
			'description' 	=> __('Lists posts related to the current post', 'largo')
		);
		parent::__construct( 'largo-related-posts-widget', __('Largo Related Posts', 'largo'), $widget_ops);
	}

	function widget( $args, $instance ) {
		global $post;
		// Preserve global $post
		$preserve = $post;

		// only useful on post pages
		if ( !is_single() ) return;

		$title = apply_filters('widget_title', empty( $instance['title'] ) ? __( 'Read Next', 'largo' ) : $instance['title'], $instance, $this->id_base);

		echo $args['before_widget'];

		if ( ! empty( $title ) ) echo $args['before_title'] . $title . $args['after_title'];

		if ( isset( $instance['qty'] ) ) {
			$related = new Largo_Related( $instance['qty'] );
		} else {
			$related = new Largo_Related( 1 );
		}

		//get the related posts
		$rel_posts = new WP_Query( array(
			'post__in' => $related->ids(),
			'nopaging' => 1,
			'post__not_in' => array( $post->ID ),
			'posts_per_page' => ( isset( $instance['qty'] ) ) ? $instance['qty'] : 1,
			'ignore_sticky_posts' => 1
		) );

		if ( $rel_posts->have_posts() ) {

			echo '<ul class="related">';

			while ( $rel_posts->have_posts() ) {
				$rel_posts->the_post();
				echo '<li>';

				echo '<a href="' . get_permalink() . '"/>' . get_the_post_thumbnail( get_the_ID(), 'thumbnail', array( 'class' => '' ) ) . '</a>';
				?>

				<h4><a href="<?php the_permalink(); ?>" title="Read: <?php esc_attr( the_title( '','', FALSE ) ); ?>"><?php the_title(); ?></a></h4>

				<?php if ( isset( $instance['show_byline'] ) && $instance['show_byline'] ) { ?>
					<h5 class="byline">
						<span class="by-author"><?php largo_byline( true, false, get_the_ID() ); ?></span>
					</h5>
				<?php } ?>

				<?php // post excerpt/summary
				largo_excerpt(get_the_ID(), 2, false, '', true);
				echo '</li>';
			}

			echo "</ul>";
		}
		echo $args['after_widget'];
		// Restore global $post
		wp_reset_postdata();
		$post = $preserve;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field($new_instance['title']);
		$instance['qty'] = (int) $new_instance['qty'];
		$instance['show_byline'] = isset( $new_instance['show_byline'] ) ? (int) $new_instance['show_byline'] : 0 ;
		return $instance;
	}

	function form( $instance ) {
		//Defaults
		$instance = wp_parse_args( (array) $instance, array( 'title' => 'Read Next', 'qty' => 1, 'show_byline' => 0, 'thumbnail_location' => 'before') );
		$title = esc_attr( $instance['title'] );
		$qty = $instance['qty'];
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title', 'largo' ); ?>:</label>
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

		<p>
			<label for="<?php echo $this->get_field_id('qty'); ?>"><?php _e('Number of Posts to Display', 'largo'); ?>:</label>
			<select name="<?php echo $this->get_field_name('qty'); ?>" id="<?php echo $this->get_field_id('qty'); ?>">
			<?php
			for ($i = 1; $i < 6; $i++) {
				echo '<option value="', $i, '"', selected($qty, $i, FALSE), '>', $i, '</option>';
			} ?>
			</select>
			<div class="description"><?php _e( "It's best to keep this at just one.", 'largo' ); ?></div>
		</p>

		<p><input id="<?php echo $this->get_field_id('show_byline'); ?>" name="<?php echo $this->get_field_name('show_byline'); ?>" type="checkbox" value="1" <?php checked( $instance['show_byline'], 1);?> />
			<label for="<?php echo $this->get_field_id('show_byline'); ?>"><?php _e( 'Show byline on each post', 'largo' ); ?></label>
		</p>

	<?php
	}

}
