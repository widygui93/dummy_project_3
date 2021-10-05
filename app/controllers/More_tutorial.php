<?php
class More_tutorial extends Controller
{
    public function index()
    {
        if ($this->model('Verify_model')->isRequestDataEmpty(file_get_contents('php://input'))) return $this->model('Verify_model')->goHome();
        $requestJsonData = file_get_contents('php://input'); // data from axios request in json
        $requestArrayData = json_decode($requestJsonData, true); // convert json into php array
        $startIndexOfMoreTutorials = $requestArrayData['currentDisplayTotalTutorial'];

        $url = $_SERVER["HTTP_REFERER"];
        $urlComponent = explode("/", $url);
        $indexPublic = array_search('public', $urlComponent);
        $currentController = $urlComponent[(int)$indexPublic + 1] == "" ? "Latest_tutorial" :  $urlComponent[(int)$indexPublic + 1];

        $twig = $this->view();

        if ($currentController == "Dashboard_teacher") {
            $moreTutorials = $this->model('More_tutorial_model')->getMoreTutorialsBy($_SESSION['username_teacher'], $startIndexOfMoreTutorials);

            echo $twig->render(
                '/tutorial/teacher/more.html.twig',
                [
                    'tutorials' => $moreTutorials,
                    'BASEURL' => BASEURL
                ]
            );
        } elseif ($currentController == "Search") {
            $moreTutorials = $this->model('More_tutorial_model')->getMoreTutorialsForSearch(strtolower($requestArrayData['keyword']), $startIndexOfMoreTutorials);

            echo $twig->render($this->getAppropriateView(), ['tutorials' => $moreTutorials, 'BASEURL' => BASEURL]);
        } elseif ($currentController == "Latest_tutorial") {
            $moreTutorials = $this->model('More_tutorial_model')->getMoreTutorials($startIndexOfMoreTutorials);

            echo $twig->render($this->getAppropriateView(), ['tutorials' => $moreTutorials, 'BASEURL' => BASEURL]);
        } elseif ($currentController == "Best_seller_tutorial") {
            $moreTutorials = $this->model('More_tutorial_model')->getMoreTutorialsForBestSeller($startIndexOfMoreTutorials);

            echo $twig->render($this->getAppropriateView(), ['tutorials' => $moreTutorials, 'BASEURL' => BASEURL]);
        } elseif ($currentController == "Most_liked_tutorial") {
            $moreTutorials = $this->model('More_tutorial_model')->getMoreTutorialsForMostLiked($startIndexOfMoreTutorials);

            echo $twig->render($this->getAppropriateView(), ['tutorials' => $moreTutorials, 'BASEURL' => BASEURL]);
        } elseif ($currentController == "Tutorial_from_teacher") {
            $usernameTeacher = $urlComponent[(int)$indexPublic + 3];
            $moreTutorials = $this->model('More_tutorial_model')->getMoreTutorialsForTutorialFrom($startIndexOfMoreTutorials, $usernameTeacher);

            echo $twig->render($this->getAppropriateView(), ['tutorials' => $moreTutorials, 'BASEURL' => BASEURL]);
        } elseif ($currentController == "Dashboard_student") {
            // di sini nanti student punya tombol play di dashboard student

        } else {
            // tidak login apa pun dan berada di home page
            // klu tombol purchase di klik nanti minta login dulu sebagai student
            $moreTutorials = $this->model('More_tutorial_model')->getMoreTutorials($startIndexOfMoreTutorials);

            echo $twig->render(
                '/tutorial/student/more.html.twig',
                [
                    'tutorials' => $moreTutorials,
                    'BASEURL' => BASEURL
                ]
            );
        }
    }

    private function getAppropriateView(): string
    {
        return isset($_SESSION['login_teacher']) ? '/tutorial/bases/tutorial-only.html.twig' : '/tutorial/student/more.html.twig';
    }
}
