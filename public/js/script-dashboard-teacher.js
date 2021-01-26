$(function(){
	  
	$("#img-cover-input").change(function() {
		if (this.files && this.files[0]) {
			let reader = new FileReader();
			
			reader.onload = function(e) {
			  $('#img-cover').attr('src', e.target.result);
			}
			
			reader.readAsDataURL(this.files[0]); // convert to base64 string
		  }
	});

	$("#video").change(function() {
		let $source = $('#vid-src');
		$source[0].src = URL.createObjectURL(this.files[0]);
		$source.parent()[0].poster = '';
		$source.parent()[0].load();
	});

});