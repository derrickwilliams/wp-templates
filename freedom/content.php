<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package ThemeGrill
 * @subpackage Freedom
 * @since Freedom 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'normal-view' ); ?>>
	<?php do_action( 'freedom_before_post_content' ); ?>

	<header class="entry-header">
		<h2 class="entry-title">
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php the_title(); ?></a>
		</h2>
	</header>

	<?php
		if ( 'post' == get_post_type() ) :
			freedom_entry_meta();
		endif;
	?>

	<?php
		if( has_post_thumbnail() ) {
			$image = '';
     		$title_attribute = the_title_attribute( 'echo=0' );
     		$image .= '<figure class="post-featured-image">';
  			$image .= '<a href="' . get_permalink() . '" title="'.$title_attribute.'">';
  			$image .= get_the_post_thumbnail( $post->ID, 'featured', array( 'title' => $title_attribute, 'alt' => $title_attribute ) ).'</a>';
  			$image .= '</figure>';
  			echo $image;
  		}
	?>

	<div class="entry-content clearfix">
		<?php
			global $more;
			$more = 0;
			the_content( '<span>'.__( 'Read more', 'freedom' ).'</span>' );
		?>
	</div>

	<?php do_action( 'freedom_after_post_content' ); ?>
</article>