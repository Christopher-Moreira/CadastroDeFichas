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
            'name' => 'required|string|max:255|min:3'
        ]);

        // Gera código único
        do {
            $code = Str::upper(Str::random(6));
        } while (Room::where('code', $code)->exists());

        $room = Room::create([
            'name' => $request->name,
            'code' => $code,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('rooms.show', $code)
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

        return redirect()->route('rooms.show', $code);
    }

    public function show($code)
    {
        $room = Room::where('code', $code)->firstOrFail();
        return view('rooms.show', compact('room'));
    }
}