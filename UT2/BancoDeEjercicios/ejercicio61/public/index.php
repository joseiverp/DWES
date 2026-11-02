<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Model\Libro;
use App\Repository\ArrayLibroRepository;
use App\Service\CatalogoService;
use App\Exception\LibroNoDisponibleException;

$dune = new Libro(10, 'Dune', 412, true);
$solaris = new Libro(20, 'Solaris', 216, false);
$dracula = new Libro(30, 'Drácula', 418, true);
$hobbit = new Libro(40, 'El Hobbit', 310, true);

$repo = new ArrayLibroRepository([$dune, $solaris, $dracula, $hobbit]);
$servicio = new CatalogoService($repo);

// Búsqueda vacía y máximo 500
$r1 = $servicio->buscarDisponibles('', 500);
$titulos1 = array_map(fn (Libro $l): string => $l->titulo(), $r1);
echo implode(', ', $titulos1) . PHP_EOL;

// Búsqueda ' DRÁ ' y máximo 500
$r2 = $servicio->buscarDisponibles(' DRÁ ', 500);
$titulos2 = array_map(fn (Libro $l): string => $l->titulo(), $r2);
echo implode(', ', $titulos2) . PHP_EOL;

// Búsqueda 'xyz'
$r3 = $servicio->buscarDisponibles('xyz', 500);
echo empty($r3) ? "Sin resultados" . PHP_EOL : implode(', ', array_map(fn (Libro $l): string => $l->titulo(), $r3)) . PHP_EOL;

// Prestar id 10 y capturar segundo intento
$servicio->prestarPorId(10);
try {
    $servicio->prestarPorId(10);
} catch (LibroNoDisponibleException $e) {
    echo "Capturada: " . $e->getMessage() . PHP_EOL;
}

$r4 = $servicio->buscarDisponibles('', 500);
$titulos4 = array_map(fn (Libro $l): string => $l->titulo(), $r4);
echo implode(', ', $titulos4) . PHP_EOL;

// Devolver id 10
$servicio->devolverPorId(10);
$r5 = $servicio->buscarDisponibles('', 500);
$titulos5 = array_map(fn (Libro $l): string => $l->titulo(), $r5);
echo implode(', ', $titulos5) . PHP_EOL;

// Capturas de id 99 y máximo 0
try {
    $servicio->prestarPorId(99);
} catch (InvalidArgumentException $e) {
    echo "Capturada: " . $e->getMessage() . PHP_EOL;
}

try {
    $servicio->buscarDisponibles('', 0);
} catch (InvalidArgumentException $e) {
    echo "Capturada: " . $e->getMessage() . PHP_EOL;
}
