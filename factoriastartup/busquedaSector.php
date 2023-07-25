<?php

require_once __DIR__.'/includes/config.php';

$form = new es\ucm\fdi\aw\FormularioBusquedaProyectoPorSector(false);
$htmlFormBusquedaTrabajoPorSector = $form->gestiona();


$tituloPagina = 'Busqueda Trabajo';

$contenidoPrincipal = <<<EOS
<div class="initBox">
    <h1 class="busqueda">Busco Colaborar en un Proyecto</h1>
    $htmlFormBusquedaTrabajoPorSector
    
</div>
EOS;


require __DIR__.'/includes/vistas/plantillas/plantillaNegociador.php';
