<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Eliminar Evento';

$idEvento = NULL;

if (isset($_GET['id_evento'])) {
    $idEvento = trim($_GET['id_evento']);
}

$evento = Eventos::elimina($idEvento); 
if (!$evento) {
    echo 'Error';
} else header('Location: perfilMisEventos.php');

$contenidoPrincipal = '';

$contenidoPrincipal = <<<EOS

EOS;
    

require __DIR__.'/includes/vistas/plantillas/plantillaNormal.php';