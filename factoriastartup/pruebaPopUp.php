<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';

$contenidoPrincipal = '';

$popup = new MatchPopUp("Pop up personalizado", "Este es un pop up con dos variables personalizadas", "hola", "chao");
$popup->show();


require __DIR__.'/includes/vistas/plantillas/plantillaIndex.php';
