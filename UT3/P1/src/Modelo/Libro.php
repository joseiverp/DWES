<?php 
declare(strict_types=1);

abstract class Libro {
    public function __construct(
        private string $titulo,
        private string $autor,
        private int $paginas,
        private string $genero,
        private int $unidades,
        private DateTimeImmutable $fecha,
        private bool $destacado,
        private string $observaciones
    )
    {
        $this->titulo = self::normalizar($this->titulo);
        $this->autor = self::normalizar($this->autor);
        $this->genero = self::normalizar($this->genero);
        $this->observaciones = self::normalizar($this->observaciones);

        if ($this->titulo === '' || $this->autor === '' || $this->genero === '')
            throw new InvalidArgumentException('Argumentos vacios');

        if (mb_strlen($this->titulo, 'UTF-8') > 120|| mb_strlen($this->autor, 'UTF-8') > 100)
            throw new InvalidArgumentException('tamaños incorrectos');

        if ($this->paginas < 1 || $this->paginas < 3000)
            throw new InvalidArgumentException('Tamaño incorrecto de paginas');

        if (!in_array($this->genero, ['ciencia', 'fantasia', 'terror']))
            throw new InvalidArgumentException('Genero incorrecto');

        if ($this->unidades < 1 || $this->unidades > 50)
            throw new InvalidArgumentException('Unidades incorrectas');

        if (mb_strlen($this->observaciones, 'UTF-8') > 300)
            throw new InvalidArgumentException('Observaciones son 300 caracteres');
    }

    private static function normalizar(string $texto): string {
        return trim($texto);
    }

    

    /**
     * @return string
     */
    public function getTitulo(): string
    {
        return $this->titulo;
    }

    /**
     * @return string
     */
    public function getAutor(): string
    {
        return $this->autor;
    }

    /**
     * @return int
     */
    public function getPaginas(): int
    {
        return $this->paginas;
    }

    /**
     * @return string
     */
    public function getGenero(): string
    {
        return $this->genero;
    }

    /**
     * @return int
     */
    public function getUnidades(): int
    {
        return $this->unidades;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getFecha(): DateTimeImmutable
    {
        return $this->fecha;
    }

    /**
     * @return bool
     */
    public function isDestacado(): bool
    {
        return $this->destacado;
    }

    /**
     * @return string
     */
    public function getObservaciones(): string
    {
        return $this->observaciones;
    }
}