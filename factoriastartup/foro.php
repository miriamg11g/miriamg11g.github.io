<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioForo.php';

use es\ucm\fdi\aw\Utils;

$form = new FormularioForo();
$htmlFormForo = $form->gestiona();

$tituloPagina = 'Foro';
//si no está logeado, no puede entrar

   // if(isset($_SESSION["login"]) && $_SESSION["login"] == true){
        $contenidoPrincipal = <<<EOS
            
            $htmlFormForo
        EOS;
    //}
    //else Utils::redirige('index.php');

    require __DIR__.'/includes/vistas/plantillas/plantillaNormal.php';
?>