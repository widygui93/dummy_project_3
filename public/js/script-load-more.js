$(function () {
  $(".load-more").click(function () {
    let currentDisplayTotalTutorial = Number(
      $("#current-display-total-tutorial").val()
    );
    let allTutorials = Number($("#all-tutorials").val());
    let tutorialsperpage = 4;
    currentDisplayTotalTutorial =
      currentDisplayTotalTutorial + tutorialsperpage;

    if (currentDisplayTotalTutorial < allTutorials) {
      $("#current-display-total-tutorial").val(currentDisplayTotalTutorial);

      // declare a request interceptor
      axios.interceptors.request.use(
        (config) => {
          // perform a task before the request is sent
          $(".load-more").text("Wait");
          $(".load-more").attr("disabled", "true");
          $(".load-more").css("cursor", "wait");
          return config;
        },
        (error) => {
          // handle the error
          return Promise.reject(error);
        }
      );

      // declare a response interceptor
      axios.interceptors.response.use(
        (response) => {
          // do something with the response data
          $(".load-more").removeAttr("disabled");
          $(".load-more").removeAttr("style");

          return response;
        },
        (error) => {
          // handle the response error
          return Promise.reject(error);
        }
      );

      axios({
        method: "post",
        url: "http://localhost/widy/project/dummy_project_3/public/More_tutorial",
        data: {
          currentDisplayTotalTutorial: currentDisplayTotalTutorial,
          keyword: $(".search-container").find("b").text(),
        },
      })
        .then((response) => {
          $(".tutorial-wrap").append(response.data);

          let totalTutorialsAfterMore =
            currentDisplayTotalTutorial + tutorialsperpage;

          // checking row value is greater than allcount or not
          if (totalTutorialsAfterMore >= allTutorials) {
            // Change the text and background
            $(".load-more").text("Hide");
          } else {
            $(".load-more").text("More");
          }
        })
        .catch((err) => console.error(err));
    } else {
      // Setting little delay while removing contents
      setTimeout(function () {
        // When row is greater than allcount then remove all class='tutorial' element after 4 element
        $(".tutorial:nth-child(4)").nextAll(".tutorial").remove();

        $("#current-display-total-tutorial").val(0);

        $(".load-more").text("More");
      }, 1000);
    }
  });
});
