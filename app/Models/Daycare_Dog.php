<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daycare_Dog extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

    protected $fillable = [
        'daycare_id',
        'dog_id'
    ];
    public function dog(){
        return $this->belongsTo(Dog::class);
    }
    public function daycare(){
        return $this->belongsTo(Daycare::class);
    }

    protected $table = 'daycareDogs';
}
