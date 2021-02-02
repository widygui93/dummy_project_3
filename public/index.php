<?php
date_default_timezone_set("Asia/Jakarta");

if(!session_id()) session_start();

require_once '../app/init.php';

$app = new App;