<?php

namespace App\Http\Controllers;

use App\Models\CategoriaEspecifica;
use App\Models\CategoriaMaterial;
use App\Models\Materiales;
use App\Models\UnidadMedida;
use App\Models\User;
use App\Notifications\CategoriaNotification;
use App\Notifications\MaterialNotification;
use App\Notifications\UNidadMedidaNotification;
use App\Notifications\UsuarioNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;;

class Crud_Configuracion extends Controller
{
    public function index()
    {
        return view('Configuracion.index');
    }
    public function tablaMateriales()
    {

        $materiales = Materiales::with('unidadMedida', 'categoria', 'categoriaEspecifica')->get();
        $categorias = CategoriaMaterial::with('categoriasEspecificas')->get();
        $categoriasEspecificas = CategoriaEspecifica::with('categoria')->get();
        $unidades = UnidadMedida::all();

        return view('Configuracion.TablaMateriales', compact('materiales', 'unidades', 'categorias', 'categoriasEspecificas'));
    }
    public function materialesupdate(Request $request, $id)
{
    // 1. Validar los datos recibidos
    $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string|max:500',
        // Ajustado según los nombres de tabla comunes en tu proyecto
        'unidad_medida_id' => 'required|exists:unidades_medida,id', 
        'categoria_id' => 'required|exists:categorias_materiales,id',
        'categoria_especifica_id' => 'required|exists:categorias_especificas,id',
    ], [
        'categoria_especifica_id.required' => 'Debe seleccionar una categoría específica válida.',
        'unidad_medida_id.required' => 'La unidad de medida es obligatoria.',
    ]);

    try {
        // 2. Buscar el material (Usando el modelo 'Materiales' que aparece en tu controlador)
        $material = Materiales::findOrFail($id);

        // 3. Actualizar los campos
        $material->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'unidad_medida_id' => $request->unidad_medida_id,
            'categoria_id' => $request->categoria_id,
            'categoria_especifica_id' => $request->categoria_especifica_id,
        ]);

        // 4. Redireccionar con mensaje de éxito
        auth()->user()->notify(new MaterialNotification('update', $material->nombre));
        return redirect()->back()->with('success', 'El material "' . $material->nombre . '" se ha actualizado correctamente.');

    } catch (\Exception $e) {
        // En caso de error, volver con un mensaje detallado para depuración
        return redirect()->back()->with('error', 'Ocurrió un error: ' . $e->getMessage());
    }
}

