<?php

namespace App\Aggregates;

use App\Command\PurchaseProduct;
use App\Command\RegisterProduct;
use App\Command\ReplenishProduct;
use App\Error\ProductNotRegisteredError;
use App\Error\ProductOutOfStockError;
use App\Events\ProductOutOfStock;
use App\Events\ProductPurchased;
use App\Events\ProductRegistered;
use App\Events\ProductReplenished;
use App\Events\ProductRunningOut;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class ProductAggregate extends AggregateRoot
{
    private bool $productRegistered = false;
    private string $name = '';
    private int $price = 0;
    private int $availableQuantity = 0;

    public function registerProduct(RegisterProduct $command): static
    {
        $this->recordThat(
            new ProductRegistered(
                $this->uuid(),
                $command->name,
                $command->availability,
                $command->price
            )
        );

        $this->persist();

        return $this;
    }

    public function purchaseProduct(PurchaseProduct $command): static
    {
        if (!$this->productRegistered) {
            throw ProductNotRegisteredError::whenPurchasing($this->uuid());
        }

        // Check if product is out of stock
        if ($this->availableQuantity < $command->requestedQuantity) {
            $this->recordThat(
                new ProductOutOfStock(
                    productId: $command->productId,
                    requestedQuantity: $command->requestedQuantity,
                    availableQuantity: $this->availableQuantity
                ));

            $this->persist();

            throw new ProductOutOfStockError(
                productId: $command->productId,
                requestedQuantity: $command->requestedQuantity,
                availableQuantity: $this->availableQuantity
            );
        }

        $orderId = uuid_create();

        // Dispatch Product Purchased Event
        $this->recordThat(
            new ProductPurchased (
                productId: $command->productId,
                orderId: $orderId,
                quantity: $command->requestedQuantity)
        );

        // Check if products are running out
        if ($this->availableQuantity <= 5) {
            $this->recordThat(new ProductRunningOut($command->productId, $this->availableQuantity));
        }

        $this->persist();

        return $this;
    }

    public function replenishProduct(ReplenishProduct $command): static
    {
        if (!$this->productRegistered) {
            throw ProductNotRegisteredError::whenReplenishing($this->uuid());
        }

        $this->recordThat(
            new ProductReplenished(
                productId: $command->productId,
                quantity: $command->quantity,
            )
        );

        $this->persist();

        return $this;
    }

    public function applyProductRegistered(ProductRegistered $event): void
    {
        $this->productRegistered = true;
        $this->name = $event->name;
        $this->availableQuantity = $event->availability;
        $this->price = $event->price;
    }

    public function applyProductPurchased(ProductPurchased $event): void
    {
        $this->availableQuantity -= $event->quantity;
    }

    public function applyProductReplenished(ProductReplenished $event): void
    {
        $this->availableQuantity += $event->quantity;
    }

    public function toArray(): array
    {
        return [
            'productId'    => $this->uuid(),
            'name'         => $this->name,
            'availability' => $this->availableQuantity,
            'price'        => $this->price,
        ];
    }
}
