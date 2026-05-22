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
        'isAvailable'
    ];

    protected $casts = [
        'isAvailable' => 'boolean',
    ];
}