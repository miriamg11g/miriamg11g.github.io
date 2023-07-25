<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/FormularioForoContinua.php';



$id=isset($_GET['id']) ? $_GET['id'] : '';
$form = new FormularioForoContinua($id);
$htmlFormForo = $form->gestiona();

$tituloPagina = 'Foro';

$contenidoPrincipal = <<<EOS
  
    $htmlFormForo
EOS;


require __DIR__.'/includes/vistas/plantillas/plantillaNormal.php';
?>