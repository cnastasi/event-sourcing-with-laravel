<?php

namespace App\Events;

use App\Command\RegisterProduct;
use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class ProductRegistered extends ShouldBeStored
{
    public function __construct(
        readonly public string $productId,
        readonly public string $name,
        readonly public int    $availability,
        readonly public int    $price,
    ) {}
}
