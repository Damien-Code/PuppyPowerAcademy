<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'descriptors',
    ];
    protected $table = 'trainingcategories';

    protected function casts(): array
    {
        return [
            'descriptors' => 'array',
        ];
    }

    public function cartTraining(){
        return $this->hasMany(Cart::class);
    }

    public function trainings(){
        return $this->hasMany(Training::class, 'trainingcategory_id');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'category_order', 'trainingcategory_id', 'order_id');
    }
}
