<?php

require_once __DIR__.'/includes/config.php';

$form = new es\ucm\fdi\aw\FormularioPostCrear(false);
$html = $form->gestiona();

$tituloPagina = 'Proyecto';

if(isset($_SESSION["login"]) && $_SESSION["login"] == true){
$contenidoPrincipal = <<<EOS
<div class="initBox">
    <div class="FormularioCrear">
        <div class="contact_form">
        <h3>Crear post</h3>
        $html
        </div>
    </div>
</div>
EOS;
}else header('Location: inicio.php');


require __DIR__.'/includes/vistas/plantillas/plantillaFormulario.php';
