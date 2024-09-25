<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'table_id', 
        'name', 
        'phone', 
        'invoice', 
        'resi', 
        'total_price',
        'chef',
        'waiter',
        'cashier',
        'status',
        'payment_url',
        'payment_method',
        'payment_status',
        'created_at',
        'updated_at',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function table(){
        return $this->belongsTo(Table::class);
    }

    public function items(){
        return $this->hasMany(OrderItem::class);
    }
}
