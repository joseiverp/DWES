<?php
require_once __DIR__ . '/../config/funciones.php';

function crearPortadaDePrueba(): ?string
{
    $nombre = generarNombre('png');

    if ($nombre === null) {
        return null;
    }

    $copiada = copy(__DIR__ . '/../muestras/portada-a.png', directorioPortadas() . '/' . $nombre);

    return $copiada ? $nombre : null;
}

$esPost = $_SERVER['REQUEST_METHOD'] === 'POST';
$errores = [];
$mensajes = [];
$portadaActual = null;
$portadaAnterior = null;

if ($esPost) {
    $portadaActual = crearPortadaDePrueba();
    $portadaAnterior = $portadaActual;
    $otrasFichas = ($_POST['otraFicha'] ?? '') === '1' ? [$portadaAnterior] : [];
    $simularFallo = ($_POST['simularFallo'] ?? '') === '1';
    $ficha = ['titulo' => 'Dune', 'portada' => $portadaActual];

    $portada = comprobarPortada($_FILES);

    if ($portadaActual === null) {
        $errores['portada'] = 'No se pudo preparar la portada anterior A.';
    } elseif ($portada['error'] !== null) {
        $errores['portada'] = $portada['error'];
        $mensajes[] = 'B no es válida: se conserva A.';
    } elseif ($portada['extension'] === null) {
        $mensajes[] = 'No ha llegado una nueva portada: se conserva A.';
    } else {
        $destino = prepararDestino($portada['extension']);

        if ($destino['error'] !== null) {
            $errores['portada'] = $destino['error'];
        } elseif (!move_uploaded_file($portada['tmp'], $destino['ruta'])) {
            $errores['portada'] = 'No se pudo guardar la portada.';
        } else {
            $portadaActual = $destino['nombre'];

            try {
                if ($simularFallo) {
                    throw new RuntimeException('Fallo simulado al confirmar el cambio de portada.');
                }

                $ficha['portada'] = $portadaActual;
                $mensajes[] = 'Cambio confirmado: la ficha usa B.';

                if (in_array($portadaAnterior, $otrasFichas, true)) {
                    $mensajes[] = 'A no se elimina porque la usa otra ficha.';
                } elseif (retirarPortada($portadaAnterior)) {
                    $mensajes[] = 'A eliminada del directorio.';
                } else {
                    $mensajes[] = 'No se pudo eliminar A; el problema queda registrado.';
                }
            } catch (RuntimeException $excepcion) {
                error_log($excepcion->getMessage());
                $portadaActual = $portadaAnterior;
                retirarPortada($destino['nombre']);
                $errores['portada'] = 'No se pudo guardar el cambio. Se mantiene la portada anterior.';
            }
        }
    }
}

$archivos = portadasGuardadas();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejercicio 19 - Sustituir una portada</title>
</head>
<body>
    <h1>Sustituir la portada A por B</h1>

    <p>Cada envío crea primero una portada A nueva y después intenta sustituirla por la imagen B que envíes.</p>

    <form method="post" action="ej19.php" enctype="multipart/form-data">
        <p>
            <label for="portada">Nueva portada B</label>
            <input id="portada" name="portada" type="file" accept="image/jpeg,image/png,image/webp">
        </p>
        <p>
            <label>
                <input type="checkbox" name="simularFallo" value="1">
                Provocar RuntimeException antes de confirmar el cambio
            </label>
        </p>
        <p>
            <label>
                <input type="checkbox" name="otraFicha" value="1">
                Otra ficha también usa A
            </label>
        </p>
        <button type="submit">Sustituir</button>
    </form>

    <?php if ($esPost): ?>
        <h2>Resultado</h2>
        <p>A: <?= e((string) $portadaAnterior) ?></p>
        <p>$portadaActual: <?= e((string) $portadaActual) ?></p>
        <?php foreach ($mensajes as $mensaje): ?>
            <p><?= e($mensaje) ?></p>
        <?php endforeach; ?>
        <?php if (isset($errores['portada'])): ?>
            <p>Error: <?= e($errores['portada']) ?></p>
        <?php endif; ?>
    <?php endif; ?>

    <h2>Archivos en storage/portadas</h2>
    <ul>
        <?php foreach ($archivos as $archivo): ?>
            <li>
                <?= e($archivo) ?>
                <?= $archivo === $portadaActual ? '(portada actual)' : '' ?>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
