<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Model/Autor.php';
require_once __DIR__ . '/../src/Model/Libro.php';
require_once __DIR__ . '/../src/Importacion/Libro.php';

use App\Model\Autor;
use App\Model\Libro;
use App\Importacion\Libro as LibroImportado;

$autor = new Autor('Frank Herbert');
$dune = new Libro('Dune', $autor);
echo $dune->ficha() . PHP_EOL;

$hobbit = new LibroImportado('El Hobbit');
echo $hobbit->titulo() . PHP_EOL;
