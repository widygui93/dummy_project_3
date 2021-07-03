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
        $currentController = end($urlComponent) == "" ? "Latest_tutorial" : end($urlComponent);

        if ($currentController == "Dashboard_teacher") {
            $moreTutorials = $this->model('More_tutorial_model')->getMoreTutorialsBy($_SESSION['username_teacher'], $startIndexOfMoreTutorials);

            $twig = $this->view();
            echo $twig->render(
                '/tutorial/teacher/more.html.twig',
                [
                    'tutorials' => $moreTutorials,
                    'BASEURL' => BASEURL
                ]
            );
        } elseif ($currentController == "Search") {
            $moreTutorials = $this->model('More_tutorial_model')->getMoreTutorialsForSearch(strtolower($requestArrayData['keyword']), $startIndexOfMoreTutorials);

            $twig = $this->view();
            echo $twig->render(
                '/tutorial/more-tutorial.html.twig',
                [
                    'tutorials' => $moreTutorials,
                    'BASEURL' => BASEURL
                ]
            );
        } elseif (isset($_SESSION['login_teacher']) && $currentController == "Latest_tutorial") {
            $moreTutorials = $this->model('More_tutorial_model')->getMoreTutorials($startIndexOfMoreTutorials);

            $twig = $this->view();
            echo $twig->render(
                '/tutorial/tutorials.html.twig',
                [
                    'tutorials' => $moreTutorials,
                    'BASEURL' => BASEURL
                ]
            );
        } elseif ($currentController == "Dashboard_student") {
            // di sini nanti student punya tombol play di dashboard student

        } elseif (isset($_SESSION['login_student']) && $currentController == "Latest_tutorial") {
            // nanti di sini muncul view kumpulan tutorial yg ada tombol purchase aja

        } else {
            // tidak login apa pun dan berada di home page
            // klu tombol purchase di klik nanti minta login dulu sebagai student
            $moreTutorials = $this->model('More_tutorial_model')->getMoreTutorials($startIndexOfMoreTutorials);

            $twig = $this->view();
            echo $twig->render(
                '/tutorial/more-tutorial.html.twig',
                [
                    'tutorials' => $moreTutorials,
                    'BASEURL' => BASEURL
                ]
            );
        }
    }
}
