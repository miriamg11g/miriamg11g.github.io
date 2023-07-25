<?php

use es\ucm\fdi\aw\Proyecto;

require_once __DIR__.'/includes/config.php';

$sector = $_SESSION['sector'];
$proyectos = Proyecto::obtenerTotalProyectos($sector);
var_dump($sector);
var_dump($proyectos);
$tituloPagina = 'Busqueda Proyecto Por Sector';

$contenidoPrincipal = <<<EOS
<section id="init">
    <div class="negociador-heading">
        <span>Proyectos más recientes</span>
        <h3>Proyectos</h3>
    </div>
EOS;

foreach ($proyectos as $p) {
    $contenido = <<<EO
    <div class="content">
        <div class="div-container">
            <div>
                <img src="">
            </div>
        </div>
        <div class="div-text">
            <a href="negociadorUsuario.php?id_proyecto={$p['id_proyecto']}" class="blog-title">{$p['nombre']}</a>
            <p>{$p['short_description']}</p>
            <a href="vistaProyecto.php?id_proyecto={$p['id_proyecto']}">Leer más</a>
        </div>
    </div>
    EO;
    $contenidoPrincipal .= $contenido;
}

$contenidoPrincipal .= <<<EOS
</section>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantillaIndex.php';
