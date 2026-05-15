<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Canteen extends Model
{
    use HasFactory; 

    // This protects your database from mass-assignment vulnerabilities
    protected $fillable = [
        'name',
        'location',
        'operating_hours',
        'is_open',
    ];
}