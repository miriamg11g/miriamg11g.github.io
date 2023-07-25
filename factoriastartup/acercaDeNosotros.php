<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Acerca de Nosotros';

$contenidoPrincipal = '';

$rutaApp = RUTA_APP;



    $contenidoPrincipal = <<<EOS
            
                                    
                <div class="fondoQuienesSomos">
                    <div class="content">
                        <div class="contenido">
                            <h1 class="element titulo">¿Quienes forman Factoria StartUp?</h1>
                            <h2>En Factoría StartUp dispones de las herramientas y recursos necesarios para poder:</h2>
                        </div>   
                        <img src="img/adminProyectos.png" alt="Imagen" class="image">
 
                    </div>
                </div>   
                <div class="overlay">
                              
                <div class="lista">
                    <ul>
                        <li>Crear un perfil profesional adaptado al proyecto que te interesa.</li>
                        <li>Publicar un proyecto en cualquier fase del mismo.</li>
                        <li>Encontrar equipo; socio, colaborador, mentor ..</li>
                        <li>Evolucionar y crecer en la comunidad en cada momento</li>
                        <li>Buscar y publicar eventos que te ayuden a crecer como profesional</li>
                        <li>Publicar y exponer tus ideas, tus conocimientos, tu experiencia…</li>
                        <li>Encontrar respuestas y soluciones a través del soporte comunitario</li>
                        <li>Comunicarte con cualquier miembro de la comunidad de forma pública o privada.</li>    
                    </ul>
                </div>

                <p>Existen más recursos, pero en vez de extendernos más creemos que es mejor que entres y lo compruebes.
                Además que esto no acaba aquí, en Factoría StartUP estamos en constante evolución e iremos añadiendo más herramientas y funcionalidades para tu éxito</p>
               
                <div class="boton">
                    <button class="boton">
                        <a href="registro.php">¡Empieza ahora!</a>
                    </button>
                </div>

            

                   
             </div>    

            <div class="contenedorMiembro">

                <div class="titulo">
                    <h3>Somos un equipo comprometido con el emprendedor</h3>
                </div>
             

                <div class="columnaMiembro">

                    <div class="card">
                        <div class="img-box">
                            <img src=""/ width="125" height="120">
                                <ul>
                                    <a href="#"><li><i class="fa fa-facebook"></i></li></a>
                                    <a href="#"><li><i class="fa fa-linkedin"></i></li></a>    
                                </ul>
                        </div>
                        <div class="card-content">
                            <h4>Antonio González</h4>
                            <h4>CEO</h4>
                        </div>        
                    </div>

                

                    <div class="card">
                        <div class="img-box">
                            <img src=""/ width="125" height="120">
                                <ul>
                                    <a href="#"><li><i class="fa fa-facebook"></i></li></a>
                                    <a href="#"><li><i class="fa fa-linkedin"></i></li></a>    
                                </ul>
                        </div>
                        <div class="card-content">
                            <h4>Paco Guio</h4>
                            <h4>CTO</h4>
                        </div>
                    </div>

                    <script>

                        function mostrarModal() {
                            document.getElementById("mi-modal").style.display = "block";
                        }
                        
                        function cerrarModal() {
                            document.getElementById("mi-modal").style.display = "none";
                        }

                    </script>

                </div>
            </div>
            

    EOS;

require __DIR__.'/includes/vistas/plantillas/plantillaNormal.php';

//https://www.youtube.com/watch?v=cP9KxNqHrUY   