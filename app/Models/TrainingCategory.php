<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];

    public function cartTraining(){
        return $this->hasMany(Cart::class);
    }

    public function trainings(){
        return $this->hasMany(Training::class);
    }
}
