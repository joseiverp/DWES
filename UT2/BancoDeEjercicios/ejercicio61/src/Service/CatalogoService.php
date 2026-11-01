<?php

declare(strict_types=1);

namespace App\Service;

use App\Contract\LibroRepository;
use App\Model\Libro;
use InvalidArgumentException;

class CatalogoService
{
    public function __construct(
        private LibroRepository $repo
    ) {}

    public function prestarPorId(int $id): void
    {
        $libro = $this->repo->buscarPorId($id);
        if ($libro === null) {
            throw new InvalidArgumentException("Libro con ID $id no encontrado");
        }
        $libro->prestar();
    }

    public function devolverPorId(int $id): void
    {
        $libro = $this->repo->buscarPorId($id);
        if ($libro === null) {
            throw new InvalidArgumentException("Libro con ID $id no encontrado");
        }
        $libro->devolver();
    }

    /**
     * @return Libro[]
     */
    public function buscarDisponibles(string $texto, int $maximo): array
    {
        if ($maximo < 1) {
            throw new InvalidArgumentException("El máximo debe ser al menos 1");
        }

        $textoNorm = mb_strtolower(trim($texto), 'UTF-8');

        $filtrados = array_filter(
            $this->repo->todos(),
            function (Libro $l) use ($textoNorm, $maximo): bool {
                $condicionDispo = $l->estaDisponible();
                $condicionPaginas = $l->paginas() <= $maximo;
                $condicionTexto = $textoNorm === '' || str_contains(
                    mb_strtolower($l->titulo(), 'UTF-8'),
                    $textoNorm
                );

                return $condicionDispo && $condicionPaginas && $condicionTexto;
            }
        );

        $resultado = array_values($filtrados);

        usort($resultado, fn (Libro $a, Libro $b): int => $a->paginas() <=> $b->paginas());

        return $resultado;
    }
}
