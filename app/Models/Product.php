<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'is_available' => 'boolean',
    ];

    // product belongs to one canteen
    public function canteen()
    {
        return $this->belongsTo(Canteen::class);
    }
}