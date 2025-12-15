<div class="container-fluid">
    <div class="row">
        <main class="col-md-9 sm-auto col-lg-10 px-md-4">
            <div class="table-responsive mt-5">
            <table data-toggle="table" class="table table-bordered table-hover table-responsive mt-5">
                <div class="d-flex justify-content-between align-items-center mb-4" >
                    <div>
                        <h2> <i class="bi bi-card-list"></i> &nbsp Materiales registrados</h2>
                    </div>
                    
                    
                </div>
                <thead>
                    <tr>
                        <th>Material</th>
                        <th>Unidad de Medida</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>Subcategoría</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($materiales as $material)
                    <tr>
                        <td>{{ $material->nombre }}</td>
                        <td>{{ $material->unidad_medida }}</td>
                        <td>{{ $material->descripcion }}</td>
                        <td>{{ $material->categoria ?? '' }}</td>
                        <td>{{ $material->categoria_especifica ?? '' }}</td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
            </div>
        </main>
    </div>
</div>