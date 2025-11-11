<form action="{{ route('provedores.create') }}" method="post" class="row g-3 needs-validation"  >
    @csrf
    <div class="mb-3">
        <label for="nombre" class="form-label" >Nombre del Proveedor</label>
        <input
            type="varchar"
            class="form-control"
            id="nombre"
            name="nombre"
            required
        />
    </div>
    <div class="mb-3">
        <labe for="correo" class="form-label">Correo del proveedor</labe>
        <input 
            type="email"
            class="form-control"
            name="correo" 
            id="correo"
            required>
    </div>
    <dv class="mb-3">
        <label for="telefono" class="form-label">Telefono del proveedor</label>
        <input type="tel"
        class="form-control"
        id="telefono"
        name="telefono"
        required>
    </dv>
    <div class="mb-3">
        <label for="Dirrecion" class="form-label">Dirrecion</label><input
            type="varchar"
            class="form-control"
            id="direccion"
            name="direccion"
            required
        />
    </div>
    <button type="submit" class="btn btn-primary">Agregar Almacen</button>
</form>