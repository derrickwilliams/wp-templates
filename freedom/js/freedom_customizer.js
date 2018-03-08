/* global freedom_customizer_obj */
jQuery(document).ready(function() {
	/**
	 * Theme Customizer related js
	 */
	jQuery('#customize-info .preview-notice').append(
		'<a class="themegrill-pro-info" href="http://themegrill.com/themes/freedom-pro/" target="_blank">{pro}</a>'
		.replace('{pro}',freedom_customizer_obj.pro));

});
