$(function(){

    $('.tutorial-title').click(function(){
        $('#modalDetailTutorial').css("display", "block");
        let id = $(this).prev().text();
        let url = $(this).prev().prev().text();
        $.post(url,{ id:id }, function(data, status){
            let tutorial = JSON.parse(data);

            let title = $("<p></p>").text('Title: ' .concat(tutorial.title));
            let desc = $("<p></p>").text('Desc: ' .concat(tutorial.description));
            let videoDuration = $("<p></p>").text('Duration: ' .concat(tutorial.video_duration));
            let createdBy = $("<p></p>").text('By: ' .concat(tutorial.created_by));
            let createdDate = $("<p></p>").text('Created on: ' .concat(tutorial.created_date));
            let prize = $("<p></p>").text('Prize: ' .concat(tutorial.prize));
            let likes = $("<p></p>").text('Total likes: ' .concat(tutorial.total_like));
            let purchased = $("<p></p>").text('Total purchased: ' .concat(tutorial.total_purchased));
            let level = $("<p></p>").text('Level: ' .concat(tutorial.level));
            let subtitle = $("<p></p>").text(tutorial.subtitle === null ? 'No for subtitle' : 'Yes for subtitle' );
            let imgCover = $('<img>', {src: '../app/core/videos/cover-img/' .concat(tutorial.img_cover)} );

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
        });
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
    // tentukan tag dan definisi masing2 tag

});