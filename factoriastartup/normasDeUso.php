<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Factoría Normas de Uso Startup';

$contenidoPrincipal = '';

$rutaApp = RUTA_APP;



    $contenidoPrincipal = <<<EOS
    <div class="initBoxx">

        
        <div class="comienzo">

            <div class="margen">
                                
                <h2 class="element titulo cabecera">Normas de uso responsable</h2>
                <p>Existen unas normas para la utilización de la web que todos los usuarios deben de respetar:

                Factoría Startup es una plataforma web participativa, basada en una red social, con un foro y una zona de eventos principalmente.
                
                Una plataforma de estas características, pertenece a un tipo de colaboración y comunicación que se denomina asíncrona, ya que, no es simultáneo en el tiempo. Es un ambiente de comunicación, donde se propicia la colaboración, el debate, la concertación y el consenso de ideas. En este, el usuario publica su mensaje en cualquier momento, quedando visible para que otros usuarios que entren más tarde, puedan leerlo y contestar. Ello permite mantener una comunicación constante con personas con algún tipo de afinidad o interés común aunque se encuentren lejos, sin necesidad de coincidir en los horarios de encuentro, superando así las limitaciones temporales.</p>

                <ol>
                    <li>Procedimiento de participación</li>
                    <li>Recomendaciones</li>
                    <li>Normas Generales</li>
                </ol>

                <h2 class="element titulo cabecera">Procedimiento de participación</h2>
                <p>Existen unas normas para la utilización de la web que todos los usuarios deben de respetar:

                Factoría Startup es una plataforma web participativa, basada en una red social, con un foro y una zona de eventos principalmente.
                
                Una plataforma de estas características, pertenece a un tipo de colaboración y comunicación que se denomina asíncrona, ya que, no es simultáneo en el tiempo. Es un ambiente de comunicación, donde se propicia la colaboración, el debate, la concertación y el consenso de ideas. En este, el usuario publica su mensaje en cualquier momento, quedando visible para que otros usuarios que entren más tarde, puedan leerlo y contestar. Ello permite mantener una comunicación constante con personas con algún tipo de afinidad o interés común aunque se encuentren lejos, sin necesidad de coincidir en los horarios de encuentro, superando así las limitaciones temporales.</p>

                <ul>
                    <li>La participación en la plataforma es una actividad de comunicación bidireccional asincrónica en la cual se establecen esquemas de cooperación, participación e intercambio de ideas, opiniones y trabajos. Para participar de la experiencia, los usuarios deberán revisar, comentar y retroalimentar los aportes de otros.</li>
                    <li>Las participaciones en la actividad de la plataforma deberán ser veraces y en el caso que sea posible referir citando la fuente el material utilizado para apoyar la intervención o contraste en el caso en que fuere necesario.                   </li>
                    <li>Las intervenciones deberán seguir un hilo en cuanto a las participaciones del resto de los compañeros y compañeras de la comunidad.</li>
                    <li>Las intervenciones deberán tratar de enriquecer las participaciones anteriores o aportar elementos nuevos a la discusión.</li>
                    <li>Es muy importante el respeto a las ideas de los demás y el uso del lenguaje adecuado, sin perder por supuesto el buen humor y buen trato hacia los demás. Recuerda que cuando escribimos no nos vemos las expresiones y esto puede dar pie a susceptibilidades. Antes de enfadarte analiza bien, no tomes conclusiones precipitadas que puedan estar confundidas. </li>
                </ul>

                <h2 class="element titulo cabecera">Recomendaciones</h2>
                    <li>El participante debe dejar claro a quien va dirigida su publicación, bien sea para la plataforma, bien sea para un miembro en particular.</li>
                    <li>Conviene recordar que cualquiera de las publicaciones, mensajes, etc, van dirigidas a personas: aunque el medio es impersonal, sus participantes no lo son. Ponte en el lugar de quien lo recibe</li>
                    <li>Factoría Startup es una comunidad y se enriquece en gran parte con las contribuciones de todos y todas; por eso recomendamos la participación activa.</li>
                    <li>Cuando se publica algo en la plataforma, intenta se lo más explicito/a que puedas. Pónselo lo más fácil posible al resto de la comunidad.</li>
                    <li>Si en el foro se contesta a un mensaje publicado, no es necesario citarlo íntegramente, ya que todos los miembros pueden leer el original.</li>
            </div>
        </div>

    </div>

  

    EOS;

require __DIR__.'/includes/vistas/plantillas/plantillaNormal.php';

