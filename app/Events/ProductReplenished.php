<?php

namespace App\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class ProductReplenished extends ShouldBeStored
{
    public function __construct(
        readonly public string $productId,
        readonly public int    $quantity,
    ) {}
}
