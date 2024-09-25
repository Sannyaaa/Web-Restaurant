<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModifierItem extends Model
{
    use HasFactory;

    protected $fillable = ['modifier_id', 'order_item_id', 'name', 'price','quantity'];

    public function modifier(){
        return $this->belongsTo(Modifier::class);
    }

    public function order_item(){
        return $this->belongsTo(OrderItem::class);
    }
}
