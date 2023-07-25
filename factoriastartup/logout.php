<?php
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Logout';
$contenidoPrincipal = "";

//Doble seguridad: unset + destroy

    if(isset($_SESSION['login'])){

        unset($_SESSION['login']);
        unset($_SESSION['esAdmin']);
        unset($_SESSION['nombreUsuario']);
        unset($_SESSION['tipo_usuario']);

        session_destroy();
    }
    
    header('Location: inicio.php');

    require __DIR__.'/includes/vistas/plantillas/plantillaLoginYRegistro.php';
