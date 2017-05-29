function changeSlide() {
	var positionslider = $(".slider").offset().top;
	var nextSection = $(".afterslider").offset().top - $(window).height();
	var sliderheight = $(window).height() + 900;
	$(".slider").css("min-height",sliderheight);
	if ($(window).scrollTop() >= positionslider) {
			 $(".bgw").css({
				 "position":"fixed",
				 "top":"30",
				 "left":"30"
			 });
			if (($(window).scrollTop() > positionslider) && ($(window).scrollTop() < positionslider + 300)) {
				$(".slide1").addClass("activeslide");
				$(".slide2").removeClass("activeslide");
			}
			if (($(window).scrollTop() > positionslider + 300) && ($(window).scrollTop() < positionslider + 600)) {
				$(".slide1").removeClass("activeslide");
				$(".slide2").addClass("activeslide");
				$(".slide3").removeClass("activeslide");
			}
			if (($(window).scrollTop() > positionslider + 600) && ($(window).scrollTop() < nextSection)) {
				$(".slide2").removeClass("activeslide");
				$(".slide3").addClass("activeslide");
			}
			if ($(window).scrollTop() >= nextSection) {
				 $(".bgw").css({
					"position":"",
					"top":"",
					"left":""
				 });
			}
		
		}
		else{
			 $(".bgw").css({
				 "position":"",
				 "top":"",
				 "left":""
			 });
		}
}

$(document).ready(function() {
	changeSlide();
	$(".containerloader").animate({
		opacity:0
	}, 1000, function() {
		$(".containerloader").hide();
	});
	$(window).scroll(function () {
		changeSlide();
	});
});
