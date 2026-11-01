<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Model\Autor;
use App\Model\Libro;
use App\Model\Categoria;
use App\Importacion\Libro as LibroImportado;

$autor = new Autor('Frank Herbert');
$dune = new Libro('Dune', $autor);
echo $dune->ficha() . PHP_EOL;

$hobbit = new LibroImportado('El Hobbit');
echo $hobbit->titulo() . PHP_EOL;

$categoria = new Categoria('Ciencia ficción');
echo $categoria->nombre() . PHP_EOL;
