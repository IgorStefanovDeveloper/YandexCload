<?php

namespace Controllers;

use Modules\CloudDiskProvider;

class IndexController
{
    protected RenderController $render;

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

    public function actionRename($path, $newName, $oldName)
    {
        $providers = new CloudDiskProvider();
        $providers->renameFile($path, $newName, $oldName);

        $this->reloadDisk($providers->getDiskContent());
    }

    public function actionDownload($path): string
    {
        $providers = new CloudDiskProvider();
        return $providers->downloadFile($path);
    }

    public function actionDelete($path)
    {
        $providers = new CloudDiskProvider();
        $providers->deleteFile($path);

        $this->reloadDisk($providers->getDiskContent());
    }

    public function actionLoad()
    {
        $providers = new CloudDiskProvider();
        $providers->createNewFile();

        $this->reloadDisk($providers->getDiskContent());
    }

    public function reloadDisk($content)
    {
        $this->render->renderTable($content);
    }
}