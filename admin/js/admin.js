jQuery(document).ready(function ($) {
	var $raceSeriesMenu = $('.toplevel_page_series-races');

	// Show New Race page as Race Series menu child
	if ($raceSeriesMenu.length) {
		$raceSeriesMenu.removeClass('wp-not-current-submenu');
		$raceSeriesMenu.addClass('wp-has-current-submenu');
		$raceSeriesMenu.find('.wp-submenu li').eq(1).addClass('current');
	}

	// Instantiate datepickers
	$('.date').datepicker();
});
