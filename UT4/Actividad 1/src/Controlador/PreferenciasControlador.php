<?php 
declare(strict_types=1);

namespace App\Controlador;

use App\Controlador\Controlador;

use function App\Soporte\redirigir;

final class PreferenciasControlador extends Controlador {

    public function guardar(): void {
        $tema = $_POST['tema'] ?? null;

        if (in_array($tema, ['claro', 'oscuro'], true)) {
            // Guardar la cookie
            $this->guardarCookie('tema', $tema);
            redirigir('index.php');
        }
        http_response_code(400);
        exit;
    }

    public function guardarCookie(string $cookie, string $valor): void {

        setcookie('tema', 'oscuro', [
            'expires' => time() + 60 * 60 * 24 * 30,
            'path' => '/',
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Lax',
        ]);

    }
}