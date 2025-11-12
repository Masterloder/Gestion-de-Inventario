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
        <label for="descripcion" class="form-label">descripcion</label><input
            type="text"
            class="form-control"
            id="descripcion"
            name="descripcion"
            required
        />
    </div>
    <div class="mb-3">
        <select class="form-select" name="unidad_medida" id="unidad_medida" required>
            <option value="" disabled >--Elige una medida--</option>
            <option value="M3">Metros Cubicos</option>
            <option value="Kg">Kilogramos</option>
            <option value="L">litros</option>
            <option value="Uds">Unidades</option>
        </select>
         <div class="invalid-feedback">
      Please select a valid state.
    </div>
    </div>
    <div class="mb-3">
        <select class="form-select" name="categoria" id="categoria" required>
            <option selected disabled>--Elige una Categoria--</option>
            <option value="Materiales Pétreos">Materiales Petreos</option>
            <option value="Materiales Cerámicos y Vítreos">materiales Cerámicos y Vitreos</option>
            <option value="Materiales Compuestos">Materiales Compuestos</option>
            <option value="Materiales Metálicos">Materiales Metálicos</option>
            <option value="Materiales Orgánicos">materliales Orgánicos</option>
        </select>
         <div class="invalid-feedback">
      Please select a valid state.
    </div>
    </div>
    <div class="mb-3">
        <select class="form-select"  name="categoria_especifica" id="categoria_especifica" required>
            <option value="" disabled >--Elige una Categoria Especifica--</option>
            <option value="Estructural">Estructural</option>
            <option value="Aglutinantes">Aglutinantes</option>
            <option value="Acabado">Acabado</option>
            <option value="Cerramiento">Cerramiento</option>
        </select>
         <div class="invalid-feedback">
      Please select a valid state.
    </div>
    </div>
    <button type="submit" class="btn btn-primary">Agregar Proveedor</button>
</form>