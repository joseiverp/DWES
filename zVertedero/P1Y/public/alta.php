<?php

use Jose\Biblioteca\Servicio\BibliotecaService;
require_once dirname(__DIR__) . '/vendor/autoload.php';

$libros = require dirname(__DIR__) . '/datos/libros.php';
$servicio = new BibliotecaService($libros);

require dirname(__DIR__) . '/vistas/alta.php';