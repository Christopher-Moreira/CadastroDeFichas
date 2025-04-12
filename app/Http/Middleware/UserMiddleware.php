<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        
        // Verifica se o usuário é user por segregação ou pela sessão
        if ($user->segregacao === 'user' || 
            ($user->can_be_user && session('current_role') === 'user')) {
            return $next($request);
        }
        
        return redirect()->route('login')->with('error', 'Acesso restrito para Aventureiros.');
    }
}