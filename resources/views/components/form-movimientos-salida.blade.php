<form action="{{ route('movimiento.salida') }}" method="post" class="row g-3 needs-validation">
    @csrf

    <div class="mb-3">
        <select class="form-control" name="id_almacen" id="id_almacen1">
            <option selected disabled>--Elige un Almacen-</option>
            @foreach ($almacenes as $almacen)
            <option value="{{ $almacen->id }}">
                {{ $almacen->nombre }} | {{ $almacen->direccion }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="fecha_hora" class="form-label">Fecha de entrada</label>
        <input type="datetime-local" class="form-control" id="fecha_hora" name="fecha_hora" required>
    </div>

    <div class="mb-3">
        <select class="form-control" name="materiales" id="materiales1">
            <option selected disabled value="">--Elige un material-</option>

            @foreach ($inventario as $item)
            <option
                value="{{ $item->material->id }}" data-almacen="{{ $item->id_almacen }}">{{ $item->material->nombre }} {{ $item->material->unidad_medida }} | Almacén: {{ $item->id_almacen }} | {{ $item->material->categoria }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="cantidad_input" class="form-label" id="cantidad_label">Cantidad Actual del Material:(0)</label>
        <input type="number" min="0" class="form-control" id="cantidad_input" name="cantidad" required>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Variables
            const selectAlmacen = document.getElementById('id_almacen1');
            const selectMaterial = document.getElementById('materiales1');
            const opcionesMateriales = Array.from(selectMaterial.querySelectorAll('option'));
            const etiquetaCantidad = document.getElementById('cantidad_label');
            const inputCantidad = document.getElementById('cantidad_input');

            // Aquí recibimos los datos ya procesados desde el controlador
            const datosInventario = @json($mapaInventario);

            // --- Lógica de Filtrado (Igual que en la respuesta anterior) ---
            function filtrarMateriales() {
                const almacenId = selectAlmacen.value;
                selectMaterial.value = "";
                actualizarLimites();

                opcionesMateriales.forEach(option => {
                    if (option.disabled && option.value === "") return; // Ignorar el placeholder
                    const almacenMaterial = option.getAttribute('data-almacen');

                    if (almacenMaterial == almacenId) {
                        option.hidden = false;
                        option.disabled = false;
                    } else {
                        option.hidden = true;
                        option.disabled = true;
                    }
                });
            }

            // --- Lógica de Cantidades ---
            function actualizarLimites() {
                const idSeleccionado = selectMaterial.value;

                if (!idSeleccionado) {
                    etiquetaCantidad.textContent = 'Cantidad Actual del Material: (0)';
                    inputCantidad.max = 0;
                    inputCantidad.value = "";
                    return;
                }

                // Obtenemos la info directo del objeto JSON creado en el controlador
                const info = datosInventario[idSeleccionado] || {
                    cantidad_actual: 0,
                    unidad_medida: ''
                };

                const cantidad_actual = Math.max(0, Number(info.cantidad_actual) || 0);
                const unidad = info.unidad_medida || '';

                etiquetaCantidad.textContent = `Cantidad Actual del Material: (${cantidad_actual} ${unidad})`;
                inputCantidad.max = String(cantidad_actual);

                const maxDigits = Math.max(1, String(cantidad_actual).length);
                inputCantidad.setAttribute('maxlength', String(maxDigits));
            }

            // Listeners
            selectAlmacen.addEventListener('change', filtrarMateriales);
            selectMaterial.addEventListener('change', actualizarLimites);

            inputCantidad.addEventListener('input', function() {
                const currentMaxDigits = Number(this.getAttribute('maxlength')) || 1;
                if (this.value.length > currentMaxDigits) this.value = this.value.slice(0, currentMaxDigits);
                if (this.value !== '' && Number(this.value) > Number(this.max)) this.value = String(this.max);
            });

            // Inicio
            if (selectAlmacen.value) filtrarMateriales();
            else opcionesMateriales.forEach(opt => {
                if (opt.value !== "") opt.hidden = true;
            });
        });
    </script>

    <button type="submit" class="btn btn-primary">Salida de materiales</button>
</form>