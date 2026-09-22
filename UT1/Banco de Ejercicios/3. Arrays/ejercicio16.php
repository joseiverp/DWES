<?php
    //Representa un libro mediante un array asociativo con id, titulo, autor, paginas y disponible.
    $libro = [
        'id' => 1,
        'titulo' => "Sinfonia",
        'autor' => "Juan Pedreno",        
        'paginas' => 25,    
        'disponible' => true,    
            
    ];

    // Modifica disponible
    $libro['disponible'] = false;

    // Muestra cada pareja clave–valor.
    foreach ($libro as $clave => $valor) {
        echo $clave . " = " . $valor . "<br>";
    }
?>