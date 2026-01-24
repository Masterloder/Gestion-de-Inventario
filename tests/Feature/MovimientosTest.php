<?php

namespace Tests\Feature;

use App\Http\Middleware\CheckAutorizacion;
use App\Models\Almacenes;
use App\Models\CategoriaEspecifica;
use App\Models\CategoriaMaterial;
use App\Models\Materiales;
use App\Models\Provedores;
use App\Models\UnidadMedida;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MovimientosTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function un_usuario_puede_registrar_un_ingreso_de_material()
    {
        // 1. ARREGLAR: Datos base
        $usuario = User::factory()->create();
        $almacen = Almacenes::factory()->create();
        $proveedor = Provedores::factory()->create();

        $unidad = UnidadMedida::create(['nombre_unidad' => 'Metro', 'simbolo' => 'm']);
        $categoria = CategoriaMaterial::create(['nombre_categoria' => 'Ferretería']);
        $subCat = CategoriaEspecifica::create(['nombre_especifico' => 'Clavos', 'categoria_id' => $categoria->id]);

        $material = Materiales::create([
            'nombre' => 'Clavo 2 pulgadas',
            'unidad_medida_id' => $unidad->id,
            'categoria_id' => $categoria->id,
            'categoria_especifica_id' => $subCat->id,
        ]);

        $datos = [
            'id_almacen'      => $almacen->id,
            'fecha_operacion' => now()->format('Y-m-d'),
            'id_material'     => $material->id,
            'cantidad'        => 100,
            'id_proveedor'    => $proveedor->id,
            'fecha_caducidad' => now()->addYear()->format('Y-m-d'),
        ];

        // 2. ACTUAR
        // Usamos withoutMiddleware() para que el middleware 'autorizacion' no nos de un 403 o 404
        $response = $this->actingAs($usuario)
            ->withoutMiddleware(CheckAutorizacion::class) // Ajusta el nombre de tu middleware si es necesario o usa ->withoutMiddleware() para todos
            ->post(route('movimientos.ingreso'), $datos);

        // 3. ASERCIÓN
        $response->assertRedirect('/panel_de_control/Logistica');
        $response->assertSessionHas('success', 'Ingreso de material registrado correctamente.');

        // Verificamos en la tabla 'inventario' (según tu menú lateral)
        $this->assertDatabaseHas('inventario', [
            'id_material' => $material->id,
            'id_almacen'  => $almacen->id,
            'cantidad_actual' => 100
        ]);

        // Verificamos en la tabla 'movimientos_inventario' (visto en tu captura)
        $this->assertDatabaseHas('movimientos_inventario', [
            'tipo_movimiento' => 'Entrada',
            'id_material'     => $material->id,
            'cantidad'        => 100
        ]);
    }
    #[Test]
    public function no_se_puede_registrar_salida_si_el_stock_es_insuficiente()
    {
        // 1. ARREGLAR: Preparar escenario con poco stock
        $usuario = User::factory()->create();
        $almacen = Almacenes::factory()->create();

        // Creamos las dependencias mínimas para el material
        $unidad = UnidadMedida::create(['nombre_unidad' => 'Litro', 'simbolo' => 'L']);
        $categoria = CategoriaMaterial::create(['nombre_categoria' => 'Químicos']);
        $subCat = CategoriaEspecifica::create(['nombre_especifico' => 'Limpieza', 'categoria_id' => $categoria->id]);

        $material = Materiales::create([
            'nombre' => 'Cloro',
            'unidad_medida_id' => $unidad->id,
            'categoria_id' => $categoria->id,
            'categoria_especifica_id' => $subCat->id,
        ]);

        // PRE-CARGAMOS STOCK: Solo 10 unidades en el inventario
        \DB::table('inventario')->insert([
            'id_material' => $material->id,
            'id_almacen' => $almacen->id,
            'cantidad_actual' => 10,
            'punto_reorden' => 0
        ]);

        // 2. ACTUAR: Intentamos sacar 100 unidades (usando la ruta de salida)
        $datosSalida = [
            'id_almacen1' => $almacen->id, // Tu controlador usa id_almacen1 para salidas
            'fecha_operacion' => now()->format('Y-m-d'),
            'ubicacion_entrega' => 'Pasillo B',
            'id_material1' => $material->id, // Tu controlador usa id_material1 para salidas
            'cantidad' => 100
        ];

        $response = $this->actingAs($usuario)
            ->withoutMiddleware(CheckAutorizacion::class)
            ->post(route('movimientos.salida'), $datosSalida);

        // 3. ASERCIÓN
        // A. El controlador debe redirigir de vuelta con errores
        $response->assertRedirect();
        $response->assertSessionHasErrors();

        // B. El stock en la tabla 'inventario' NO debe haber cambiado (debe seguir en 10)
        $this->assertDatabaseHas('inventario', [
            'id_material' => $material->id,
            'cantidad_actual' => 10
        ]);

        // C. NO debe haberse creado ningún registro en 'movimientos_inventario'
        $this->assertDatabaseMissing('movimientos_inventario', [
            'tipo_movimiento' => 'Salida',
            'id_material' => $material->id,
            'cantidad' => 100
        ]);
    }

    #[Test]
    public function un_usuario_puede_registrar_una_salida_si_hay_stock_suficiente()
    {
        // 1. ARREGLAR: Preparar escenario con stock inicial
        $usuario = User::factory()->create();
        $almacen = Almacenes::factory()->create();

        $unidad = UnidadMedida::create(['nombre_unidad' => 'Pieza', 'simbolo' => 'pza']);
        $categoria = CategoriaMaterial::create(['nombre_categoria' => 'Herramientas']);
        $subCat = CategoriaEspecifica::create(['nombre_especifico' => 'Manuales', 'categoria_id' => $categoria->id]);

        $material = Materiales::create([
            'nombre' => 'Martillo',
            'unidad_medida_id' => $unidad->id,
            'categoria_id' => $categoria->id,
            'categoria_especifica_id' => $subCat->id,
        ]);

        // Insertamos 50 unidades iniciales directamente en la DB
        \DB::table('inventario')->insert([
            'id_material' => $material->id,
            'id_almacen' => $almacen->id,
            'cantidad_actual' => 50,
            'punto_reorden' => 5
        ]);

        // 2. ACTUAR: Intentamos sacar 20 unidades
        $datosSalida = [
            'id_almacen1' => $almacen->id,
            'fecha_operacion' => now()->format('Y-m-d'),
            'ubicacion_entrega' => 'Obra Norte',
            'id_material1' => $material->id,
            'cantidad' => 20
        ];

        $response = $this->actingAs($usuario)
            ->withoutMiddleware(CheckAutorizacion::class)
            ->post(route('movimientos.salida'), $datosSalida);

        // 3. ASERCIÓN
        $response->assertRedirect('/Movimientos/tabla');
        // Verificamos que el stock bajó de 50 a 30 (50 - 20 = 30)
        $this->assertDatabaseHas('inventario', [
            'id_material' => $material->id,
            'id_almacen' => $almacen->id,
            'cantidad_actual' => 30
        ]);

        // Verificamos que se grabó el registro de salida
        $this->assertDatabaseHas('movimientos_inventario', [
            'tipo_movimiento' => 'Salida',
            'id_material' => $material->id,
            'cantidad' => 20,
            'destino' => 'Obra Norte'
        ]);
    }

    #[Test]
    public function no_se_puede_registrar_ingreso_sin_datos_obligatorios()
    {
        $usuario = User::factory()->create();

        // Enviamos un formulario vacío
        $response = $this->actingAs($usuario)
            ->withoutMiddleware(CheckAutorizacion::class)
            ->post(route('movimientos.ingreso'), []); // Datos vacíos

        // ASERCIÓN
        // El sistema debe redirigir de vuelta (back) y tener errores en la sesión
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['id_material', 'cantidad', 'id_almacen']);
    }
}
