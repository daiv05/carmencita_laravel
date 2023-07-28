<!DOCTYPE html>
<html>

<head>
    <title>Título del PDF</title>
</head>

<body>
    <div class="grid-cols-2 gap-1 w-550">
        <p class="grid-rows-1 text-right inset-y-0 right-0 pb-4 font-mono">{{ date('d-m-Y', strtotime($venta->fecha_venta)) }}</p>
        <p class="grid-rows-1 inset-y-0 left-0 font-mono">{{ $venta->nombre_cliente_venta }}</p>

        <div class="h-500 border border-red-500">
            <table class="table w-full border border-red-500">
                <thead>
                    <tr class="h-10 bg-white invisible">
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
                    @foreach ($venta->detalleVenta as $detalles)
                        <tr class="border border-red-500 h-8">
                            <td class="text-left text-sm font-mono border">{{ $detalles->cantidad_producto }}</td>
                            <td class="text-left text-sm font-mono w-250">{{ $detalles->producto->nombre_producto }}</td>
                            <td class="text-left text-sm font-mono">$ {{ number_format($detalles->producto->precio_unitario, 4) }}</td>
                            <td class="text-left text-sm font-mono"></td>
                            <td class="text-left text-sm font-mono"></td>
                            <td class="text-left text-sm font-mono w-80">$ {{ number_format($detalles->cantidad_producto * $detalles->producto->precio_unitario, 4) }}</td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

        <div class="h-500 border border-red-500">
            <table class="table w-full border border-red-500">
                <thead>
                    <tr class="h-10 bg-white invisible">
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
                    <tr class="border border-red-500 h-8">
                        <td class="text-left border"></td>
                        <td class="text-left w-250"></td>
                        <td class="text-left"></td>
                        <td class="text-left"></td>
                        <td class="text-left"></td>
                        <td class="text-left text-sm font-mono">$ {{ number_format($venta->total_venta - $venta->total_iva, 2) }}</td>
                    </tr>
                    <tr class="border border-red-500 h-8">
                        <td class="text-left border"></td>
                        <td class="text-left w-250"></td>
                        <td class="text-left"></td>
                        <td class="text-left"></td>
                        <td class="text-left"></td>
                        <td class="text-left"></td>
                    </tr>
                    <tr class="border border-red-500 h-8">
                        <td class="text-left border"></td>
                        <td class="text-left w-250"></td>
                        <td class="text-left"></td>
                        <td class="text-left"></td>
                        <td class="text-left"></td>
                        <td class="text-left"></td>
                    </tr>
                    <tr class="border border-red-500 h-8">
                        <td class="text-left border"></td>
                        <td class="text-left w-250"></td>
                        <td class="text-left"></td>
                        <td class="text-left"></td>
                        <td class="text-left"></td>
                        <td class="text-left"></td>
                    </tr>
                    <tr class="border border-red-500 h-8">
                        <td class="text-left border"></td>
                        <td class="text-left w-250"></td>
                        <td class="text-left"></td>
                        <td class="text-left"></td>
                        <td class="text-left"></td>
                        <td class="text-left"></td>
                    </tr>
                    <tr class="border border-red-500 h-8">
                        <td class="text-left border"></td>
                        <td class="text-left w-250"></td>
                        <td class="text-left"></td>
                        <td class="text-left"></td>
                        <td class="text-left"></td>
                        <td class="text-left text-sm font-mono">$ {{ number_format($venta->total_venta, 2) }}</td>
                    </tr>

                </tbody>
            </table>
        </div>

    </div>

</body>

</html>

<script></script>

<style>
    /* Estilos generados a partir de Tailwind CSS */

    /* Clases de Tailwind utilizadas en el div principal */
    .grid-cols-2 {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .gap-1 {
        gap: 0.25rem;
    }

    .w-550 {
        width: 550px;
    }

    /* Clases de Tailwind utilizadas en el primer párrafo */
    .grid-rows-1 {
        grid-row: span 1 / span 1;
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

    /* Clases de Tailwind utilizadas en el div con clase "h-500" */
    .h-500 {
        height: 300px;
    }

    .border-red-500 {
        border-color: #EF4444;
    }

    /* Clases de Tailwind utilizadas en la tabla */
    .table {
        display: table;
        width: 100%;
    }

    /* Clases de Tailwind utilizadas en el thead y tr del encabezado de la tabla */
    .h-10 {
        height: 2.5rem;
    }

    .bg-white {
        background-color: #FFF;
    }

    .invisible {
        visibility: hidden;
    }

    /* Clases de Tailwind utilizadas en las celdas del encabezado de la tabla */
    .font-bold {
        font-weight: bold;
    }

    /* Clases de Tailwind utilizadas en las celdas de las filas de la tabla */
    .h-8 {
        height: 0.5rem;
    }

    .border {
        border-width: 1px;
    }

    .text-sm {
        font-size: 0.8rem;
    }

    .w-250 {
        width: 250px;
    }

    /* Clases de Tailwind utilizadas en la última celda de la tabla */
    .w-80 {
        width: 80px;
    }
</style>
