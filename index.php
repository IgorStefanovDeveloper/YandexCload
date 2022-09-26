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
    exit;
}
if (!isset($_REQUEST['provider'])) {
    $indexController->actionAuth();
} else {
    $indexController->actionMain();
}