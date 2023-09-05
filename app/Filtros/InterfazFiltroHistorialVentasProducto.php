<?php

namespace App\Filtros;

interface InterfazFiltroHistorialVentasProducto{

    public function filtrarPorFechaInicio($fechaInicio);

    public function filtrarPorFechaFin($fechaFin);

    public function filtrarPorFechaIncioYFechaFin($fechaInicioVenta,$fechaFinVenta);

    public function filtrarPorMinimoIngresoProducto($minIngreso);

    public function filtrarPorMaximoIngresoProducto($maxIngreso);

    public function filtrarPorMinimoYMaximoIngresoProducto($minIngreso,$maxIngreso);

    public function filtrarPorMinimoCantidadProducto($minCantidadProducto);

    public function filtrarPorMaximoCantidadProducto($maxCantidadProducto);

    public function filtrarPorMinimioYMaximoCantidadProducto($minCantidadProducto,$maxCantidadProducto);
}