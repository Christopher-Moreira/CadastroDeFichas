<?php

namespace App\Http\Controllers;

use App\Models\Personagem;
use Illuminate\Http\Request;

class PersonagemController extends Controller
{
    public function create()
    {
        return view('personagens.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Campos Obrigatórios (NOT NULL)
            'personagem_nome' => 'required|string|max:255',
            'level' => 'required|integer|min:1',
            'vida' => 'required|integer',
            'forca' => 'required|integer',
            'coragem' => 'required|integer',
            'fe' => 'required|integer',
            'agilidade' => 'required|integer',
            'furtividade' => 'required|integer',
            'resistencia' => 'required|integer', 
            'carisma' => 'required|integer',    
            'inteligencia' => 'required|integer',
            'percepcao' => 'required|integer',  
            'sanidade' => 'required|integer',   
    
         
            'idade' => 'nullable|integer',
            'cor_olhos' => 'nullable|string|max:50',
            'cabelo' => 'nullable|string|max:50',
            'altura' => 'nullable|numeric',
            'descricao' => 'nullable|string',
            'lore' => 'nullable|string',
            'mochila' => 'nullable|string'
        ]);
    
        Personagem::create(array_merge(
            $validated,
            ['user_id' => auth()->id()]
        ));
    
        return redirect()->route('pagina.principal');
    }
}