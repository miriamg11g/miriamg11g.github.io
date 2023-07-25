<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Proyectos';

$contenidoPrincipal = '';

$rutaApp = RUTA_APP;
//luego diferenciaré lo que puede hacer el admin y lo que puede hacer el usuario normal

    $contenidoPrincipal = <<<EOS
    <div class="initBoxx">

        
        <div class="comienzo">

            <div class="margen">
                                
                <h1 class="element titulo cabecera">Proyectos</h1>
                <h2>¿Qué actividad deseas realizar con repecto a los proyectos?</h2>

                

                <div class="col">
                    
                    <div class="card card1">

                    <div class="card card2">
                    <h4><a class="boton" href='{$rutaApp}/procesoEliminarProyecto.php'>Eliminar Proyectos</a></h4>
                    <br>
                    <img src="img/elimina.png"/ width="175" height="120">
                    </div>


                </div>
            </div>


        </div>



    </div>

  

    EOS;

require __DIR__.'/includes/vistas/plantillas/plantillaInicio.php';

