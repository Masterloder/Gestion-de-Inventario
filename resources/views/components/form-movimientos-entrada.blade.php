<form action="{{ route('movimientos.ingreso') }}" method="post" class="row g-3 needs-validation">
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
            $Materiales = DB::table('materiales')->get();
            $i = count($Materiales);
            $Cont =0;
            @endphp
            @foreach ($Materiales as $i )
            @php
            $cantidad = $Materiales[$Cont];
            $materiales = DB::table('materiales')->where('id',$cantidad->id)->first();
            $cantidad1[$Cont] = [
                'cantidad_actual' => '0',
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
        <label for="cantidad" class="form-label">Cantidad A Ingresar</label>
        <input
            type="text"
            inputmode="numeric"
            pattern="\d{1,8}"
            class="form-control"
            id="cantidad"
            name="cantidad"
            required
            maxlength="8"
            title="Ingresa solo números enteros (máx 8 dígitos)"
            oninput="this.value = this.value.replace(/\D/g,'').slice(0,8);"
        />
    </div>
    <button type="submit" class="btn btn-primary">Ingreso de materiales</button>
</form>