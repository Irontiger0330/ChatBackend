<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['from_id', 'to_id', 'body'];

    // protected $appends = ['Message'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
