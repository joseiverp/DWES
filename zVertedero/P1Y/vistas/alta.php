<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta</title>
</head>
<body>
    <h1>Dar de alta</h1>

    <form action="alta.php" method="post">

        <label for="tipo">Tipo</label>
        <select name="tipo" id="tipo">
            <option value=""></option>
            <option value="papel">papel</option>
            <option value="digital">digital</option>
        </select>

        <label for="titulo">Título</label>
        <input type="text" name="titulo" maxlength="120" id="titulo" required >

        <label for="autor">Autor</label>
        <input type="text" name="autor" id="autor" maxlength="100" required>

        <label for="paginas">Páginas</label>
        <input type="text" name="paginas" id="paginas">

        <label for="genero">Género</label>
        <select name="genero" id="genero">
            <option value=""></option>
            <option value="ciencia">ciencia</option>
            <option value="fantasia">fantasia</option>
            <option value="terror">terror</option>
        </select>

        <label for="unidades">Ejemplarres o licencias</label>
        <input type="text" name="unidades" id="unidades">

        <label for="fechaAlta">Fecha de alta</label>
        <input type="text" name="fechaAlta" id="fechaAlta" placeholder="YYYY-MM-DD">

        <label for="destacado">Destacado</label>
        <input type="checkbox" value="1" name="destacado" id="destacado">

        <label for="observaciones">Observaciones</label>
        <textarea name="observaciones" id="observaciones" maxlength="300"></textarea>

        <label for="correo">Correo</label>
        <input type="text" id="correo" name="correo" required>

        <button type="submit">Dar de alta</button>

    </form>

    <a href="index.php">Volver al catálogo</a>
</body>
</html>