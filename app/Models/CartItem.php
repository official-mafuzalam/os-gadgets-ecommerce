<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity'
    ];

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'cart_item_attributes')
            ->withPivot('value', 'order')
            ->withTimestamps();
    }
    public function cart()
    {
        return $this->belongsTo(ShoppingCart::class, 'cart_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getTotalPriceAttribute()
    {
        return $this->product ? $this->product->final_price * $this->quantity : 0;
    }
}
