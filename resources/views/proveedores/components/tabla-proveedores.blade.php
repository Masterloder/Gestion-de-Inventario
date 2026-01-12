<div class="container-fluid">
  <div class="row">
    @include('components.siderbar_panelcontrol')
    <main class="col-md-9 sm-auto col-lg-10 px-md-4">
      <div class="table-responsive mt-5">
        <table data-toggle="table" class="table table-responsive table-striped table-hover " data-search="true" data-sort-stable="true" data-pagination="true" id="tabla-proveedores">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
              <h2> <i class="bi bi-card-list"></i> &nbsp Materiales registrados</h2>
            </div>
            <!-- Botón para abrir el modal de registro de proveedor -->
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#registrarProveedorModal">
              <i class="bi bi-plus-circle"></i> Registrar Proveedor
            </button>

            <!-- Modal Registrar Proveedor -->
            <div class="modal fade" id="registrarProveedorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1 aria-labelledby="registrarProveedorLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <form action="{{ route('provedores.create') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-success text-white">
                      <h5 class="modal-title" id="registrarProveedorLabel">Registrar Nuevo Proveedor</h5>
                      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                      <div class="mb-3">
                        <label for="nombreNuevo" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombreNuevo" name="nombre" required>
                      </div>
                      <div class="mb-3">
                        <label for="correoNuevo" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="correoNuevo" name="correo" required>
                      </div>
                      <div class="mb-3">
                        <label for="telefonoNuevo" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefonoNuevo" name="telefono" required>
                      </div>
                      <div class="mb-3">
                        <label for="direccionNuevo" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccionNuevo" name="direccion" required>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-success">Registrar</button>
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>


          </div>
          <thead>
            <tr>
              <th>Nombre</th>
              <th>Teléfono</th>
              <th>Correo</th>
              <th>Dirección</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody class="table-group-divider">
            @if($proveedores->isEmpty())
            <td colspan="8" class="text-center py-4">
              <i class="bi bi-info-circle"></i> No hay registros de Materiales registrados.
            </td>
            @else
            @foreach($proveedores as $proveedor)
            <tr>
              <td>{{ $proveedor->nombre }}</td>
              <td>{{ $proveedor->correo }}</td>
              <td>{{ $proveedor->telefono }}</td>
              <td>{{ $proveedor->direccion }}</td>
              <td>
                <!-- Botón para mostrar información detallada -->
                <button type="button" class="btn btn-info btn-sm"
                  data-bs-toggle="modal"
                  data-bs-target="#detalleProveedorModal{{ $proveedor->id }}">
                  <i class="bi bi-eye"></i>
                </button>
                <!-- Botón para abrir el modal de edición -->
                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editarProveedorModal{{ $proveedor->id }}">
                  <i class="bi bi-pencil"></i>
                </button>

                <!-- Botón para soft delete -->
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#eliminarProveedorModal{{ $proveedor->id }}">
                  <i class="bi bi-trash"></i>
                </button>


                <div class="modal fade " id="detalleProveedorModal{{ $proveedor->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" aria-labelledby="label{{ $proveedor->id }}" aria-hidden="true">
                  <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header bg-info text-dark">
                        <h5 class="modal-title" id="label{{ $proveedor->id }}">
                          Informacion del Proveedor {{ $proveedor->nombre }}
                        </h5>
                        <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                      </div>
                      <div class="modal-body">
                        <!-- Modal Detalle Proveedor -->
                        <div class="modal-body">
                          <p><strong>Nombre:</strong> {{ $proveedor->nombre }}</p>
                          <p><strong>Correo:</strong> {{ $proveedor->correo }}</p>
                          <p><strong>Teléfono:</strong> {{ $proveedor->telefono }}</p>
                          <p><strong>Dirección:</strong> {{ $proveedor->direccion }}</p>
                        </div>
                        <div class="table-responsive">
                          <table class="table  table-responsive table-striped  table-hover " data-search="true" data-sort-stable="true" data-pagination="true" id="tabla-provedores2">
                            <div class="d-flex justify-content-between align-items-center mb-3">

                            </div>
                            <thead class="table-light">
                              <tr>
                                <th>Material</th>
                                <th>Categoría</th>
                                <th>Específica</th>
                                <th class="text-end">Cantidad Total</th>
                              </tr>
                            </thead class="table-group-divider">
                            <tbody>
                              {{-- Cambiamos a la relación que agrupa y suma --}}
                              @forelse($proveedor->suministrosAgrupados as $suministro)
                              <tr>
                                <td>{{ $suministro->material->nombre }}</td>
                                <td>
                                  <span class="badge bg-info text-dark">
                                    {{ $suministro->material->categoria->nombre_categoria ?? 'N/A' }}
                                  </span>
                                </td>
                                <td>{{ $suministro->material->categoriaEspecifica->nombre_especifico ?? 'N/A' }}</td>
                                <td class="text-end fw-bold">
                                  {{ number_format($suministro->total_suministrado, 2) }}
                                </td>
                              </tr>
                              @empty
                              <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                  <i class="bi bi-exclamación-triangle"></i> No hay suministros registrados para este proveedor.
                                </td>
                              </tr>
                              @endforelse
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Modal Editar Proveedor -->
                <div class="modal fade" id="editarProveedorModal{{ $proveedor->id }}" tabindex="-1" aria-labelledby="editarProveedorLabel{{ $proveedor->id }}" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <form action="{{ route('proveedores.update', $proveedor->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header bg-warning">
                          <h5 class="modal-title" id="editarProveedorLabel{{ $proveedor->id }}">Editar Proveedor</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                          <div class="mb-3">
                            <label for="nombre{{ $proveedor->id }}" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre{{ $proveedor->id }}" name="nombre" value="{{ $proveedor->nombre }}" required>
                          </div>
                          <div class="mb-3">
                            <label for="correo{{ $proveedor->id }}" class="form-label">Correo</label>
                            <input type="email" class="form-control" id="correo{{ $proveedor->id }}" name="correo" value="{{ $proveedor->correo }}" required>
                          </div>
                          <div class="mb-3">
                            <label for="telefono{{ $proveedor->id }}" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefono{{ $proveedor->id }}" name="telefono" value="{{ $proveedor->telefono }}" required>
                          </div>
                          <div class="mb-3">
                            <label for="direccion{{ $proveedor->id }}" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion{{ $proveedor->id }}" name="direccion" value="{{ $proveedor->direccion }}" required>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-warning">Guardar Cambios</button>
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                
                <!-- Modal Soft Delete -->
                <div class="modal fade" id="eliminarProveedorModal{{ $proveedor->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" aria-labelledby="eliminarProveedorLabel{{ $proveedor->id }}" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="eliminarProveedorLabel{{ $proveedor->id }}">Eliminar Proveedor</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                      </div>
                      <div class="modal-body">
                        ¿Estás seguro que deseas eliminar este proveedor?
                      </div>
                      <div class="modal-footer">
                        <form action="{{ route('proveedores.delete', $proveedor->id) }}" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                      </div>
                    </div>
                  </div>
                </div>


              </td>
            </tr>
            @endforeach
            @endif
          </tbody>

        </table>
      </div>
    </main>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.22.4/dist/bootstrap-table.min.js"></script>

<script src="https://unpkg.com/bootstrap-table@1.22.4/dist/locale/bootstrap-table-es-ES.min.js"></script>
<script
  src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js"
  integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp"
  crossorigin="anonymous"
  class="astro-vvvwv3sm"></script>
<script src="dashboard.js" class="astro-vvvwv3sm"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    $('tabla-proveedores').bootstrapTable();
  });
</script>