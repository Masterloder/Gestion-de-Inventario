<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Materiales;
use Illuminate\Database\Seeder;

class MaterialesSeeder extends Seeder
{
    public function run(): void
    {
        {
            $material = [
                ['nombre' => 'Madera', 'descripcion' => 'Material natural utilizado en construcción y fabricación de muebles.', 'unidad_medida' => 'M3', 'categoria' => 'Materiales Orgánicos', 'categoria_especifica' => 'Estructural'],
                ['nombre' => 'Acero', 'descripcion' => 'Material metálico resistente y duradero, comúnmente usado en estructuras.', 'unidad_medida' => 'Kg', 'categoria' => 'Materiales Metálicos', 'categoria_especifica' => 'Estructural'],
                ['nombre' => 'Lona', 'descripcion' => 'Material utilizado para cubrir o proteger objetos.', 'unidad_medida' => 'M3', 'categoria' => 'Materiales Orgánicos', 'categoria_especifica' => 'Cerramiento'],
                ['nombre' => 'Vidrio', 'descripcion' => 'Material transparente utilizado en ventanas, botellas y otros productos.', 'unidad_medida' => 'M3', 'categoria' => 'Materiales Cerámicos y vítreos', 'categoria_especifica' => 'Cerramiento'],
                ['nombre' => 'Hormigón', 'descripcion' => 'Material compuesto utilizado en construcción, hecho de cemento, agua y agregados.', 'unidad_medida' => 'M3', 'categoria' => 'Materiales Compuestos', 'categoria_especifica' => 'Estructural'],
            ['nombre' => 'Aluminio', 'descripcion' => 'Metal ligero y resistente a la corrosión, usado en estructuras y acabados.', 'unidad_medida' => 'Kg', 'categoria' => 'Materiales Metálicos', 'categoria_especifica' => 'Acabado'],
            ['nombre' => 'Cobre', 'descripcion' => 'Metal conductor utilizado en instalaciones eléctricas y tuberías.', 'unidad_medida' => 'Kg', 'categoria' => 'Materiales Metálicos', 'categoria_especifica' => 'Instalaciones'],
            ['nombre' => 'PVC', 'descripcion' => 'Plástico resistente usado en tuberías y recubrimientos.', 'unidad_medida' => 'M', 'categoria' => 'Materiales Poliméricos', 'categoria_especifica' => 'Instalaciones'],
            ['nombre' => 'Yeso', 'descripcion' => 'Material de acabado para paredes y techos.', 'unidad_medida' => 'Kg', 'categoria' => 'Materiales Cerámicos y vítreos', 'categoria_especifica' => 'Acabado'],
            ['nombre' => 'Arena', 'descripcion' => 'Agregado fino utilizado en mezclas de construcción.', 'unidad_medida' => 'M3', 'categoria' => 'Materiales Granulares', 'categoria_especifica' => 'Agregado'],
            ['nombre' => 'Grava', 'descripcion' => 'Agregado grueso para mezclas de hormigón.', 'unidad_medida' => 'M3', 'categoria' => 'Materiales Granulares', 'categoria_especifica' => 'Agregado'],
            ['nombre' => 'Cemento', 'descripcion' => 'Material aglutinante para la fabricación de hormigón y mortero.', 'unidad_medida' => 'Kg', 'categoria' => 'Materiales Compuestos', 'categoria_especifica' => 'Aglutinante'],
            ['nombre' => 'Ladrillo', 'descripcion' => 'Pieza cerámica para construcción de muros.', 'unidad_medida' => 'Unidad', 'categoria' => 'Materiales Cerámicos y vítreos', 'categoria_especifica' => 'Estructural'],
            ['nombre' => 'Bloque de concreto', 'descripcion' => 'Elemento prefabricado para muros y cerramientos.', 'unidad_medida' => 'Unidad', 'categoria' => 'Materiales Compuestos', 'categoria_especifica' => 'Estructural'],
            ['nombre' => 'Teja', 'descripcion' => 'Elemento para cubiertas y techos.', 'unidad_medida' => 'Unidad', 'categoria' => 'Materiales Cerámicos y vítreos', 'categoria_especifica' => 'Cubierta'],
            ['nombre' => 'Pintura', 'descripcion' => 'Revestimiento líquido para protección y decoración.', 'unidad_medida' => 'L', 'categoria' => 'Materiales Químicos', 'categoria_especifica' => 'Acabado'],
            ['nombre' => 'Clavos', 'descripcion' => 'Elementos metálicos para fijación.', 'unidad_medida' => 'Kg', 'categoria' => 'Materiales Metálicos', 'categoria_especifica' => 'Fijación'],
            ['nombre' => 'Tornillos', 'descripcion' => 'Elementos roscados para unión de piezas.', 'unidad_medida' => 'Kg', 'categoria' => 'Materiales Metálicos', 'categoria_especifica' => 'Fijación'],
            ['nombre' => 'Silicona', 'descripcion' => 'Sellador flexible para juntas y uniones.', 'unidad_medida' => 'Cartucho', 'categoria' => 'Materiales Químicos', 'categoria_especifica' => 'Sellado'],
            ['nombre' => 'Espuma de poliuretano', 'descripcion' => 'Aislante térmico y acústico en spray.', 'unidad_medida' => 'L', 'categoria' => 'Materiales Poliméricos', 'categoria_especifica' => 'Aislante'],
            ['nombre' => 'Poliestireno expandido', 'descripcion' => 'Material ligero para aislamiento.', 'unidad_medida' => 'M2', 'categoria' => 'Materiales Poliméricos', 'categoria_especifica' => 'Aislante'],
            ['nombre' => 'Fibra de vidrio', 'descripcion' => 'Material compuesto para aislamiento y refuerzo.', 'unidad_medida' => 'M2', 'categoria' => 'Materiales Compuestos', 'categoria_especifica' => 'Aislante'],
            ['nombre' => 'Azulejo', 'descripcion' => 'Baldosa cerámica para revestimientos.', 'unidad_medida' => 'M2', 'categoria' => 'Materiales Cerámicos y vítreos', 'categoria_especifica' => 'Acabado'],
            ['nombre' => 'Mármol', 'descripcion' => 'Piedra natural para acabados de lujo.', 'unidad_medida' => 'M2', 'categoria' => 'Materiales Pétreos', 'categoria_especifica' => 'Acabado'],
            ['nombre' => 'Granito', 'descripcion' => 'Roca ígnea usada en encimeras y pisos.', 'unidad_medida' => 'M2', 'categoria' => 'Materiales Pétreos', 'categoria_especifica' => 'Acabado'],
            ['nombre' => 'Piedra', 'descripcion' => 'Material natural para muros y pavimentos.', 'unidad_medida' => 'M3', 'categoria' => 'Materiales Pétreos', 'categoria_especifica' => 'Estructural'],
            ['nombre' => 'Cartón yeso', 'descripcion' => 'Panel para tabiquería interior.', 'unidad_medida' => 'M2', 'categoria' => 'Materiales Compuestos', 'categoria_especifica' => 'Acabado'],
            ['nombre' => 'Tubería de cobre', 'descripcion' => 'Conducto para instalaciones hidráulicas.', 'unidad_medida' => 'M', 'categoria' => 'Materiales Metálicos', 'categoria_especifica' => 'Instalaciones'],
            ['nombre' => 'Tubería de PVC', 'descripcion' => 'Conducto plástico para agua y desagüe.', 'unidad_medida' => 'M', 'categoria' => 'Materiales Poliméricos', 'categoria_especifica' => 'Instalaciones'],
            ['nombre' => 'Cable eléctrico', 'descripcion' => 'Conductor para instalaciones eléctricas.', 'unidad_medida' => 'M', 'categoria' => 'Materiales Metálicos', 'categoria_especifica' => 'Instalaciones'],
            ['nombre' => 'Malla electrosoldada', 'descripcion' => 'Refuerzo metálico para hormigón.', 'unidad_medida' => 'M2', 'categoria' => 'Materiales Metálicos', 'categoria_especifica' => 'Refuerzo'],
            ['nombre' => 'Geotextil', 'descripcion' => 'Tela sintética para separación y filtración.', 'unidad_medida' => 'M2', 'categoria' => 'Materiales Poliméricos', 'categoria_especifica' => 'Aislante'],
            ['nombre' => 'Impermeabilizante', 'descripcion' => 'Producto para evitar filtraciones de agua.', 'unidad_medida' => 'L', 'categoria' => 'Materiales Químicos', 'categoria_especifica' => 'Protección'],
            ['nombre' => 'Mortero', 'descripcion' => 'Mezcla de cemento, arena y agua para unir ladrillos.', 'unidad_medida' => 'Kg', 'categoria' => 'Materiales Compuestos', 'categoria_especifica' => 'Aglutinante'],
            ['nombre' => 'Policarbonato', 'descripcion' => 'Plástico transparente y resistente para cubiertas.', 'unidad_medida' => 'M2', 'categoria' => 'Materiales Poliméricos', 'categoria_especifica' => 'Cubierta'],
            ['nombre' => 'Chapa metálica', 'descripcion' => 'Lámina de metal para cubiertas y cerramientos.', 'unidad_medida' => 'M2', 'categoria' => 'Materiales Metálicos', 'categoria_especifica' => 'Cubierta'],
            ['nombre' => 'Panel sandwich', 'descripcion' => 'Panel aislante para fachadas y cubiertas.', 'unidad_medida' => 'M2', 'categoria' => 'Materiales Compuestos', 'categoria_especifica' => 'Aislante'],
            ['nombre' => 'Tarima flotante', 'descripcion' => 'Revestimiento de suelo de madera o sintético.', 'unidad_medida' => 'M2', 'categoria' => 'Materiales Orgánicos', 'categoria_especifica' => 'Acabado'],
            ['nombre' => 'Linóleo', 'descripcion' => 'Revestimiento natural para suelos.', 'unidad_medida' => 'M2', 'categoria' => 'Materiales Orgánicos', 'categoria_especifica' => 'Acabado'],
            ['nombre' => 'Adhesivo de montaje', 'descripcion' => 'Pegamento fuerte para fijación de materiales.', 'unidad_medida' => 'Cartucho', 'categoria' => 'Materiales Químicos', 'categoria_especifica' => 'Fijación'],
            ['nombre' => 'Espuma fenólica', 'descripcion' => 'Aislante térmico rígido.', 'unidad_medida' => 'M2', 'categoria' => 'Materiales Poliméricos', 'categoria_especifica' => 'Aislante'],
            ['nombre' => 'Lana mineral', 'descripcion' => 'Aislante térmico y acústico de origen mineral.', 'unidad_medida' => 'M2', 'categoria' => 'Materiales Compuestos', 'categoria_especifica' => 'Aislante'],
            ['nombre' => 'Panel de yeso', 'descripcion' => 'Placa para paredes interiores.', 'unidad_medida' => 'M2', 'categoria' => 'Materiales Compuestos', 'categoria_especifica' => 'Acabado'],
            ['nombre' => 'Tubería de polietileno', 'descripcion' => 'Tubería flexible para agua potable.', 'unidad_medida' => 'M', 'categoria' => 'Materiales Poliméricos', 'categoria_especifica' => 'Instalaciones'],
            ['nombre' => 'Cinta asfáltica', 'descripcion' => 'Cinta impermeable para sellado.', 'unidad_medida' => 'Rollo', 'categoria' => 'Materiales Químicos', 'categoria_especifica' => 'Sellado'],
            ['nombre' => 'Cinta de enmascarar', 'descripcion' => 'Cinta adhesiva para protección en pintura.', 'unidad_medida' => 'Rollo', 'categoria' => 'Materiales Químicos', 'categoria_especifica' => 'Protección'],
            ['nombre' => 'Tubo corrugado', 'descripcion' => 'Tubo flexible para cables eléctricos.', 'unidad_medida' => 'M', 'categoria' => 'Materiales Poliméricos', 'categoria_especifica' => 'Instalaciones'],
            ['nombre' => 'Perfil de aluminio', 'descripcion' => 'Elemento estructural ligero para marcos.', 'unidad_medida' => 'M', 'categoria' => 'Materiales Metálicos', 'categoria_especifica' => 'Estructural'],
            ['nombre' => 'Rejilla metálica', 'descripcion' => 'Elemento para ventilación o protección.', 'unidad_medida' => 'M2', 'categoria' => 'Materiales Metálicos', 'categoria_especifica' => 'Cerramiento'],
            ['nombre' => 'Puerta de madera', 'descripcion' => 'Elemento de cerramiento interior o exterior.', 'unidad_medida' => 'Unidad', 'categoria' => 'Materiales Orgánicos', 'categoria_especifica' => 'Cerramiento'],
            ['nombre' => 'Ventana de aluminio', 'descripcion' => 'Elemento para iluminación y ventilación.', 'unidad_medida' => 'Unidad', 'categoria' => 'Materiales Metálicos', 'categoria_especifica' => 'Cerramiento'],
            ['nombre' => 'Persiana', 'descripcion' => 'Sistema de protección solar para ventanas.', 'unidad_medida' => 'Unidad', 'categoria' => 'Materiales Poliméricos', 'categoria_especifica' => 'Cerramiento'],
            ['nombre' => 'Baldosa hidráulica', 'descripcion' => 'Pieza decorativa para suelos.', 'unidad_medida' => 'M2', 'categoria' => 'Materiales Cerámicos y vítreos', 'categoria_especifica' => 'Acabado'],
            ['nombre' => 'Mosaico vítreo', 'descripcion' => 'Pieza pequeña de vidrio para decoración.', 'unidad_medida' => 'M2', 'categoria' => 'Materiales Cerámicos y vítreos', 'categoria_especifica' => 'Acabado'],
            ['nombre' => 'Panel solar', 'descripcion' => 'Dispositivo para generación de energía solar.', 'unidad_medida' => 'Unidad', 'categoria' => 'Materiales Compuestos', 'categoria_especifica' => 'Instalaciones'],
            ['nombre' => 'Tubo de acero galvanizado', 'descripcion' => 'Tubería resistente a la corrosión.', 'unidad_medida' => 'M', 'categoria' => 'Materiales Metálicos', 'categoria_especifica' => 'Instalaciones'],
            ];
            foreach ($material as $mat) {
                $m = new Materiales();
                $m->nombre = $mat['nombre'];
                $m->descripcion = $mat['descripcion'];
                $m->unidad_medida = $mat['unidad_medida'];
                $m->categoria = $mat['categoria'];
                $m->categoria_especifica = $mat['categoria_especifica'];
                $m->created_at = now();
                $m->updated_at = now();
                $m->save();
            }
        }
    }
}
