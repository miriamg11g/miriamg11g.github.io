<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';

$tituloPagina = "Formulario Negociador";

$sector = "ALL";

if (isset($_GET['sector'])) {
    $sector = trim($_GET['sector']);
}

$form = new FormularioNegociadorPorSector($sector);
$htmlFormBusquedaTrabajoPorSector = $form->gestiona();

$contenidoPrincipal = <<<EOS
<div class="initBox">
    
$htmlFormBusquedaTrabajoPorSector
</div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantillaNegociador.php';
?>