<?php
/**
 * The template used for displaying posts page (images listing view).
 *
 * @package ThemeGrill
 * @subpackage Freedom
 * @since Freedom 1.0
 */

global $post_i;
if( $post_i % 2 == 1 )
	$article_class = 'tg-two-column-post-left';
else
	$article_class = 'tg-two-column-post-right';

if( has_post_thumbnail() )
	$article_class .= ' yes-post-thumbnail';
else
	$article_class .= ' no-post-thumbnail';

$article_class .= ' post-box';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $article_class ); ?>>
	<?php do_action( 'freedom_before_post_content' ); ?>
		<?php
			if( has_post_thumbnail() ) {
				$image = '';
	     		$title_attribute = the_title_attribute( 'echo=0' );
	     		$image .= '<figure class="post-featured-image">';
	  			$image .= '<a href="' . get_permalink() . '" title="'.$title_attribute.'">';
	  			$image .= get_the_post_thumbnail( $post->ID, 'featured-home', array( 'title' => $title_attribute, 'alt' => $title_attribute ) ).'</a>';
	  			$image .= '</figure>';
	  			echo $image;
	  		}
	  		else {
	  			$image = '<figure><img width="485" height="400" src="'.FREEDOM_ADMIN_IMAGES_URL.'/featured-image-place-holder.png"></figure>';
	  			echo $image;
	  		}
		?>

		<div class="post-content-area">
			<header class="entry-header">
				<h2 class="entry-title">
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php the_title(); ?></a>
				</h2>
			</header>

			<?php freedom_home_entry_meta(); ?>
		</div>

	<?php do_action( 'freedom_after_post_content' ); ?>
</article>

<?php $post_i++; ?>