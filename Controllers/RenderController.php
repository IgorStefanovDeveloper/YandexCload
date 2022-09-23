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
        include __DIR__ . "/../view/header.php";
        include __DIR__ . "/../view/main.php";
        include __DIR__ . "/../view/footer.php";
    }

}