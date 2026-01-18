<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;

class RespaldoController extends Controller
{
    public function downloadSql()
    {
        $tables = DB::select('SHOW TABLES');
        $dbName = config('database.connections.mysql.database');

        // 1. Generar el contenido SQL (Estructura + Datos)
        $sql = "-- Respaldo: $dbName\n-- Generado: " . date('Y-m-d H:i:s') . "\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($tables as $table) {
            $tableName = array_values((array)$table)[0];

            // Estructura
            $createTable = DB::select("SHOW CREATE TABLE `$tableName`")[0];
            $sql .= "\n-- Tabla: `$tableName` --\n";
            $sql .= ((array)$createTable)['Create Table'] . ";\n\n";

            // Datos
            $rows = DB::table($tableName)->get();
            foreach ($rows as $row) {
                $values = array_map(function ($value) {
                    if (is_null($value)) return 'NULL';
                    return "'" . addslashes($value) . "'";
                }, (array)$row);

                $sql .= "INSERT INTO `$tableName` VALUES (" . implode(', ', $values) . ");\n";
            }
        }
        $sql .= "\nSET FOREIGN_KEY_CHECKS=1;";

        // 2. Definir nombre y ruta de guardado
        $fileName = "respaldo_" . date('dmY_His') . ".sql";
        $path = "backups/" . $fileName;

        // 3. GUARDAR EL ARCHIVO EN EL DISCO LOCAL (storage/app/backups)
        Storage::disk('local')->put($path, $sql);

        // 4. RETORNAR LA DESCARGA AL USUARIO
        // Esto abrirá el cuadro de diálogo del navegador para elegir ubicación
        return Storage::disk('local')->download($path);
    }
    public function listBackups()
    {
        // Obtiene todos los archivos de la carpeta backups
        $files = Storage::disk('local')->files('backups');
        return view('Configuracion.Respaldo_backup', compact('files'));
    }
    public function restore(Request $request)
    {
        // 1. Validar que se subió un archivo .sql
        $request->validate([
            'backup_file' => 'required|file'
        ]);

        try {
            // 2. Leer el contenido del archivo subido
            $file = $request->file('backup_file');
            $sql = file_get_contents($file->getRealPath());

            // 3. Desactivar restricciones de llaves foráneas
            DB::unprepared("SET FOREIGN_KEY_CHECKS=0;");

            // 4. Ejecutar el SQL (Esto borrará y recreará tablas según el contenido del archivo)
            // Usamos unprepared para ejecutar múltiples sentencias a la vez
            DB::unprepared($sql);

            DB::unprepared("SET FOREIGN_KEY_CHECKS=1;");

            return back()->with('success', '¡Sistema restaurado con éxito!');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al restaurar: ' . $e->getMessage());
        }
    }

    public function index()
    {
        // Obtenemos los archivos de la carpeta local 'backups'
        $files = Storage::disk('local')->files('backups');

        $backups = [];
        foreach ($files as $file) {
            $backups[] = [
                'name' => basename($file),
                'size' => round(Storage::disk('local')->size($file) / 1024, 2) . ' KB',
                'date' => date('Y-m-d H:i:s', Storage::disk('local')->lastModified($file)),
                'path' => $file
            ];
        }

        // Invertimos para ver el más reciente primero
        $backups = array_reverse($backups);

        return view('Configuracion.Respaldo_backup', compact('backups'));
    }

    public function restoreFromServer($fileName)
    {
        set_time_limit(600);
        ini_set('memory_limit', '1024M');

        try {
            $path = 'backups/' . $fileName;
            if (!Storage::disk('local')->exists($path)) {
                return back()->with('error', 'El archivo no existe.');
            }

            $sql = Storage::disk('local')->get($path);

            // 1. DESACTIVAR LLAVES PARA LIMPIEZA
            DB::unprepared("SET FOREIGN_KEY_CHECKS=0;");

            // 2. OBTENER Y BORRAR TODAS LAS TABLAS ACTUALES
            $dbName = config('database.connections.mysql.database');
            $tables = DB::select('SHOW TABLES');
            $columnName = "Tables_in_" . $dbName;

            foreach ($tables as $table) {
                $tableName = $table->$columnName;
                DB::unprepared("DROP TABLE IF EXISTS `$tableName`;");
            }

            // 3. EJECUTAR EL SQL DEL RESPALDO (Crea tablas e inserta datos)
            // Lo ejecutamos todo junto. Si el archivo fue generado con el código 
            // anterior de DB::table()->get(), unprepared lo procesará bien.
            DB::unprepared($sql);

            // 4. REACTIVAR LLAVES
            DB::unprepared("SET FOREIGN_KEY_CHECKS=1;");

            return back()->with('success', "¡Base de datos vaciada y restaurada con éxito!");
        } catch (\Exception $e) {
            // Reactivar llaves por seguridad si algo falla
            DB::unprepared("SET FOREIGN_KEY_CHECKS=1;");

            \Log::error("Error en restauración: " . $e->getMessage());
            return back()->with('error', 'Error al restaurar: ' . $e->getMessage());
        }
    }
}
