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

        $request->merge([
            'email' => strtolower($request->input('email'))
        ]);

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/dashboard')
                ->withSuccess('tu cuenta ha sido autenticada');
        }

        return redirect("/Inicio_de_sesion")->with('error', 'No tienes permiso para acceder aquí.');
    }

    public function postRegistration(Request $request): RedirectResponse
    {
        // 1. Convertir email,nombre,apellido a minúsculas
        $request->merge([
        'email'     => strtolower($request->input('email')),
        'firstname' => ucfirst(strtolower($request->input('firstname'))),
        'lastname'  => ucfirst(strtolower($request->input('lastname'))),
    ]);

        

        // 3. Validación
        $request->validate([
            'name'      => 'Operador de Almacén',
            'firstname' => 'required|string|max:30',
            'lastname'  => 'required|string|max:30',
            'email'     => 'required|email|unique:users,email',
            'password'  => [
                'required',
                'string',
                'min:8',
                'max:14',
                'confirmed', // Esto verifica automáticamente con password_confirmation
                'regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?]).{8,14}$/'
            ],
        ], [
            // Mensajes personalizados para el modal o spans
            'password.regex' => 'La contraseña debe tener una mayúscula, un número, un carácter especial y entre 8 y 14 caracteres.',
            'email.unique'   => 'Este correo ya está registrado.',
            'password.confirmed' => 'Las contraseñas no coinciden.'
        ]);

        // 4. Creación de usuario
        $data = $request->all();
        $this->create($data);

        // 5. Redirección final
        return redirect("/Inicio_de_sesion")->withsuccess('¡Genial! Has Creado un Usuario correctamente');
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
            'name' => 'Operador de Almacén',
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
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

    public function updatePassword(Request $request)
{
    $request->validate([
        'password' => 'required|min:8',
        'user_id' => 'required|exists:users,id'
    ]);

    $user = User::find($request->user_id);
    $user->password = Hash::make($request->password);
    $user->save();

    return redirect()->route('login')->with('success', 'Contraseña actualizada.');
}
}
