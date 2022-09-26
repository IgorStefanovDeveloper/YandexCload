<?php

namespace Modules\CloudDiskProvider\Interfaces;

/*
 * Interface to work with cloud disk
 * */

interface ICloudProvider
{
    public function showDiskContent($accessCode);

    public function deleteFile($path);

    public function createNewFile($fileName);

    public function downloadFile($path);

    public function renameFile($path, $newName, $oldName);
}