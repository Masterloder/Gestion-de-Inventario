<div class="modal fade" id="editModal{{ $unidad->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Editar Unidad: {{ $unidad->nombre_unidad }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('unidad-medicion.update', $unidad->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre de la Unidad</label>
                        <input type="text" name="nombre_unidad" class="form-control" value="{{ $unidad->nombre_unidad }}" maxlength="25" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Símbolo</label>
                        <input type="text" name="simbolo" class="form-control" value="{{ $unidad->simbolo }}" maxlength="5" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal{{ $unidad->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirmar Eliminación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <i class="bi bi-exclamation-triangle text-danger display-4"></i>
                <p class="mt-3">¿Estás seguro de que deseas eliminar la unidad <strong>{{ $unidad->nombre_unidad }}</strong>?</p>
                <small class="text-muted">Esta acción no se puede deshacer.</small>
            </div>
            <div class="modal-footer">
                <form action="{{ route('unidad-medicion.delete', $unidad->id) }}" method="POST" class="w-100">
                    @csrf
                    @method('DELETE')
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Eliminar Definitivamente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createUnidadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Crear Nueva Unidad de Medición</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('unidad-medicion.create') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre de la Unidad</label>
                        <input type="text" name="nombre_unidad" class="form-control" placeholder="Ejemplo: Kilogramo" maxlength="25" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Símbolo</label>
                        <input type="text" name="simbolo" class="form-control" placeholder="Ejemplo: kg" maxlength="5" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Crear Unidad</button>
                </div>
            </form>
        </div>
    </div>      