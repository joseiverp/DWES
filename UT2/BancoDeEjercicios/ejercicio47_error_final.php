<?php

declare(strict_types=1);

require_once __DIR__ . '/ejercicio47.php';

class RecursoInvalido extends RecursoBiblioteca
{
    public function tipo(): string
    {
        return 'invalido';
    }

    public function origen(): string
    {
        return 'Otro Origen';
    }
}
