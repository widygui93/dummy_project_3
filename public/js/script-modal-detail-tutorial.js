$(function(){
	  
	// Get the modal
    // let modal = $('#modalDetailTutorial');

    $('.tutorial-title').click(function(){
        $('#modalDetailTutorial').css("display", "block");
        // $(".detail-tutorial").append(" <b>Appended text</b>.");
        let title = $("<p></p>").text($(this).find('a').text());
        let createdBy = $("<p></p>").text($(this).parent().next().find('span').text());
        let createdDate = $("<p></p>").text($(this).parent().next().find('small').text());
        let prize = $("<p></p>").text($(this).parent().parent().next().find('.tutorial-cost').children('span').text());
        let likes = $("<p></p>").text($(this).parent().parent().next().find('.tutorial-like').children('span').text());
        let imgCoverSrc = $(this).parent().parent().prev().find('img').attr("src");
        let imgCover = $('<img>', {src: imgCoverSrc} );
        // $(".detail-tutorial").text(title);
        $(".detail-tutorial").append(title);
        $(".detail-tutorial").append(createdBy);
        $(".detail-tutorial").append(createdDate);
        $(".detail-tutorial").append(prize);
        $(".detail-tutorial").append(likes);
        $(".detail-tutorial").append(imgCover);
    });

    $('.close-detail-tutorial').click(function(){
        $('#modalDetailTutorial').css("display", "none");
        $('.detail-tutorial').empty();
    });

    // When the user clicks anywhere outside of the modal, close it
    // window.onclick = function(event) {
    //     if (event.target == modal) {
    //         modal.style.display = "none";
            
    //     }
    //     // $('#modalDetailTutorial').css("display", "none");
    // }

});