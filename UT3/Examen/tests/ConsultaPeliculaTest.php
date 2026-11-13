<?php

declare(strict_types=1);

use App\Contrato\PeliculaRepository;
use App\Modelo\Pelicula;
use App\Servicio\ConsultaPelicula;
use PHPUnit\Framework\TestCase;

final class ConsultaPeliculaTest extends TestCase
{
    // COMPLETAR 11. Película ausente con un stub.
    public function peliculaAusente(){
        $repositorio = $this->createStub(PeliculaRepository::class);
        $repositorio->method('buscarPorId')->willReturn(null);

        
    }

    // COMPLETAR 12. Consulta única del identificador con un mock.

}
