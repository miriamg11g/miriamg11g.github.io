<?php
require_once __DIR__.'/includes/config.php';

$tituloPagina = "Formulario Negociador";

$form = new es\ucm\fdi\aw\FormularioNegociadorPorProyecto(false);
$htmlFormBusquedaTrabajoPorSector = $form->gestiona();

$contenidoPrincipal = <<<EOS
$htmlFormBusquedaTrabajoPorSector

EOS;

require __DIR__.'/includes/vistas/plantillas/plantillaNegociador.php';
?>