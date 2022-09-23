<?php

namespace Controllers;

use Modules\CloudDiskProvider;

class IndexController
{
    protected $render;

    public function __construct()
    {
        $this->render = new RenderController();
    }

    public function actionAuth()
    {
        $providers = new CloudDiskProvider();
        $providersList = $providers->getListOfAvailableProviders();
        $this->render->renderAuth($providersList);
    }

    public function actionMain()
    {
        $providers = new CloudDiskProvider();
        $this->render->renderMain($providers->getDiskContent());
    }
}