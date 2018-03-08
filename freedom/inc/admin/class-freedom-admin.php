<?php
/**
 * Freedom Admin Class.
 *
 * @author  ThemeGrill
 * @package freedom
 * @since   1.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Freedom_Admin' ) ) :

/**
 * Freedom_Admin Class.
 */
class Freedom_Admin {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'wp_loaded', array( __CLASS__, 'hide_notices' ) );
		add_action( 'load-themes.php', array( $this, 'admin_notice' ) );
	}

	/**
	 * Add admin menu.
	 */
	public function admin_menu() {
		$theme = wp_get_theme( get_template() );

		$page = add_theme_page( esc_html__( 'About', 'freedom' ) . ' ' . $theme->display( 'Name' ), esc_html__( 'About', 'freedom' ) . ' ' . $theme->display( 'Name' ), 'activate_plugins', 'freedom-welcome', array( $this, 'welcome_screen' ) );
		add_action( 'admin_print_styles-' . $page, array( $this, 'enqueue_styles' ) );
	}

	/**
	 * Enqueue styles.
	 */
	public function enqueue_styles() {
		global $freedom_version;

		wp_enqueue_style( 'freedom-welcome', get_template_directory_uri() . '/css/admin/welcome.css', array(), $freedom_version );
	}

	/**
	 * Add admin notice.
	 */
	public function admin_notice() {
		global $freedom_version, $pagenow;

		wp_enqueue_style( 'freedom-message', get_template_directory_uri() . '/css/admin/message.css', array(), $freedom_version );

		// Let's bail on theme activation.
		if ( 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {
			add_action( 'admin_notices', array( $this, 'welcome_notice' ) );
			update_option( 'freedom_admin_notice_welcome', 1 );

		// No option? Let run the notice wizard again..
		} elseif( ! get_option( 'freedom_admin_notice_welcome' ) ) {
			add_action( 'admin_notices', array( $this, 'welcome_notice' ) );
		}
	}

	/**
	 * Hide a notice if the GET variable is set.
	 */
	public static function hide_notices() {
		if ( isset( $_GET['freedom-hide-notice'] ) && isset( $_GET['_freedom_notice_nonce'] ) ) {
			if ( ! wp_verify_nonce( $_GET['_freedom_notice_nonce'], 'freedom_hide_notices_nonce' ) ) {
				wp_die( __( 'Action failed. Please refresh the page and retry.', 'freedom' ) );
			}

			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( __( 'Cheatin&#8217; huh?', 'freedom' ) );
			}

			$hide_notice = sanitize_text_field( $_GET['freedom-hide-notice'] );
			update_option( 'freedom_admin_notice_' . $hide_notice, 1 );
		}
	}

	/**
	 * Show welcome notice.
	 */
	public function welcome_notice() {
		?>
		<div id="message" class="updated freedom-message">
			<a class="freedom-message-close notice-dismiss" href="<?php echo esc_url( wp_nonce_url( remove_query_arg( array( 'activated' ), add_query_arg( 'freedom-hide-notice', 'welcome' ) ), 'freedom_hide_notices_nonce', '_freedom_notice_nonce' ) ); ?>"><?php _e( 'Dismiss', 'freedom' ); ?></a>
			<p><?php printf( esc_html__( 'Welcome! Thank you for choosing Freedom! To fully take advantage of the best our theme can offer please make sure you visit our %swelcome page%s.', 'freedom' ), '<a href="' . esc_url( admin_url( 'themes.php?page=freedom-welcome' ) ) . '">', '</a>' ); ?></p>
			<p class="submit">
				<a class="button-secondary" href="<?php echo esc_url( admin_url( 'themes.php?page=freedom-welcome' ) ); ?>"><?php esc_html_e( 'Get started with Freedom', 'freedom' ); ?></a>
			</p>
		</div>
		<?php
	}

	/**
	 * Intro text/links shown to all about pages.
	 *
	 * @access private
	 */
	private function intro() {
		global $freedom_version;

		$theme = wp_get_theme( get_template() );

		// Drop minor version if 0
		$major_version = substr( $freedom_version, 0, 3 );
		?>
		<div class="freedom-theme-info">
			<h1>
				<?php esc_html_e('About', 'freedom'); ?>
				<?php echo $theme->display( 'Name' ); ?>
				<?php printf( '%s', $major_version ); ?>
			</h1>

			<div class="welcome-description-wrap">
				<div class="about-text"><?php echo $theme->display( 'Description' ); ?></div>

				<div class="freedom-screenshot">
					<img src="<?php echo esc_url( get_template_directory_uri() ) . '/screenshot.png'; ?>" />
				</div>
			</div>
		</div>

		<p class="freedom-actions">
			<a href="<?php echo esc_url( 'https://themegrill.com/themes/freedom/' ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Theme Info', 'freedom' ); ?></a>

			<a href="<?php echo esc_url( 'https://demo.themegrill.com/freedom/' ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'View Demo', 'freedom' ); ?></a>

			<a href="<?php echo esc_url( 'https://themegrill.com/themes/freedom-pro/' ); ?>" class="button button-primary docs" target="_blank"><?php esc_html_e( 'View PRO version', 'freedom' ); ?></a>

			<a href="<?php echo esc_url( 'https://wordpress.org/support/view/theme-reviews/freedom?filter=5#postform' ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'Rate this theme', 'freedom' ); ?></a>
		</p>

		<h2 class="nav-tab-wrapper">
			<a class="nav-tab <?php if ( empty( $_GET['tab'] ) && $_GET['page'] == 'freedom-welcome' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'freedom-welcome' ), 'themes.php' ) ) ); ?>">
				<?php echo $theme->display( 'Name' ); ?>
			</a>
			<a class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'supported_plugins' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'freedom-welcome', 'tab' => 'supported_plugins' ), 'themes.php' ) ) ); ?>">
				<?php esc_html_e( 'Supported Plugins', 'freedom' ); ?>
			</a>
			<a class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'free_vs_pro' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'freedom-welcome', 'tab' => 'free_vs_pro' ), 'themes.php' ) ) ); ?>">
				<?php esc_html_e( 'Free Vs Pro', 'freedom' ); ?>
			</a>
			<a class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'changelog' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'freedom-welcome', 'tab' => 'changelog' ), 'themes.php' ) ) ); ?>">
				<?php esc_html_e( 'Changelog', 'freedom' ); ?>
			</a>
		</h2>
		<?php
	}

	/**
	 * Welcome screen page.
	 */
	public function welcome_screen() {
		$current_tab = empty( $_GET['tab'] ) ? 'about' : sanitize_title( $_GET['tab'] );

		// Look for a {$current_tab}_screen method.
		if ( is_callable( array( $this, $current_tab . '_screen' ) ) ) {
			return $this->{ $current_tab . '_screen' }();
		}

		// Fallback to about screen.
		return $this->about_screen();
	}

	/**
	 * Output the about screen.
	 */
	public function about_screen() {
		$theme = wp_get_theme( get_template() );
		?>
		<div class="wrap about-wrap">

			<?php $this->intro(); ?>

			<div class="changelog point-releases">
				<div class="under-the-hood two-col">
					<div class="col">
						<h3><?php esc_html_e( 'Theme Customizer', 'freedom' ); ?></h3>
						<p><?php esc_html_e( 'All Theme Options are available via Customize screen.', 'freedom' ) ?></p>
						<p><a href="<?php echo admin_url( 'customize.php' ); ?>" class="button button-secondary"><?php esc_html_e( 'Customize', 'freedom' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php esc_html_e( 'Documentation', 'freedom' ); ?></h3>
						<p><?php esc_html_e( 'Please view our documentation page to setup the theme.', 'freedom' ) ?></p>
						<p><a href="<?php echo esc_url( 'https://themegrill.com/theme-instruction/freedom/' ); ?>" class="button button-secondary"><?php esc_html_e( 'Documentation', 'freedom' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php esc_html_e( 'Got theme support question?', 'freedom' ); ?></h3>
						<p><?php esc_html_e( 'Please put it in our dedicated support forum.', 'freedom' ) ?></p>
						<p><a href="<?php echo esc_url( 'https://themegrill.com/support-forum/' ); ?>" class="button button-secondary"><?php esc_html_e( 'Support Forum', 'freedom' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php esc_html_e( 'Need more features?', 'freedom' ); ?></h3>
						<p><?php esc_html_e( 'Upgrade to PRO version for more exciting features.', 'freedom' ) ?></p>
						<p><a href="<?php echo esc_url( 'https://themegrill.com/themes/freedom-pro/' ); ?>" class="button button-secondary"><?php esc_html_e( 'View Pro', 'freedom' ); ?></a></p>
					</div>

					<div class="col">
						<h3><?php esc_html_e( 'Got sales related question?', 'freedom' ); ?></h3>
						<p><?php esc_html_e( 'Please send it via our sales contact page.', 'freedom' ) ?></p>
						<p><a href="<?php echo esc_url( 'https://themegrill.com/contact/' ); ?>" class="button button-secondary"><?php esc_html_e( 'Contact Page', 'freedom' ); ?></a></p>
					</div>

					<div class="col">
						<h3>
							<?php
							esc_html_e( 'Translate', 'freedom' );
							echo ' ' . $theme->display( 'Name' );
							?>
						</h3>
						<p><?php esc_html_e( 'Click below to translate this theme into your own language.', 'freedom' ) ?></p>
						<p>
							<a href="<?php echo esc_url( 'http://translate.wordpress.org/projects/wp-themes/freedom' ); ?>" class="button button-secondary">
								<?php
								esc_html_e( 'Translate', 'freedom' );
								echo ' ' . $theme->display( 'Name' );
								?>
							</a>
						</p>
					</div>
				</div>
			</div>

			<div class="return-to-dashboard freedom">
				<?php if ( current_user_can( 'update_core' ) && isset( $_GET['updated'] ) ) : ?>
					<a href="<?php echo esc_url( self_admin_url( 'update-core.php' ) ); ?>">
						<?php is_multisite() ? esc_html_e( 'Return to Updates', 'freedom' ) : esc_html_e( 'Return to Dashboard &rarr; Updates', 'freedom' ); ?>
					</a> |
				<?php endif; ?>
				<a href="<?php echo esc_url( self_admin_url() ); ?>"><?php is_blog_admin() ? esc_html_e( 'Go to Dashboard &rarr; Home', 'freedom' ) : esc_html_e( 'Go to Dashboard', 'freedom' ); ?></a>
			</div>
		</div>
		<?php
	}

	/**
	 * Output the changelog screen.
	 */
	public function changelog_screen() {
		global $wp_filesystem;

		?>
		<div class="wrap about-wrap">

			<?php $this->intro(); ?>

			<p class="about-description"><?php esc_html_e( 'View changelog below:', 'freedom' ); ?></p>

			<?php
				$changelog_file = apply_filters( 'freedom_changelog_file', get_template_directory() . '/readme.txt' );

				// Check if the changelog file exists and is readable.
				if ( $changelog_file && is_readable( $changelog_file ) ) {
					WP_Filesystem();
					$changelog = $wp_filesystem->get_contents( $changelog_file );
					$changelog_list = $this->parse_changelog( $changelog );

					echo wp_kses_post( $changelog_list );
				}
			?>
		</div>
		<?php
	}

	/**
	 * Parse changelog from readme file.
	 * @param  string $content
	 * @return string
	 */
	private function parse_changelog( $content ) {
		$matches   = null;
		$regexp    = '~==\s*Changelog\s*==(.*)($)~Uis';
		$changelog = '';

		if ( preg_match( $regexp, $content, $matches ) ) {
			$changes = explode( '\r\n', trim( $matches[1] ) );

			$changelog .= '<pre class="changelog">';

			foreach ( $changes as $index => $line ) {
				$changelog .= wp_kses_post( preg_replace( '~(=\s*Version\s*(\d+(?:\.\d+)+)\s*=|$)~Uis', '<span class="title">${1}</span>', $line ) );
			}

			$changelog .= '</pre>';
		}

		return wp_kses_post( $changelog );
	}

	/**
	 * Output the supported plugins screen.
	 */
	public function supported_plugins_screen() {
		?>
		<div class="wrap about-wrap">

			<?php $this->intro(); ?>

			<p class="about-description"><?php esc_html_e( 'This theme recommends following plugins:', 'freedom' ); ?></p>
			<ol>
				<li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/social-icons/' ); ?>" target="_blank"><?php esc_html_e( 'Social Icons', 'freedom' ); ?></a>
					<?php esc_html_e(' by ThemeGrill', 'freedom'); ?>
				</li>
				<li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/easy-social-sharing/' ); ?>" target="_blank"><?php esc_html_e( 'Easy Social Sharing', 'freedom' ); ?></a>
					<?php esc_html_e(' by ThemeGrill', 'freedom'); ?>
				</li>
				<li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/contact-form-7/' ); ?>" target="_blank"><?php esc_html_e( 'Contact Form 7', 'freedom' ); ?></a></li>
				<li><a href="<?php echo esc_url( 'https://wordpress.org/plugins/wp-pagenavi/' ); ?>" target="_blank"><?php esc_html_e( 'WP-PageNavi', 'freedom' ); ?></a></li>
								
			</ol>

		</div>
		<?php
	}

	/**
	 * Output the free vs pro screen.
	 */
	public function free_vs_pro_screen() {
		?>
		<div class="wrap about-wrap">

			<?php $this->intro(); ?>

			<p class="about-description"><?php esc_html_e( 'Upgrade to PRO version for more exciting features.', 'freedom' ); ?></p>

			<table>
                <thead>
                    <tr>
                        <th class="table-feature-title"><h3><?php esc_html_e('Features', 'freedom'); ?></h3></th>
                        <th><h3><?php esc_html_e('Freedom', 'freedom'); ?></h3></th>
                        <th><h3><?php esc_html_e('Freedom Pro', 'freedom'); ?></h3></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><h3><?php esc_html_e('Slider', 'freedom'); ?></h3></td>
                        <td><?php esc_html_e('4', 'freedom'); ?></td>
                        <td><?php esc_html_e('Unlimited Slides', 'freedom'); ?></td>
                    </tr>
                    <tr>
                        <td><h3><?php esc_html_e('Google Fonts Option', 'freedom'); ?></h3></td>
                        <td><span class="dashicons dashicons-no"></span></td>
                        <td><?php esc_html_e('600+', 'freedom'); ?></td>
                    </tr>
                    <tr>
                        <td><h3><?php esc_html_e('Font Size options', 'freedom'); ?></h3></td>
                        <td><span class="dashicons dashicons-no"></span></td>
                        <td><span class="dashicons dashicons-yes"></span></td>
                    </tr>
                    <tr>
                        <td><h3><?php esc_html_e('Primary Color', 'freedom'); ?></h3></td>
                        <td><span class="dashicons dashicons-yes"></span></td>
                        <td><span class="dashicons dashicons-yes"></span></td>
                    </tr>
                    <tr>
                        <td><h3><?php esc_html_e('Multiple Color Options', 'freedom'); ?></h3></td>
                        <td><span class="dashicons dashicons-no"></span></td>
                        <td><?php esc_html_e('35+ color options', 'freedom'); ?></td>
                    </tr>
                    <tr>
                        <td><h3><?php esc_html_e('Social Icons', 'freedom'); ?></h3></td>
                        <td><span class="dashicons dashicons-no"></span></td>
                        <td><span class="dashicons dashicons-yes"></span></td>
                    </tr>
                    <tr>
                        <td><h3><?php esc_html_e('Boxed & Wide layout option', 'freedom'); ?></h3></td>
                        <td><span class="dashicons dashicons-yes"></span></td>
                        <td><span class="dashicons dashicons-yes"></span></td>
                    </tr>
                    <tr>
                        <td><h3><?php esc_html_e('Translation Ready', 'freedom'); ?></h3></td>
                        <td><span class="dashicons dashicons-yes"></span></td>
                        <td><span class="dashicons dashicons-yes"></span></td>
                    </tr>
                    <tr>
                        <td><h3><?php esc_html_e('Content Demo', 'freedom'); ?></h3></td>
                        <td><span class="dashicons dashicons-no"></span></td>
                        <td><span class="dashicons dashicons-yes"></span></td>
                    </tr>
                    <tr>
                        <td><h3><?php esc_html_e('Footer Widget Area', 'freedom'); ?></h3></td>
                        <td><span class="dashicons dashicons-yes"></span></td>
                        <td><span class="dashicons dashicons-yes"></span></td>
                    </tr>
                    <tr>
                        <td><h3><?php esc_html_e('Footer Copyright Editor', 'freedom'); ?></h3></td>
                        <td><span class="dashicons dashicons-no"></span></td>
                        <td><span class="dashicons dashicons-yes"></span></td>
                    </tr>
                    <tr>
                        <td><h3><?php esc_html_e('Support', 'freedom'); ?></h3></td>
                        <td><?php esc_html_e('Forum', 'freedom'); ?></td>
                        <td><?php esc_html_e('Forum + Emails/Support Ticket', 'freedom'); ?></td>
                    </tr>
                </tbody>
            </table>

		</div>
		<?php
	}
}

endif;

return new Freedom_Admin();
