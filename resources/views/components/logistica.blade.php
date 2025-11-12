 <div class="container-fluid">
   <div class="row">
     @include('components.siderbar_panelcontrol')
     <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
       <div class="table-responsive mt-5">
         <div>
           <h2> <i class="bi bi-backpack4-fill  "></i>&nbsp Inventario</h2>
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


         <table data-toggle="table" class=" table table-responsive table-striped  ">
           <thead>
             <tr>
               <th>Material</th>
               <th>Descripcion</th>
               <th>Cantidad Disponible</th>
               <th>Almacen</th>
               <th>Ubicacion Fisica</th>
               <th>Acciones</th>
             </tr>
           </thead>
           <tbody class="table-group-divider">
             @php
             use App\Models\Inventario;
             use App\Models\Almacenes;
             use App\Models\Materiales;
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
               <td>Vacio</td>
             </tr>
             @else
             @foreach ($Post as $i )
             @php
             $Inventario = $Post[$Cont];
             $materiales = new Materiales();
             $materiales = Materiales::find($Inventario['id_material']);
             $almacen = new Almacenes();
             $almacen = Almacenes::find($Inventario['id_almacen']);
             @endphp

             <tr>
               <td>{{ $materiales->nombre}}</td>
               <td>{{ $materiales->descripcion}}</td>
               <td>{{ $Inventario->cantidad_actual }} {{ $Inventario->unidad_medida }}</td>
               <td>{{ $almacen->nombre}}</td>
               <td>{{ $almacen->direccion }}</td>
               <td><button><i class="bi bi-truck"></i></button><button><i class="bi bi-pencil"></i></button><button><i class="bi bi-eraser-fill"></i></button></td>
             </tr>
             @php
             $Cont = $Cont + 1;
             @endphp
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