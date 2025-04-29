<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Planilla</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
        }

        .info,
        .totals,
        .signature {
            width: 100%;
            margin-bottom: 20px;
        }

        .info td,
        .totals td {
            padding: 8px;
            /*border: 1px solid #000;*/
        }

        .signature {
            text-align: center;
        }

        .signature div {
            margin-top: 60px;
        }

        table {
            border: none;
        }

        td, tr,
        th {
            border: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Tienda y Depósito Carmencita</h1>
            <h2>Boleta de Pago</h2>
            <p>{{ $periodo_pago }}</p>
        </div>
        <h3>Información del empleado:</h3>
        <table class="info">
            <tr>
                <td><strong>Nombre:</strong> {{ $empleado->primer_nombre }} {{ $empleado->segundo_nombre }}
                    {{ $empleado->primer_apellido }} {{ $empleado->segundo_apellido }}</td>
                    <td><strong>Residencia:</strong> {{ $empleado->residencia }}</td>
            </tr>
            <tr>
                <td><strong>DUI:</strong> {{ $empleado->dui_empleado }}</td>
                <td><strong>Domicilio:</strong> {{ $empleado->domicilio }}</td>
            </tr>
            <tr>
                <td><strong>Teléfono:</strong> {{ $empleado->telefono }}</td>
                <td><strong>Profesión:</strong> {{ $empleado->profesion_oficio }}</td>
            </tr>
        </table>
        <table class="totals">
            <tr><strong>Días trabajados: </strong>{{$detallePlanilla->dias_laborados}}</tr>
            <tr>
                <td>(+) Ingresos percibidos</td>
                <td>(-) Egresos y deducciones</td>
            </tr>
            <tr>
                <td><strong>Salario devengado:</strong> ${{ $detallePlanilla->base }}</td>
                <td><strong>ISSS:</strong> ${{ $detallePlanilla->monto_isss }}</td>
            </tr>
            <tr>
                <td><strong>Aguinaldo:</strong> ${{ $detallePlanilla->monto_aguinaldo }}</td>
                <td><strong>AFP:</strong> ${{ $detallePlanilla->monto_afp }}</td>
            </tr>
            <tr>
                <td><strong>Bonificaciones:</strong> ${{ $detallePlanilla->monto_bonos }}</td>
                <td><strong>Total egresos:</strong> ${{ $detallePlanilla->monto_afp + $detallePlanilla->monto_isss }}</td>
            </tr>
            <tr>
                <td><strong>Vacación 30%:</strong> ${{ $detallePlanilla->monto_vacaciones }}</td>
                <td></td>
            </tr>
            <tr>
                <td><strong>Total ingresos:</strong> ${{ $detallePlanilla->monto_gravable_cotizable }}</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3" align="center"><strong>Total Neto a recibir:</strong>
                    ${{ $detallePlanilla->monto_pago_empleado }}</td>
            </tr>
        </table>
        <div class="signature">
            <div>F._______________________</div>
            <div style="margin-top: 0;">{{ $empleado->cargo->nombre_cargo }}</div>
            <div style="margin-top: 0;">{{ $empleado->primer_nombre }} {{ $empleado->segundo_nombre }}
                {{ $empleado->primer_apellido }} {{ $empleado->segundo_apellido }}</div>
        </div>
    </div>
</body>

</html>
