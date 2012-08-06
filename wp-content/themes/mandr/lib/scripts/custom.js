jQuery.noConflict();
jQuery(document).ready(function() {
	
	/* 
	 * Tab functions
	 */
	if(jQuery('ul.tabs').length > 0){
		jQuery('ul.tabs').tabs('> .tabs_content');
	}
	if(jQuery('ul.tabs_framed').length > 0){
		jQuery('ul.tabs_framed').tabs('> .tabs_framed_content');
	}
	if(jQuery('ul.tabs_button').length > 0){
		jQuery('ul.tabs_button').tabs('> .tabs_button_content');
	}
	if(jQuery('.tabs_vertical_frame').length > 0){
		jQuery('.tabs_vertical_frame').tabs('> .tabs_vertical_content');
		jQuery('.tabs_vertical_frame').data('tabs').onBeforeClick(function(e,index) {
			this.getTabs().parent().removeClass('current');
			this.getTabs().eq(index).parent().addClass('current');
		});
	}
	if(jQuery('ul.blog_tabs').length > 0){
		jQuery('ul.blog_tabs').tabs('> .blog_tabs_content');
		jQuery('ul.blog_tabs').data('tabs').onClick(function(index) {
			Cufon.refresh();
		});
	}
	
	/* 
	 * Hover fade
	 */
	jQuery('.hover_fade_js').live('hover', function(e) {
		if( e.type == 'mouseenter' )
			jQuery(this).stop().animate({opacity:0.7},400);

		if( e.type == 'mouseleave' )
			jQuery(this).stop().animate({opacity:1},400);
	});
	
	/* 
	 * toggle functions 
	 */
	jQuery('.toggle').toggle(function(){
		jQuery(this).addClass('active');
		}, function () {
		jQuery(this).removeClass('active');
	});

	jQuery('.toggle').click(function(){
		jQuery(this).next('.toggle_content').slideToggle();
	});
	
	jQuery('.toggle_frame_set').each(function(i) {
		var _this = jQuery(this),
		    toggle = _this.find('.toggle_accordion');
		
		toggle.click(function(){
			if( jQuery(this).next().is(':hidden') ) {
				_this.find('.toggle_accordion').removeClass('active').next().slideUp();
				jQuery(this).toggleClass('active').next().slideDown();
			}
			return false;
		});
	});
	
	/* 
	 * image reflect functions 
	 */
	jQuery('img.reflect').reflect({height:0.5,opacity:0.5});
	
	/*
	 * prettyPhoto 
	 */
	jQuery("a[rel^='prettyPhoto'], a[rel^='lightbox']").prettyPhoto({
		overlay_gallery: false, social_tools: '', 'theme': 'light_square' /* light_square / dark_rounded / light_square / dark_square / facebook */															
	});
	
	/* 
	 * spam protction on mailto: links
	 */
	jQuery('a.email_link_noreplace').nospam({
      replaceText: false,
      filterLevel: 'normal'
    });

	jQuery('a.email_link_replace').nospam({
      replaceText: true,
      filterLevel: 'normal'
    });

	/* 
	 * Contact form submit
	 */
	jQuery('.contact_form_submit').click(function() {
		clearInterval(preLoaderSmall);
		preLoaderCount = 0;
		mysitePreloaderSmall('.mysite_contact_feedback');
		jQuery(this).next().css('display','inline-block');
	});
	
	/* 
	 * "target_blank" links
	 */
	jQuery('.flickr_badge_image a').attr('target', '_blank');
	jQuery('.target_blank').attr('target', '_blank');
	
});


/*
 * Preload image function
 */
(function($) {
  var cache = [];
  // Arguments are image paths relative to the current page.
  $.preLoadImages = function() {
    var args_len = arguments.length;
    for (var i = args_len; i--;) {
      var cacheImage = document.createElement('img');
      cacheImage.src = arguments[i];
      cache.push(cacheImage);
    }
  }
})(jQuery)

// Preload loading images
jQuery.preLoadImages(
assetsUri+ '/transparent.gif',
assetsUri+ '/preloader.png'
);

/*
 * Preloader image
 */
var preLoader = null;
var preLoaderCount = 0;
function mysitePreloader(img_class) {
    var i,
	positions;
	i=0;
		
	positions=[-26,-52,-78,-104,-130,-156,-182,-208,-234,-260,-286,0];
	positionsClass = 'center';
	
	preLoader=setInterval(function(){
	jQuery(img_class +' img').css('background-position',positions[i]+'px ' +positionsClass);
	i++;
	preLoaderCount++;
	if(preLoaderCount===200){clearInterval(preLoader);preLoaderCount = 0;}
	if(i===12){i=0;}
	},70);
}

var preLoaderSmall = null;
var preLoaderSmallCount = 0;
function mysitePreloaderSmall(img_class) {
    var i,
	positions;
	i=0;
	
	positionsSmall=[-16,-32,-48,-64,-80,-96,-112,-128,-144,-160,-176,0];
	positionsClassSmall = 'bottom';
	
	preLoaderSmall=setInterval(function(){
	jQuery(img_class +' img').css('background-position',positionsSmall[i]+'px ' +positionsClassSmall);
	i++;
	preLoaderSmallCount++;
	if(preLoaderSmallCount===200){clearInterval(preLoaderSmall);preLoaderSmallCount = 0;}
	if(i===12){i=0;}
	},70);
}

var preLoaderLarge = null;
var preLoaderLargeCount = 0;
function mysitePreloaderLarge(img_class) {
    var i,
	positions;
	i=0;
	
	positionsLarge=[-35,-70,-105,-140,-175,-210,-245,-280,-315,-350,-385,0];
	positionsClassLarge = 'top';
	
	preLoaderLarge=setInterval(function(){
	jQuery(img_class +' img').css('background-position',positionsLarge[i]+'px ' +positionsClassLarge);
	i++;
	preLoaderLargeCount++;
	if(preLoaderLargeCount===200){clearInterval(preLoaderLarge);preLoaderLargeCount = 0;}
	if(i===12){i=0;}
	},70);
}

mysitePreloader('.mysite_preloader');
mysitePreloaderLarge('.mysite_preloader_large');

/*
 * YouTube api events
 */
function onYouTubePlayerAPIReady(id) {
  new YT.Player(id, {
    height: '',
    width: '',
    videoId: '',
    events: {
      'onStateChange': onPlayerStateChange
    }
  });
}

function onPlayerStateChange(event) {
	if( event.data == YT.PlayerState.PLAYING ) {
		if( jQuery('#mysite_scrolling_slider').length>0){
			jQuery('#mysite_scrolling_slider').data('scrollable').stop();
			jQuery('#slider_module_inner').mouseout(function() {
				jQuery('#mysite_scrolling_slider').data('scrollable').stop();
			});
		}
		if( jQuery('#fading_slides').length>0){
			jQuery('.slider_nav').data('slideshow').stop();
		}
	}
}

/*
 * Vimeo api events
 */
var VimeoEmbed = {};

