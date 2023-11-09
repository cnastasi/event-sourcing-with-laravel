<?php

namespace App\Reactors;

use App\Events\ProductRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;

class ProductReactor extends Reactor implements ShouldQueue
{
    public function onProductRegistered(ProductRegistered $event)
    {
        // Sending mail logic
    }
}
