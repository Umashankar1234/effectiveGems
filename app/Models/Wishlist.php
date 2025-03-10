<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'product_id'];
    public function productDetails()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function userDetails()
    {
        return $this->hasOne(Euser::class, 'id', 'user_id');
    }
}
