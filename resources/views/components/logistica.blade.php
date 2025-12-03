 <div class="container-fluid">
   <div class="row">
     @include('components.siderbar_panelcontrol')
     <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
       <div class="table-responsive mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4"  >

          <div>
            <h2> <i class="bi bi-backpack4-fill  "></i>&nbsp Inventario</h2>
          </div>
          
          <div class="btn-group ms-auto " role="group" aria-label="Basic example">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop1"> <i class="bi bi-clipboard-plus"></i> Nuevo Material</button>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop2"> <i class="bi bi-clipboard-plus"></i> Nuevo Almacen</button>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop3"> <i class="bi bi-clipboard-plus"></i> Nuevo Proveedor </button>
          </div>
        </div>
          <div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="staticBackdropLabel">Registro de Material</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  @include('components.form--materiales')
                </div>
              </div>
            </div>
          </div>
          <div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="staticBackdropLabel">Registro de Almacen</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  @include('components.form--almacenes')
                </div>
              </div>
            </div>
          </div>
          <div class="modal fade" id="staticBackdrop3" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="staticBackdropLabel">Registro de proveedores</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  @include('components.form-proveedor')
                </div>
              </div>
            </div>
          </div>
          
          
          
          <div class="modal fade" id="modalRegistrarSalida" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalRegistrarSalidaLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                  <h5 class="modal-title" id="modalRegistrarSalidaLabel">🚚 Registrar Salida de Material</h5>
                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  {{-- Aquí incluiremos el formulario de salida --}}
                  @include('components.form-material-salida')
                </div>
              </div>
            </div>
          </div>
          
          
          <table data-toggle="table" class="table table-striped table-hover" data-search="true" data-sort-stable="true" data-pagination="true">
            <thead>
              <tr>
                <th data-sortable="true">Material</th>
                <th data-sortable="true">Descripción</th>
                <th data-sortable="true">Cantidad Disponible</th>
                <th data-sortable="true">Almacén</th>
                <th data-sortable="true">Ubicación Física</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody class="table-group-divider">
              {{--
              El controlador está pasando una colección llamada $inventarioItems, 
              la cual ya tiene las relaciones 'material' y 'almacen' cargadas (Eager Loading).
              --}}
              @forelse ($inventario as $item)
              <tr>
                {{-- Uso directo de las relaciones de Eloquent --}}
                <td>{{ $item->material->nombre ?? 'N/A' }}</td>
                <td>{{ $item->material->descripcion ?? 'N/A' }}</td>
                <td>{{ $item->cantidad_actual }} {{ $item->unidad_medida }}</td>
                <td>{{ $item->almacen->nombre ?? 'N/A' }}</td>
                <td>{{ $item->almacen->direccion ?? 'N/A' }}</td>
                <td>
                  {{-- Usar botones con clases de Bootstrap para mejor estilo y feedback --}}
                  
                  {{-- ... Otros botones (Nuevo Material, Almacén, Proveedor) ... --}}
                  
                  {{-- Botón para abrir el nuevo modal de salida --}}
                  <button type="button"
                  class="btn btn-danger"
                  data-bs-toggle="modal"
                  data-bs-target="#modalRegistrarSalida"
                  data-material-id="{{ $item->id_material }}"
                  data-almacen-id="{{ $item->id_almacen }}"
                  data-inventario-key="{{ $item->id_material }}-{{ $item->id_almacen }}"
                  title="Registrar Salida">
                  <i class="bi bi-truck"></i>
                </button>
                
                <button class="btn btn-sm btn-warning" title="Editar"><i class="bi bi-pencil"></i></button>
                {{-- Usar un formulario para la acción DELETE  --}}
                <form method="POST" action="{{ route('movimientos.destroy', $item->id) }}" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm('¿Confirmar eliminación?');">
                    <i class="bi bi-eraser-fill"></i>
                  </button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              {{-- Mensaje si el inventario está vacío --}}
              <td colspan="6" class="text-center py-4">
                <i class="bi bi-info-circle"></i> No hay elementos registrados en el inventario.
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </DIV>
    </main>
  </div>
 </div>
 <script
   src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js"
   integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp"
   crossorigin="anonymous"
   class="astro-vvvwv3sm"></script>
 <script src="dashboard.js" class="astro-vvvwv3sm"></script>
