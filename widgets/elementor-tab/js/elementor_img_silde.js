/*
elementor_img
@author CJJ
 */

(function($){	
	$.fn.carousel=function(e){
		e=$.extend({itemsPerMove:2,duration:1e3,vertical:!1,specification:"",width:0,height:0,step:1,preCtrEntity:"pre_arrow",nextCtrEntity:"next_arrow"},e);
		var t=this,
			n=t.find(".viewport"),
			r=n.find(".list"),
			i,s,o,u,a,f=!1,
			l={
				init:function(){
					var oFirst=r.children(":first"),
						oLast=r.children(":last"),
						l,c,list_len=r.children().length;
					
					if(e.vertical){	//判断滚动方式
						l=Math.max(oFirst.outerHeight(!0), oLast.outerHeight(!0));
						i=l*e.itemsPerMove;
						c=oFirst.outerHeight(!0)-oFirst.outerHeight();
						t.addClass("vertical").css({height:e.height||i-c, width:e.width||oFirst.outerWidth(!0)});
						r.height(l*list_len);
						if(l*list_len>(e.height || i-c)){
							s={scrollTop:"-="+i};
							o={scrollTop:i};
							u={scrollTop:"-="+i*e.step};
							a={scrollTop:i*e.step};
							this.bind_event();
						}
					}else{
						l=Math.max(oFirst.outerWidth(!0), oLast.outerWidth(!0));
						i=l*e.itemsPerMove;
						c=oFirst.outerWidth(!0)-oFirst.outerWidth();
						t.addClass("horizontal").css({height:e.height||oFirst.outerHeight(!0), width:e.width||i-c});
						r.width(l*list_len);
						if(l*list_len>(e.width || i-c)){
							s={scrollLeft:"-="+i};
							o={scrollLeft:"+="+i};
							u={scrollLeft:"-="+i*e.step};
							a={scrollLeft:i*e.step};
							this.bind_event();
						}
					}
				},
				step_prev:function(t){
					if(f) return;f=!0;
					for(var o=0;o<e.itemsPerMove;o++)r.prepend(r.children(":last"));
					n[e.vertical?"scrollTop":"scrollLeft"](i).stop().animate(s,{
						duration:e.duration,
						complete:function(){
							l.current(0);
							t-=1;
							f=!1;
							t>0 && l.step_prev(t);
						}
					});
				},
				step_next:function(t){
					if(f) return;
					f=!0;
					n.stop().animate(o, {
						duration:e.duration,
						complete:function(){
							l.current(1);
							l.repeatRun(function(){
								r.children(":last").after(r.children(":first"))
							}, e.itemsPerMove);
							e.vertical?n.scrollTop(0):n.scrollLeft(0);
							t-=1;
							f=!1;
							t>0 && l.step_next(t);
						}
					})
				},
				moveSlide:function(t){
					t==="next"?this.step_next(e.step):this.step_prev(e.step)
				},
				repeatRun:function(e,t){
					for(var n=0; n<t; n++) e()
				},
				bind_event:function(){
					t.find(".btn").on("click", function(e){
						l.moveSlide($(this).hasClass("prev")?"prev":"next")
					});
				},
				current:function(t){
					var b=r.find("li.current");
					t?b.next().addClass('current').siblings().removeClass('current'):b.prev().addClass('current').siblings().removeClass('current');
					b=r.find("li.current");
					$(".detail_pic .big_box").attr("href", $('#shopbox_outer').length?'javascript:;':b.find("img").attr("mask"));
					$(".detail_pic .normal").attr("src", b.find("img").attr("normal"));
					
					if(b.attr('pos')=='video'){ //视频
						$(".detail_pic .big_box").hide();
						$(".detail_pic .video_container").show();
					}else{ //图片
						$(".detail_pic .big_box").show().attr("href", $('#shopbox_outer').length?'javascript:;':b.find("img").attr("mask"));
						$(".detail_pic .normal").attr("src", b.find("img").attr("normal"));
						$(".detail_pic .video_container").hide().find('.ytp-chrome-bottom .ytp-play-button').click();
					}
				}
			}
		l.init();
	}
	$.fn.extend({
		//放大镜插件
		magnify:function(t){
			t=$.extend({blankHeadHeight:0,detailWidth:348,detailHeight:348,detailLeft:458,featureImgRect:"350x350",large:"v"},t);
			
			var n=!1,
				win_left=$(window).scrollLeft(),
				win_top=$(window).scrollTop(),
				u=$("img", this).width(),
				a=$("img", this).height(),
				c=$(this).children("a"),
				narmal_pic=$(this).find(".normal"),
				h='<div class="detail_img_box" style="width:'+t.detailWidth+'px;height:'+t.detailHeight+'px;left:'+t.detailLeft+'px;"><img class="detail_img" onerror="$.imgOnError(this)"></div><div class="rect_mask"></div>';
			$(h).appendTo(this);
			var d=this.find(".detail_img_box"),
				v=d.find("img"),
				m=this.find(".rect_mask"),
				g=this,
				w=function($){
					d.hide();
					m.hide();
					m.css("top","-9999px");
					d.css("top","-9999px");
					n=!1
				};
			
			$(this).off().on('mouseleave', w).on('mousemove', function(h){
				if(!n){
					if(!c.attr("href")) return;
					var p=c.attr("href");
					v.attr("src", p);
					s=$(this).offset().left;
					o1=$(this).offset().top;
					o2=$(this).parent().parent().offset().top;
					v_top=o1-o2;
					d.css({top:t.blankHeadHeight-v_top});
					n=!0
				}
				d.css({'width':(v.width()<t.detailWidth?v.width():t.detailWidth),'height':(v.height()<t.detailHeight?v.height():t.detailHeight)});
				u=narmal_pic.width();
				a=narmal_pic.height();
				f=u*(t.detailWidth/v.width()>1?1:t.detailWidth/v.width());
				l=a*(t.detailHeight/v.height()>1?1:t.detailHeight/v.height());
				m.css({"width":f,"height":l});
				d.css({left:t.detailLeft-parseInt(d.parent().parent().css("left"))});
				if(h.clientX+win_left>u+s) return $(this).trigger("mouseleave");
				var g=h.clientX+win_left-s,
					w=h.clientY+win_top-o1;
				g<f/2?g=0:g>u-f/2?g=u-f:g-=f/2;
				w<l/2?w=0:w>a-l/2?w=a-l:w-=l/2;
				m.css({left:g, top:w});
				v.css({left:-(t.detailWidth/f)*g, top:-(t.detailHeight/l)*w, "max-width":"inherit", "max-height":"inherit"});
				d.show();
				m.show()
			});
			
			$(window).on("scroll", function(t){
				win_left=$(window).scrollLeft();
				win_top=$(window).scrollTop();
			});
		},
	})	

	//string => Object
	$.evalJSON = function(JSON){
		if (typeof JSON == 'undefined') return false;
		typeof JSON == "object" && JSON.parse ? JSON.parse: function(str) {
			return eval("(" + str + ")")
		};
	}

	var k=!1;
	var elementor_img_obj = {
		elementor_img_init:function(obj){
			elementor_img_obj.big_img_load(obj);
			elementor_img_obj.small_img_list(obj);
		},
		big_img_css:function(obj){//大图定位
			var $bigPic=obj,
				$picShell=$bigPic.find(".pic_shell");
				$bigBox=$picShell.find(".big_box");
			
			$bigBox.css({width:$picShell.width(), height:$picShell.height()});
			$bigBox.css({height:$bigBox.find('.magnify .big_pic img').height()});
			pleft=($picShell.width()-$bigBox.find('.magnify .big_pic img').width())/2;
			ptop=($picShell.height()-$bigBox.height())/2;
			$bigBox.css({width:$bigBox.find('.magnify .big_pic img').width(), left:pleft, top:0});
			
			//视频定位
			// $('.video_container iframe').attr({width:$picShell.width(), height:$picShell.height()});
		},
		big_img_load:function(obj){//大图loading		
			obj.height("auto");
			n_data=$.evalJSON(obj.find(".magnify").attr("data"));
			magnify=obj.find(".magnify").magnify('', n_data);
			
			// $(".big_pic").attr('href', 'javascript:;');
			// $(".big_box").removeClass('center');
			if(!obj.find('.small_carousel .item[pos=video]').hasClass('current')){
				obj.find('.pic_shell').addClass('loading');
			}
			obj.find(".big_pic img").load(function(){
				setTimeout(function(){
					obj.find('.pic_shell').removeClass('loading');
				},200);
				elementor_img_obj.big_img_css();
			});
		},
		small_img_list:function(obj){//小图列表
			var $bigPic=obj,
				$small=$bigPic.find('.small_carousel'),
				r, k;

			if($bigPic.hasClass("prod_gallery_x")){
				var $height=386,
					$len=6;
				if($('.detail_pic .small_carousel .item').size()>$len){
					$('.detail_pic .small_carousel .btn').show();
				}
				$small.carousel({itemsPerMove:1,height:$height,width:76,duration:200,vertical:1,step:1});
			}else{
				var $width=390,
					$len=4;
				if($('.detail_pic .small_carousel .item').size()>$len){
					$('.detail_pic .small_carousel .btn').show();
				}
				$small.carousel({itemsPerMove:1,height:86,width:$width,duration:200,vertical:!1,step:1});
			}
			$bigPic.on("mouseenter",".small_carousel .item",function(t){
				r=$bigPic.find(".current");
				var i=$(this);
				if(!i.hasClass("current")){
					r.removeClass("current");
					r=i;
					r.addClass("current");
					if(i.attr('pos')=='video'){ //视频
						$bigPic.find(".big_box").hide();
						$bigPic.find('.pic_shell').addClass('loading');
						// $bigPic.find(".video_container").show();
						setTimeout(function(){
							$bigPic.find('.pic_shell').removeClass('loading');
						},200);
					}else{ //图片
						$bigPic.find(".big_box").show().removeClass('center');
						$bigPic.find(".big_pic").attr("href", $('#shopbox_outer').length?'javascript:;':$(this).find("img").attr("mask"));
						$bigPic.find(".normal").attr("src", $(this).find("img").attr("normal"));
						// $bigPic.find(".video_container").hide().find('.ytp-chrome-bottom .ytp-play-button').click();
						$bigPic.find('.pic_shell').addClass('loading');
					}
				}
				return false;
			});
		}
	}

	if ($(".img_silde_box").length) {
		$(".img_silde_box").each(function(){
			var _this = $(this);

			elementor_img_obj.elementor_img_init(_this);
		})
	};
	
	// elementor_img();
})(jQuery);

