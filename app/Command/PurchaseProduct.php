<?php

namespace App\Command;

readonly class PurchaseProduct
{
    public function __construct(
        public string $productId,
        public int    $requestedQuantity
    ) {
        $this->validateProductId();
        $this->validateRequestedQuantity();
    }

    private function validateProductId(): void
    {
        !uuid_is_valid($this->productId) && throw new \DomainException("Invalid Product ID given ({$this->productId})");
    }

    private function validateRequestedQuantity(): void
    {
        $this->requestedQuantity < 1 && throw new \DomainException("Product quantity cannot be less than 1 ({$this->quantity})");
    }
}
