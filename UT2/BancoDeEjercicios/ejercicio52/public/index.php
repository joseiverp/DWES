<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Model\Personas\Autor;
use App\Model\Libro;
use App\Service\CatalogoService;

$autor1 = new Autor('Frank Herbert');
$libro1 = new Libro('Dune', $autor1);

$autor2 = new Autor('Stanislaw Lem');
$libro2 = new Libro('Solaris', $autor2);

$servicio = new CatalogoService([$libro1, $libro2]);

foreach ($servicio->fichas() as $ficha) {
    echo $ficha . PHP_EOL;
}

$servicioVacio = new CatalogoService([]);
foreach ($servicioVacio->fichas() as $ficha) {
    echo $ficha . PHP_EOL;
}
