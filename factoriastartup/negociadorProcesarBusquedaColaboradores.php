<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';

$tituloPagina = "Formulario Negociador";

$proyecto = "ALL";

if (isset($_GET['proyecto'])) {
    $proyecto = trim($_GET['proyecto']);
}

$form = new FormularioNegociadorUsuario($proyecto);
$htmlFormBusquedaTrabajoPorSector = $form->gestiona();

$contenidoPrincipal = <<<EOS
<div class="initBox">
    
$htmlFormBusquedaTrabajoPorSector
</div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantillaNegociador.php';
?>