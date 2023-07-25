<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Perfil';

//$form1 = new FormularioPerfilEditarImagen(false);
//$html1 = $form1->gestiona();
$form2 = new FormularioPerfilEditar(false);
$html2 = $form2->gestiona();

$contenidoPrincipal = '';
$contenidoPrincipal.= <<<EO
<div class="todoInfo">
    <div class="tituloEditarPerfil"> 
    <a class='button proyecto' href='/factoriaStartup/perfil.php'><i class="fa fa-arrow-left" ></i></a>
        <h2>Editar Perfil</h2>
    </div>
    
    $html2
</div>
EO;


$contenidoPrincipal .= <<<EO


EO;
   


require __DIR__.'/includes/vistas/plantillas/plantillaPerfil.php';