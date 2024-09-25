<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'ingredient',
        'price',
        'image',
        'category_id',
        'slug',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function cart(){
        return $this->hasMany(Cart::class);
    }

    // public function orders(){
    //     return $this->belongsToMany(Order::class);
    // }
    
    public function items(){
        return $this->belongsToMany(OrderItem::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }
}
