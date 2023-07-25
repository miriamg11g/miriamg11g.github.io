<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';

// Obtener todos los posts buscados
$busqueda = "ALL";

if (isset($_GET['busqueda'])) {
    $busqueda = trim($_GET['busqueda']);
}

$posts = Post::obtenerBusquedaPosts($busqueda);

$tituloPagina = 'Blog';
$form = new FormularioPostBusqueda(false);
$html = $form->gestiona();

$contenidoPrincipal = '';
$contenidoPrincipal.= <<<EO
    <div class="todosProyectos">
        <h3>Blog</h3>
    <div class="anadirProy"> 

        $html
        <a class='button proyecto' href='/factoriaStartup/postMostrar.php'><i class="fa fa-arrow-left" ></i></a>
        
    </div>
EO;

if(empty($posts)){

    $contenidoPrincipal .= '<p>No se han encontrado resultados para tu búsqueda</p>';
}
else{

foreach ($posts as $post) {

    $id_post = $post['id_post'];
    $titulo = $post['titulo'];
    $short_description = $post['short_description'];
   

    $ruta = Imagen::getRutaFromBBDD($post['imagen']);

    // Mostrar proyecto de forma sencilla
    $contenidoPrincipal.= <<<EO
    <div class="proyecto">
        
        <div class="filaTitulo">
            <h2>$titulo</h2>
        </div>

        <div class="fila">
            <div class="columnaImg">
                <img src="$ruta" alt="ImgProject">
            </div>

            <div class="columna">
                <p>$short_description</p>
                <a href="vistaPost.php?id=$id_post">Leer más</a>
            </div>
        </div>
    </div>
    EO;
}

$contenidoPrincipal.= <<<EO
    </div>
EO;
}

require __DIR__.'/includes/vistas/plantillas/plantillaBlog.php';