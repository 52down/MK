var browser={
    versions:function(){
        var u = navigator.userAgent, app = navigator.appVersion;
        return {
            trident: u.indexOf('Trident') > -1, //IE内核
            presto: u.indexOf('Presto') > -1, //opera内核
            webKit: u.indexOf('AppleWebKit') > -1, //苹果、谷歌内核
            gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1,//火狐内核
            mobile: !!u.match(/AppleWebKit.*Mobile.*/), //是否为移动终端
            ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端
            android: u.indexOf('Android') > -1 || u.indexOf('Adr') > -1, //android终端
            iPhone: u.indexOf('iPhone') > -1 , //是否为iPhone或者QQHD浏览器
            iPad: u.indexOf('iPad') > -1, //是否iPad
            webApp: u.indexOf('Safari') == -1, //是否web应该程序，没有头部与底部
            weixin: u.indexOf('MicroMessenger') > -1, //是否微信 （2015-01-22新增）
            qq: u.match(/\sQQ/i) == " qq" //是否QQ
        };
    }(),
    language:(navigator.browserLanguage || navigator.language).toLowerCase()
}
//判断是否IE内核
//if(browser.versions.trident){ alert("is IE"); }
//判断是否webKit内核
//if(browser.versions.webKit){ alert("is webKit"); }
//判断是否移动端
//if(browser.versions.mobile||browser.versions.android||browser.versions.ios){ alert("移动端"); }

