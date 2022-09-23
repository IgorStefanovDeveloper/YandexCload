<?php

namespace Modules\CloudDiskProvider\Interfaces;

/*
 * Interface to work with cloud disk
 * */

interface ICloudProvider
{
    public function showDiskContent($accessCode);

    public function deleteFile($accessCode , $fileName);

    public function createNewFile($accessCode , $fileName);

    public function downloadFile($accessCode , $fileName);
}