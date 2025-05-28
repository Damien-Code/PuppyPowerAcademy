<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category_Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderTrainingFactory> */
    use HasFactory;

    protected $fillable = [
        'order_id',
        'category_id',
    ];
    public function order(){
        return $this->belongsTo(Order::class);
    }
    public function category(){
        return $this->belongsTo(TrainingCategory::class);
    }

    protected $table = 'category_order';
}
