<?php
//namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';

$form = new es\ucm\fdi\aw\FormularioCalendarioAdmin();
$html = $form->gestiona();

$tituloPagina = 'Calendario Administrador';


$contenidoPrincipal = <<<EOS
<div class=calendarioinicio>
    <h3>Calendario Administrador</h3>
</div>
$html
EOS;


require __DIR__.'/includes/vistas/plantillas/plantillaCalendario.php';