VimeoEmbed.vimeo_player_loaded = function(player_id) {
	VimeoEmbed.setupAPIEventListeners(player_id);
};

VimeoEmbed.setupAPIEventListeners = function(target) {
	iframe_player = document.getElementById(target);
	iframe_player.addEvent( 'onPlay', VimeoEmbed.vimeo_on_play);
};

VimeoEmbed.vimeo_on_play = function(player_id) {
    if( jQuery('#mysite_scrolling_slider').length>0){
		jQuery('#mysite_scrolling_slider').data('scrollable').stop();
		jQuery('#slider_module_inner').mouseout(function() {
			jQuery('#mysite_scrolling_slider').data('scrollable').stop();
		});
	}
	if( jQuery('#fading_slides').length>0){
		jQuery('.slider_nav').data('slideshow').stop();
	}
};

/*
 * Contact ajaxForm
 */
(function($)
{
	$(function() {
		try {
			
			$('div.mysite_form > form').ajaxForm({
				
				data: { '_mysite_form_ajax_submit': 1 },
				dataType: 'json',
				success: function(data) {
					if($.browser.safari){ bodyelem = $('body') } else { bodyelem = $('html') }
					
					jQuery(data.into).find(':input').each(function() {
						jQuery(this).removeClass('required_error');
					});
					
					if(data.errors) {
						
						if(data.errored_fields){
							$('.mysite_message').remove();
							for(var i in data.errored_fields){
							    $('#' +data.errored_fields[i]).addClass('required_error');
							}
							bodyelem.animate({ scrollTop: $(data.into).offset().top-80
					  		}, 'slow', function(){
								jQuery('.mysite_contact_feedback').css('display','none');
							});
						}
						
						if(data.errored_fields == '' || !data.sidebar){
							if(data.errors) {
							  	bodyelem.animate({
							    	scrollTop: $(data.into).offset().top-80
							  		}, 'slow', function(){
										$('.mysite_message').remove();
										$(data.errors).css('display', 'none').prependTo(data.into).slideDown('slow');
										jQuery('.mysite_contact_feedback').css('display','none');
								});
							}
						}
					}
					 
					if( data.mail_sent ) {
						$('.mysite_message').remove();
						$(data.into + ' > form').remove(); 
						bodyelem.animate({
					    	scrollTop: $(data.into).offset().top-80
					  		}, 'slow', function(){
								$(data.success).css('display', 'none').prependTo(data.into).slideDown('slow');
								jQuery('.mysite_contact_feedback').css('display','none');
						});
					}
				}
				 
			});
			
		} catch (e) {
			//suppress error
		}
	});
	
})(jQuery);

/*
 * Mysitemyway image preloader
 */
(function($)
{
	$.fn.preloader = function(options) {
		var defaults = {
			selector: '',
			imgSelector: 'img',
			imgAppend: 'a',
			fade: true,
			delay: 500,
			fadein: 400,
			imageResize: imageResize,
			resizeDisabled: resizeDisabled,
			nonce: imageNonce,
			beforeShowAll: function(){},
			onDone: function(){},
			oneachload: function(image){}
			
		},
		options = $.extend({}, defaults, options);
		
		var ua = $.browser,
			uaVersion = ua.version.substring(0,1);
		
		if(options.imageResize == 'wordpress')
			options.delay = 0;
			
		return this.each(function() {
			
			options.beforeShowAll.call(this);
			
			var $this = $(this),
				 images = $this.find(options.imgSelector),
				 count = images.length;
				
			$this.load = {
				
				preload: function(count) {
					if(count>0) {
						$this.load.loadImage(0,count);
					} else {
						return;
					}
				},
				
				loadImage: function(i,count) {
					if(i<count) {
						var imgId = Math.floor(Math.random()*1000)+'_img_';
						$this.load.append(i,imgId);

						if(options.imageResize == 'timthumb' || options.resizeDisabled == 'true')
							$this.load.loader(i,$(images[i]).attr('src'),imgId);
							
						if( (options.imageResize == 'wordpress') && (options.resizeDisabled == false) )
								$this.load.resize(i,imgId);
						
					} else {
						options.onDone.call(this);
					}
				},
				
				append: function(i,imgId) {
						$('<span id="'+imgId+(i+1)+'"></span>').each(function() {
							if( options.imgAppend ) {
								$(this).appendTo($this.find(options.imgAppend).eq(i));
							} else {
								$(this).appendTo($(options.selector));
							}
						   	
						});
				},
				
				loader: function(i,image,imgId) {
					var newImage = new Image(),
						currImage = $('#'+imgId+(i+1)),
						title = ( $(images[i]).attr('title') ) ? $(images[i]).attr('title') : '';
						
		        $(newImage).load(function () {
					$(this).attr('width', $(images[i]).attr('width'));
					$(this).attr('height', $(images[i]).attr('height'));
					
						$(images[i]).parent().remove()
						if( options.fade ) {
							$(this).css('display','none');
							$(currImage).append(this);

							j = i+1;
							
							// Remove preloader
							$(this).parent().prev().delay(j*options.delay).queue(function() {
								$(this).remove();
							});
							
							// FadeIn image
							$(this).delay(j*options.delay).fadeIn(options.fadein).queue(function() {
								$(this).addClass($(images[i]).attr('class'));
								if( $(this).parent().parent().is('a')) {
									if(($(this).parent().parent().attr('rel'))){
										if($(this).parent().parent().attr('rel').match('prettyPhoto')){
											var filename = $(this).parent().parent().attr('href'),
												videos=['swf','youtube','vimeo','mov'];
											for(var v in videos){
											    if(filename.match(videos[v])){
													var video_icon = true;
												}else{
													var zoom_icon = true;
												}
											}
										}
									}
									
									//$(this).parent().prev().remove();
									
								} else {
									//$(this).parent().prev().remove();
								}
								
							if( video_icon ){
								$(this).parent().parent().css('backgroundImage','url(' +assetsUri+ '/play.png)');
								
							}else if(zoom_icon){
								$(this).parent().parent().css('backgroundImage','url(' +assetsUri+ '/zoom.png)');
							}
							
							options.oneachload.call(this, this);
						});
						if( (!ua.msie) || (uaVersion >= '9' && ua.msie) ){
							$this.load.loadImage(i+1,count);
						}
						
					} else {
						$(this).addClass($(images[i]).attr('class'));
						$(currImage).append(this);
						if( (!ua.msie) || (uaVersion >= '9' && ua.msie) ){
							$this.load.loadImage(i+1,count);
						}
						options.oneachload.call(this, this);
					}
						
		        }).error(function () {
					// try to load next item
					$this.load.loadImage(i+1,count);
		        })
				  .attr('src', image)
				  .attr('title', title)
				  .attr('alt', $(images[i]).attr('alt'));
				
			 	  if(uaVersion <= '8' && ua.msie){
					  $this.load.loadImage(i+1,count);
				  }
				
				},
				
				resize: function(i,imgId) {
					var imgResize = $('<input>', { type: 'text', name:'ajax_image_resize_url', val: $(images[i]).attr('src') })
						imgWidth = $('<input>', { type: 'text', name:'img_width', val: $(images[i]).attr('width') }),
						imgHeight = $('<input>', { type: 'text', name:'img_height', val: $(images[i]).attr('height') }),
						j5M5601 = $('<input>', { type: 'text', name:'j5M5601', val: options.nonce });
						
					postData = imgResize.add(imgWidth).add(imgHeight).add(j5M5601).serialize();
					
					$.ajax({
						type: 'POST',
						dataType: 'json',
						data: postData,
						beforeSend: function(x) {
					        if(x && x.overrideMimeType) {
					            x.overrideMimeType('application/json;charset=UTF-8');
					        }
					    },
						success: function(data) {
							$this.load.loader(i,data.url,imgId);
					    }
					});
				}
				
			};
			
			$this.load.preload(count);
		});
	}
})(jQuery);


