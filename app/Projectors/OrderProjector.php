<?php

namespace App\Projectors;

use App\Events\ProductPurchased;
use App\Models\Order;
use App\Models\Product;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class OrderProjector extends Projector
{
    public function onProductPurchased(ProductPurchased $event)
    {
        $product = Product::withProductId($event->productId);

        $data = (array)$event;

        $data['total'] = $product->price * $event->quantity;

        Order::create($data);
    }
}
