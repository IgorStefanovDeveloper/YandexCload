<?php

namespace Modules\CloudDiskProvider\Interfaces;

/*
* Interface for cloud drive authentication
* */

interface CloudAuthInterface
{
    public function extractAccessCode(string $authCode): string;

    public function getAuthLink(): string;
}