<?php
/**
 * Home Template: Top Stories
 * Description: A newspaper-like layout highlighting one Top Story on the left and others to the right. A popular layout choice!
 * Sidebars: Homepage Left Rail (An optional widget area that, when enabled, appears to the left of the main content area on the homepage)
 */

global $largo, $shown_ids, $tags;
$topstory_classes = (largo_get_active_homepage_layout() == 'LegacyThreeColumn') ? 'top-story span12' : 'top-story span8';
?>
<div id="homepage-featured" class="row-fluid clearfix">

	<div <?php post_class( $topstory_classes ); ?>>

	<?php
		$topstory = largo_get_featured_posts( array(
			'tax_query' => array(
				array(
					'taxonomy' 	=> 'prominence',
					'field' 	=> 'slug',
					'terms' 	=> 'top-story'
				)
			),
			'posts_per_page' => 1
		) );
		if ( $topstory->have_posts() ) :
			while ( $topstory->have_posts() ) : $topstory->the_post(); $shown_ids[] = get_the_ID();
		?>
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'large' ); ?></a>
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<h5 class="byline"><?php largo_byline( true, false, get_the_ID() ); ?></h5>
				<?php largo_excerpt( $post, 4 ); ?>
				<?php if ( largo_post_in_series() ):
					$feature = largo_get_the_main_feature();
					$feature_posts = largo_get_recent_posts_for_term( $feature, 1, 1 );
					if ( $feature_posts ):
						foreach ( $feature_posts as $feature_post ): ?>

							<h4 class="related-story"><?php _e('Related:', 'largo'); ?> <a href="<?php echo esc_url( get_permalink( $feature_post->ID ) ); ?>"><?php echo get_the_title( $feature_post->ID ); ?></a></h4>
						<?php endforeach;
					endif;
				endif;
			endwhile;
		endif; // end top story ?>
	</div>

	<?php if ( largo_get_active_homepage_layout() !== 'LegacyThreeColumn' ) { ?>
		<div class="sub-stories span4">
			<?php
			$posts_per_page = 6;
			$posts_per_page = apply_filters( 'largo_homepage_topstories_post_count', $posts_per_page );
			$substories = largo_get_featured_posts( array(
				'tax_query' => array(
					array(
						'taxonomy' 	=> 'prominence',
						'field' 	=> 'slug',
						'terms' 	=> 'homepage-featured'
					)
				),
				'posts_per_page'		=> $posts_per_page,
				'post__not_in' 	=> $shown_ids
			) );
			if ( $substories->have_posts() ) :
				$count = 1;
				while ( $substories->have_posts() ) : $substories->the_post(); $shown_ids[] = get_the_ID();
					if ( $count <= 3 ) : ?>
						<div <?php post_class( 'story' ); ?> >
							<?php if ( largo_has_categories_or_tags() && $tags === 'top' ) {
								largo_maybe_top_term();
							} ?>
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
							<?php largo_excerpt( $post, 3 ); ?>
						</div>
					<?php elseif ( $count == 4 ) : ?>
						<h4 class="subhead"><?php _e('More Headlines', 'largo'); ?></h4>
						<h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
					<?php else : ?>
						<h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
					<?php endif;
					$count++;
				endwhile;
			endif; // end more featured posts ?>
		</div>
	<?php } ?>
</div>
