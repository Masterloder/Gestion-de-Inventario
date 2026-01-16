<form action="{{ route('movimientos.salida2') }}" method="post" class="row g-3 needs-validation">
    @csrf

    {{-- SELECT: ALMACENES --}}
    <div class="mb-3 col-md-6">
        <label for="id_almacen1" class="form-label">Almacén de Origen <span class="text-danger">*</span></label>
        <select class="form-control" name="id_almacen1" id="id_almacen1" required>
            <option selected disabled value="">-- Elige un Almacén --</option>
            @foreach ($almacenes as $almacen)
                <option value="{{ $almacen->id }}">{{ $almacen->nombre }} | {{ $almacen->direccion }}</option>
            @endforeach
        </select>
    </div>

    {{-- INPUT: FECHA --}}
    <div class="mb-3 col-md-6">
        <label for="fecha_operacion" class="form-label">Fecha y Hora de Salida <span class="text-danger">*</span></label>
        <input type="datetime-local" class="form-control" id="fecha_operacion" name="fecha_operacion" required>
    </div>

    {{-- SELECT: MATERIALES --}}
    <div class="mb-3 col-12">
    <label for="materiales1" class="form-label fw-bold">Material a Dar de Salida <span class="text-danger">*</span></label>
    <select class="form-select shadow-sm" name="id_material1" id="materiales1" required>
        <option selected disabled value="">-- Primero elige un Almacén --</option>
        
        @foreach ($inventario as $item)
            @php
                $material = $item->materiales;
                if (!$material) continue;
                
                $nombreCat = is_object($material->categoria) 
                             ? ($material->categoria->nombre_categoria ?? 'General') 
                             : ($material->categoria ?? 'Sin Categoría');
            @endphp
            {{-- Usamos style="display: none" para que no se vean al cargar --}}
            <option
                value="{{ $item->id_materiales }}"
                data-almacen="{{ $item->id_almacen }}"
                data-stock="{{ $item->cantidad_actual }}"
                data-unidad="{{ $material->unidad_medida ?? 'uds' }}"
                style="display: none;"> 
                {{ $material->nombre }} | Stock: {{ $item->cantidad_actual }} {{ $material->unidad_medida }} | Cat: {{ $nombreCat }}
            </option>
        @endforeach
    </select>
</div>

    {{-- INPUT: CANTIDAD --}}
    <div class="mb-3 col-12">
        <label for="cantidad_input" class="form-label" id="cantidad_label">Cantidad a retirar (Seleccione material)</label>
        <input
            type="number"
            min="1"
            step="any"
            class="form-control"
            id="cantidad_input"
            name="cantidad"
            required
            disabled {{-- Deshabilitado hasta que elijan material --}}
            placeholder="0.00">
        <div class="form-text text-muted" id="ayuda_stock"></div>
    </div>

    <div class="col-12 text-end">
        <button type="submit" class="btn btn-primary" id="btnSubmit">Salida de materiales</button>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAlmacen = document.getElementById('id_almacen1');
    const selectMaterial = document.getElementById('materiales1');
    const inputCantidad = document.getElementById('cantidad_input');
    const etiquetaCantidad = document.getElementById('cantidad_label');
    const ayudaStock = document.getElementById('ayuda_stock');
    const opcionesMateriales = Array.from(selectMaterial.querySelectorAll('option'));

    // 1. Filtrar materiales cuando cambia el almacén
    selectAlmacen.addEventListener('change', function() {
        const almacenId = this.value;
        
        // Resetear material e input
        selectMaterial.value = "";
        inputCantidad.value = "";
        inputCantidad.disabled = true;
        etiquetaCantidad.textContent = "Cantidad a retirar";
        ayudaStock.textContent = "";

        opcionesMateriales.forEach(opt => {
            if (opt.value === "") {
                opt.hidden = false;
                opt.textContent = "-- Seleccione un Material --";
            } else {
                const coincide = opt.getAttribute('data-almacen') === almacenId;
                opt.hidden = !coincide;
                opt.disabled = !coincide;
            }
        });
    });

    // 2. Actualizar límites cuando cambia el material
    selectMaterial.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const stockMax = parseFloat(selectedOption.getAttribute('data-stock'));
        const unidad = selectedOption.getAttribute('data-unidad');

        if (stockMax > 0) {
            inputCantidad.disabled = false;
            inputCantidad.max = stockMax;
            inputCantidad.placeholder = `Máximo: ${stockMax}`;
            etiquetaCantidad.innerHTML = `Cantidad a retirar <span class="badge bg-info">Disponible: ${stockMax} ${unidad}</span>`;
            ayudaStock.textContent = `No puedes despachar más de ${stockMax} ${unidad}.`;
        } else {
            inputCantidad.disabled = true;
            inputCantidad.value = "";
            ayudaStock.textContent = "Este material no tiene stock disponible en este almacén.";
        }
    });

    // 3. Validación en tiempo real (No permitir escribir más del máximo)
    inputCantidad.addEventListener('input', function() {
        const max = parseFloat(this.max);
        const actual = parseFloat(this.value);

        if (actual > max) {
            this.value = max; // Forzar el valor al máximo permitido
            alert("No puedes exceder el stock disponible (" + max + ")");
        }
    });


    function filtrarMateriales() {
    const almacenSeleccionado = selectAlmacen.value; // El ID del almacén elegido
    const opciones = selectMaterial.options;

    // 1. Limpiar selecciones previas
    selectMaterial.value = "";
    inputCantidad.value = "";
    inputCantidad.disabled = true;

    // 2. Recorrer opciones y mostrar solo las que coincidan
    for (let i = 0; i < opciones.length; i++) {
        const opt = opciones[i];
        
        // El placeholder siempre se queda
        if (opt.value === "") {
            opt.style.display = "block";
            continue;
        }

        // Comparamos el data-almacen de la opción con el ID seleccionado
        if (opt.getAttribute('data-almacen') == almacenSeleccionado) {
            opt.style.display = "block"; // Se muestra
            opt.disabled = false;        // Se habilita para envío
        } else {
            opt.style.display = "none";  // Se oculta
            opt.disabled = true;         // Se deshabilita para evitar envíos erróneos
        }
    }
}
});
</script>
</form>