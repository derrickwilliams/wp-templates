<?php
/**
 * Freedom Theme Customizer
 *
 * @package ThemeGrill
 * @subpackage Freedom
 * @since Freedom 1.0.5
 */

function freedom_customize_register($wp_customize) {

   // Theme important links started
   class Freedom_Important_Links extends WP_Customize_Control {

      public $type = "freedom-important-links";

      public function render_content() {
         //Add Theme instruction, Support Forum, Demo Link, Rating Link
         $important_links = array(
            'theme-info' => array(
               'link' => esc_url('https://themegrill.com/themes/freedom/'),
               'text' => __('Theme Info', 'freedom'),
            ),
            'support' => array(
               'link' => esc_url('https://themegrill.com/support-forum/'),
               'text' => __('Support Forum', 'freedom'),
            ),
            'documentation' => array(
               'link' => esc_url('https://themegrill.com/theme-instruction/freedom/'),
               'text' => __('Documentation', 'freedom'),
            ),
            'demo' => array(
               'link' => esc_url('https://demo.themegrill.com/freedom/'),
               'text' => __('View Demo', 'freedom'),
            ),
            'rating' => array(
               'link' => esc_url('http://wordpress.org/support/view/theme-reviews/freedom?filter=5'),
               'text' => __('Rate this theme', 'freedom'),
            ),
         );
         foreach ($important_links as $important_link) {
            echo '<p><a target="_blank" href="' . $important_link['link'] . '" >' . esc_attr($important_link['text']) . ' </a></p>';
         }
      }

   }

   $wp_customize->add_section('freedom_important_links', array(
      'priority' => 1,
      'title' => __('Freedom Important Links', 'freedom'),
   ));

   /**
    * This setting has the dummy Sanitization function as it contains no value to be sanitized
    */
   $wp_customize->add_setting('freedom_important_links', array(
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'freedom_links_sanitize'
   ));

   $wp_customize->add_control(new Freedom_Important_Links($wp_customize, 'important_links', array(
      'section' => 'freedom_important_links',
      'settings' => 'freedom_important_links'
   )));
   // Theme Important Links Ended

   // Start of the Header Options
   // Header Options Area
   $wp_customize->add_panel('freedom_header_options', array(
      'capabitity' => 'edit_theme_options',
      'priority' => 500,
      'title' => __('Header', 'freedom')
   ));

   // Header Logo upload option
   $wp_customize->add_section('freedom_header_logo', array(
      'priority' => 1,
      'title' => __('Header Logo', 'freedom'),
      'panel' => 'freedom_header_options'
   ));

	if ( !function_exists('the_custom_logo') || ( get_theme_mod('freedom_header_logo_image', '') != '' ) ) {
		$wp_customize->add_setting('freedom_header_logo_image', array(
		  'default' => '',
		  'capability' => 'edit_theme_options',
		  'sanitize_callback' => 'esc_url_raw'
		));

		$wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'freedom_header_logo_image', array(
		  'label' => __('Upload logo for your header.', 'freedom'),
		  'description' => sprintf(__( '%sInfo:%s This option will be removed in upcoming update. Please go to Site Identity section to upload the theme logo.', 'freedom'  ), '<strong>', '</strong>'),

		  'section' => 'freedom_header_logo',
		  'setting' => 'freedom_header_logo_image'
		)));
	}
   // Header logo and text display type option
   $wp_customize->add_section('freedom_show_option', array(
      'priority' => 2,
      'title' => __('Show', 'freedom'),
      'panel' => 'freedom_header_options'
   ));

   $wp_customize->add_setting('freedom_show_header_logo_text', array(
      'default' => 'text_only',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'freedom_radio_select_sanitize'
   ));

   $wp_customize->add_control('freedom_show_header_logo_text', array(
      'type' => 'radio',
      'label' => __('Choose the option that you want.', 'freedom'),
      'section' => 'freedom_show_option',
      'choices' => array(
         'logo_only' => __('Header Logo Only', 'freedom'),
         'text_only' => __('Header Text Only', 'freedom'),
         'both' => __('Show Both', 'freedom'),
         'none' => __('Disable', 'freedom')
      )
   ));

   // New Responsive Menu
   $wp_customize->add_section('freedom_new_menu_style', array(
      'priority' => 3,
      'title' => esc_html__('Responsive Menu Style', 'freedom'),
      'panel' => 'freedom_header_options'
   ));
   $wp_customize->add_setting('freedom_new_menu', array(
      'default' => 0,
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'freedom_checkbox_sanitize'
   ));
   $wp_customize->add_control('freedom_new_menu', array(
      'type' => 'checkbox',
      'label' => esc_html__('Switch to new responsive menu', 'freedom'),
      'section' => 'freedom_new_menu_style',
      'settings' => 'freedom_new_menu'
   ));

   // End of Header Options

   // Start of the Design Options
   $wp_customize->add_panel('freedom_design_options', array(
      'capabitity' => 'edit_theme_options',
      'priority' => 505,
      'title' => __('Design', 'freedom')
   ));

   // site layout setting
   $wp_customize->add_section('freedom_site_layout_setting', array(
      'priority' => 1,
      'title' => __('Site Layout', 'freedom'),
      'panel' => 'freedom_design_options'
   ));

   $wp_customize->add_setting('freedom_site_layout', array(
      'default' => 'wide',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'freedom_radio_select_sanitize'
   ));

   $wp_customize->add_control('freedom_site_layout', array(
      'type' => 'radio',
      'label' => __('Choose your site layout. The change is reflected in whole site.', 'freedom'),
      'choices' => array(
         'box' => __('Boxed layout', 'freedom'),
         'wide' => __('Wide layout', 'freedom')
      ),
      'section' => 'freedom_site_layout_setting'
   ));

   class Freedom_Image_Radio_Control extends WP_Customize_Control {

      public function render_content() {

         if ( empty( $this->choices ) )
            return;

         $name = '_customize-radio-' . $this->id;

         ?>
         <style>
            #freedom-img-container .freedom-radio-img-img {
               border: 3px solid #DEDEDE;
               margin: 0 5px 5px 0;
               cursor: pointer;
               border-radius: 3px;
               -moz-border-radius: 3px;
               -webkit-border-radius: 3px;
            }
            #freedom-img-container .freedom-radio-img-selected {
               border: 3px solid #AAA;
               border-radius: 3px;
               -moz-border-radius: 3px;
               -webkit-border-radius: 3px;
            }
            input[type=checkbox]:before {
               content: '';
               margin: -3px 0 0 -4px;
            }
         </style>
         <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
         <ul class="controls" id='freedom-img-container'>
         <?php
            foreach ( $this->choices as $value => $label ) :
               $class = ($this->value() == $value)?'freedom-radio-img-selected freedom-radio-img-img':'freedom-radio-img-img';
               ?>
               <li style="display: inline;">
               <label>
                  <input <?php $this->link(); ?>style='display:none' type="radio" value="<?php echo esc_attr( $value ); ?>" name="<?php echo esc_attr( $name ); ?>" <?php $this->link(); checked( $this->value(), $value ); ?> />
                  <img src = '<?php echo esc_html( $label ); ?>' class = '<?php echo $class; ?>' />
               </label>
               </li>
               <?php
            endforeach;
         ?>
         </ul>
         <script type="text/javascript">
            jQuery(document).ready(function($) {
               $('.controls#freedom-img-container li img').click(function(){
                  $('.controls#freedom-img-container li').each(function(){
                     $(this).find('img').removeClass ('freedom-radio-img-selected') ;
                  });
                  $(this).addClass ('freedom-radio-img-selected') ;
               });
            });
         </script>
         <?php
      }
   }

   // default layout setting
   $wp_customize->add_section('freedom_default_layout_setting', array(
      'priority' => 2,
      'title' => __('Default layout', 'freedom'),
      'panel'=> 'freedom_design_options'
   ));

   $wp_customize->add_setting('freedom_default_layout', array(
      'default' => 'no_sidebar_full_width',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'freedom_radio_select_sanitize'
   ));

   $wp_customize->add_control(new Freedom_Image_Radio_Control($wp_customize, 'freedom_default_layout', array(
      'type' => 'radio',
      'label' => __('Select default layout. This layout will be reflected in whole site archives, categories, search page etc. The layout for a single post and page can be controlled from below options.', 'freedom'),
      'section' => 'freedom_default_layout_setting',
      'settings' => 'freedom_default_layout',
      'choices' => array(
         'right_sidebar' => FREEDOM_ADMIN_IMAGES_URL . '/right-sidebar.png',
         'left_sidebar' => FREEDOM_ADMIN_IMAGES_URL . '/left-sidebar.png',
         'no_sidebar_full_width' => FREEDOM_ADMIN_IMAGES_URL . '/no-sidebar-full-width-layout.png',
         'no_sidebar_content_centered' => FREEDOM_ADMIN_IMAGES_URL . '/no-sidebar-content-centered-layout.png'
      )
   )));

   // default layout for pages
   $wp_customize->add_section('freedom_default_page_layout_setting', array(
      'priority' => 3,
      'title' => __('Default layout for pages only', 'freedom'),
      'panel'=> 'freedom_design_options'
   ));

   $wp_customize->add_setting('freedom_pages_default_layout', array(
      'default' => 'right_sidebar',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'freedom_radio_select_sanitize'
   ));

   $wp_customize->add_control(new Freedom_Image_Radio_Control($wp_customize, 'freedom_pages_default_layout', array(
      'type' => 'radio',
      'label' => __('Select default layout for pages. This layout will be reflected in all pages unless unique layout is set for specific page.', 'freedom'),
      'section' => 'freedom_default_page_layout_setting',
      'settings' => 'freedom_pages_default_layout',
      'choices' => array(
         'right_sidebar' => FREEDOM_ADMIN_IMAGES_URL . '/right-sidebar.png',
         'left_sidebar' => FREEDOM_ADMIN_IMAGES_URL . '/left-sidebar.png',
         'no_sidebar_full_width' => FREEDOM_ADMIN_IMAGES_URL . '/no-sidebar-full-width-layout.png',
         'no_sidebar_content_centered' => FREEDOM_ADMIN_IMAGES_URL . '/no-sidebar-content-centered-layout.png'
      )
   )));

   // default layout for single posts
   $wp_customize->add_section('freedom_default_single_posts_layout_setting', array(
      'priority' => 4,
      'title' => __('Default layout for single posts only', 'freedom'),
      'panel'=> 'freedom_design_options'
   ));

   $wp_customize->add_setting('freedom_single_posts_default_layout', array(
      'default' => 'right_sidebar',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'freedom_radio_select_sanitize'
   ));

   $wp_customize->add_control(new Freedom_Image_Radio_Control($wp_customize, 'freedom_single_posts_default_layout', array(
      'type' => 'radio',
      'label' => __('Select default layout for single posts. This layout will be reflected in all single posts unless unique layout is set for specific post.', 'freedom'),
      'section' => 'freedom_default_single_posts_layout_setting',
      'settings' => 'freedom_single_posts_default_layout',
      'choices' => array(
         'right_sidebar' => FREEDOM_ADMIN_IMAGES_URL . '/right-sidebar.png',
         'left_sidebar' => FREEDOM_ADMIN_IMAGES_URL . '/left-sidebar.png',
         'no_sidebar_full_width' => FREEDOM_ADMIN_IMAGES_URL . '/no-sidebar-full-width-layout.png',
         'no_sidebar_content_centered' => FREEDOM_ADMIN_IMAGES_URL . '/no-sidebar-content-centered-layout.png'
      )
   )));

   // Posts page listing display type setting
   $wp_customize->add_section('freedom_post_page_display_type_setting', array(
      'priority' => 5,
      'title' => __('Posts page listing display type', 'freedom'),
      'panel' => 'freedom_design_options'
   ));

   $wp_customize->add_setting('freedom_posts_page_display_type', array(
      'default' => 'photo_blogging_two_column',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'freedom_radio_select_sanitize'
   ));

   $wp_customize->add_control('freedom_posts_page_display_type', array(
      'type' => 'radio',
      'label' => __('Choose the display type for the latest posts view or posts page view (static front page).', 'freedom'),
      'choices' => array(
         'photo_blogging_two_column' => __('Photo blogging view (two column)', 'freedom'),
         'normal_view' => __('Normal view', 'freedom')
      ),
      'section' => 'freedom_post_page_display_type_setting'
   ));

   // Archive/Category posts listing display type setting
   $wp_customize->add_section('freedom_archive_category_listing_display_type_setting', array(
      'priority' => 6,
      'title' => __('Archive/Category posts listing display type', 'freedom'),
      'panel' => 'freedom_design_options'
   ));

   $wp_customize->add_setting('freedom_archive_display_type', array(
      'default' => 'photo_blogging_two_column',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'freedom_radio_select_sanitize'
   ));

   $wp_customize->add_control('freedom_archive_display_type', array(
      'type' => 'radio',
      'label' => __('Choose the display type for the archive/category view.', 'freedom'),
      'choices' => array(
         'photo_blogging_two_column' => __('Photo blogging view (two column)', 'freedom'),
         'normal_view' => __('Normal view', 'freedom')
      ),
      'section' => 'freedom_archive_category_listing_display_type_setting'
   ));

   // Site primary color option
   $wp_customize->add_section('freedom_primary_color_setting', array(
      'panel' => 'freedom_design_options',
      'priority' => 7,
      'title' => __('Primary color option', 'freedom')
   ));

   $wp_customize->add_setting('freedom_primary_color', array(
      'default' => '#46c9be',
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'freedom_color_option_hex_sanitize',
      'sanitize_js_callback' => 'freedom_color_escaping_option_sanitize'
   ));

   $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'freedom_primary_color', array(
      'label' => __('This will reflect in links, buttons and many others. Choose a color to match your site.', 'freedom'),
      'section' => 'freedom_primary_color_setting',
      'settings' => 'freedom_primary_color'
   )));

	if ( ! function_exists( 'wp_update_custom_css_post' ) ) {
		// Custom CSS setting
		class Freedom_Custom_CSS_Control extends WP_Customize_Control {

			public $type = 'custom_css';

			public function render_content() {
			?>
				<label>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
				</label>
			<?php
			}

		}

		$wp_customize->add_section('freedom_custom_css_setting', array(
			'priority' => 9,
			'title' => __('Custom CSS', 'freedom'),
			'panel' => 'freedom_design_options'
		));

		$wp_customize->add_setting('freedom_custom_css', array(
			'default' => '',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'wp_filter_nohtml_kses',
			'sanitize_js_callback' => 'wp_filter_nohtml_kses'
		));

		$wp_customize->add_control(new Freedom_Custom_CSS_Control($wp_customize, 'freedom_custom_css', array(
			'label' => __('Write your custom css.', 'freedom'),
			'section' => 'freedom_custom_css_setting',
			'settings' => 'freedom_custom_css'
		)));

	}
	// End of Design Options

   // Adding Text Area Control For Use In Customizer
   class Freedom_Text_Area_Control extends WP_Customize_Control {

      public $type = 'text_area';

      public function render_content() {
      ?>
         <label>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <textarea rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
         </label>
      <?php
      }

   }

   // Start of the Slider Options
   $wp_customize->add_panel('freedom_slider_options', array(
      'capabitity' => 'edit_theme_options',
      'priority' => 515,
      'title' => __('Slider', 'freedom')
   ));

   // slider activate option
   $wp_customize->add_section('freedom_slider_activate_section', array(
      'priority' => 1,
      'title' => __('Activate slider', 'freedom'),
      'panel' => 'freedom_slider_options'
   ));

   $wp_customize->add_setting('freedom_activate_slider', array(
      'default' => 0,
      'capability' => 'edit_theme_options',
      'sanitize_callback' => 'freedom_checkbox_sanitize'
   ));

   $wp_customize->add_control('freedom_activate_slider', array(
      'type' => 'checkbox',
      'label' => __('Check to activate slider.', 'freedom'),
      'section' => 'freedom_slider_activate_section',
      'settings' => 'freedom_activate_slider'
   ));

   for ( $i = 1; $i <= 4; $i++ ) {
      // adding slider section
      $wp_customize->add_section('freedom_slider_number_section'.$i, array(
         'priority' => 10,
         'title' => sprintf( __( 'Slider #%1$s', 'freedom' ), $i ),
         'panel' => 'freedom_slider_options'
      ));

      // adding slider image url
      $wp_customize->add_setting('freedom_slider_image'.$i, array(
         'default' => '',
         'capability' => 'edit_theme_options',
         'sanitize_callback' => 'esc_url_raw'
      ));

      $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'freedom_slider_image'.$i, array(
         'label' => __('Upload Image', 'freedom'),
         'section' => 'freedom_slider_number_section'.$i,
         'setting' => 'freedom_slider_image'.$i
      )));

      // adding slider title
      $wp_customize->add_setting('freedom_slider_title'.$i, array(
         'default' => '',
         'capability' => 'edit_theme_options',
         'sanitize_callback' => 'wp_filter_nohtml_kses'
      ));

      $wp_customize->add_control('freedom_slider_title'.$i, array(
         'label' => __('Enter title for this slide','freedom'),
         'section' => 'freedom_slider_number_section'.$i,
         'setting' => 'freedom_slider_title'.$i
      ));

      // adding slider description
      $wp_customize->add_setting('freedom_slider_text'.$i, array(
         'default' => '',
         'capability' => 'edit_theme_options',
         'sanitize_callback' => 'freedom_text_sanitize'
      ));

      $wp_customize->add_control(new Freedom_Text_Area_Control($wp_customize, 'freedom_slider_text'.$i, array(
         'label' => __('Enter description for this slide','freedom'),
         'section' => 'freedom_slider_number_section'.$i,
         'setting' => 'freedom_slider_text'.$i
      )));

      // adding button text
      $wp_customize->add_setting('freedom_slider_button_text'.$i, array(
         'default' => '',
         'capability' => 'edit_theme_options',
         'sanitize_callback' => 'wp_filter_nohtml_kses'
      ));

      $wp_customize->add_control('freedom_slider_button_text'.$i, array(
         'label' => __('Enter the button text.','freedom'),
         'section' => 'freedom_slider_number_section'.$i,
         'setting' => 'freedom_slider_button_text'.$i
      ));

      // adding button url
      $wp_customize->add_setting('freedom_slider_link'.$i, array(
         'default' => '',
         'capability' => 'edit_theme_options',
         'sanitize_callback' => 'esc_url_raw'
      ));

      $wp_customize->add_control('freedom_slider_link'.$i, array(
         'label' => __('Enter link to redirect for the slide','freedom'),
         'section' => 'freedom_slider_number_section'.$i,
         'setting' => 'freedom_slider_link'.$i
      ));
   }
   // End of Slider Options

   // Start of data sanitization
   function freedom_radio_select_sanitize( $input, $setting ) {
      // Ensuring that the input is a slug.
      $input = sanitize_key( $input );
      // Get the list of choices from the control associated with the setting.
      $choices = $setting->manager->get_control( $setting->id )->choices;
      // If the input is a valid key, return it, else, return the default.
      return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
   }

   // color sanitization
   function freedom_color_option_hex_sanitize($color) {
      if ($unhashed = sanitize_hex_color_no_hash($color))
         return '#' . $unhashed;

      return $color;
   }

   function freedom_color_escaping_option_sanitize($input) {
      $input = esc_attr($input);
      return $input;
   }

   // text-area sanitize
   function freedom_text_sanitize($input) {
      return wp_kses_post( force_balance_tags( $input ) );
   }

   // checkbox sanitize
   function freedom_checkbox_sanitize($input) {
      if ( $input == 1 ) {
         return 1;
      } else {
         return '';
      }
   }

   // sanitization of links
   function freedom_links_sanitize() {
      return false;
   }

}
add_action('customize_register', 'freedom_customize_register');


