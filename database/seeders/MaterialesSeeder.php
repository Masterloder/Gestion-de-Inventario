<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Materiales;
use Illuminate\Database\Seeder;

class MaterialesSeeder extends Seeder
{
    public function run(): void
    { {
            $material = [
                // Materiales Petreos
                ['nombre' => 'Arena', 'descripcion' => 'Agregado fino utilizado en mezclas de construcción.', 'unidad_medida_id' => 5, 'categoria_id' => 1, 'categoria_especifica_id' => 1], // Naturales
                ['nombre' => 'Grava', 'descripcion' => 'Agregado grueso para mezclas de hormigón.', 'unidad_medida_id' => 5, 'categoria_id' => 1, 'categoria_especifica_id' => 1], // Naturales
                ['nombre' => 'Piedra', 'descripcion' => 'Material natural para muros y pavimentos.', 'unidad_medida_id' => 5, 'categoria_id' => 1, 'categoria_especifica_id' => 1], // Naturales
                ['nombre' => 'Granito', 'descripcion' => 'Roca ígnea usada en encimeras y pisos.', 'unidad_medida_id' => 4, 'categoria_id' => 1, 'categoria_especifica_id' => 1], // Naturales
                ['nombre' => 'Mármol', 'descripcion' => 'Piedra natural para acabados de lujo.', 'unidad_medida_id' => 4, 'categoria_id' => 1, 'categoria_especifica_id' => 1], // Naturales

                // Ceramicos y Porcelanas
                ['nombre' => 'Ladrillo', 'descripcion' => 'Pieza cerámica para construcción de muros.', 'unidad_medida_id' => 6, 'categoria_id' => 2, 'categoria_especifica_id' => 3], // Cerámicas Gruesas
                ['nombre' => 'Azulejo', 'descripcion' => 'Baldosa cerámica para revestimientos.', 'unidad_medida_id' => 4, 'categoria_id' => 2, 'categoria_especifica_id' => 4], // Cerámicas Finas
                ['nombre' => 'Baldosa hidráulica', 'descripcion' => 'Pieza decorativa para suelos.', 'unidad_medida_id' => 4, 'categoria_id' => 2, 'categoria_especifica_id' => 4], // Cerámicas Finas
                ['nombre' => 'Mosaico vítreo', 'descripcion' => 'Pieza pequeña de vidrio para decoración.', 'unidad_medida_id' => 4, 'categoria_id' => 2, 'categoria_especifica_id' => 4], // Cerámicas Finas

                // Materiales Compuestos
                ['nombre' => 'Hormigón', 'descripcion' => 'Material compuesto utilizado en construcción, hecho de cemento, agua y agregados.', 'unidad_medida_id' => 5, 'categoria_id' => 3, 'categoria_especifica_id' => 5], // Laminados
                ['nombre' => 'Mortero', 'descripcion' => 'Mezcla de cemento, arena y agua para unir ladrillos.', 'unidad_medida_id' => 1, 'categoria_id' => 3, 'categoria_especifica_id' => 5], // Laminados
                ['nombre' => 'Panel sandwich', 'descripcion' => 'Panel aislante para fachadas y cubiertas.', 'unidad_medida_id' => 4, 'categoria_id' => 3, 'categoria_especifica_id' => 6], // Laminados
                ['nombre' => 'Fibra de vidrio', 'descripcion' => 'Material compuesto para aislamiento y refuerzo.', 'unidad_medida_id' => 4, 'categoria_id' => 3, 'categoria_especifica_id' => 4], // Reforzados con Fibra
                ['nombre' => 'Panel de yeso', 'descripcion' => 'Placa para paredes interiores.', 'unidad_medida_id' => 4, 'categoria_id' => 3, 'categoria_especifica_id' => 6], // Laminados
                ['nombre' => 'Cartón yeso', 'descripcion' => 'Panel para tabiquería interior.', 'unidad_medida_id' => 4, 'categoria_id' => 3, 'categoria_especifica_id' => 6], // Laminados

                // Materiales Metalicos
                ['nombre' => 'Acero', 'descripcion' => 'Material metálico resistente y duradero, comúnmente usado en estructuras.', 'unidad_medida_id' => 1, 'categoria_id' => 4, 'categoria_especifica_id' => 13], // Metales Pesados
                ['nombre' => 'Aluminio', 'descripcion' => 'Metal ligero y resistente a la corrosión, usado en estructuras y acabados.', 'unidad_medida_id' => 1, 'categoria_id' => 4, 'categoria_especifica_id' => 15], // Metales Ligeros
                ['nombre' => 'Cobre', 'descripcion' => 'Metal conductor utilizado en instalaciones eléctricas y tuberías.', 'unidad_medida_id' => 1, 'categoria_id' => 4, 'categoria_especifica_id' => 14], // Metales No Ferrosos
                ['nombre' => 'Tubería de cobre', 'descripcion' => 'Conducto para instalaciones hidráulicas.', 'unidad_medida_id' => 3, 'categoria_id' => 4, 'categoria_especifica_id' => 14], // Metales No Ferrosos
                ['nombre' => 'Tubo de acero galvanizado', 'descripcion' => 'Tubería resistente a la corrosión.', 'unidad_medida_id' => 3, 'categoria_id' => 4, 'categoria_especifica_id' => 13], // Metales Pesados
                ['nombre' => 'Clavos', 'descripcion' => 'Elementos metálicos para fijación.', 'unidad_medida_id' => 1, 'categoria_id' => 4, 'categoria_especifica_id' => 13], // Metales Pesados
                ['nombre' => 'Tornillos', 'descripcion' => 'Elementos roscados para unión de piezas.', 'unidad_medida_id' => 1, 'categoria_id' => 4, 'categoria_especifica_id' => 13], // Metales Pesados
                ['nombre' => 'Perfil de aluminio', 'descripcion' => 'Elemento estructural ligero para marcos.', 'unidad_medida_id' => 3, 'categoria_id' => 4, 'categoria_especifica_id' => 15], // Metales Ligeros
                ['nombre' => 'Chapa metálica', 'descripcion' => 'Lámina de metal para cubiertas y cerramientos.', 'unidad_medida_id' => 4, 'categoria_id' => 4, 'categoria_especifica_id' => 13], // Metales Pesados
                ['nombre' => 'Malla electrosoldada', 'descripcion' => 'Refuerzo metálico para hormigón.', 'unidad_medida_id' => 4, 'categoria_id' => 4, 'categoria_especifica_id' => 13], // Metales Pesados
                ['nombre' => 'Rejilla metálica', 'descripcion' => 'Elemento para ventilación o protección.', 'unidad_medida_id' => 4, 'categoria_id' => 4, 'categoria_especifica_id' => 13], // Metales Pesados
                ['nombre' => 'Ventana de aluminio', 'descripcion' => 'Elemento para iluminación y ventilación.', 'unidad_medida_id' => 6, 'categoria_id' => 4, 'categoria_especifica_id' => 15], // Metales Ligeros

                // Materiales Organicos
                ['nombre' => 'Madera', 'descripcion' => 'Material natural utilizado en construcción y fabricación de muebles.', 'unidad_medida_id' => 5, 'categoria_id' => 5, 'categoria_especifica_id' => 16], // Madera y Derivados
                ['nombre' => 'Puerta de madera', 'descripcion' => 'Elemento de cerramiento interior o exterior.', 'unidad_medida_id' => 6, 'categoria_id' => 5, 'categoria_especifica_id' => 16], // Madera y Derivados
                ['nombre' => 'Tarima flotante', 'descripcion' => 'Revestimiento de suelo de madera o sintético.', 'unidad_medida_id' => 4, 'categoria_id' => 5, 'categoria_especifica_id' => 21], // Recubrimientos y Acabados Orgánicos
                ['nombre' => 'Linóleo', 'descripcion' => 'Revestimiento natural para suelos.', 'unidad_medida_id' => 4, 'categoria_id' => 5, 'categoria_especifica_id' => 21], // Recubrimientos y Acabados Orgánicos

                // Materiales Aislantes
                ['nombre' => 'Espuma de poliuretano', 'descripcion' => 'Aislante térmico y acústico en spray.', 'unidad_medida_id' => 2, 'categoria_id' => 6, 'categoria_especifica_id' => 18], // Aislantes de Origen Sintético
                ['nombre' => 'Poliestireno expandido', 'descripcion' => 'Material ligero para aislamiento.', 'unidad_medida_id' => 4, 'categoria_id' => 6, 'categoria_especifica_id' => 18], // Aislantes de Origen Sintético
                ['nombre' => 'Lana mineral', 'descripcion' => 'Aislante térmico y acústico de origen mineral.', 'unidad_medida_id' => 4, 'categoria_id' => 6, 'categoria_especifica_id' => 17], // Aislantes de Origen Mineral
                ['nombre' => 'Espuma fenólica', 'descripcion' => 'Aislante térmico rígido.', 'unidad_medida_id' => 4, 'categoria_id' => 6, 'categoria_especifica_id' => 18], // Aislantes de Origen Sintético
                ['nombre' => 'Geotextil', 'descripcion' => 'Tela sintética para separación y filtración.', 'unidad_medida_id' => 4, 'categoria_id' => 6, 'categoria_especifica_id' => 18], // Aislantes de Origen Sintético

                // Materiales Quimicos
                ['nombre' => 'Pintura', 'descripcion' => 'Revestimiento líquido para protección y decoración.', 'unidad_medida_id' => 2, 'categoria_id' => 7, 'categoria_especifica_id' => 27], // Polímeros Químicos
                ['nombre' => 'Impermeabilizante', 'descripcion' => 'Producto para evitar filtraciones de agua.', 'unidad_medida_id' => 2, 'categoria_id' => 7, 'categoria_especifica_id' => 27], // Polímeros Químicos
                ['nombre' => 'Silicona', 'descripcion' => 'Sellador flexible para juntas y uniones.', 'unidad_medida_id' => 13, 'categoria_id' => 7, 'categoria_especifica_id' => 27], // Polímeros Químicos
                ['nombre' => 'Adhesivo de montaje', 'descripcion' => 'Pegamento fuerte para fijación de materiales.', 'unidad_medida_id' => 13, 'categoria_id' => 7, 'categoria_especifica_id' => 27], // Polímeros Químicos

                // Materiales Refractarios
                // (No hay materiales en tu lista original que encajen claramente aquí, puedes agregar si lo deseas)

                // Materiales Sinteticos
                ['nombre' => 'PVC', 'descripcion' => 'Plástico resistente usado en tuberías y recubrimientos.', 'unidad_medida_id' => 3, 'categoria_id' => 9, 'categoria_especifica_id' => 42], // Fontanería y Saneamiento
                ['nombre' => 'Tubería de PVC', 'descripcion' => 'Conducto plástico para agua y desagüe.', 'unidad_medida_id' => 3, 'categoria_id' => 9, 'categoria_especifica_id' => 42], // Fontanería y Saneamiento
                ['nombre' => 'Tubería de polietileno', 'descripcion' => 'Tubería flexible para agua potable.', 'unidad_medida_id' => 3, 'categoria_id' => 9, 'categoria_especifica_id' => 42], // Fontanería y Saneamiento
                ['nombre' => 'Tubo corrugado', 'descripcion' => 'Tubo flexible para cables eléctricos.', 'unidad_medida_id' => 3, 'categoria_id' => 9, 'categoria_especifica_id' => 42], // Fontanería y Saneamiento
                ['nombre' => 'Panel solar', 'descripcion' => 'Dispositivo para generación de energía solar.', 'unidad_medida_id' => 6, 'categoria_id' => 9, 'categoria_especifica_id' => 44], // Refuerzos Estructurales
                ['nombre' => 'Cinta asfáltica', 'descripcion' => 'Cinta impermeable para sellado.', 'unidad_medida_id' => 7, 'categoria_id' => 9, 'categoria_especifica_id' => 45], // Membranas Impermeabilizantes
                ['nombre' => 'Cinta de enmascarar', 'descripcion' => 'Cinta adhesiva para protección en pintura.', 'unidad_medida_id' => 7, 'categoria_id' => 9, 'categoria_especifica_id' => 45], // Membranas Impermeabilizantes
                ['nombre' => 'Lona', 'descripcion' => 'Material utilizado para cubrir o proteger objetos.', 'unidad_medida_id' => 5, 'categoria_id' => 9, 'categoria_especifica_id' => 45], // Membranas Impermeabilizantes
                ['nombre' => 'Policarbonato', 'descripcion' => 'Plástico transparente y resistente para cubiertas.', 'unidad_medida_id' => 4, 'categoria_id' => 9, 'categoria_especifica_id' => 44], // Refuerzos Estructurales
                ['nombre' => 'Yeso', 'descripcion' => 'Material de acabado para paredes y techos.', 'unidad_medida_id' => 1, 'categoria_id' => 9, 'categoria_especifica_id' => 43], // Revestimientos y Pinturas

                // Otros
                ['nombre' => 'Bloque de concreto', 'descripcion' => 'Elemento prefabricado para muros y cerramientos.', 'unidad_medida_id' => 6, 'categoria_id' => 3, 'categoria_especifica_id' => 5], // Laminados
                ['nombre' => 'Teja', 'descripcion' => 'Elemento para cubiertas y techos.', 'unidad_medida_id' => 6, 'categoria_id' => 2, 'categoria_especifica_id' => 3], // Cerámicas Gruesas
                ['nombre' => 'Cable eléctrico', 'descripcion' => 'Conductor para instalaciones eléctricas.', 'unidad_medida_id' => 3, 'categoria_id' => 4, 'categoria_especifica_id' => 14], // Metales No Ferrosos
                ['nombre' => 'Persiana', 'descripcion' => 'Sistema de protección solar para ventanas.', 'unidad_medida_id' => 6, 'categoria_id' => 9, 'categoria_especifica_id' => 45], // Membranas Impermeabilizantes
                ['nombre' => 'Cemento', 'descripcion' => 'Material aglutinante para la fabricación de hormigón y mortero.', 'unidad_medida_id' => 1, 'categoria_id' => 3, 'categoria_especifica_id' => 5], // Laminados
            ];
            foreach ($material as $mat) {
                $m = new Materiales();
                $m->nombre = $mat['nombre'];
                $m->descripcion = $mat['descripcion'];
                $m->unidad_medida_id = $mat['unidad_medida_id'];
                $m->categoria_id = $mat['categoria_id'];
                $m->categoria_especifica_id = $mat['categoria_especifica_id'];
                $m->created_at = now();
                $m->updated_at = now();
                $m->save();
            }
        }
    }
}
