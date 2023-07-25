<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Perfil mis post';

$contenidoPrincipal = '';

$resultado = Post::obtenerTotalPostsUsuario($_SESSION['id_usuario']);

// Mostrar cada proyecto con su imagen 

$contenidoPrincipal.= <<<EO
    <div class="todosPost">
    <div class="anadirPost"> 
        <h3>Todos los Post</h3>
    </div>
EO;
if (!empty($resultado)) {
    foreach ($resultado as $fila) {

        $id_post = $fila['id_post'];
        $id_propietario = $fila['id_propietario'];
        $titulo = $fila['titulo'];
        $short_description = $fila['short_description'];
        $description = $fila['descripcion'];
        //$needs_description = $fila['needs_description'];

        $ruta = Imagen::getRutaFromBBDD($fila['imagen']);
        
        $contenidoPrincipal.= <<<EO
        <div class="post">
            
            <div class="filaTitulo">
                <h2>$titulo</h2>

                <a href="postEliminar.php?id_post=$id_post" >
                    <div class="papelera">
                        <i class="fas fa-trash-alt" ></i>
                    </div>
                </a>
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
}else {
        $contenidoPrincipal .= <<<EO
        <div class="matchNo">
            <div class="filaTitulo">
                <h2>No se encuentran posts en tu perfil</h2>
            </div>
        </div>
        EO;
}
$contenidoPrincipal.= <<<EO
    </div>
EO;
    

require __DIR__.'/includes/vistas/plantillas/plantillaPerfil.php';