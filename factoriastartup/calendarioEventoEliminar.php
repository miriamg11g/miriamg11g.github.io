<?php
  namespace es\ucm\fdi\aw;
  require_once __DIR__.'/includes/config.php';

  
  $form = new FormularioEventoEliminar();
  $htmlFormRegistro = $form->gestiona();
  

  
  $tituloPagina = 'Eliminar Evento';
  
  
  $contenidoPrincipal = <<<EOS
  
  
      $htmlFormRegistro

      <div>
      <a class="boton-flecha" href="calendarioMostrar.php">&larr; Volver</a> 
      </div>
  
  EOS;
  
  
  
  require __DIR__.'/includes/vistas/plantillas/plantillaFormulario.php';
  
  
