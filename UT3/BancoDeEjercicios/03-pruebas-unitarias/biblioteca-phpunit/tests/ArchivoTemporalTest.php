<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class ArchivoTemporalTest extends TestCase
{
    private ?string $ruta = null;

    protected function tearDown(): void
    {
        if ($this->ruta !== null && file_exists($this->ruta)) {
            unlink($this->ruta);
        }

        if ($this->ruta !== null) {
            $this->assertFileDoesNotExist($this->ruta);
        }
    }

    public function testEscribeYLeeUnArchivoTemporal(): void
    {
        $ruta = tempnam(sys_get_temp_dir(), 'ut3');
        $this->assertIsString($ruta);
        $this->ruta = $ruta;

        file_put_contents($this->ruta, 'Dune');

        $this->assertSame('Dune', file_get_contents($this->ruta));
    }
}
