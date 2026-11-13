<?php

declare(strict_types=1);

use App\Contrato\VideojuegoRepository;
use App\Modelo\Videojuego;
use App\Servicio\ConsultaVideojuego;
use PHPUnit\Framework\TestCase;

final class ConsultaVideojuegoTest extends TestCase
{
    // COMPLETAR 11. Videojuego ausente con un stub.
    public function testVideoJuegoAusente(): void {

        $repositorio = $this->createStub(VideojuegoRepository::class);
        
        $repositorio->method('buscarPorId')->willReturn(null);

        $servicio =  new ConsultaVideojuego($repositorio);
        $this->expectException(OutOfBoundsException::class);
        $servicio->obtener(99);
    }

    // COMPLETAR 12. Consulta única del identificador con un mock.
    public function testConsultaIdentificador(): void {

        $videojuego = new Videojuego('Islas de cristal', 'Nébula Studio', 35, 'aventura');
        $repositorio = $this->createMock(VideojuegoRepository::class);

        $repositorio->expects($this->once())
            ->method('buscarPorId')
            ->with(7)
            ->willReturn($videojuego);

        $servicio = new ConsultaVideojuego($repositorio);

        $resultado = $servicio->obtener(7);

        $this->assertSame($resultado, $videojuego);
    }

}
