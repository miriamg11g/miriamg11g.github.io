<?php
  namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';

$form = new FormularioNegociadorColaborarEnSector(false);
$htmlFormBusquedaTrabajoPorSector = $form->gestiona();

$tituloPagina = 'Busqueda Trabajo';

$contenidoPrincipal = <<<EOS
<div class="initBoxx">
    <h1 class="titulo">
    <span>N</span><span>E</span><span>G</span><span>O</span><span>C</span><span>I</span><span>A</span><span>D</span><span>O</span><span>R</span>
    </h1>
    <div class="titulo">
        <h2>Tienes dos opciones:</h2>
    </div>
    <div class="contenedor">
        <div class="sector">
            <h1>Seleccionar un Sector</h1>
            $htmlFormBusquedaTrabajoPorSector
        </div>
        <div class="todosProyectos">
            <h1>Seleccionar el proyecto</h1>
EOS;

$sector = "ALL";

if (isset($_GET['sector'])) {
    $sector = trim($_GET['sector']);
}


$resultado = Proyecto::obtenerTotalProyectos($sector);

$form = new FormularioNegociadorSectorBusqueda(false);
$htmlBusquedaSector = $form->gestiona();


$contenidoPrincipal .= <<<EOS
    $htmlBusquedaSector
EOS;

foreach ($resultado as $fila) {

$form = new FormularioNegociadorColaborarEnProyecto($fila);
$htmlFormBusquedaTrabajoPorProyecto = $form->gestiona();

$contenidoPrincipal .= <<<EOS
            $htmlFormBusquedaTrabajoPorProyecto
EOS;
}


$contenidoPrincipal .= <<<EOS
</div></div></div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantillaNegociador.php';
