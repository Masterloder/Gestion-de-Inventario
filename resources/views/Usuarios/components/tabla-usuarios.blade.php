<div class="container-fluid ">
    <div class="row">
        @include('components.siderbar_panelcontrol')
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-5">
            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
                <h2 class="fw-bold text-black">
                    <i class="bi bi-gear-fill me-2"></i>&nbsp Administracion de Usuarios
                </h2>
            </div>

            <div>
                <table data-toggle="table" class="table table-responsive table-striped table-hover " data-search="true" data-sort-stable="true" data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <thead class="table-">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Usuario</th>
                                <th scope="col" >Nombre</th>
                                <th scope="col">Correo</th>
                                <th scope="col">Rol</th>
                                <th scope="col" >Autorizacion </th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            @foreach($usuarios as $usuario)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $usuario->name }}</td>
                                <td>{{ $usuario->firstname }} {{ $usuario->lastname }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td>{{ $usuario->rol }}</td>
                                <td class="text-center align-middle">
                                    <form action="{{ route('usuarios.autorizacion', $usuario->id) }}" method="POST" onsubmit="return confirm('{{ $usuario->autorizacion ? '¿Está seguro de que desea revocar la autorización de este usuario?' : '¿Está seguro de que desea autorizar el ingreso de este usuario?' }}');" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="autorizar" value="{{ $usuario->autorizacion ? 0 : 1 }}">
                                        <button type="submit" class="btn {{ $usuario->autorizacion ? 'btn-success' : 'btn-danger' }}" title="{{ $usuario->autorizacion ? 'Revocar autorización' : 'Autorizar usuario' }}">
                                            {{ $usuario->autorizacion ? 'Autorizado' : 'No Autorizado' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="text-center align-middle">
                                    <!-- Botón para modificar usuario (abre modal) -->
                                    <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditarUsuario{{ $usuario->id }}">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <!-- Botón para ver información completa (abre modal) -->
                                    <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalVerUsuario{{ $usuario->id }}">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <!-- Botón para softdelete (abre modal de confirmación) -->
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modalSoftDeleteUsuario{{ $usuario->id }}">
                                        <i class="bi bi-trash3"></i>
                                    </button>

                                    <!-- Modal Modificar Usuario -->
                                    <div class="modal fade" id="modalEditarUsuario{{ $usuario->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1 aria-labelledby="editarUsuarioLabel{{ $usuario->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered ">
                                            <div class="modal-content">
                                                <form action="{{ route('usuarios.update', $usuario->id) }}"  method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editarUsuarioLabel{{ $usuario->id }}">Modificar Usuario</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Campos de edición -->
                                                        <div class="mb-3 text-start">
                                                            <label for="name{{ $usuario->id }}" class="form-label">Usuario</label>
                                                            <input type="text" class="form-control" id="name{{ $usuario->id }}" name="name" value="{{ $usuario->name }}" maxlength="20"
                                                                pattern="^[a-zA-Z0-9._-]{4,20}$"
                                                                title="El usuario debe tener entre 4 y 20 caracteres, solo letras, números, puntos, guiones y guiones bajos"
                                                                oninput="this.value = this.value.replace(/[^a-zA-Z0-9._-]/g, '')">
                                                        </div>
                                                        <div class="mb-3 text-start">
                                                            <label for="firstname{{ $usuario->id }}" class="form-label">Nombre</label>
                                                            <input type="text" class="form-control" id="firstname{{ $usuario->id }}" name="firstname" value="{{ $usuario->firstname }}" maxlength="35"
                                                                pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
                                                                title="Solo letras y espacios, sin números ni caracteres especiales"
                                                                oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '')">
                                                        </div>
                                                        
                                                        <div class="mb-3 text-start">
                                                            <label for="lastname{{ $usuario->id }}" class="form-label">Apellido</label>
                                                            <input type="text" class="form-control" id="lastname{{ $usuario->id }}" name="lastname" value="{{ $usuario->lastname }}" maxlength="35"
                                                                 pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$"
                                                                title="Solo letras y espacios, sin números ni caracteres especiales"
                                                                oninput="this.value = this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñ\s]/g, '')">
                                                        </div>
                                                        <div class="mb-3 text-start">
                                                            <label for="email{{ $usuario->id }}" class="form-label">Correo</label>
                                                            <input type="email" class="form-control" id="email{{ $usuario->id }}" name="email" value="{{ $usuario->email }}" maxlength="35">
                                                        </div>
                                                        <div class="mb-3 text-start">
                                                            <label for="rol{{ $usuario->id }}" class="form-label">Rol</label>
                                                            <select class="form-select" id="rol{{ $usuario->id }}" name="rol">
                                                                <option value="administrador" {{ $usuario->rol == 'administrador' ? 'selected' : '' }}>Administrador</option>
                                                                <option value="operador de almacen" {{ $usuario->rol == 'operador de almacen' ? 'selected' : '' }}>Operador de Almacen</option>
                                                            </select>
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

                                    <!-- Modal Ver Información Usuario -->
                                    <div class="modal fade" id="modalVerUsuario{{ $usuario->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1 aria-labelledby="verUsuarioLabel{{ $usuario->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered ">
                                            <div class="modal-content">
                                                <div class="modal-header bg-info">
                                                    <h5 class="modal-title" id="verUsuarioLabel{{ $usuario->id }}">Información Completa del Usuario</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Usuario:</strong> {{ $usuario->name }}</p>
                                                    <p><strong>Nombre:</strong> {{ $usuario->firstname }} {{ $usuario->lastname }}</p>
                                                    <p><strong>Correo:</strong> {{ $usuario->email }}</p>
                                                    <p><strong>Rol:</strong> {{ $usuario->rol }}</p>
                                                    <!-- Agrega más campos si es necesario -->
                                                    <!-- Formulario para cambiar la contraseña -->
                                                    <form action="{{ route('usuarios.cambiarPassword', $usuario->id) }}" method="POST" onsubmit="return validarCambioPassword{{ $usuario->id }}();">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="password{{ $usuario->id }}" class="form-label">Nueva Contraseña</label>
                                                            <input type="password" class="form-control" id="password{{ $usuario->id }}" name="password" 
                                                                pattern="^(?=.*[A-Za-z])(?=.*[^A-Za-z0-9]).{8,14}$"
                                                                title="Debe tener entre 8 y 14 caracteres, al menos una letra y un caracter especial" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="password_confirmation{{ $usuario->id }}" class="form-label">Repetir Contraseña</label>
                                                            <input type="password" class="form-control" id="password_confirmation{{ $usuario->id }}" name="password_confirmation" required>
                                                        </div>
                                                        <button type="submit" class="btn btn-danger">Cambiar Contraseña</button>
                                                    </form>
                                                    <script>
                                                    function validarCambioPassword{{ $usuario->id }}() {
                                                        var pass = document.getElementById('password{{ $usuario->id }}').value;
                                                        var pass2 = document.getElementById('password_confirmation{{ $usuario->id }}').value;
                                                        var regex = /^(?=.*[A-Za-z])(?=.*[^A-Za-z0-9]).{8,14}$/;
                                                        if (!regex.test(pass)) {
                                                            alert('La contraseña debe tener entre 8 y 14 caracteres, al menos una letra y un caracter especial.');
                                                            return false;
                                                        }
                                                        if (pass !== pass2) {
                                                            alert('Las contraseñas no coinciden.');
                                                            return false;
                                                        }
                                                        return confirm('¿Está seguro de que desea cambiar la contraseña? Esta acción no podrá ser revertida.');
                                                    }
                                                    </script>

                                                    <script>
                                                    function confirmarCambioPassword() {
                                                        return confirm('¿Está seguro de que desea cambiar la contraseña? Esta acción no podrá ser revertida.');
                                                    }
                                                    </script>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal SoftDelete Usuario -->
                                    <div class="modal fade" id="modalSoftDeleteUsuario{{ $usuario->id }}" tabindex="-1" aria-labelledby="softDeleteUsuarioLabel{{ $usuario->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('usuarios.delete', $usuario->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="softDeleteUsuarioLabel{{ $usuario->id }}">Eliminar Usuario</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>¿Está seguro de que desea eliminar este usuario? Esta acción es reversible.</p>
                                                        <p><strong>{{ $usuario->name }}</strong> ({{ $usuario->email }})</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </div>
                </table>
            </div>

        </main>
    </div>
</div>

<style>
    .transition {
        transition: all 0.3s ease;
    }

    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
    }
</style>