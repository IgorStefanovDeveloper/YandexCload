<?php

namespace Modules;

use Modules\CloudDiskProvider\Classes\YandexDisk;
use Modules\CloudDiskProvider\Classes\ProviderException;

class CloudDiskProvider
{
    private array $avalibleProviders;

    public function __construct()
    {
        $this->avalibleProviders = ["yandex" => new YandexDisk()];
    }

    private function auth()
    {
        if (isset($_REQUEST['provider'])) {
            if (!array_key_exists($_REQUEST['provider'], $this->avalibleProviders))
                return "Не задан поставщик данных, попробуйте авторизоваться повторно.";
        } else
            return "Не задан поставщик данных, попробуйте авторизоваться повторно.";

        $accessCode = false;
        //TODO add crypt
        if (isset($_REQUEST['code']) && !isset($_COOKIE["access"]) && $_REQUEST['provider']) {
            try {
                $accessCode = $this->avalibleProviders[$_REQUEST['provider']]->extractAccessCode($_REQUEST['code']);
                setcookie("access", $accessCode, time() + 3600, "/");
            } catch (CustomException $e) {
                echo $e->getMessage();
            }
        } elseif (isset($_COOKIE["access"])) {
            $accessCode = $_COOKIE["access"];
        }
        if ($this->avalibleProviders[$_REQUEST['provider']]->setAccessCode($accessCode) == "")
            return "Неудачная авторизация";
        return true;
    }

    protected function checkAuth():bool
    {
        $result = true;
        try {
            $authResult = $this->auth();
            if ($authResult !== true) throw new ProviderException($authResult, 123);
        } catch (ProviderException $e) {
            $result = false;
            echo $e;
        } finally {
            return $result;
        }
    }

    public function getListOfAvailableProviders(): array
    {
        $authArr = [];
        foreach ($this->avalibleProviders as $prov) {
            $authArr[] = ['link' => $prov->getAuthLink(), 'label' => $prov->getProviderLabel()];
        }

        return $authArr;
    }

    public function getDiskContent()
    {
        if($this->checkAuth() === false) return false;
        $page = $_REQUEST['page'] ?? 1;
        return $this->avalibleProviders[$_REQUEST['provider']]->showDiskContent($page);
    }

    public function renameFile($path, $newName, $oldName)
    {
        if($this->checkAuth() === false) return false;
        return $this->avalibleProviders[$_REQUEST['provider']]->renameFile($path, $newName, $oldName);
    }

    public function downloadFile($path): string
    {
        if($this->checkAuth() === false) return false;
        return $this->avalibleProviders[$_REQUEST['provider']]->downloadFile($path);
    }

    public function createNewFile()
    {
        if($this->checkAuth() === false) return false;
        $this->avalibleProviders[$_REQUEST['provider']]->createNewFile();
    }

    public function deleteFile($path)
    {
        if($this->checkAuth() === false) return false;
        $this->avalibleProviders[$_REQUEST['provider']]->deleteFile($path);
    }
}

