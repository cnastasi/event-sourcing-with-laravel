<?php

namespace App\Command;

readonly class RegisterProduct
{
    public function __construct(
        public string $name,
        public int    $availability,
        public int    $price,
    ) {
        $this->validate();
    }

    private function validate(): void
    {
        $this->validateName();
        $this->validateQuantity();
        $this->validatePrice();
    }

    private function validateName(): void
    {
        empty($this->name) && throw new \DomainException('Product name cannot be empty');
    }

    private function validateQuantity(): void
    {
        $this->availability < 1 && throw new \DomainException('Product quantity cannot be less than 1');
    }

    private function validatePrice(): void
    {
        $this->price < 5 && throw new \DomainException('Product price cannot be less than 0.05€');
    }
}
