<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Utils\Money;
use Illuminate\Console\Command;

class ShowProductListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:list';

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
        $map = function (Product $product){
            $result = $product->toArray();

            $result['price'] = Money::toString($result['price']);

            return $result;
        };

        $products = Product::all(['productId', 'name', 'availability', 'price'])->map($map);

        if (count($products) > 0) {

            $headers = array_keys($products[0]);

            $this->newLine();
            $this->table($headers, $products);
            $this->newLine();
        }
        else {
            $this->newLine();
            $this->warn('⚡ No products in the stock');
            $this->newLine();
        }
    }
}
