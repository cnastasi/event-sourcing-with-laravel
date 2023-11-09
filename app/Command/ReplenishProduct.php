<?php

namespace App\Command;

readonly class ReplenishProduct
{
    public function __construct(
        public string $productId,
        public int    $quantity
    ) {
        $this->validateProductId();
        $this->validateQuantity();
    }

    private function validateProductId(): void
    {
        !uuid_is_valid($this->productId) && throw new \DomainException("Invalid Product ID given ({$this->productId})");
    }

    private function validateQuantity(): void
    {
        $this->quantity < 1 && throw new \DomainException("Product quantity cannot be less than 1 ({$this->quantity})");
    }
}
