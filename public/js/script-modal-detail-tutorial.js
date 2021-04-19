$(function(){

    $(document).on("click", ".tutorial-title", function () {
        $('.modalDetailTutorial').css("display", "block");
        $('.modal-content').addClass("shown-modal-content");
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
                    let videoDuration = $("<p class='duration'></p>").text('Duration: ' + tutorial.data[0].video_duration);
                    let createdByContainer = $("<div class='createdby-container'></div>")
                                                .append('<span class="label-by">By </span>')
                                                .append( $("<a href='#' class='created-by'></a>").text(tutorial.data[0].created_by) );
                    let createdDate = $("<p class='created-dt'></p>").text('Created on: ' + tutorial.data[0].created_date);
                    let prizeContainer = $("<div class='prize-container'></div>")
                                                .append("<img src='http://localhost/widy/project/dummy_project_3/public/svg/green_dollar_icon.svg' class='dollar-logo' alt='cost'>")
                                                .append( $("<span class='prize'></span>").text(tutorial.data[0].prize) );
                    let likeContainer = $("<div class='like-container'></div>")
                                                .append("<img src='http://localhost/widy/project/dummy_project_3/public/svg/Green_Heart_Icon.svg' class='like-logo' alt='like'>")
                                                .append( $("<p></p>").text(tutorial.data[0].total_like + ' Likes') );
                    let purchased = $("<p class='purchased-by'></p>").text('Purchased By: ' + tutorial.data[0].total_purchased + ' Students');
                    let level = $("<p class='level'></p>").text('Level: ' + tutorial.data[0].level);
                    let subtitle = $("<span></span>").text('Subtitle').addClass(tutorial.data[0].subtitle === null ? 'without-subtitle' : 'with-subtitle' );
                    let imgCover = $('<img>', {src: '../app/core/videos/cover-img/' + tutorial.data[0].img_cover} ).addClass('img-cover');

                    $(".detail-tutorial").append(imgCover);
                    $(".detail-tutorial").append(title);
                    $(".detail-tutorial").append(createdByContainer);
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
                            tag => {
                                if( tag == "Latest Tutorial" ) $(tags).append("<li><a href='#'>Latest Tutorial</a></li>")
                                if( tag == "Best Seller" )     $(tags).append("<li><a href='#'>Best Seller</a></li>")
                                if( tag == "Most Liked" )      $(tags).append("<li><a href='#'>Most Liked</a></li>")
                            }
                        );
                        let tagsContainer = $("<div class='tags-container'></div>")
                                                .append('<p class="label-tags">Tags:</p>')
                                                .append(tags);
                        $(".detail-tutorial").append(tagsContainer);
                    }
                    let descContainer = $("<div class='desc-container'></div>")
                                            .append('<p class="label-desc">Desc:</p>')
                                            .append(desc);
                    $(".detail-tutorial").append(descContainer);
                }
            } 
        )
        .catch(err => console.error(err));

    });

    $('.close-detail-tutorial').click(function(){
        $('.modalDetailTutorial').css("display", "none");
        $('.modal-content').removeClass("shown-modal-content");
        $('.detail-tutorial').empty();
    });

    // When the user clicks anywhere outside of the modal, close it
    const modalDetailTutorial = $(".modalDetailTutorial")[0];
    $(window).click(function(event){
        if (event.target == modalDetailTutorial) {
            $('.modalDetailTutorial').css("display", "none");
            $('.modal-content').removeClass("shown-modal-content");
            $('.detail-tutorial').empty();
        }
    });

    $('.load-more').click(function(){
        let row = Number($('#row').val());
        let allcount = Number($('#all').val());
        let tutorialsperpage = 4;
        row = row + tutorialsperpage;

        if(row < allcount){
            $("#row").val(row);

            // Add a request interceptor
            // axios.interceptors.request.use(function () {
            //     $(".load-more").text("Loading...");
            // }, function (error) {
            //     return Promise.reject(error);
            // });

            axios({
                method: 'post',
                url: 'http://localhost/widy/project/dummy_project_3/public/More_tutorial',
                data: { row: row }
            })
            .then(

                response => {

                    // Setting little delay while displaying new content
                    setTimeout(function() {

                        let tutorialElement, tutorialVideo, tutorialInfo, info1, info2, tutorialPlay, playButton, playInfo, tutorialLike, tutorialCost;

                        response.data.forEach(
                            
                            element => {

                                tutorialVideo = $("<div class='tutorial-video'></div>")
                                                    .append( $("<img alt='video-poster'>").attr("src", "../app/core/videos/cover-img/" + element.img_cover) );
                                
                                tutorialInfo = $("<div class='tutorial-info'></div>");

                                info1 = $("<div class='info-1'>").append( $("<span style='display: none;'>").text(element.id) );
                                info1.append( $("<span class='tutorial-title'>").append( $("<a></a>").text(element.title) ) );
                                info1.append( $("<span class='tooltiptext'>").text("Click for details") );
                                tutorialInfo.append(info1);

                                info2 = $("<div class='info-2'>");
                                info2.append( $("<span class='tutorial-author'>").text("By " + element.created_by) );
                                info2.append( $("<small class='tutorial-date'>").text(element.created_date) );
                                tutorialInfo.append(info2);

                                tutorialPlay = $("<div class='tutorial-play'>");
                                playButton = $("<div class='play-button'>").append( $("<a href='#'>Play</a>") );
                                tutorialPlay.append(playButton);

                                playInfo = $("<div class='play-info'>");
                                tutorialLike = $("<span class='tutorial-like'>").append( $("<img src='http://localhost/widy/project/dummy_project_3/public/svg/Green_Heart_Icon.svg' alt='like'>") );
                                tutorialLike.append( $("<span></span>").text(element.total_like) );

                                tutorialCost = $("<span class='tutorial-cost'>").append( $("<img src='http://localhost/widy/project/dummy_project_3/public/svg/green_dollar_icon.svg' alt='like'>") );
                                tutorialCost.append( $("<span></span>").text(element.prize) );

                                playInfo.append(tutorialLike);
                                playInfo.append(tutorialCost);

                                tutorialPlay.append(playInfo);


                                tutorialElement = $("<div class='tutorial'></div>").append(tutorialVideo);
                                tutorialElement.append(tutorialInfo);
                                tutorialElement.append(tutorialPlay);

                                $(".tutorial-wrap").append(tutorialElement);

                            }  
                        
                        );

                        let rowno = row + tutorialsperpage;

                        // checking row value is greater than allcount or not
                        if(rowno >= allcount){

                            // Change the text and background
                            $('.load-more').text("Hide");
                        }else{
                            $(".load-more").text("More");
                        }
                    }, 1000);

                }
            )
            .catch(err => console.error(err));
        } 
        else {
            // Setting little delay while removing contents
            setTimeout(function() {

                // When row is greater than allcount then remove all class='tutorial' element after 4 element
                $('.tutorial:nth-child(4)').nextAll('.tutorial').remove();

                $("#row").val(0);

                $('.load-more').text("More");
                
            }, 1000);
        }

    });

    // ganti pagination dgn load more button (done)
    // delete tutorial
    // edit prize, level dan desc dari tutorial
    // perbaikan list dari tutorial di home dgn data dari DB
});