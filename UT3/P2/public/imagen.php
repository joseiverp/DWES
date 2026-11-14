<?php
require_once __DIR__ . '/../src/archivos.php';

$nombre = $_GET['nombre'] ?? null;
$mime = mimeCartel($nombre);

if ($mime === false) {
    http_response_code(404);
    exit;
}

header('Content-Type: ' . $mime);
header('X-Content-Type-Options: nosniff');
readfile(DIRECTORIO_CARTELES . '/' . $nombre);
exit;
