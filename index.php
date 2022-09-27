<?php

use Controllers\IndexController;

require_once "vendor/autoload.php";

$indexController = new IndexController();
if (isset($_REQUEST['action'])) {
    if ($_REQUEST['action'] == "rename") {
        $path = $_REQUEST['path'] ?? false;
        $newName = $_REQUEST['newName'] ?? false;
        $oldName = $_REQUEST['oldName'] ?? false;
        $indexController->actionRename($path, $newName, $oldName);
    }
    if ($_REQUEST['action'] == "download") {
        $path = $_REQUEST['path'] ?? false;
        echo $indexController->actionDownload($path);
    }
    if ($_REQUEST['action'] == "delete") {
        $path = $_REQUEST['path'] ?? false;
        echo $indexController->actionDelete($path);
    }
    if ($_REQUEST['action'] == "load") {
        $path = $_REQUEST['path'] ?? false;
        echo $indexController->actionLoad();
    }
    exit;
}
if (!isset($_REQUEST['provider'])) {
    $indexController->actionAuth();
} else {
    $indexController->actionMain();
}