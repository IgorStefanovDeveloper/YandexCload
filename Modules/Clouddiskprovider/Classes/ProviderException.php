<?php

namespace Modules\CloudDiskProvider\Classes;

class ProviderException extends \Exception
{
    public function __contruct($message, $code = 0, Throwable $previous = null)
    {
        parent::__construct('Ошибка провайдера:' . $message, $code, $previous);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}