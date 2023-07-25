<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Eliminar Proyecto';

$idProyecto = NULL;

if (isset($_GET['id_proyecto'])) {
    $idProyecto = trim($_GET['id_proyecto']);
}

$proyecto = Proyecto::eliminarProyecto($idProyecto); 
header('Location: ' . $_SERVER['HTTP_REFERER']);

if (!$proyecto) {
    //ERROR
}  

$contenidoPrincipal = '';

$contenidoPrincipal = <<<EOS

EOS;
    

require __DIR__.'/includes/vistas/plantillas/plantillaPerfil.php';