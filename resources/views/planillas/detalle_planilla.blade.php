<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle Planilla</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12px;
        }
        h2 {
            text-align: left;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .table, .th, .td {
            border: 1px solid black;
        }
        .th, .td {
            padding: 5px;
            text-align: center;
        }
        .thead {
            background-color: #f9fafb;
            color: #333;
        }
        .bg-gray-50 {
            background-color: #f9fafb;
        }
        .text-gray-400 {
            color: #9ca3af;
        }
        .font-semibold {
            font-weight: 600;
        }
        .signature div {
            width: 200px;
            text-align: center;
        }
        .signature-line {
            border-bottom: 1px solid black;
            width: 200px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>

    <h2>TIENDA Y DEPÓSITO CARMENCITA</h2>
    <h3>PERIODOD DE PAGO: {{ Carbon\Carbon::parse($planilla->fecha_inicio)->format('d/m/Y') }} - {{ Carbon\Carbon::parse($planilla->fecha_fin)->format('d/m/Y') }}</h3>
    
    <table class="table border bg-white w-full m-auto">
        <thead>
            <tr class="text-gray-400 bg-gray-50 border-b">
                <th class="th">EMPLEADO</th>
                <th class="th">DIAS LABORADOS</th>
                <th class="th">SUELDO QUINCENAL</th>
                <th class="th">VACACIONES</th>
                <th class="th">AGUINALDO</th>
                <th class="th">BONO</th>
                <th class="th">MONTO GRAVABLE COTIZABLE</th>
                <th class="th">ISSS (3%)</th>
                <th class="th">AFP (7.25%)</th>
                <th class="th">ISSS PATRONAL</th>
                <th class="th">AFP PATRONAL</th>
                <th class="th">TOTAL A PAGAR AL EMPLEADO</th>
                <th class="th">TOTAL A DEPOSITAR EN LA PLANILLA UNICA</th>
            </tr>
        </thead>
        <tbody>
            @foreach($planilla->detallesPlanilla as $detallePlanilla)
            <tr>
                <td class="td">{{ $detallePlanilla->empleado->primer_nombre }}</td>
                <td class="td">{{ $detallePlanilla->dias_laborados }}</td>
                <td class="td">{{ number_format($detallePlanilla->base, 2) }}</td>
                <td class="td">{{ number_format($detallePlanilla->monto_vacaciones, 2) }}</td>
                <td class="td">{{ number_format($detallePlanilla->monto_aguinaldo, 2) }}</td>
                <td class="td">{{ number_format($detallePlanilla->monto_bonos, 2) }}</td>
                <td class="td">{{ number_format($detallePlanilla->monto_gravable_cotizable, 2) }}</td>
                <td class="td">{{ number_format($detallePlanilla->monto_isss, 2) }}</td>
                <td class="td">{{ number_format($detallePlanilla->monto_afp, 2) }}</td>
                <td class="td">{{ number_format($detallePlanilla->monto_isss_patronal, 2) }}</td>
                <td class="td">{{ number_format($detallePlanilla->monto_afp_patronal, 2) }}</td>
                <td class="td">{{ number_format($detallePlanilla->monto_pago_empleado, 2) }}</td>
                <td class="td">{{ number_format($detallePlanilla->monto_planilla_unica, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="signature">
        <div class="signature-line"></div>
        <div>Gerente</div>
    </div>
</body>
</html>
