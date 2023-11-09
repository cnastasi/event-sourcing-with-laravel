<?php

namespace App\Events;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class ProductRunningOut extends ShouldBeStored
{
    public function __construct(
        readonly public string $productId,
        readonly public int    $availableProducts,
    ) {}
}
