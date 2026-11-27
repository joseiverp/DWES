<h2>Iniciar sesión</h2>
<?php if ($error !== null): ?>
    <p><?= \App\Soporte\e($error) ?></p>
<?php endif; ?>

<form method="post">
    <label for="email">Correo</label>
    <input type="email" name="email" id="email" required>

    <label for="clave">Contraseña</label>
    <input type="password" name="clave" id="clave" required>

    <button>Iniciar sesión</button>
</form>
