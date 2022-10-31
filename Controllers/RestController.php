<?php

namespace Controllers;

use Modules\CloudDiskProvider;

class RestController
{
    private function auth($provider, $site): string
    {
        $providers = new CloudDiskProvider(false, $provider);

        return $providers->getAuthTokenAjax($site);
    }

    private function code($provider, $code): string
    {
        $providers = new CloudDiskProvider(false, $provider);

        return $providers->auth($code)['accessCode'];
    }

    private function loadFileToDisk($accessCode, $provider, $linkToFile): string
    {
        $providers = new CloudDiskProvider(false, $provider);

        return $providers->loadFileByUrl($accessCode, $linkToFile);
    }

    public function getDataForApiRequest($request, $args)
    {
        $resultData = [];

        $data = json_decode($request->getBody());

        switch ($args['action']) {
            case "auth":
                $resultData = json_encode(["link" => $this->auth($args['provider'] , $data->site)]);
                break;
            case "code":
                $resultData = json_encode(["code" => $this->code($args['provider'], $data->code)]);
                break;
            case "load":
                $resultData = json_encode(["load" => $this->loadFileToDisk($data->accessCode, $args['provider'], $data->link)]);
                break;
        }

        return $resultData;
    }
}