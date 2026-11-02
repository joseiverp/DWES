<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de la biblioteca</title>
</head>
<body>
    <h1>Catálogo de la biblioteca</h1>

    <form action="index.php" method="get">
        <p>
            <label for="q">Título o autor</label>
            <input type="text" id="q" name="q">
        </p>
        <p>
            <label for="genero">Género</label>
            <select id="genero" name="genero">
                <option value="">Todos</option>
                <option value="ciencia">Ciencia</option>
                <option value="fantasia">Fantasía</option>
                <option value="terror">Terror</option>
            </select>
        </p>
        <p>
            <label for="tipo">Tipo de libro</label>
            <select id="tipo" name="tipo">
                <option value="">Todos</option>
                <option value="papel">Papel</option>
                <option value="digital">Digital</option>
            </select>
        </p>
        <p>
            <label for="destacados">Solo destacados</label>
            <input type="checkbox" id="destacados" name="destacados" value="1">
        </p>
        <p>
            <button type="submit">Buscar</button>
        </p>
    </form>

    <p>
        <a href="alta.php">Dar de alta un libro</a>
        <a href="index.php">Catálogo inicial</a>
    </p>

    <table border="1">
        <thead>
            <tr>
                <th>Título</th>
                <th>Autor</th>
                <th>Género</th>
                <th>Tipo</th>
                <th>Páginas</th>
                <th>Unidades</th>
                <th>Coste de reposición</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($filas === []): ?>
                <tr>
                    <td colspan="7">No hay libros que coincidan</td>
                </tr>
            <?php else: ?>
                <?php foreach ($filas as $fila): ?>
                    <tr>
                        <td><?= htmlspecialchars($fila['titulo'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($fila['autor'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($fila['genero'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></td>
                        <td><?= $fila['tipo'] === 'papel' ? 'Papel' : 'Digital' ?></td>
                        <td><?= $fila['paginas'] ?></td>
                        <td><?= $fila['unidades'] ?></td>
                        <td><?= number_format($fila['costeCentimos'] / 100, 2, ',', '.') ?> €</td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <section>
        <h2>Resumen</h2>
        <p>Títulos: <?= $resumen['titulos'] ?></p>
        <p>Unidades: <?= $resumen['unidades'] ?></p>
        <p>Páginas: <?= $resumen['paginas'] ?></p>
        <p>Coste total: <?= number_format($resumen['costeCentimos'] / 100, 2, ',', '.') ?> €</p>
    </section>
</body>
</html>
