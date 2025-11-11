 <div class="container-fluid">
     <div class="row">
         @include('components.siderbar_panelcontrol')
         <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
             <div class="table-responsive mt-5">
                 <div>
                     <h2> <i class="bi bi-truck"></i> &nbsp Movimientos</h2>
                 </div>

                 <div class="btn-group ml-auto " role="group" aria-label="Basic example">
                     <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop1"> <i class="bi bi-clipboard-plus"></i> Nuevo Material</button>
                     <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop2"> <i class="bi bi-clipboard-plus"></i> Nuevo Almacen</button>
                     <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop3"> <i class="bi bi-clipboard-plus"></i> Nuevo Proveedor </button>
                 </div>
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
                 <div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                     <div class="modal-dialog modal-dialog-centered">
                         <div class="modal-content">
                             <div class="modal-header">
                                 <h1 class="modal-title fs-5" id="staticBackdropLabel">Registro de Almacen</h1>
                                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                             </div>
                             <div class="modal-body">
                                 @include('components.form--almacenes')
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="modal fade" id="staticBackdrop3" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                     <div class="modal-dialog modal-dialog-centered">
                         <div class="modal-content">
                             <div class="modal-header">
                                 <h1 class="modal-title fs-5" id="staticBackdropLabel">Registro de proveedores</h1>
                                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                             </div>
                             <div class="modal-body">
                                 @include('components.form-proveedor')
                             </div>
                         </div>
                     </div>
                 </div>

                 <table data-toggle="table" class=" table table-responsive">
                     <thead>
                         <tr>
                             <th>Material</th>
                             <th>Descripcion</th>
                             <th>Cantidad Disponible</th>
                             <th>Almacen</th>
                             <th>Acciones</th>
                         </tr>
                     </thead>
                     <tbody>
                         @php
                         use App\Models\Inventario;
                         $Post = new Inventario();
                         $Post = Inventario::all();
                         $Post1 = $Post[0];
                         $i = count($Post)
                         @endphp
                         @if ($i === null)
                         <td>Vacio</td>
                         <td>Vacio</td>
                         <td>Vacio</td>
                         <td>Vacio</td>
                         <td>Vacio</td>
                         @else
                         @foreach ($Post as $i )
                         <tr>
                             <td>{{ $Post1->id_material}}</td>
                             <td>{{ $Post1->id_almacen}}</td>
                             <td>{{ $Post1->cantidad_actual}}</td>
                             <td>{{ $Post1->id_almacen}}</td>
                         </tr>
                         @endforeach
                         @endif

                     </tbody>
                     </tbody>
             </DIV>
         </main>
     </div>
 </div>
 <script
     src="https://cdn.jsdelivr.net/npm/chart.js@4.3.2/dist/chart.umd.js"
     integrity="sha384-eI7PSr3L1XLISH8JdDII5YN/njoSsxfbrkCTnJrzXt+ENP5MOVBxD+l6sEG4zoLp"
     crossorigin="anonymous"
     class="astro-vvvwv3sm"></script>
 <script src="dashboard.js" class="astro-vvvwv3sm"></script>