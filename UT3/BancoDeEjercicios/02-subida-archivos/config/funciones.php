<?php

const TAMANO_MAXIMO = 2 * 1024 * 1024;
const MIMES_PERMITIDOS = [
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
    'image/webp' => 'webp',
];
const PATRON_NOMBRE = '/\A[a-f0-9]{32}\.(jpg|png|webp)\z/';

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function directorioPortadas(): string
{
    return __DIR__ . '/../storage/portadas';
}

function estructuraValida(mixed $archivo): bool
{
    return is_array($archivo)
        && isset($archivo['error'], $archivo['size'], $archivo['tmp_name'])
        && is_int($archivo['error'])
        && is_int($archivo['size'])
        && is_string($archivo['tmp_name']);
}

function errorRecepcion(int $codigo): string
{
    return match ($codigo) {
        UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE => 'La portada supera el tamaño que admite el servidor.',
        UPLOAD_ERR_PARTIAL => 'La portada solo se recibió en parte. Vuelve a enviarla.',
        default => 'No se pudo recibir la portada.',
    };
}

function recibirPortada(array $files, string $campo = 'portada'): array
{
    if (!array_key_exists($campo, $files)) {
        return ['estado' => 'ausente', 'error' => null];
    }

    $archivo = $files[$campo];

    if (!estructuraValida($archivo)) {
        return ['estado' => 'error', 'error' => 'La portada no tiene la estructura esperada.'];
    }

    if ($archivo['error'] === UPLOAD_ERR_NO_FILE) {
        return ['estado' => 'sin-archivo', 'error' => null];
    }

    if ($archivo['error'] !== UPLOAD_ERR_OK) {
        return ['estado' => 'error', 'error' => errorRecepcion($archivo['error'])];
    }

    return ['estado' => 'ok', 'error' => null];
}

function tamanoValido(int $tamano): bool
{
    return $tamano >= 1 && $tamano <= TAMANO_MAXIMO;
}

function detectarMime(string $ruta): string|false
{
    return is_file($ruta) ? (new finfo(FILEINFO_MIME_TYPE))->file($ruta) : false;
}

function comprobarArchivo(int $tamano, string $tmp): array
{
    if (!tamanoValido($tamano)) {
        return ['error' => 'La portada debe ocupar entre 1 byte y 2 MiB.', 'extension' => null];
    }

    $mime = detectarMime($tmp);

    if ($mime === false) {
        return ['error' => 'No se pudo comprobar el formato de la portada.', 'extension' => null];
    }

    if (!isset(MIMES_PERMITIDOS[$mime])) {
        return ['error' => 'La portada debe ser una imagen JPEG, PNG o WebP.', 'extension' => null];
    }

    return ['error' => null, 'extension' => MIMES_PERMITIDOS[$mime]];
}

function comprobarPortada(array $files, string $campo = 'portada'): array
{
    $recepcion = recibirPortada($files, $campo);

    if ($recepcion['estado'] !== 'ok') {
        return ['error' => $recepcion['error'], 'tmp' => null, 'extension' => null];
    }

    $archivo = $files[$campo];
    $comprobacion = comprobarArchivo($archivo['size'], $archivo['tmp_name']);

    return [
        'error' => $comprobacion['error'],
        'tmp' => $archivo['tmp_name'],
        'extension' => $comprobacion['extension'],
    ];
}

function generarNombre(string $extension): ?string
{
    try {
        return bin2hex(random_bytes(16)) . '.' . $extension;
    } catch (Random\RandomException) {
        return null;
    }
}

function prepararDestino(string $extension, ?string $directorio = null): array
{
    $directorio = $directorio ?? directorioPortadas();
    $nombre = generarNombre($extension);

    if ($nombre === null) {
        return ['error' => 'No se pudo preparar el archivo.', 'nombre' => null, 'ruta' => null];
    }

    if (!is_dir($directorio) || !is_writable($directorio)) {
        return ['error' => 'Almacenamiento no disponible.', 'nombre' => null, 'ruta' => null];
    }

    $ruta = $directorio . '/' . $nombre;

    if (file_exists($ruta)) {
        return ['error' => 'Nombre ocupado; vuelve a enviar.', 'nombre' => null, 'ruta' => null];
    }

    return ['error' => null, 'nombre' => $nombre, 'ruta' => $ruta];
}

function retirarPortada(string $nombre): bool
{
    if (preg_match(PATRON_NOMBRE, $nombre) !== 1) {
        error_log('Se intentó retirar una portada con un nombre no válido.');
        return false;
    }

    $ruta = directorioPortadas() . '/' . $nombre;

    if (!is_file($ruta)) {
        return true;
    }

    if (!unlink($ruta)) {
        error_log('No se pudo eliminar la portada ' . $nombre);
        return false;
    }

    return true;
}

function portadasGuardadas(): array
{
    $nombres = [];

    foreach (scandir(directorioPortadas()) as $archivo) {
        if (preg_match(PATRON_NOMBRE, $archivo) === 1) {
            $nombres[] = $archivo;
        }
    }

    return $nombres;
}

function leerFicha(array $entrada): array
{
    $valores = ['titulo' => '', 'paginas' => ''];
    $errores = [];
    $paginas = null;

    foreach (array_keys($valores) as $campo) {
        $dato = $entrada[$campo] ?? '';

        if (is_string($dato)) {
            $valores[$campo] = trim($dato);
        } else {
            $errores[$campo] = 'Debe ser texto.';
        }
    }

    if (!isset($errores['titulo'])) {
        if ($valores['titulo'] === '') {
            $errores['titulo'] = 'Escribe el título.';
        } elseif (mb_strlen($valores['titulo'], 'UTF-8') > 120) {
            $errores['titulo'] = 'El título no puede superar los 120 caracteres.';
        }
    }

    if (!isset($errores['paginas'])) {
        $numero = filter_var($valores['paginas'], FILTER_VALIDATE_INT);

        if ($numero === false || $numero < 1 || $numero > 3000) {
            $errores['paginas'] = 'Entre 1 y 3000 páginas.';
        } else {
            $paginas = $numero;
        }
    }

    return ['valores' => $valores, 'errores' => $errores, 'paginas' => $paginas];
}
