<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alta de libro</title>
</head>
<body>
    <h1>Alta de libro</h1>

    <?php if ($ficha === null): ?>
        <?php if (isset($errores['general'])): ?>
            <p><?= htmlspecialchars($errores['general'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p>
        <?php endif; ?>

        <form action="alta.php" method="post">
            <p>
                <label for="tipo">Tipo</label>
                <select id="tipo" name="tipo">
                    <option value="">Selecciona un tipo</option>
                    <option value="papel" <?= $valores['tipo'] === 'papel' ? 'selected' : '' ?>>Papel</option>
                    <option value="digital" <?= $valores['tipo'] === 'digital' ? 'selected' : '' ?>>Digital</option>
                </select>
                <?php if (isset($errores['tipo'])): ?>
                    <span><?= htmlspecialchars($errores['tipo'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></span>
                <?php endif; ?>
            </p>

            <p>
                <label for="titulo">Título</label>
                <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($valores['titulo'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
                <?php if (isset($errores['titulo'])): ?>
                    <span><?= htmlspecialchars($errores['titulo'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></span>
                <?php endif; ?>
            </p>

            <p>
                <label for="autor">Autor</label>
                <input type="text" id="autor" name="autor" value="<?= htmlspecialchars($valores['autor'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
                <?php if (isset($errores['autor'])): ?>
                    <span><?= htmlspecialchars($errores['autor'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></span>
                <?php endif; ?>
            </p>

            <p>
                <label for="paginas">Páginas</label>
                <input type="text" id="paginas" name="paginas" value="<?= htmlspecialchars($valores['paginas'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
                <?php if (isset($errores['paginas'])): ?>
                    <span><?= htmlspecialchars($errores['paginas'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></span>
                <?php endif; ?>
            </p>

            <p>
                <label for="genero">Género</label>
                <select id="genero" name="genero">
                    <option value="">Selecciona un género</option>
                    <option value="ciencia" <?= $valores['genero'] === 'ciencia' ? 'selected' : '' ?>>Ciencia</option>
                    <option value="fantasia" <?= $valores['genero'] === 'fantasia' ? 'selected' : '' ?>>Fantasía</option>
                    <option value="terror" <?= $valores['genero'] === 'terror' ? 'selected' : '' ?>>Terror</option>
                </select>
                <?php if (isset($errores['genero'])): ?>
                    <span><?= htmlspecialchars($errores['genero'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></span>
                <?php endif; ?>
            </p>

            <p>
                <label for="unidades">Ejemplares o licencias</label>
                <input type="text" id="unidades" name="unidades" value="<?= htmlspecialchars($valores['unidades'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
                <?php if (isset($errores['unidades'])): ?>
                    <span><?= htmlspecialchars($errores['unidades'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></span>
                <?php endif; ?>
            </p>

            <p>
                <label for="fechaAlta">Fecha de alta (YYYY-MM-DD)</label>
                <input type="text" id="fechaAlta" name="fechaAlta" value="<?= htmlspecialchars($valores['fechaAlta'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
                <?php if (isset($errores['fechaAlta'])): ?>
                    <span><?= htmlspecialchars($errores['fechaAlta'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></span>
                <?php endif; ?>
            </p>

            <p>
                <label for="destacado">Destacado</label>
                <input type="checkbox" id="destacado" name="destacado" value="1" <?= $valores['destacado'] ? 'checked' : '' ?>>
                <?php if (isset($errores['destacado'])): ?>
                    <span><?= htmlspecialchars($errores['destacado'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></span>
                <?php endif; ?>
            </p>

            <p>
                <label for="observaciones">Observaciones</label>
                <textarea id="observaciones" name="observaciones"><?= htmlspecialchars($valores['observaciones'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></textarea>
                <?php if (isset($errores['observaciones'])): ?>
                    <span><?= htmlspecialchars($errores['observaciones'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></span>
                <?php endif; ?>
            </p>

            <p>
                <label for="correo">Correo</label>
                <input type="text" id="correo" name="correo" value="<?= htmlspecialchars($valores['correo'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?>">
                <?php if (isset($errores['correo'])): ?>
                    <span><?= htmlspecialchars($errores['correo'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></span>
                <?php endif; ?>
            </p>

            <p>
                <button type="submit">Dar de alta</button>
            </p>
        </form>

        <p>
            <a href="index.php">Volver al catálogo</a>
        </p>

    <?php else: ?>
        <section>
            <h2>Confirmación de alta</h2>
            <p>El libro se ha registrado correctamente.</p>
            <p>Registrado por: <?= htmlspecialchars($ficha['correo'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></p>

            <h3>Ficha del libro</h3>
            <ul>
                <li>Título: <?= htmlspecialchars($ficha['titulo'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></li>
                <li>Autor: <?= htmlspecialchars($ficha['autor'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></li>
                <li>Tipo: <?= htmlspecialchars($ficha['tipo'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></li>
                <li>Género: <?= htmlspecialchars($ficha['genero'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></li>
                <li>Páginas: <?= $ficha['paginas'] ?></li>
                <li>Unidades: <?= $ficha['unidades'] ?></li>
                <li>Fecha: <?= htmlspecialchars($ficha['fecha'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></li>
                <li>Destacado: <?= htmlspecialchars($ficha['destacado'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></li>
                <li>Observaciones: <?= htmlspecialchars($ficha['observaciones'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') ?></li>
                <li>Coste: <?= number_format($ficha['costeCentimos'] / 100, 2, ',', '.') ?> €</li>
            </ul>

            <h3>Catálogo de la biblioteca</h3>
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
                </tbody>
            </table>

            <section>
                <h4>Resumen</h4>
                <p>Títulos: <?= $resumen['titulos'] ?></p>
                <p>Unidades: <?= $resumen['unidades'] ?></p>
                <p>Páginas: <?= $resumen['paginas'] ?></p>
                <p>Coste total: <?= number_format($resumen['costeCentimos'] / 100, 2, ',', '.') ?> €</p>
            </section>

            <p>
                <a href="index.php">Volver al catálogo</a>
            </p>
        </section>
    <?php endif; ?>
</body>
</html>
