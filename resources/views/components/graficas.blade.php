
    <div class="container-fluid">
      <div class="row">
        @include('components.siderbar_panelcontrol')
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
          <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"
          >
            <h1 class="h2">Graficas</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-secondary">
                  Compartir
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary">
                  Exportar
                </button>
              </div>
            <div class="btn-group" id="timeRange">
                <select class="form-select" id="timeRangeMenu">
                    <option value="semana">Semana</option>
                    <option value="mes">Mes</option>
                    <option value="año">Año</option>
                </select>
            </div>

            </div>
          </div>
          <canvas
            class="my-4 w-100"
            id="myChart"
            width="900"
            height="380"
          ></canvas>
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
      class="astro-vvvwv3sm"
    ></script>
    <script src="dashboard.js" class="astro-vvvwv3sm"></script>