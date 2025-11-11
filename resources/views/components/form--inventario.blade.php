<form action="{{ route('materiales.create') }}" method="post" class="row g-3 needs-validation" novalidate >
    @csrf
    <div class="mb-3">
        <label for="nombre" class="form-label" >Nombre del material</label>
        <input
            type="varchar"
            class="form-control"
            id="nombre"
            name="nombre"
            required
        />
    </div>
    <div class="mb-3">
        <label for="Dirrecion" class="form-label">Dirrecion</label><input
            type="text"
            class="form-control"
            id="Dirrecion"
            name="Dirrecion"
            required
        />
    </div>
    <button type="submit" class="btn btn-primary">Agregar Almacen</button>
</form>