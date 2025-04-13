<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'user_id', 'has_password', 'password'];
    
    // Não retornar o campo password nas consultas
    protected $hidden = ['password'];

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
    
    // Verifica se a sala tem senha
    public function isPasswordProtected()
    {
        return $this->has_password;
    }
    
    // Verifica se a senha fornecida está correta
    public function checkPassword($password)
    {
        if (!$this->has_password) {
            return true;
        }
        
        return Hash::check($password, $this->password);
    }
    
    // Muta o atributo password antes de salvar
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = Hash::make($value);
            $this->attributes['has_password'] = true;
        } else {
            $this->attributes['has_password'] = false;
            $this->attributes['password'] = null;
        }
    }
    protected static function booted()
{
    static::retrieved(function ($model) {
        $model->last_accessed_at = now();
        $model->save();
    });
}
}