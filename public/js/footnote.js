/*  Originally by Lukas Mathis
	http://ignorethecode.net/blog/2010/04/20/footnotes/
*/var Footnotes={footnotetimeout:!1,setup:function(){var e=$("a.footnote-ref");e.unbind("mouseover",Footnotes.footnoteover);e.unbind("mouseout",Footnotes.footnoteoout);e.bind("mouseover",Footnotes.footnoteover);e.bind("mouseout",Footnotes.footnoteoout)},footnoteover:function(){clearTimeout(Footnotes.footnotetimeout);$("#footnotediv").stop();$("#footnotediv").remove();var e=$(this).attr("href").substr(1),t=$(this).offset(),n=$(document.createElement("div"));n.attr("id","footnotediv");n.bind("mouseover",Footnotes.divover);n.bind("mouseout",Footnotes.footnoteoout);var r=document.getElementById(e);n.html($(r).html());n.css({position:"absolute",width:"18em",opacity:.95});$(document.body).append(n);var i=t.left;i+420>$(window).width()+$(window).scrollLeft()&&(i=$(window).width()-420+$(window).scrollLeft());var s=t.top+20;s+n.height()>$(window).height()+$(window).scrollTop()&&(s=t.top-n.height()-15);n.css({left:i,top:s})},footnoteoout:function(){Footnotes.footnotetimeout=setTimeout(function(){$("#footnotediv").animate({opacity:0},600,function(){$("#footnotediv").remove()})},100)},divover:function(){clearTimeout(Footnotes.footnotetimeout);$("#footnotediv").stop();$("#footnotediv").css({opacity:.95})}};$(document).ready(function(){Footnotes.setup()});