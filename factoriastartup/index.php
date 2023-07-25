<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Factoría Inicio Startup';

$contenidoPrincipal = '';

$rutaApp = RUTA_APP;




   /*$popup = new MyPopup("Bienvenido al Negociador", "¿Preparado para encontrar tu match?");
    $popup->show();
    */

    $contenidoPrincipal = <<<EOS
    <div class="initBoxx">

        
        <div class="comienzo">

            <div class="home">
                                
                <h1 class="titulo">
                <span>F</span><span>A</span><span>C</span><span>T</span><span>O</span><span>R</span><span>Í</span><span>A</span><span>    </span><span>S</span><span>T</span><span>A</span><span>R</span><span>T</span><span>U</span><span>P</span>
                </h1>
                <h2>Puedes emprender o puedes tener éxito</h2>
                <h2>Aprovecha la inteligencia colectiva y consigue tus objetivos</h2>

            </div>

            <div class="col">

                <div class="colDentro">

                    <div class="card card1">

                        <h4><a class="boton" href='{$rutaApp}/calendarioMostrar.php'>Calendario</a></h4>
                        <br>
                        <img src="img/c.png"/ width="175" height="120">
                        <span class="img"><img class="imagen" > </span>
                        <br><p>Publica y/o asiste a cursos, talleres, charlas.... y haz networking</p>
                        </div>

                        <div class="card card2">
                        <h4><a class="boton" href='{$rutaApp}/proyectosMostrar.php'>Proyectos</a></h4>
                        <br>
                        <img src="img/eventos.png"/ width="175" height="120">
                        <br><p>Crea y encuentra proyectos interesantes en los que colaborar</p>
                        </div>

                        <div class="card card3">
                        <h4> <a class="boton" href='{$rutaApp}/recursos.php'>Recursos</a></h4>
                        <br>
                        <img src="img/rec.png"/ width="175" height="120">
                        <br><p>Herramientas que aportan soluciones: foro, noticias, DAFO... </p>
                        </div>

                        <div class="card card4">
                        <h4><a class="boton" href='{$rutaApp}/perfil.php'>Perfiles</a></h4>
                        <br>
                        <img src="img/p.png"/ width="175" height="120">
                        <br><p>Publica tu perfil, date a conocer o encuentra equipo para tu proyecto</p>
                        </div>

                    </div>
                </div>
            </div>
            <div class="colaboracion">
            
                <div class="parteDeAbajo">

                    <div class="titulo">
                        <h3>Nuestros colaboradores</h3>
                    </div>
                </div>
                    
                
                <div class="colaboradores">
                    <div class="colaborador">
                    <h4>Miriam García Godoy</h4>
                    <br>
                    <div class="img-box">
                    <img src="img/miriam.jpg">
                    </div>
                    <br><p>Estudiante del Doble grado de Ingenieria Informatica y ADE</p>
                    </div>

                    <div class="colaborador">
                    <h4>Leire Fernández Rivas</h4><br>
                    <div class="img-box">
                    <img src="img/leire.jpeg"/width="200" height="250">
                    </div>
                    <br><p>Estudiante del Doble grado de Ingenieria Informatica y ADE</p>
                    </div>

                    <div class="colaborador">
                    <h4>María Belén Herruzo Barroso</h4>
                    <br>
                    <div class="img-box">
                    <img src="img\maria.jpeg"/width="200" height="250">
                    </div>
                    <br><p>Estudiante del Doble grado de Ingenieria Informatica y ADE</p>
                    </div>

                </div>
            </div>
            
        


        </div>

      


    </div>

  

    EOS;

require __DIR__.'/includes/vistas/plantillas/plantillaInicio.php';

