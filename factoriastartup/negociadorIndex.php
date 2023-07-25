<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Factoría Startup';

$contenidoPrincipal = '';

$rutaApp = RUTA_APP;

/*if (!isset($_SESSION["login"])) {*/

    $contenidoPrincipal = <<<EOS
    <div class="initBoxx">

        <h1 class="titulo">
        <span>N</span><span>E</span><span>G</span><span>O</span><span>C</span><span>I</span><span>A</span><span>D</span><span>O</span><span>R</span>
        </h1>
        <div class="descripcion">
            <h2>Selecciona la opción que más te interese:</h2>
        </div>

        <div class="opciones">

            <div class="botonBusco">
            
            <h3>Aquí encontrarás proyectos o sectores afines en los que podrás colaborar</h3>
            <h3>¿A qué esperas para encontar tu proyecto ideal?</h3>
            <a class="boton" href='{$rutaApp}/negociadorBusquedaColaborar.php'>Busco colaborar en un proyecto</a>
            </div>

           

            <div class="botonBusco">
            
            <h3>¿Tienes un proyecto interesante?</h3>
            <h3>Aquí encontrarás perfiles que se ajusten a las necesidades de tu proyecto</h3>
            <a class="boton" href='{$rutaApp}/negociadorBusquedaColaboradores.php'>Busco colaboradores para mi proyecto</a> 
            </div>

        </div>

       
        


    </div>

  

    EOS;
/*}*/

/*<div class="element Logo"><img src="./img/logo.png" alt="Logo de Factoria"></div> */

require __DIR__.'/includes/vistas/plantillas/plantillaNegociador.php';

/*
 <div class="botonBusco">
            
            <h3>Encuentra el proyecto que mejor se ajuste a tus necesidades según el sector
            </h3>
            <a class="boton" href='{$rutaApp}/busquedaSector.php'>Busco Colaborar en un Proyecto</a>
            </div>
*/
/*


    $popup = new MyPopup("Bienvenido al Negociador", "¿Preparado para encontrar tu match?");
    $popup->show();
<div class="element popup-container">
                <button type="btn-popup" id="btn-abrir-negociador2" class="btn-popup"> ¿Qué es el Negociador? </button>
                <div class="popup" id="popup">
                <h2>¿Qué es?</h2>
                <p>Se trata de una nueva forma de negociar entre varios usuarios, ya sea de manera </p>
            </div>
        </div>



 <script>
            var btnAbrirPopup = document.getElementById('btn-abrir-negociador2');
            var popup = document.getElementById('popup');
            var btnCerrarPopup = document.getElementById('btn-cerrar-popup');
            var abierto = 0;

            // Abrir ventana emergente del negociador
            btnAbrirPopup.addEventListener('click', function() {

                if(abierto == 0){
                    abierto = 1;
                    popup.classList.add('show');
                }
                else{
                    abierto = 0;
                    popup.classList.remove('show');
                }
            });

        </script>

        */






















/*
        <script>
        let popup = document.getElementById("popup");

        function openPopup(){
            popup.classList.add("show");
        }
        function closePopup(){
            popup.classList.remove("show");
        }
        </script>  
        
        <div class="element popup-container">
                <button type="btn-popup" id="btn-abrir-negociador2" class="btn-abrir-negociador2" onclick="openPopup()"> ¿Qué es el NEGOCIADOR? </button>
                <div class="popup" id="popup">
                <h2>¿Qué es?</h2>
                <p>Se trata de una nueva forma de negociar entre varios usuarios, ya sea de manera </p>
                <button class="btn-cerrar-popup" id="btn-cerrar-popup" onclick="closePopup()"> Cerrar </button>
            </div>
        </div>



             
*/