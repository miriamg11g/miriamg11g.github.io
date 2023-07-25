<?php

require_once __DIR__.'/includes/config.php';

$form = new es\ucm\fdi\aw\FormularioLogin();
$htmlFormLogin = $form->gestiona();

$tituloPagina = 'Login';

$contenidoPrincipal = <<<EOS

<div class="initBoxx">

    <div class="login">
        $htmlFormLogin
        <div class="contact_form">
        <h3>¿No tienes una cuenta?</h3>
        <a class="boton" href="/factoriaStartup/registro.php">Regístrate</a>
        </div>
    </div>
</div>


EOS;

require __DIR__.'/includes/vistas/plantillas/plantillaNormal.php';
