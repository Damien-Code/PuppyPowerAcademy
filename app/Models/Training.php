<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Training extends Model
{
    /** @use HasFactory<\Database\Factories\TrainingFactory> */
    use HasFactory, Softdeletes;

    protected $fillable = [
        'title',
        'price',
        'description',
        'link'
    ];

    public function cartTraining(){
        return $this->hasMany(Cart::class);
    }

    protected $table = 'trainings';
}
