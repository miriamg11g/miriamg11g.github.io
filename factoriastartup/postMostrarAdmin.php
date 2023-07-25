<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Blog';

$posts = Post::obtenerTotalPosts();

$form = new FormularioPostBusqueda(false);
$html = $form->gestiona();

// Mostrar cada proyecto con su imagen 
$contenidoPrincipal = '';
$contenidoPrincipal.= <<<EO
    <div class="todosProyectos">
        <h3>Blog</h3>
    <div class="anadirProy"> 

        $html
        <a class='button proyecto' href='/factoriaStartup/postCrear.php'>+</a>
        
    </div>
EO;

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

require __DIR__.'/includes/vistas/plantillas/plantillaBlog.php';



