<?php

namespace Modules;

use Modules\CloudDiskProvider\Classes\YandexDisk as YandexDisk;

class CloudDiskProvider
{
    private array $avalibleProviders;

    public function __construct()
    {
        $this->avalibleProviders = ["yandex" => new YandexDisk()];
    }

    private function auth()
    {
        $accessCode = false;
        //TODO add crypt
        if (isset($_REQUEST['code']) && !isset($_COOKIE["access"])) {
            $accessCode = $this->avalibleProviders[$_REQUEST['provider']]->extractAccessCode($_REQUEST['code']);
            setcookie("access", $accessCode, time() + 3600, "/");
        } elseif (isset($_COOKIE["access"])) {
            $accessCode = $_COOKIE["access"];
        }
        $this->avalibleProviders[$_REQUEST['provider']]->setAccessCode($accessCode);
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
        $this->auth();
        $page = $_REQUEST['page'] ?? 1;

        if (isset($_REQUEST['provider'])) {
            if (isset($this->avalibleProviders[$_REQUEST['provider']])) {
                return $this->avalibleProviders[$_REQUEST['provider']]->showDiskContent($page);
            } else {
                return "Обласчный сервир дал неккоректный ответ!";
            }
        } else {
            return "Обласчный сервир дал неккоректный ответ!";
        }
    }

    public function renameFile($path, $newName, $oldName)
    {
        $this->auth();
        if (isset($_REQUEST['provider'])) {
            return $this->avalibleProviders[$_REQUEST['provider']]->renameFile($path, $newName, $oldName);
        }
        return false;
    }

    public function downloadFile($path): string
    {
        $this->auth();
        return $this->avalibleProviders[$_REQUEST['provider']]->downloadFile($path);
    }

    public function createNewFile()
    {
        $this->auth();
        $this->avalibleProviders[$_REQUEST['provider']]->createNewFile();
    }

    public function deleteFile($path)
    {
        $this->auth();
        $this->avalibleProviders[$_REQUEST['provider']]->deleteFile($path);
    }
}

