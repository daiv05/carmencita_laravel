<!DOCTYPE html>
<html>

<head>
    <title>Facturas - Credito Fiscal</title>
</head>

<body>
    <div style="margin-right: 20px; margin-left: 20px; margin-top: 110px">
        <div class="margen-right-fecha">
            <p class="text-sm text-right inset-y-0 right-0 font-mono">
                {{ date('d-m-Y', strtotime($credito->fecha_credito)) }}
            </p>
        </div>
        @if (isset($credito->cliente))
            <div class="margen-left-nombre-cliente">
                <p class="text-sm inset-y-0 left-0 font-mono">{{ $credito->cliente->distintivo_cliente }}</p>
                <p class="text-sm inset-y-0 left-0 font-mono"></p>
                <p class="text-sm inset-y-0 left-0 font-mono" style="margin-left: 35px;">
                    {{ $credito->cliente->direccion_cliente }}</p>
                <p class="text-sm inset-y-0 left-0 font-mono" style="margin-left: 35px;">
                    {{ $credito->cliente->municipio->nombre_municipio }} <label
                        style="margin-left: 200px;">{{ $credito->cliente->municipio->departamento->nombre_departamento }}
                    </label> </p>
                <p class="text-sm inset-y-0 left-0 font-mono" style="margin-left: 190px;">
                    {{ $credito->cliente->nrc_cliente }} <label
                        style="margin-left: 50px;">{{ $credito->cliente->dui_cliente }}</label> </p>
                <p class="text-sm inset-y-0 left-0 font-mono"></p>
                <p class="text-sm inset-y-0 left-0 font-mono"></p>
            </div>
        @else
            <div class="margen-left-nombre-cliente">
                <p class="text-sm inset-y-0 left-0 font-mono">-</p>
                <p class="text-sm inset-y-0 left-0 font-mono"></p>
                <p class="text-sm inset-y-0 left-0 font-mono" style="margin-left: 35px;">
                    -</p>
                <p class="text-sm inset-y-0 left-0 font-mono" style="margin-left: 35px;">
                    - <label style="margin-left: 200px;">-
                    </label> </p>
                <p class="text-sm inset-y-0 left-0 font-mono" style="margin-left: 190px;">
                    - <label style="margin-left: 50px;">-</label> </p>
                <p class="text-sm inset-y-0 left-0 font-mono"></p>
                <p class="text-sm inset-y-0 left-0 font-mono"></p>
            </div>
        @endif
        <div style="height: 300px">
            <table class="table">
                <thead>
                    <tr class="invisible">
                        <th class="font-bold">Cant.</th>
                        <th class="font-bold">Descripcion</th>
                        <th class="font-bold">Precio Unitario</th>
                        <th class="font-bold">Ventas sujetas</th>
                        <th class="font-bold">Ventas exentas</th>
                        <th class="font-bold">Ventas afectas</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($credito->detalleCredito as $detalles)
                        <tr>
                            <td class="text-left text-sm font-mono td-num">{{ $detalles->cantidad_producto_credito }}
                            </td>
                            @if ($detalles->descuentos == 0)
                                <td class="text-left text-sm font-mono td-descripcion">
                                    {{ $detalles->producto->nombre_producto }}</td>
                            @else
                                <td class="text-left text-sm font-mono td-descripcion">
                                    {{ $detalles->producto->nombre_producto . '          (-$' . number_format($detalles->descuentos, 2) . ' desc)' }}
                                </td>
                            @endif
                            <td class="text-left text-sm font-mono td-precio">$
                                {{ number_format($detalles->producto->precio_unitario, 4) }}</td>
                            <td class="text-left text-sm font-mono td-precio"></td>
                            <td class="text-left text-sm font-mono td-precio"></td>
                            <td class="text-left text-sm font-mono td-precio">$
                                {{ number_format($detalles->cantidad_producto_credito * $detalles->producto->precio_unitario, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <table class="table">
            <thead>
                <tr class="invisible">
                    <th class="font-bold">Cant.</th>
                    <th class="font-bold">Descripcion</th>
                    <th class="font-bold">Precio Unitario</th>
                    <th class="font-bold">Ventas sujetas</th>
                    <th class="font-bold">Ventas exentas</th>
                    <th class="font-bold">Ventas afectas</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr class="">
                    <td class="text-left td-h-10"></td>
                    <td class="text-left td-h-10"></td>
                    <td class="text-left td-h-10"></td>
                    <td class="text-left td-h-10"></td>
                    <td class="text-left td-h-10"></td>
                    <td class="text-left text-sm font-mono">$
                        {{ number_format($credito->total_credito - $credito->total_iva_credito, 2) }}</td>
                </tr>
                <tr class="">
                    <td class="text-left td-h-10"></td>
                    <td class="text-left td-h-10"></td>
                    <td class="text-left td-h-10"></td>
                    <td class="text-left td-h-10"></td>
                    <td class="text-left td-h-10"></td>
                    <td class="text-left text-sm font-mono">$ {{ number_format($credito->total_iva_credito, 2) }}</td>
                </tr>
                <tr class="">
                    <td class="text-left td-h-10"></td>
                    <td class="text-left td-h-10"></td>
                    <td class="text-left td-h-10"></td>
                    <td class="text-left td-h-10"></td>
                    <td class="text-left td-h-10"></td>
                    <td class="text-left td-h-10"></td>
                </tr>
                <tr class="">
                    <td class="text-left td-h-10"></td>
                    <td class="text-left td-h-10"></td>
                    <td class="text-left td-h-10"></td>
                    <td class="text-left td-h-10"></td>
                    <td class="text-left td-h-10"></td>
                    <td class="text-left td-h-10"></td>
                </tr>
                <tr class="">
                    <td class="text-left td-h-10"></td>
                    <td class="text-left td-h-10"></td>
                    <td class="text-left td-h-10"></td>
                    <td class="text-left td-h-10"></td>
                    <td class="text-left td-h-10"></td>
                    <td class="text-left td-h-10"></td>
                </tr>
                <tr class="">
                    <td class="text-left td-h-10"></td>
                    <td class="text-left td-h-10"></td>
                    <td class="text-left td-h-10"></td>
                    <td class="text-left td-h-10"></td>
                    <td class="text-left td-h-10"></td>
                    <td class="text-left text-sm font-mono">$ {{ number_format($credito->total_credito, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
<style>
    .td-h-10 {
        height: 18px;
    }

    .margen-right-fecha {
        margin-right: 40px;
    }

    .margen-left-nombre-cliente {
        margin-left: 40px;
    }

    .division-resumen {
        height: 500px;
        text-align: start;
        vertical-align: top;
    }

    .td-num {
        height: 10px;
        width: 5px;
    }

    .td-precio {
        height: 10px;
        width: 20px;
    }

    .td-descripcion {
        width: 200px;
        height: 20px;
    }

    @page {
        margin: 0px;
    }

    .text-right {
        text-align: right;
    }

    .inset-y-0 {
        top: 0;
        bottom: 0;
    }

    .right-0 {
        right: 0;
    }

    .pb-4 {
        padding-bottom: 1rem;
    }

    .font-mono {
        font-family: monospace;
    }

    /* Clases de Tailwind utilizadas en el segundo párrafo */
    .left-0 {
        left: 0;
    }

    .invisible {
        visibility: hidden;
    }

    .font-bold {
        font-weight: bold;
    }

    .text-sm {
        font-size: 0.6rem;
    }
</style>
