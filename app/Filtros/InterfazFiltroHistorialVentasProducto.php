<?php

namespace App\Filtros;

interface InterfazFiltroHistorialVentasProducto{
    /*Filtro por 4 parametros*/

    public function filtroFechaIncioValorVentasCantidades($fechaInicioVenta,$minTotal,$maxTotal,$minTotalProducto,$maxTotalProducto);
    public function filtroFechaFinValorVentasCantidades($fechaFinVenta,$minTotal,$maxTotal,$minTotalProducto,$maxTotalProducto);
    public function filtroFechasValorVentasCantidades($fechaInicioVenta,$fechaFinVenta,$minTotal,$maxTotal,$minTotalProducto,$maxTotalProducto);
    public function obtenerTodos();
    




}