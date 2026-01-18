<?php

namespace App\Http\Controllers;

use App\Models\SecurityQuestion;
use App\Models\SecurityQuestionList;
use App\Models\UserSecurityAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SecurityController extends Controller
{
    public function index()
    {
        $questionsList = SecurityQuestion::all();
        return view('preguntas_de_seguridad.security-questions', compact('questionsList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'questions' => 'required|array|size:3',
            'questions.*' => 'required|exists:security_questions_list,id',
            'answers' => 'required|array|size:3',
            'answers.*' => 'required|string|min:1|max:255',
        ]);

        try {
            $user = Auth::user();

            // 1. Guardar las preguntas y respuestas
            foreach ($request->questions as $index => $questionId) {
                UserSecurityAnswer::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'question_id' => $questionId
                    ],
                    [
                        'answer' => $request->answers[$index]
                    ]
                );
            }

            // 2. NUEVO: Actualizar el estado del usuario
            // Accedemos al usuario autenticado y cambiamos la columna
            $user->update([
                'configuracion_seguridad_completa' => 1
            ]);

            return redirect('/dashboard')->with('success', 'Configuración de seguridad completada con éxito.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al guardar: ' . $e->getMessage());
        }
    }
}
