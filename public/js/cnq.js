/*  Originally by Lukas Mathis
	http://ignorethecode.net/blog/2010/04/20/footnotes/
*/function supportsTouch(){return"ontouchstart"in window||window.DocumentTouch&&document instanceof DocumentTouch}var Footnotes={footnotetimeout:!1,setup:function(){var e=$("a.footnote-ref");e.unbind("mouseover",Footnotes.footnoteover);e.unbind("mouseout",Footnotes.footnoteoout);e.bind("mouseover",Footnotes.footnoteover);e.bind("mouseout",Footnotes.footnoteoout)},footnoteover:function(){clearTimeout(Footnotes.footnotetimeout);$("#footnotediv").stop();$("#footnotediv").remove();var e=$(this).attr("href").substr(1),t=$(this).offset(),n=$(document.createElement("div"));n.attr("id","footnotediv");n.bind("mouseover",Footnotes.divover);n.bind("mouseout",Footnotes.footnoteoout);var r=document.getElementById(e),i=$(r).html(),s=Math.floor((i.length-180)/36+18);s<18&&(s=18);s>24&&(s=24);n.html(i);n.css({position:"absolute",width:s+"em",opacity:.95});$(document.body).append(n);var o=t.left;o+s*24>$(window).width()+$(window).scrollLeft()&&(o=$(window).width()-s*24+$(window).scrollLeft());var u=t.top+20;u+n.height()>$(window).height()+$(window).scrollTop()&&(u=t.top-n.height()-15);n.css({left:o,top:u})},footnoteoout:function(){Footnotes.footnotetimeout=setTimeout(function(){$("#footnotediv").animate({opacity:0},600,function(){$("#footnotediv").remove()})},100)},divover:function(){clearTimeout(Footnotes.footnotetimeout);$("#footnotediv").stop();$("#footnotediv").css({opacity:.95})}};$(document).ready(function(){supportsTouch()||Footnotes.setup()});(function(){function n(){}function r(e,t){this.path=e;if(typeof t!="undefined"&&t!==null){this.at_2x_path=t;this.perform_check=!1}else{this.at_2x_path=e.replace(/\.\w+$/,function(e){return"@2x"+e});this.perform_check=!0}}function i(e){this.el=e;this.path=new r(this.el.getAttribute("src"),this.el.getAttribute("data-at2x"));var t=this;this.path.check_2x_variant(function(e){e&&t.swap()})}var e=typeof exports=="undefined"?window:exports,t={check_mime_type:!0};e.Retina=n;n.configure=function(e){e===null&&(e={});for(var n in e)e.hasOwnProperty(n)&&(t[n]=e[n])};n.init=function(t){t===null&&(t=e);var n=t.onload||new Function;t.onload=function(){var e=document.getElementsByTagName("img"),t=[],r,s;for(r=0;r<e.length;r++){s=e[r];t.push(new i(s))}n()}};n.isRetina=function(){var t="(-webkit-min-device-pixel-ratio: 1.5),                      (min--moz-device-pixel-ratio: 1.5),                      (-o-min-device-pixel-ratio: 3/2),                      (min-resolution: 1.5dppx)";return e.devicePixelRatio>1?!0:e.matchMedia&&e.matchMedia(t).matches?!0:!1};e.RetinaImagePath=r;r.confirmed_paths=[];r.prototype.is_external=function(){return!!this.path.match(/^https?\:/i)&&!this.path.match("//"+document.domain)};r.prototype.check_2x_variant=function(e){var n,i=this;if(this.is_external())return e(!1);if(!this.perform_check&&typeof this.at_2x_path!="undefined"&&this.at_2x_path!==null)return e(!0);if(this.at_2x_path in r.confirmed_paths)return e(!0);n=new XMLHttpRequest;n.open("HEAD",this.at_2x_path);n.onreadystatechange=function(){if(n.readyState!=4)return e(!1);if(n.status>=200&&n.status<=399){if(t.check_mime_type){var s=n.getResponseHeader("Content-Type");if(s===null||!s.match(/^image/i))return e(!1)}r.confirmed_paths.push(i.at_2x_path);return e(!0)}return e(!1)};n.send()};e.RetinaImage=i;i.prototype.swap=function(e){function n(){if(!t.el.complete)setTimeout(n,5);else{t.el.setAttribute("width",t.el.offsetWidth);t.el.setAttribute("height",t.el.offsetHeight);t.el.setAttribute("src",e)}}typeof e=="undefined"&&(e=this.path.at_2x_path);var t=this;n()};n.isRetina()&&n.init(e)})();$(function(){$("p.share span").hide();$("p.share").on("mouseenter mouseleave click",function(){$("p.share span").fadeToggle()});$("p.share span a").click(function(){var e=$(this).data("width")||640,t=$(this).data("height")||480;window.open($(this).attr("href"),"Share Dialog","width="+e+",height="+t);return!1})});var _gauges=_gauges||[];(function(){var e=document.createElement("script");e.type="text/javascript";e.async=!0;e.id="gauges-tracker";e.setAttribute("data-site-id","52656b0d108d7b73f100004d");e.src="//secure.gaug.es/track.js";var t=document.getElementsByTagName("script")[0];t.parentNode.insertBefore(e,t)})();