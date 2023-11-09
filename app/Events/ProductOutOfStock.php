<?php

namespace App\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class ProductOutOfStock extends ShouldBeStored
{
    public function __construct(
        readonly public string $productId,
        readonly public int    $requestedQuantity,
        readonly public int    $availableQuantity
    ) {}
}
