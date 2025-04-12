<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'room_users')
                    ->withTimestamps();
    }

    // Gera código único
    public static function generateUniqueCode()
    {
        do {
            $code = Str::upper(Str::random(6));
        } while (self::where('code', $code)->exists());

        return $code;
    }
    
}