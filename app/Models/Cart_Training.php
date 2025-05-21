<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart_Training extends Model
{
    /** @use HasFactory<\Database\Factories\CartTrainingFactory> */
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'training_id',
    ];
    public function cart(){
        return $this->belongsTo(Cart::class);
    }
    public function training(){
        return $this->belongsTo(Training::class);
    }

    protected $table = 'cart_trainings';
}
