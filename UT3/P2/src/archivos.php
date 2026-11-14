<?php

const DIRECTORIO_CARTELES = __DIR__ . '/../storage/carteles';
const TAMANO_MAXIMO = 2 * 1024 * 1024;
const LIMITE_POST = 8 * 1024 * 1024;
const TIPOS_PERMITIDOS = [
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
    'image/webp' => 'webp',
];

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function tamanoValido(int $bytes): bool
{
    return $bytes >= 1 && $bytes <= TAMANO_MAXIMO;
}

function detectarMime(string $ruta): string|false
{
    if (!is_file($ruta) || !is_readable($ruta)) {
        return false;
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    return $finfo->file($ruta);
}

function nombreValido(mixed $nombre): bool
{
    return is_string($nombre)
        && preg_match('/\A[a-f0-9]{32}\.(jpg|png|webp)\z/', $nombre) === 1;
}

function mimeCartel(mixed $nombre): string|false
{
    if (!nombreValido($nombre)) {
        return false;
    }

    $mime = detectarMime(DIRECTORIO_CARTELES . '/' . $nombre);
    return $mime !== false && isset(TIPOS_PERMITIDOS[$mime]) ? $mime : false;
}

function cartelValido(mixed $nombre): bool
{
    return mimeCartel($nombre) !== false;
}

function listarCarteles(): array|false
{
    $rutas = glob(DIRECTORIO_CARTELES . '/*');
    if ($rutas === false) {
        return false;
    }

    $carteles = [];
    foreach ($rutas as $ruta) {
        $nombre = basename($ruta);
        if (cartelValido($nombre)) {
            $carteles[] = $nombre;
        }
    }
    return $carteles;
}

function mensajeErrorSubida(int $codigo): string
{
    return match ($codigo) {
        UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'La imagen supera el límite de recepción del servidor.',
        UPLOAD_ERR_PARTIAL => 'La imagen solo se ha recibido en parte. Vuelve a enviarla.',
        UPLOAD_ERR_CANT_WRITE => 'El servidor no ha podido escribir la imagen recibida.',
        default => 'Se ha producido un error al recibir la imagen.',
    };
}

function validarImagen(mixed $archivo): array
{
    if ($archivo === null) {
        return ['error' => null, 'extension' => null];
    }

    $estructuraValida = is_array($archivo)
        && isset($archivo['error'], $archivo['size'], $archivo['tmp_name'])
        && is_int($archivo['error'])
        && is_int($archivo['size'])
        && is_string($archivo['tmp_name']);

    if (!$estructuraValida) {
        return ['error' => 'La entrada recibida no es válida.', 'extension' => null];
    }

    if ($archivo['error'] === UPLOAD_ERR_NO_FILE) {
        return ['error' => null, 'extension' => null];
    }

    if ($archivo['error'] !== UPLOAD_ERR_OK) {
        return ['error' => mensajeErrorSubida($archivo['error']), 'extension' => null];
    }

    if (!tamanoValido($archivo['size'])) {
        return ['error' => 'La imagen debe ocupar entre 1 byte y 2 MiB.', 'extension' => null];
    }

    if (!is_file($archivo['tmp_name']) || !is_readable($archivo['tmp_name'])) {
        return ['error' => 'No se ha podido leer la imagen recibida.', 'extension' => null];
    }

    $mime = detectarMime($archivo['tmp_name']);
    if ($mime === false || !isset(TIPOS_PERMITIDOS[$mime])) {
        return ['error' => 'Formato no permitido. Sube una imagen JPEG, PNG o WebP.', 'extension' => null];
    }

    return ['error' => null, 'extension' => TIPOS_PERMITIDOS[$mime]];
}

function guardarImagen(string $tmp, string $extension): array
{
    try {
        $nombre = bin2hex(random_bytes(16)) . '.' . $extension;
    } catch (Random\RandomException) {
        return ['error' => 'No se ha podido preparar el archivo.', 'nombre' => null];
    }

    if (!is_dir(DIRECTORIO_CARTELES) || !is_writable(DIRECTORIO_CARTELES)) {
        return ['error' => 'El almacenamiento no está disponible.', 'nombre' => null];
    }

    $destino = DIRECTORIO_CARTELES . '/' . $nombre;
    if (file_exists($destino)) {
        return ['error' => 'No se ha podido generar un nombre libre. Vuelve a enviar la imagen.', 'nombre' => null];
    }

    if (!move_uploaded_file($tmp, $destino)) {
        return ['error' => 'No se ha podido guardar la imagen.', 'nombre' => null];
    }

    return ['error' => null, 'nombre' => $nombre];
}

function eliminarCartel(string $nombre): bool
{
    $ruta = DIRECTORIO_CARTELES . '/' . $nombre;
    return nombreValido($nombre) && is_file($ruta) && unlink($ruta);
}

function sustituirCartel(string $tmp, string $extension, string $anterior): array
{
    $guardado = guardarImagen($tmp, $extension);
    if ($guardado['error'] !== null) {
        return $guardado;
    }

    $nuevo = $guardado['nombre'];
    if (eliminarCartel($anterior)) {
        return ['error' => null, 'nombre' => $nuevo];
    }

    if (eliminarCartel($nuevo)) {
        return ['error' => 'No se ha podido retirar el cartel anterior. Se mantiene el cartel actual y se ha descartado la imagen nueva.', 'nombre' => null];
    }

    error_log('No se ha podido eliminar el cartel nuevo ' . $nuevo . ' tras fallar la sustitución.');
    return ['error' => 'No se ha podido completar la sustitución. El cartel anterior se mantiene.', 'nombre' => null];
}
