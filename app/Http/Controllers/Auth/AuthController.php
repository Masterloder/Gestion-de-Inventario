<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{

    public function index(Request $request): View
    {
        // Verifica si el usuario NO ha iniciado sesión
        if (!Auth::check()) {
            // Redirige al usuario a la ruta de inicio de sesión
            return view('Inicion_de_sesion');
        }

        // Si ha iniciado sesión, continúa con la lógica del controlador
        return view('auth.login');
    }

    public function InformacionUser()
    {
        $user = User::all()->first();
        return view('Perfil', compact('user'));
    }

    public function registration(): View
    {
        return view('auth.registration');
    }

    public function postLogin(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/dashboard')
                ->withSuccess('tu cuenta ha sido autenticada');
        }

        return redirect("Inicio_de_sesion")->withError('ohh! credenciales invalidas');
    }

    public function postRegistration(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $user = $this->create($data);

        Auth::login($user);

        return redirect("dashboard")->withSuccess('Genial! Has iniciado sesión correctamente');
    }

    public function dashboard()
    {
        if (Auth::check()) {
            return view('dashboard');
        }

        return redirect("/Inicio_de_sesion")->withSuccess('  Ohh! Tu no tienes acceso a esa pagina  ');
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/Inicio_de_sesion');
    }
}
