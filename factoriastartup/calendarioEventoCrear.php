<?php
  namespace es\ucm\fdi\aw;
  require_once __DIR__.'/includes/config.php';

  
  $form = new FormularioEventoCrear();
  $htmlFormRegistro = $form->gestiona();
  

  
  $tituloPagina = 'Crear Evento';
  
  if(isset($_SESSION["login"]) && $_SESSION["login"] == true){
  $contenidoPrincipal = <<<EOS
  
  
      $htmlFormRegistro

      <div>
      <a class="boton-flecha" href="calendarioMostrar.php">&larr; Volver</a> 
      </div>
  
  EOS;
  }else header('Location: inicio.php');
  
  
  require __DIR__.'/includes/vistas/plantillas/plantillaFormulario.php';
  