<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Utils\Money;
use Illuminate\Console\Command;

class ShowOrderListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:orders';

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
        $map = function (Order $order) {
            $result = $order->toArray();

            $result['total'] = Money::toString($result['total']);

            return $result;
        };

        $orders = Order::all(['orderId', 'productId', 'quantity', 'total'])->map($map);

        if (count($orders) > 0) {

            $headers = array_keys($orders[0]);

            $this->newLine();
            $this->table($headers, $orders);
            $this->newLine();
        } else {
            $this->newLine();
            $this->warn('⚡ No orders found');
            $this->newLine();
        }
    }
}
