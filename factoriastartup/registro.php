<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';

$form = new FormularioRegistro();
$htmlFormRegistro = $form->gestiona();

$tituloPagina = 'Registro';

$contenidoPrincipal = <<<EOS

<div class="initBoxx">

    <div class="registro">
        $htmlFormRegistro
        <div class="contact_form">
        <h3>¿Tienes una cuenta?</h3>
        <a class="boton" href="/factoriaStartup/login.php">Entrar</a>
        </div>
    </div>
</div>


EOS;


require __DIR__.'/includes/vistas/plantillas/plantillaNormal.php';
