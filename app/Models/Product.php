<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'canteen_id',
        'item_name', 
        'price',
        'description',
        'image_url',
        'category',
        'is_available',
    ];

    protected $casts = [
        'isAvailable' => 'boolean',
    ];

    // Magic Translator: Lets the frontend use capital 'A' without breaking the database
    public function getIsAvailableAttribute()
    {
        return $this->attributes['is_available'];
    }
}