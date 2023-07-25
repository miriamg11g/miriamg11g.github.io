<?php

namespace es\ucm\fdi\aw;

$numProyectos = Proyecto::obtenerNumProyectosDelUsuario($_SESSION['id_usuario']);
$numPost = Post::obtenerNumPostDelUsuario($_SESSION['id_usuario']);
$numEventos = Eventos::obtenerNumEventosDelUsuario($_SESSION['id_usuario']);
$numMatches = Matches::obtenerNumMatchesSinConfirmar($_SESSION['id_usuario']);
$infoUser = Usuario::buscaInfoUsuario($_SESSION['id_usuario']);
$ruta = Imagen::getRutaFromBBDD($infoUser->getImg());

if(!$ruta) $ruta= RUTA_IMGS .'/fotosUsers/user.png';

?>
    
    <aside id="sideBarIzq">

        <div class="sidebar bar-block light-grey" style="width:25%">
            <div class="container dark-grey">Mi Perfil</div>

            <img src="<?=$ruta?>" alt="ImgUser" style="width:100%">
            <a href="perfil.php" class="bar-item button blue">Usuario:  <?=$_SESSION["nombreUsuario"]?></a>
            <a href="perfilMisProyectos.php" class="bar-item button">Mis Proyectos<span class="tag blue right margin-right"><?=$numProyectos?></span></a>
            <a href="perfilMisPost.php" class="bar-item button">Mis Post<span class="tag blue right margin-right"><?=$numPost?></span></a>

            <a href="perfilMisMatches.php" class="bar-item button">Mis Matches<span class="tag blue right margin-right"><?=$numMatches?></span></a>
            <a href="perfilMisEventos.php" class="bar-item button">Mis Eventos<span class="tag blue right margin-right"><?=$numEventos?></span></a>
          
            
            <a href="#" class="bar-item button blue">Ajustes</a>
            <a href='logout.php' class="bar-item button blue">Cerrar Sesión</a>

        </div>

    </aside>


<?php


    



 
 

 