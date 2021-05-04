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

	$("#desc").val("");
	
	$("#desc").keyup(function(){
		$(".length-desc").text( $("#desc").val().length );
	});

	$('.restore-button').click(function(e){
        // console.log('this is restore button');
        // swal("this is restore button");
		let idTut = $(this).parent().parent().prev().children(".info-1").children('span:first').text();
		
		swal({
            title: "Are you sure to restore?",
            text: "Once restore, Students can find this tutorial.",
            icon: "warning",
            buttons: [true, "Yeah"]
          })
		.then((willRestore) => {
			if (willRestore) {
				axios({
					method: 'post',
					url: 'http://localhost/widy/project/dummy_project_3/public/Dashboard_teacher/restore',
					data: { id: idTut }
				})
				.then(
					response => {
						swal({
							title: response.data.title,
							text: response.data.text,
							icon: response.data.icon,
							buttons: [false, true]
						})
						.then( () => location.reload() );
					}
				)
				.catch(err => console.error(err));
			}
		});
        e.preventDefault();

    });

    $('.revoke-button').click(function(e){
		let idTut = $(this).parent().parent().prev().children(".info-1").children('span:first').text();

        swal({
            title: "Are you sure to revoke?",
            text: "Once revoked, Students cannot find this tutorial unless they have bought it.",
            icon: "warning",
            buttons: [true, "Yeah"]
          })
		.then((willDelete) => {
			if (willDelete) {
				axios({
					method: 'post',
					url: 'http://localhost/widy/project/dummy_project_3/public/Dashboard_teacher/revoke',
					data: { id: idTut }
				})
				.then(
					response => {
						swal({
							title: response.data.title,
							text: response.data.text,
							icon: response.data.icon,
							buttons: [false, true]
						})
						.then( () => location.reload() );
					}
				)
				.catch(err => console.error(err));
			}
		});
        e.preventDefault();
    });

});