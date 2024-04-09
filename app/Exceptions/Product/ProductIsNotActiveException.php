<?php

namespace App\Exceptions\Product;

use Exception;

class ProductIsNotActiveException extends Exception
{
    public function __construct(string $message = null, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct(__("messages.model_not_found"), $code, $previous);
    }
}
