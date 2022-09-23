<?php

namespace Modules\CloudDiskProvider\Interfaces;

/*
* Interface for cloud drive authentication
* */

interface ICloudAuth
{
    public function extractAccessCode($authCode);

    public function getAuthLink();
}