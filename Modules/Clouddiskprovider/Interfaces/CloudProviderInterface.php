<?php

namespace Modules\CloudDiskProvider\Interfaces;

/*
 * Interface to work with cloud disk
 * */

interface CloudProviderInterface
{
    public function showDiskContent($accessCode);

    public function deleteFile($path);

    public function createNewFile($fileArray);

    public function downloadFile($path);

    public function renameFile($path, $newName, $oldName);
}