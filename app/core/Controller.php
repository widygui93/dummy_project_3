<?php

class Controller {
	public function view(){
		$loader = new \Twig\Loader\FilesystemLoader('../app/views');
		return new \Twig\Environment($loader);
	}
	public function model($model){
		require_once '../app/models/' . $model . '.php';

		return new $model;

	}
}