/*********************
//* jQuery Multi Level CSS Menu #2- By Dynamic Drive: http://www.dynamicdrive.com/
//* Last update: Nov 7th, 08': Limit # of queued animations to minmize animation stuttering
//* Menu avaiable at DD CSS Library: http://www.dynamicdrive.com/style/
*********************/

//Update: April 12th, 10: Fixed compat issue with jquery 1.4x

//Specify full URL to down and right arrow images (23 is padding-right to add to top level LIs with drop downs):
var arrowimages={down:['', ''], right:['', '']}

var jqueryslidemenu={

animateduration: {over: 200, out: 25}, //duration of slide in/ out animation, in milliseconds

buildmenu:function(menuid, arrowsvar){
	jQuery(document).ready(function($){
		$(" #main_navigation a").removeAttr("title");

		var $mainmenu=$("."+menuid+">ul")
		var $headers=$mainmenu.find("ul").parent()
		$headers.each(function(i){
			var $curobj=$(this)
			var $subul=$(this).find('ul:eq(0)')
			this._dimensions={w:this.offsetWidth, h:this.offsetHeight, subulw:$subul.outerWidth(), subulh:$subul.outerHeight()}
			this.istopheader=$curobj.parents("ul").length==1? true : false
			$subul.css({top:this.istopheader? this._dimensions.h+"px" : 0})
			
			/*
			$curobj.children("a:eq(0)").css(this.istopheader? {paddingRight: arrowsvar.down[2]} : {}).append(
				'<img src="'+ (this.istopheader? arrowsvar.down[1] : arrowsvar.right[1])
				+'" class="' + (this.istopheader? arrowsvar.down[0] : arrowsvar.right[0])
				+ '" style="border:0;" />'
			)*/
			
			$curobj.hover(
				function(e){
					var $targetul=$(this).children("ul:eq(0)")
					this._offsets={left:$(this).offset().left, top:$(this).offset().top}
					
					if(jQuery.browser.msie){
						var menuleft=this.istopheader? 0 : this._dimensions.w +2
						menuleft=(this._offsets.left+menuleft+this._dimensions.subulw>$(window).width())? (this.istopheader? -this._dimensions.subulw+this._dimensions.w : -this._dimensions.w) -4 : menuleft
					}
					if(!jQuery.browser.msie){
						var menuleft=this.istopheader? 0 : this._dimensions.w
						menuleft=(this._offsets.left+menuleft+this._dimensions.subulw>$(window).width())? (this.istopheader? -this._dimensions.subulw+this._dimensions.w : -this._dimensions.w) : menuleft
					}
					if ($targetul.queue().length<=1){
						$targetul.css({left:menuleft+"px", width:this._dimensions.subulw+'px'}).slideDown(jqueryslidemenu.animateduration.over)
						
						if(jQuery.browser.msie){
							ieVersion = jQuery.browser.version.substring(0,1);
							if( ieVersion == 7 ){ var disableArrors = true; }
					    }
						if( !disableArrors ) {
							if(this.istopheader && jQuery(this).children().eq(0).find('span.menu_arrow').length<1) {
								$curobj.children("a:eq(0)").append(
										'<span class="menu_arrow"></span>'
								)
							}
						}
					} //if 1 or less queued animations
						
				},
				function(e){
					var $targetul=$(this).children("ul:eq(0)")
					$targetul.slideUp(jqueryslidemenu.animateduration.out)
				}
			) //end hover
			$curobj.click(function(){
				$(this).children("ul:eq(0)").hide()
			})
		}) //end $headers.each()
		$mainmenu.find("ul").css({display:'none', visibility:'visible'})
	}) //end document.ready
}
}
//build menu with ID="main_navigation" on page:
jqueryslidemenu.buildmenu("jqueryslidemenu", arrowimages);


/*
    reflection.js for jQuery v1.03
    (c) 2006-2009 Christophe Beyls <http://www.digitalia.be>
    MIT-style license.
*/
(function(a){a.fn.extend({reflect:function(b){b=a.extend({height:1/3,opacity:0.5},b);return this.unreflect().each(function(){var c=this;if(/^img$/i.test(c.tagName)){function d(){var g=c.width,f=c.height,l,i,m,h,k;i=Math.floor((b.height>1)?Math.min(f,b.height):f*b.height);if(a.browser.msie){l=a("<img />").attr("src",c.src).css({width:g,height:f,marginBottom:i-f,filter:"flipv progid:DXImageTransform.Microsoft.Alpha(opacity="+(b.opacity*100)+", style=1, finishOpacity=0, startx=0, starty=0, finishx=0, finishy="+(i/f*100)+")"})[0]}else{l=a("<canvas />")[0];if(!l.getContext){return}h=l.getContext("2d");try{a(l).attr({width:g,height:i});h.save();h.translate(0,f-1);h.scale(1,-1);h.drawImage(c,0,0,g,f);h.restore();h.globalCompositeOperation="destination-out";k=h.createLinearGradient(0,0,0,i);k.addColorStop(0,"rgba(255, 255, 255, "+(1-b.opacity)+")");k.addColorStop(1,"rgba(255, 255, 255, 1.0)");h.fillStyle=k;h.rect(0,0,g,i);h.fill()}catch(j){return}}a(l).css({display:"block",border:0});m=a(/^a$/i.test(c.parentNode.tagName)?"<span />":"<div />").insertAfter(c).append([c,l])[0];m.className=c.className;a.data(c,"reflected",m.style.cssText=c.style.cssText);a(m).css({width:g,height:f+i,overflow:"hidden"});c.style.cssText="display: block; border: 0px";c.className="reflected"}if(c.complete){d()}else{a(c).load(d)}}})},unreflect:function(){return this.unbind("load").each(function(){var c=this,b=a.data(this,"reflected"),d;if(b!==undefined){d=c.parentNode;c.className=d.className;c.style.cssText=b;a.removeData(c,"reflected");d.parentNode.replaceChild(c,d)}})}})})(jQuery);

