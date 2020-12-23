$(function(){
    let slideIndex = 1;
	showSlides(slideIndex);

	function showSlides(n) {
		let i;
		const SLIDE_TESTI = document.getElementsByClassName("testi");
		if (n > SLIDE_TESTI.length) {slideIndex = 1}    
		if (n < 1) {slideIndex = SLIDE_TESTI.length}
		for (i = 0; i < SLIDE_TESTI.length; i++) {
			SLIDE_TESTI[i].style.display = "none";  
		}
		SLIDE_TESTI[slideIndex-1].style.display = "block";  
	}

	$(".next").on('click',function(){
		showSlides(slideIndex += 1);
	});

	$(".prev").on('click',function(){
		showSlides(slideIndex -= 1);
	});

	let slideTeacher = 1;
	showSlidesTeacher(slideTeacher);

	function showSlidesTeacher(n) {
		let i;
		const SLIDE_TEACHER = document.getElementsByClassName("teacher");
		if (n > SLIDE_TEACHER.length) {slideTeacher = 1}    
		if (n < 1) {slideTeacher = SLIDE_TEACHER.length}
		for (i = 0; i < SLIDE_TEACHER.length; i++) {
			SLIDE_TEACHER[i].style.display = "none";  
		}
		SLIDE_TEACHER[slideTeacher-1].style.display = "block";  
	}

	$(".next-teacher").on('click',function(){
		showSlidesTeacher(slideTeacher += 1);
	});

	$(".prev-teacher").on('click',function(){
		showSlidesTeacher(slideTeacher -= 1);
	});

	$(".tab-conven").on('click',function(){
		$(".conven-feature").removeClass("close");
		$(".conven-feature").addClass("open");
		$(".unemi-feature").removeClass("open");
		$(".unemi-feature").addClass("close");
	});
	$(".tab-unemi").on('click',function(){
		$(".unemi-feature").removeClass("close");
		$(".unemi-feature").addClass("open");
		$(".conven-feature").removeClass("open");
		$(".conven-feature").addClass("close");
	});

});