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
        'trainingcategory_id',
    ];
    public function cart(){
        return $this->belongsTo(Cart::class);
    }
    public function trainingcategory(){
        return $this->belongsTo(TrainingCategory::class);
    }

    protected $table = 'cart_trainings';
}
