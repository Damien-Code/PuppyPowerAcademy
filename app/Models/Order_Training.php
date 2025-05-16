<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_Training extends Model
{
    /** @use HasFactory<\Database\Factories\OrderTrainingFactory> */
    use HasFactory;

    protected $fillable = [
        'order_id',
        'training_id',
    ];
    public function order(){
        return $this->belongsTo(Order::class);
    }
    public function training(){
        return $this->belongsTo(Training::class);
    }

    protected $table = 'order_trainings';
}
