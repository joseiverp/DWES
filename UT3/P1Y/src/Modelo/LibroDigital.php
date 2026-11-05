<?php
declare(strict_types=1);

namespace Jose\Biblioteca\Modelo;

use Override;

class LibroDigital extends Libro
{

    public function getTipo(): string {
        return 'digital';
    }
    
    #[Override]
    public function costeReposicionCentimos(): int
    {
        return 400 * $this->getUnidades();
    }
}