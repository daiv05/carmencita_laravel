<?php

namespace App\Filtros;

interface InterfazFiltroHistorialVentasProducto{
    /*Filtro por 4 parametros*/

    public function filtroFechaIncioValorVentasCantidades($fechaInicioVenta,$minTotal,$maxTotal,$minTotalProducto,$maxTotalProducto);
    public function filtroFechaFinValorVentasCantidades($fechaFinVenta,$minTotal,$maxTotal,$minTotalProducto,$maxTotalProducto);
    public function filtroFechasValorVentasCantidades($fechaInicioVenta,$fechaFinVenta,$minTotal,$maxTotal,$minTotalProducto,$maxTotalProducto);
    public function filtrarPorValorVentasCantidades($minTotal,$maxTotal,$minTotalProducto,$maxTotalProducto);
    public function filtrarPorFechaInicio($fechaInicioVenta);
    public function filtrarPorFechaFin($fechaFinVenta);
    public function filtrarPorFechas($fechaInicioVenta,$fechaFinVenta);
    public function obtenerTodos();
    




}