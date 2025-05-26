<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dog_Training extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    protected $fillable = [
        'dog_id',
        'category_id',
        'completed'
    ];
    public function dog(){
        return $this->belongsTo(Dog::class);
    }
    public function training(){
        return $this->belongsTo(TrainingCategory::class);
    }

    protected $table = 'dog_trainings';
}
