<?php

namespace App\Error;

class ProductOutOfStockError extends \DomainException
{
    public function __construct(string $productId, int $requestedQuantity, int $availableQuantity)
    {
        parent::__construct("The product <fg=yellow>{$productId}</> is out of stock. Requested <fg=yellow>{$requestedQuantity}</> products but into the stock there are only <fg=yellow>{$availableQuantity}</> of them");
    }
}
