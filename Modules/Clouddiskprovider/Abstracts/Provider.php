<?php

namespace Modules\CloudDiskProvider\Abstracts;

use GuzzleHttp\Client;
use Modules\CloudDiskProvider\Interfaces\CloudAuthInterface;
use Modules\CloudDiskProvider\Interfaces\CloudProviderInterface;

abstract class Provider implements CloudAuthInterface, CloudProviderInterface
{
    public function getProviderLabel(): string
    {
        return $this::NAMEPROVIDER;
    }

    protected function checkAuth()
    {
    }

    protected function getHeadersForAccessRequest(string $authCode): array
    {
        return [];
    }

    public function extractAccessCode(string $authCode): string
    {
        $client = new Client(['base_uri' => $this::TOKENPATH]);

        $response = $client->request('POST',
            $this::TOKENPATH,
            $this->getHeadersForAccessRequest($authCode)
        );

        if ($response->getStatusCode() == "200") {
            $result = json_decode($response->getBody());

            return $result->access_token;
        } else {
            //TODO add Throw
            return "";
        }
    }
}