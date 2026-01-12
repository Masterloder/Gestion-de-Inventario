<form action="{{ route('movimientos.salida') }}" method="POST">
    @csrf

    {{-- 1. Campos Ocultos (Valores clave para el backend) --}}
    {{-- Estos campos se llenan automáticamente con JavaScript al abrir el modal --}}
    <input type="hidden" name="id_material1" id="hidden_id_material" required>
    <input type="hidden" name="id_almacen1" id="hidden_id_almacen_origen" required>

    <div class="row g-3">

        {{-- 2. Material (Campo de Solo Lectura Automático) --}}
        <div class="col-md-6">
            <label for="material_display" class="form-label">Material a Despachar</label>
            {{-- Usamos un <select> con la clase 'form-control-plaintext' para mostrar el nombre. --}}
            {{-- Nota: El ID "materiales1" se mantiene para compatibilidad con tu JS previo si lo usas para otros fines. --}}
            <select class="form-select" id="materiales1" name="materiales_display" disabled>
                <option value="">Cargando material...</option>
                {{-- Iterar sobre la colección de materiales para que JavaScript pueda hacer la selección --}}
                @foreach ($materiales as $material)
                {{-- Acceso como array --}}
                <option value="{{ $material['id'] }}">
                    {{ $material['nombre'] }}
                    | Cat: {{ $material['categoria']['nombre_categoria'] ?? 'S/C' }}
                    ({{ $material['unidad_medida']['simbolo'] ?? '' }})
                </option>
                @endforeach
            </select>
            <div class="form-text text-muted">Este campo se auto-selecciona y no se puede modificar.</div>
        </div>

        {{-- 3. Almacén de Origen (Campo de Solo Lectura Automático) --}}
        <div class="col-md-6">
            <label for="id_almacen1" class="form-label">Almacén de Origen</label>
            {{-- Usamos un <select> con la clase 'form-control-plaintext' para mostrar el nombre. --}}
            <select class="form-select" id="id_almacen1" name="almacen_display" disabled>
                <option value="">Cargando almacén...</option>
                {{-- Iterar sobre la colección de almacenes para que JavaScript pueda hacer la selección --}}
                @foreach ($almacenes as $almacen)
                <option value="{{ $almacen->id }}" data-nombre="{{ $almacen->nombre }}">
                    {{ $almacen->nombre }}
                </option>
                @endforeach
            </select>
            <div class="form-text text-muted">El material proviene de este almacén.</div>
        </div>

        {{-- 4. Cantidad a Despachar (Campo Editable) --}}
        <div class="col-md-6">
            <label for="cantidad_input" class="form-label">
                Cantidad a Despachar
                <small class="text-danger fw-bold" id="cantidad_label">Cantidad Disponible: (0)</small>
            </label>
            <input type="number"
                class="form-control"
                id="cantidad_input"
                name="cantidad"
                min="1"
                max="0" {{-- El JS establecerá el máximo --}}
                placeholder="Ingrese cantidad"
                required>
            <div class="invalid-feedback">La cantidad no debe exceder el stock disponible.</div>
        </div>

        {{-- 5. Fecha de Salida (Campo Editable) --}}
        @php
        // Usamos now() para obtener la fecha y hora actual (Carbon instance)
        $fechaHoy = now()->toDateString();

        // Calcular la fecha MÍNIMA: Hoy - 7 días (hace una semana)
        $fechaMinima = now()->subDays(7)->toDateString();

        // Calcular la fecha MÁXIMA: Hoy + 7 días (dentro de una semana)
        $fechaMaxima = now()->addDays(7)->toDateString();
        @endphp
        <div class="col-md-6">
            <label for="fecha_operacion" class="form-label">Fecha de Salida</label>
            <input type="date"
                class="form-control"
                id="fecha_operacion"
                name="fecha_operacion"
                value="{{ $fechaHoy }}" {{-- Valor por defecto: Hoy --}}
                min="{{ $fechaMinima }}" {{--Límite Mínimo: Hace 7 días --}}
                max="{{ $fechaMaxima }}" {{--Límite Máximo: Dentro de 7 días --}}
                required>
        </div>

        {{-- 6. Ubicación de Entrega (Campo Editable) --}}
        <div class="col-12">
            <label for="ubicacion_entrega" class="form-label">Ubicación/Destino de Entrega</label>
            <input type="text"
                class="form-control"
                id="ubicacion_entrega"
                name="ubicacion_entrega"
                placeholder="Ej: Obra A, Taller de Mantenimiento, Departamento X"
                required>
        </div>
        

    </div>

    <div class="modal-footer mt-4">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary"><i class="bi bi-send-fill"></i> Registrar Salida</button>
    </div>

</form>

{{-- Lógica de Auto-Relleno y Campo Oculto --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalSalida = document.getElementById('modalRegistrarSalida');

        if (modalSalida) {
            modalSalida.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;

                // Obtener datos del botón de la tabla
                const materialId = button.getAttribute('data-material-id');
                const almacenId = button.getAttribute('data-almacen-id');

                // 1. Llenar los campos ocultos (los que el servidor usará)
                const hiddenMaterial = document.getElementById('hidden_id_material');
                const hiddenAlmacen = document.getElementById('hidden_id_almacen_origen');

                if (hiddenMaterial) hiddenMaterial.value = materialId;
                if (hiddenAlmacen) hiddenAlmacen.value = almacenId;

                // 2. Llenar los campos de visualización (Usamos la lógica de tu función filtrarMateriales)
                // Se asume que las variables `selectAlmacen`, `selectMaterial` y la función 
                // `filtrarMateriales(materialIdToSelect)` están definidas en el script principal.

                if (window.selectAlmacen && window.selectMaterial && typeof window.filtrarMateriales === 'function') {
                    // Seleccionar los <select> de solo lectura para que muestren el nombre correcto
                    window.selectAlmacen.value = almacenId;
                    window.filtrarMateriales(materialId); // Esta función también seleccionará el material
                }
            });
        }
    });
</script>