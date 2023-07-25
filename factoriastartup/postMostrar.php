<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';

// Obtener todos los posts
//$posts = Post::obtenerTotalPosts();
/*
// Mostrar cada post con su título, fecha y contenido
$contenidoPrincipal = '';
foreach ($posts as $post) {
    $imagen=base64_encode($post['imagen']);
    $contenido= <<<EO
    <div class="div">
        <div class="blog">
            <img src="data:image/jpeg;base64,{$imagen}" style="max-width: 200px;">
            <h2>{$post['titulo']}</h2>
            <div class="blog_p">
                <p>{$post['short_description']}</p>
                <p>{$post['descripcion']}</p>
            </div>
        </div>
    </div>
    EO;
    $contenidoPrincipal.= $contenido; // Concatenar el contenido principal en la variable $contenidoCompleto
}


require __DIR__.'/includes/vistas/plantillas/plantillaNormal.php';
*/
/*
$tituloPagina = 'Blog';

// Mostrar cada post con su título, fecha y contenido
$contenidoPrincipal = '';
    $contenidoPrincipal = <<<EO
        <body>
        <section id="blog">
                <div class="blog-heading">
                    <span>Posts recientes</span>
                    <h3>Blog</h3>
                </div>
    EO;
    foreach ($posts as $post) {

    $ruta = Imagen::getRutaFromBBDD($post['imagen']);

    $contenido= <<<EO
            <div class="content">
                <div class="blog-container">
                    <div>
                        <img src="$ruta" alt="Blog">
                    </div>
                </div>

                <div class="blog-text">
                    <span>fecha</span>
                    <a href="vistaPost.php?id_post={$post['id_post']}" class="blog-title">{$post['titulo']}</a>
                    <p>{$post['short_description']}</p>
                    <a href="vistaPost.php?id_post={$post['id_post']}" >Leer mas</a>
                </div>
            </div>
        </section>   
        </body>
        EO;
        $contenidoPrincipal.= $contenido; // Concatenar el contenido principal en la variable $contenidoCompleto
        

    }
    require __DIR__.'/includes/vistas/plantillas/plantillaBlog.php';
*/




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
                <a href="vistaPost.php?id_post=$id_post">Leer más</a>
            </div>
        </div>
    </div>
    EO;

}

$contenidoPrincipal.= <<<EO
    </div>
EO;

require __DIR__.'/includes/vistas/plantillas/plantillaBlog.php';



