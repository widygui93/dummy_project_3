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

	$(document).on("click", ".restore-button", function (e) {
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

    $(document).on("click", ".revoke-button", function (e) {
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

	$(document).on("click", ".update-button", function(e){

		let idTut = $(this).parent().parent().prev().children(".info-1").children('span:first').text();

        axios({
            method: 'post',
            url: 'http://localhost/widy/project/dummy_project_3/public/Dashboard_teacher/getDataToDisplayBeforeUpdate',
            data: { id: idTut }
        })
        .then(
            
            response => {

				if(response.data.title == "Failed"){
					swal({
						title: response.data.title,
						text: response.data.text,
						icon: response.data.icon,
						buttons: [false, true]
					})
					.then( () => location.reload() );
				} else {

					// let prizeValueForUpdate = response.data.dataTutorial[0].prize.trim();
					// let descValueForUpdate = response.data.dataTutorial[0].description;
					
					let updateWrapper = document.createElement("div");
					let prizeWrapper = document.createElement("div");
					let descWrapper = document.createElement("div");
					let prizeLabel = document.createElement("label");
					let descLabel = document.createElement("label");
					let prizeInputUpdate = document.createElement("input");
					let descTextAreaUpdate = document.createElement("textarea");

					$(updateWrapper).addClass("update-tutorial-wrapper");
					$(prizeInputUpdate).val(response.data.dataTutorial[0].prize.trim());
					$(descTextAreaUpdate).val(response.data.dataTutorial[0].description);
					$(prizeInputUpdate).addClass("update-prize");
					$(descTextAreaUpdate).addClass("update-desc");
					$(prizeLabel).text("Prize");
					$(descLabel).text("Description");

					$(prizeWrapper).append(prizeLabel);
					$(prizeWrapper).append(prizeInputUpdate);

					$(descWrapper).append(descLabel);
					$(descWrapper).append(descTextAreaUpdate);

					$(updateWrapper).append(prizeWrapper);
					$(updateWrapper).append(descWrapper);

					swal({
						icon: response.data.icon,
						title: response.data.title,
						content: updateWrapper,
						buttons: [true, "Update"]
					})
					.then((willUpdate) => {
						// console.log($(".update-prize").val());
						// console.log($(".update-desc").val());
						if (willUpdate) {
							axios({
								method: 'post',
								url: 'http://localhost/widy/project/dummy_project_3/public/Dashboard_teacher/update',
								data: { 
									id	 : idTut,
									prize: $(".update-prize").val(),
									desc : $(".update-desc").val()
								}
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
				}

            } 
        )
        .catch(err => console.error(err));

		e.preventDefault();
	});

});