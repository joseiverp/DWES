<?php

function e(string $texto): string
{
    return htmlspecialchars($texto, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function volcar(mixed $dato): string
{
    ob_start();
    var_dump($dato);
    return e(ob_get_clean());
}

function camposOcultos(array $campos): string
{
    $html = '';
    foreach ($campos as $nombre => $valor) {
        if (is_array($valor)) {
            foreach ($valor as $elemento) {
                $html .= '<input type="hidden" name="' . e($nombre) . '[]" value="' . e($elemento) . '">';
            }
        } else {
            $html .= '<input type="hidden" name="' . e($nombre) . '" value="' . e($valor) . '">';
        }
    }
    return $html;
}
