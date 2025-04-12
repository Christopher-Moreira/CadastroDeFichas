<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Registro
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'segregacao' => 'user', // Valor padrão
            'can_be_admin' => false, // Por padrão não pode ser admin
            'can_be_user' => true,  // Por padrão pode ser user
        ]);
    
        return redirect()->route('login')->with('status', 'Registro realizado! Faça login.');
    }

    // Login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
    
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Verificar se o usuário pode acessar ambos os papéis
            if (auth()->user()->can_be_admin && auth()->user()->can_be_user) {
                return redirect()->route('role.selection');
            }
            
            // Redirecionamento baseado no papel
            if (auth()->user()->segregacao === 'admin') {
                return redirect()->route('admin.dashboard');
            }
    
            return redirect()->route('pagina.principal');
        }
    
        return back()->withErrors([
            'email' => 'Credenciais inválidas.',
        ]);
    }

    public function showRoleSelectionForm()
    {
        $user = Auth::user();
        
        // Se o usuário não tem permissão para ambos os papéis, redirecione
        if (!($user->can_be_admin && $user->can_be_user)) {
            if ($user->segregacao === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('pagina.principal');
            }
        }
        
        return view('auth.role-selection');
    }
    
    // Método para processar a seleção de papel
    public function selectRole(Request $request)
    {
        $role = $request->input('role');
        $user = Auth::user();
        
        // Verificar se o usuário tem permissão para o papel selecionado
        if ($role === 'admin' && !$user->can_be_admin) {
            return redirect()->back()->with('error', 'Você não tem permissão para acessar como Guardião.');
        }
        
        if ($role === 'user' && !$user->can_be_user) {
            return redirect()->back()->with('error', 'Você não tem permissão para acessar como Aventureiro.');
        }
        
        // Atualizar o papel atual do usuário na sessão
        session(['current_role' => $role]);
        
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('pagina.principal');
        }
    }

    // Página Principal (Aventureiro)
    public function paginaPrincipal()
    {
        $user = auth()->user();
    
        // Se o usuário pode ser dos dois tipos mas não escolheu o papel ainda
        if ($user->can_be_user && $user->can_be_admin && !session('current_role')) {
            return redirect()->route('role.selection');
        }
    
        // Se ele não pode acessar como aventureiro, bloqueia
        if (!(($user->can_be_user && session('current_role') === 'user') || $user->segregacao === 'user')) {
            abort(403, 'Acesso não autorizado.');
        }
    
        $personagens = $user->personagens()->latest()->get();
        return view('pagina_principal', compact('personagens'));
    }
    
    // Página Admin (Guardião)
    public function adminDashboard()
    {
        // Verifica se o usuário atual tem permissão para acessar como admin
        if (!(auth()->user()->segregacao === 'admin' || session('current_role') === 'admin')) {
            abort(403, 'Acesso não autorizado.');
        }
        
    
        return view('admin.dashboard');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}