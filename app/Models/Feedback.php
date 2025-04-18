<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'rating', 'message', 'user_id', 'is_show'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
