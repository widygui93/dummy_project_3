$(function(){

    $('.tutorial-title').click(function(){
        $('.modalDetailTutorial').css("display", "block");
        let id = $(this).prev().text();
        axios({
            method: 'post',
            url: 'http://localhost/widy/project/dummy_project_3/public/Detail_tutorial',
            data: {
                id: id
            }
        })
        .then(
            
            tutorial => {

                if( tutorial.data == 'ID is invalid data type' ){

                    let msg = $("<p></p>").text('ID is invalid data type');
                    $(".detail-tutorial").append(msg);

                } else if( tutorial.data == 'Tutorial is not available' ){

                    let msg = $("<p></p>").text('Tutorial is not available');
                    $(".detail-tutorial").append(msg);

                } else if( tutorial.data == 'Tutorial is not authorized to access' ){

                    let msg = $("<p></p>").text('Tutorial is not authorized to access');
                    $(".detail-tutorial").append(msg);

                } else {

                    let title = $("<h3 class='title'></h3>").text(tutorial.data[0].title);
                    let desc = $("<p class='description'></p>").text(tutorial.data[0].description);
                    let videoDuration = $("<p></p>").text('Duration: ' + tutorial.data[0].video_duration);
                    let createdBy = $("<a href='#' class='created-by'></a>").text(tutorial.data[0].created_by);
                    let createdDate = $("<p></p>").text('Created on: ' + tutorial.data[0].created_date);
                    let dollarLogo = $("<img src='http://localhost/widy/project/dummy_project_3/public/svg/green_dollar_icon.svg' class='dollar-logo' alt='cost'>");
                    let prize = $("<span class='prize'></span>").text(tutorial.data[0].prize);
                    let prizeContainer = $("<div class='prize-container'></div>").append(dollarLogo).append(prize);
                    let logoLikes = $("<img src='http://localhost/widy/project/dummy_project_3/public/svg/Green_Heart_Icon.svg' class='like-logo' alt='like'>");
                    let likes = $("<p></p>").text(tutorial.data[0].total_like + ' Likes');
                    let likeContainer = $("<div class='like-container'></div>").append(logoLikes).append(likes);
                    let purchased = $("<p></p>").text('Purchased By: ' + tutorial.data[0].total_purchased + ' Students');
                    let level = $("<p></p>").text('Level: ' + tutorial.data[0].level);
                    let subtitle = $("<span></span>").text('Subtitle').addClass(tutorial.data[0].subtitle === null ? 'without-subtitle' : 'with-subtitle' );
                    let imgCover = $('<img>', {src: '../app/core/videos/cover-img/' + tutorial.data[0].img_cover} ).addClass('img-cover');

                    $(".detail-tutorial").append(imgCover);
                    $(".detail-tutorial").append(title);
                    $(".detail-tutorial").append('<span>By </span>');
                    $(".detail-tutorial").append(createdBy);
                    $(".detail-tutorial").append(prizeContainer);
                    $(".detail-tutorial").append(likeContainer);
                    $(".detail-tutorial").append(level);
                    $(".detail-tutorial").append(purchased);
                    $(".detail-tutorial").append(createdDate);
                    $(".detail-tutorial").append(videoDuration);
                    $(".detail-tutorial").append(subtitle);

                    if( tutorial.data[0].tags.length > 0 ){
                        let tags = $("<ul class='tags'></ul>");
                        tutorial.data[0].tags.forEach(
                            tag => $(tags).append($("<li></li>").text(tag))
                        );
                        $(".detail-tutorial").append('<p>Tags:</p>');
                        $(".detail-tutorial").append(tags);
                    }
                    $(".detail-tutorial").append('<p>Desc:</p>');
                    $(".detail-tutorial").append(desc);
                }
            } 
        )
        .catch(err => console.error(err));

    });

    $('.close-detail-tutorial').click(function(){
        $('.modalDetailTutorial').css("display", "none");
        $('.detail-tutorial').empty();
    });

    // When the user clicks anywhere outside of the modal, close it
    const modalDetailTutorial = $(".modalDetailTutorial")[0];
    $(window).click(function(event){
        if (event.target == modalDetailTutorial) {
            $('.modalDetailTutorial').css("display", "none");
            $('.detail-tutorial').empty();
        }
    });
    // coba buat agar performance detail tutorial tidak delay karena ajax
    // buat pagination
    // kasih style utk data detail tutorial
    // buat limit karakter di field description dan kasih live counting down saat typing
    // buat pake twig
});