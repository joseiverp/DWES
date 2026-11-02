<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Model\Libro;
use App\Model\Revista;

$libro = new Libro('Dune');
$revista = new Revista('Ciencia');

$recursos = [$libro, $revista];
echo "Total de recursos: " . count($recursos) . PHP_EOL;

foreach ($recursos as $r) {
    echo $r->tipo() . PHP_EOL;
}
