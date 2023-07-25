<?php
namespace es\ucm\fdi\aw;

class FormularioCalendario extends Formulario
{
    public function __construct() {
        parent::__construct('formCalendario', []);
    }

    protected function generaCamposFormulario(&$datos, $errores = array()) {
       /* $calendario = '<div class="division">';*/
        $calendario = '<div class="calendario">';
        $meses = array(
            "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
            "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
        );
    
        // Obtener el mes y año actual
        $mes_actual = isset($_GET['mes']) ? intval($_GET['mes']) : intval(date('n'));
        $anio_actual = isset($_GET['anio']) ? intval($_GET['anio']) : intval(date('Y'));
    
        // Agregar desplegable para seleccionar mes
        $calendario .= '<label for="mes">Selecciona un mes:</label>';
        $calendario .= '<select name="mes" id="mes" onchange="actualizarCalendario()">';
        for ($i = 1; $i <= 12; $i++) {
            $calendario .= '<option value="' . $i . '"';
            if ($i == $mes_actual) {
                $calendario .= ' selected';
            }
            $calendario .= '>' . $meses[$i - 1] . '</option>';
        }
        $calendario .= '</select>';
    
        $calendario .= $this->generaCalendario($mes_actual, $anio_actual);
        $calendario .= '</div>';
        //$calendario .=$this->generarListaEventos($mes_actual, $anio_actual);
        
        $calendario .= $this->procesarLista();
       
        /*$calendario .= '</div>'; *///cerrar div grande

        $script = <<<EOF
        <script>
            function actualizarCalendario() {
                const mesSeleccionado = document.getElementById("mes").value;
                const url = new URL(window.location.href);
                url.searchParams.set("mes", mesSeleccionado);
                window.location.href = url.href;
            }
        </script>
    EOF;
    
        return $calendario . $script ;
    }

    protected function procesarLista() {
        $id_usuario = $_SESSION['id_usuario'];
        $eventos=Eventos::obtenerTotalEventosUsuario($id_usuario);
        
        $html='';
        $html .= '<div class="sidebarDer">';
        $html .= '<h3>Eventos actuales</h3>';
            $html .= '<div class="listado">';
                $html .= '<table>';
                $html .= "<tr><th>Nombre</th><th>Fecha</th></tr>";
                foreach ($eventos as $evento) {
                    echo $evento->getEvento();
                    //$evento = new Eventos($eventoid_evento'], $evento['evento'], $evento['fecha']);
                    $evento = new Eventos($evento->getEvento(), $evento->getIdEvento(), $evento->getDate(),$evento->getIdProyecto() ,$evento->getDescripcion(), $_SESSION['id_usuario']);
                    $html .= "<tr>";
                    $html .= "<td>" . $evento->getEvento() . "</td>";
                    
                    $html .= "<td>" . $evento->getDate() . "</td>";
                    $html .= "<td><a href='calendarioEventoVista.php?id_evento=" . $evento->getIdEvento() . "'>Ver más</a></td>";
                    $html .= "</tr>";
                }
                    $html .= "</table>";
                    $html .= '</div>';

                    $html .= '<div class="botonesSideBar">';
                    $html .= '<form method="GET">';
                    $html .= '<button type="submit" class="botonCrear" formaction="calendarioEventoCrear.php">Crear Evento</button>';
                    $html .= '<button type="submit" class="botonEliminar" formaction="calendarioEventoEliminar.php">Eliminar Evento</button>';
                    $html .= '<button type="submit" class="botonModificar" formaction="calendarioEventoModificar.php">Modificar Evento</button>';
                    $html .= '</form>';
                    $html .= '</div>';
                    

                $html .= '</div>';
        $html .= '</div>'; //de sidebar

        return $html;
    }
    

    protected function procesaFormulario(&$datos) {
        return false;
    }
    private function hayEventosEnFecha($dia, $mes, $anio) {
        $mes = str_pad($mes, 2, '0', STR_PAD_LEFT); // Añadir 0 delante del mes si es de menos de dos dígitos
        $dia = str_pad($dia, 2, '0', STR_PAD_LEFT); // Añadir 0 delante del mes si es de menos de dos dígitos
        $fecha = $anio.'-'.$mes.'-'.$dia;
        $evento = Eventos::buscaEventoPorFecha($fecha);
        return $evento !== null;
    }
    private function miEventosEnFecha($dia, $mes, $anio) {
        $mes = str_pad($mes, 2, '0', STR_PAD_LEFT); // Añadir 0 delante del mes si es de menos de dos dígitos
        $dia = str_pad($dia, 2, '0', STR_PAD_LEFT); // Añadir 0 delante del mes si es de menos de dos dígitos
        $fecha = $anio.'-'.$mes.'-'.$dia;
        $evento = Eventos::buscaEventoPorFecha($fecha);
        return $evento;
    }
    
