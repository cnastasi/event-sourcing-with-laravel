<?php

namespace App\Console\Commands;

use App\Aggregates\ProductAggregate;
use App\Command\PurchaseProduct;
use App\Command\ReplenishProduct;
use App\Error\ProductNotRegisteredError;
use App\Error\ProductOutOfStockError;
use Illuminate\Console\Command;

class ReplenishProductCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:replenish {productId} {quantity}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $productId = $this->argument('productId');
        $quantity = (int)$this->argument('quantity');

        $command = new ReplenishProduct($productId, $quantity);

        try {
            ProductAggregate::retrieve($command->productId)
                ->replenishProduct($command);

            $this->newLine();
            $this->info("✓ Product <fg=yellow>{$productId}</> replenished by <fg=yellow>{$quantity}</>");
            $this->newLine();
        } catch (ProductNotRegisteredError $error) {
            $this->newLine();
            $this->line("<bg=red;fg=black>✗ Product not registered:</> {$error->getMessage()}");
            $this->newLine();
        }
    }
}
