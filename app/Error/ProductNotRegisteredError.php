<?php

namespace App\Error;

class ProductNotRegisteredError extends \DomainException
{
    private function __construct(string $what, string $productId)
    {
        parent::__construct("You cannot {$what} the product <fg=yellow>{$productId}</> before registering it");
    }

    public static function whenPurchasing(string $productId): ProductNotRegisteredError
    {
        return new ProductNotRegisteredError('purchase', $productId);
    }

    public static function whenReplenishing(string $productId): ProductNotRegisteredError
    {
        return new ProductNotRegisteredError('replenish', $productId);
    }
}
