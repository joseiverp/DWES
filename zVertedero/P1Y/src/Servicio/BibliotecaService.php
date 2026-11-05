<?php
declare(strict_types=1);

namespace Jose\Biblioteca\Servicio;
use Jose\Biblioteca\Modelo\Libro;
class BibliotecaService {
    public function __construct(private array $libros){}

    public function todos(): array {
        return $this->libros;
    }
    public function agregar(Libro $libro): void {
        $this->libros[] = $libro;
    }
    public function filtrar(
     string $q, string $genero, string $tipo,
     bool $soloDestacados
    ): array {
        $filtrados = array_filter(
            $this->libros
        )
    }
    public function filas(array $libros): array {
     throw new \LogicException('Método sin implementar.');
    }
    public function resumen(array $libros): array {
     throw new \LogicException('Método sin implementar.');
    }
}