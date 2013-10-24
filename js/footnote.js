// Original by Lukas Mathis <http://ignorethecode.net/blog/2010/04/20/footnotes/>

var Footnotes = {
	footnotetimeout: false,
	setup: function() {
		var footnotelinks = $("a.footnote-ref");

		footnotelinks.unbind('mouseover',Footnotes.footnoteover);
		footnotelinks.unbind('mouseout',Footnotes.footnoteoout);

		footnotelinks.bind('mouseover',Footnotes.footnoteover);
		footnotelinks.bind('mouseout',Footnotes.footnoteoout);
	},
	footnoteover: function() {
		clearTimeout(Footnotes.footnotetimeout);
		$('#footnotediv').stop();
		$('#footnotediv').remove();

		var id = $(this).attr('href').substr(1);
		var position = $(this).offset();

		var div = $(document.createElement('div'));
		div.attr('id','footnotediv');
		div.bind('mouseover',Footnotes.divover);
		div.bind('mouseout',Footnotes.footnoteoout);

		var el = document.getElementById(id);
		var fntext = $(el).html();
		var width = Math.floor((fntext.length - 180) / 36 + 18);
		if (width < 18) { width = 18; }
		if (width > 24) { width = 24; }
		div.html(fntext);

		div.css({
			position: 'absolute',
			width: width + 'em',
			opacity: 0.95
		});
		$(document.body).append(div);

		var left = position.left;
		if(left + width*24  > $(window).width() + $(window).scrollLeft()) {
			left = $(window).width() - width*24 + $(window).scrollLeft();
		}
		var top = position.top+20;
		if(top + div.height() > $(window).height() + $(window).scrollTop()) {
			top = position.top - div.height() - 15;
		}
		div.css({
			left:left,
			top:top
		});
	},
	footnoteoout: function() {
		Footnotes.footnotetimeout = setTimeout(function() {
			$('#footnotediv').animate({
				opacity: 0
			}, 600, function() {
				$('#footnotediv').remove();
			});
		},100);
	},
	divover: function() {
		clearTimeout(Footnotes.footnotetimeout);
		$('#footnotediv').stop();
		$('#footnotediv').css({
				opacity: 0.95
		});
	}
};

function supportsTouch() {
	return (('ontouchstart' in window) || window.DocumentTouch && document instanceof DocumentTouch);
}

$(document).ready(function() {
	if (! supportsTouch()) {
		Footnotes.setup();
	}
});
