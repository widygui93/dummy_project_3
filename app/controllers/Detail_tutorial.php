<?php
class Detail_tutorial extends Controller{
    public function index(){
        $id = $_POST['id'];
        $detail = $this->model('Detail_tutorial_model')->getDetailTutorialBy($id);
		$detailJSON = json_encode($detail);
        echo $detailJSON;
    }
}