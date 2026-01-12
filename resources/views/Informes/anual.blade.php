<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        /* Banner superior */
        .banner {
            background-color: #2c5e8c;
            color: white;
            text-align: center;
            padding: 20px;
            margin-bottom: 10px;
        }

        .banner h1 {
            margin: 0;
            font-size: 22px;
        }

        /* Encabezados de sección */
        .section-header {
            color: #3a8fb7;
            border-bottom: 2px solid #3a8fb7;
            font-size: 18px;
            text-align: center;
            margin: 15px 0;
            padding-bottom: 5px;
        }

        .blue-bar {
            background-color: #1a4567;
            color: white;
            text-align: center;
            padding: 5px;
            font-weight: bold;
            text-transform: uppercase;
        }

        /* Tablas */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th {
            background-color: #1a4567;
            color: white;
            padding: 8px;
            border: 1px solid #fff;
        }

        td {
            padding: 8px;
            border: 1px solid #eee;
            text-align: center;
        }

        .alt-row {
            background-color: #e8f1f8;
        }

        .stock-blue {
            background-color: #a2bfff;
            color: black;
            font-weight: bold;
        }

        /* Layout inferior */
        .split-container {
            width: 100%;
        }

        .split-box {
            width: 48%;
            vertical-align: top;
        }
    </style>
</head>

<body>
    <div class="section-header">Informe de Gestion de Inventario
    </div>
    <div class="blue-bar">detalles de los productos de mayor ingreso</div>

    <table class="table-responsive">
        <thead>
            <tr>
                <th>Nombre del producto</th>
                <th>Categoria</th>
                <th>Categoria especifica</th>
                <th>Descripcion</th>
                <th>Cantidad total Ingresados</th>
                <th>Cantidad Todal Despachados</th>
                <th>Cantidad disponible</th>
                <th>Mayor Proveedor</th>
            </tr>
        </thead>
        <tbody>
            @foreach($productos as $p)
            <tr>
                {{-- Accedemos a los datos a través de la relación materiales --}}
                <td>{{ $p->nombre ?? 'N/A' }}</td>
                <td>{{ $p->categoria->nombre_categoria ?? 'Sin Categoría' }}</td>
                <td>{{ $p->categoriaEspecifica->nombre_especifico ?? 'N/A' }}</td>
                <td>{{ $p->descripcion ?? 'Sin descripción' }}</td>

                {{-- Los totales calculados en el selectRaw --}}
                <td>{{ $p->total_ingresados ?? 0 }}</td>
                <td>{{ $p->total_despachados ?? 0 }}</td>
                {{-- Cantidad disponible en el periodo --}}
                <td style="font-weight: bold; background-color: #f8f9fa;">
                    {{ number_format($p->total_ingresados - $p->total_despachados, 2) }}
                </td>

                <td>{{ $p->materiales->mayor_proveedor ?? 'Varios' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table style="margin-top: -10px;">
        <thead>
            <tr>
                <th>Mayor Movimientos</th>
                <th>Nombre del Material</th>
                <th>Categorias</th>
                <th>Tipo de movimiento</th>
                <th>fecha del Movimiento</th>
                <th style="background-color: #2c5e8c;">Cantidad del Movimiento</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reporte as $mov)
            <tr>
                <td>{{ $mov->numero_referencia }}</td>
                <td>{{ $mov->material }}</td>
                <td>{{ $mov->categoria_general ?? 'General' }}</td>
                <td>{{ $mov->tipo_movimiento == 1 ? 'ENTRADA' : 'SALIDA' }}</td>
                <td>{{ $mov->fecha_operacion }}</td>
                <td style="background-color: #2c5e8c; color:white;">{{ $mov->cantidad }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-header">Trabajadores</div>
    <table>
        <thead>
            <tr>
                <th>trabajador</th>
                <th>Rol</th>
                <th>Correo</th>
                <th>Telefono</th>
                <th>salida Totales</th>
                <th>Despachos Totales</th>
            </tr>
        </thead>
        <tbody>
        <tbody>
            @foreach($proveedores as $proveedor)
            <tr>
                <td>{{ $proveedor->nombre }}</td>
                <td>{{ $proveedor->rol }}</td>
                <td>{{ $proveedor->correo }}</td>
                <td>{{ $proveedor->telefono }}</td>
                <td>{{ $proveedor->direccion }}</td>
                <td>{{ $proveedor->total_ingresos ?? 0 }}</td>
            </tr>
            @endforeach
        </tbody>
        </tbody>
    </table>

    <table class="split-container" >
        <tr>
            <td class="split-box" style="border:none; padding:0;">
                <div style="color:#3a8fb7; font-weight:bold; font-size:14px;">Proveedores con más materiales Ingresados</div>
                <table>
                    <thead>
                        <tr>
                            <th>Nombre del Proveedor</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Movimientos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($proveedores as $prov)
                        <tr>
                            <td>{{ $prov->nombre }}</td>
                            <td>{{ $prov->correo }}</td>
                            <td>{{ $prov->telefono }}</td>
                            <td>{{ $prov->direccion }}</td>
                            <td>{{ $prov->total_ingresos }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
            <td style="width:4%; border:none;"></td>
            <td class="split-box" style="border:none; padding:0;">
                <div style="width: 50%; margin: auto;">
    <canvas id="pastelMateriales"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('pastelMateriales').getContext('2d');
    
    // Convertir los datos de PHP a JSON para JS
    const datosMateriales = @json($topMateriales);
    
    const nombres = datosMateriales.map(m => m.nombre);
    const totales = datosMateriales.map(m => m.total_movido || 0);

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: nombres,
            datasets: [{
                label: 'Cantidad Total Movida',
                data: totales,
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' },
                title: { display: true, text: 'Top 5 Materiales con Más Movimiento' }
            }
        }
    });
</script>
            </td>
        </tr>
    </table>

</body>

</html>