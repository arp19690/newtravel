function init_validation(target) {
	function validate(target) {
		var valid = true;
		$(target).find('.req').each(function() {
			if($(this).val() == '') {
				valid = false;
				$(this).parent().addClass('errored');
			}
			else {
				$(this).parent().removeClass('errored');
			}
		});
		return valid;
	}
	
	$('form.w_validation').live('submit', function(e) {
		var valid = validate(this);
		if(!valid) e.preventDefault();
	});
	
	if(target) {return validate(target);}
}
$(window).load(function() {
	init_validation();
});

$(document).ready(function(){

	$slideHover = function() {
		$('.offer-slider-i').on({
			mouseenter: function(){
				$(this).find('.offer-slider-overlay').fadeIn(170);
				$(this).find('.offer-slider-btn').animate({top: "50%"}, 170);
			},
			mouseleave: function(){
				$(this).find('.offer-slider-overlay').fadeOut(170);
				$(this).find('.offer-slider-btn').css('top','-200px');
			}
		}, $(this));
	}
	$headerDown = function() {
		$('.header-a').slideUp(120);
		$('.header-b').css('height','59px');
		$('.header-b').addClass('fixed');
		$('.header-logo').css('margin-top','10px')
		$('.header-right').css('margin-top','21px');
		$('.header-logo').find('img').attr('src','img/logo-a.png');

	}
	$headerUp = function() {
		$('.header-a').slideDown(150);
		$('.header-b').removeClass('fixed');
		$('.header-b').css('height','89px');
		$('.header-logo').css('margin-top','26px');
		$('.header-right').css('margin-top','37px');
		$('.header-logo').find('img').attr('src','img/logo.png');
	}

	$(window).scroll(function(){
		var $scrollTop = $(window).scrollTop();
		if ( $scrollTop>140 ) {
			$headerDown();
		} else {
			$headerUp();
		}
	});

	$('.mobile-menu a.has-child').click(function(){
	 if ( $(this).is('.open') ) {
		$(this).removeClass('open');
		$(this).closest('li').find('ul').slideUp(); 
	 } else {
		$('.mobile-menu li ul').slideUp();
		$('.mobile-menu li a').removeClass('open');
		$(this).addClass('open');
		$(this).closest('li').find('ul').slideDown(); 
	 }

	 
	 return false;
	});

	$('.menu-btn').click(function(){
	 if ( $(this).is('.open') ) {
		$(this).removeClass('open') 
		$('.mobile-menu').slideUp(); 
	 } else {
		$(this).addClass('open') 
		$('.mobile-menu').slideDown();
	 }
	 return false;
	 
	});


	$('.header-nav ul li').hover(
		function() {
			$(this).find('ul').show();
		}, function() {
			$(this).find('ul').hide();
		}
	);
	$('.header-lang').hover(
		function() {
			$('.langs-drop').fadeIn();
		}, function() {
			$('.langs-drop').hide();
		}
	);
	$('.header-viewed').hover(
		function() {
			$('.viewed-drop').fadeIn();
		}, function() {
			$('.viewed-drop').hide();
		}
	);
	$('.header-curency').hover(
		function() {
			$('.curency-drop').fadeIn();
		}, function() {
			$('.curency-drop').hide();
		}
	);
	$('.flight-line .flight-line-b b').click(function(){
	  if ( $(this).is('.open') ) {
		$(this).removeClass('open');
		$(this).closest('.flight-line').find('.flight-details').slideUp();  
	  } else {
		$(this).addClass('open');
		$(this).closest('.flight-line').find('.flight-details').slideDown();  
	  }
	});
	$('.alt-flight .flight-line-b b').click(function(){
	  if ( $(this).is('.open') ) {
		$(this).removeClass('open');
		$(this).closest('.alt-flight').find('.alt-details').slideUp();  
	  } else {
		$(this).addClass('open');
		$(this).closest('.alt-flight').find('.alt-details').slideDown();  
	  }
	});
	$('.hdr-srch-btn').click(function(){
		$('.hdr-srch-overlay').fadeIn().find('input:text').focus();
		return false;
	});
	$('.srch-close').click(function(){
		$('.hdr-srch-overlay').fadeOut();
		return false;
	});

	$('.srch-lbl').click(function(){
		if ( $(this).is('.open') ) {
			$(this).closest('.search-tab-content').find('.search-asvanced').hide();
			$(this).text('Advanced Search options').removeClass('open');
		} else {
			
			$(this).closest('.search-tab-content').find('.search-asvanced').fadeIn();
			$(this).text('close search options').addClass('open');	
			
		}
	});

	$('.search-tab').click(function(){
		var $index = $(this).index();
		$('.search-tab-content').hide().eq($index).fadeIn();
		$('.search-tab').removeClass('active').eq($index).addClass('active');
		return false;
	});

	$('.header-account a').click(function(){
		$('.overlay').fadeIn(function(){
			$('.autorize-popup').animate({top: '50%'}, 300).find('input:text').eq('0').focus();
		});
		return false;
	});

	$('.overlay').click(function(){
		$('.autorize-popup').animate({top: '-300px'}, 300, function(){
			$('.overlay').fadeOut();	
		});
	});

	$('.autorize-tab-content').eq('0').css('display','block');
	$('.autorize-tabs a').click(function(){
		if ( $(this).is('.autorize-close') ) {
			$('.autorize-popup').animate({top: '-300px'}, 300, function(){
				$('.overlay').fadeOut();	
			});
		} else {
			var $index = $(this).index();
			$('.autorize-tabs a').removeClass('current').eq($index).addClass('current');
			$('.autorize-tab-content').hide().eq($index).fadeIn().find('input:text').eq('0').focus();
		}
		return false;
	});

	$('map area').hover(
		function() {
			var $id = $(this).attr('id');
			$('.regions-holder .'+$id).css('background-position','left -177px');
			$('.regions-nav a.'+$id).addClass('chosen');
		}, function() {
			var $id = $(this).attr('id');
			$('.regions-holder .'+$id).css('background-position','left 0px');
			$('.regions-nav a.'+$id).removeClass('chosen');
		}
	);
	$('.regions-nav a').hover(
		function() {
			var $id = $(this).attr('class');
			$('.regions-holder .'+$id).css('background-position','left -177px');
		}, function() {
			var $id = $(this).attr('class');
			$('.regions-holder .'+$id).css('background-position','left 0px');
		}
	);

	$('.gallery-i a').live('click',function(){
		var $href = $(this).attr('href');
		$('.gallery-i').removeClass('active');
		$(this).closest('.gallery-i').addClass('active');
		$('.tab-gallery-big img').attr('src',$href);
		return false;
	});
	$('.content-tabs-head a').click(function(){
		var $index = $(this).closest('li').index();
		$('.content-tabs-head a').removeClass('active');
		$('.content-tabs-head li').eq($index).find('a').addClass('active');
		$('.content-tabs-i').hide().eq($index).fadeIn();
		return false;
	});
	$('.faq-item-a').click(function(){
	  var $parent = $(this).closest('.faq-item');
	  if ($parent.is('.open')) {
		$parent.find('.faq-item-p').hide(); 
		$('.faq-item').removeClass('open');
	  } else {
		$('.faq-item').removeClass('open');
		$('.faq-item-p').hide();
		$parent.addClass('open').find('.faq-item-p').fadeIn();  
	  }
	});
	$('.h-tab-i a').click(function(){
	 var $index = $(this).closest('.h-tab-i').index();
	 $('.h-tab-i').removeClass('active');
	 $('.h-tab-i').eq($index).addClass('active');
	 
	 if ( $(this).is('.initMap') ) {
	 $('.tab-map').css('opacity','0');
	 $('#preloader').show();
	 $('.tab-item').hide().eq($index).fadeIn(function(){
		var mylat = '52.569334';
		var mylong ='13.380216';                
		var mapOptions = {
			zoom: 13,
			disableDefaultUI: true,
			zoomControl: true,
			zoomControlOptions: {
				style: google.maps.ZoomControlStyle.LARGE,
				position: google.maps.ControlPosition.LEFT_CENTER
			},
			center: new google.maps.LatLng(mylat, mylong), // New York 
		};
		var mapElement = document.getElementById('map');
		var map = new google.maps.Map(mapElement, mapOptions);
		google.maps.event.addDomListener(window, 'resize', init);
		google.maps.event.addListenerOnce(map, 'idle', function(){
			
			var place = new google.maps.LatLng(52.569334, 13.380216);   
			var image = new google.maps.MarkerImage('img/map.png',      
			new google.maps.Size(19, 29),      
			new google.maps.Point(0,0),      
			new google.maps.Point(0, 32));  
			var marker = new google.maps.Marker({
				map:map,
				icon: image, 
				draggable:false,
				animation: google.maps.Animation.DROP,
				position: place
			}); 
			
			$('.tab-map').css('opacity','1');
			$('#preloader').hide();	
			$('.map-contacts').each(function(index){	
				$(this).delay(141*index).fadeIn();     
			}); 
			
			});                 
		google.maps.event.trigger(map, 'resize'); 
	 }); 
	 } else {
	 $('.tab-item').hide().eq($index).fadeIn();
	 } 
	 return false;
	});

	$('.tabs-nav a').click(function(){
	 var $parent = $(this).closest('.tabs-block')
	 var $index = $(this).closest('li').index();
	 $parent.find('.tabs-nav li a').removeClass('active');
	 $parent.find('.tabs-nav li').eq($index).find('a').addClass('active');
	 $parent.find('.tabs-content-i').hide().eq($index).fadeIn();
	 return false;
	});

	$('.accordeon-a').click(function(){
		var $parent = $(this).closest('.accordeon-item');
		$('.accordeon-item').removeClass('open');
		$('.accordeon-b').hide();
		$parent.addClass('open').find('.accordeon-b').fadeIn();
	});

	$('.toggle-trigger').click(function(){
		var $parent = $(this).closest('.toggle-i');
		if ( $parent.is('.open') ) {
			$parent.removeClass('open').find('.toggle-txt').hide();	
		} else {
			$parent.addClass('open').find('.toggle-txt').fadeIn();
		}
		return false;
	});

	$('.shareholder span').click(function(){
		if ( $(this).is('.open') ) {
			$('.share-popup').hide();
			$(this).removeClass('open');
		} else {
			$('.share-popup').fadeIn();
			$(this).addClass('open');	
		}

		return false;
	});

	$('.payment-tabs a').click(function(){
		var $index = $(this).index();
		$('.payment-tab').hide().eq($index).fadeIn();
		$('.payment-tabs a').removeClass('active').eq($index).addClass('active');
		return false;
	});

	$('.solutions-i').hover(
		function() {
			$(this).find('.solutions-over').css('background','rgba(0,0,0,0.7)');
			$(this).find('.solutions-over-c').hide();
			$(this).find('.solutions-over-d').fadeIn(500);
		}, function() {
			$(this).find('.solutions-over').css('background','rgba(0,0,0,0.5)');
			$(this).find('.solutions-over-d').hide();
			$(this).find('.solutions-over-c').fadeIn(700);		
		}
	);

});

$(window).resize(function(){
	var $width = $(document).width();
	if ($width>900) {
		$('.mobile-menu').hide();
		$('.menu-btn').removeClass('open');
	}
});
