<?php
declare(strict_types=1);

use App\Model\Libro;
use App\Model\LibroNoDisponibleException;
use PHPUnit\Framework\TestCase;

final class LibroTest extends TestCase
{
    private Libro $libro;

    protected function setUp(): void
    {
        $this->libro = new Libro('Dune', 'Frank Herbert', 412);
    }

    public function testConservaTitulo(): void
    {
        $this->assertSame('Dune', $this->libro->titulo());
    }

    public function testPaginasDevuelveUnEntero(): void
    {
        $this->assertSame(412, $this->libro->paginas());
    }

    public function testAssertEqualsNoComparaElTipo(): void
    {
        $this->assertEquals(412, '412');
        $this->assertNotSame(412, '412');
    }

    public function testEstaDisponibleAlCrearlo(): void
    {
        $this->assertTrue($this->libro->estaDisponible());
    }

    public function testDejaDeEstarDisponibleAlPrestarlo(): void
    {
        $this->libro->prestar();

        $this->assertFalse($this->libro->estaDisponible());
    }

    public function testSegundoPrestamoLanzaExcepcion(): void
    {
        $this->libro->prestar();

        $this->expectException(LibroNoDisponibleException::class);
        $this->libro->prestar();
    }

    public function testTituloVacioLanzaExcepcion(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Libro('', 'Frank Herbert', 412);
    }

    public function testPaginasNegativasLanzaExcepcion(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Libro('Dune', 'Frank Herbert', -5);
    }
}
