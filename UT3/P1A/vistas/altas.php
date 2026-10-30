<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de alta</title>
</head>
<body>
    <form action="alta.php" method="post">
        <!-- Tipo de Libro -->

          <p><label for="tipo">Tipo de libro</label>
              <select name="tipo" id="tipo">
                    <option value="">Todos</option>
                    <option value="papel">Papel</option>
                    <option value="digital">Digital</option>
                </select>
        </p>

        <!-- Título -->
        <p>
            <label for="tipo">Tipo de libro</label>
            <input type="text" id="titulo" name="titulo">
        </p>
        <!-- Autor -->
        <p>
            <label for="autor">Autor</label>
            <input type="text" id="paginas" name="titulo">
        </p>

        <!-- Páginas -->
        <p>
            <label for="paginas">Paginas</label>
            <input type="text" id="titulo" name="titulo">
        </p>

        <!-- Género -->
         <p>
            <label for="genero">Género</label>

            <select name="genero" id="genero">
                <option value="">Todos</option>
                <option value="cienta">Ciencia</option>
                <option value="fantasia">Fantasia</option>
                <option value="terror">Terror</option>
            </select>
         </p>

     <!-- Solo destacados-->
        <p>
            <label for="destacados">Solo destacados</label>
            <input type="checkbox" value="1" id="destacados" name="titulo">
        </p>
        
        <!-- Observaciones -->
        <p>
            <textarea name="observaciones">Observaciones</textarea>
        </p>

        <!-- Correo -->
        <p>
            <label for="correo">Correo</label>
            <input type="text" value="1" id="correos nb">
        </p>
    </form>
</body>
</html>