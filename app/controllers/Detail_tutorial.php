<?php
class Detail_tutorial extends Controller{
    public function index(){
        if( $this->model('Verify_model')->isRequestDataEmpty(file_get_contents('php://input')) ) return $this->model('Verify_model')->goHome();
        $requestJsonData = file_get_contents('php://input'); // data from axios request in json
        $requestArrayData = json_decode($requestJsonData, true); // convert json into php array
        $id = $requestArrayData['id'];

        $responseResultTemplate = $this->model('Detail_tutorial_model')->getDetailTutorialBy($id);
        echo $responseResultTemplate;
        
    }
}