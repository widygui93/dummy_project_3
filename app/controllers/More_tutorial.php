<?php
class More_tutorial extends Controller{
    public function index(){
        if( $this->model('Verify_model')->isRequestDataEmpty(file_get_contents('php://input')) ) return $this->model('Verify_model')->goHome();
        $requestJsonData = file_get_contents('php://input'); // data from axios request in json
        $requestArrayData = json_decode($requestJsonData, true); // convert json into php array
        $startIndexOfMoreTutorials = $requestArrayData['currentDisplayTotalTutorial'];

        $url = $_SERVER["HTTP_REFERER"];
        $urlComponent = explode("/", $url);
        $currentController = end($urlComponent);

        if(isset( $_SESSION['login_teacher'] )){
            if( $currentController == "Dashboard_teacher" ){
                $moreTutorials = $this->model('More_tutorial_model')->getMoreTutorialsBy($_SESSION['username_teacher'],$startIndexOfMoreTutorials);
                
                $twig = $this->view();
                echo $twig->render('/tutorial/more-tutorial-teacher.html.twig', 
                    [
                        'tutorials' => $moreTutorials,
                        'BASEURL' => BASEURL
                    ]
                );
            } else {
                // nanti di sini muncul view kumpulan tutorial yg tidak ada tombol apapun
                // echo "ini view bukan di dashboard";
                $moreTutorials = $this->model('More_tutorial_model')->getMoreTutorials($startIndexOfMoreTutorials);
                
                $twig = $this->view();
                echo $twig->render('/tutorial/tutorials.html.twig', 
                    [
                        'tutorials' => $moreTutorials,
                        'BASEURL' => BASEURL
                    ]
                );
            }
        } elseif(isset( $_SESSION['login_student'] )){
            if( $currentController == "Dashboard_student" ){
                // di sini nanti student punya tombol play di dashboard student

            } else {
                // nanti di sini muncul view kumpulan tutorial yg ada tombol purchase aja
            }

            echo "ini view student";

        } else {
            // nanti di sini muncul view kumpulan tutorial yg ada tombol purchase aja
            // klu tombol purchase di klik nanti minta login dulu sebagai student
            // echo "ini view kosong";
            $moreTutorials = $this->model('More_tutorial_model')->getMoreTutorials($startIndexOfMoreTutorials);
                
            $twig = $this->view();
            echo $twig->render('/tutorial/more-tutorial.html.twig', 
                [
                    'tutorials' => $moreTutorials,
                    'BASEURL' => BASEURL
                ]
            );
            
        }

    }

}