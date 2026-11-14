<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de la biblioteca</title>
</head>
<body>
    <h1>Catálogo de la biblioteca</h1>

    <form action="index.php" method="get">
        
        <label for="q">Título o autor</label>
        <input type="text" name="q" id="q" value="">

        <label for="genero">Género</label>
        <select name="genero" id="genero">
            <option value="">Todos</option>
            <option value="ciencia">Ciencia</option>
            <option value="fantasia">Fantasía</option>
            <option value="terror">Terror</option>
        </select>

        <label for="tipo">Tipo de libro</label>
        <select name="tipo" id="tipo">
            <option value="">Todos</option>
            <option value="papel">Papel</option>
            <option value="digital">Digital</option>
        </select>
        
        <label for="destacados">Solo destacados</label>
        <input type="checkbox" id="destacados" name="destacados" value="1">

        <button type="submit">Buscar</button>

    </form>

    <?php if(empty($filas)): ?>
        <?= "No hay libros que coincidan" ?>

    <?php else: ?>
            
        <table border=1>
            <thead>
                <tr>
                    <th>título</th>
                    <th>autor</th>
                    <th>género</th>
                    <th>tipo</th>
                    <th>páginas</th>
                    <th>unidades</th>
                    <th>coste de reposición</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($filas as $fila): ?>  
                    <tr>
                        <td><?= htmlspecialchars($fila['titulo'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')?></td>
                        <td><?= htmlspecialchars($fila['autor'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')?></td>
                        <td><?= htmlspecialchars($fila['genero'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')?></td>
                        <td><?= $fila['tipo'] === 'papel' ? 'Papel' : 'Digital'?></td>
                        <td><?= $fila['paginas'] ?></td>
                        <td><?= $fila['unidades'] ?></td>
                        <td><?= $fila['costeCentimos'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <h2>Resumen</h2>

    <p>Títulos: <?= $resumen['titulos']?></p>
    <p>Unidades: <?= $resumen['unidades']?></p>
    <p>Páginas: <?= $resumen['paginas'] ?></p>
    <p>Coste total: <?= number_format($resumen['costeCentimos'] / 100, 2, ',', '.')?> €</p>
        
    <a href="alta.php">Dar de alta</a>
    <br>
    <a href="index.php">Catálogo</a>
</body>
</html>