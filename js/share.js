$(function() {
	$('p.share span').hide();
	$('p.share').hover(function() {
		$('p.share span').fadeToggle();
	});
	$('p.share span a').click(function() {
		var width = $(this).data('width') || 640;
		var height = $(this).data('height') || 480;
		window.open($(this).attr('href'), 'Share Dialog', 'width=' + width + ',height=' + height);
		return false;
	});
});