public function materialesDelete($id)
{
    try {
        $material = Materiales::findOrFail($id);
        $material->delete(); // Esto ejecutará SoftDelete si el modelo lo tiene configurado
        auth()->user()->notify(new MaterialNotification('delete', $material->nombre));
        return redirect()->back()->with('success', 'Material eliminado correctamente.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'No se pudo eliminar el material.');
    }
}

    public function tablaUnidadesMedicion()
    {

        $unidades = UnidadMedida::all();
        return view('Configuracion.TablaUnidadM', compact('unidades'));
    }


    public function VistaUsuarios()
    {
        $usuarios = User::all();
        return view('Usuarios.index', compact('usuarios'));
    }

    public function PostUsuario(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        auth()->user()->notify(new UsuarioNotification('create', $request->name));
        return redirect()->back()->with('success', 'Usuario creado exitosamente.');
    }

    public function cambiarPassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $usuario = User::findOrFail($id);
        $usuario->password = bcrypt($request->input('password'));
        $usuario->save();


        auth()->user()->notify(new UsuarioNotification('update', $usuario->name));
        return redirect()->back()->with('success', 'Contraseña actualizada exitosamente.');
    }

    public function cambiarAutorizacion(Request $request, $id)
    {
        // 1. Buscamos al usuario
        $usuario = User::findOrFail($id);

        // 2. Actualizamos con el valor que viene del input hidden 'autorizar'
        $usuario->autorizacion = $request->input('autorizar');
        $usuario->save();

        // 3. Redirección correcta (usando el nombre de tu ruta de configuración)
        auth()->user()->notify(new UsuarioNotification('update', $usuario->name));
        return redirect()->back()->with('success', 'Estado de autorización actualizado.');
    }

    public function updateUsuario(Request $request, $id)
    {
        $usuario = User::findOrFail($id);


        $request->validate([
            'name' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'rol' => 'required|string|max:255',
            'email' => "required|string|email|max:255|unique:users,email,{$usuario->id}",
        ]);

        // Capitalizar la primera letra de firstname y lastname
        $request->merge([
            'firstname' => ucfirst(strtolower($request->input('firstname'))),
            'lastname' => ucfirst(strtolower($request->input('lastname'))),
        ]);

        $usuario->update([
            'name' => $request->input('name'),
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'rol' => $request->input('rol'),
            'email' => $request->input('email'),
        ]);

        return redirect()->back()->with('success', 'Usuario actualizado exitosamente.');
    }


    public function DeleteUsuario($id)
    {
        $usuario = User::findOrFail($id);

        // Al tener el Trait SoftDeletes, esto no borra la fila de la DB,
        // sino que pone la fecha actual en 'deleted_at' automáticamente.
        $usuario->delete();
        auth()->user()->notify(new UsuarioNotification('delete', $usuario->name));
        return redirect()->back()->with('success', 'Usuario eliminado exitosamente.');
    }


    public function tablaCategorias()
    {
        $categorias = CategoriaMaterial::with('categoriasEspecificas')->get();
        return view('Categorias.index', compact('categorias'));
    }

    public function PostCategoria(Request $request, $id)
    {
        // 1. Validar los datos que vienen del formulario
        $request->validate([
            'nombre_categoria' => 'required|string|max:255',
            'nombre_especifico' => 'required|string|max:255',
        ]);

        // 2. Encontrar la categoría específica
        $categoriaMaterial = CategoriaMaterial::findOrFail($id);
        $categoriaEspecifica = CategoriaEspecifica::findOrFail($id);

        try {
            // Usamos una transacción para asegurar que ambos cambios se apliquen juntos
            DB::transaction(function () use ($request, $categoriaEspecifica, $categoriaMaterial) {

                // 3. Actualizar la Categoría General (Padre)
                // Accedemos a través de la relación definida en el modelo
                $categoriaGeneral = $categoriaMaterial;
                $categoriaGeneral->nombre_categoria = $request->nombre_categoria;
                $categoriaGeneral->save();

                // 4. Actualizar la Categoría Específica (Hijo)
                $categoriaEspecifica->nombre_especifico = $request->nombre_especifico;
                $categoriaEspecifica->save();
            });
            auth()->user()->notify(new CategoriaNotification('update_categoria', $categoriaMaterial->nombre_categoria, $categoriaEspecifica->nombre_especifico));
            return redirect()->back()->with('success', 'Ambas categorías se actualizaron correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Hubo un problema al actualizar: ' . $e->getMessage());
        }
    }

    public function DeleteCategoriaT($id)
    {
        $categoriaEspecifica = CategoriaEspecifica::findOrFail($id);

        // Al tener el Trait SoftDeletes, esto no borra la fila de la DB,
        // sino que pone la fecha actual en 'deleted_at' automáticamente.

        $categoriaEspecifica->delete();
        auth()->user()->notify(new CategoriaNotification('delete_categoria_especifica', null, $categoriaEspecifica->nombre_especifico));
        return redirect()->back()->with('success', 'Categoría específica eliminada exitosamente.');
    }
    public function DeleteCategoria($id)
    {
        $categoriaMaterial = CategoriaMaterial::findOrFail($id);
        // Al tener el Trait SoftDeletes, esto no borra la fila de la DB,
        // sino que pone la fecha actual en 'deleted_at' automáticamente.
        $categoriaMaterial->delete();
        auth()->user()->notify(new CategoriaNotification('delete_categoria', $categoriaMaterial->nombre_categoria, null));
        return redirect()->back()->with('success', 'Categoría eliminada exitosamente.');
    }


    public function store(Request $request)
    {
        // 1. Validar los datos
        $request->validate([
            'categoria_material_id' => 'required|exists:categorias_materiales,id',
            'nombre_especifico' => 'required|string|max:255',
        ]);

        // 2. Crear el nuevo registro
        // Asegúrate de que estos campos estén en el array $fillable de tu modelo
        CategoriaEspecifica::create([
            'categoria_id' => $request->categoria_material_id,
            'nombre_especifico' => $request->nombre_especifico,
        ]);

        // 3. Responder al usuario
        auth()->user()->notify(new CategoriaNotification('create_categoria_especifica', null, $request->nombre_especifico));
        return redirect()->back()->with('success', 'Subcategoría agregada correctamente.');
    }
    public function CategoriaCrear(Request $request)
    {
        $request->validate([
            'nombre_categoria' => 'required|string|max:255|unique:categorias_materiales,nombre_categoria',
        ]);

        CategoriaMaterial::create([
            'nombre_categoria' => $request->nombre_categoria
        ]);
        auth()->user()->notify(new CategoriaNotification('create_categoria', $request->nombre_categoria, null));
        return redirect()->back()->with('success', 'Categoría creada con éxito.');
    }

    public function CategoriaEspecificaCrear(Request $request)
    {
        $request->validate([
            'categoria_id' => 'required|exists:categorias_materiales,id',
            'nombre_especifico' => 'required|string|max:255',
        ]);

        CategoriaEspecifica::create([
            'categoria_id' => $request->categoria_id,
            'nombre_especifico' => $request->nombre_especifico,
        ]);
        auth()->user()->notify(new CategoriaNotification('create_categoria_especifica', null, $request->nombre_especifico));
        return redirect()->back()->with('success', 'Categoría específica creada con éxito.');
    }

    public function UnidadMedicionCrear(Request $request)
    {
        $request->validate([
            'nombre_unidad' => 'required|string|max:100|unique:unidades_medida,nombre_unidad',
            'simbolo' => 'required|string|max:20|unique:unidades_medida,simbolo',
        ]);

        UnidadMedida::create([
            'nombre_unidad' => $request->nombre_unidad,
            'simbolo' => $request->simbolo,
        ]);
        auth()->user()->notify(new UNidadMedidaNotification('create', $request->nombre_unidad));
        return redirect()->back()->with('success', 'Unidad de medida creada con éxito.');
    }
    public function UnidadMedicionUpdate(Request $request, $id)
    {
        $request->validate([
            'nombre_unidad' => 'required|string|max:100|unique:unidades_medida,nombre_unidad,' . $id,
            'simbolo' => 'required|string|max:20|unique:unidades_medida,simbolo,' . $id,
        ]);

        $unidad = UnidadMedida::findOrFail($id);
        $unidad->update([
            'nombre_unidad' => $request->nombre_unidad,
            'simbolo' => $request->simbolo,
        ]);
        auth()->user()->notify(new UNidadMedidaNotification('update', $unidad->nombre_unidad));
        return redirect()->back()->with('success', 'Unidad de medida actualizada con éxito.');
    }
    public function UnidadMedicionDelete($id)
    {
        $unidad = UnidadMedida::findOrFail($id);
        $unidad->delete();
        auth()->user()->notify(new UNidadMedidaNotification('delete', $unidad->nombre_unidad));
        return redirect()->back()->with('success', 'Unidad de medida eliminada con éxito.');
    }
}
