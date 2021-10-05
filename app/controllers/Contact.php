<?php

class Contact extends Controller
{
    public function index()
    {
        $url = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : BASEURL;

        $result = $this->model('Contact_model')->sendMail($_POST);

        Flasher::setFlash($result['icon'], $result['title'], $result['text']);

        header('Location: ' . $url . '');
        exit;
    }
}
