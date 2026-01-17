<div class="container-fluid">
    <div class="row">
        @include('components.siderbar_panelcontrol')
        <main class="col-md-9 sm-auto col-lg-10 px-md-4">
            <div class="table-responsive  mt-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2> <i class="bi bi-card-list"></i> &nbsp Materiales registrados</h2>
                    </div>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop1"> <i class="bi bi-clipboard-plus"></i> Nuevo Material</button>
                </div>
                <table data-toggle="table" style="table-layout: fixed; width: 100%;" class="table table-striped table-hover bg-white shadow-sm" data-search=" true" data-sort-stable="true" data-pagination="true">

                    <thead>
                        <tr>
                            <th data-sortable="true">Material</th>
                            <th data-sortable="true">Unidad de Medida</th>
                            <th data-sortable="true">Descripción</th>
                            <th data-sortable="true">Categoría</th>
                            <th data-sortable="true">Subcategoría</th>
                            <th class="text-center" style="white-space: nowrap; width: 1%;"> Acciones </th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @foreach($materiales as $material)
                        <tr>
                            <td>{{ $material->nombre }}</td>
                            <td>{{ $material->unidadMedida->nombre_unidad ?? '' }}</td>
                            <td>{{ $material->descripcion }}</td>
                            <td>{{ $material->categoria->nombre_categoria ?? '' }}</td>
                            <td>{{ $material->categoriaEspecifica->nombre_especifico ?? '' }}</td>
                            <td class="text-center" style="white-space: nowrap; width: 1%;">
                                <button type="button"
                                    class="btn btn-warning btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEdicion"
                                    data-id="{{ $material->id }}"
                                    data-nombre="{{ $material->nombre }}"
                                    data-descripcion="{{ $material->descripcion }}"
                                    data-unidad-id="{{ $material->unidad_medida_id }}"
                                    data-unidad-nombre="{{ $material->unidadMedida->nombre_unidad }}"
                                    data-categoria-id="{{ $material->categoria_id }}"
                                    data-categoria-nombre="{{ $material->categoria->nombre_categoria }}"
                                    data-sub-id="{{ $material->categoria_especifica_id }}"
                                    data-sub-nombre="{{ $material->categoriaEspecifica->nombre_especifico ?? 'Sin subcategoría' }}">
                                    <i class="bi bi-pencil"></i>
                                </button>

                                <button type="button"
                                    class="btn btn-danger btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEliminar"
                                    data-id="{{ $material->id }}"
                                    data-nombre="{{ $material->nombre }}">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                                <div class="modal fade" id="modalEliminar" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title" id="eliminarModalLabel{{ $material->id }}">Confirmar Eliminación</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>¿Estás seguro que deseas eliminar el Material {{ $material->nombre }}**?</p>
                                                <p class="text-danger">Esta acción registrará la baja, pero mantendrá el registro.</p>
                                            </div>
                                            <form action="{{ route('materiales.delete', $material->id) }}" method="POST">
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


                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <!-- Modal de Registro de Material -->
                <div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Registro de Material</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @include('components.form--materiales')
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal de Edición de Material -->
                <div class="modal fade" id="modalEdicion" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <form action="{{ route('materiales.postupdate', ['id' => $material->id]) }}" id="formEdicion" method="Post">
                                @csrf
                                @method('post')
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title">Editar Material</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Nombre</label>
                                            <input type="text" name="nombre" id="edit_nombre" class="form-control" maxlength="30" required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Unidad de Medida</label>
                                            <div class="dropdown">
                                                <button class="form-select text-start" type="button" id="btnEditUnidad" data-bs-toggle="dropdown">-- Seleccionar --</button>
                                                <ul class="dropdown-menu w-100">
                                                    @foreach($unidades as $u)
                                                    <li><button class="dropdown-item" type="button" onclick="updateEditField('Unidad', '{{ $u->id }}', '{{ $u->nombre_unidad }}')">{{ $u->nombre_unidad }}</button></li>
                                                    @endforeach
                                                </ul>
                                                <input type="hidden" name="unidad_medida_id" id="hiddenEditUnidad">
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Categoría Principal</label>
                                            <div class="dropdown">
                                                <button class="form-select text-start" type="button" id="btnEditCategoria" data-bs-toggle="dropdown">-- Seleccionar --</button>
                                                <ul class="dropdown-menu w-100">
                                                    @foreach($categorias as $cat)
                                                    <li>
                                                        <button class="dropdown-item" type="button"
                                                            onclick="updateEditField('Categoria', '{{ $cat->id }}', '{{ $cat->nombre_categoria }}'); filtrarSubcategorias('{{ $cat->id }}')">
                                                            {{ $cat->nombre_categoria }}
                                                        </button>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                                <input type="hidden" name="categoria_id" id="hiddenEditCategoria">
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Categoría Específica</label>
                                            <div class="dropdown">
                                                <button class="form-select text-start" type="button" id="btnEditSubcategoria" data-bs-toggle="dropdown">-- Seleccionar --</button>
                                                <ul class="dropdown-menu w-100" id="listaSubcategorias">
                                                    @foreach($categoriasEspecificas as $sub)
                                                    <li class="sub-item cat-parent-{{ $sub->categoria_id }}">
                                                        <button class="dropdown-item" type="button" onclick="updateEditField('Subcategoria', '{{ $sub->id }}', '{{ $sub->nombre_especifico }}')">{{ $sub->nombre_especifico }}</button>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                                <input type="hidden" name="categoria_especifica_id" id="hiddenEditSubcategoria">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Descripción</label>
                                        <textarea name="descripcion" id="edit_descripcion" class="form-control" rows="2" maxlength="250" ></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <script>
                    // Función para actualizar campos y nombres visuales
                    function updateEditField(tipo, id, nombre) {
                        document.getElementById('hiddenEdit' + tipo).value = id;
                        document.getElementById('btnEdit' + tipo).innerText = nombre;
                    }

                    /**
                     * Filtra las subcategorías y resetea la selección previa
                     */
                    function filtrarSubcategorias(categoriaId, esCargaInicial = false) {
                        const items = document.querySelectorAll('#listaSubcategorias .sub-item');
                        const btnSub = document.getElementById('btnEditSubcategoria');
                        const inputSub = document.getElementById('hiddenEditSubcategoria');
                        let hayOpciones = false;

                        // SI NO ES LA CARGA INICIAL (es decir, el usuario cambió la categoría manualmente)
                        // Reseteamos la subcategoría para obligar a elegir una nueva
                        if (!esCargaInicial) {
                            btnSub.innerText = '-- Seleccionar --';
                            inputSub.value = '';
                        }

                        items.forEach(item => {
                            if (item.classList.contains('cat-parent-' + categoriaId)) {
                                item.style.display = 'block';
                                hayOpciones = true;
                            } else {
                                item.style.display = 'none';
                            }
                        });

                        // Manejo de estado visual si la categoría no tiene hijos
                        if (!hayOpciones) {
                            btnSub.innerText = 'Sin categorías específicas';
                            btnSub.classList.add('disabled');
                        } else {
                            btnSub.classList.remove('disabled');
                        }
                    }

                    // Evento al abrir el modal
                    const modalEdicion = document.getElementById('modalEdicion');
                    modalEdicion.addEventListener('show.bs.modal', function(event) {
                        const button = event.relatedTarget;
                        const catId = button.getAttribute('data-categoria-id');

                        // Rellenar datos básicos
                        document.getElementById('edit_nombre').value = button.getAttribute('data-nombre');
                        document.getElementById('edit_descripcion').value = button.getAttribute('data-descripcion');

                        // Cargar IDs actuales
                        document.getElementById('hiddenEditUnidad').value = button.getAttribute('data-unidad-id');
                        document.getElementById('hiddenEditCategoria').value = catId;
                        document.getElementById('hiddenEditSubcategoria').value = button.getAttribute('data-sub-id');

                        // Cargar Textos actuales
                        document.getElementById('btnEditUnidad').innerText = button.getAttribute('data-unidad-nombre');
                        document.getElementById('btnEditCategoria').innerText = button.getAttribute('data-categoria-nombre');
                        document.getElementById('btnEditSubcategoria').innerText = button.getAttribute('data-sub-nombre');

                        // FILTRAR pasándole 'true' para que NO resetee el valor actual la primera vez que abre
                        filtrarSubcategorias(catId, true);

                        // Debe coincidir exactamente con el prefijo que pusiste en web.php
                        document.getElementById('formEdicion').action = "/configuracion/tabla-materiales/" + button.getAttribute('data-id');
                    });
                </script>
                <script>
                    const modalEliminar = document.getElementById('modalEliminar');
                    modalEliminar.addEventListener('show.bs.modal', function(event) {
                        const button = event.relatedTarget;
                        const id = button.getAttribute('data-id');
                        const nombre = button.getAttribute('data-nombre');

                        document.getElementById('nombreMaterialEliminar').innerText = nombre;

                        // ACTUALIZACIÓN: Apuntar a la ruta de eliminación con el ID
                        const form = document.getElementById('formEliminar');
                        form.action = '/configuracion/tabla-materiales/delete/' + id;
                    });
                </script>

            </div>
        </main>
    </div>
</div>