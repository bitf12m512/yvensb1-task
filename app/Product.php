<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'class',
        'variants',
        'price',
        'image',
        'status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'variants' => 'array'
    ];

    /**
     * Get the image.
     *
     * @return string
     */
    public function getImageAttribute($value)
    {
        if (isset($value) && $value != "" && $value != null)
            return url("/") . "/upload/{$value}";
        else
            return "";
    }
}
