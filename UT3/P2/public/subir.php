<?php 
    $metodo = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    $esPost = $metodo === 'POST';

    $errores = [];

    if ($esPost) {
        $archivo = $_FILES['imagen'] ?? null;

        $estructuraValida = is_array($archivo)
            && isset($archivo['error'], $archivo['size'], $archivo['tmp_name'])
            && is_int($archivo['error'])
            && is_int($archivo['size'])
            && is_string($archivo['tmp_name']);

        if ($archivo !== null && !$estructuraValida){
            $errores['imagen'] = 'Imagen no valida';
        }

    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir</title>
</head>
<body>
    
    <form action="subir.php" method="post" enctype="multipart/form-data">
         
        <label for="imagen">Imagen</label>
        <input type="file" name="imagen" id="imagen" accept="image/jpeg,image/png,image/webp">

        <button type="submit">Guardar</button>

    </form>

    <a href="index.php">Volver a la galería</a>
    
</body>
</html>