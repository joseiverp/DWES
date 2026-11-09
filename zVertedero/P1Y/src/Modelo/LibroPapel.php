<?php
declare(strict_types=1);

namespace Jose\Biblioteca\Modelo;

use Override;

class LibroPapel extends Libro
{

    public function getTipo(): string {
        return 'papel';
    }
    
    #[Override]
    public function costeReposicionCentimos(): int
    {
        return $this->getPaginas() * 5 * $this->getUnidades();
    }
}