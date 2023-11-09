<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $orderId
 * @property string $productId
 * @property int $quantity
 * @property int $total
 */
class Order extends Model
{
    protected $fillable = ['orderId', 'productId', 'quantity', 'total'];
}
