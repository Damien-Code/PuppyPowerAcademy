<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dog extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'race',
        'user_id',
        'age', //kan maybe weg
        'been_to_daycare'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function dogTraining(){
        return $this->hasMany(Dog_Training::class);
    }

    // Search if this is correct for pivot table
    public function daycares(){
//        return $this->hasManyThrough(Daycare::class, Daycare_Dog::class);
        return $this->belongsToMany(Daycare::class, Daycare_Dog::class);
    }

    protected $table = 'dogs';
}
