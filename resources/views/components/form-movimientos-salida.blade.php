<form action="{{ route('movimientos.salida2') }}" method="post" class="row g-3 needs-validation">
    @csrf

    {{-- SELECT: ALMACENES --}}
    <div class="mb-3 col-md-6">
        <label for="id_almacen1" class="form-label">Almacén de Origen <span class="text-danger">*</span></label>
        <select class="form-control" name="id_almacen1" id="id_almacen1" required onchange="filtrarMateriales()">
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
    {{-- SELECT: MATERIALES --}}
    <div class="mb-3 col-12">
        <label for="materiales1" class="form-label fw-bold">Material a Dar de Salida <span class="text-danger">*</span></label>
        <select class="form-select shadow-sm" name="id_material1" id="materiales1" required>
            <option selected disabled value="">-- Primero elige un Almacén --</option>

            @foreach ($inventario as $item)
            @php
            // IMPORTANTE: Según tu controlador la relación es 'material'
            $mat = $item->material;

            if (!$mat) continue;

            // Acceder al nombre de la categoría a través de la relación cargada
            $nombreCat = ($mat->categoria)
            ? ($mat->categoria->nombre_categoria ?? 'General')
            : 'Sin Categoría';

            // Acceder a la unidad de medida
            $nombreUnidad = ($mat->unidadMedida)
            ? ($mat->unidadMedida->nombre ?? 'uds')
            : 'uds';
            @endphp
            <option
                value="{{ $mat->id }}"
                data-almacen="{{ $item->id_almacen }}"
                data-stock="{{ $item->cantidad_actual }}"
                data-unidad="{{ $nombreUnidad }}"
                style="display: none;"
                hidden
                disabled>
                {{-- AQUÍ SE MUESTRA EL NOMBRE: --}}
                {{ $mat->nombre }} | Stock: {{ number_format($item->cantidad_actual, 2) }} {{ $nombreUnidad }} | Cat: {{ $nombreCat }}
            </option>
            @endforeach
        </select>
    </div>

    {{-- INPUT: CANTIDAD --}}
    <div class="mb-3 col-12">
        <label for="cantidad_input" class="form-label" id="cantidad_label">Cantidad a retirar</label>
        <input
            type="number"
            min="0.01"
            step="any"
            class="form-control"
            id="cantidad_input"
            name="cantidad"
            required
            disabled
            onkeypress="return soloNumeros(event)"
            placeholder="0.00">
        <div class="form-text" id="ayuda_stock"></div>
    </div>

    
        <button type="submit" class="btn btn-primary" id="btnSubmit">Registrar Salida</button>
    
</form>

<script>
    /**
     * 
     * Bloquea cualquier carácter que no sea número o punto
     */
    function soloNumeros(evt) {
        const charCode = (evt.which) ? evt.which : evt.keyCode;
        // Permitir números (48-57) y punto (46)
        if (charCode !== 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
            evt.preventDefault();
            return false;
        }
        return true;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const selectAlmacen = document.getElementById('id_almacen1');
        const selectMaterial = document.getElementById('materiales1');
        const inputCantidad = document.getElementById('cantidad_input');
        const etiquetaCantidad = document.getElementById('cantidad_label');
        const ayudaStock = document.getElementById('ayuda_stock');

        // 1. Filtrar materiales por almacén
        window.filtrarMateriales = function() {
            const almacenId = selectAlmacen.value;
            const opciones = selectMaterial.querySelectorAll('option');

            selectMaterial.value = "";
            inputCantidad.value = "";
            inputCantidad.disabled = true;
            ayudaStock.textContent = "";

            opciones.forEach(opt => {
                if (opt.value === "") {
                    opt.style.display = "block";
                    opt.disabled = false;
                } else {
                    const coincide = opt.getAttribute('data-almacen') === almacenId;
                    opt.style.display = coincide ? "block" : "none";
                    opt.hidden = !coincide;
                    opt.disabled = !coincide;
                }
            });
        };

        // 2. Configurar límites al seleccionar material
        selectMaterial.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (!selectedOption.value) return;

            const stockMax = parseFloat(selectedOption.getAttribute('data-stock'));
            const unidad = selectedOption.getAttribute('data-unidad');

            inputCantidad.disabled = false;
            inputCantidad.max = stockMax;
            inputCantidad.placeholder = `Máximo disponible: ${stockMax}`;
            etiquetaCantidad.innerHTML = `Cantidad a retirar <span class="badge bg-info">Stock: ${stockMax} ${unidad}</span>`;
            ayudaStock.className = "form-text text-muted";
            ayudaStock.textContent = `No puede exceder los ${stockMax} ${unidad}.`;
        });

        // 3. Validar entrada en tiempo real (evitar letras y excesos)
        inputCantidad.addEventListener('input', function() {
            const max = parseFloat(this.max);
            let valor = parseFloat(this.value);

            if (valor > max) {
                this.value = max;
                alert("Cantidad ajustada al máximo disponible: " + max);
            }
            if (valor < 0) this.value = 0;
        });
    });
</script>