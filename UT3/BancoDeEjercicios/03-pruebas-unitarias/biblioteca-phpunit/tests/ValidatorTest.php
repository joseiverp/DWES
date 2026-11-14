<?php
declare(strict_types=1);

use App\Service\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class ValidatorTest extends TestCase
{
    public static function titulosVacios(): array
    {
        return [
            'cadena vacía' => [''],
            'espacios' => ['   '],
            'tabulación' => ["\t"],
        ];
    }

    #[DataProvider('titulosVacios')]
    public function testTituloRequerido(string $valor): void
    {
        $validator = new Validator();

        $resultado = $validator->requerido($valor, 'Escribe el título.');

        $this->assertSame('Escribe el título.', $resultado);
    }

    public function testTituloConTextoDevuelveNull(): void
    {
        $validator = new Validator();

        $this->assertNull($validator->requerido('Dune', 'Escribe el título.'));
    }
}
