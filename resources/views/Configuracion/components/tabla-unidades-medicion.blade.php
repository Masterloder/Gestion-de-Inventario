<div class="container-fluid">
    <div class="row">
        @include('components.siderbar_panelcontrol')
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="table-responsive mt-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="bi bi-card-list"></i>  &nbsp   Unidades de Medición</h2>
                    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#createUnidadModal">
                        <i class="bi bi-plus>"></i> Agregar Unidad de Medición
                    </button>
                </div>

                <table data-toggle="table" style="table-layout: fixed; width: 100%;" class="table table-striped table-hover bg-white shadow-sm" data-search="true" data-pagination="true">
                    <thead>
                        <tr>
                            <th data-sortable="true" style="width: 25%;">Unidad</th>
                            <th data-sortable="true" style="width: 15%;">Símbolo</th>
                            <th data-sortable="true" style="width: 20%;">Creación</th>
                            <th data-sortable="true" style="width: 20%;">Actualización</th>
                            <th class="text-center" style="width: 20%;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @foreach($unidades as $unidad)
                        <tr>
                            <td>{{ $unidad->nombre_unidad }}</td>
                            <td>{{ $unidad->simbolo }}</td>
                            <td>{{ $unidad->created_at->format('d/m/Y') }}</td>
                            <td>{{ $unidad->updated_at->format('d/m/Y') }}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $unidad->id }}">
                                    <i class="bi bi-pencil"></i>
                                </button>

                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $unidad->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>

                        @include('Configuracion.components.modals_unidades') 

                        @endforeach
                    </tbody>
                </table>
            </div>
            
        </main>
    </div>
</div>