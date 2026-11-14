<?php
declare(strict_types=1);

use App\Service\PortadaValidator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class PortadaValidatorTest extends TestCase
{
    public static function casosPortada(): array
    {
        return [
            '1 byte' => [1, 'image/jpeg', true],
            '2 MiB' => [2 * 1024 * 1024, 'image/jpeg', true],
            '2 MiB + 1' => [2 * 1024 * 1024 + 1, 'image/jpeg', false],
            'image/png' => [1024, 'image/png', true],
            'text/plain' => [1024, 'text/plain', false],
        ];
    }

    #[DataProvider('casosPortada')]
    public function testValidaTamanoYFormato(int $tamano, string $mime, bool $aceptada): void
    {
        $validator = new PortadaValidator();

        $resultado = $validator->validar($tamano, $mime);

        if ($aceptada) {
            $this->assertNull($resultado);
        } else {
            $this->assertIsString($resultado);
        }
    }
}
