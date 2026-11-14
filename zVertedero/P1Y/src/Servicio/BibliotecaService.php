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

        $qNormalizado = mb_strtolower(trim($q), 'UTF-8');
        
        $filtrados = array_filter(
            $this->todos(),
            fn(Libro $libro) :bool => 
                ($qNormalizado === '' ||
                str_contains(mb_strtolower($libro->getTitulo(), 'UTF-8'), $qNormalizado) ||
                str_contains(mb_strtolower($libro->getAutor(), 'UTF-8'), $qNormalizado)) 
                &&
                ($genero === '' || $genero === $libro->getGenero())
                &&
                ($tipo === '' || $tipo === $libro->getTipo())
                &&
                ($soloDestacados === false || $libro->isDestacado())        
        );

        return array_values($filtrados);

    }
    public function filas(array $libros): array {

        return array_map(
            fn (Libro $libro): array => [
                    "titulo" => $libro->getTitulo(),
                    "autor" => $libro->getAutor(),
                    "paginas" => $libro->getPaginas(),
                    "genero" => $libro->getGenero(),
                    "tipo" => $libro->getTipo(),
                    "unidades" => $libro->getUnidades(),
                    "fechaAlta" => $libro->getFechaAlta() !== null ?  $libro->getFechaAlta()->format('Y-m-d') : 'Sin fecha',
                    "destacado" => $libro->isDestacado(),
                    "observaciones" => $libro->getObservaciones(),
                    "costeCentimos" => $libro->costeReposicionCentimos()
                ]
            ,
            $libros
        );
    } 
    public function resumen(array $libros): array {
        
        return array_reduce(
            $libros,
            function (array $acumulador, Libro $libro): array {

                $acumulador['titulos'] = $acumulador['titulos'] + 1;
                $acumulador['unidades'] += $libro->getUnidades();
                $acumulador['paginas'] += $libro->getPaginas();
                $acumulador['costeCentimos'] += $libro->costeReposicionCentimos();
            
                return $acumulador;
            }
            , 
            [
                "titulos" => 0,
                "unidades" => 0,
                "paginas" => 0,
                "costeCentimos" => 0
            ]
        );
    }
}