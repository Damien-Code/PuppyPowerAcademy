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
        'trainingcategory_id',
    ];
    public function order(){
        return $this->belongsTo(Order::class);
    }
    public function trainingcategory(){
        return $this->belongsTo(TrainingCategory::class);
    }

    protected $table = 'category_order';
}
