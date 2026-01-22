<form action="{{ route('provedores.create') }}" method="post" class="row g-3 needs-validation" novalidate id="formProveedor">
    @csrf

    <div class="col-md-12 mb-3">
        <label for="nombre" class="form-label">Nombre del Proveedor</label>
        <input
            type="text"
            class="form-control"
            id="nombre"
            name="nombre"
            maxlength="30"
            required />
        <div class="invalid-feedback">
            Por favor, ingresa un nombre válido (solo letras).
        </div>
    </div>

    <div class="col-md-12 mb-3">
        <label for="correo" class="form-label">Correo del proveedor</label>
        <input
            type="email"
            class="form-control"
            name="correo"
            id="correo"
            maxlength="40"
            required>
        <div class="invalid-feedback">
            Ingresa un correo electrónico válido ejemplo Ayuda@ayuda.com
        </div>
    </div>

    <div class="col-md-12 mb-3">
        <label for="telefono" class="form-label">Teléfono del proveedor</label>
        <input
            type="tel"
            class="form-control"
            id="telefono"
            name="telefono"
            pattern="^\+?[0-9]{7,15}$"
            onkeypress="return soloNumerosYMas(event)"
            required>
        <div class="invalid-feedback">
            Ingresa un teléfono válido (números y opcionalmente + al inicio).
        </div>
    </div>

    <div class="col-md-12 mb-3">
        <label for="direccion" class="form-label">Dirección</label>
        <input
            type="text"
            class="form-control"
            id="direccion"
            name="direccion"
            required />
        <div class="invalid-feedback">
            La dirección es obligatoria.
        </div>
    </div>


    <button type="submit" class="btn btn-primary">Agregar Proveedor</button>

</form>

<script>
    // 1. VALIDACIÓN DE ENVÍO (Previene el envío si hay errores)
    (function() {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')

        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
    })()

    // 2. BLOQUEO DE TECLAS (Evita caracteres prohibidos)
    function soloLetras(e) {
        var key = e.keyCode || e.which;
        var tecla = String.fromCharCode(key);
        // Expresión regular para letras (incluyendo acentos y ñ)
        var letras = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]$/;

        if (!letras.test(tecla)) {
            return false;
        }
    }

    function soloNumerosYMas(e) {
        var key = e.keyCode || e.which;
        var tecla = String.fromCharCode(key);
        var permitidos = /^[0-9+]$/;

        if (!permitidos.test(tecla)) {
            return false;
        }
    }
</script>