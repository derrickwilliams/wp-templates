<?php
/**
 * Displays the searchform of the theme.
 *
 * @package ThemeGrill
 * @subpackage Freedom
 * @since Freedom 1.0
 */
?>
<form action="<?php echo esc_url( home_url( '/' ) ); ?>" id="search-form" class="searchform clearfix" method="get">
	<input type="text" placeholder="<?php esc_attr_e( 'Search', 'freedom' ); ?>" class="s field" name="s">
	<input type="submit" value="<?php esc_attr_e( 'Search', 'freedom' ); ?>" class="search-submit submit" name="submit">
</form><!-- .searchform -->