<?php

require_once __DIR__.'/includes/config.php';

$form = new es\ucm\fdi\aw\FormularioProyectoCrearAdmin(false);
$html = $form->gestiona();

$tituloPagina = 'Añadir Proyecto';

if (isset($_SESSION["login"])) {

$contenidoPrincipal = <<<EOS
<div class="initBox">
    <div class="FormularioCrear">
        <div class="contact_form">
        <h2>Crear proyecto</h2>
        $html
        </div>
    </div>
</div>
EOS;

}

require __DIR__.'/includes/vistas/plantillas/plantillaFormulario.php';
