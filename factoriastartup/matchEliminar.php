<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Eliminar Match';

$idMatch = NULL;

if (isset($_GET['id_match'])) {
    $idMatch = trim($_GET['id_match']);
}

$match = Matches::seDesconfirma($idMatch); 
if (!$match) {
    echo 'Error';
} else header('Location: perfilMisMatches.php');

$contenidoPrincipal = '';

$contenidoPrincipal = <<<EOS

EOS;
    

require __DIR__.'/includes/vistas/plantillas/plantillaNormal.php';