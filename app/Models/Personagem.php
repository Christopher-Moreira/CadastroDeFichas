<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Personagem extends Model
{
    use HasFactory;
// App\Models\Personagem
protected $table = 'personagens'; 
protected $fillable = [
    'user_id',
    'personagem_nome',
    'level',
    'idade',
    'cor_olhos',
    'cabelo',
    'altura',
    'descricao',
    'lore',
    'vida',
    'forca',
    'coragem',
    'fe',
    'agilidade',
    'furtividade',
    'resistencia',
    'carisma',      
    'inteligencia', 
    'percepcao',    
    'mochila',
    'sanidade',      
    'xp',
    'imagens'
];

public function user()
{
    return $this->belongsTo(User::class);
}
}