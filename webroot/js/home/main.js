$(document).ready(function() {
// 	var videosrc = $("#video").attr("src");
// 	$(".containerloader").animate({
// 		opacity:0
// 	}, 1000, function() {
// 		$(".containerloader").hide();
// 	});
// 	$( ".player svg" ).click(function() {		
// 		$(".modal-overlay").css({
// 			visibility:"visible",
// 			opacity:"1",
// 		});
// 		$("#video").attr("src",videosrc+'?autoplay=1');
// 	});
// 	$(".modal-overlay").click(function() {
// 		$(this).css({
// 			visibility:"hidden",
// 			opacity:"0",
// 		});
// 		$("#video").attr("src",videosrc);
// 	});
	$( ".signup-btn" ).click(function() {		
		$(".form-overlay,.form-sign").css({
			visibility:"visible",
			opacity:"1",
		});
	});
  // Hide notif 8s
jQuery(document).ready(function(){
    jQuery(".notif").delay(6000).hide("fast");
});
  $( ".login-btn" ).click(function() {    
    $(".form-overlay,.form-login").css({
      visibility:"visible",
      opacity:"1",
    });
  });
	$( ".form-overlay" ).click(function() {		
		$(".form-overlay, .form-container").css({
			visibility:"hidden",
			opacity:"0",
		});
	});
  // $( ".password_forget" ).click(function() {   
  //   return false;
  // });
	$(".menu-toggle").click(function() {
		  $(this).toggleClass("on");
		  $('.menu-section').toggleClass("on");
		  $("nav ul").toggleClass('hidden');
	});
	// Smooth scroll
	$('.js-scrollTo').on('click', function() { // Au clic sur un élément
		$("nav ul").addClass("hidden");
		$(".menu-section,.menu-toggle").removeClass("on");
		var page = $(this).attr('href'); // Page cible
		var speed = 1000; // Durée de l'animation (en ms)
		$('html, body').animate( { scrollTop: $(page).offset().top}, speed ); // Go
		return false;
	});	

});
$(function() {

  smoothScroll.init();

  // init ScrollMagic Controller
  var controller = new ScrollMagic.Controller();

	
	
   var scenenavtowh = new ScrollMagic.Scene({
      triggerElement: ".video",
      duration: $(window).height(),
       triggerHook: 0.1,
      reverse: true
    })
    .setTween(TweenMax.to('.menu-toggle div', 1.2, {
      background:"#22B2FF"
    }))
    .addTo(controller);	
	
	var scenenavtobl = new ScrollMagic.Scene({
      triggerElement: ".prices",
      duration: $(window).height(),
      triggerHook: 0.1,
      reverse: true
    })
    .setTween(TweenMax.to('.menu-toggle div', 1.2, {
      background:"#ffffff"
    }))
    .addTo(controller);	
	
  // Scene 1 Handler
  var scene1 = new ScrollMagic.Scene({
      triggerElement: "#scene1",
      duration: $(window).height() / 2,
      triggerHook: .35,
      reverse: true
    })
    .setPin("#pinned-row1")
    .addTo(controller);
	
  var scene1 = new ScrollMagic.Scene({
      triggerElement: "#scene1",
      duration: $(window).height() / 4,
      triggerHook: .4,
      reverse: true
    })
    .setTween(TweenMax.to('#scene-indicator', .75, {
      opacity: 1,
	  visibility:'visible',
    }))
    .addTo(controller);
	
	var scene1 = new ScrollMagic.Scene({
      triggerElement: ".story",
      duration: $(window).height() / 3,
      triggerHook: .4,
      reverse: true
    })
    .setTween(TweenMax.to('#story h2', .75, {
      opacity: 1,
	  visibility:'visible',
    }))
    .addTo(controller);
  // Scene2 Handler
  var scene2 = new ScrollMagic.Scene({
      triggerElement: "#scene2",
      duration: $(window).height() / 4,
      triggerHook: .8
    })
    .setTween(TweenMax.to('.first', .75, {
      scale: .5
    }))
    .addTo(controller);

  var scene2 = new ScrollMagic.Scene({
      triggerElement: "#scene2",
      duration: $(window).height() / 2,
      triggerHook: .8
    })
    .addTo(controller);

  var scene2 = new ScrollMagic.Scene({
      triggerElement: "#scene2",
      duration: $(window).height() / 2,
      triggerHook: .8
    })
    .setTween(TweenMax.to('.second', .75, {
      scale: 1.5
    }))
    .addTo(controller);

  var scene2 = new ScrollMagic.Scene({
      triggerElement: "#scene2",
      duration: $(window).height() / 2,
      triggerHook: .8
    })
    .addTo(controller);

  var scene2 = new ScrollMagic.Scene({
      triggerElement: "#scene2",
      duration: $(window).height() / 2,
      triggerHook: 1.8
    })
    .setTween(TweenMax.to('#pinned-row1', .75, {
      opacity: 0
    }))
    .addTo(controller);

  var scene2 = new ScrollMagic.Scene({
      triggerElement: "#scene2",
      duration: $(window).height() / 2,
      triggerHook: .7
    })
    .setTween(TweenMax.to('#pinned-row2', 1.25, {
      opacity: 1
    }))
    .addTo(controller);
	
	var scene2 = new ScrollMagic.Scene({
      triggerElement: "#scene2",
      duration: $(window).height() / 2,
      triggerHook: 0.7,
	  reverse : true,
    })
    .setTween(TweenMax.to('.story', 1.25, {css:{className:'+=story2'}}))
    .addTo(controller);	
	
  var scene2 = new ScrollMagic.Scene({
      triggerElement: "#scene2",
      duration: $(window).height() / 2,
      triggerHook: .35
    })
    .setPin("#pinned-row2")
    .addTo(controller);

  // Scene3 Handler
   var scene3 = new ScrollMagic.Scene({
      triggerElement: "#scene3",
      duration: $(window).height() / 2,
      triggerHook: .8
    })
    .setTween(TweenMax.to('.second', .75, {
      scale: 1
    }))
    .addTo(controller);

  var scene3 = new ScrollMagic.Scene({
      triggerElement: "#scene3",
      duration: $(window).height() / 2,
      triggerHook: .8
    })
    .addTo(controller);

  var scene3 = new ScrollMagic.Scene({
      triggerElement: "#scene3",
      duration: $(window).height() / 2,
      triggerHook: .8
    })
    .setTween(TweenMax.to('.third', .75, {
      scale: 1.5
    }))
    .addTo(controller);

  var scene3 = new ScrollMagic.Scene({
      triggerElement: "#scene3",
      duration: $(window).height() / 2,
      triggerHook: .8
    })
    .addTo(controller);

  var scene3 = new ScrollMagic.Scene({
      triggerElement: "#scene3",
      duration: $(window).height() / 2,
      triggerHook: 1.8
    })
    .setTween(TweenMax.to('#pinned-row2', .75, {
      opacity: 0
    }))
    .addTo(controller);

  var scene3 = new ScrollMagic.Scene({
      triggerElement: "#scene3",
      duration: $(window).height() / 2,
      triggerHook: .7
    })
    .setTween(TweenMax.to('#pinned-row3', 1.25, {
      opacity: 1
    }))
    .addTo(controller);
var scene3 = new ScrollMagic.Scene({
      triggerElement: "#scene3",
      duration: $(window).height() / 2,
      triggerHook: 0.7,
	  reverse : true,
    })
    .setTween(TweenMax.to('.story', 1.25, {css:{className:'+=story3'}}))
    .addTo(controller);	
  var scene3 = new ScrollMagic.Scene({
      triggerElement: "#scene3",
      duration: $(window).height() / 2,
      triggerHook: .35
    })
    .setPin("#pinned-row3")
    .addTo(controller);

  var scene3 = new ScrollMagic.Scene({
      triggerElement: "#scene3",
      duration: $(window).height() / 3,
      triggerHook: 0
    })
    .setTween(TweenMax.to('#scene-indicator', .75, {
      opacity: 0,
    }))
    .addTo(controller);
	 var scene3 = new ScrollMagic.Scene({
      triggerElement: "#scene3",
       duration: $(window).height()/1.5,
      triggerHook: 0.2,
	  reverse : true,
    })
    .setTween(TweenMax.to('#story h2', .75, {
      opacity: 0,
    }))
    .addTo(controller);
	
	 var scene4 = new ScrollMagic.Scene({
      triggerElement: ".prices",
       duration: $(window).height()/10,
      triggerHook: 0.2,
	  reverse : true,
    })
    .setTween(TweenMax.to('#story h2', .75, {
      visibility:"hidden"
    }))
    .addTo(controller);
	var scene4 = new ScrollMagic.Scene({
      triggerElement: ".prices",
       duration: $(window).height()/10,
      triggerHook: 0.2,
	  reverse : true,
    })
    .setTween(TweenMax.to('#scene-indicator', .75, {
      visibility:"hidden"
    }))
    .addTo(controller);
});