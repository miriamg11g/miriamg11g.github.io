<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Eliminar Post';

$idPost = NULL;

if (isset($_GET['id_post'])) {
    $idPost = trim($_GET['id_post']);
}

$post = Post::eliminarPost($idPost); 
if (!$post) {
    //ERROR
}  

$contenidoPrincipal = '';

$contenidoPrincipal = <<<EOS

EOS;
    

require __DIR__.'/includes/vistas/plantillas/plantillaPerfil.php';