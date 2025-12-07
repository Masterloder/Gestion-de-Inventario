 <div class="container-fluid">
     <div class="row">
         @include('components.siderbar_panelcontrol')
         <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
             <div class="table-responsive mt-5">
                <div class="d-flex justify-content-between align-items-center mb-4" >
                    <div>
                        <h2> <i class="bi bi-truck"></i> &nbsp Movimientos</h2>
                    </div>
                    
                    <div class="btn-group ml-auto " role="group" aria-label="Basic example">
                        <button type="button" class="btn btn btn-secondary" data-bs-toggle="modal" data-bs-target="#staticBackdrop1"> <i class="bi bi-clipboard-plus"></i>Ingreso de Materiales</button>
                        <button type="button" class="btn btn btn-secondary" data-bs-toggle="modal" data-bs-target="#staticBackdrop2"> <i class="bi bi-clipboard-plus"></i>Salida de Materiales</button>
                        
                    </div>
                </div>
                    
                 <div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                     <div class="modal-dialog modal-dialog-centered">
                         <div class="modal-content">
                             <div class="modal-header">
                                 <h1 class="modal-title fs-5" id="staticBackdropLabel">ingreso de Materiales</h1>
                                 <button type="button" class="btn-close  " data-bs-dismiss="modal" aria-label="Close"></button>
                             </div>
                             <div class="modal-body">
                                 @include('components.form-movimientos-entrada')
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                     <div class="modal-dialog modal-dialog-centered">
                         <div class="modal-content">
                             <div class="modal-header">
                                 <h1 class="modal-title fs-5" id="staticBackdropLabel">ingreso de </h1>
                                 <button type="button" class="btn-close  " data-bs-dismiss="modal" aria-label="Close"></button>
                             </div>
                             <div class="modal-body">
                                 @include('components.form-movimientos-salida')
                             </div>
                         </div>
                     </div>
                 </div>

                 <table data-toggle="table" class="table table-responsive table-striped" data-search="true" data-sort-stable="true" data-pagination="true" id="tabla-movimientos">
                     <thead>
                         <tr>
                             <th data-sortable="true">Tipo de Movimiento</th>
                             <th data-sortable="true">Fecha de Operación</th>
                             <th data-sortable="true">Cantidad</th>
                             <th data-sortable="true">Nº de Referencia</th>
                             <th data-sortable="true">Material</th>
                             <th data-sortable="true">Almacén</th>
                             <th data-sortable="true">Trabajador</th>
                             <th>Acciones</th>
                         </tr>
                     </thead>
                     <tbody class="table-group-divider">
                         @if ($movimientos->isEmpty())
                         <tr>
                             {{-- Colspan debe ser 8 para abarcar todas las columnas --}}
                             <td colspan="8" class="text-center">No hay movimientos registrados.</td>
                         </tr>
                         @else
                         @foreach ($movimientos as $movimiento)
                         <tr>
                             {{-- 1. Tipo de Movimiento --}}
                             <td>{{ $movimiento->tipo_movimiento ?? 'N/A' }}</td>

                             {{-- 2. Fecha de Operación (formatos recomendados) --}}
                             <td>{{ $movimiento->fecha_operacion ?? 'N/A' }}</td>

                             {{-- 3. Cantidad --}}
                             <td>{{ $movimiento->cantidad }}</td>

                             {{-- 4. Número de Referencia --}}
                             <td>{{ $movimiento->numero_referencia }}</td>

                             {{-- 5. Nombre del Material --}}
                             <td>{{ $movimiento->materiales->nombre ?? 'N/A' }}</td>

                             {{-- 6. Nombre del Almacén --}}
                             <td>{{ $movimiento->almacenes->nombre ?? 'N/A' }}</td>

                             {{-- 7. Nombre del Trabajador (asumiendo columna 'name' o 'nombre') --}}
                             <td>{{ $movimiento->trabajador->name ?? 'Usuario Eliminado' }}</td>

                             {{-- 8. Acciones --}}
                             <td>
                                 <button type="button"
                                     class="btn btn-sm btn-info"
                                     title="Ver Detalles"
                                     data-bs-toggle="modal"
                                     data-bs-target="#detalleModal{{ $movimiento->id }}">
                                     <i class="bi bi-eye"></i>
                                 </button>

                                 <button type="button"
                                     class="btn btn-sm btn-warning"
                                     title="Editar Movimiento"
                                     data-bs-toggle="modal"
                                     data-bs-target="#editarModal{{ $movimiento->id }}">
                                     <i class="bi bi-pencil"></i>
                                 </button>

                                 <button type="button"
                                     class="btn btn-sm btn-danger"
                                     title="Eliminar Movimiento"
                                     data-bs-toggle="modal"
                                     data-bs-target="#eliminarModal{{ $movimiento->id }}">
                                     <i class="bi bi-trash"></i>
                                 </button>
                             </td>
                         </tr>
                         <div class="modal fade" id="detalleModal{{ $movimiento->id }}" tabindex="-1" aria-labelledby="detalleModalLabel{{ $movimiento->id }}" aria-hidden="true">
                             <div class="modal-dialog">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                         <h5 class="modal-title" id="detalleModalLabel{{ $movimiento->id }}">Detalles del Movimiento #{{ $movimiento->id }}</h5>
                                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                     </div>
                                     <div class="modal-body">
                                         <p><strong>Tipo:</strong> {{ $movimiento->tipo_movimiento ?? 'N/A' }}</p>
                                         <p><strong>Material:</strong> {{ $movimiento->materiales->nombre ?? 'N/A' }}</p>
                                         <p><strong>Descripción del Material:</strong> {{ $movimiento->materiales->descripcion ?? 'N/A' }}</p>
                                         <hr>
                                         <p><strong>Almacén:</strong> {{ $movimiento->almacenes->nombre ?? 'N/A' }}</p>
                                         <p><strong>Destino:</strong> {{ $movimiento->destino ?? 'N/A' }}</p>
                                         <p><strong>Trabajador:</strong> {{ $movimiento->trabajador->name ?? 'N/A' }}</p>
                                         <p><strong>Referencia:</strong> {{ $movimiento->numero_referencia }}</p>
                                         <p><strong>Cantidad:</strong> {{ $movimiento->cantidad }}</p>
                                         <hr>
                                         <p class="text-muted small">
                                             <strong>Fecha de Creación:</strong> {{ $movimiento->created_at->format('d/m/Y H:i') }}<br>
                                             <strong>Última Actualización:</strong> {{ $movimiento->updated_at->format('d/m/Y H:i') }}
                                         </p>
                                     </div>
                                     <div class="modal-footer">
                                         <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                     </div>
                                 </div>
                             </div>
                         </div>
                         <div class="modal fade" id="editarModal{{ $movimiento->id }}" tabindex="-1" aria-labelledby="editarModalLabel{{ $movimiento->id }}" aria-hidden="true">
                             <div class="modal-dialog modal-lg">
                                 <div class="modal-content">
                                     <div class="modal-header">
                                         <h5 class="modal-title" id="editarModalLabel{{ $movimiento->id }}">Editar Movimiento #{{ $movimiento->id }}</h5>
                                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                     </div>
                                     <form action="{{ route('movimientos.update', $movimiento->id) }}" method="POST">
                                         @csrf
                                         @method('PUT')
                                         <div class="modal-body row">

                                             <div class="mb-3 col-md-6">
                                                 <label for="id_material_{{ $movimiento->id }}" class="form-label">Material</label>
                                                 <select name="id_material" id="id_material_{{ $movimiento->id }}" class="form-select" required>
                                                     <option value="">-- Selecciona Material --</option>
                                                     @foreach ($materiales as $material)
                                                     <option
                                                         value="{{ $material->id }}"
                                                         {{ $movimiento->id_material == $material->id ? 'selected' : '' }}>
                                                         {{ $material->nombre }} ({{ $material->unidad_medida }})
                                                     </option>
                                                     @endforeach
                                                 </select>
                                             </div>

                                             <div class="mb-3 col-md-6">
                                                 <label for="id_trabajador_{{ $movimiento->id }}" class="form-label">Trabajador</label>
                                                 <select name="id_usuario" id="id_trabajador_{{ $movimiento->id }}" class="form-select" required>
                                                     <option value="">-- Selecciona Trabajador --</option>
                                                     @foreach ($trabajadores as $trabajador)
                                                     <option
                                                         value="{{ $trabajador->id }}"
                                                         {{ $movimiento->id_usuario == $trabajador->id ? 'selected' : '' }}>
                                                         {{ $trabajador->name }}
                                                     </option>
                                                     @endforeach
                                                 </select>
                                             </div>

                                             <div class="mb-3 col-md-6">
                                                 <label for="cantidad_{{ $movimiento->id }}" class="form-label">Cantidad</label>
                                                 <input type="number"
                                                     name="cantidad"
                                                     id="cantidad_{{ $movimiento->id }}"
                                                     class="form-control"
                                                     value="{{ $movimiento->cantidad }}"
                                                     required>
                                             </div>

                                             <div class="mb-3 col-md-6">
                                                 <label for="referencia_{{ $movimiento->id }}" class="form-label">Nº de Referencia</label>
                                                 <input type="text"
                                                     name="numero_referencia"
                                                     id="referencia_{{ $movimiento->id }}"
                                                     class="form-control"
                                                     value="{{ $movimiento->numero_referencia }}">
                                             </div>

                                         </div>
                                         <div class="modal-footer">
                                             <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                             <button type="submit" class="btn btn-warning">Guardar Cambios</button>
                                         </div>
                                     </form>
                                 </div>
                             </div>
                         </div>
                         <div class="modal fade" id="eliminarModal{{ $movimiento->id }}" tabindex="-1" aria-labelledby="eliminarModalLabel{{ $movimiento->id }}" aria-hidden="true">
                             <div class="modal-dialog">
                                 <div class="modal-content">
                                     <div class="modal-header bg-danger text-white">
                                         <h5 class="modal-title" id="eliminarModalLabel{{ $movimiento->id }}">Confirmar Eliminación</h5>
                                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                     </div>
                                     <div class="modal-body">
                                         <p>¿Estás seguro que deseas eliminar (Soft Delete) el Movimiento **#{{ $movimiento->id }}**?</p>
                                         <p class="text-danger">Esta acción registrará la baja, pero mantendrá el registro.</p>
                                     </div>
                                     <form action="{{ route('movimientos.destroy', $movimiento->id) }}" method="POST">
                                         @csrf
                                         @method('DELETE') {{-- Método para la eliminación --}}
                                         <div class="modal-footer">
                                             <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                             <button type="submit" class="btn btn-danger">Eliminar (Soft Delete)</button>
                                         </div>
                                     </form>
                                 </div>
                             </div>
                         </div>
                         @endforeach
                         @endif
                     </tbody>
                 </table>
             </DIV>
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
         $('tabla-movimientos').bootstrapTable();
     });
 </script>