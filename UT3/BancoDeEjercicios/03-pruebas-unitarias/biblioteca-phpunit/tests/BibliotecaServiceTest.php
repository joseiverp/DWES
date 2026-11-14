<?php
declare(strict_types=1);

use App\Model\Libro;
use App\Repository\ArrayLibroRepository;
use App\Repository\LibroRepository;
use App\Service\BibliotecaService;
use PHPUnit\Framework\TestCase;

final class BibliotecaServiceTest extends TestCase
{
    public function testPrestarConElRepositorioReal(): void
    {
        $repositorio = new ArrayLibroRepository();
        $id = $repositorio->guardar(new Libro('Dune', 'Frank Herbert', 412));
        $servicio = new BibliotecaService($repositorio);

        $servicio->prestar($id);

        $this->assertFalse($repositorio->buscarPorId($id)->estaDisponible());
    }

    public function testPrestarUnIdAusenteConElRepositorioReal(): void
    {
        $servicio = new BibliotecaService(new ArrayLibroRepository());

        $this->expectException(OutOfBoundsException::class);
        $servicio->prestar(999);
    }

    public function testPrestarUnIdInexistenteConStub(): void
    {
        $repositorio = $this->createStub(LibroRepository::class);
        $repositorio->method('buscarPorId')->willReturn(null);
        $servicio = new BibliotecaService($repositorio);

        $this->expectException(OutOfBoundsException::class);
        $servicio->prestar(999);
    }

    public function testPrestarConsultaUnaVezElRepositorioConMock(): void
    {
        $libro = new Libro('Dune', 'Frank Herbert', 412);
        $repositorio = $this->createMock(LibroRepository::class);
        $repositorio->expects($this->once())
            ->method('buscarPorId')
            ->with(1)
            ->willReturn($libro);
        $servicio = new BibliotecaService($repositorio);

        $servicio->prestar(1);

        $this->assertFalse($libro->estaDisponible());
    }
}
