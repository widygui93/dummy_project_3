<?php
class More_tutorial extends Controller{
    public function index(){
        if( $this->model('Verify_model')->isRequestDataEmpty(file_get_contents('php://input')) ) return $this->model('Verify_model')->goHome();
            $requestJsonData = file_get_contents('php://input'); // data from axios request in json
            $requestArrayData = json_decode($requestJsonData, true); // convert json into php array
            $startIndexOfMoreTutorials = $requestArrayData['currentDisplayTotalTutorial'];

            $responseArrayData = $this->model('More_tutorial_model')->getMoreTutorial($_SESSION['username_teacher'],$startIndexOfMoreTutorials);
            $responseJsonData = json_encode($responseArrayData);
            echo $responseJsonData;

    }

}