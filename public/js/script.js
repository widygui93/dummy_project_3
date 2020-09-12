$(function(){
	$(".menu-btn").on('click',function(){
		// $(".menu-admin").toggleClass("aktif");
		if($(".menu-admin").hasClass('aktif')) {
			$(".menu-admin").removeClass('aktif');
			$(".menu-admin").addClass('inaktif');
		} else {
			$(".menu-admin").removeClass('inaktif');
			$(".menu-admin").addClass('aktif');
		} 
		$(".menu-btn").toggleClass("open");
		$(".header").toggleClass("open");
	});

});