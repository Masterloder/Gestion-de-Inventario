<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ResetSecurityController extends Controller
{
    // Paso 1: Mostrar formulario de email
    public function showEmailForm()
    {
        return view('auth.passwords.email-security');
    }

    // Paso 2: Verificar email y buscar una pregunta al azar
    public function verifyEmail(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !$user->configuracion_seguridad_completa) {
            return back()->withErrors(['email' => 'Usuario no encontrado o seguridad no configurada.']);
        }

        // Obtenemos 2 preguntas al azar de las 3 que el usuario configuró
        $randomQuestions = DB::table('user_security_answers')
            ->join('security_questions_list', 'user_security_answers.question_id', '=', 'security_questions_list.id')
            ->where('user_id', $user->id)
            ->inRandomOrder()
            ->limit(2)
            ->get();

        // Guardamos los IDs de las preguntas en la sesión para validar después
        session([
            'reset_user_id' => $user->id,
            'question_ids' => $randomQuestions->pluck('question_id')->toArray()
        ]);

        return view('auth.passwords.answer-questions', compact('randomQuestions'));
    }

    // Paso 3: Verificar si la respuesta es correcta
    public function verifyAnswer(Request $request)
    {
        $answerData = DB::table('user_security_answers')
            ->where('user_id', session('reset_user_id'))
            ->where('question_id', session('reset_question_id'))
            ->first();

        if (Hash::check(strtolower(trim($request->answer)), $answerData->answer)) {
            session(['allow_password_reset' => true]);
            return view('auth.passwords.new-password');
        }

        return back()->withErrors(['answer' => 'La respuesta es incorrecta.']);
    }

    // Paso 4: Cambiar la contraseña finalmente
    public function resetPassword(Request $request)
    {
        if (!session('allow_password_reset')) return redirect()->route('login');

        $request->validate(['password' => 'required|confirmed|min:8']);

        $user = User::find(session('reset_user_id'));
        $user->password = Hash::make($request->password);
        $user->save();

        session()->forget(['reset_user_id', 'reset_question_id', 'allow_password_reset']);

        return redirect()->route('login')->with('status', 'Contraseña actualizada con éxito.');
    }
}
