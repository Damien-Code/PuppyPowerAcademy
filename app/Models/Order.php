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
        'postal_code',
        'country',
        'city',
        'street',
        'house_number',
        'total_price'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function orderProducts(){
        return $this->hasMany(Order_Product::class);
    }

    public function categoryOrder()
    {
        return $this->hasMany(Category_Order::class);
    }


//msNote: maybe dat deze ook hernoemd moet worden (idk)
    protected $appends = ['totalPrice'];
    /**
     * @author Damien-Code
     * @return mixed
     * Returns the total price of the order
     */
    public function getTotalPriceAttribute(){
        $products = $this->orderProducts->sum(function($orderProduct){
            return $orderProduct->product->price * $orderProduct->amount;
        });
        $trainings = $this->categoryOrder->sum(function($categoryOrder){
            return $categoryOrder->trainingcategory->price;
        });
        return $products + $trainings;
    }

    protected $table = 'orders';
}
