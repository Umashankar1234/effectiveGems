<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
    public function productDetails()
    {
        return $this->hasOne(Product::class, 'id', 'product_id'); 
    }
}