window.onload = function(){
	$(".load-fadeInUp").each(function(i){
		$(this).addClass("animated fadeInUp");
	});
	$(".load-fadeIn").each(function(i){
		$(this).addClass("animated fadeIn");
	});
};
$(function() {
	/*窗口变化时运行*/
	$(window).resize(function() {
		/*全屏幕高度*/
		$(".parallax").css("min-height",$(window).height());
		$(".get-inspired-box").each(function(i){
			$(this).height($(this).width()*1.33333333);
		});
		$(".home-about-img").each(function(i){
			$(this).height($(this).width()*1);
		});
	});
	if(browser.versions.trident){
		$("body").addClass("ie");
	}
	if(browser.versions.mobile){
		$("body").addClass("mob");
	}
	if(browser.versions.ios){
		$("body").addClass("ios");
	}
	if(browser.versions.iPhone){
		$("body").addClass("iPhone");
	}
	if(browser.versions.android){
		$("body").addClass("android");
	}
	
	/*滚动条滚动时运行*/
	$(window).scroll(function(){
		/*css 动画*/
		$(".css3-animation,.css3-animation-3d,.css3-animation-txt,.css3-animation-txt-y,.css3-animation-txt-right").each(function(i){
				if($(window).scrollTop() >= ($(this).offset().top - ($(window).height()*0.75 ) )){
					$(this).addClass("scrolltothis");
				}
		});
		$(".add-fadeIn").each(function(i){
				if($(window).scrollTop() >= ($(this).offset().top - ($(window).height()*0.75 ) )){
					$(this).addClass("animated fadeIn");
				}
		});
		
		$(".add-fadeInUp").each(function(i){
				if($(window).scrollTop() >= ($(this).offset().top - ($(window).height()*0.75 ) )){
					$(this).addClass("animated fadeInUp");
				}
		});
		$(".add-fadeInDown").each(function(i){
				if($(window).scrollTop() >= ($(this).offset().top - ($(window).height()*0.75 ) )){
					$(this).addClass("animated fadeInDown");
				}
		});
		
		/*css 动画 end*/
		if($(window).scrollTop() > 1 ){
			$("body").addClass("scroll");
			$(".header-main .col-logo").addClass("col-sm-3 animated fadeInDown");
			$(".header-main .col-menu").addClass("col-sm-9 animated fadeInDown");
			
		}else{
			$("body").removeClass("scroll");
			$(".header-main .col-logo").removeClass("col-sm-3 animated fadeInDown");
			$(".header-main .col-menu").removeClass("col-sm-9 animated fadeInDown");
			
		}
	});
	/***/
	$(".page-banner,.home-banner").addClass("loadone");
	/*全屏幕高度*/
	$(".parallax").css("min-height",$(window).height());
	
	
	
	/**/
	function floatLabel(inputType){
		$(inputType).each(function(){
			var $this = $(this);
			// on focus add cladd active to label
			$this.focus(function(){
				$this.next().addClass("active");
				
			});
			//on blur check field and remove class if needed
			$this.blur(function(){
				if($this.val() === '' || $this.val() === 'blank'){
					$this.next().removeClass();
				}
			});
		});
	}
	// just add a class of "floatLabel to the input field!"
	floatLabel(".floatLabel");
	/**/
	
	$(".navbar-link").click(function(){
		$(this).toggleClass("active");
		$("html").toggleClass("active");
		$("body").toggleClass("active");
		$(".page-wrap").toggleClass("active");
		$(".mob-navbar-pop").toggleClass("active");
		
	});
	$(".page-wrap.active").click(function(){
		$(this).removeClass("active");
		$(".mob-navbar-pop").removeClass("active");
		$(".navbar-link").removeClass("active");
	});
	$(".dropdown-sub>a").click(function(){
		$(this).parent().siblings("li").removeClass("active");
		$(this).parent().siblings("li").find(".mob-menu-sub").stop(true,true).slideUp();
		$(this).parent().toggleClass("active")
		$(this).siblings(".mob-menu-sub").stop(true,true).slideToggle();
		return false;
	});
	
	$(".mob-navbar-pop .close-btn").click(function(){
		$(this).parents(".mob-navbar-pop").fadeOut();
	});
	
	var num_index_mob;
	$(".dropdown-right").click(function(){
		var nav_num = $(this).index()+1;
		$(".mob-navbar-sub").addClass("active");
		$(".mob-navbar-sub>div#nav-mob-"+nav_num+"").stop(true,true).show().siblings().hide();
		return false;
	});
	$(".mob-navbar-sub-box h3 a").click(function(){
		$(".mob-navbar-sub").removeClass("active");
		return false;
	});
	$(".mob-navbar-sub-box dt").click(function(){
		$(this).toggleClass("active").siblings("dd").slideToggle();
		$(this).parents("dl").siblings("dl").find("dt").removeClass("active");
		$(this).parents("dl").siblings("dl").find("dd").slideUp();
	});
	
	$(".mob-search-btn").click(function(){
		$(this).toggleClass("active");
		$(".navbar-form").fadeToggle();
		return false;
	});
	
	$('.arrow-link').click(function(e) {
  	$('html, body').animate({scrollTop: $('.minka-story').offset().top}, 1000);
		return false;
  });
	
	var num_index;
	var remove_num;
	$(".dropdown-nav").hover(function(){
		$(this).addClass("active");
		$(".nav-dropdown").addClass("active");
		var nav_num = $(this).index()+1;
		num_index = $(this).index();
		$(".nav-dropdown>.container-fluid>div>.row#nav-"+nav_num+"").addClass("active").siblings().removeClass("active");
		
	},function(){
		var remove_num = num_index+1;
		$(this).removeClass("active");
		$(".nav-dropdown").removeClass("active");
		$(".nav-dropdown>.container-fluid>div>.row#nav-"+remove_num+"").removeClass("active");
		
	});
	$(".nav-dropdown-main").hover(function(){
		var remove_num = num_index+1;
		$(this).parents(".nav-dropdown").addClass("active");
		$(".dropdown-nav").eq(num_index).addClass("active");
		$(".nav-dropdown>.container-fluid>div>.row#nav-"+remove_num+"").addClass("active")
	},function(){
		var remove_num = num_index+1;
		$(this).parents(".nav-dropdown").removeClass("active");
		$(".dropdown-nav").removeClass("active");
		$(".nav-dropdown>.container-fluid>div>.row#nav-"+remove_num+"").removeClass("active");
	});
	
	$(".search-link").click(function(){
		$(".search-box").fadeIn();
		return false;
	});
	
	$(".header-main dd").hover(function(){
		$(this).addClass("active");
		$(this).find(".dropdown-menu-3").show();
	},function(){
		$(this).removeClass("active");
		$(this).find(".dropdown-menu-3").hide();
	});
	$(".dropdown-menu-3").each(function(i){
		
		$(this).height($(this).parents(".dropdown-menu-sub").height());
	});
	
/*	var nav_c = 2;
	for (var i=1;i<nav_c;i++){
		
		var nav_class = '.link-nav-c-'+i;
		var nav_c_class = '.mob-nav-c-'+i;
		$(nav_class).click(function(){
			$(nav_c_class).addClass("active");
			$(nav_c_class).each(function(e){
			  $(this).height($(".mob-navbar").height());	
			});
		});
	}
*/	
	$('dd.link-nav-c a').click(function(){
		var i = $(this).prop('rel');
		var nav_c_class = '.mob-nav-c-'+i;
		
		$(nav_c_class).addClass("active");
		$(nav_c_class).each(function(e){
			$(this).height($(".mob-navbar").height());	
		});
	})
	
	$(".mob-nav-c dt").click(function(){
	  $(this).parents(".mob-nav-c").removeClass("active");
	});
	$(".search-link-li a").click(function(){
	  $(".pc-search").slideDown(300);
		$(".pc-search .substring").focus();
	  return false;	
	});
	$(".search-close").click(function(){
	  $(".pc-search").slideUp(300);
	  return false;	
	});
	 var swiper = new Swiper('.home-banner .swiper-container', {
        nextButton: '.home-banner .swiper-button-next',
        prevButton: '.home-banner .swiper-button-prev',
        effect: 'fade',
		autoplay: 2500,
        autoplayDisableOnInteraction: false
    });
	$(".get-inspired-box").each(function(i){
		$(this).height($(this).width()*1.33333333);
	});
	$(".home-about-img").each(function(i){
		$(this).height($(this).width()*1);
	});
	
	
	$(".close-icon").click(function(){
		$(this).parents(".pop-wrap").fadeOut();
		$(this).parents(".search-box").fadeOut();
		$(this).parents(".details-pop").fadeOut();
		return false;	
	});
	$(".pop-wrap-bg").click(function(){
		$(this).parents(".pop-wrap").fadeOut();
	});
	
	$(".live-chat-link").click(function(){
	  $(".live-chat-pop").addClass("active").fadeIn();
	  return false;
	});
	$(".quick-shop-link").click(function(){
	  $(".quick-shop-pop").addClass("active").fadeIn();
	  return false;
	});
	
	$(".videos-box-img a").click(function(){
	  $(".video-pop").addClass("active").fadeIn();
	  return false;
	});
	$(".videos-pop-link").click(function(){
	  $(".video-pop").addClass("active").fadeIn();
	  return false;
	});
	$(".myProjects-pop-link").click(function(){
	  $(".myProjects-pop").addClass("active").fadeIn();
	  return false;
	});
	
	$(".filter-txt").click(function(){
		$(this).toggleClass("active");
	  	$(this).siblings(".filter-dropdown-main").slideToggle();
	});
	$(".filter-dropdown-main li").click(function(){
		$(this).siblings("li").removeClass("active")	
		$(this).addClass("active");
		$(this).parents(".filter-dropdown-main").slideUp();
		$(this).parents(".filter-dropdown-main").siblings(".filter-txt").removeClass("active");
		$(this).parents(".filter-dropdown-main").siblings(".filter-txt").find("span").html($("span",this).html());
		
	});
	
	var swiper = new Swiper('.compare .swiper-container', {
        nextButton: '.compare .swiper-button-next',
        prevButton: '.compare .swiper-button-prev',
        slidesPerView: 10,
        spaceBetween: 30,
        breakpoints: {
            1024: {
                slidesPerView: 9,
                spaceBetween: 20
            },
            768: {
                slidesPerView: 8,
                spaceBetween: 15
            },
            640: {
                slidesPerView: 4,
                spaceBetween: 15
            },
            320: {
                slidesPerView: 3,
                spaceBetween: 10
            }
        }
    });
	
	$(".p-index-box-txt input").click(function(){
	  $(".compare").toggleClass("active");	
	  
	});
	$(".close-compare").click(function(){
	  $(".compare").removeClass("active");
	  return false;
	});
	$(".show-filter").click(function(){
		$(this).toggleClass("active");
		$(".filter-top-line").toggleClass("active").slideToggle();
	});
	
	$(".filters-downlink").click(function(){
		$(".mob-sort-down").slideUp();
		$("#mob-filters-side").slideToggle();
		$(this).toggleClass("active");	
		$(".sort-downlink").removeClass("active");
	});
	$(".sort-downlink").click(function(){
		$("#mob-filters-side").slideUp();
		$(".mob-sort-down").slideToggle();		
		$(this).toggleClass("active");	
		$(".filters-downlink").removeClass("active");
	});
	/**/
	var index_2 = 0;
	if($("#tabs-list-2 li a").attr("class") == "active"){
		m =   0;
		$("#tabs-main-2").find(".tabs-box").eq(m).css("display","block");
	}
	$("#tabs-list-2 li a").click(function(){
		$("#tabs-list-2 li a").removeClass("active");
		$(this).addClass("active");
   		index_2 =   $("#tabs-list-2 li a").index(this);
   		showTabs_2(index_2);
		return false;
	}); 
	function showTabs_2(n){
		$("#tabs-main-2").find(".tabs-box").hide();
		$("#tabs-main-2").find(".tabs-box").eq(n).fadeIn();
		
		var swiper = new Swiper('.details-reviews-banner .swiper-container', {
			nextButton: '.details-reviews-banner .swiper-button-next',
			prevButton: '.details-reviews-banner .swiper-button-prev',
			slidesPerView: 3,
			spaceBetween: 45,
			breakpoints: {
				1024: {
					slidesPerView: 3,
					spaceBetween: 30
				},
				768: {
					slidesPerView: 2,
					spaceBetween: 15
				},
				640: {
					slidesPerView: 1,
					spaceBetween: 15
				},
				320: {
					slidesPerView: 1,
					spaceBetween: 10
				}
			}
		});
	};
	/**/
	var swiper = new Swiper('.product-family .swiper-container', {
        nextButton: '.product-family .swiper-button-next',
        prevButton: '.product-family .swiper-button-prev',
        slidesPerView: 4,
        spaceBetween: 30,
        breakpoints: {
            1024: {
                slidesPerView: 3,
                spaceBetween: 20
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 15
            },
            640: {
                slidesPerView: 1,
                spaceBetween: 15
            },
            320: {
                slidesPerView: 1,
                spaceBetween: 10
            }
        }
    });
	var swiper = new Swiper('.you-like .swiper-container', {
        nextButton: '.you-like .swiper-button-next',
        prevButton: '.you-like .swiper-button-prev',
        slidesPerView: 4,
        spaceBetween: 30,
        breakpoints: {
            1024: {
                slidesPerView: 3,
                spaceBetween: 20
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 15
            },
            640: {
                slidesPerView: 1,
                spaceBetween: 15
            },
            320: {
                slidesPerView: 1,
                spaceBetween: 10
            }
        }
    });
	
	var swiper = new Swiper('.comparison-main .swiper-container', {
        scrollbar: '#swiper-scrollbar-top.swiper-scrollbar',
        scrollbarHide: true,
        slidesPerView: 4,
        centeredSlides: false,
        spaceBetween: 20,
        grabCursor: true,
        breakpoints: {
				1024: {
					slidesPerView: 4,
					spaceBetween: 10
				},
				992: {
					slidesPerView: 3,
					spaceBetween: 10
				},
				640: {
					slidesPerView: 1,
					spaceBetween: 10
				},
				320: {
					slidesPerView: 1,
					spaceBetween: 10
				}
			}
    });
	$(".resources-meun dt").click(function(){
	  $(this).toggleClass("active");
	  $(this).siblings("dd").stop(false,true).slideToggle();	
	});
	
	$(".faq-box-title").click(function(){
	  $(this).toggleClass("active");	
	  $(this).siblings(".faq-box-child").slideToggle();
	});
	
	var swiper = new Swiper('.getInspired-swiper .swiper-container', {
        nextButton: '.getInspired-swiper .swiper-button-next',
        prevButton: '.getInspired-swiper .swiper-button-prev',
    });
	var swiper = new Swiper('.getInspired-bottom .swiper-container', {
        nextButton: '.getInspired-bottom .swiper-button-next',
        prevButton: '.getInspired-bottom .swiper-button-prev',
        slidesPerView: 4,
        spaceBetween: 15,
        breakpoints: {
            1024: {
                slidesPerView: 3,
                spaceBetween: 15
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 10
            },
            640: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            320: {
                slidesPerView: 2,
                spaceBetween: 10
            }
        }
    });
	$(".getInspired-line").height($(".getInspired-main").height());
	
	$(".myProjects-all-top-mob dt").click(function(){
	  $(this).toggleClass("active");
	  $(this).siblings("dd").stop(false,true).slideToggle();	
	});
	
	$("edit-link").click(function(){
	  	
	});
	
});
/*old menu*/
/*$(document).ready(function(){
	var menu_head = $(".menu-head");
    menu_head.hover(function(index) {
		$(this).parent().find(".menu-body").slideDown('fast').show();
        $(this).parent().hover(
			function() {
				$(this).find(".menu-head").addClass("aa1");
            }, function(){
            	$(this).parent().find(".menu-body").slideUp('fast').end().find(".menu-head").removeClass("aa1");
        });
    });
});*/
/*浏览器判断*/
/*const delegateEvent = (context, eventName, selector, fn) => {
    context.addEventListener(eventName, function(event) {
        const possibleTargets = context.querySelectorAll(selector);
        const target = event.target;

        for (var i = 0, l = possibleTargets.length; i < l; i++) {
            let el = target;
            let p = possibleTargets[i];

            while(el && el !== context) {
                if (el === p) {
                    return fn.call(p, event);
                }

                el = el.parentNode;
            }
        }
    });
};


const editableText = {
    init: function() {
        if (document.querySelectorAll('.js-editable-text').length === 0) {
            return false;
        }

        this.$editableText = document.querySelectorAll('.js-editable-text');

        Array.prototype.forEach.call(this.$editableText, (el, i) => {
            this.addEditBtn(el, i);
            this.bindEvents(el);
        });

    },
    addEditBtn: function(el, i) {
        const   buttonHtml = '<button id="EditableTextEditBtn_' + i + '" class="editable-text-btn editable-text-edit-btn" type="button">Edit</button><button id="EditableTextSaveBtn_' + i + '" class="editable-text-btn editable-text-save-btn" type="button">Save</button>',
                text = el.textContent;

        el.innerHTML = '<span class="editable-text-string">' + text + '</span>' + buttonHtml;
    },
    bindEvents: function(el) {

        delegateEvent(el, 'click', '.editable-text-btn', function(e) {
            e.preventDefault();
            const $editableText = el.querySelector('.editable-text-string');

            if($editableText.getAttribute('contenteditable')) {
                $editableText.removeAttribute('contenteditable');
                el.classList.remove('is-active');
            }
            else {
                $editableText.setAttribute('contenteditable', true);
                $editableText.focus();
                el.classList.add('is-active');
            }
        });
    }

};

// Initialise the module
editableText.init();*/

