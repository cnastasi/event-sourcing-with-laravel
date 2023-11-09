<?php

namespace App\Console\Commands;

use App\Aggregates\ProductAggregate;
use App\Command\PurchaseProduct;
use App\Error\ProductNotRegisteredError;
use App\Error\ProductOutOfStockError;
use Illuminate\Console\Command;

class PurchaseProductCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:purchase {productId} {quantity}';

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

        $command = new PurchaseProduct($productId, $quantity);

        try {
            ProductAggregate::retrieve($command->productId)
                ->purchaseProduct($command);

            $this->newLine();
            $this->info("✓ Product <fg=yellow>{$productId}</> purchased");
            $this->newLine();

        } catch (ProductOutOfStockError $error) {
            $this->newLine();
            $this->line("<bg=red;fg=black>✗ Product out of stock:</> {$error->getMessage()}");
            $this->newLine();
        } catch (ProductNotRegisteredError $error) {
            $this->newLine();
            $this->line("<bg=red;fg=black>✗ Product not registered:</> {$error->getMessage()}");
            $this->newLine();
        }
    }
}
