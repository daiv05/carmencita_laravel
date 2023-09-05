<?php

namespace App\Filtros;

interface InterfazFiltroProductosMasVendidos{

    public function filtrarPorFechaInicio($fechaInicio);

    public function filtrarPorFechaFin($fechaFin);

    public function filtrarPorCantidad($cantidad);

    public function filtrarPorFechaIncioYFechaFinYCantidad($fechaInicio, $fechaFin,$cantidad);

    public function filtrarPorFechaInicioYCantidad($fechaInicio,$cantidad);

    public function filtrarPorFechaFinYCantidad($fechaFin,$cantidad);

    public function obtenerProductosPorFechaInicioYFechaFin($fechaInicio, $fechaFin);

}