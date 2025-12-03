<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table data-toggle="table" class="table table-responsive table-striped">
    <thead>
        <tr>
            <th>Tipo de Movimiento</th>
            <th>Fecha de Operación</th>
            <th>Cantidad</th>
            <th>Nº de Referencia</th>
            <th>Material</th>
            <th>Almacén</th>
            <th>Trabajador</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody class="table-group-divider">
        @if ($movimientos->isEmpty())
            <tr>
                {{-- Colspan debe ser 8 para abarcar todas las columnas --}}
                <td colspan="8" class="text-center">No hay movimientos registrados.</td>
            </tr>
        @else
            @foreach ($movimientos as $movimiento)
                <tr>
                    {{-- 1. Tipo de Movimiento --}}
                    <td>{{ $movimiento->tipo_movimiento ?? 'N/A' }}</td>
                    
                    {{-- 2. Fecha de Operación (formatos recomendados) --}}
                    <td>{{ $movimiento->fecha_hora ?? 'N/A' }}</td>
                    
                    {{-- 3. Cantidad --}}
                    <td>{{ $movimiento->cantidad }}</td>
                    
                    {{-- 4. Número de Referencia --}}
                    <td>{{ $movimiento->numero_referencia }}</td>
                    
                    {{-- 5. Nombre del Material --}}
                    <td>{{ $movimiento->materiales->nombre ?? 'N/A' }}</td>
                    
                    {{-- 6. Nombre del Almacén --}}
                    <td>{{ $movimiento->almacenes->nombre ?? 'N/A' }}</td>
                    
                    {{-- 7. Nombre del Trabajador (asumiendo columna 'name' o 'nombre') --}}
                    <td>{{ $movimiento->trabajador->name ?? 'Usuario Eliminado' }}</td>
                    
                    {{-- 8. Acciones --}}
                    <td>
                        <button class="btn btn-sm btn-primary" title="Ver Detalle"><i class="bi bi-eye"></i></button>
                        <button class="btn btn-sm btn-danger" title="Anular"><i class="bi bi-x-circle"></i></button>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
</body>
</body>
</html>