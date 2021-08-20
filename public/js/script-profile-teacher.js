$(function () {
  $(document).on("click", "#change-password", function () {
    $(".modalChangePassword").css("display", "block");
    $(".modal-content").addClass("shown-modal-content");
  });

  $(".close-change-password").click(function () {
    $(".modalChangePassword").css("display", "none");
    $(".modal-content").removeClass("shown-modal-content");
  });

  // When the user clicks anywhere outside of the modal, close it
  const modalChangePassword = $(".modalChangePassword")[0];
  $(window).click(function (event) {
    if (event.target == modalChangePassword) {
      $(".modalChangePassword").css("display", "none");
      $(".modal-content").removeClass("shown-modal-content");
    }
  });
});
