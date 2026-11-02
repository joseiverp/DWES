<?php

declare(strict_types=1);

namespace Jose\Biblioteca\Modelo;

class LibroPapel extends Libro
{
    public function getTipo(): string
    {
        return 'papel';
    }

    public function costeReposicionCentimos(): int
    {
        // 5 centimos por pagina y por cada ejemplar
        return $this->getPaginas() * 5 * $this->getUnidades();
    }
}
