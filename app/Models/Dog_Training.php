<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dog_Training extends Model
{
    use HasFactory;
    protected $table = 'dog_trainings';

    /**
     * Indicates if the model's ID is auto-incrementing.
     * For composite keys, this should be false.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The primary key for the model.
     * Set to null for composite keys.
     *
     * @var string|null
     */
    protected $primaryKey = null;

    protected $fillable = [
        'dog_id',
        'training_id',
        'watched_at'
    ];

    protected $casts = [
        'watched_at' => 'datetime',
        'dog_id' => 'integer',
        'training_id' => 'integer',
    ];

    /**
     * Set the keys for a save update query.
     * This is crucial for models with composite primary keys.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery($query)
    {
        $query->where('dog_id', $this->getAttribute('dog_id'))
              ->where('training_id', $this->getAttribute('training_id'));

        return $query;
    }

    public function dog(){
        return $this->belongsTo(Dog::class);
    }

    public function training(){
        return $this->belongsTo(Training::class);
    }
}
