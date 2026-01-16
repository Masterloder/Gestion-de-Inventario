<form action="{{ route('movimientos.ingreso') }}" method="post" class="row g-3 needs-validation" novalidate>
    @csrf

    {{-- SELECT: ALMACENES --}}
    <div class="col-md-6 mb-3">
        <label for="id_almacen" class="form-label">Almacén de Destino <span class="text-danger">*</span></label>
        <select class="form-control" name="id_almacen" id="id_almacen" required>
            <option selected disabled value="">-- Elige un Almacén --</option>
            @foreach ($almacenes as $almacen)
                <option value="{{ $almacen->id }}">
                    {{ $almacen->nombre }} | {{ $almacen->direccion }}
                </option>
            @endforeach
        </select>
        <div class="invalid-feedback">Seleccione un almacén.</div>
    </div>

    {{-- SELECT: PROVEEDORES --}}
    <div class="col-md-6 mb-3">
        <label for="id_proveedor" class="form-label">Proveedor</label>
        <select class="form-control" name="id_proveedor" id="id_proveedor">
            <option value="" selected>-- Elige un Proveedor (Opcional) --</option>
            @foreach ($proveedores as $proveedor)
                <option value="{{ $proveedor->id }}">
                    {{ $proveedor->nombre }} | {{ $proveedor->correo }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- INPUT: FECHA DE ENTRADA --}}
    <div class="col-md-6 mb-3">
        <label for="fecha_operacion" class="form-label">Fecha y Hora de Entrada <span class="text-danger">*</span></label>
        <input 
            type="datetime-local"
            class="form-control"
            id="fecha_operacion"
            name="fecha_operacion"
            required
            min="{{ \Carbon\Carbon::now()->subWeeks(2)->format('Y-m-d\TH:i') }}"
            max="{{ \Carbon\Carbon::now()->addWeeks(2)->format('Y-m-d\TH:i') }}"
        >
        <div class="invalid-feedback">Ingrese una fecha de entrada válida.</div>
    </div>

    {{-- INPUT: FECHA DE CADUCIDAD (Nuevo Campo) --}}
    <div class="col-md-6 mb-3">
        <label for="fecha_caducidad" class="form-label">Fecha de Caducidad</label>
        <input 
            type="date"
            class="form-control"
            id="fecha_caducidad"
            name="fecha_caducidad"
            min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
        >
        <div class="form-text">Opcional. Dejar vacío si el material no caduca.</div>
    </div>

    {{-- INPUT: CANTIDAD --}}
    <div class="col-md-6 mb-3">
        <label for="cantidad" class="form-label">Cantidad A Ingresar <span class="text-danger">*</span></label>
        <input
            type="text"
            inputmode="numeric"
            pattern="\d{1,8}"
            class="form-control"
            id="cantidad"
            name="cantidad"
            required
            maxlength="8"
            oninput="this.value = this.value.replace(/\D/g,'').slice(0,8);"
        />
        <div class="invalid-feedback">Ingrese una cantidad válida (solo números).</div>
    </div>

    {{-- SELECT: MATERIALES --}}
<div class="col-md-6 mb-3"> <label for="id_material" class="form-label">Material a Ingresar <span class="text-danger">*</span></label>
    <select class="form-control select2" name="id_material" id="id_material" required>
        <option selected disabled value="">-- Elige un Material --</option>
        @foreach ($materiales as $material)
            <option value="{{ $material->id }}">
                {{-- Accedemos solo al nombre de la categoría --}}
                {{ $material->nombre }}  | {{ $material->categoria->nombre_categoria ?? 'Sin Categoría' }}  |  {{ $material->categoriaespecifica->nombre_especifico ?? 'Sin categoria Especifica' }}
            </option>
        @endforeach
    </select>
    <div class="invalid-feedback">Seleccione un material.</div>
</div>

    <div class="col-12 text-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Registrar Ingreso</button>
    </div>
</form>

<script>
    // Script para activar la validación visual de Bootstrap
    (function () {
      'use strict'
      var forms = document.querySelectorAll('.needs-validation')
      Array.prototype.slice.call(forms).forEach(function (form) {
          form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
              event.preventDefault()
              event.stopPropagation()
            }
            form.classList.add('was-validated')
          }, false)
        })
    })()
</script>