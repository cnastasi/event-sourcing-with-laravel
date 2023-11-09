<?php

namespace App\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class ProductPurchased extends ShouldBeStored
{
    public function __construct(
        readonly public string $productId,
        readonly public string $orderId,
        readonly public int    $quantity,
    ) {}
}
