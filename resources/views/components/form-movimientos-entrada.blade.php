<form action="{{ route('movimiento.ingreso') }}" method="post" class="row g-3 needs-validation">
    @csrf
        <div class="mb-3">
        <select class="form-control" name="id_almacen" id="id_almacen">
            <option selected disabled>--Elige un Almacen-</option>
            @php
            $almacenes = DB::table('almacenes')->get();
            $A = count($almacenes);
            $Cont=0;
            @endphp
            @foreach ($almacenes as $A )
            @php
            $almacen = $almacenes[$Cont];
            @endphp
            <option value="{{ $almacen->id }}">{{ $almacen->nombre }} | {{$almacen->direccion  }}</option>
            @php
            $Cont++;
            @endphp
            @endforeach

        </select>
    </div>
    <div class="mb-3">
        <select class="form-control" name="id_proveedor" id="id_proveedor">
            <option value="null" selected>--Elige un Proveedor-</option>
            @php
            $proveedores = DB::table('proveedores')->get();
            $A = count($proveedores);
            $Cont=0;
            @endphp
            @foreach ($proveedores as $A )
            @php
            $proveedor = $proveedores[$Cont];
            @endphp
            <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }} | {{$proveedor->correo}} | {{ $proveedor->telefono}}</option>
            @php
            $Cont++;
            @endphp
            @endforeach

        </select>
    </div>
    <div class="mb-3">
        <label for="fecha_hora" class="form-label">Fecha de entrada</label>
        <input type="datetime-local"
            class="form-control"
            id="fecha_hora"
            name="fecha_hora"
            required>
    </div>
    <div class="mb-3">
        <select class="form-control" name="materiales" id="materiales">
            <option selected disabled>--Elige un material-</option>
            @php
            $inventario = DB::table('inventario')->get();
            $i = count($inventario);
            $Cont =0;
            @endphp
            @foreach ($inventario as $i )
            @php
            $cantidad = $inventario[$Cont];
            $materiales = DB::table('materiales')->where('id',$cantidad->id_material)->first();
            $cantidad1[$Cont] = [
                'cantidad_actual' => $cantidad->cantidad_actual,
                'unidad_medida'  => $materiales->unidad_medida
            ];
            $material = $materiales;
            @endphp
            <option value="{{ $material->id }}">{{ $material->nombre }} {{ $material->unidad_medida}} | {{ $material->categoria }} | {{ $material->categoria_especifica }}</option>
            @php
            $Cont++;
            @endphp
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        @php
        // Mapear id_material => [cantidad_actual, unidad_medida]
        $map = [];
        foreach ($inventario as $inv) {
            $mat = DB::table('materiales')->where('id', $inv->id_material)->first();
            $map[$inv->id_material] = [
            'cantidad_actual' => $inv->cantidad_actual,
            'unidad_medida' => $mat->unidad_medida ?? ''
            ];
        }
        @endphp

        <label for="cantidad_input" class="form-label" id="cantidad_label">Cantidad Actual del Material: (0)</label>
        <input type="number" min="0" max="999999" class="form-control" id="cantidad_input" name="cantidad" required>

        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const cantidades = @json($map);
            const select = document.getElementById('materiales');
            const label = document.getElementById('cantidad_label');
            const input = document.getElementById('cantidad_input');

            const MAX_ALLOWED = 999999;
            const MAX_DIGITS = String(MAX_ALLOWED).length;

            function actualizar() {
            const id = select.value;
            const info = (cantidades && cantidades[id]) ? cantidades[id] : {cantidad_actual: 0, unidad_medida: ''};
            const cant = Number(info.cantidad_actual) || 0;
            const unidad = info.unidad_medida || '';

            label.textContent = 'Cantidad Actual del Material: (' + cant + (unidad ? ' ' + unidad : '') + ')';
            input.max = MAX_ALLOWED;
            input.setAttribute('maxlength', MAX_DIGITS);

            if (input.value !== '') {
                if (input.value.length > MAX_DIGITS) input.value = input.value.slice(0, MAX_DIGITS);
                if (Number(input.value) > MAX_ALLOWED) input.value = String(MAX_ALLOWED);
            }
            }

            input.addEventListener('input', function () {
            if (this.value.length > MAX_DIGITS) this.value = this.value.slice(0, MAX_DIGITS);
            if (this.value !== '' && Number(this.value) > MAX_ALLOWED) this.value = String(MAX_ALLOWED);
            if (/^0+\d+/.test(this.value)) this.value = String(Number(this.value));
            });

            select.addEventListener('change', actualizar);
            actualizar();
        });
        </script>
    </div>
    <button type="submit" class="btn btn-primary">Ingreso de materiales</button>
</form>