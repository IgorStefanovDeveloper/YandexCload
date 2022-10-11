<?php

namespace Modules\CloudDiskProvider\Classes;

use Arhitector\Yandex\Disk;
use Modules\CloudDiskProvider\Abstracts\Provider;
use MongoDB\Driver\Exception\Exception;

/*
 * Class to work with Yandex disk
 * */

class YandexDisk extends Provider
{
    const AUTHPATTERNSTR = "https://oauth.yandex.ru/authorize?response_type=code&client_id=";
    const TOKENPATH = "https://oauth.yandex.ru/token";
    const NAMEPROVIDER = "Яндекс диск";
    const PAGESIZE = 20;

    private string $authToken;
    private string $secretToken;
    public string $accessCode;

    public function __construct()
    {
        // TODO add try catch
        $this->authToken = $_ENV['YANDEX_AUTH_TOKEN'];
        $this->secretToken = $_ENV['YANDEX_SECRET_TOKEN'];
    }

    public function setAccessCode($code): string
    {
        $this->accessCode = $code;

        return $code;
    }

    public function showDiskContent($page = 1): array
    {
        $disk = new Disk($this->accessCode);

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
        $disk = new Disk($this->accessCode);
        $resource = $disk->getResource($path, 0);
        $resource->delete();
    }

    public function createNewFile()
    {
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/upload/tmp/';
        $uploadFile = $uploadDir . basename($_FILES['file']['name']);
        move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile);

        $disk = new Disk($this->accessCode);
        $resource = $disk->getResource(basename($_FILES['file']['name']));
        if (!$resource->has()) {
            $resource->upload($uploadFile);
        }
    }

    public function downloadFile($path): string
    {
        $disk = new Disk($this->accessCode);
        $resource = $disk->getResource($path, 0);
        $file = '/upload/tmp/' . $resource->get('name');

        $resource->download($_SERVER['DOCUMENT_ROOT'] . $file, true);

        return $file;
    }

    public function renameFile($path, $newName, $oldName)
    {
        $disk = new Disk($this->accessCode);
        $resource = $disk->getResource($path, 0);

        return $resource->move(str_replace($oldName, $newName, $path));
    }

    public function getAuthLink(): string
    {
        return self::AUTHPATTERNSTR . $this->authToken;
    }

    public function extractAccessCode($authCode): string
    {
        $query = [
            'grant_type' => 'authorization_code',
            'code' => $authCode,
            'client_id' => $this->authToken,
            'client_secret' => $this->secretToken
        ];

        $query = http_build_query($query);

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