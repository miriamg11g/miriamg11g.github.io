<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'AdminConsola';

$contenidoPrincipal = '';

$rutaApp = RUTA_APP;

    $contenidoPrincipal = <<<EOS
    <div class="initBoxx">

        
        <div class="comienzo">

            <div class="margen">
                                
                <h1 class="element titulo cabecera">AdminConsola</h1>
                <h2>¿Qué deseas hacer?</h2>

                

                <div class="col">

                    <div class="card card1">

                    <h4><a class="boton" href='{$rutaApp}/adminProyectos.php'>Modificar proyectos</a></h4>
                    <br>
                    <img src="img/adminProyectos.png"/ width="175" height="120">
                    <span class="img"><img class="imagen" > </span>
                    </div>

                </div>

                <div class="col">

                    <div class="card card2">

                    <h4><a class="boton" href='{$rutaApp}/adminRecursos.php'>Modificar otros recursos</a></h4>
                    <br>
                    <img src="img/adminRecursos.png"/ width="175" height="120">
                    <span class="img"><img class="imagen" > </span>
                    </div>
                </div>

                <div class="col">

                    <div class="card card2">

                    <h4><a class="boton" href='{$rutaApp}/creablog.php'>Modificar Proyectos</a></h4>
                    <br>
                    <img src="img/creaP.png"/ width="175" height="120">
                    <span class="img"><img class="imagen" > </span>
                    </div>
                </div>
            </div>


        </div>



    </div>

  

    EOS;

require __DIR__.'/includes/vistas/plantillas/plantillaAdmin.php';
