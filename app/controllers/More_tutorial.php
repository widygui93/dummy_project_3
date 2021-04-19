<?php
class More_tutorial extends Controller{
    public function index(){
        if( $this->model('Verify_model')->isRequestDataEmpty(file_get_contents('php://input')) ) return $this->model('Verify_model')->goHome();
            $requestJsonData = file_get_contents('php://input'); // data from axios request in json
            $requestArrayData = json_decode($requestJsonData, true); // convert json into php array
            $row = $requestArrayData['row'];
            // if( $this->model('Detail_tutorial_model')->isIDNotUUID($id) ) echo "ID is invalid data type";
    
            // elseif( $this->model('Detail_tutorial_model')->isIdNotAvailable($id) ) echo "Tutorial is not available"; 
            
            // elseif( $this->model('Detail_tutorial_model')->isIneligibleTutorial($id) ) echo "Tutorial is not authorized to access";
    
            // else {
            //     $responseArrayData = $this->model('Detail_tutorial_model')->getDetailTutorialBy($id);
                // $responseJsonData = json_encode($responseArrayData);
                // echo $responseJsonData;
            // }

            $responseArrayData = $this->model('More_tutorial_model')->getMoreTutorial($_SESSION['username_teacher'],$row);

            $responseJsonData = json_encode($responseArrayData);
            echo $responseJsonData;

    }

}