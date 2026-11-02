<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Model\Libro;
use App\Repository\ArrayLibroRepository;
use App\Service\CatalogoService;

$libros = [
    new Libro(10, 'Dune', true),
    new Libro(20, 'Solaris', false),
    new Libro(30, 'Drácula', true),
];

$repo = new ArrayLibroRepository($libros);
$servicio = new CatalogoService($repo);

$titulos = $servicio->titulosDisponibles();
echo implode(', ', $titulos) . PHP_EOL;

$repoVacio = new ArrayLibroRepository([]);
$servicioVacio = new CatalogoService($repoVacio);

$titulosVacios = $servicioVacio->titulosDisponibles();
echo empty($titulosVacios) ? "Sin libros disponibles" . PHP_EOL : implode(', ', $titulosVacios) . PHP_EOL;
