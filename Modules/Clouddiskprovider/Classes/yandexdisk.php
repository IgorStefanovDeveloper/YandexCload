<?php

namespace Modules\CloudDiskProvider\Classes;

use Modules\CloudDiskProvider\Interfaces\ICloudAuth as ICloudAuth;
use Modules\CloudDiskProvider\Interfaces\ICloudProvider as ICloudProvider;

/*
 * Class to work with Yandex disk
 * */

class YandexDisk implements ICloudProvider, ICloudAuth
{
    const AUTHPATTERNSTR = "https://oauth.yandex.ru/authorize?response_type=code&client_id=";
    const TOKENPATH = "https://oauth.yandex.ru/token";
    const AUTHTOKEN = "5c0321478480456a8f4abbdf0fd9fd1b";
    const SECRETTOKEN = "2673716ec38a4b938e3ed965c1956f3f";

    protected $disk;
    protected $tokenOAuth;
    protected $accessCode;
    protected $tokenJWT;
    public $providerLabel;

    public function __construct()
    {
        $this->providerLabel = "Яндекс диск";
    }

    public function getProviderLabel()
    {
        return $this->providerLabel;
    }

    public function showDiskContent($accessCode): array
    {
        $disk = new \Arhitector\Yandex\Disk($accessCode);
        return ["totalSize" => $disk->total_space, 'freeSpace' => $disk['free_space'], 'items' => $disk->getResources()];
    }

    public function deleteFile($accessCode, $fileName)
    {
    }

    public function createNewFile($accessCode, $fileName)
    {
    }

    public function downloadFile($accessCode, $fileName)
    {
    }

    public function getAuthLink(): string
    {
        return self::AUTHPATTERNSTR . self::AUTHTOKEN;
    }

    public function extractAccessCode($authCode)
    {
        // post query for auth
        $query = array(
            'grant_type' => 'authorization_code',
            'code' => $authCode,
            'client_id' => self::AUTHTOKEN,
            'client_secret' => self::SECRETTOKEN
        );
        $query = http_build_query($query);

        // post query header
        $header = "Content-type: application/x-www-form-urlencoded";

        $opts = array('http' =>
            array(
                'method' => 'POST',
                'header' => $header,
                'content' => $query
            )
        );
        $context = stream_context_create($opts);
        $result = file_get_contents(self::TOKENPATH, false, $context);
        $result = json_decode($result);

        return $result->access_token;
    }
}