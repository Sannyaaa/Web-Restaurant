<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'menu_id',
        'quantity',
        'price',
        'total_price',
        'special_instructions',
    ];

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function menu(){
        return $this->belongsTo(Menu::class);
    }

    public function review(){
        return $this->hasOne(Review::class);
    }

    public function modifiers(){
        return $this->hasMany(ModifierItem::class);
    }

    // Method untuk menghitung total harga modifier
    public function getTotalModifierPriceAttribute()
    {
        return $this->modifiers->sum(function($modifier) {
            return $modifier->price * $modifier->quantity;
        });
    }
}
