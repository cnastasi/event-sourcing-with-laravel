<?php

namespace App\Projectors;

use App\Events\ProductPurchased;
use App\Events\ProductRegistered;
use App\Events\ProductReplenished;
use App\Models\Product;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class ProductProjector extends Projector
{
    public function onProductRegistered(ProductRegistered $event): void
    {
        $data = (array)$event;

        Product::create($data);
    }

    public function onProductPurchased(ProductPurchased $event): void
    {
        Product::withProductId($event->productId)
            ->decrementAvailability($event->quantity);
    }

    public function onProductReplenished(ProductReplenished $event)
    {
        Product::withProductId($event->productId)
            ->incrementAvailability($event->quantity);
    }
}
