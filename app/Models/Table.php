<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Table extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'qr_code'];

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($post) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
        });
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }
    
}