/**
* hoverIntent r5 // 2007.03.27 // jQuery 1.1.2+
* <http://cherne.net/brian/resources/jquery.hoverIntent.html>
* 
* @param  f  onMouseOver function || An object with configuration options
* @param  g  onMouseOut function  || Nothing (use configuration options object)
* @author    Brian Cherne <brian@cherne.net>
*/
(function($){$.fn.hoverIntent=function(f,g){var cfg={sensitivity:7,interval:100,timeout:0};cfg=$.extend(cfg,g?{over:f,out:g}:f);var cX,cY,pX,pY;var track=function(ev){cX=ev.pageX;cY=ev.pageY;};var compare=function(ev,ob){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);if((Math.abs(pX-cX)+Math.abs(pY-cY))<cfg.sensitivity){$(ob).unbind("mousemove",track);ob.hoverIntent_s=1;return cfg.over.apply(ob,[ev]);}else{pX=cX;pY=cY;ob.hoverIntent_t=setTimeout(function(){compare(ev,ob);},cfg.interval);}};var delay=function(ev,ob){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);ob.hoverIntent_s=0;return cfg.out.apply(ob,[ev]);};var handleHover=function(e){var p=(e.type=="mouseover"?e.fromElement:e.toElement)||e.relatedTarget;while(p&&p!=this){try{p=p.parentNode;}catch(e){p=this;}}if(p==this){return false;}var ev=jQuery.extend({},e);var ob=this;if(ob.hoverIntent_t){ob.hoverIntent_t=clearTimeout(ob.hoverIntent_t);}if(e.type=="mouseover"){pX=ev.pageX;pY=ev.pageY;$(ob).bind("mousemove",track);if(ob.hoverIntent_s!=1){ob.hoverIntent_t=setTimeout(function(){compare(ev,ob);},cfg.interval);}}else{$(ob).unbind("mousemove",track);if(ob.hoverIntent_s==1){ob.hoverIntent_t=setTimeout(function(){delay(ev,ob);},cfg.timeout);}}};return this.mouseover(handleHover).mouseout(handleHover);};})(jQuery);

/*
 * jQuery Easing v1.3 - http://gsgd.co.uk/sandbox/jquery/easing/
 *
 * Uses the built in easing capabilities added In jQuery 1.1
 * to offer multiple easing options
 *
 * TERMS OF USE - jQuery Easing
 * 
 * Open source under the BSD License. 
 * 
 * Copyright © 2008 George McGinley Smith
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without modification, 
 * are permitted provided that the following conditions are met:
 * 
 * Redistributions of source code must retain the above copyright notice, this list of 
 * conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list 
 * of conditions and the following disclaimer in the documentation and/or other materials 
 * provided with the distribution.
 * 
 * Neither the name of the author nor the names of contributors may be used to endorse 
 * or promote products derived from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY 
 * EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 *  COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 *  EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 *  GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED 
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 *  NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED 
 * OF THE POSSIBILITY OF SUCH DAMAGE. 
 *
*/

jQuery.easing['jswing']=jQuery.easing['swing'];jQuery.extend(jQuery.easing,{def:'easeOutQuad',swing:function(x,t,b,c,d){return jQuery.easing[jQuery.easing.def](x,t,b,c,d);},easeInQuad:function(x,t,b,c,d){return c*(t/=d)*t+b;},easeOutQuad:function(x,t,b,c,d){return-c*(t/=d)*(t-2)+b;},easeInOutQuad:function(x,t,b,c,d){if((t/=d/2)<1)return c/2*t*t+b;return-c/2*((--t)*(t-2)-1)+b;},easeInCubic:function(x,t,b,c,d){return c*(t/=d)*t*t+b;},easeOutCubic:function(x,t,b,c,d){return c*((t=t/d-1)*t*t+1)+b;},easeInOutCubic:function(x,t,b,c,d){if((t/=d/2)<1)return c/2*t*t*t+b;return c/2*((t-=2)*t*t+2)+b;},easeInQuart:function(x,t,b,c,d){return c*(t/=d)*t*t*t+b;},easeOutQuart:function(x,t,b,c,d){return-c*((t=t/d-1)*t*t*t-1)+b;},easeInOutQuart:function(x,t,b,c,d){if((t/=d/2)<1)return c/2*t*t*t*t+b;return-c/2*((t-=2)*t*t*t-2)+b;},easeInQuint:function(x,t,b,c,d){return c*(t/=d)*t*t*t*t+b;},easeOutQuint:function(x,t,b,c,d){return c*((t=t/d-1)*t*t*t*t+1)+b;},easeInOutQuint:function(x,t,b,c,d){if((t/=d/2)<1)return c/2*t*t*t*t*t+b;return c/2*((t-=2)*t*t*t*t+2)+b;},easeInSine:function(x,t,b,c,d){return-c*Math.cos(t/d*(Math.PI/2))+c+b;},easeOutSine:function(x,t,b,c,d){return c*Math.sin(t/d*(Math.PI/2))+b;},easeInOutSine:function(x,t,b,c,d){return-c/2*(Math.cos(Math.PI*t/d)-1)+b;},easeInExpo:function(x,t,b,c,d){return(t==0)?b:c*Math.pow(2,10*(t/d-1))+b;},easeOutExpo:function(x,t,b,c,d){return(t==d)?b+c:c*(-Math.pow(2,-10*t/d)+1)+b;},easeInOutExpo:function(x,t,b,c,d){if(t==0)return b;if(t==d)return b+c;if((t/=d/2)<1)return c/2*Math.pow(2,10*(t-1))+b;return c/2*(-Math.pow(2,-10*--t)+2)+b;},easeInCirc:function(x,t,b,c,d){return-c*(Math.sqrt(1-(t/=d)*t)-1)+b;},easeOutCirc:function(x,t,b,c,d){return c*Math.sqrt(1-(t=t/d-1)*t)+b;},easeInOutCirc:function(x,t,b,c,d){if((t/=d/2)<1)return-c/2*(Math.sqrt(1-t*t)-1)+b;return c/2*(Math.sqrt(1-(t-=2)*t)+1)+b;},easeInElastic:function(x,t,b,c,d){var s=1.70158;var p=0;var a=c;if(t==0)return b;if((t/=d)==1)return b+c;if(!p)p=d*.3;if(a<Math.abs(c)){a=c;var s=p/4;}
else var s=p/(2*Math.PI)*Math.asin(c/a);return-(a*Math.pow(2,10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p))+b;},easeOutElastic:function(x,t,b,c,d){var s=1.70158;var p=0;var a=c;if(t==0)return b;if((t/=d)==1)return b+c;if(!p)p=d*.3;if(a<Math.abs(c)){a=c;var s=p/4;}
else var s=p/(2*Math.PI)*Math.asin(c/a);return a*Math.pow(2,-10*t)*Math.sin((t*d-s)*(2*Math.PI)/p)+c+b;},easeInOutElastic:function(x,t,b,c,d){var s=1.70158;var p=0;var a=c;if(t==0)return b;if((t/=d/2)==2)return b+c;if(!p)p=d*(.3*1.5);if(a<Math.abs(c)){a=c;var s=p/4;}
else var s=p/(2*Math.PI)*Math.asin(c/a);if(t<1)return-.5*(a*Math.pow(2,10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p))+b;return a*Math.pow(2,-10*(t-=1))*Math.sin((t*d-s)*(2*Math.PI)/p)*.5+c+b;},easeInBack:function(x,t,b,c,d,s){if(s==undefined)s=1.70158;return c*(t/=d)*t*((s+1)*t-s)+b;},easeOutBack:function(x,t,b,c,d,s){if(s==undefined)s=1.70158;return c*((t=t/d-1)*t*((s+1)*t+s)+1)+b;},easeInOutBack:function(x,t,b,c,d,s){if(s==undefined)s=1.70158;if((t/=d/2)<1)return c/2*(t*t*(((s*=(1.525))+1)*t-s))+b;return c/2*((t-=2)*t*(((s*=(1.525))+1)*t+s)+2)+b;},easeInBounce:function(x,t,b,c,d){return c-jQuery.easing.easeOutBounce(x,d-t,0,c,d)+b;},easeOutBounce:function(x,t,b,c,d){if((t/=d)<(1/2.75)){return c*(7.5625*t*t)+b;}else if(t<(2/2.75)){return c*(7.5625*(t-=(1.5/2.75))*t+.75)+b;}else if(t<(2.5/2.75)){return c*(7.5625*(t-=(2.25/2.75))*t+.9375)+b;}else{return c*(7.5625*(t-=(2.625/2.75))*t+.984375)+b;}},easeInOutBounce:function(x,t,b,c,d){if(t<d/2)return jQuery.easing.easeInBounce(x,t*2,0,c,d)*.5+b;return jQuery.easing.easeOutBounce(x,t*2-d,0,c,d)*.5+c*.5+b;}});

