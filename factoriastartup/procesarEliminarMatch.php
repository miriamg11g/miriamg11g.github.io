<?php
namespace es\ucm\fdi\aw;

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Perfil';


$contenidoPrincipal = '';

$id_match = $_GET['Matches'];

$contenidoPrincipal .= $id_match;

//$_SESSION['id_match'] = $id_match;

$match = Matches::eliminarMatch($id_match);

//return $match;



header('Location: perfil.php');


require __DIR__.'/includes/vistas/plantillas/plantillaPerfil.php';



?>