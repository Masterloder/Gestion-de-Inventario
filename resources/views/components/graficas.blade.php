<div class="container-fluid">
  <div class="row">
    @include('components.siderbar_panelcontrol')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-chart">
                <div class="card-header">
                    <div class="row">
                        <div class="col-sm-6 text-left">
                            <h5 class="card-category">Movimientos totales</h5>
                            <h2 class="card-title">Movimientos</h2>
                        </div>
                        <div class="col-sm-6">
                            <div class="btn-group btn-group-toggle float-end" data-toggle="buttons">
                                <label class="btn btn-sm btn-primary btn-simple active" id="filter-dia">
                                    <input type="radio" name="options" data-periodo="dia">
                                    <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Día</span>
                                </label>
                                <label class="btn btn-sm btn-primary btn-simple" id="filter-semana">
                                    <input type="radio" name="options" data-periodo="semana">
                                    <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Semana</span>
                                </label>
                                <label class="btn btn-sm btn-primary btn-simple" id="filter-mes">
                                    <input type="radio" name="options" data-periodo="mes">
                                    <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Mes</span>
                                </label>
                                <label class="btn btn-sm btn-primary btn-simple active" id="filter-anio">
                                    <input type="radio" name="options" data-periodo="año" checked>
                                    <span class="d-none d-sm-block d-md-block d-lg-block d-xl-block">Año</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 350px;">
                        <canvas id="chartBig1"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-lg-6 col-md-12">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Entradas y Salidas</h5>
                    <h3 class="card-title"><i class="tim-icons icon-delivery-fast text-info"></i> Top 5 Materiales</h3>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 300px;">
                         <canvas id="chartBarBlue"></canvas> 
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-md-12">
            <div class="card card-chart">
                <div class="card-header">
                    <h5 class="card-category">Ranking de Actividad</h5>
                    <h3 class="card-title"><i class="tim-icons icon-user-run text-primary"></i> Top 5 Trabajadores</h3>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 300px;">
                        <canvas id="chartLineGreen"></canvas> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

      <h2>Proveedores</h2>
      <div class="table-responsive small">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">Serial</th>
              <th scope="col">Nombre</th>
              <th scope="col">Correo</th>
              <th scope="col">telefono</th>
              <th scope="col">Direccion</th>
            </tr>
          </thead>
          <tbody>
            @php
            use App\Models\Provedores;
            $Post = new Provedores();
            $Post = Provedores::all();
            @endphp
            @foreach ($Post as $post)
            <tr>
              <td>{{ $post->id }}</td>
              <td>{{ $post->nombre}}</td>
              <td>{{ $post->correo }}</td>
              <td>{{ $post->telefono }}</td>
              <td>{{ $post->direccion }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>
<script
  src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js"
  integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp"
  crossorigin="anonymous"
  class="astro-vvvwv3sm"></script>
<script src="dashboard.js" class="astro-vvvwv3sm"></script>