/* 
 * No Spam (1.3)
 * by Mike Branski (www.leftrightdesigns.com)
 * mikebranski@gmail.com
 *
 * Copyright (c) 2008 Mike Branski (www.leftrightdesigns.com)
 * Licensed under GPL (www.leftrightdesigns.com/library/jquery/nospam/gpl.txt)
 *
 * NOTE: This script requires jQuery to work.  Download jQuery at www.jquery.com
 *
 * Thanks to Bill on the jQuery mailing list for the double slash idea!
 *
 * CHANGELOG:
 * v 1.3   - Added support for e-mail addresses with multiple dots (.) both before and after the at (@) sign
 * v 1.2.1 - Included GPL license
 * v 1.2   - Finalized name as No Spam (was Protect Email)
 * v 1.1   - Changed switch() to if() statement
 * v 1.0   - Initial release
 *
 */

jQuery.fn.nospam = function(settings) {
	settings = jQuery.extend({
		replaceText: false, 	// optional, accepts true or false
		filterLevel: 'normal' 	// optional, accepts 'low' or 'normal'
	}, settings);
	
	return this.each(function(){
		e = null;
		if(settings.filterLevel == 'low') { // Can be a switch() if more levels added
			if(jQuery(this).is('a[rel]')) {
				e = jQuery(this).attr('rel').replace('//', '@').replace(/\//g, '.');
			} else {
				e = jQuery(this).text().replace('//', '@').replace(/\//g, '.');
			}
		} else { // 'normal'
			if(jQuery(this).is('a[rel]')) {
				e = jQuery(this).attr('rel').split('').reverse().join('').replace('//', '@').replace(/\//g, '.');
			} else {
				e = jQuery(this).text().split('').reverse().join('').replace('//', '@').replace(/\//g, '.');
			}
		}
		if(e) {
			if(jQuery(this).is('a[rel]')) {
				jQuery(this).attr('href', 'mailto:' + e);
				if(settings.replaceText) {
					jQuery(this).text(e);
				}
			} else {
				jQuery(this).text(e);
			}
		}
	});
};


/*

CUSTOM FORM ELEMENTS

Created by Ryan Fait
www.ryanfait.com

The only things you may need to change in this file are the following
variables: checkboxHeight, radioHeight and selectWidth (lines 24, 25, 26)

The numbers you set for checkboxHeight and radioHeight should be one quarter
of the total height of the image want to use for checkboxes and radio
buttons. Both images should contain the four stages of both inputs stacked
on top of each other in this order: unchecked, unchecked-clicked, checked,
checked-clicked.

You may need to adjust your images a bit if there is a slight vertical
movement during the different stages of the button activation.

The value of selectWidth should be the width of your select list image.

Visit http://ryanfait.com/ for more information.

*/

var checkboxHeight = "25";
var radioHeight = "25";
var selectWidth = "190";


/* No need to change anything after this */


document.write('<style type="text/css">input.styled { display: none; } select.styled { position: relative; width: ' + selectWidth + 'px; opacity: 0; filter: alpha(opacity=0); z-index: 5; } .disabled { opacity: 0.5; filter: alpha(opacity=50); }</style>');

var Custom = {
	init: function() {
		var inputs = document.getElementsByTagName("input"), span = Array(), textnode, option, active;
		for(a = 0; a < inputs.length; a++) {
			if((inputs[a].type == "checkbox" || inputs[a].type == "radio") && inputs[a].className == "styled") {
				span[a] = document.createElement("span");
				span[a].className = inputs[a].type;

				if(inputs[a].checked == true) {
					if(inputs[a].type == "checkbox") {
						position = "0 -" + (checkboxHeight*2) + "px";
						span[a].style.backgroundPosition = position;
					} else {
						position = "0 -" + (radioHeight*2) + "px";
						span[a].style.backgroundPosition = position;
					}
				}
				inputs[a].parentNode.insertBefore(span[a], inputs[a]);
				inputs[a].onchange = Custom.clear;
				if(!inputs[a].getAttribute("disabled")) {
					span[a].onmousedown = Custom.pushed;
					span[a].onmouseup = Custom.check;
				} else {
					span[a].className = span[a].className += " disabled";
				}
			}
		}
		inputs = document.getElementsByTagName("select");
		for(a = 0; a < inputs.length; a++) {
			if(inputs[a].className == "styled") {
				option = inputs[a].getElementsByTagName("option");
				active = option[0].childNodes[0].nodeValue;
				textnode = document.createTextNode(active);
				for(b = 0; b < option.length; b++) {
					if(option[b].selected == true) {
						textnode = document.createTextNode(option[b].childNodes[0].nodeValue);
					}
				}
				span[a] = document.createElement("span");
				span[a].className = "select";
				span[a].id = "select" + inputs[a].name;
				span[a].appendChild(textnode);
				inputs[a].parentNode.insertBefore(span[a], inputs[a]);
				if(!inputs[a].getAttribute("disabled")) {
					inputs[a].onchange = Custom.choose;
				} else {
					inputs[a].previousSibling.className = inputs[a].previousSibling.className += " disabled";
				}
			}
		}
		document.onmouseup = Custom.clear;
	},
	pushed: function() {
		element = this.nextSibling;
		if(element.checked == true && element.type == "checkbox") {
			this.style.backgroundPosition = "0 -" + checkboxHeight*3 + "px";
		} else if(element.checked == true && element.type == "radio") {
			this.style.backgroundPosition = "0 -" + radioHeight*3 + "px";
		} else if(element.checked != true && element.type == "checkbox") {
			this.style.backgroundPosition = "0 -" + checkboxHeight + "px";
		} else {
			this.style.backgroundPosition = "0 -" + radioHeight + "px";
		}
	},
	check: function() {
		element = this.nextSibling;
		if(element.checked == true && element.type == "checkbox") {
			this.style.backgroundPosition = "0 0";
			element.checked = false;
		} else {
			if(element.type == "checkbox") {
				this.style.backgroundPosition = "0 -" + checkboxHeight*2 + "px";
			} else {
				this.style.backgroundPosition = "0 -" + radioHeight*2 + "px";
				group = this.nextSibling.name;
				inputs = document.getElementsByTagName("input");
				for(a = 0; a < inputs.length; a++) {
					if(inputs[a].name == group && inputs[a] != this.nextSibling) {
						inputs[a].previousSibling.style.backgroundPosition = "0 0";
					}
				}
			}
			element.checked = true;
		}
	},
	clear: function() {
		inputs = document.getElementsByTagName("input");
		for(var b = 0; b < inputs.length; b++) {
			if(inputs[b].type == "checkbox" && inputs[b].checked == true && inputs[b].className == "styled") {
				inputs[b].previousSibling.style.backgroundPosition = "0 -" + checkboxHeight*2 + "px";
			} else if(inputs[b].type == "checkbox" && inputs[b].className == "styled") {
				inputs[b].previousSibling.style.backgroundPosition = "0 0";
			} else if(inputs[b].type == "radio" && inputs[b].checked == true && inputs[b].className == "styled") {
				inputs[b].previousSibling.style.backgroundPosition = "0 -" + radioHeight*2 + "px";
			} else if(inputs[b].type == "radio" && inputs[b].className == "styled") {
				inputs[b].previousSibling.style.backgroundPosition = "0 0";
			}
		}
	},
	choose: function() {
		option = this.getElementsByTagName("option");
		for(d = 0; d < option.length; d++) {
			if(option[d].selected == true) {
				document.getElementById("select" + this.name).childNodes[0].nodeValue = option[d].childNodes[0].nodeValue;
			}
		}
	}
}
window.onload = Custom.init;

/**
 * Vimeo Api
 * http://github.com/vimeo/froogaloop/raw/master/froogaloop.min.js
 */
var Froogaloop=function(){var e={hasWindowEvent:false,PLAYER_DOMAIN:"",eventCallbacks:{},iframe_pattern:/player\.(([a-zA-Z0-9_\.]+)\.)?vimeo(ws)?\.com\/video\/([0-9]+)/i},j=function(b){b||(b=document.getElementsByTagName("iframe"));for(var a,c=0,f=b.length,g;c<f;c++){a=b[c];if(g=e.iframe_pattern.test(a.getAttribute("src"))){a.api=h.api;a.get=h.get;a.addEvent=h.addEvent}}},h={api:function(b,a){i(b,a,this)},get:function(b,a){k(b,a,this.id!=""?this.id:null);i(b,null,this)},addEvent:function(b,a){k(b,
a,this.id!=""?this.id:null);b!="onLoad"&&i("api_addEventListener",[b,a.name],this);if(e.hasWindowEvent)return false;e.PLAYER_DOMAIN=d.getDomainFromUrl(this.getAttribute("src"));window.addEventListener?window.addEventListener("message",l,false):window.attachEvent("onmessage",l,false);e.hasWindowEvent=true}},i=function(b,a,c){if(!c.contentWindow.postMessage)return false;if(a===undefined||a===null)a="";var f=c.getAttribute("src").split("?")[0];b=d.serialize({method:b,params:a,id:c.getAttribute("id")});
c.contentWindow.postMessage(b,f)},k=function(b,a,c){if(c){e.eventCallbacks[c]||(e.eventCallbacks[c]={});e.eventCallbacks[c][b]=a}else e.eventCallbacks[b]=a},l=function(b){if(b.origin!=e.PLAYER_DOMAIN)return false;var a=d.unserialize(b.data);b=a.params?a.params.split('"').join("").split(","):"";a=a.method;var c=b[b.length-1];if(c=="")c=null;if(a=c?e.eventCallbacks[c][a]:e.eventCallbacks[a])b.length>0?a.apply(null,b):a.call()},d={r20:/%20/g,isArray:function(b){return Object.prototype.toString.call(b)===
"[object Array]"},isFunction:function(b){return Object.prototype.toString.call(b)==="[object Function]"},unserialize:function(b){if(!b)return false;var a={};b=b.split("&");for(var c,f,g=0;g<b.length;g++){c=unescape(b[g].split("=")[0]);f=unescape(b[g].split("=")[1]);if(f.indexOf("=")>-1)f=d.unserialize(f);a[c]=f}return a},s:false,serialize:function(b){d.s=[];for(var a in b)d.buildParams(a,b[a]);return d.s.join("&").replace(d.r20,"+")},buildParams:function(b,a){var c=0;if(d.isArray(a)){for(;c<a.length;c++)a[c]=
encodeURIComponent(a[c]);d.addToParam(encodeURIComponent(b),a.join(","))}else d.addToParam(encodeURIComponent(b),encodeURIComponent(a))},addToParam:function(b,a){a=d.isFunction(a)?a():a;d.s[d.s.length]=b+"="+a},getDomainFromUrl:function(b){b=b.split("/");for(var a="",c=0;c<b.length;c++){if(c<3)a+=b[c];else break;if(c<2)a+="/"}return a}};j();return{init:j}}();


/**
 * YouTube Api
 */
(function(){var e=void 0,f=null,g,h=this,j=function(a){for(var a=a.split("."),b=h,c;c=a.shift();)if(b[c]!=f)b=b[c];else return f;return b},k="closure_uid_"+Math.floor(Math.random()*2147483648).toString(36),aa=0,ba=function(a){return a.call.apply(a.bind,arguments)},ca=function(a,b){var c=b||h;if(arguments.length>2){var d=Array.prototype.slice.call(arguments,2);return function(){var b=Array.prototype.slice.call(arguments);Array.prototype.unshift.apply(b,d);return a.apply(c,b)}}else return function(){return a.apply(c,
arguments)}},m=function(){m=Function.prototype.bind&&Function.prototype.bind.toString().indexOf("native code")!=-1?ba:ca;return m.apply(f,arguments)},n=function(a,b){var c=a.split("."),d=h;!(c[0]in d)&&d.execScript&&d.execScript("var "+c[0]);for(var i;c.length&&(i=c.shift());)!c.length&&b!==e?d[i]=b:d=d[i]?d[i]:d[i]={}},p=function(a,b){o.prototype[a]=b},q=function(a,b){function c(){}c.prototype=b.prototype;a.p=b.prototype;a.prototype=new c};
Function.prototype.bind=Function.prototype.bind||function(a){if(arguments.length>1){var b=Array.prototype.slice.call(arguments,1);b.unshift(this,a);return m.apply(f,b)}else return m(this,a)};var s=function(a){this.stack=Error().stack||"";if(a)this.message=String(a)};q(s,Error);var da=function(a){for(var b=1;b<arguments.length;b++)var c=String(arguments[b]).replace(/\$/g,"$$$$"),a=a.replace(/\%s/,c);return a},t=function(a,b){if(a<b)return-1;else if(a>b)return 1;return 0};var u=function(a,b){b.unshift(a);s.call(this,da.apply(f,b));b.shift();this.o=a};q(u,s);var x=function(a,b){if(!a){var c=Array.prototype.slice.call(arguments,2),d="Assertion failed";if(b){d+=": "+b;var i=c}throw new u(""+d,i||[]);}};var y=Array.prototype,ea=y.indexOf?function(a,b,c){x(a.length!=f);return y.indexOf.call(a,b,c)}:function(a,b,c){c=c==f?0:c<0?Math.max(0,a.length+c):c;if(typeof a=="string"){if(typeof b!="string"||b.length!=1)return-1;return a.indexOf(b,c)}for(;c<a.length;c++)if(c in a&&a[c]===b)return c;return-1},fa=function(a,b,c){x(a.length!=f);return arguments.length<=2?y.slice.call(a,b):y.slice.call(a,b,c)};var ga=function(a){var b=z,c;for(c in b)if(a.call(e,b[c],c,b))return c};var A,B,C,D,E=function(){return h.navigator?h.navigator.userAgent:f};D=C=B=A=!1;var F;if(F=E()){var ha=h.navigator;A=F.indexOf("Opera")==0;B=!A&&F.indexOf("MSIE")!=-1;C=!A&&F.indexOf("WebKit")!=-1;D=!A&&!C&&ha.product=="Gecko"}var G=B,H=D,ia=C,I;
a:{var J="",K;if(A&&h.opera)var L=h.opera.version,J=typeof L=="function"?L():L;else if(H?K=/rv\:([^\);]+)(\)|;)/:G?K=/MSIE\s+([^\);]+)(\)|;)/:ia&&(K=/WebKit\/(\S+)/),K)var M=K.exec(E()),J=M?M[1]:"";if(G){var N,O=h.document;N=O?O.documentMode:e;if(N>parseFloat(J)){I=String(N);break a}}I=J}
var ja=I,P={},Q=function(a){var b;if(!(b=P[a])){b=0;for(var c=String(ja).replace(/^[\s\xa0]+|[\s\xa0]+$/g,"").split("."),d=String(a).replace(/^[\s\xa0]+|[\s\xa0]+$/g,"").split("."),i=Math.max(c.length,d.length),l=0;b==0&&l<i;l++){var r=c[l]||"",la=d[l]||"",ma=RegExp("(\\d*)(\\D*)","g"),na=RegExp("(\\d*)(\\D*)","g");do{var v=ma.exec(r)||["","",""],w=na.exec(la)||["","",""];if(v[0].length==0&&w[0].length==0)break;b=t(v[1].length==0?0:parseInt(v[1],10),w[1].length==0?0:parseInt(w[1],10))||t(v[2].length==
0,w[2].length==0)||t(v[2],w[2])}while(b==0)}b=P[a]=b>=0}return b};!G||Q("9");!H&&!G||G&&Q("9")||H&&Q("1.9.1");G&&Q("9");var ka=function(){};var R=function(){this.c=[];this.d={}};q(R,ka);R.prototype.i=1;R.prototype.f=0;var oa=function(a,b,c){var d=a.d[b];d||(d=a.d[b]=[]);var i=a.i;a.c[i]=b;a.c[i+1]=c;a.c[i+2]=e;a.i=i+3;d.push(i)};
R.prototype.k=function(a){var b=this.d[a];if(b){this.f++;for(var c=fa(arguments,1),d=0,i=b.length;d<i;d++){var l=b[d];this.c[l+1].apply(this.c[l+2],c)}this.f--;if(this.e&&this.f==0)for(;b=this.e.pop();)if(this.f!=0){if(!this.e)this.e=[];this.e.push(b)}else if(c=this.c[b]){if(c=this.d[c])d=c,c=ea(d,b),c>=0&&(x(d.length!=f),y.splice.call(d,c,1));delete this.c[b];delete this.c[b+1];delete this.c[b+2]}}};var S=function(a){if(a=a||j("window.event")){this.type=a.type;var b=a.target||a.srcElement;if(b&&b.nodeType==3)b=b.parentNode;this.target=b;if(b=a.relatedTarget)try{b=b.nodeName&&b}catch(c){b=f}else if(this.type=="mouseover")b=a.fromElement;else if(this.type=="mouseout")b=a.toElement;this.relatedTarget=b;this.data=a.data;this.source=a.source;this.origin=a.origin;this.state=a.state;this.clientX=a.clientX!==e?a.clientX:a.pageX;this.clientY=a.clientY!==e?a.clientY:a.pageY;if(a.pageX||a.pageY)this.pageX=
a.pageX,this.pageY=a.pageY;else if((a.clientX||a.clientY)&&document.body&&document.documentElement)this.pageX=a.clientX+document.body.scrollLeft+document.documentElement.scrollLeft,this.pageY=a.clientY+document.body.scrollTop+document.documentElement.scrollTop;this.keyCode=a.keyCode||0;this.charCode=a.charCode||(this.type=="keypress"?this.keyCode:0);this.n=a}};g=S.prototype;g.type="";g.target=f;g.relatedTarget=f;g.currentTarget=f;g.data=f;g.source=f;g.origin=f;g.state=f;g.keyCode=0;g.charCode=0;
g.n=f;g.clientX=0;g.clientY=0;g.pageX=0;g.pageY=0;var z=j("yt.events.listeners_")||{};n("yt.events.listeners_",z);var T=j("yt.events.counter_")||{count:0};n("yt.events.counter_",T);var pa=function(a,b){return ga(function(c){return c[0]==a&&c[1]=="message"&&c[2]==b})},ra=function(){var a=window,b=qa;if(a&&(a.addEventListener||a.attachEvent)){var c=pa(a,b);if(!c){var c=++T.count+"",d=function(c){c=new S(c);c.currentTarget=a;return b.call(a,c)};z[c]=[a,"message",b,d];a.addEventListener?a.addEventListener("message",d,!1):a.attachEvent("onmessage",d)}}};n("yt.config_",window.yt&&window.yt.config_||{});n("yt.globals_",window.yt&&window.yt.globals_||{});n("yt.msgs_",window.yt&&window.yt.msgs_||{});n("yt.timeouts_",window.yt&&window.yt.timeouts_||[]);var U=window.yt&&window.yt.intervals_||[];n("yt.intervals_",U);eval("/*@cc_on!@*/false");var V=window.YTConfig||{},sa={width:640,height:390,title:"video player",host:"http://www.youtube.com",apiReady:"onYouTubePlayerAPIReady"},ta={0:"onEnded",1:"onPlaying",2:"onPaused",3:"onBuffering",5:"onVideoCued"},W=f,X=function(a,b){return(b?b:{})[a]||V[a]||sa[a]},qa=function(a){if(a.origin==X("host")){var a=JSON.parse(a.data),b=W[a.id];switch(a.event){case "onReady":window.clearInterval(b.h);Y(b,"onReady");break;case "onStateChange":b.state=a.state;Z(b,a);Y(b,"onStateChange",b.state);b.state!=-1&&
Y(b,ta[b.state]);break;case "onPlaybackQualityChange":b.l=a.quality;Y(b,"onPlaybackQualityChange",b.l);break;case "onError":Y(b,"onError",a.error);break;case "infoDelivery":Z(b,a)}}},o=function(a,b){var c=typeof a=="string"?document.getElementById(a):a;if(c){if(c.tagName.toLowerCase()!="iframe"){var d=document.createElement("iframe");c.appendChild(d);d.setAttribute("frameborder","0");d.setAttribute("title","YouTube "+X("title",b));d.setAttribute("type","text/html");if(b&&(d.height=X("height",b),d.width=
X("width",b),"videoId"in b||"videoId"in V)){c=X("playerVars",b)||[];c.enablejsapi=1;window.location.host&&(c.origin=window.location.protocol+"//"+window.location.host);var i=[],l;for(l in c)c.hasOwnProperty(l)&&i.push(l+"="+c[l]);d.src=X("host",b)+"/embed/"+X("videoId",b)+"?"+i.join("&")}c=d}this.b=c;this.id=this[k]||(this[k]=++aa);this.a={};this.g=new R;d=this.id;W||(W={},ra());W[d]=this;d=m(this.j,this);d=window.setInterval(d,250);U.push(d);this.h=d;if(b){var d=X("events",b),r;for(r in d)d.hasOwnProperty(r)&&
this.addEventListener(r,d[r])}}};g=o.prototype;g.m=function(){var a=this.b;a&&a.parentNode&&a.parentNode.removeChild(a)};g.b=f;g.id=0;g.h=0;g.state=-1;g.g=f;g.j=function(){this.sendMessage({event:"listening"})};var Z=function(a,b){var c=b.info||{},d;for(d in c)c.hasOwnProperty(d)&&(a.a[d]=c[d])};o.prototype.addEventListener=function(a,b){var c=b;typeof b=="string"&&(c=function(){window[b].apply(window,arguments)});oa(this.g,a,c)};
var Y=function(a,b,c){a.g.k(b,{target:a,data:c})},$=function(a,b,c){c=c||[];c=Array.prototype.slice.call(c);a.sendMessage({event:"command",func:b,args:c})};g=o.prototype;g.sendMessage=function(a){a.id=this.id;this.b.contentWindow.postMessage(JSON.stringify(a),X("host"))};g.cueVideoById=function(){$(this,"cueVideoById",arguments);return this};g.loadVideoById=function(){$(this,"loadVideoById",arguments);return this};g.cueVideoByUrl=function(){$(this,"cueVideoByUrl",arguments);return this};
g.loadVideoByUrl=function(){$(this,"loadVideoByUrl",arguments);return this};g.playVideo=function(){$(this,"playVideo");return this};g.pauseVideo=function(){$(this,"pauseVideo");return this};g.stopVideo=function(){$(this,"stopVideo");return this};g.seekTo=function(){$(this,"seekTo",arguments);return this};g.clearVideo=function(){$(this,"clearVideo");return this};g.mute=function(){$(this,"mute");return this};g.unMute=function(){$(this,"unMute");return this};g.isMuted=function(){return this.a.isMuted};
g.setVolume=function(){$(this,"setVolume",arguments);return this};g.getVolume=function(){return this.a.volume};g.setSize=function(a,b){this.b.width=a;this.b.height=b;return this};g.getVideoBytesLoaded=function(){return this.a.videoBytesLoaded};g.getVideoBytesTotal=function(){return this.a.videoBytesTotal};g.getVideoStartBytes=function(){return this.a.videoStartBytes};g.getPlayerState=function(){return this.state};g.getCurrentTime=function(){return this.a.currentTime};g.getPlaybackQuality=function(){return this.a.quality};
g.setPlaybackQuality=function(){$(this,"setPlaybackQuality",arguments);return this};g.getAvailableQualityLevels=function(){return this.a.availableQualityLevels};g.getDuration=function(){return this.a.duration};g.getVideoUrl=function(){return this.a.videoUrl};g.getVideoEmbedCode=function(){return'<iframe title="'+this.b.title+'" class="'+this.b.className+'" width="'+this.b.width+'" height="'+this.b.height+'" src="'+this.b.src+'" type="text/html" frameborder="0"></iframe>'};n("YT.PlayerState.ENDED",0);n("YT.PlayerState.PLAYING",1);n("YT.PlayerState.PAUSED",2);n("YT.PlayerState.BUFFERING",3);n("YT.PlayerState.CUED",5);n("YT.Player",o);p("destroy",o.prototype.m);p("cueVideoById",o.prototype.cueVideoById);p("loadVideoById",o.prototype.loadVideoById);p("cueVideoByUrl",o.prototype.cueVideoByUrl);p("loadVideoByUrl",o.prototype.loadVideoByUrl);p("playVideo",o.prototype.playVideo);p("pauseVideo",o.prototype.pauseVideo);p("stopVideo",o.prototype.stopVideo);p("seekTo",o.prototype.seekTo);
p("clearVideo",o.prototype.clearVideo);p("mute",o.prototype.mute);p("unMute",o.prototype.unMute);p("isMuted",o.prototype.isMuted);p("setVolume",o.prototype.setVolume);p("getVolume",o.prototype.getVolume);p("setSize",o.prototype.setSize);p("getVideoBytesLoaded",o.prototype.getVideoBytesLoaded);p("getVideoBytesTotal",o.prototype.getVideoBytesTotal);p("getVideoStartBytes",o.prototype.getVideoStartBytes);p("getPlayerState",o.prototype.getPlayerState);p("getCurrentTime",o.prototype.getCurrentTime);
p("getPlaybackQuality",o.prototype.getPlaybackQuality);p("setPlaybackQuality",o.prototype.setPlaybackQuality);p("getAvailableQualityLevels",o.prototype.getAvailableQualityLevels);p("getDuration",o.prototype.getDuration);p("getVideoUrl",o.prototype.getVideoUrl);p("getVideoEmbedCode",o.prototype.getVideoEmbedCode);p("addEventListener",o.prototype.addEventListener);var ua=j(X("apiReady"));ua&&ua();})();
