<?php
  namespace es\ucm\fdi\aw;
  require_once __DIR__.'/includes/config.php';

  
  $form = new FormularioEventoEliminarAdmin();
  $htmlFormRegistro = $form->gestiona();
  

  
  $tituloPagina = 'Eliminar Evento Admin';
  
  
  $contenidoPrincipal = <<<EOS
  
  
      $htmlFormRegistro

      <div>
      <a class="boton-flecha" href="calendarioMostrarAdmin.php">&larr; Volver</a> 
      </div>
  
  EOS;
  
  
  
  require __DIR__.'/includes/vistas/plantillas/plantillaFormulario.php';
  
  
