<?php

namespace Modules\CloudDiskProvider\Interfaces;

/*
* Interface for cloud drive authentication
* */

interface CloudAuthInterface
{
    public function extractAccessCode($authCode);

    public function getAuthLink();
}