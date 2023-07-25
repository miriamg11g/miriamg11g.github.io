<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Recursos';

$contenidoPrincipal = '';

$rutaApp = RUTA_APP;

    $contenidoPrincipal = <<<EOS
    <div class="initBoxx">

        
        <div class="comienzo">

            <div class="margen">
                                
                <h1 class="element titulo cabecera">Recursos</h1>
                <h2>¿Qué recurso desea utilizar?</h2>

                

                <div class="col">

                    <div class="card card1">

                    <h4><a class="boton" href='{$rutaApp}/creablog.php'>Crea Post</a></h4>
                    <br>
                    <img src="img/creaP.png"/ width="175" height="120">
                    <span class="img"><img class="imagen" > </span>
                    </div>



                </div>
            </div>


        </div>



    </div>

  

    EOS;

require __DIR__.'/includes/vistas/plantillas/plantillaInicio.php';
