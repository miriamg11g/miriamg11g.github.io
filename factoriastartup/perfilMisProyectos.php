<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Perfil mis proyectos';

$contenidoPrincipal = '';

$resultado = Proyecto::obtenerMisProyectos($_SESSION['id_usuario']);

// Mostrar cada proyecto con su imagen 

$contenidoPrincipal.= <<<EO
    <div class="todosProyectos">
    <div class="anadirProy"> 
        <h3>Todos los Proyectos</h3>
    </div>
EO;
if (!empty($resultado)) {
    foreach ($resultado as $fila) {

        $id_proyecto = $fila['id_proyecto'];
        $id_propietario = $fila['id_propietario'];
        $nombre = $fila['nombre'];
        $short_description = $fila['short_description'];
        $sector = $fila['sector'];
        //$description = $fila['description'];
        //$needs_description = $fila['needs_description'];

        $ruta = Imagen::getRutaFromBBDD($fila['imagen']);
        
        $contenidoPrincipal.= <<<EO
        <div class="proyecto">
            
            <div class="filaTitulo">
                <h2>$nombre</h2>

                <a href="proyectoEliminar.php?id_proyecto=$id_proyecto" >
                    <div class="papelera">
                        <i class="fas fa-trash-alt" ></i>
                    </div>
                </a>

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
    }
} else {
    $contenidoPrincipal .= <<<EO
    <div class="matchNo">
        <div class="filaTitulo">
            <h2>No se encuentran proyectos en tu perfil</h2>
        </div>
    </div>
    EO;
}

$contenidoPrincipal.= <<<EO
    </div>
EO;
    

require __DIR__.'/includes/vistas/plantillas/plantillaPerfil.php';