    private function generaCalendario($mes_actual, $anio_actual) {
        $mesActual = date('n');
        $meses = array(
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 5 => 'Mayo', 6 => 'Junio', 
            7 => 'Julio', 8 => 'Agosto', 9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        );


        // Calcular el mes y año anterior y siguiente
        $mes_anterior = $mes_actual - 1;
        $anio_anterior = $anio_actual;
        if ($mes_anterior == 0) {
            $mes_anterior = 12;
            $anio_anterior--;
        }
        $mes_siguiente = $mes_actual + 1;
        $anio_siguiente = $anio_actual;
        if ($mes_siguiente == 13) {
            $mes_siguiente = 1;
            $anio_siguiente++;
        }

        // Generar la tabla del mes actual
        $calendario = '<table class="calendario">';
        $calendario .= '<caption>' . $meses[$mes_actual] . ' ' . $anio_actual . '</caption>';
        $calendario .= '<thead>';
        $calendario .= '<tr>';
        $calendario .= '<th>Lun</th>';
        $calendario .= '<th>Mar</th>';
        $calendario .= '<th>Mie</th>';
        $calendario .= '<th>Jue</th>';
        $calendario .= '<th>Vie</th>';
        $calendario .= '<th>Sab</th>';
        $calendario .= '<th>Dom</th>';
        $calendario .= '</tr>';
        $calendario .= '</thead>';
        $calendario .= '<tbody>';

        $diasEnMes = date('t', mktime(0, 0, 0, $mes_actual, 1, $anio_actual));
        $fecha = new \DateTime($anio_actual . '-' . $mes_actual . '-01');
        $diaSemana = $fecha->format('N');

       
        // Completar los días del mes anterior
        $calendario .= '<tr>';
        for ($i = 1; $i < $diaSemana; $i++) {
            $calendario .= '<td class="otro-mes"'.' style="background-color: #6495ED;">' . ($diasEnMes - $diaSemana + $i + 1) . '</td>';
        }

        // Completar los días del mes actual
        $contador = 1;
        for ($i = $diaSemana; $i <= 7; $i++) {
            $calendario .= '<td';
            if ($contador == intval(date('j')) && $mes_actual == intval(date('n')) && $anio_actual == intval(date('Y'))) {
                $calendario .= ' class="hoy"';
            }
            if ($this->hayEventosEnFecha($contador, $mes_actual, $anio_actual) && ($_SESSION['id_usuario']==$this->miEventosEnFecha($contador, $mes_actual, $anio_actual)->getPropietario())) {
                $hoy = $this->miEventosEnFecha($contador, $mes_actual, $anio_actual)->getEvento();
                $calendario .= ' style="background-color: #72b5e1;">'. $contador . '</td>';



            } else {
                $calendario .= '>' . $contador . '</td>';
            }
            $contador++;
        }
        $calendario .= '</tr>';

        while ($contador <= $diasEnMes) {
            $calendario .= '<tr>';
            for ($i = 1; $i <= 7; $i++) {
                if ($contador > $diasEnMes) {
                    break;
                }
                $calendario .= '<td';
                if ($contador == intval(date('j')) && $mes_actual == intval(date('n')) && $anio_actual == intval(date('Y'))) {
                    $calendario .= ' class="hoy"';
                }if ($this->hayEventosEnFecha($contador, $mes_actual, $anio_actual) && ($_SESSION['id_usuario']==$this->miEventosEnFecha($contador, $mes_actual, $anio_actual)->getPropietario())) {
                  
                    $calendario .= ' style="background-color: #72b5e1;">' .  $contador ;
                    $calendario .= ' onclick="mostrarEvento(\'' . $this->miEventosEnFecha($contador, $mes_actual, $anio_actual)->getEvento() . '\')">';
                 

                } else {
                    $calendario .= '>' . $contador . '</td>';
                }
                $contador++;
            }
            $calendario .= '</tr>';
        }

        $calendario .= '</tbody>';
        $calendario .= '</table>';
        
        
  


                return $calendario ;
            }



    
    function generarListaEventos($mes, $anio) {
        $lista= '<div class= "listaCalendario">';
        
        // Crear la lista de eventos
        
        $lista.= '<ul>';
        for ($i = 1; $i <= 31; $i++) {
            $fecha = sprintf('%04d-%02d-%02d', $anio, $mes, $i); // Formatear la fecha

            if ($this->hayEventosEnFecha($i, $mes, $anio)) {
                // Si hay un evento para esta fecha, agregarlo a la lista junto a enlaces para editar o eliminar
                $evento = $this->miEventosEnFecha($i, $mes, $anio); // Aquí debes obtener la información del evento correspondiente
               $id=$evento->getIdEvento();
               $lista .= '<li>' . $i . ': ' . $evento->getEvento() . '<a href="include/calendarioEventoEliminar.php?id=' . $id . '">Eliminar</a></li>';
              } else {
                // Si no hay evento, agregar un elemento vacío a la lista junto a un enlace para crear uno nuevo
                $nombre="evento vacio";
                $lista .= '<li>' . $i . ': <a href="calendarioEventoCrear.php?fecha=' . $fecha . '">Crear evento</a></li>';//por hacer

            }

              
        }
        $lista .= '</ul>';

        $lista.= '</div>';
        
        return $lista;
        }
              
            

}







  