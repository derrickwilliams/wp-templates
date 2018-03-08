<?php
/**
 * Contains all the fucntions and components related to header part.
 *
 * @package ThemeGrill
 * @subpackage Freedom
 * @since Freedom 1.0
 */

/****************************************************************************************/
// Filter the get_header_image_tag() for option of adding the link back to home page option
function freedom_header_image_markup( $html, $header, $attr ) {
	$output = '';
	$header_image = get_header_image();

	if( ! empty( $header_image ) ) {
		$output .= '<div class="header-image-wrap"><img src="' . esc_url( $header_image ) . '" class="header-image" width="' . get_custom_header()->width . '" height="' .  get_custom_header()->height . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '"></div>';
	}

	return $output;
}

function freedom_header_image_markup_filter() {
	add_filter( 'get_header_image_tag', 'freedom_header_image_markup', 10, 3 );
}

add_action( 'freedom_header_image_markup_render','freedom_header_image_markup_filter' );

/****************************************************************************************/

if ( ! function_exists( 'freedom_render_header_image' ) ) :
/**
 * Shows the small info text on top header part
 */
function freedom_render_header_image() {
	if ( function_exists( 'the_custom_header_markup' ) ) {
		do_action( 'freedom_header_image_markup_render' );
		the_custom_header_markup();
	} else {
		$header_image = get_header_image();
		if ( ! empty( $header_image ) ) {
		?>
			<div class="header-image-wrap"><img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></div>
		<?php
		}
	}
}
endif;

/****************************************************************************************/

if ( ! function_exists( 'freedom_featured_image_slider' ) ) :
/**
 * display featured post slider
 */
function freedom_featured_image_slider() {
	global $post;
	?>
		<section id="featured-slider">
			<div class="slider-cycle inner-wrap clearfix">
				<div class="slider-rotate">
					<?php
					for( $i = 1; $i <= 4; $i++ ) {
						$freedom_slider_title = get_theme_mod( 'freedom_slider_title'.$i , '' );
						$freedom_slider_text = get_theme_mod( 'freedom_slider_text'.$i , '' );
						$freedom_slider_image = get_theme_mod( 'freedom_slider_image'.$i , '' );
						$freedom_slider_button_text = get_theme_mod( 'freedom_slider_button_text'.$i , '' );
						$freedom_slider_link = get_theme_mod( 'freedom_slider_link'.$i , '#' );

						if( !empty( $freedom_header_title ) || !empty( $freedom_slider_text ) || !empty( $freedom_slider_image ) ) {
							if ( $i == 1 ) { $classes = "slides displayblock"; } else { $classes = "slides displaynone"; }

					?>
					<div class="<?php echo $classes; ?>">
						<figure>
							<img alt="<?php echo esc_attr( $freedom_slider_title ); ?>" src="<?php echo esc_url( $freedom_slider_image ); ?>">
						</figure>
						<div class="entry-container">
							<?php if( !empty( $freedom_slider_title ) || !empty( $freedom_slider_text ) ) { ?>
								<h2 class="entry-title"><a href="<?php echo esc_url( $freedom_slider_link ); ?>" title="<?php echo esc_attr( $freedom_slider_title ); ?>"><?php echo $freedom_slider_title; ?></a></h2>
								<div class="entry-content"><p><?php echo $freedom_slider_text; ?></p></div>
								<?php if( !empty( $freedom_slider_button_text ) ) { ?>
								<div class="slider-read-more-button"><a href="<?php echo esc_url( $freedom_slider_link ); ?>" title="<?php echo esc_attr( $freedom_slider_title ); ?>"><?php echo $freedom_slider_button_text; ?></a></div>
								<?php } ?>
							<?php } ?>
						</div>
					</div>
					<?php
					}
				}
				?>
				</div>
				<div class="slider-nav">
					<a class="slide-next" href="#"><i class="fa fa-angle-right"></i></a>
					<a class="slide-prev" href="#"><i class="fa fa-angle-left"></i></a>
				</div>
		</div>
		</section>
	<?php
}
endif;

/****************************************************************************************/

if ( ! function_exists( 'freedom_header_title' ) ) :
/**
 * Show the title in header
 */
function freedom_header_title() {
	if( is_archive() ) {
		if ( is_category() ) :
			$freedom_header_title = single_cat_title( '', FALSE );

		elseif ( is_tag() ) :
			$freedom_header_title = single_tag_title( '', FALSE );

		elseif ( is_author() ) :
			/* Queue the first post, that way we know
			 * what author we're dealing with (if that is the case).
			*/
			the_post();
			$freedom_header_title =  sprintf( __( 'Author: %s', 'freedom' ), '<span class="vcard">' . get_the_author() . '</span>' );
			/* Since we called the_post() above, we need to
			 * rewind the loop back to the beginning that way
			 * we can run the loop properly, in full.
			 */
			rewind_posts();

		elseif ( is_day() ) :
			$freedom_header_title = sprintf( __( 'Day: %s', 'freedom' ), '<span>' . get_the_date() . '</span>' );

		elseif ( is_month() ) :
			$freedom_header_title = sprintf( __( 'Month: %s', 'freedom' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

		elseif ( is_year() ) :
			$freedom_header_title = sprintf( __( 'Year: %s', 'freedom' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

		elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
			$freedom_header_title = __( 'Asides', 'freedom' );

		elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
			$freedom_header_title = __( 'Images', 'freedom');

		elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
			$freedom_header_title = __( 'Videos', 'freedom' );

		elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
			$freedom_header_title = __( 'Quotes', 'freedom' );

		elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
			$freedom_header_title = __( 'Links', 'freedom' );

		else :
			$freedom_header_title = __( 'Archives', 'freedom' );

		endif;
	}
	elseif( is_404() ) {
		$freedom_header_title = __( 'Page NOT Found', 'freedom' );
	}
	elseif( is_search() ) {
		$freedom_header_title = __( 'Search Results', 'freedom' );
	}
	elseif( is_page()  ) {
		$freedom_header_title = get_the_title();
	}
	elseif( is_single()  ) {
		$freedom_header_title = get_the_title();
	}
	else {
		$freedom_header_title = '';
	}

	return $freedom_header_title;

}
endif;

/****************************************************************************************/

?>