/*****************************************************************************************/

/**
 * Enqueue scripts for customizer
 */
function freedom_customizer_js() {
   wp_enqueue_script( 'freedom_customizer_script', get_template_directory_uri() . '/js/freedom_customizer.js', array("jquery"), 'false', true  );

   wp_localize_script( 'freedom_customizer_script', 'freedom_customizer_obj', array(

      'pro' => __('View PRO version','freedom')

   ) );
}
add_action( 'customize_controls_enqueue_scripts', 'freedom_customizer_js' );

/*
 * Custom Scripts
 */
add_action( 'customize_controls_print_footer_scripts', 'freedom_customizer_custom_scripts' );

function freedom_customizer_custom_scripts() { ?>
<style>
	/* Theme Instructions Panel CSS */
	li#accordion-section-freedom_important_links h3.accordion-section-title, li#accordion-section-freedom_important_links h3.accordion-section-title:focus { background-color: #46C9BE !important; color: #fff !important; }
	li#accordion-section-freedom_important_links h3.accordion-section-title:hover { background-color: #46C9BE !important; color: #fff !important; }
	li#accordion-section-freedom_important_links h3.accordion-section-title:after { color: #fff !important; }
	/* Upsell button CSS */
	.themegrill-pro-info,
	.customize-control-freedom-important-links a {
		/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#8fc800+0,8fc800+100;Green+Flat+%232 */
		background: #008EC2;
		color: #fff;
		display: block;
		margin: 15px 0 0;
		padding: 5px 0;
		text-align: center;
		font-weight: 600;
	}

	.customize-control-freedom-important-links a{
		padding: 8px 0;
	}

	.themegrill-pro-info:hover,
	.customize-control-freedom-important-links a:hover {
		color: #ffffff;
		/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#006e2e+0,006e2e+100;Green+Flat+%233 */
		background:#2380BA;
	}
</style>
<?php
}
?>
