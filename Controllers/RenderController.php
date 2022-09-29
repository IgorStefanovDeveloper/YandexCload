<?php

namespace Controllers;

class RenderController
{

    public function renderAuth($providersList)
    {
        $title = "Авторизация";
        include __DIR__ . "/../view/header.php";
        include __DIR__ . "/../view/auth.php";
        include __DIR__ . "/../view/footer.php";
    }

    public function renderMain($content)
    {
        $title = "Главная";
        $currentPage = $_REQUEST['page'] ?? 1;
        $hasContent = is_array($content);
        if ($hasContent)
            $pageCount = ceil($content['count'] / $content['nav']);

        include __DIR__ . "/../view/header.php";
        include __DIR__ . "/../view/main.php";
        include __DIR__ . "/../view/footer.php";
    }

    public function renderTable($content)
    {
        include __DIR__ . "/../view/main.php";
    }

    public function getFileSize($bytes)
    {
        if ($bytes < 1000 * 1024) {
            return number_format($bytes / 1024, 2) . "KB";
        } elseif ($bytes < 1000 * 1048576) {
            return number_format($bytes / 1048576, 2) . "MB";
        } elseif ($bytes < 1000 * 1073741824) {
            return number_format($bytes / 1073741824, 2) . "GB";
        } else {
            return number_format($bytes / 1099511627776, 2) . "TB";
        }
    }
}