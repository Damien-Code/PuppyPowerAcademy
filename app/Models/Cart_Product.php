<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Thiagoprz\EloquentCompositeKey\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Model;

class Cart_Product extends Model
{
    /** @use HasFactory<\Database\Factories\CartProductFactory> */
    use HasFactory;


    protected $fillable = [
        'cart_id',
        'product_id',
        'amount'
    ];
    public function cart(){
        return $this->belongsTo(Cart::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }

    protected $table = 'cart_products';
}
