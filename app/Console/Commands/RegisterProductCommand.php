<?php

namespace App\Console\Commands;

use App\Aggregates\ProductAggregate;
use App\Command\RegisterProduct;
use Illuminate\Console\Command;

class RegisterProductCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:register {name} {quantity} {price}';

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
        $name = $this->argument('name');
        $quantity = (int)$this->argument('quantity');
        $price = (int)$this->argument('price');

        try {
            $command = new RegisterProduct($name, (int)$quantity, (int)$price);

            $aggregate = ProductAggregate::retrieve(uuid_create())
                ->registerProduct($command);

            $this->newLine();
            $this->info("✓ Product registered with id <fg=yellow>{$aggregate->uuid()}</>");
            $this->newLine();

        } catch (\DomainException $exception) {
            $this->warn('Product not registered');
            $this->error($exception->getMessage());
        }
    }
}
