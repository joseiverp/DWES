<?php

declare(strict_types=1);

function limpiarEspacios(string $texto): string
{
    // TODO 1: limpiar extremos y agrupar espacios consecutivos.🟢
    $texto = trim($texto);
    $texto = preg_replace('/\S+/', ' ', $texto);

    return $texto;
}

function normalizarBusqueda(string $texto): string
{
    // REVISAR: ¿funciona con PÁDEL y ÓRBITA? 🟢
    return mb_strtolower(limpiarEspacios($texto), 'UTF-8');
}

function obtenerCategorias(array $actividades): array
{
    // TODO 2: extraer categorías sin duplicados en orden de aparición.🟢
    $categorias = array_column($actividades, 'categoria');
    $categorias = array_unique($categorias);
    $categorias = array_values($categorias);
    return $categorias;
}

function categoriaValida(string $categoria, array $categorias): bool
{
    return $categoria === ''
        || array_search($categoria, $categorias, true) !== false;

        /*
        
            CODIGO EQUIVALENTE PERO ESCRITO DE MANERA QUE SEA MAS FACIL DE APRENDER
            if ($categoria === '') {
                return true;
            }

            $posicion = array_search($categoria, $categorias, true);

            return $posicion !== false;

        */
}

function plazasOcupadas(array $reservas, int $actividadId): int
{
    // TODO 5: sumar plazas de reservas confirmadas de esta actividad.
    return 0;
}

// Función facilitada: añade los cálculos a una copia de cada actividad.
function prepararActividades(array $actividades, array $reservas): array
{
    return array_map(
        function (array $actividad) use ($reservas): array {
            $actividad['ocupadas'] = plazasOcupadas($reservas, $actividad['id']);
            $actividad['libres'] = $actividad['capacidad'] - $actividad['ocupadas'];

            return $actividad;
        },
        $actividades
    );
}











   // Preguntar a CHATGPT: entonces array_filter solo puede recibir
   //  un array de array ($actividades) y el callback solo un array ($actividad)? 

function filtrarActividades(
    array $actividades,
    string $texto,
    string $categoria,
    bool $soloConPlazas
    ): array
{
    $textoNormalizado = normalizarBusqueda($texto);

    return array_filter(
        $actividades,
        fn(array $actividad): bool =>
            (
                $textoNormalizado === ''
                ||
                str_contains(normalizarBusqueda($actividad['nombre']), $textoNormalizado)
            )
            &&
            (
                $categoria === ''
                ||
                $actividad['categoria'] === $categoria
            )
            &&
            (
                $soloConPlazas === false 
                ||
                $actividad['libres'] > 0
            )    
    );
}




// MANERA PARA APRENDER 

// function ordenarActividades(array $actividades, string $orden): array
// {
//     // TODO 4: ordenar una copia según el criterio y desempatar por id.
//     usort (
//         $actividades,
//         function (array $a, array $b) use ($orden):int {

//             if ($orden === 'libres'){
//                 $resultado = $a['libre'] <=> $b['libre'];
//             } else {
//                 $resultado =
//                     normalizarBusqueda($a['nombre'])
//                     <=>
//                     normalizarBusqueda($b['nombre'])
//             }

//             if ($resultado === 0) {
//                 $resultado = $a['id'] <=> $b['b'];
//             }

//             return $resultado;
//         }
//     );
//     return $actividades;
// }



// USANDO TERNARIO

function ordenarActividades(array $actividades, string $orden): array
{
    // TODO 4: ordenar una copia según el criterio y desempatar por id.
    usort (
        $actividades,
        function (array $a, array $b) use ($orden):int {

            $resultado = $orden === 'libres' 
                ? $a['libre'] <=> $b['libre']
                : normalizarBusqueda($a['nombre'])
                    <=> normalizarBusqueda($b['nombre']);
            
            return resultado === 0
                ? $a['id'] <=> $b['b']
                : $resultado;

        }
    );
    return $actividades;
}







function resumirActividades(array $actividades): array
{
    return [
        'cantidad' => count($actividades),
        'capacidad' => count($actividades), // REVISAR: cuenta actividades, no plazas
        'ocupadas' => array_reduce(
            $actividades,
            fn(int $s, array $a): int => $s + $a['ocupadas'],
            0
        ),
        'libres' => 0, // TODO 6: sumar plazas libres
        'hayCompletas' => false, // TODO 7: comprobar si alguna está completa
        'todasConPlazas' => false, // TODO 8: comprobar si todas tienen plazas
    ];
}

// Función facilitada: permite pasar una función como dato.
function transformarNombres(array $nombres, callable $callback): array
{
    return array_map($callback, $nombres);
}

function generarEtiquetas(array $actividades, string $prefijo = 'Actividad: '): array
{
    // TODO 9: extraer nombres y usar una closure que capture el prefijo.
    return [];
}

// Función facilitada. La entrada web valida el id antes de llamar.
function normalizarId(int|string $id): int
{
    return (int) $id;
}

function buscarPorId(array $actividades, int|string $id): ?array
{
    // TODO 10: buscar por id en todas las actividades; id no es índice.
    return null;
}

function monitorVisible(?string $monitor): string
{
    // TODO 11: resolver el caso de monitor null.
    return '';
}

function inicioNombre(string $nombre): string
{
    return substr(limpiarEspacios($nombre), 0, 3);
}

function codigoValido(string $codigo): bool
{
    return preg_match('/DEP-[0-9]+-[0-9]+/', $codigo) === 1;
}
