$ = new jQuery.noConflict();
$(document).ready(function(){
	// scroll to top
	$(window).scroll(function () {
		if ($(this).scrollTop() > show_after_px) {
			$('.scroll-to-top').fadeIn();
		} else {
			$('.scroll-to-top').fadeOut();
		}
	});
	$('.scroll-to-top').click(function () {
		$("html, body").animate({
			scrollTop: 0
		}, time_to_scroll );
		return false;
	});
});