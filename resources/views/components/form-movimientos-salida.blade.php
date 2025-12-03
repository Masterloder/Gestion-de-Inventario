<form action="{{ route('movimientos.salida2') }}" method="post" class="row g-3 needs-validation">
    @csrf

    {{-- SELECT: ALMACENES --}}
    <div class="mb-3 col-md-6">
        <label for="id_almacen1" class="form-label">Almacén de Origen <span class="text-danger">*</span></label>
        <select class="form-control" name="id_almacen1" id="id_almacen1" required>
            <option selected disabled value="">-- Elige un Almacén --</option>
            @foreach ($almacenes as $almacen)
            <option value="{{ $almacen->id }}">
                {{ $almacen->nombre }} | {{ $almacen->direccion }}
            </option>
            @endforeach
        </select>
    </div>

    {{-- INPUT: FECHA DE SALIDA --}}
    <div class="mb-3 col-md-6">
        <label for="fecha_operacion" class="form-label">Fecha y Hora de Salida <span class="text-danger">*</span></label>
        <input type="datetime-local" class="form-control" id="fecha_operacion" name="fecha_operacion" required>
    </div>

    {{-- SELECT: MATERIALES --}}
    <div class="mb-3 col-12">
        <label for="materiales1" class="form-label">Material a Dar de Salida <span class="text-danger">*</span></label>
        <select class="form-control" name="id_material1" id="materiales1" required>
            <option selected disabled value="">-- Elige un material --</option>
            {{-- Iteramos sobre el INVENTARIO que contiene la cantidad actual --}}
            @foreach ($inventario as $item)
            @php
            // Clave compuesta para JavaScript: material_id-almacen_id
            $dataKey = "{$item->id_material}-{$item->id_almacen}";
            $nombreMaterial = $item->material->nombre ?? 'Material Desconocido';
            $unidadMedida = $item->material->unidad_medida ?? '';
            $categoria = $item->material->categoria ?? '';
            @endphp
            <option
                value="{{ $item->id_material }}"
                data-almacen="{{ $item->id_almacen }}"
                data-key="{{ $dataKey }}"
                hidden disabled>
                {{ $nombreMaterial }} ({{ $unidadMedida }}) | Almacén: {{ $item->almacen->nombre ?? $item->id_almacen }} | {{ $categoria }}
            </option>
            @endforeach
        </select>
    </div>

    {{-- INPUT: CANTIDAD --}}
    <div class="mb-3 col-12">
        <label for="cantidad_input" class="form-label" id="cantidad_label">Cantidad Actual del Material: (0)</label>
        <input
            type="number"
            min="1"
            class="form-control"
            id="cantidad_input"
            name="cantidad"
            required
            placeholder="Introduce la cantidad a retirar">
        <div class="invalid-feedback">
            La cantidad no debe exceder el stock disponible.
        </div>
    </div>

    <div class="col-12 text-end">
        <button type="submit" class="btn btn-primary">Salida de materiales</button>
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- 1. Definición de Elementos del DOM ---
        const selectAlmacen = document.getElementById('id_almacen1');
        const selectMaterial = document.getElementById('materiales1');
        const etiquetaCantidad = document.getElementById('cantidad_label');
        const inputCantidad = document.getElementById('cantidad_input');
        
        // Obtener todas las opciones del select de materiales
        const opcionesMateriales = selectMaterial ? Array.from(selectMaterial.querySelectorAll('option')) : [];
        
        // Asumiendo que el controlador pasa los datos de inventario. Si no es así, esta línea fallará.
        // Asegúrate de que $mapaInventario está disponible en esta vista.
        const DATOS_INVENTARIO = @json($mapaInventario ); 


        // --- 2. Función para Actualizar Cantidad Disponible y Límites ---
        // Se llama cuando se cambia el almacén o el material.
        function actualizarLimites() {
            if (!selectMaterial || !etiquetaCantidad || !inputCantidad) return;

            const selectedMaterialId = selectMaterial.value;
            const selectedAlmacenId = selectAlmacen.value;
            
            // Clave compuesta: materialId-almacenId
            const dataKey = `${selectedMaterialId}-${selectedAlmacenId}`; 
            
            // Obtener la información del stock para la combinación actual
            const info = DATOS_INVENTARIO[dataKey] || { cantidad_actual: 0, unidad_medida: '' };

            const cantidad_actual = Math.max(0, Number(info.cantidad_actual) || 0);
            const unidad = info.unidad_medida || '';

            // Actualizar la etiqueta y el atributo 'max' del input
            etiquetaCantidad.textContent = `Cantidad Disponible: (${cantidad_actual} ${unidad})`;
            inputCantidad.max = String(cantidad_actual);
            
            // Si no hay stock o el input excede el nuevo máximo, limpiamos el valor
            if (cantidad_actual === 0 || Number(inputCantidad.value) > cantidad_actual) {
                 inputCantidad.value = "";
            }
        }


        // --- 3. Función CLAVE para Filtrar Materiales por Almacén ---
        function filtrarMateriales() {
            const almacenId = selectAlmacen.value;

            // 1. Resetear el selector de material
            selectMaterial.value = "";
            actualizarLimites(); // Limpiar la etiqueta de cantidad

            // 2. Iterar y mostrar/ocultar las opciones
            opcionesMateriales.forEach(option => {
                // El placeholder inicial debe ser siempre visible (value="")
                if (option.value === "") {
                    option.hidden = false;
                    return; 
                }
                
                // Si no tiene el atributo data-almacen, lo ignoramos
                if (!option.hasAttribute('data-almacen')) return;

                const almacenMaterial = option.getAttribute('data-almacen');
                
                // Mostrar solo si coincide con el almacén seleccionado
                const isVisible = almacenMaterial === almacenId;
                
                option.hidden = !isVisible;
                option.disabled = !isVisible;
            });
        }
        

        // --- 4. Listeners de Eventos ---
        
        // Cuando el almacén cambia, se llama a la función de filtrado
        if (selectAlmacen) {
            selectAlmacen.addEventListener('change', filtrarMateriales);
        }

        // Cuando el material cambia, se llama a la función para actualizar la cantidad disponible
        if (selectMaterial) {
            selectMaterial.addEventListener('change', actualizarLimites);
        }

        // Validación en el input de cantidad
        if (inputCantidad) {
            inputCantidad.addEventListener('input', function() {
                // Restricción: No exceder el stock disponible (max)
                if (this.value !== '' && Number(this.value) > Number(this.max)) {
                    this.value = String(this.max);
                }
                // Evitar que el valor sea negativo
                if (Number(this.value) < 0) this.value = 1;
            });
        }
        
        // Inicialización: Ocultar opciones al cargar si no hay almacén seleccionado
        if (!selectAlmacen.value) {
            opcionesMateriales.forEach(opt => {
                 if (opt.value !== "") opt.hidden = true;
            });
        }
    });
</script>
</form>