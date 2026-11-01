<?php

declare(strict_types=1);

namespace Jose\Biblioteca\Modelo;

class LibroDigital extends Libro
{
    public function getTipo(): string
    {
        return 'digital';
    }

    public function costeReposicionCentimos(): int
    {
        // 400 centimos fijos por cada licencia
        return 400 * $this->getUnidades();
    }
}
