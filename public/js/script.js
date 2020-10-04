$(function(){
	$(".menu-btn").on('click',function(){
		$(".menu-btn").toggleClass("open");
		$(".header").toggleClass("open");
		$(".menu-navbar").toggleClass("open");
		$(".login-signup-wrapper").toggleClass("open");
	});

	let slideIndex = 1;
	showSlides(slideIndex);

	function showSlides(n) {
		let i;
		const slides = document.getElementsByClassName("testi");
		if (n > slides.length) {slideIndex = 1}    
		if (n < 1) {slideIndex = slides.length}
		for (i = 0; i < slides.length; i++) {
			slides[i].style.display = "none";  
		}
		slides[slideIndex-1].style.display = "block";  
	}

	$(".next").on('click',function(){
		showSlides(slideIndex += 1);
	});

	$(".prev").on('click',function(){
		showSlides(slideIndex -= 1);
	});

});