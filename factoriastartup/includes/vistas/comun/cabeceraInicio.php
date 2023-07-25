<?php
namespace es\ucm\fdi\aw;

require_once __DIR__ . '/../../Usuario.php';
?>

<body>
    <header id="cabeceraInicio">

        <div id="columnas">
            
            <div class="columna1">
                
            </div>
            

            <div class="columna2">
                <nav class="navbar">
                    <ul>
                        <li><a href="inicio.php" id="img"><img src="<?= RUTA_IMGS . '/logo2.jpeg' ?>" alt="Logo de Factoria"></a></li>
                        <li><a href="inicio.php">FactoríaStartUp</a></li>
                        
                        <?php if (isset($_SESSION['login'])) { 
                            $usuario = Usuario::getUsuario($_SESSION['nombreUsuario']);?>
                                                      
                            <?php if ($usuario['rol'] == 'admin') {   ?>
                                <li><a href='perfil.php'><i class="fa fa-user" style="color: #ffffff;"></i>    Perfil</a></li>
                                <li><a href='calendarioMostrarAdmin.php'>AdminRecursos</a></li>
                                <li><a href='proyectosMostrarAdmin.php'>AdminProyectos</a></li>
                                <li><a href='postMostrarAdmin.php'>Blog</a></li>    
                           
                            <?php } else { ?>
                                <li><a href='perfil.php'><i class="fa fa-user" style="color: #ffffff;"></i>    Perfil</a></li>
                                <li><a href='contactos.php'>Contactar</a></li>
                                <li><a href='acercaDeNosotros.php'>Quienes Somos</a></li>
                                <li><a href='postMostrar.php'>Blog</a></li>
                                <li><a href='foro.php'>Foro</a></li>
                                <li><a href='calendarioMostrar.php'>Eventos</a></li>
                                <li><a href='proyectosMostrar.php'>Proyectos</a></li>
                                <li><a href='negociadorIndex.php'>Negociador</a></li>
                             <?php } ?>
                        <?php } else { ?>
                            <li><a href='login.php'><i class="fa fa-user" style="color: #ffffff"></i>   Login </i></a></li>
                            <li><a href='contactos.php'>Contactar</a></li>
                            <li><a href='acercaDeNosotros.php'>Quienes Somos</a></li>
                        <?php } ?>
                        
                    </ul>
                </nav>
            </div>
        </div>
        
    </header>

</body>
