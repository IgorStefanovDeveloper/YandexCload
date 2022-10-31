<?php

namespace Modules;

use Modules\CloudDiskProvider\Classes\YandexDisk;
use Modules\CloudDiskProvider\Classes\ProviderException;

class CloudDiskProvider
{
    private array $avalibleProviders;
    private string $currentProvider;

    public function __construct($code = false, $provider = false)
    {
        $this->avalibleProviders = ["yandex" => new YandexDisk()];

        if ($provider !== false) {
            $this->currentProvider = $provider;
        }

        if ($code !== false) {
            $auth = $this->checkAuth($code);

            if ($auth['status'] === false) {
                return $auth;
            }
        }

        return ['status' => true];
    }

    public function getAuthTokenAjax($site): string
    {
        return $this->avalibleProviders[$this->currentProvider]->getAuthLink($site);
    }

    public function auth($code = false): array
    {
        $result = [];

        if (isset($this->currentProvider)) {
            if (!array_key_exists($this->currentProvider, $this->avalibleProviders))
                $result = ["status" => false, "content" => "Не задан поставщик данных, попробуйте авторизоваться повторно."];
        } else {
            $result = ["status" => false, "content" => "Не задан поставщик данных, попробуйте авторизоваться повторно."];
        }

        $accessCode = false;

        if (isset($code) && !isset($_COOKIE["access"]) && $this->currentProvider) {
            try {
                $accessCode = $this->avalibleProviders[$this->currentProvider]->extractAccessCode($code);

                $this->avalibleProviders[$this->currentProvider]->setAccessCode($accessCode);

                setcookie("access", $accessCode, time() + 3600, "/");
            } catch (ProviderException $e) {
                $result = ["status" => false, "content" => $e->getMessage()];
            }
        } elseif (isset($_COOKIE["access"])) {
            $accessCode = $_COOKIE["access"];
        }

        if ($this->avalibleProviders[$this->currentProvider]->setAccessCode($accessCode) !== true) {
            $result = ["status" => false, "content" => "Неудачная авторизация"];
        }

        return ["status" => true, 'accessCode' => $accessCode];
    }

    protected function checkAuth($code = false): array
    {
        $result = ["status" => true];

        try {
            $authResult = $this->auth($code);

            if ($authResult['status'] !== true) throw new ProviderException($authResult['content'], 123);
        } catch (ProviderException $e) {
            $result = ["status" => false, "content" => $e->getMessage()];
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

    public function getDiskContent(): array
    {
        $auth = $this->checkAuth();

        if ($auth['status'] === false) {
            return $auth;
        }

        $page = $_REQUEST['page'] ?? 1;

        return $this->avalibleProviders[$this->currentProvider]->showDiskContent($page);
    }

    public function renameFile($path, $newName, $oldName)
    {
        $auth = $this->checkAuth();

        if ($auth['status'] === false) {
            return $auth;
        }

        return $this->avalibleProviders[$this->currentProvider]->renameFile($path, $newName, $oldName);
    }

    public function downloadFile($path): string
    {
        $auth = $this->checkAuth();

        if ($auth['status'] === false) {
            return $auth;
        }

        return $this->avalibleProviders[$this->currentProvider]->downloadFile($path);
    }

    public function createNewFile($fileArray)
    {
        $auth = $this->checkAuth();

        if ($auth['status'] === false) {
            return $auth;
        }

        $this->avalibleProviders[$this->currentProvider]->createNewFile($fileArray);
    }

    public function loadFileByUrl($accessCode, $fileUrl)
    {
        return $this->avalibleProviders[$this->currentProvider]->loadFileByUrl($fileUrl, $accessCode);
    }

    public function deleteFile($path)
    {
        $auth = $this->checkAuth();

        if ($auth['status'] === false) {
            return $auth;
        }

        $this->avalibleProviders[$this->currentProvider]->deleteFile($path);
    }
}

