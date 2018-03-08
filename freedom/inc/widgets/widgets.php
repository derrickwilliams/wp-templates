<?php
/**
 * Contains all the functions related to sidebar and widget.
 *
 * @package ThemeGrill
 * @subpackage Freedom
 * @since Freedom 1.0
 */

add_action( 'widgets_init', 'freedom_widgets_init');
/**
 * Function to register the widget areas(sidebar) and widgets.
 */
function freedom_widgets_init() {

	// Registering main right sidebar
	register_sidebar( array(
		'name' 				=> __( 'Right Sidebar', 'freedom' ),
		'id' 					=> 'freedom_right_sidebar',
		'description'   	=> __( 'Shows widgets at Right side.', 'freedom' ),
		'before_widget' 	=> '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  	=> '</aside>',
		'before_title'  	=> '<h3 class="widget-title">',
		'after_title'   	=> '</h3>'
	) );	

	// Registering main left sidebar
	register_sidebar( array(
		'name' 				=> __( 'Left Sidebar', 'freedom' ),
		'id' 					=> 'freedom_left_sidebar',
		'description'   	=> __( 'Shows widgets at Left side.', 'freedom' ),
		'before_widget' 	=> '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  	=> '</aside>',
		'before_title'  	=> '<h3 class="widget-title">',
		'after_title'   	=> '</h3>'
	) );

	// Registering Header sidebar
	register_sidebar( array(
		'name' 				=> __( 'Header Sidebar', 'freedom' ),
		'id' 					=> 'freedom_header_sidebar',
		'description'   	=> __( 'Shows widgets in header section just above the main navigation menu.', 'freedom' ),
		'before_widget' 	=> '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  	=> '</aside>',
		'before_title'  	=> '<h3 class="widget-title">',
		'after_title'   	=> '</h3>'
	) );

	// Registering contact Page sidebar
	register_sidebar( array(
		'name' 				=> __( 'Contact Page Sidebar', 'freedom' ),
		'id' 					=> 'freedom_contact_page_sidebar',
		'description'   	=> __( 'Shows widgets on Contact Page Template.', 'freedom' ),
		'before_widget' 	=> '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  	=> '</aside>',
		'before_title'  	=> '<h3 class="widget-title"><span>',
		'after_title'   	=> '</span></h3>'
	) );

	// Registering Error 404 Page sidebar
	register_sidebar( array(
		'name' 				=> __( 'Error 404 Page Sidebar', 'freedom' ),
		'id' 					=> 'freedom_error_404_page_sidebar',
		'description'   	=> __( 'Shows widgets on Error 404 page.', 'freedom' ),
		'before_widget' 	=> '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  	=> '</aside>',
		'before_title'  	=> '<h3 class="widget-title">',
		'after_title'   	=> '</h3>'
	) );

	// Registering footer sidebar one
	register_sidebar( array(
		'name' 				=> __( 'Footer Sidebar One', 'freedom' ),
		'id' 					=> 'freedom_footer_sidebar_one',
		'description'   	=> __( 'Shows widgets at footer sidebar one.', 'freedom' ),
		'before_widget' 	=> '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  	=> '</aside>',
		'before_title'  	=> '<h3 class="widget-title">',
		'after_title'   	=> '</h3>'
	) );

	// Registering footer sidebar two
	register_sidebar( array(
		'name' 				=> __( 'Footer Sidebar Two', 'freedom' ),
		'id' 					=> 'freedom_footer_sidebar_two',
		'description'   	=> __( 'Shows widgets at footer sidebar two.', 'freedom' ),
		'before_widget' 	=> '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  	=> '</aside>',
		'before_title'  	=> '<h3 class="widget-title">',
		'after_title'   	=> '</h3>'
	) );
}

/****************************************************************************************/
?>