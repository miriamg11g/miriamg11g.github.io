<?php

namespace es\ucm\fdi\aw;

require_once __DIR__.'/includes/config.php';

$id=isset($_GET['id_evento']) ? $_GET['id_evento'] : '';
$token=isset($_GET['token']) ? $_GET['token'] : '';

$evento=Eventos::buscaEvento($id);
var_dump($evento);
$proyecto = $evento->getIdProyecto();

$propietario = $evento->getPropietario();
var_dump($propietario);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Descripción Evento</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/estiloCabecera.css" />
        <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/estiloNormal.css" />

    </head>

    <body class="VistaEvento">

    <?php
	require(RAIZ_APP.'/vistas/comun/cabeceraInicio.php');
    ?>


    <main class="vista">
        <div class="container">
            <div class="row">
                <div class="columImg">
                    <img src="img/eventos.png" class="imagen">
                </div>

                <div class="columInfo">
                    <h2><?php echo $evento->getEvento(); ?></h2>
                    <p><strong>Proyecto al que pertenece:</strong> <?php echo $proyecto?></p>
                    <p><strong>Creador del evento:</strong> <?php echo $propietario?></p>
                    <p><strong>Fecha del evento:</strong> <?php echo $evento->getDate(); ?></p>
                    <p><strong>Descripción del evento:</strong>  <?php echo $evento->getDescripcion(); ?></p>
                </div>
            </div>
            </div>    
            <div class="atras">
               <!--<button class="btn btn-outline-primary col-10" type="button" onclick="">Seleccionar</button>-->
                <a class="atras" href="<?php echo $_SERVER['HTTP_REFERER']; ?>">Volver Atrás</a>    
            </div>  
      
    </main>


    </body>
</html>