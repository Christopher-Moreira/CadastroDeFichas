<?php

namespace App\Http\Controllers;

use App\Models\Personagem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Adicione esta importação

class PersonagemController extends Controller
{
    public function create()
    {
        return view('personagens.create');
    }

    public function store(Request $request)
    {
        $customMessages = [
            'required' => 'O campo :attribute não pode ser vazio.',
            'numeric' => 'O campo :attribute deve ser um número.',
            'min' => 'O valor mínimo para :attribute é :min.',
            'max' => 'O valor máximo para :attribute é :max.',
            'image' => 'O arquivo deve ser uma imagem válida (jpeg, png, jpg, gif).',
            'mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg ou gif.'
        ];

        // Validação única consolidada
        $validated = $request->validate([
            // Campos obrigatórios
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
            'sanidade' => 'required|integer|min:0|max:100',
            
            // Campos opcionais
            'idade' => 'nullable|integer',
            'cor_olhos' => 'nullable|string|max:50',
            'cabelo' => 'nullable|string|max:50',
            'altura' => 'nullable|numeric',
            'descricao' => 'nullable|string',
            'lore' => 'nullable|string',
            'mochila' => 'nullable|string',
            'xp' => 'nullable|numeric|min:0',
            
            // Imagem
            'imagens' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], $customMessages);

        // Tratamento da imagem
        if ($request->hasFile('imagens')) {
            $imagePath = $request->file('imagens')->store('personagens', 'public');
            $validated['imagens'] = $imagePath;
        }

        // Criação do registro
        Personagem::create(array_merge(
            $validated,
            ['user_id' => auth()->id()]
        ));

        return redirect()->route('pagina.principal')->with('success', 'Personagem criado com sucesso!');
    }

    public function edit($id)
    {
        $personagem = Personagem::findOrFail($id);
        return view('personagens.edit', compact('personagem'));
    }

    public function update(Request $request, $id)
    {
        $customMessages = [
            'required' => 'O campo :attribute não pode ser vazio.',
            'numeric' => 'O campo :attribute deve ser um número.',
            'min' => 'O valor mínimo para :attribute é :min.',
            'max' => 'O valor máximo para :attribute é :max.',
            'image' => 'O arquivo deve ser uma imagem válida (jpeg, png, jpg, gif).',
            'mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg ou gif.'
        ];

        // Validação única consolidada
        $validated = $request->validate([
            // Campos obrigatórios
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
            'sanidade' => 'required|integer|min:0|max:100',
            
            // Campos opcionais
            'idade' => 'nullable|integer',
            'cor_olhos' => 'nullable|string|max:50',
            'cabelo' => 'nullable|string|max:50',
            'altura' => 'nullable|numeric',
            'descricao' => 'nullable|string',
            'lore' => 'nullable|string',
            'mochila' => 'nullable|string',
            'xp' => 'nullable|numeric|min:0',
            
            // Imagem
            'imagens' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], $customMessages);

        $personagem = Personagem::findOrFail($id);
        $data = $validated;

        // Tratamento da imagem
        if ($request->hasFile('imagens')) {
            // Remove imagem antiga
            if ($personagem->imagens) {
                Storage::disk('public')->delete($personagem->imagens);
            }
            
            // Armazena nova imagem
            $data['imagens'] = $request->file('imagens')->store('personagens', 'public');
        }

        $personagem->update($data);

        return redirect()->route('pagina.principal')->with('success', 'Ficha atualizada com sucesso!');
    }

    public function destroy($id)
    {
        $personagem = Personagem::findOrFail($id);
        
        // Remove imagem associada
        if ($personagem->imagens) {
            Storage::disk('public')->delete($personagem->imagens);
        }
        
        $personagem->delete();
        
        return redirect()->back()->with('success', 'Ficha excluída com sucesso!');
    }
}