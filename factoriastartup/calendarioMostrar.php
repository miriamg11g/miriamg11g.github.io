<?php
//namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';

$form = new es\ucm\fdi\aw\FormularioCalendario();
$html = $form->gestiona();

$tituloPagina = 'Calendario';


$contenidoPrincipal = <<<EOS
<div class=calendarioinicio>
    <h3>Calendario</h3>
</div>
$html
EOS;


require __DIR__.'/includes/vistas/plantillas/plantillaCalendario.php';
