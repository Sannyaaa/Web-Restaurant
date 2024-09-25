<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modifier extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'category'];

    public function modifier_item(){
        return $this->belongsTo(ModifierItem::class);
    }
}
