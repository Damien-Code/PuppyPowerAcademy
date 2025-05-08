<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory, Softdeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock' //kan maybe weg
    ];
    public function orderProduct(){
        return $this->hasMany(Order_Product::class);
    }
    public function cartProduct(){
        return $this->hasMany(Cart_Product::class);
    }

    protected $table = 'products';
}
