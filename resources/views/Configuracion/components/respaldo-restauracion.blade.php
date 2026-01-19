<div class="container-fluid ">
    <div class="row">
        @include('components.siderbar_panelcontrol')
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-5">
            
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
                <h2 class="fw-bold text-black">
                    <i class="bi bi-gear-fill me-2"></i>&nbsp Respaldos y Restauración
                </h2>
            </div>

            <div class="mb-4">
                <form action="{{ route('backup.database') }}" method="GET">
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <i class="bi bi-plus-circle me-1"></i> Generar Nuevo Backup Ahora
                    </button>
                </form>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3">
                            <h5 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2"></i>Historial de Backups</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nombre del Archivo</th>
                                            <th>Fecha de Creación</th>
                                            <th>Tamaño</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($backups as $backup)
                                        <tr>
                                            <td class="fw-medium text-primary">{{ $backup['name'] }}</td>
                                            <td>{{ $backup['date'] }}</td>
                                            <td><span class="badge bg-secondary">{{ $backup['size'] }}</span></td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <form action="{{ route('backup.restoreFromServer', $backup['name']) }}" method="POST" onsubmit="return confirm('¿Restaurar esta versión? Se perderán los datos actuales.')">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-warning">
                                                            <i class="bi bi-arrow-counterclockwise"></i> Restaurar
                                                        </button>
                                                    </form>
                                                    
                                                    <a href="{{ route('backup.downloadFile', $backup['name']) }}" class="btn btn-sm btn-outline-primary ms-1">
                                                        <i class="bi bi-download"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">No se encontraron respaldos guardados.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<style>
    .transition { transition: all 0.3s ease; }
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
</style>