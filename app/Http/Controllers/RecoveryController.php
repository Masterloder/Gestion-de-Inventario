<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

class RecoveryController extends Controller
{
    public function checkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email'], [
            'email.exists' => 'Este correo no está registrado en nuestro sistema.'
        ]);

        // Redirigimos a la vista de preguntas pasando el email en la URL (o puedes usar sesión)
        return redirect()->route('password.security.verify', ['email' => $request->email]);
    }

    public function showResetForm($userId)
    {
        // Pasamos el ID a la vista que diseñamos
        return view('Preguntas_de_Seguridad.components.new-password', ['userId' => $userId]);
    }

    public function showVerifyForm(Request $request)
    {
        $request->merge([
            'email' => strtolower($request->input('email'))
        ]);
        $email = $request->query('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('password.request')->with('error', 'Correo no encontrado.');
        }

        // Ahora esto buscará en la tabla pivote 'user_security_answers' automáticamente
        $randomQuestions = $user->securityQuestions()
            ->inRandomOrder()
            ->take(2)
            ->get();

        if ($randomQuestions->isEmpty()) {
            return redirect()->route('login')->with('error', 'No tienes preguntas configuradas.');
        }

        return view('Preguntas_de_Seguridad.answer-questions', compact('randomQuestions', 'user'));
    }

    // 2. Verificar sin estar logueado
    public function verifyQuestions(Request $request)
    {

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'question_ids' => 'required|array|size:2',
            'answers' => 'required|array|size:2',
        ]);
        $user = User::find($request->user_id);
        $correctCount = 0;

        foreach ($request->question_ids as $index => $questionId) {
            $question = $user->securityQuestions()->where('security_questions_list.id', $questionId)->first();

            // Accedemos al campo 'answer' de la tabla pivote user_security_answers
            if ($question && Hash::check(strtolower($request->answers[$index]), $question->pivot->answer)) {
                $correctCount++;
            }
        }

        if ($correctCount === 2) {
            // Generamos la URL firmada para que pueda resetear su clave
            $temporaryUrl = URL::temporarySignedRoute(
                'password.reset.form', // Debe ser igual al ->name() en web.php
                now()->addMinutes(10),
                ['users' => $user->id]
            );

            return redirect($temporaryUrl);
        }

        return back()->with('error', 'Las respuestas de seguridad no coinciden.');
    }
    // Guarda la nueva contraseña
    public function updatePassword(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'password' => 'required|min:8',
        ]);

        $user = User::find($request->user_id);
        $user->password = Hash::make($request->password);
        $user->save();

        // Redirigir al login con mensaje de éxito
        return redirect()->route('login')->withsuccess( 'Tu contraseña ha sido actualizada correctamente.');
    }
}
