<?php
class Detail_tutorial extends Controller{
    public function index(){
        $requestJsonData = file_get_contents('php://input'); // data from axios request in json
        $requestArrayData = json_decode($requestJsonData, true); // convert json into php array
        $id = $requestArrayData['id'];
        $responseArrayData = $this->model('Detail_tutorial_model')->getDetailTutorialBy($id);
		$responseJsonData = json_encode($responseArrayData);
        echo $responseJsonData;
    }
}