<form action="{{ route('provedores.create') }}" method="post" class="row g-3 needs-validation ">
    @csrf
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre del Proveedor</label>
        <input
            type="text"
            class="form-control"
            id="nombre"
            name="nombre"
            required
        />
    </div>
    <div class="mb-3">
        <label for="contacto" class="form-label">Correo Electrónico</label>
        <input
            type="text"
            class="form-control"
            id="contacto"
            name="contacto"
            required
        />
    </div>
    <div class="mb-3">
        <label for="telefono" class="form-label">Teléfono</label>
        <input
            type="text"
            class="form-control"
            id="telefono"
            name="telefono"
            required
        />
    </div>
    <div class="mb-3">
        <label for="direccion" class="form-label">Dirección</label>
        <input
            type="text"
            class="form-control"
            id="direccion"
            name="direccion"
            required
        />
    </div>
    <button type="submit" class="btn btn-primary">Agregar Proveedor</button>
</form>