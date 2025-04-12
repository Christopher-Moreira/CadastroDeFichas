<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        
        // Verifica se o usuário é admin por segregação ou pela sessão
        if ($user->segregacao === 'admin' || 
            ($user->can_be_admin && session('current_role') === 'admin')) {
            return $next($request);
        }
        
        return redirect()->route('login')->with('error', 'Acesso restrito para Guardiões do Reino.');
    }
}