<div class="container-fluid">
    <div class="row">
        <main class="col-md-9 sm-auto col-lg-10 px-md-4">
            <div class="table-responsive mt-5">
            <table data-toggle="table" class="table table-responsive table-striped" data-search="true" data-sort-stable="true" data-pagination="true" id="tabla-proveedores" >
                <div class="d-flex justify-content-between align-items-center mb-4" >
                    <div>
                        <h2> <i class="bi bi-card-list"></i> &nbsp Materiales registrados</h2>
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
                <tbody table-group-divider >
                    @foreach($proveedores as $proveedor)
                    <tr>
                        <td>{{ $proveedor->nombre }}</td>
                        <td>{{ $proveedor->correo }}</td>
                        <td>{{ $proveedor->telefono }}</td>
                        <td>{{ $proveedor->direccion }}</td>
                        <td>
                            <!-- Botón para mostrar información detallada -->
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detalleProveedorModal{{ $proveedor->id }}">
                                <i class="bi bi-eye"></i>
                            </button>

                            <!-- Botón para soft delete -->
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#eliminarProveedorModal{{ $proveedor->id }}">
                                <i class="bi bi-trash"></i>
                            </button>

                            <!-- Modal Detalle Proveedor -->
                            <div class="modal fade" id="detalleProveedorModal{{ $proveedor->id }}" tabindex="-1" aria-labelledby="detalleProveedorLabe {{ $proveedor->id }}" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="detalleProveedorLabel{{ $proveedor->id }}">Detalle del Proveedor</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                  </div>
                                  <div class="modal-body">
                                    <p><strong>Nombre:</strong> {{ $proveedor->nombre }}</p>
                                    <p><strong>Correo:</strong> {{ $proveedor->correo }}</p>
                                    <p><strong>Teléfono:</strong> {{ $proveedor->telefono }}</p>
                                    <p><strong>Dirección:</strong> {{ $proveedor->direccion }}</p>
                                    <!-- Agrega más campos si es necesario -->
                                  </div>
                                  <table data-toggle="table" class="table table-responsive table-striped" data-search="true" data-sort-stable="true" data-pagination="true" id="tabla-{{ $proveedor->id }}" >
                                    <thead>
                                        <tr>
                                            <th>Materiales Suministrados</th>
                                            <th>Cantidades</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @if($proveedor->materiales->isEmpty())
                                            <tr>
                                                <td>No hay registros</td>
                                            </tr>
                                        @else
                                            @foreach($proveedor->materiales as $material)
                                            <tr>
                                                <td>{{ $material->nombre }}</td>
                                                <td>{{ $material->cantidad }}</td>
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                  </table>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <!-- Modal Soft Delete -->
                            <div class="modal fade" id="eliminarProveedorModal{{ $proveedor->id }}" tabindex="-1" aria-labelledby="eliminarProveedorLabel{{ $proveedor->id }}" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="eliminarProveedorLabel{{ $proveedor->id }}">Eliminar Proveedor</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                  </div>
                                  <div class="modal-body">
                                    ¿Estás seguro que deseas eliminar este proveedor?
                                  </div>
                                  <div class="modal-footer">
                                    <form action="{{ asset('proveedores/delete/' . $proveedor->id) }}" method="POST">
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