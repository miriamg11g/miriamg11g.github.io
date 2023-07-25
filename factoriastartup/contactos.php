<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';
$tituloPagina = 'Contacto';

$contenidoPrincipal = <<<EOS

          <div class =  "contacto">
                              
                <div id="contenedor-contacto">
                        <div class="container-contacto">
                                        <div class="bloque-contacto">
                                            <div class="info-contacto">
                                                <h5 class="alinearIzq"> DIRECCIÓN </h5>
                                                <i class="fa fa-phone"></i>
                                                <p>Av. América, 48 <br>  Madrid, España</p>
                                            </div>
                                            <div class="info-contacto">
                                                <h5 class="alinearIzq"> TELÉFONO</h5>
                                                <i class="fa fa-map-marker"></i>
                                                <p> (+34) 656 78 96 12 </p>
                                            </div>
                                            <div class="info-contacto">
                                                <h5 class="alinearIzq"> EMAIL </h5>
                                                <i class="fa fa-envelope"></i>
                                                <p> factoriastartup@gmail.com </p>
                                              
                                            </div>
                                        </div>
                                        <div class="bloque">
                                            <div class="formulario-contacto">
                                                <form method="post" action="confirmacionContacto.php" name="enqform">
                                                    <input type="text" required="" name="txtname" placeholder="NOMBRE Y APELLIDOS">
                                                    <input type="email" required="" autocomplete="off" name="txtemail"  placeholder="CORREO ELECTRÓNICO">
                                                    <textarea required="" rows="3" cols="5" name="txtmessage" placeholder="SUGERENCIAS"></textarea>
                                                    <input type="submit" name="submit" class="submit">
                                                </form>
                                            </div>
                                        </div>
                      </div>
                 </div>
            </div>




            <div  class = "contacto_mapa"> 
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3036.247031810129!2d-3.674180584932465!3d40.43813516425548!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd42287d74c34653%3A0x8bdcab25f7ebf56f!2sAvenida%20de%20Am%C3%A9rica%2C%2048%2C%2028027%20Madrid!5e0!3m2!1sen!2ses!4v1650164162743!5m2!1sen!2ses" width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy"></iframe>    
                </div>

  EOS;
     require __DIR__.'/includes/vistas/plantillas/plantillaNormal.php';
?>