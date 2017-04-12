function heightFit(slider){
    var height = 0;
    $(slider).children().each(function(index, el) {
    	if(height < (heightElement = $(el).height()) ) height = heightElement;

    });
    $(slider).children().height(height);
 }

$(function(){



	$("#menu").prepend(	$(".header .logo").clone(),
						$(".header .header-contacts").clone(),
						$(".header .nav").clone(),
						// $(".social .section-title").clone(),
						$(".social .wrap-social-btn").children('a').removeClass('wow').end().clone(),
						$(".social .site-wrap").clone()
						);
	slideout = new Slideout({
	    'panel': document.getElementById('panel'),
	    'menu': document.getElementById('menu'),
	    'padding': 256,
	    'tolerance': 70,
	    // 'touch' : false,
	  });
	$(".close").click(function(event) {
		slideout.close();
	});

	// $(".touch-fix").on('touchenter',function(event) {
	// 	alert();
	// });
	
	// document.body.addEventListener('touchstart', function(e){
	// 	if($(e.target).hasClass('touch-fix')) {
	//         console.log(e);
	// 		slideout.enableTouch();
	// 	}
	//     }, false);
	
	// document.body.addEventListener('touchend', function(e){
	// 		if($(e.target).hasClass('touch-fix')) {
	// 	        console.log(e);
	// 	slideout.disableTouch();
	// 		}
	//     }, false);


	// slideout.disableTouch();
	// slideout.on('open', function() {
	// });
	// slideout.on('close', function() {
	// });

	// $(".panel-cover, .mobile-fixed-btn").click(function(event) {
	// 	slideout.toggle();
	// });
	// $(".mobile-fixed-btn").addClass('zoom');
	//  $(".slideout-menu").append($(".wrap-fixed-btn").clone());




	$(".form-trigger").on("click", function(event) {
		if($(event.target).data('wrap')){
			$.fancybox.defaults.baseClass = function(){
				return $(event.target).data('wrap');
			}();
		}
		else {
			$.fancybox.defaults.baseClass = "";
		}
		
		$.fancybox.open({
			src: '#form-main',
			baseClass: 'zaza',
		});
	});
	
	mainForm = $("#form-main");
	$("form[action='/form.php']").submit(function(event){
		mainForm.text("Секундочку...")
		$.ajax({
			url: $(event.target).attr('action'),
			type: 'POST',
			dataType: '',
			data: $(event.target).serialize(),
		})
		.done(function(json) {
			mainForm.text("Спасибо! Ваша форма отправлена, мы свяжемся с Вами в ближайшее время.");
		})
		.fail(function() {
			mainForm.text("Возникли проблемы, пожалуйста, перезагрузите страницу и повторите попытку.");
		});	
		if($(event.target).hasClass('form-trigger-sub')){
			$.fancybox.open({
				src: '#form-main',
			});
		}
		
		return false;
	});



	$('.grid').imagesLoaded().progress( function() {
		$('.gallery-foto-wrap .grid, .detail-news-images').masonry({
		  itemSelector: '.grid-item',
		  columnWidth: 282.5,
		  gutter: 10,
		});


		$('.wrap-videos.grid').masonry({
		  itemSelector: '.grid-item',
		  columnWidth: '.grid-item',
		  gutter: 10,
		});
	});

	


	$(".fancybox").fancybox();



	header = $(".header-sub");
	$(".lvl-1 li").hover(function(e) {
		$(e.currentTarget).find(".lvl-2").stop().animate({opacity: 'show', height: 'show'}, 200);
	}, function(e) {
		console.log(e);
		$(e.currentTarget).find(".lvl-2").stop().animate({opacity: 'hide', height: 'hide'}, 200);
	});



	$(".group-box-title").click(function(event) {
		$(event.target).parent().children('.group-des').slideFadeToggle(200);
		$(event.target).parent().toggleClass('open');
	});


	var topNav = $(".header-sub");
	var fixedClass = "fixed-header";
	var shadowClass = "fixed-shadow";
	setTimeout(function(){
		$(document).scroll();
		$(document).scroll(function(){
			topNav.addClass("header-anim");
		});
	});

	var start_pos=1;
	 $(window).scroll(function(){
	  if ($(window).scrollTop()>=start_pos) {
	      if (topNav.hasClass()==false) topNav.addClass(fixedClass);
	  }
	  else topNav.removeClass(fixedClass);

	  if($(window).scrollTop()>=start_pos+60){
	  	topNav.addClass(shadowClass);
	  }
	  else {
	  	topNav.removeClass(shadowClass);
	  }

	 });



	 $(".bx-slider").bxSlider({
		slideWidth: 280,
		maxSlides: 4,
		slideMargin: 16.5,
		infiniteLoop: false,
		hideControlOnEnd: true,
		onSliderLoad: function(){heightFit(this)},
	});
	 $(".bx-slider-video").bxSlider({
		slideWidth: 379,
		maxSlides: 4,
		slideMargin: 16.5,
		infiniteLoop: false,
		hideControlOnEnd: true,
		onSliderLoad: function(){heightFit(this)},
	});






	 wow = new WOW(
	   {
	     animateClass: 'animated',
	     offset:       100,
	     callback: function(obj){
	     	if(obj.id=='typed-text'){
	     		Typed.new('#typed-text', {
	     		        strings: ["Просто заполните форму^1000 и мы ответим на все Ваши вопросы!"],
	     		        typeSpeed: 10,
	     		      });
	     	}
	     },
	   }
	 );
	 wow.init();

	 bind = $(".you-reviews").mouseenter(function(event) {
	 	Typed.new('#typed-reviews', {
	         strings: ["Ваш отзыв очень важен для нас!"],
	         typeSpeed: 10,
	       });
	 	bind.unbind('mouseenter');
	 });
	 


});