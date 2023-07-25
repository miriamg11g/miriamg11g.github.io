<?php

namespace es\ucm\fdi\aw;


require_once __DIR__.'/includes/config.php';
require_once __DIR__.'/includes/Post.php';

$id=isset($_GET['id_post']) ? $_GET['id_post'] : '';
$token=isset($_GET['token']) ? $_GET['token'] : '';

$post= Post::buscaPost($id);

$ruta = Imagen::getRutaFromBBDD($post->getImagen());
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Descripción Evento</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <link href="css/destinos.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/estiloCabecera.css" />
        <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/estiloNormal.css" />
        <link rel="stylesheet" type="text/css" href="<?= RUTA_CSS ?>/estiloProyectosMostrar.css" />
        
    </head>

    <body class="vistaPost">

    <?php
	require(RAIZ_APP.'/vistas/comun/cabeceraInicio.php');
    ?>


    <main class="vista">
        <div class="container">
            <div class="row">
                <div class="columImg">
                    <img src="<?php echo $ruta; ?>" alt="ImgProject">
                </div>
                <div class="columInfo">
                    <h2><?php echo $post->getdescripcion(); ?></h2>
                        <div class="descripcion">
                           <p><?php echo $post->getTitulo();?></p>
                        </div>
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