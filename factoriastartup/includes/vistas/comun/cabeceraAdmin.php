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
                                   
                            
                                <li><a href='logout.php'>Cerrar Sesión</a></li>
                                <li><a href='perfil.php'><?=$_SESSION["nombreUsuario"]?></a></li>
                                <li><a href='calendarioMostrarAdmin.php'>AdminRecursos</a></li>
                                <li><a href='proyectosMostrarAdmin.php'>AdminProyectos</a></li>
                                <li><a href='postMostrarAdmin.php'>Blog</a></li>    
                           
                            
                             <?php }  else { ?>
                            <li><a href='login.php'>Login</i></a></li>
                            <li><a href='registro.php'>Registro</i></a></li>
                            <li><a href='contactos.php'>Contactar</a></li>
                            <li><a href='acercaDeNosotros.php'>Quienes Somos</a></li>
                        <?php } ?>
                        
                    </ul>
                </nav>
            </div>
        </div>
        
    </header>

</body>
