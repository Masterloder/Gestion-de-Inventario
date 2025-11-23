 <div class="container-fluid">
     <div class="row">
         @include('components.siderbar_panelcontrol')
         <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
             <div class="table-responsive mt-5">
                 <div>
                     <h2> <i class="bi bi-truck"></i> &nbsp Movimientos</h2>
                 </div>

                 <div class="btn-group ml-auto " role="group" aria-label="Basic example">
                     <button type="button" class="btn btn btn-secondary" data-bs-toggle="modal" data-bs-target="#staticBackdrop1"> <i class="bi bi-clipboard-plus"></i>Ingreso de Materiales</button>
                     <button type="button" class="btn btn btn-secondary" data-bs-toggle="modal" data-bs-target="#staticBackdrop2"> <i class="bi bi-clipboard-plus"></i>Salida de Materiales</button>
                 
                    </div>
                 <div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                     <div class="modal-dialog modal-dialog-centered">
                         <div class="modal-content">
                             <div class="modal-header">
                                 <h1 class="modal-title fs-5" id="staticBackdropLabel">ingreso de Materiales</h1>
                                 <button type="button" class="btn-close  " data-bs-dismiss="modal" aria-label="Close"></button>
                             </div>
                             <div class="modal-body">
                                @include('components.form-movimientos-entrada')
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                     <div class="modal-dialog modal-dialog-centered">
                         <div class="modal-content">
                             <div class="modal-header">
                                 <h1 class="modal-title fs-5" id="staticBackdropLabel">ingreso de </h1>
                                 <button type="button" class="btn-close  " data-bs-dismiss="modal" aria-label="Close"></button>
                             </div>
                             <div class="modal-body">
                                @include('components.form-movimientos-salida')
                             </div>
                         </div>
                     </div>
                 </div>

                 <table data-toggle="table" class=" table table-responsive table-striped  ">
                     <thead>
                         <tr>
                             <th>Material</th>
                             <th>Descripcion</th>
                             <th>Cantidad Disponible</th>
                             <th>Almacen</th>
                             <th>Acciones</th>
                         </tr>
                     </thead>
                     <tbody class="table-group-divider">
                         @php
                         use App\Models\Inventario;
                         $Post = new Inventario();
                         $Post = Inventario::all();
                         $i = count($Post);
                         $Cont = 0;
                         @endphp
                         @if ($i === null)
                         <tr>
                             <td>Vacio</td>
                             <td>Vacio</td>
                             <td>Vacio</td>
                             <td>Vacio</td>
                             <td>Vacio</td>
                         </tr>
                         @else
                         @foreach ($Post as $i )
                         @php
                         $Inventario = $Post[$Cont];
                         $materiales = DB::table('materiales')->find($Inventario['id_material']);
                         $almacen = DB::table('almacenes')->find($Inventario['id_almacen']);
                         @endphp
                         <tr>
                             <td>{{ $materiales->nombre}}</td>
                             <td>{{ $materiales->descripcion}}</td>
                             <td>{{ $Inventario->cantidad_actual}}</td>
                             <td>{{ $Inventario->id_almacen}}</td>
                             <td><button><i class="bi bi-truck"></i></button><button><i class="bi bi-pencil"></i></button><button><i class="bi bi-eraser-fill"></i></button></td>
                         </tr>
                         @php
                         $Cont = $Cont + 1;
                         @endphp
                         @endforeach
                         @endif
                     </tbody>
                 </table>
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