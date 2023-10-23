<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hoja de ruta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>

    <main class="">

        <div class="mt-5">
            <label for="" class="h1 px-5">Hoja de Ruta</label>
        </div>

        <div class="mt-5">
            <label for="" class="px-5">Fecha de entrega: </label>
            <label for="">{{ date('d/m/Y', strtotime($hoja_de_ruta->fecha_entrega)) }}</label>

            <label for="" class="px-5">Repartidor encargado:</label>
            <label
                for="">{{ $hoja_de_ruta->empleado->primer_nombre . ' ' . $hoja_de_ruta->empleado->primer_apellido }}</label>
        </div>

        <div class="mt-5">
            <label for="" class="h4 px-5">Lista de Pedidos: </label>
        </div>

        <div class="mt-5">
            <div class="container">
                <table class="table">
                    <thead class="table-light rounded-md">
                        <tr>
                            <th>No.</th>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>

                        @php
                            $index = 1;
                        @endphp

                        @foreach ($hoja_de_ruta->ventaDomicilio as $venta_domicilio)
                            <tr>
                                <td>{{ $index++ }}</td>
                                <td>{{ $venta_domicilio->venta->nombre_cliente_venta }}</td>
                                <td> </td>
                                <td>$ {{ number_format($venta_domicilio->venta->total_venta, 2) }}</td>
                            </tr>
                        @endforeach

                        @foreach ($hoja_de_ruta->creditoFiscalDomicilio as $credito_domicilio)
                            <tr>
                                <td>{{ $index++ }}</td>
                                <td>{{ $credito_domicilio->creditoFiscal->cliente->distintivo_cliente }}</td>
                                <td>{{ $credito_domicilio->creditoFiscal->cliente->direccion_cliente }}</td>
                                <td>$ {{ number_format($credito_domicilio->creditoFiscal->total_credito, 2) }}</td>
                            </tr>
                        @endforeach

                        <tr>
                            <th colspan="3">Total Pedidos</th>
                            <td>$ {{ number_format($hoja_de_ruta->total, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

</body>

</html>
