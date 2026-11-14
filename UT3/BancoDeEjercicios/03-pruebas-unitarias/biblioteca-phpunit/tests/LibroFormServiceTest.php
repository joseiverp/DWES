<?php
declare(strict_types=1);

use App\Service\LibroFormService;
use App\Service\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class LibroFormServiceTest extends TestCase
{
    private LibroFormService $servicio;

    protected function setUp(): void
    {
        $this->servicio = new LibroFormService(new Validator());
    }

    private function entradaValida(): array
    {
        return [
            'titulo' => 'Dune',
            'autor' => 'Frank Herbert',
            'paginas' => '412',
            'genero' => 'ciencia',
            'fechaAlta' => '',
        ];
    }

    public static function casosPaginas(): array
    {
        return [
            'mínimo' => ['1', true],
            'máximo' => ['3000', true],
            'cero' => ['0', false],
            'por encima del máximo' => ['3001', false],
            'con letras' => ['12abc', false],
            'decimal' => ['12.5', false],
            'array' => [['412'], false],
        ];
    }

    #[DataProvider('casosPaginas')]
    public function testValidaPaginas(mixed $paginas, bool $aceptada): void
    {
        $entrada = $this->entradaValida();
        $entrada['paginas'] = $paginas;

        $resultado = $this->servicio->procesar($entrada);

        if ($aceptada) {
            $this->assertArrayNotHasKey('paginas', $resultado['errores']);
            $this->assertSame((int) $paginas, $resultado['datos']['paginas']);
        } else {
            $this->assertArrayHasKey('paginas', $resultado['errores']);
            $this->assertNull($resultado['datos']);
        }
    }

    public function testProcesaUnaFichaValida(): void
    {
        $entrada = $this->entradaValida();
        $entrada['titulo'] = ' Dune ';

        $resultado = $this->servicio->procesar($entrada);

        $this->assertSame([], $resultado['errores']);
        $this->assertSame('Dune', $resultado['valores']['titulo']);
        $this->assertSame('412', $resultado['valores']['paginas']);
        $this->assertSame('Dune', $resultado['datos']['titulo']);
        $this->assertSame(412, $resultado['datos']['paginas']);
        $this->assertNull($resultado['datos']['fechaAlta']);
    }

    public function testFechaValidaCreaUnDateTimeImmutable(): void
    {
        $entrada = $this->entradaValida();
        $entrada['fechaAlta'] = '2026-10-24';

        $resultado = $this->servicio->procesar($entrada);

        $this->assertInstanceOf(DateTimeImmutable::class, $resultado['datos']['fechaAlta']);
        $this->assertSame('2026-10-24', $resultado['datos']['fechaAlta']->format('Y-m-d'));
    }

    public function testFechaImposibleSeRechaza(): void
    {
        $entrada = $this->entradaValida();
        $entrada['fechaAlta'] = '2026-02-31';

        $resultado = $this->servicio->procesar($entrada);

        $this->assertArrayHasKey('fechaAlta', $resultado['errores']);
        $this->assertNull($resultado['datos']);
    }

    public function testTituloDe120CaracteresSeAcepta(): void
    {
        $entrada = $this->entradaValida();
        $entrada['titulo'] = str_repeat('á', 120);

        $resultado = $this->servicio->procesar($entrada);

        $this->assertArrayNotHasKey('titulo', $resultado['errores']);
        $this->assertNotNull($resultado['datos']);
    }

    public function testTituloDe121CaracteresSeRechaza(): void
    {
        $entrada = $this->entradaValida();
        $entrada['titulo'] = str_repeat('á', 121);

        $resultado = $this->servicio->procesar($entrada);

        $this->assertArrayHasKey('titulo', $resultado['errores']);
        $this->assertNull($resultado['datos']);
    }

    public function testTituloComoArrayConservaElMensajeDeTipo(): void
    {
        $entrada = $this->entradaValida();
        $entrada['titulo'] = ['Dune'];

        $resultado = $this->servicio->procesar($entrada);

        $this->assertSame('Debe ser texto.', $resultado['errores']['titulo']);
        $this->assertSame('', $resultado['valores']['titulo']);
    }

    public function testGeneroNoPermitidoSeRechaza(): void
    {
        $entrada = $this->entradaValida();
        $entrada['genero'] = 'aventura';

        $resultado = $this->servicio->procesar($entrada);

        $this->assertArrayHasKey('genero', $resultado['errores']);
        $this->assertNull($resultado['datos']);
    }
}
