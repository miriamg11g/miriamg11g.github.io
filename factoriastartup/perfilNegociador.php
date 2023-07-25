<?php

require_once __DIR__.'/includes/config.php';

$tituloPagina = 'Perfil';


$contenidoPrincipal = '';

$MostrarFormulariosMatches = mostrarMatches();

$rutaApp = RUTA_APP;


if(isset( $_SESSION['id_match'])){
    $match_seleccionado = $_SESSION['id_match'];
}
else{
    $match_seleccionado = '';
}

    $contenidoPrincipal = <<<EOS
    <div class="initBox">

        <h1 class="element tituloPerfil">MI PERFIL</h1>       
        <div class="listaProyectos">
            <h3 class="element ListaPerfil">Lista de matches por confirmar:</h3>   
            $MostrarFormulariosMatches
        </div>

    </div>
    EOS;

function mostrarMatches(){

    $html = '';

    $listaMatches = es\ucm\fdi\aw\Matches::obtenerTotalMatchesSinConfirmar();

    $numfilas = sizeof($listaMatches);
    $id = 0;
    $i = 0;

    $html = '<div class="box"> <div class="match" name="match" id="match">';

    //$datos = '';

    while ($numfilas > $i){

        $datos = array(
            "listaMatches" => $listaMatches,
            "id_match" => $i
        );

        $form = new es\ucm\fdi\aw\FormularioMatchPerfil($datos);

       

        $htmlFormAceptarMatch = $form->gestiona2($datos);

        $html .= $htmlFormAceptarMatch;

        $i = $i + 1;

    }

    return $html;
}    

require __DIR__.'/includes/vistas/plantillas/plantillaPerfilNegociador.php';