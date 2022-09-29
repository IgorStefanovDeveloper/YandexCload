<?php

namespace Modules\CloudDiskProvider\Abstracts;

use Modules\CloudDiskProvider\Interfaces\ICloudAuth as ICloudAuth;
use Modules\CloudDiskProvider\Interfaces\ICloudProvider as ICloudProvider;

abstract class Provider implements ICloudProvider, ICloudAuth
{
    public function getProviderLabel(): string
    {
        return $this::NAMEPROVIDER;
    }

    protected function checkAuth()
    {
    }
}