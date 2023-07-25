<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'AdminModificarEventos';

$contenidoPrincipal = '';


$tituloPagina = 'Eliminar Proyecto';

// Obtén el valor de id_destino
$id_proyecto = $_POST['id'];

// Llama a la función eliminaDestino con el valor de id_fecha como parámetro
Proyecto::eliminarProyecto($id_proyecto);

header('Location: ' . $_SERVER['HTTP_REFERER']);

require __DIR__.'/includes/vistas/plantillas/plantillaAdmin.php';
