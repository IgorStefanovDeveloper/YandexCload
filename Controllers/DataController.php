<?php

namespace Controllers;

use Modules\CloudDiskProvider;

class DataController
{
    public function getDataForAuthPage(): array
    {
        $providers = new CloudDiskProvider();
        $providersList = $providers->getListOfAvailableProviders();

        return [
            'template' => 'auth.twig',
            'title' => 'Авторизация',
            'providersList' => $providersList
        ];
    }

    public function getDataForContentPage($queryData, $args): array
    {
        $code = $queryData['code'] ?? false;

        $providers = new CloudDiskProvider($code, $args['provider']);
        $content = $providers->getDiskContent();

        if (isset($content['status']) && $content['status'] === false) {
            $data = [
                'title' => 'Ошибка',
                'text' => $content['content'],
                'template' => 'error.twig'
            ];
        } else {
            $data = $this->prepareData($args['provider'], $content);

            $data['title'] = $args['provider'] . ' диск';
            $data['template'] = "provider.twig";
        }

        return $data;
    }

    public function getDataForAjax($queryData, $args):array {
        $providers = new CloudDiskProvider(false, $args['provider']);

        $path = $queryData['path'] ?? false;

        $needReload = true;

        switch ($args['action']) {
            case "rename":
                $newName = $queryData['newName'] ?? false;
                $oldName = $queryData['oldName'] ?? false;

                $providers->renameFile($path, $newName, $oldName);
                break;
            case "download":
                $needReload = false;

                $data['content'] = $providers->downloadFile($path);
                break;
            case "delete":
                $providers->deleteFile($path);
                break;
            case "load":
                $providers->createNewFile($_FILES['file']);
                break;
        }

        if ($needReload) {
            $content = $providers->getDiskContent();

            $data = $this->prepareData($args['provider'], $content);
            $data['template'] = "ajaxRefreshTable.twig";
        }

        $data['needReload'] = $needReload;

        return $data;
    }

    private function prepareData($provider, $content): array
    {
        $data = [];

        $currentPage = $_REQUEST['page'] ?? 1;
        $hasContent = is_array($content);
        $pageCount = 1;

        if ($hasContent) {
            $pageCount = ceil($content['count'] / $content['nav']);
        }

        $data['provider'] = $provider;
        $data['pageCount'] = $pageCount;
        $data['content'] = $content;
        $data['currentPage'] = $currentPage;

        return $data;
    }
}