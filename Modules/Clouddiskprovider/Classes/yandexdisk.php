<?php

namespace Modules\CloudDiskProvider\Classes;

use Modules\CloudDiskProvider\Abstracts\Provider;

/*
 * Class to work with Yandex disk
 * */

class YandexDisk extends Provider
{
    const AUTHPATTERNSTR = "https://oauth.yandex.ru/authorize?response_type=code&client_id=";
    const TOKENPATH = "https://oauth.yandex.ru/token";
    //TODO hide tokens
    const AUTHTOKEN = "5c0321478480456a8f4abbdf0fd9fd1b";
    const SECRETTOKEN = "2673716ec38a4b938e3ed965c1956f3f";
    const NAMEPROVIDER = "Яндекс диск";
    const PAGESIZE = 20;
    public $accessCode;

    public function __construct()
    {
    }

    public function setAccessCode($code): void
    {
        $this->accessCode = $code;
    }

    public function showDiskContent($page = 1): array
    {
        $disk = new \Arhitector\Yandex\Disk($this->accessCode);

        return [
            "totalSize" => $disk->get('total_space'),
            'freeSpace' => $disk->get('free_space'),
            'items' => $disk->getResources(self::PAGESIZE, ($page - 1) * self::PAGESIZE),
            'count' => $disk->getResources(PHP_INT_MAX)->count(),
            'nav' => self::PAGESIZE
        ];
    }

    public function deleteFile($path)
    {
    }

    public function createNewFile($fileName)
    {
    }

    public function downloadFile($path): string
    {
        $disk = new \Arhitector\Yandex\Disk($this->accessCode);
        $resource = $disk->getResource($path, 0);
        $file = '/upload/tmp/' . $resource->get('name');
        $resource->download($_SERVER['DOCUMENT_ROOT'] . $file, true);
        return $file;
    }

    public function renameFile($path, $newName, $oldName)
    {
        $disk = new \Arhitector\Yandex\Disk($this->accessCode);
        $resource = $disk->getResource($path, 0);
        return $resource->move(str_replace($oldName, $newName, $path));
    }

    public function getAuthLink(): string
    {
        return self::AUTHPATTERNSTR . self::AUTHTOKEN;
    }

    public function extractAccessCode($authCode): string
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