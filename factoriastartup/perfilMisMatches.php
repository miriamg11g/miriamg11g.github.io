<?php
namespace es\ucm\fdi\aw;
require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Perfil mis matches';

$contenidoPrincipal = '';

$confirmados = Matches::obtenerTotalMatchesConfirmados($_SESSION['id_usuario']);
$noConfirmados = Matches::obtenerTotalMatchesSinConfirmar($_SESSION['id_usuario']);
$confirmadosEmpty = '';
$noConfirmadosEmpty = '';
// Mostrar cada proyecto con su imagen 

if($noConfirmados == ''){
    $noConfirmadosEmpty .= <<<EO
    <div class="matchNo">
        <div class="filaTitulo">
            <h2>No se encuentran matches sin confirmar</h2>
        </div>
    </div>
    EO;
}

if($confirmados == ''){
    $confirmadosEmpty .= <<<EO
    <div class="matchNo">
        <div class="filaTitulo">
            <h2>No se encuentran matches confirmados</h2>
        </div>
    </div>
    EO;
}

$contenidoPrincipal.= <<<EO
    <div class="todosMatches">
    <div class="anadirMatches1"> 
        <h3>Matches sin confirmar</h3>
    </div>
    $noConfirmados
    $noConfirmadosEmpty
    <div class="anadirMatches2"> 
    <h3>Todos los Matches</h3>
    </div>
    $confirmados
    $confirmadosEmpty
EO;






/*
if (!empty($noConfirmados)) {
    foreach ($noConfirmados as $fila) {

        $id_match = $fila['id_match'];
        $confirmado = $fila['confirmado'];
        $descripcion = $fila['descripcion'];
        $id_busqueda_colab = $fila['id_busqueda_colab'];
        $id_busqueda_proy = $fila['id_busqueda_proy'];
        $id_proyecto = BusquedaColaboradores::idBusquedaColab($id_match);
        $proyecto=Proyecto::obtenerProyectosPorId($id_proyecto);
        $nombreProyecto = $proyecto[0]['nombre'];
        
        //var_dump($fila);
        //var_dump($descripcion);
        //var_dump($id_busqueda_colab);   
    //var_dump($proyecto);
        $contenidoPrincipal.= <<<EO
        <div class="match">
            
            <div class="filaTitulo">
            <h2>$nombreProyecto</h2>

                <div class="emoticonos">
                    <a href="matchEliminar.php?id_match=$id_match" >
                        <div class="papelera">
                            <i class="fas fa-trash-alt" ></i>
                        </div>
                    </a>
                    <a href="matchConfirmar.php?id_match=$id_match" >
                        <div class="tick">
                            <img src="img/tick.png" alt="tick" style="width: 8%; height: 8%;">
                        </div>
                    </a>
                </div>
            </div>

            <div class="fila">
                <div class="columna">
                    <p>$descripcion</p>
                    <a href="vistaMatch.php?id_match=$id_match">Leer más</a>
                </div>
            </div>
        </div>
        EO;
    }
} else {
    $contenidoPrincipal .= <<<EO
    <div class="matchNo">
        <div class="filaTitulo">
            <h2>No se encuentran matches sin confirmar</h2>
        </div>
    </div>
    EO;
}
*/
/*
$contenidoPrincipal.= <<<EO
    
EO;
if (!empty($confirmados)) {
    foreach ($confirmados as $fil) {

        $id_match = $fil['id_match'];
        $confirmado = $fil['confirmado'];
        $descripcion = $fil['descripcion'];
        $id_busqueda_colab = $fil['id_busqueda_colab'];
        $id_busqueda_proy = $fil['id_busqueda_proy'];
        $id_proyecto = BusquedaColaboradores::idBusquedaColab($id_match);
        $proyecto=Proyecto::obtenerProyectosPorId($id_proyecto);
        $nombreProyecto = $proyecto[0]['nombre'];

        $contenidoPrincipal.= <<<EO
        <div class="match">
            
            <div class="filaTitulo">
            <h2>$nombreProyecto</h2>
            </div>

            <div class="fila">
                <div class="columna">
                    <p>$descripcion</p>
                    <a href="#.php?id_match=$id_match">Contactar</a>
                </div>
            </div>
        </div>
        EO;
    }
} else {
    $contenidoPrincipal .= <<<EO
    <div class="matchNo">
        <div class="filaTitulo">
            <h2>No se encuentran matches confirmados</h2>
        </div>
    </div>
    EO;
}
$contenidoPrincipal.= <<<EO
    </div>
EO;
    
*/
require __DIR__.'/includes/vistas/plantillas/plantillaPerfil.php';