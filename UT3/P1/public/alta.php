<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use Jose\Biblioteca\Modelo\LibroDigital;
use Jose\Biblioteca\Modelo\LibroPapel;
use Jose\Biblioteca\Servicio\BibliotecaService;

$libros = require dirname(__DIR__) . '/datos/libros.php';
$servicio = new BibliotecaService($libros);

$valores = [
    'tipo' => '',
    'titulo' => '',
    'autor' => '',
    'paginas' => '',
    'genero' => '',
    'unidades' => '',
    'fechaAlta' => '',
    'destacado' => false,
    'observaciones' => '',
    'correo' => '',
];
$errores = [];
$ficha = null;
$filas = [];
$resumen = [];

$metodo = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$esPost = ($metodo === 'POST');

if ($esPost) {
    // leemos los campos de texto comprobando que sean cadenas
    $camposTexto = ['tipo', 'titulo', 'autor', 'paginas', 'genero', 'unidades', 'fechaAlta', 'observaciones', 'correo'];
    $textos = [];

    foreach ($camposTexto as $campo) {
        $entrada = $_POST[$campo] ?? '';
        if (!is_string($entrada)) {
            $errores[$campo] = 'Debe ser texto.';
            $valores[$campo] = '';
            $textos[$campo] = '';
        } else {
            $recortado = trim($entrada);
            $valores[$campo] = $recortado;
            $textos[$campo] = $recortado;
        }
    }

    if (!isset($errores['tipo'])) {
        if (!in_array($textos['tipo'], ['papel', 'digital'], true)) {
            $errores['tipo'] = 'Elige un tipo válido.';
        }
    }

    if (!isset($errores['titulo'])) {
        if ($textos['titulo'] === '') {
            $errores['titulo'] = 'Escribe el título.';
        } elseif (mb_strlen($textos['titulo'], 'UTF-8') > 120) {
            $errores['titulo'] = 'Máximo 120 caracteres.';
        }
    }

    if (!isset($errores['autor'])) {
        if ($textos['autor'] === '') {
            $errores['autor'] = 'Escribe el autor.';
        } elseif (mb_strlen($textos['autor'], 'UTF-8') > 100) {
            $errores['autor'] = 'Máximo 100 caracteres.';
        }
    }

    $paginasEntero = null;
    if (!isset($errores['paginas'])) {
        $paginasValidadas = filter_var($textos['paginas'], FILTER_VALIDATE_INT);
        if ($paginasValidadas === false || $paginasValidadas < 1 || $paginasValidadas > 3000) {
            $errores['paginas'] = 'Entre 1 y 3000 páginas.';
        } else {
            $paginasEntero = $paginasValidadas;
        }
    }

    if (!isset($errores['genero'])) {
        if (!in_array($textos['genero'], ['ciencia', 'fantasia', 'terror'], true)) {
            $errores['genero'] = 'Elige un género válido.';
        }
    }

    $unidadesEntero = null;
    if (!isset($errores['unidades'])) {
        $unidadesValidadas = filter_var($textos['unidades'], FILTER_VALIDATE_INT);
        if ($unidadesValidadas === false || $unidadesValidadas < 1 || $unidadesValidadas > 50) {
            $errores['unidades'] = 'Entre 1 y 50 unidades.';
        } else {
            $unidadesEntero = $unidadesValidadas;
        }
    }

    $fechaAltaObj = null;
    if (!isset($errores['fechaAlta'])) {
        if ($textos['fechaAlta'] === '') {
            $fechaAltaObj = null;
        } else {
            try {
                $fechaParseada = DateTimeImmutable::createFromFormat('!Y-m-d', $textos['fechaAlta']);
            } catch (\ValueError) {
                $fechaParseada = false;
            }

            if ($fechaParseada === false || $fechaParseada->format('Y-m-d') !== $textos['fechaAlta']) {
                $errores['fechaAlta'] = 'Fecha no válida.';
            } else {
                $fechaAltaObj = $fechaParseada;
            }
        }
    }

    $destacadoBool = false;
    if (!isset($_POST['destacado'])) {
        $destacadoBool = false;
        $valores['destacado'] = false;
    } else {
        $marca = $_POST['destacado'];
        if (!is_string($marca) || $marca !== '1') {
            $errores['destacado'] = 'Valor no válido.';
            $valores['destacado'] = false;
        } else {
            $destacadoBool = true;
            $valores['destacado'] = true;
        }
    }

    if (!isset($errores['observaciones'])) {
        if (mb_strlen($textos['observaciones'], 'UTF-8') > 300) {
            $errores['observaciones'] = 'Máximo 300 caracteres.';
        }
    }

    if (!isset($errores['correo'])) {
        $correoValidado = filter_var($textos['correo'], FILTER_VALIDATE_EMAIL);
        if ($textos['correo'] === '' || $correoValidado === false) {
            $errores['correo'] = 'Escribe un correo válido.';
        }
    }

    // si no hay errores creamos el libro segun el tipo seleccionado
    if ($errores === []) {
        try {
            $nuevoLibro = $textos['tipo'] === 'papel'
                ? new LibroPapel(
                    $textos['titulo'],
                    $textos['autor'],
                    $paginasEntero,
                    $textos['genero'],
                    $unidadesEntero,
                    $fechaAltaObj,
                    $destacadoBool,
                    $textos['observaciones']
                )
                : new LibroDigital(
                    $textos['titulo'],
                    $textos['autor'],
                    $paginasEntero,
                    $textos['genero'],
                    $unidadesEntero,
                    $fechaAltaObj,
                    $destacadoBool,
                    $textos['observaciones']
                );

            $servicio->agregar($nuevoLibro);

            $fechaTextoFicha = $nuevoLibro->getFechaAlta() !== null
                ? $nuevoLibro->getFechaAlta()->format('Y-m-d')
                : 'Sin fecha';

            $obsTextoFicha = $nuevoLibro->getObservaciones() !== ''
                ? $nuevoLibro->getObservaciones()
                : 'Sin observaciones';

            $ficha = [
                'titulo' => $nuevoLibro->getTitulo(),
                'autor' => $nuevoLibro->getAutor(),
                'tipo' => $nuevoLibro->getTipo() === 'papel' ? 'Papel' : 'Digital',
                'genero' => $nuevoLibro->getGenero(),
                'paginas' => $nuevoLibro->getPaginas(),
                'unidades' => $nuevoLibro->getUnidades(),
                'fecha' => $fechaTextoFicha,
                'destacado' => $nuevoLibro->getDestacado() ? 'Sí' : 'No',
                'observaciones' => $obsTextoFicha,
                'costeCentimos' => $nuevoLibro->costeReposicionCentimos(),
                'correo' => $textos['correo'],
            ];

            $filas = $servicio->filas($servicio->todos());
            $resumen = $servicio->resumen($servicio->todos());
        } catch (InvalidArgumentException $e) {
            $errores['general'] = $e->getMessage();
            $ficha = null;
        }
    }
}

require dirname(__DIR__) . '/vistas/alta.php';
