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
                $moreTutorials = $this->model('More_tutorial_model')->getMoreTutorial($_SESSION['username_teacher'],$startIndexOfMoreTutorials);
                
                $twig = $this->view();
                echo $twig->render('/tutorial/more-tutorial-teacher.html.twig', 
                    [
                        'tutorials' => $moreTutorials,
                        'BASEURL' => BASEURL
                    ]
                );
            } else {
                echo "ini view bukan di dashboard";
            }
        } elseif(isset( $_SESSION['login_student'] )){

            echo "ini view student";

        } else {
            echo "ini view kosong";
            
        }

    }

}