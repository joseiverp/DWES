<?php
use Jose\Biblioteca\Servicio\BibliotecaService;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$libros = require dirname(__DIR__) . '/datos/libros.php';

$servicio = new BibliotecaService($libros);

$q = $_GET['q'] ?? '';
$genero = $_GET['genero'] ?? '';
$tipo = $_GET['tipo'] ?? '';
$soloDestacados = isset($_GET['destacados']);

$librosFiltrados = $servicio->filtrar($q, $genero, $tipo, $soloDestacados);
$filas = $servicio->filas($librosFiltrados);
$resumen = $servicio->resumen($librosFiltrados);

require dirname(__DIR__)  . '/vistas/catalogo.php';