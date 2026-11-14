<?php
require_once __DIR__ . '/../config/funciones.php';

$nombre = $_GET['nombre'] ?? '';

if (!is_string($nombre) || preg_match(PATRON_NOMBRE, $nombre) !== 1) {
    http_response_code(404);
    exit;
}

$ruta = directorioPortadas() . '/' . $nombre;
$mime = detectarMime($ruta);

if ($mime === false || !isset(MIMES_PERMITIDOS[$mime])) {
    http_response_code(404);
    exit;
}

header('Content-Type: ' . $mime);
header('X-Content-Type-Options: nosniff');
readfile($ruta);
exit;
