<div class="container-fluid">
  <div class="row">
    @include('components.siderbar_panelcontrol')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="content p-4">
        <div class="row mb-4">
          <div class="col-12">
            <div class="card card-chart">
              <div class="card-header">
                <div class="row">
                  <div class="col-sm-6 text-left">
                    <h5 class="card-category text-dark">Movimientos totales</h5>
                    <h2 class="card-title text-info mb-0">Movimientos</h2>
                  </div>
                  <div class="col-sm-6">
                    {{-- Botones de toggle (Solo visuales por ahora) --}}
                    <div class="btn-group btn-group-toggle float-end" data-toggle="buttons">
                      <label class="btn btn-sm btn-primary active btn-simple">
                        <input type="radio" name="options" checked> Entradas
                      </label>
                      <label class="btn btn-sm btn-primary btn-simple">
                        <input type="radio" name="options"> Salidas
                      </label>
                      <label class="btn btn-sm btn-primary btn-simple">
                        <input type="radio" name="options"> Verificaciones
                      </label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <div class="chart-area" style="height: 300px;">
                  <canvas id="chartBig1"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">

          <div class="col-lg-4">
            <div class="card card-chart">
              <div class="card-header">
                <h5 class="card-category text-dark">Total Shipments</h5>
                <h3 class="card-title text-info"><i class="fas fa-bell text-primary"></i> 763,215</h3>
              </div>
              <div class="card-body">
                <div class="chart-area" style="height: 220px;">
                  <canvas id="chartLinePurple"></canvas>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="card card-chart">
              <div class="card-header">
                <h5 class="card-category text-dark">Daily Sales</h5>
                <h3 class="card-title text-info"><i class="fas fa-truck text-info"></i> 3,500€</h3>
              </div>
              <div class="card-body">
                <div class="chart-area" style="height: 220px;">
                  <canvas id="chartBarBlue"></canvas>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="card card-chart">
              <div class="card-header">
                <h5 class="card-category text-dark">Completed Tasks</h5>
                <h3 class="card-title text-info"><i class="fas fa-paper-plane text-success"></i> 12,100K</h3>
              </div>
              <div class="card-body">
                <div class="chart-area" style="height: 220px;">
                  <canvas id="chartLineGreen"></canvas>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

      <h2>Logística de Materiales</h2>
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