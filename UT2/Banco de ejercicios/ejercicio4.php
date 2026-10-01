<?php
    $catalogo = [[] ,[], [], [], []];
    $disponibles = array_filter($catalogo,
    fn(int $a): bool => $a['disponible']
    )
?>