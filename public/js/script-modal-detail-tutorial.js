$(function(){

    $('.tutorial-title').click(function(){
        $('#modalDetailTutorial').css("display", "block");
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

                let title = $("<p></p>").text('Title: ' .concat(tutorial.data[0].title));
                let desc = $("<p></p>").text('Desc: ' .concat(tutorial.data[0].description));
                let videoDuration = $("<p></p>").text('Duration: ' .concat(tutorial.data[0].video_duration));
                let createdBy = $("<p></p>").text('By: ' .concat(tutorial.data[0].created_by));
                let createdDate = $("<p></p>").text('Created on: ' .concat(tutorial.data[0].created_date));
                let prize = $("<p></p>").text('Prize: ' .concat(tutorial.data[0].prize));
                let likes = $("<p></p>").text('Total likes: ' .concat(tutorial.data[0].total_like));
                let purchased = $("<p></p>").text('Total purchased: ' .concat(tutorial.data[0].total_purchased));
                let level = $("<p></p>").text('Level: ' .concat(tutorial.data[0].level));
                let subtitle = $("<p></p>").text(tutorial.data[0].subtitle === null ? 'No for subtitle' : 'Yes for subtitle' );
                let imgCover = $('<img>', {src: '../app/core/videos/cover-img/' .concat(tutorial.data[0].img_cover)} );

                $(".detail-tutorial").append(title);
                $(".detail-tutorial").append(desc);
                $(".detail-tutorial").append(videoDuration);
                $(".detail-tutorial").append(createdBy);
                $(".detail-tutorial").append(createdDate);
                $(".detail-tutorial").append(prize);
                $(".detail-tutorial").append(likes);
                $(".detail-tutorial").append(purchased);
                $(".detail-tutorial").append(level);
                $(".detail-tutorial").append(subtitle);
                $(".detail-tutorial").append(imgCover);

                if( tutorial.data[0].tags.length > 0 ){
                    let tags = $("<ul></ul>");
                    tutorial.data[0].tags.forEach(
                        tag => $(tags).append($("<li></li>").text(tag))
                    );
                    $(".detail-tutorial").append(tags);
                }

            } 
        
        )
        .catch(err => console.error(err));

    });

    $('.close-detail-tutorial').click(function(){
        $('#modalDetailTutorial').css("display", "none");
        $('.detail-tutorial').empty();
    });

    // When the user clicks anywhere outside of the modal, close it
    const modalDetailTutorial = $("#modalDetailTutorial")[0];
    $(window).click(function(event){
        if (event.target == modalDetailTutorial) {
            $('#modalDetailTutorial').css("display", "none");
            $('.detail-tutorial').empty();
        }
    });
    // coba buat agar performance detail tutorial tidak delay karena ajax
    // tentukan tag dan definisi masing2 tag (done)
    // buat penjagaan utk controller detail_tutorial.php dari di akses di browser atau di source yg di devtool
    // coba ganti jquery dgn axios utk request data ke server (done)
});