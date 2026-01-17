<div class="container-fluid">
    <div class="row">
        @include('components.siderbar_panelcontrol')

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="table-responsive mt-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="bi bi-card-list"></i> &nbsp Categorias y Categorias Especificas</h2>
                    <div>
                        <div class="btn-group ms-auto " role="group" aria-label="Basic example">
                            <!-- boton para abrir el modal de agregar nueva categoría -->
                            <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addcategoriaModal">
                                <i class="bi bi-plus-square"></i> Agregar Una nueva categoria
                            </button>
                            <!-- boton para abrir el modal de agregar nueva categoría específica -->
                            <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addcategoriaEspecificaModal">
                                <i class="bi bi-list-stars"></i> Agregar una nueva categoria especifica
                            </button>
                        </div>
                        <!-- Modal para agregar nueva categoría -->
                        <div class="modal fade" id="addcategoriaModal" tabindex="-1" aria-labelledby="addcategoriaModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-success text-white">
                                        <h5 class="modal-title" id="addcategoriaModalLabel">
                                            <i class="bi bi-plus-circle me-2"></i>Nueva Categoría
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <form action="{{ route('categorias.create') }}" method="post" onsubmit="return confirm('¿Estás seguro de agregar esta nueva categoría?');">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="nombre_categoria" class="form-label fw-bold">Nombre de la categoría</label>
                                                <input type="text"
                                                    name="nombre_categoria"
                                                    class="form-control @error('nombre_categoria') is-invalid @enderror"
                                                    id="nombre_categoria"
                                                    placeholder="Escribe el nombre aquí..."
                                                    maxlength="25"
                                                    required
                                                    autofocus>
                                                @error('nombre_categoria')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-success">
                                                <i class="bi bi-save me-1"></i> Guardar
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                        <!-- Modal para agregar nueva categoría específica -->
                        <div class="modal fade" id="addcategoriaEspecificaModal" tabindex="-1" aria-labelledby="addcategoriaEspecificaModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-success text-white">
                                        <h5 class="modal-title" id="addcategoriaEspecificaModalLabel">
                                            <i class="bi bi-list-stars me-2"></i>Nueva Categoría Específica
                                        </h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <form action="{{ route('categorias-especificas.create') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">

                                            <div class="mb-3">
                                                <label for="categoria_id" class="form-label fw-bold">Seleccionar Categoría Principal</label>
                                                <select name="categoria_id" id="categoria_id" class="form-select" required>
                                                    <option value="" selected disabled>Elija una categoría...</option>
                                                    @foreach($categorias as $categoria)
                                                    <option value="{{ $categoria->id }}">{{ $categoria->nombre_categoria }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label for="nombre_especifico" class="form-label fw-bold">Nombre de la Categoría Específica</label>
                                                <input type="text"
                                                    name="nombre_especifico"
                                                    id="nombre_especifico"
                                                    class="form-control"
                                                    placeholder="Ej: Naturales, Cerámicas Gruesas..."
                                                    maxlength="25"
                                                    required>
                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-success">Guardar Registro</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <table data-toggle="table" style="table-layout: auto; width: 100%;" class="table table-responsive table-striped table-hover bg-white shadow-sm" data-search="true" data-pagination="true">
                    <thead>
                        <tr>
                            <th data-field="categoria" data-sortable="true"> Categoria </th>
                            <th data-field="categoria_especifica" data-sortable="true"> Categoria Especifica </th>
                            <th class="text-center" style="white-space: nowrap; width: 1%;"> Acciones </th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @foreach ($categorias as $cat)
                        @if ($cat->categoriasEspecificas->isEmpty())
                        <tr>
                            <td>{{ $cat->nombre_categoria }}</td>
                            @if ($cat->categoriasEspecificas->isEmpty())
                            <td> No hay categorias especificas Registradas</td>
                            <td class="text-center" style="white-space: nowrap; width: 1%;">

                                <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addcategoriaEspecificaModal{{ $cat->id }}">
                                    <i class="bi bi-plus-square"></i> Agregar Específica
                                </button>



                                <div class="modal fade" id="addcategoriaEspecificaModal{{ $cat->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-success text-white">
                                                <h5 class="modal-title"><i class="bi bi-plus-circle"></i> Nueva Categoría Específica</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <form action="{{ route('categorias_especificas.create') }}" method="POST" onsubmit="return confirm('¿Estás seguro de agregar esta nueva subcategoría?');">
                                                @csrf
                                                <div class="modal-body text-start">
                                                    <input type="hidden" name="categoria_material_id" value="{{ $cat->id }}">

                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold">Categoría Padre</label>
                                                        <input type="text" class="form-control bg-light" value="{{ $cat->nombre_categoria }}" readonly>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="nombre_especifico_nuevo{{ $cat->id }}" class="form-label fw-bold">Nombre de la Categoría Específica</label>
                                                        <input type="text"
                                                            name="nombre_especifico"
                                                            id="nombre_especifico_nuevo{{ $cat->id }}"
                                                            class="form-control"
                                                            placeholder="Ej: Naturales, Procesados..."
                                                            maxlength="30"
                                                            required>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-success">Crear Subcategoría</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Botón para abrir el modal de eliminación -->
                                <button type="button"
                                    class="btn btn-danger mb-3"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteModalcategoria{{ $cat->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>

                                <!-- Modal de eliminación -->
                                <div class="modal fade" id="deleteModalcategoria{{ $cat->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered"> ">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title">Confirmar Eliminación</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Estás seguro de que deseas eliminar <strong>{{ $cat->nombre_categoria }}</strong>?
                                                <p class="text-muted small mt-2">Esta acción no se puede deshacer.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('categorias.delete', $cat->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-danger">Eliminar Definitivamente</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>
                            @endif
                        </tr>
                        @else
                        @foreach ($cat->categoriasEspecificas as $catEsp)
                        <tr>
                            <td>{{ $cat->nombre_categoria }}</td>
                            <td>{{ $catEsp->nombre_especifico }}</td>
                            <td class="text-center" style="white-space: nowrap; width: 1%;">
                                <!-- Botón para abrir el modal de edición -->
                                <button type="button"
                                    class="btn btn-primary btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $catEsp->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>


                                <!-- Modal de edición -->
                                <div class="modal fade" id="editModal{{ $catEsp->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title">Editar Categoría Específica</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('categorias.update', $catEsp->id) }}" method="POST" onsubmit="return confirm('¡Atención! No se podrá devolver el cambio una vez aceptado. ¿Deseas continuar?');">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="nombre_categoria_{{ $catEsp->id }}" class="form-label fs-5">Nombre de la Categoría</label>
                                                        <input type="text" class="form-control" id="nombre_categoria_{{ $catEsp->id }}" name="nombre_categoria" value="{{ $cat->nombre_categoria }}" maxlength="30" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="nombre_especifico_{{ $catEsp->id }}" class="form-label fs-5">Nombre de la Categoría Específica</label>
                                                        <input type="text" class="form-control" id="nombre_especifico_{{ $catEsp->id }}" name="nombre_especifico" value="{{ $catEsp->nombre_especifico }}" maxlength="30" required>
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
                                <!-- Botón para abrir el modal de eliminación -->
                                <button type="button"
                                    class="btn btn-danger btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $catEsp->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                                <!-- Modal de eliminación -->
                                <div class="modal fade" id="deleteModal{{ $catEsp->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered"> ">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title">Confirmar Eliminación</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Estás seguro de que deseas eliminar <strong>{{ $catEsp->nombre_especifico }}</strong>?
                                                <p class="text-muted small mt-2">Esta acción no se puede deshacer.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="{{ route('categorias_especificas.delete', $catEsp->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-danger">Eliminar Definitivamente</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>

                        </tr>
                        @endforeach
                        @endif
                        @endforeach
                    </tbody>
                </table>



            </div>

        </main>
    </div>
</div>