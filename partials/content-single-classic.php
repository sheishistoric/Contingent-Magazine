<?php
/**
 * The template for displaying content in the single.php template
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'hnews item' ); ?> itemscope itemtype="https://schema.org/Article">

	<?php do_action( 'largo_before_post_header' ); ?>

	<header>

		<h1 class="entry-title" itemprop="headline"><?php the_title(); ?></h1>
		<?php if ( $subtitle = get_post_meta( $post->ID, 'subtitle', true ) )
			echo '<h2 class="subtitle">' . $subtitle . '</h2>';
		?>
		<h5 class="byline"><?php largo_byline( true, false, get_the_ID() ); ?></h5>

		<?php
			if ( !of_get_option( 'single_social_icons' ) == false ) {
				largo_post_social_links();
			}
		?>

		<?php largo_post_metadata( $post->ID ); ?>

	</header><!-- / entry header -->

	<?php
		do_action( 'largo_after_post_header' );

		largo_hero( null,'' );

		do_action( 'largo_after_hero' );
	?>

	<div class="entry-content clearfix" itemprop="articleBody">
		<?php largo_entry_content( $post ); ?>
	</div><!-- .entry-content -->

	<?php do_action( 'largo_after_post_content' ); ?>

	<footer class="post-meta bottom-meta">

	</footer><!-- /.post-meta -->

	<?php do_action( 'largo_after_post_footer' ); ?>

</article><!-- #post-<?php the_ID(); ?> -->
