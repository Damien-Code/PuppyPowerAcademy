<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory, Softdeletes;
    use InteractsWithMedia;


    protected $fillable = [
        'name',
        'description',
        'price',
        'stock' //kan maybe weg
    ];

    // Add media to model without adding it to db
    protected $appends = [
        'mediaFile'
    ];

    public function orderProduct(){
        return $this->hasMany(Order_Product::class);
    }
    public function cartProduct(){
        return $this->hasMany(Cart::class);
    }

    /**
     * @author Damien-Code
     * Check if media is already loaded
     * Retrieve the first media item
     */
    public function getMediaFileAttribute()
    {
        if ($this->relationLoaded('media')) {
            return $this->getFirstMedia();
        }
        return null;
    }


    protected $table = 'products';
}
