<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';
$tituloPagina = 'Contacto';

$contenidoPrincipal = <<<EOS
<div class="bodyConfirmacion">
    <div class="confirmacion">
        <h1>Mensaje enviado</h1>
        <p>Gracias por contactar con Factoria Startup. Hemos recibido tu mensaje y nos pondremos en contacto contigo a la brevedad posible.</p>
    </div>
</div>
<div>

    <a class="boton-flecha" href="inicio.php">&larr; Volver</a> 
</div>
EOS;

require __DIR__.'/includes/vistas/plantillas/plantillaNormal.php';
?>
