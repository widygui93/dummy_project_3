$(function(){

    $(".menu-btn").on('click',function(){
		$(".menu-btn").toggleClass("open");
		$(".menu-navbar").toggleClass("open");
		$(".login-signup-wrapper").toggleClass("open");
		$(".logout-wrapper").toggleClass("open");
	});

});