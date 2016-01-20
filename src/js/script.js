var resizeHeader = function($) {
	var front_page = false;
	if ($('.front-page').length){
		front_page = true;
	}

	var $card = $('.title-card'),
			$window = $(window),
			window_width = $window.width(),
			window_height = ($('body').hasClass('admin-bar')) ? $window.height() - 32 : $window.height();

	if (front_page){
		$card.css('height', $window.height());
		$('#more-site').data('scroll-to', window_height);
	} else {
		console.log(false);
		$card.css('height', 300);
	}

	$card.fillsize('> img.header-image');
};

var resize = function($) {
	$(window).on('resize.title-card', function() {
		resizeHeader($);
	});
};

var smoothScroll = function($) {
	$('a[href*=#]:not(a[href=#])').click(function() {
		if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
			if (target.length) {
				$('html, body').animate({
					scrollTop: target.offset().top
				}, 500);
				return false;
			}
		}
	});
};

if (typeof jQuery !== 'undefined') {
	jQuery(document).ready(function($) {
		resizeHeader($);
		resize($);
		smoothScroll($);
	});
}