<script>
    // ⚠️ Asegúrate de que esta variable exista en la vista Blade y contenga los datos de inventario
    const DATOS_INVENTARIO = @json($mapaInventario ); 
    
    // Elementos del DOM para el modal de Salida (Deben ser globales o accesibles)
    const selectAlmacen = document.getElementById('id_almacen1');
    const selectMaterial = document.getElementById('materiales1');
    const etiquetaCantidad = document.getElementById('cantidad_label');
    const inputCantidad = document.getElementById('cantidad_input');
    const opcionesMateriales = selectMaterial ? Array.from(selectMaterial.querySelectorAll('option')) : [];
    
    // --- FUNCIÓN CLAVE: ACTUALIZA LA ETIQUETA Y EL LÍMITE MAX DEL INPUT ---
    window.actualizarLimites = function() {
        if (!selectMaterial || !etiquetaCantidad || !inputCantidad) return;

        const selectedMaterialId = selectMaterial.value;
        const selectedAlmacenId = selectAlmacen.value;
        
        // Clave compuesta: materialId-almacenId (como la definiste en tu controlador)
        const dataKey = `${selectedMaterialId}-${selectedAlmacenId}`; 
        
        const info = DATOS_INVENTARIO[dataKey] || { cantidad_actual: 0, unidad_medida: '' };

        const cantidad_actual = Math.max(0, Number(info.cantidad_actual) || 0);
        const unidad = info.unidad_medida || '';

        // Actualizar la etiqueta y el atributo 'max'
        etiquetaCantidad.textContent = `Cantidad Disponible: (${cantidad_actual} ${unidad})`;
        inputCantidad.max = String(cantidad_actual);
        
        // Opcional: Limpiar el input si la cantidad no es válida
        if (Number(inputCantidad.value) > cantidad_actual) {
             inputCantidad.value = "";
        }
    }

    // --- FUNCIÓN DE FILTRADO (También ajustada para ser global) ---
    window.filtrarMateriales = function(materialIdToSelect = null) {
        if (!selectAlmacen || !selectMaterial) return;

        const almacenId = selectAlmacen.value;
        
        // 1. Mostrar/Ocultar opciones (el mismo material puede existir en otro almacén)
        opcionesMateriales.forEach(option => {
            if (!option.hasAttribute('data-almacen') || option.value === "") return;
            const almacenMaterial = option.getAttribute('data-almacen');
            const isVisible = almacenMaterial === almacenId;
            
            option.hidden = !isVisible;
            option.disabled = !isVisible;
        });

        // 2. Si se debe seleccionar un material (auto-relleno)
        if (materialIdToSelect) {
             selectMaterial.value = materialIdToSelect;
        } else {
             selectMaterial.value = ""; // Si no es auto-relleno, resetear la selección
        }
        
        // 3. ¡LLAMADA CLAVE! Después de seleccionar, actualiza los límites y la etiqueta
        actualizarLimites(); 
    }

    document.addEventListener('DOMContentLoaded', function() {
        const modalSalida = document.getElementById('modalRegistrarSalida'); 

        if (modalSalida) {
            modalSalida.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget; 
                
                const materialId = button.getAttribute('data-material-id');
                const almacenId = button.getAttribute('data-almacen-id');

                // 1. Asignar los valores a los select y campos ocultos
                selectAlmacen.value = almacenId; 
                document.getElementById('hidden_id_material').value = materialId;
                document.getElementById('hidden_id_almacen_origen').value = almacenId;

                // 2. Llamar a la función que filtra y selecciona el material, 
                //    y luego llama a 'actualizarLimites()'
                filtrarMateriales(materialId); 
                
                // Limpiar el input de cantidad
                if (inputCantidad) {
                     inputCantidad.value = "";
                }
            });
        }
        
        // Listeners manuales (para cuando el usuario cambia los select dentro del modal)
        if (selectAlmacen && selectMaterial) {
            selectAlmacen.addEventListener('change', () => filtrarMateriales(null)); 
            selectMaterial.addEventListener('change', actualizarLimites);
        }
    });
</script>