/*点击滚动到#id, click_scroll()运行*/
function click_scroll(){
	if($("a[href^='#']").length > 0){
		$("a").click(function(){
			if($(this).attr("href").length >= 2){
				$("body").animate({scrollTop: $($(this).attr("href")).offset().top}, 1000);
				return false;
			}
		});
	}
}
/*parallax,$(".dome").parallax()*/
(function( $ ){
	var $window = $(window);
	var windowHeight = $window.height();
	$window.resize(function () {
		windowHeight = $window.height();
	});

	$.fn.parallax = function(xpos, speedFactor, outerHeight) {
		var $this = $(this);
		var getHeight;
		var firstTop;
		var paddingTop = 0;
		//get the starting position of each element to have parallax applied to it	
		function update (){
			
			$this.each(function(){
								
				firstTop = $this.offset().top;
			});
	
			if (outerHeight) {
				getHeight = function(jqo) {
					return jqo.outerHeight(true);
				};
			} else {
				getHeight = function(jqo) {
					return jqo.height();
				};
			}
				
			// setup defaults if arguments aren't specified
			if (arguments.length < 1 || xpos === null) xpos = "50%";
			if (arguments.length < 2 || speedFactor === null) speedFactor = 1.2;
			if (arguments.length < 3 || outerHeight === null) outerHeight = true;
			
			// function to be called whenever the window is scrolled or resized
			
				var pos = $window.scrollTop();				
	
				$this.each(function(){
					var $element = $(this);
					var top = $element.offset().top;
					var height = getHeight($element);
	
					// Check if totally above or totally below viewport
					if (top + height < pos || top > pos + windowHeight) {
						return;
					}
					
					$this.css('backgroundPosition', xpos + " " + Math.round((firstTop - pos) * speedFactor) + "px");
					
				});
		}		

		$window.bind('scroll', update).resize(update);
		update();
	};
})(jQuery);
/*scrolltotop*/
var scrolltotop={
	setting: {startline:100, scrollto: 0, scrollduration:500, fadeduration:[500, 100]},
	controlHTML: '<i class="fa fa-angle-up"></i>', 
	controlattrs: {offsetx:5, offsety:5}, 
	anchorkeyword: '#top', 
	state: {isvisible:false, shouldvisible:false},
	scrollup:function(){
		if (!this.cssfixedsupport){this.$control.css({opacity:0}); };
		var dest=isNaN(this.setting.scrollto)? this.setting.scrollto : parseInt(this.setting.scrollto);
		if (typeof dest=="string" && jQuery('#'+dest).length==1){dest=jQuery('#'+dest).offset().top;}
		else{dest=0;};
		this.$body.animate({scrollTop: dest}, this.setting.scrollduration);
	},

	keepfixed:function(){
		var $window=jQuery(window);
		var controlx=$window.scrollLeft() + $window.width() - this.$control.width() - this.controlattrs.offsetx;
		var controly=$window.scrollTop() + $window.height() - this.$control.height() - this.controlattrs.offsety;
		this.$control.css({left:controlx+'px', top:controly+'px'});
	},

	togglecontrol:function(){
		var scrolltop=jQuery(window).scrollTop();
		if (!this.cssfixedsupport){this.keepfixed();};
		this.state.shouldvisible=(scrolltop>=this.setting.startline)? true : false;
		if (this.state.shouldvisible && !this.state.isvisible){
			this.$control.stop().animate({opacity:1}, this.setting.fadeduration[0]);
			this.state.isvisible=true;
		}
		else if (this.state.shouldvisible==false && this.state.isvisible){
			this.$control.stop().animate({opacity:0}, this.setting.fadeduration[1]);
			this.state.isvisible=false;
		}
	},
	
	init:function(){
		jQuery(document).ready(function($){
			var mainobj=scrolltotop;
			var iebrws=document.all;
			mainobj.cssfixedsupport=!iebrws || iebrws && document.compatMode=="CSS1Compat" && window.XMLHttpRequest;
			mainobj.$body=(window.opera)? (document.compatMode=="CSS1Compat"? $('html') : $('body')) : $('html,body');
			mainobj.$control=$('<div id="topcontrol">'+mainobj.controlHTML+'</div>')
				.css({position:mainobj.cssfixedsupport? 'fixed' : 'absolute', bottom:mainobj.controlattrs.offsety, right:mainobj.controlattrs.offsetx, opacity:0, cursor:'pointer'})
				.attr({title:'Scroll Back to Top'})
				.click(function(){mainobj.scrollup(); return false})
				.appendTo('body');
			if (document.all && !window.XMLHttpRequest && mainobj.$control.text()!=''){mainobj.$control.css({width:mainobj.$control.width()}); }
			mainobj.togglecontrol();
			$('a[href="' + mainobj.anchorkeyword +'"]').click(function(){
				mainobj.scrollup();
				return false;
			});
			$(window).bind('scroll resize', function(e){
				mainobj.togglecontrol();
			})
		})
	}
};

scrolltotop.init();