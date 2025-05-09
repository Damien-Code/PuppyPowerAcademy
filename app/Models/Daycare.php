<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daycare extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    protected $fillable = [
        'date',
    ];
    public function daycareDog(){
        return $this->hasMany(Daycare_Dog::class);
    }

    protected $table = 'daycares';
}
