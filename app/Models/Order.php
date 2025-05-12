<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'postalCode',
        'country',
        'city',
        'street',
        'houseNumber',
        // 'totalPrice',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function orderProducts(){
        return $this->hasMany(Order_Product::class);
    }

    protected $appends = ['totalPrice'];
    public function getTotalPriceAttribute(){
        return $this->orderProducts->sum(function($orderProduct){
            return $orderProduct->product->price * $orderProduct->amount;
        });
    }

    protected $table = 'orders';
}
