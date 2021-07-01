$(function () {
  $(document).on("click", ".tutorial-title", function () {
    $(".modalDetailTutorial").css("display", "block");
    $(".modal-content").addClass("shown-modal-content");
    let id = $(this).prev().text();
    axios({
      method: "post",
      url: "http://localhost/widy/project/dummy_project_3/public/Detail_tutorial",
      data: {
        id: id,
      },
    })
      .then((tutorial) => {
        $(".detail-tutorial").append(tutorial.data);
      })
      .catch((err) => console.error(err));
  });

  $(".close-detail-tutorial").click(function () {
    $(".modalDetailTutorial").css("display", "none");
    $(".modal-content").removeClass("shown-modal-content");
    $(".detail-tutorial").empty();
  });

  // When the user clicks anywhere outside of the modal, close it
  const modalDetailTutorial = $(".modalDetailTutorial")[0];
  $(window).click(function (event) {
    if (event.target == modalDetailTutorial) {
      $(".modalDetailTutorial").css("display", "none");
      $(".modal-content").removeClass("shown-modal-content");
      $(".detail-tutorial").empty();
    }
  });

  // ganti pagination dgn load more button (done)
  // revoke/restore tutorial (done)
  //  (kasih notif ke student yg pernah purchase tutorial tsb)
  //  (mesti tambahkan field is_revoke utk table tutorial agar bisa soft delete)
  //  (jika student sdh beli tutorial tsb maka tutorial tsb tidak terdelete di dashboard student)
  //  (tutorial tidak muncul di home,search view, dashboard teacher, latest, best seller dan most like tut)
  // edit prize dan desc dari tutorial
  //  (kasih notif ke student yg pernah purchase tutorial tsb)
  //  (prize dan desc berubah di  home,search view, dashboard teacher, latest, best seller dan most like tut)
  //  (prize dan desc juga berubah di dashboard student)
  //  (mesti tambahkan field purchase_amount di table purchased_tutorial agar tau pas beli di harga berapa,tidak jadi field ini karena di dashboard student juga berubah)
  // perbaikan list dari tutorial di home dgn data dari DB (done)
  // buat contact us berfungsi dgn phpmailer
  // jika teacher update, revoke dan restore tutorial maka student yg membeli tutorial tsb dpt notif
  // jika student beli dan like suatu tutorial. maka teacher yg buat itu tutorial dpt notif
  // terapkan fuzzy algoritma di fitur search (done)
});
