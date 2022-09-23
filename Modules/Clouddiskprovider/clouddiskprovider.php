<?php

namespace Modules;

use Modules\CloudDiskProvider\Classes\YandexDisk as YandexDisk;

class CloudDiskProvider
{
    const AUTHINTERFACE = "Modules\CloudDiskProvider\Interfaces\ICloudAuth";
    private $avalibleProviders = [];

    public function __construct()
    {
        $this->avalibleProviders = ["yandex" => new YandexDisk()];
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
        if (isset($_REQUEST['provider']) && isset($_REQUEST['code'])) {
            if (isset($this->avalibleProviders[$_REQUEST['provider']])) {
                $accessCode = $this->avalibleProviders[$_REQUEST['provider']]->extractAccessCode($_REQUEST['code']);
                return $this->avalibleProviders[$_REQUEST['provider']]->showDiskContent($accessCode);
            } else {
                return "Обласчный сервир дал неккоректный ответ!";
            }
        } else {
            return "Обласчный сервир дал неккоректный ответ!";
        }
    }
}

