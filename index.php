<?php

use Controllers\IndexController;

require_once "vendor/autoload.php";

$indexController = new IndexController();

if(!isset($_GET['code'])){
    $indexController->actionAuth();
}else{
    $indexController->actionMain();
}