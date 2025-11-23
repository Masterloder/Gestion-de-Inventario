<div class="container py-3">


        <div class="row g-4"> {{-- g-4 añade espacio entre columnas --}}

            <div class="col-lg-8">

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold text-dark">Edit Profile</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label text-secondary small fw-bold">Company (disabled)</label>
                                <input type="text" class="form-control" disabled placeholder="Company" value="Creative Code Inc.">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-secondary small fw-bold">Nombre de Usuario</label>
                                    <input type="text" name="username" class="form-control" value="{{ old('username', $user->name) }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-secondary small fw-bold">Correo Electronico</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-secondary small fw-bold">Nombre</label>
                                    <input type="text" name="first_name" class="form-control" value="Mike">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-secondary small fw-bold">Apellido</label>
                                    <input type="text" name="last_name" class="form-control" value="Andrew">
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-primary px-4">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold text-dark">Contraseña</h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label text-secondary small fw-bold">Contraseña Actual</label>
                                <input type="password" name="current_password" class="form-control">
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-secondary small fw-bold">Nueva Contraseña</label>
                                    <input type="password" name="password" class="form-control">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-secondary small fw-bold">Confirmar Contraseña</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-primary px-4">Actualizar Contraseña</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card card-user border-0 shadow-sm sticky-top" style="top: 20px; z-index: 1;">

                    <div class="card-header-bg"></div>

                    <div class="card-body pt-0">
                        <div class="avatar-wrapper">
                            <img src="{{ $user->avatar ?? '' }}" alt="Profile" class="avatar">
                        </div>

                        <div class="text-center mt-3">
                            <h5 class="fw-bold text-dark mb-1">{{ $user->name }} {{ $user->rol }}</h5>
                            <p class="text-muted small mb-3">{{ $user->email}}</p>


                            <div class="d-flex justify-content-center gap-2 mb-3">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>