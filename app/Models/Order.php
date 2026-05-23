<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'canteen_id', 'total_amount', 'status'];

    // An Order belongs to a Student
    public function user() { return $this->belongsTo(User::class); }
    
    // An Order has many Food Items
    public function items() { return $this->hasMany(OrderItem::class); }
}