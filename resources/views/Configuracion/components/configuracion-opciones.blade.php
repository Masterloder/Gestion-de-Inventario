<div class="container-fluid ">
    <div class="row">
        @include('components.siderbar_panelcontrol')
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-5">
            <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-2">
                <h2 class="fw-bold text-black">
                    <i class="bi bi-gear-fill me-2"></i>&nbsp Configuración
                </h2>
            </div>

            @php
                $configOptions = [
                    [
                        'title' => 'Opciones de Configuración',
                        'desc'  => 'Administra parámetros generales y preferencias del sistema.',
                        'link'  => '#',
                        'icon'  => 'bi-sliders'
                    ],
                    [
                        'title' => 'Gestión de Usuarios',
                        'desc'  => 'Administra usuarios, roles, permisos y perfiles de acceso.',
                        'link'  => '/Usuarios',
                        'icon'  => 'bi-people'
                    ],
                    [
                        'title' => 'Unidades de Medidas',
                        'desc'  => 'Configura unidades como kilogramos, metros y litros.',
                        'link'  => 'configuracion/tabla-unidades-medicion',
                        'icon'  => 'bi-rulers'
                    ],
                    [
                        'title' => 'Categorías y Subcategorías',
                        'desc'  => 'Gestiona la organización jerárquica de materiales.',
                        'link'  => '/configuracion/tabla-categorias',
                        'icon'  => 'bi-tags'
                    ],
                    [
                        'title' => 'Materiales',
                        'desc'  => 'Administra el catálogo de materiales registrados.',
                        'link'  => 'configuracion/tabla-materiales',
                        'icon'  => 'bi-box-seam'
                    ],
                    [
                        'title' => 'Respaldos y Restauración',
                        'desc'  => 'Administra datos de respaldo y restauración del sistema.',
                        'link'  => '/backup/database',
                        'icon'  => 'bi-save'
                    ],
                ];
            @endphp

            <div class="row g-4">
                @foreach($configOptions as $option)
                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="card h-100 shadow-sm border-0 hover-shadow transition">
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-primary bg-opacity-10 p-3 rounded me-3">
                                        <i class="bi {{ $option['icon'] }} text-primary fs-4"></i>
                                    </div>
                                    <h5 class="card-title fw-bold mb-0 text-dark">{{ $option['title'] }}</h5>
                                </div>
                                
                                <p class="card-text text-muted flex-grow-1">
                                    {{ $option['desc'] }}
                                </p>
                                
                                <div class="mt-auto pt-3">
                                    <a href="{{ $option['link'] }}" class="btn btn-outline-primary w-100">
                                        Ir a {{ explode(' ', $option['title'])[0] }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
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