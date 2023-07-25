<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Perfil mis post';

$contenidoPrincipal = '';

$resultado = Eventos::obtenerTotalEventosUsuario($_SESSION['id_usuario']);

// Mostrar cada proyecto con su imagen 

$contenidoPrincipal.= <<<EO
    <div class="todosEventos">
    <div class="anadirEventos"> 
        <h3>Todos los Eventos</h3>
    </div>
EO;
if (!empty($resultado)) {
    foreach ($resultado as $fila) {

        $id_evento = $fila->getIdEvento();
        $id_propietario = $fila->getPropietario();
        $evento = $fila->getEvento();
        $id_proyecto = $fila->getIdProyecto();
        $description = $fila->getDescripcion();
        //$needs_description = $fila['needs_description'];

        
        
        $contenidoPrincipal.= <<<EO
        <div class="evento">
            
            <div class="filaEvento">
                <h2>$id_evento</h2>

                <a href="eventoEliminar.php?id_evento=$evento" >
                    <div class="papelera">
                        <i class="fas fa-trash-alt" ></i>
                    </div>
                </a>
            </div>

            <div class="fila">

                <div class="columna">
                    <p>$description</p>
                    <a href="vistaEvento.php?id_evento=$evento">Leer más</a>
                </div>
            </div>
        </div>
        EO;
    }
} else {
    $contenidoPrincipal .= <<<EO
    <div class="matchNo">
        <div class="filaTitulo">
            <h2>No se encuentran eventos en tu perfil</h2>
        </div>
    </div>
    EO;
}


$contenidoPrincipal.= <<<EO
    </div>
EO;
    

require __DIR__.'/includes/vistas/plantillas/plantillaPerfil.php';