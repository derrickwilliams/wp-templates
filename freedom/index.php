<?php 
/**
 * Theme Index Section for our theme.
 *
 * @package ThemeGrill
 * @subpackage Freedom
 * @since Freedom 1.0
 */

get_header(); ?>

	<?php do_action( 'freedom_before_body_content' ); ?>

	<div id="primary">
		<div id="content" class="clearfix">

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'content', '' ); ?>

				<?php endwhile; ?>

				<?php get_template_part( 'navigation', 'none' ); ?>

			<?php else : ?>

				<?php get_template_part( 'no-results', 'none' ); ?>
				
			<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->
	
	<?php freedom_sidebar_select(); ?>
	
	<?php do_action( 'freedom_after_body_content' ); ?>

<?php get_footer(); ?>