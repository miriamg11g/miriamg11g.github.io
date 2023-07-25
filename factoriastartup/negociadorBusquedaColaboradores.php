<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';

$resultado = Proyecto::obtenerMisProyectos($_SESSION['id_usuario']);

$tituloPagina = 'Busqueda Colaboradores';

$contenidoPrincipal = <<<EOS
<div class="initBoxx">
    <h1 class="titulo">
    <span>N</span><span>E</span><span>G</span><span>O</span><span>C</span><span>I</span><span>A</span><span>D</span><span>O</span><span>R</span>
    </h1>
    <h1>Selecciona el proyecto para el que buscas colaboradores:</h1>
    <div class="contenedor">
        <div class="todosProyectos">
EOS;


foreach ($resultado as $fila) {

    $form = new FormularioNegociadorColaboradores($fila);
    $htmlFormBusquedaProyecto = $form->gestiona();
    
    $contenidoPrincipal .= <<<EOS
                $htmlFormBusquedaProyecto
    EOS;
}

$contenidoPrincipal .= <<<EOS
        </div>
    </div>
</div>
EOS;


require __DIR__.'/includes/vistas/plantillas/plantillaNegociador.php';
