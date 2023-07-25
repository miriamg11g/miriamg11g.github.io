<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Proyectos';

$busqueda = "ALL";

if (isset($_GET['busqueda'])) {
    $busqueda = trim($_GET['busqueda']);
}

$resultado = Proyecto::obtenerBusquedaProyectos($busqueda);
$form = new FormularioProyectoBusqueda(false);
$html = $form->gestiona();


    // Mostrar cada proyecto con su imagen 
    $contenidoPrincipal = '';
    $contenidoPrincipal.= <<<EO
        <div class="todosProyectos">
            <h3>Proyectos</h3>
            <div class="anadirProy"> 
            $html
            <a class='button proyecto' href='/factoriaStartup/proyectoCrear.php'>+</a>
        </div>
    EO;

if(empty($resultado)){

    $contenidoPrincipal .= '<p>No se han encontrado resultados para tu búsqueda</p>';
}
    else{
    foreach ($resultado as $fila) {

        $id_proyecto = $fila['id_proyecto'];
        //$id_propietario = $fila['id_propietario'];
        $nombre = $fila['nombre'];
        $short_description = $fila['short_description'];
        $sector = $fila['sector'];
        //$description = $fila['description'];
        //$needs_description = $fila['needs_description'];
        // Convertir imagen BLOB a base64 para mostrarla en HTML
        $ruta = Imagen::getRutaFromBBDD($fila['imagen']);
        //var_dump($ruta);
        //exit(0);
        // Mostrar proyecto de forma sencilla
        $contenidoPrincipal.= <<<EO
        <div class="proyecto">
            
            <div class="filaTitulo">
                <h2>$nombre</h2>
            </div>

            <div class="fila">
                <div class="columnaImg">
                    <img src="$ruta" alt="ImgProject">
                </div>

                <div class="columna">
                    <p>$short_description</p>
                    <a href="proyectosMostrarCompleto.php?id=$id_proyecto">Leer más</a>
                </div>
            </div>
        </div>
        EO;
    // $contenidoPrincipal.= $contenido; // Concatenar el contenido principal en la variable $contenidoCompleto

    }

    $contenidoPrincipal.= <<<EO
        </div>
    EO;
}

require __DIR__.'/includes/vistas/plantillas/plantillaProyectos.php';



