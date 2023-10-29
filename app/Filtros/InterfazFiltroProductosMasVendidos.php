<?php

namespace App\Filtros;

interface InterfazFiltroProductosMasVendidos{

    public function filtrarPorFechaInicio($fechaInicio, $tipoOrden, $cantidadAMostrar);

    public function filtrarPorFechaFin($fechaFin, $tipoOrden, $cantidadAMostrar);

    public function filtrarPorCantidad($cantidad, $tipoOrden);

    public function filtrarPorFechaIncioYFechaFinYCantidad($fechaInicio, $fechaFin, $cantidad, $tipoOrden);

    public function filtrarPorFechaInicioYCantidad($fechaInicio,$cantidad, $tipoOrden);

    public function filtrarPorFechaFinYCantidad($fechaFin,$cantidad, $tipoOrden);

    public function obtenerProductosPorOrden($tipoOrden, $cantidadAMostrar);

    public function filtrarPorFechaInicioYFechaFin($fechaInicio, $fechaFin, $tipoOrden, $cantidadAMostrar);

}