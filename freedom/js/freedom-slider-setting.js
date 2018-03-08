/**
 * Slider Setting
 *
 * Contains all the slider settings for the featured image slider.
 */
 var slides = jQuery('.slider-rotate').children().length;
if(slides <= 1) {
   jQuery('.slider-nav').css('display', 'none');
} else {
   jQuery('.slider-nav').css('display', 'visible');
}
jQuery(window).load(function() {
jQuery('.slider-rotate').cycle({
	fx:					'scrollLeft',
	pager:				'#controllers',
	prev:				'.slide-prev',
	next:						'.slide-next',
	activePagerClass:	'active',
	timeout:			5000,
	speed:				1000,
	pause:				1,
	pauseOnPagerHover:	1,
	width:				'100%',
	containerResize:	0,
	fit:				1,
	after: 				function ()	{
							jQuery(this).parent().css('height', jQuery(this).height());
						},
	cleartypeNoBg: 		true

});

});
