<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    public function create()
    {
        return view('salas.sala_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|min:3',
            'password' => 'nullable|string|min:4'
        ]);

        // Gera código único
        do {
            $code = Str::upper(Str::random(6));
        } while (Room::where('code', $code)->exists());

        $room = Room::create([
            'name' => $request->name,
            'code' => $code,
            'user_id' => Auth::id(),
            'password' => $request->password
        ]);

        // Redireciona para a seleção de personagem
        return redirect()->route('rooms.select_character', $code)
            ->with('success', 'Sala criada com sucesso! Código: '.$code);
    }

    public function join()
    {
        return view('salas.sala_join');
    }

    public function enter(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6'
        ]);

        $code = Str::upper($request->code);
        $room = Room::where('code', $code)->first();

        if (!$room) {
            return back()->withErrors(['code' => 'Sala não encontrada!'])
                        ->withInput();
        }

        // Verificar se a sala tem senha
        if ($room->isPasswordProtected()) {
            // Redirecionar para a página de senha
            return redirect()->route('rooms.password', $code);
        }

        // Redireciona para a seleção de personagem 
        return redirect()->route('rooms.select_character', $code);
    }

    // Novo método para mostrar a página de senha
    public function showPasswordForm($code)
    {
        $room = Room::where('code', $code)->firstOrFail();
        
        // Se a sala não tiver senha, redireciona para seleção de personagem
        if (!$room->isPasswordProtected()) {
            return redirect()->route('rooms.select_character', $code);
        }
        
        return view('salas.sala_password', compact('room'));
    }

    // Novo método para verificar a senha
    public function checkPassword(Request $request, $code)
    {
        $request->validate([
            'password' => 'required|string'
        ]);
        
        $room = Room::where('code', $code)->firstOrFail();
        
        if (!$room->checkPassword($request->password)) {
            return back()->withErrors(['password' => 'Senha incorreta!']);
        }
        
        // Senha correta, armazenar na sessão que esse usuário já foi autenticado
        session(["room_auth_{$code}" => true]);
        
        // Redireciona para a seleção de personagem
        return redirect()->route('rooms.select_character', $code);
    }

    public function show($code)
    {
        $room = Room::where('code', $code)->firstOrFail();
        
        // Verificar se o usuário está autenticado na sala
        if ($room->isPasswordProtected() && !session("room_auth_{$code}")) {
            // Se não estiver autenticado, redirecionar para página de senha
            return redirect()->route('rooms.password', $code);
        }
        
        // Obter usuários conectados com seus personagens
        $connectedUsers = $room->members()->with('personagens')->get();
        
        // Preparar lista de usuários com seus respectivos personagens selecionados
        $usersList = [];
        foreach ($connectedUsers as $user) {
            $selectedCharacterId = session('selected_character_id');
            $character = null;
            
            // Se o usuário atual
            if ($user->id == Auth::id()) {
                $character = $user->personagens()->find($selectedCharacterId);
            } else {
                // Para outros usuários, tente obter da sessão deles
                $character = $user->personagens()->first(); // Solução simplificada
            }
            
            $usersList[] = [
                'user' => $user,
                'character' => $character
            ];
        }

        // Obter o personagem selecionado pelo usuário atual
        $selectedCharacter = Auth::user()->personagens()->find(session('selected_character_id'));
        
        return view('rooms.show', compact('room', 'usersList', 'selectedCharacter'));
    }

    public function selectCharacter($code)
    {
        $room = Room::where('code', $code)->firstOrFail();
        
        // Verificar se o usuário está autenticado na sala
        if ($room->isPasswordProtected() && !session("room_auth_{$code}")) {
            // Se não estiver autenticado, redirecionar para página de senha
            return redirect()->route('rooms.password', $code);
        }
        
        $personagens = Auth::user()->personagens;
        
        return view('rooms.select_character', compact('room', 'personagens'));
    }

    // Método para entrar na sala com o personagem selecionado
    public function enterWithCharacter(Request $request, $code)
    {
        $request->validate([
            'selected_character_id' => 'required|exists:personagens,id'
        ]);

        $room = Room::where('code', $code)->firstOrFail();
        
        // Verificar se o usuário está autenticado na sala
        if ($room->isPasswordProtected() && !session("room_auth_{$code}")) {
            // Se não estiver autenticado, redirecionar para página de senha
            return redirect()->route('rooms.password', $code);
        }
        
        $personagemId = $request->selected_character_id;
        
        // Armazene o personagem selecionado na sessão
        session(['selected_character_id' => $personagemId]);
        
        // Adicione o usuário como membro da sala se ainda não for
        if (!$room->members->contains(Auth::id())) {
            $room->members()->attach(Auth::id());
        }
        
        return redirect()->route('rooms.show', $code);
    }

    public function updateConnectionStatus(Request $request, $code)
    {
        $room = Room::where('code', $code)->firstOrFail();
        
        // Verifique se o usuário está autorizado
        if (!$room->members->contains(Auth::id())) {
            return response()->json(['error' => 'Não autorizado'], 403);
        }
        
        // Atualize o timestamp da última atividade do usuário na sala
        $room->members()->updateExistingPivot(Auth::id(), [
            'last_activity' => now()
        ]);
        
        // Retorne a lista atualizada de usuários conectados
        $connectedUsers = $room->members()
            ->wherePivot('last_activity', '>=', now()->subMinutes(5))
            ->with('personagens')
            ->get();
        
        return response()->json(['users' => $connectedUsers]);
    }
}