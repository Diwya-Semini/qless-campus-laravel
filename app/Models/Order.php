<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // YOUR custom database columns
    protected $fillable = [
        'user_id', 
        'canteen_id', 
        'total_amount', 
        'queue_number', 
        'status', 
        'ticket_number'
    ];

    // 1. Link back to the Student
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 2. THE FIX: Link to the Food Items (This is what Laravel was crying about!)
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}