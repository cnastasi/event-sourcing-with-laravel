<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $productId
 * @property string $name
 * @property int $availability
 * @property int $price
 */
class Product extends Model
{
    protected $fillable = ['productId', 'name', 'availability', 'price'];

    public function incrementAvailability(int $quantity): void {
        $this->increment('availability', $quantity);
    }

    public function decrementAvailability(int $quantity): void {
        $this->decrement('availability', $quantity);
    }

    public static function withProductId (string $productId): Product
    {
        return Product::where('productId', $productId)->first();
    }
}
