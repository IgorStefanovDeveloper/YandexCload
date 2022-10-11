<?php

namespace Modules\CloudDiskProvider\Abstracts;

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
}