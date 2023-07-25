<?php

namespace es\ucm\fdi\aw;


class Matches{

    private $id_match;
    private $id_busqueda_colab;
    private $id_busqueda_proy;
    private $confirmado;


    public function __construct($id_match, $confirmado, $id_busqueda_colab, $id_busqueda_proy)
    {
        $this->id_match = $id_match;
        $this->confirmado = $confirmado;
        $this->id_busqueda_colab = $id_busqueda_colab;
        $this->id_busqueda_proy = $id_busqueda_proy;

    }

    public static function existe_match($id_busqueda_colab, $id_busqueda_proy){

        //MIRAR SI ESTA BÚSQUEDA YA SE HA REALIZADO Y SE ENCUENTRA EN LA BBDD
        $conn = Aplicacion::getInstance()->getConexionBd();
        $result = false;

        $query = "SELECT * FROM matches 
        WHERE id_busqueda_colab = $id_busqueda_colab 
        AND id_busqueda_proy = $id_busqueda_proy;";
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();

        if($fila){
            $result = true;
        }

        return $result;
    }

    public static function hacer_match($busqueda_colab, $busqueda_proyecto){
    //AÑADIR EN LA BBDD EL MATCH
    $conn = Aplicacion::getInstance()->getConexionBd();
    $result = false;

        $query = sprintf("INSERT INTO matches(id_match, confirmadoProy, id_busqueda_colab, id_busqueda_proy)  VALUES (NULL, '0', '%s', '%s')",
            $conn->real_escape_string($busqueda_colab['id_busqueda']),
            $conn->real_escape_string($busqueda_proyecto['id_busqueda'])
        );

        if ($conn->query($query)) {
            $result = true;
        } else {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
        }

    return $result;

    }

    public static function analizarSiMatch($busqueda_colab, $busqueda_proyecto){

        $hacerMatch = false;

        if($busqueda_colab['obra_y_servicio'] && $busqueda_proyecto['obra_y_servicio']){
            $hacerMatch = true;
        }
        if($busqueda_colab['pacto_a_futuro'] && $busqueda_proyecto['pacto_a_futuro']){
            $hacerMatch = true;
        }
        if(abs($busqueda_colab['porcentaje_empresa'] - $busqueda_proyecto['porcentaje_empresa']) <= 10){
            $hacerMatch = true;
        }
        if(abs($busqueda_colab['porcentaje_ventas'] - $busqueda_proyecto['porcentaje_ventas']) <= 10){
            $hacerMatch = true;
        }
        
        return $hacerMatch;
    }

    public static function obtenerNumMatchesSinConfirmar($id_usuario){
        $conn = Aplicacion::getInstance()->getConexionBd();

        $query = "SELECT COUNT(*) AS numMatches
        FROM matches AS mt
        LEFT JOIN busqueda_colaboradores AS colab
        ON mt.id_busqueda_colab=colab.id_busqueda
        LEFT JOIN busqueda_proyectos AS proy
        ON mt.id_busqueda_proy=proy.id_busqueda
        WHERE colab.id_usuario = $id_usuario AND mt.confirmadoColab = '0' AND mt.confirmadoProy != '2'
        OR proy.id_usuario = $id_usuario AND mt.confirmadoProy = '0' AND mt.confirmadoColab != '2'";

        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();

        return $fila['numMatches'];

    }

////////////SE USA??? /////////////////////////////////////////////////////////////////////

    
/*
    public static function obtenerTotalMatchesSinConfirmar($id_usuario) {
        $matches = array();
    
        $conn = Aplicacion::getInstance()->getConexionBd();
    
        $query = "SELECT *
                FROM matches AS mt
                LEFT JOIN busqueda_colaboradores AS colab
                ON mt.id_busqueda_colab=colab.id_busqueda
                LEFT JOIN busqueda_proyectos AS proy
                ON mt.id_busqueda_proy=proy.id_busqueda
                WHERE colab.id_usuario = $id_usuario AND mt.confirmadoColab = '0'
                OR proy.id_usuario = $id_usuario AND mt.confirmadoProy = '0'
                ORDER BY mt.id_match ASC";
                  
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
        
        while ($fila) {
            array_push($matches, $fila);
            $fila = $rs->fetch_assoc();
        }
    
        return $matches;
    }*/
/*
    public static function obtenerTotalMatchesConfirmados($id_usuario) {
        $matches = array();
    
        $conn = Aplicacion::getInstance()->getConexionBd();
    
        $query = "SELECT m.* 
                  FROM matches m 
                  INNER JOIN busqueda_colaboradores bc ON m.id_busqueda_colab = bc.id_busqueda 
                  WHERE m.confirmadoProy = 1 AND $id_usuario = bc.id_usuario 
                  ORDER BY m.id_match ASC";
                  
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
        
        while ($fila) {
            array_push($matches, $fila);
            $fila = $rs->fetch_assoc();
        }
    
        return $matches;
    }
    */


    public static function obtenerNumTotalMatchesConfirmados($id_usuario) {
        $conn = Aplicacion::getInstance()->getConexionBd();
    
        $query = "SELECT COUNT(*) as total_matches
                  FROM matches m 
                  INNER JOIN busqueda_colaboradores bc ON m.id_busqueda_colab = bc.id_busqueda 
                  WHERE m.confirmadoProy = 1 AND $id_usuario = bc.id_usuario";
    
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
    
        $total_matches = $fila['total_matches'];
    
        return $total_matches;
    }
    
    public static function obtenerNumTotalMatchesSinConfirmar($id_usuario) {
        $conn = Aplicacion::getInstance()->getConexionBd();
    
        $query = "SELECT COUNT(*) as total_matches
                  FROM matches m 
                  INNER JOIN busqueda_colaboradores bc ON m.id_busqueda_colab = bc.id_busqueda 
                  WHERE m.confirmadoProy = 0 AND $id_usuario = bc.id_usuario";
    
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
    
        $total_matches = $fila['total_matches'];
    
        return $total_matches;
    }

    public static function obtenerNumTotalMatchesUsuario($id_usuario) {
        $conn = Aplicacion::getInstance()->getConexionBd();
    
        $query = "SELECT COUNT(*) as total_matches
                  FROM matches m 
                  INNER JOIN busqueda_colaboradores bc ON m.id_busqueda_colab = bc.id_busqueda 
                  WHERE m.confirmadoProy IN (0, 1) AND $id_usuario = bc.id_usuario";
    
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
    
        $total_matches = $fila['total_matches'];
    
        return $total_matches;
    }
    

/*
   public static function hacer_match()
{
    $conn = Aplicacion::getInstance()->getConexionBd();
    $consulta = "INSERT INTO matches (id_busqueda_colab, id_busqueda_proy)
        SELECT bc.id_busqueda, bp.id_busqueda
        FROM busqueda_colaboradores bc
        INNER JOIN busqueda_proyectos bp 
        ON ABS(bc.porcentaje_ventas - bp.porcentaje_ventas) < 10 
           AND ABS(bc.porcentaje_beneficios - bp.porcentaje_beneficios) < 10
        WHERE NOT EXISTS (
            SELECT 1 FROM matches m
            WHERE m.id_busqueda_colab = bc.id_busqueda
            AND m.id_busqueda_proy = bp.id_busqueda
        )";


    mysqli_query($conn, $consulta);
    
    $id_match = mysqli_insert_id($conn);
    $id_busqueda_colab = mysqli_query($conn, "SELECT id_busqueda_colab FROM matches WHERE id_match = '$id_match'")->fetch_object()->id_busqueda_colab;
    $id_busqueda_proy = mysqli_query($conn, "SELECT id_busqueda_proy FROM matches WHERE id_match = '$id_match'")->fetch_object()->id_busqueda_proy;


    return array('id_busqueda_colab' => $id_busqueda_colab, 'id_busqueda_proy' => $id_busqueda_proy);
}
*/
	
    public static function seConfirmaProy($id_match) {
        $conn = Aplicacion::getInstance()->getConexionBd();
    
        $consulta = "UPDATE matches SET confirmadoProy = 1 WHERE id_match = $id_match";
    
        if (!$conn->query($consulta)) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
    
        return true;
    }

    public static function seConfirmaColab($id_match) {
        $conn = Aplicacion::getInstance()->getConexionBd();
    
        $consulta = "UPDATE matches SET confirmadoColab = 1 WHERE id_match = $id_match";
    
        if (!$conn->query($consulta)) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
    
        return true;
    }


    public static function seDesconfirma($id_match) {
        $conn = Aplicacion::getInstance()->getConexionBd();
    
        $consulta = "UPDATE matches SET confirmadoProy = 2 WHERE id_match = $id_match";
    
        if (!$conn->query($consulta)) {
            error_log("Error BD ({$conn->errno}): {$conn->error}");
            return false;
        }
    
        return true;
    }
    
///////////////////

    public static function obtenerTotalMatchesSinConfirmar($id_usuario){
        $html = "";
        $matches = array();    
        $conn = Aplicacion::getInstance()->getConexionBd();
    
        $query = "SELECT mt.id_match, mt.confirmadoProy, mt.confirmadoColab, proy.id_usuario AS id_usuarioProy, colab.id_usuario AS id_usuarioColab, colab.id_proyecto, colab.porcentaje_empresa, colab.porcentaje_ventas, colab.obra_y_servicio, colab.pacto_a_futuro, colab.id_aptitud
        FROM matches AS mt
        LEFT JOIN busqueda_colaboradores AS colab
        ON mt.id_busqueda_colab=colab.id_busqueda
        LEFT JOIN busqueda_proyectos AS proy
        ON mt.id_busqueda_proy=proy.id_busqueda
        WHERE proy.id_usuario = $id_usuario 
        AND mt.confirmadoProy = '0'
        AND mt.confirmadoColab != '2'
        ";
                  
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
        
        while ($fila) {
            array_push($matches, $fila);
            $fila = $rs->fetch_assoc();
        }
    
        $html = Matches::obtenerHtmlMatchProy($matches);

        $matches2 = array();

        $query = "SELECT mt.id_match, mt.confirmadoProy, mt.confirmadoColab, proy.id_usuario AS id_usuarioProy, colab.id_usuario AS id_usuarioColab, colab.id_proyecto, colab.porcentaje_empresa, colab.porcentaje_ventas, colab.obra_y_servicio, colab.pacto_a_futuro, colab.id_aptitud
        FROM matches AS mt
        LEFT JOIN busqueda_colaboradores AS colab
        ON mt.id_busqueda_colab=colab.id_busqueda
        LEFT JOIN busqueda_proyectos AS proy
        ON mt.id_busqueda_proy=proy.id_busqueda
        WHERE colab.id_usuario = $id_usuario 
        AND mt.confirmadoProy != '2'
        AND mt.confirmadoColab = '0'
        ";
                  
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
        
        while ($fila) {
            array_push($matches2, $fila);
            $fila = $rs->fetch_assoc();
        }

        $html .= Matches::obtenerHtmlMatchColab($matches2);

        return $html;
    }

    public static function obtenerTotalMatchesConfirmados($id_usuario){
        $html = "";
        $matches = array();    
        $conn = Aplicacion::getInstance()->getConexionBd();
    
        $query = "SELECT mt.id_match, mt.confirmadoProy, mt.confirmadoColab, proy.id_usuario AS id_usuarioProy, colab.id_usuario AS id_usuarioColab, proy.id_proyecto, proy.porcentaje_empresa, proy.porcentaje_ventas, proy.obra_y_servicio, proy.pacto_a_futuro, colab.id_aptitud
        FROM matches AS mt
        LEFT JOIN busqueda_colaboradores AS colab
        ON mt.id_busqueda_colab=colab.id_busqueda
        LEFT JOIN busqueda_proyectos AS proy
        ON mt.id_busqueda_proy=proy.id_busqueda
        WHERE proy.id_usuario = $id_usuario 
        AND mt.confirmadoProy = '1'
        AND mt.confirmadoColab != '2'
        ";
                  
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
        
        while ($fila) {
            array_push($matches, $fila);
            $fila = $rs->fetch_assoc();
        }
    
        //return $matches;

        $html .= Matches::obtenerHtmlMatchProy($matches);

        $matches2 = array();

        $query = "SELECT mt.id_match, mt.confirmadoProy, mt.confirmadoColab, proy.id_usuario AS id_usuarioProy, colab.id_usuario AS id_usuarioColab, colab.id_proyecto, colab.porcentaje_empresa, colab.porcentaje_ventas, colab.obra_y_servicio, colab.pacto_a_futuro, colab.id_aptitud
        FROM matches AS mt
        LEFT JOIN busqueda_colaboradores AS colab
        ON mt.id_busqueda_colab=colab.id_busqueda
        LEFT JOIN busqueda_proyectos AS proy
        ON mt.id_busqueda_proy=proy.id_busqueda
        WHERE colab.id_usuario = $id_usuario 
        AND mt.confirmadoProy != '2'
        AND mt.confirmadoColab = '1'
        ";
                  
        $rs = $conn->query($query);
        $fila = $rs->fetch_assoc();
        
        while ($fila) {
            array_push($matches2, $fila);
            $fila = $rs->fetch_assoc();
        }

        $html .= Matches::obtenerHtmlMatchColab($matches2);

        return $html;
    }

    private static function obtenerHtmlMatchProy($matches){
        if (empty($matches)) {
            return ''; // Return an empty string if there are no matches
        }
        $contenido = '';

        foreach ($matches as $fila) {

            $id_match = $fila['id_match'];
            $id_usuarioColab = $fila['id_usuarioColab'];
            $id_proyecto = $fila['id_proyecto'];
            $id_aptitud = $fila['id_aptitud'];
            $porcentaje_empresa = $fila['porcentaje_empresa'];
            $porcentaje_ventas = $fila['porcentaje_ventas'];
            $obra_y_servicio = $fila['obra_y_servicio'];
            $pacto_a_futuro = $fila['pacto_a_futuro'];
            $confimadoProy = $fila['confirmadoProy'];
            //$confirmado = $fila['confirmado'];
            //$descripcion = $fila['descripcion'];
            //$id_busqueda_colab = $fila['id_busqueda_colab'];
            //$id_busqueda_proy = $fila['id_busqueda_proy'];
            //$id_proyecto = BusquedaColaboradores::idBusquedaColab($id_match);
            $nombreUserColab = Usuario::buscaNombreUsuarioPorId($id_usuarioColab);
            $nombreAptitud = Aptitudes::obtenerAptitudPorNum($id_aptitud);
            $proyecto=Proyecto::obtenerProyectosPorId($fila['id_proyecto']);
            $nombreProyecto = $proyecto[0]['nombre'];

            $opciones = '';
            if($porcentaje_empresa > 0){
                $opciones .= "<p>Un $porcentaje_empresa% de su empresa.</p>";
            }
            if($porcentaje_ventas > 0){
                $opciones .= "<p>El $porcentaje_ventas% de las ventas.</p>";
            }
            if($obra_y_servicio){
                $opciones .= "<p>Trabajar por obra y servicio.</p>";
            }
            if($pacto_a_futuro){
                $opciones .= "<p>Pactar en un futuro la negociación.</p>";
            }


            $contenido.= <<<EO
            <div class="match">
                
                <div class="fila">
                    <div class="columna">
                        <h2>¡Tienes un match con el usuario $nombreUserColab!</h2>
                        <h3>Está interesado en que participes en su proyecto <a href="proyectosMostrarCompleto.php?id=$id_proyecto" >$nombreProyecto</a> porque necesita tus habilidades de $nombreAptitud.</h3>
                        <p>A cambio estaría dispuesto a ofrecer alguna de las siguientes opciones:</p>
                        $opciones
                    </div>
                </div>
            EO;

            if($confimadoProy == '0'){
            $contenido.= <<<EO
                <div class="filaTitulo">

                    <div class="emoticonos">
                        <a href="matchConfirmarProy.php?id_match=$id_match" >
                            <div class="tick">
                               Aceptar negociación
                            </div>
                        </a>
                    </div>   
                    <div class="emoticonos"> 
                        <a href="matchEliminar.php?id_match=$id_match" >
                            <div class="tick">
                                Rechazar
                            </div>
                        </a>
                        
                    </div>
                </div>
            EO;
            }

            $contenido.= <<<EO
            </div>
            EO;
        }

        return $contenido;

    }

    private static function obtenerHtmlMatchColab($matches){
        if (empty($matches)) {
            return ''; // Return an empty string if there are no matches
        }
        $contenido = '';

        foreach ($matches as $fila) {

            $id_match = $fila['id_match'];
            $id_usuarioColab = $fila['id_usuarioColab'];
            $id_proyecto = $fila['id_proyecto'];
            $id_aptitud = $fila['id_aptitud'];
            $porcentaje_empresa = $fila['porcentaje_empresa'];
            $porcentaje_ventas = $fila['porcentaje_ventas'];
            $obra_y_servicio = $fila['obra_y_servicio'];
            $pacto_a_futuro = $fila['pacto_a_futuro'];
            $confimadoColab = $fila['confirmadoColab'];
            //$confirmado = $fila['confirmado'];
            //$descripcion = $fila['descripcion'];
            //$id_busqueda_colab = $fila['id_busqueda_colab'];
            //$id_busqueda_proy = $fila['id_busqueda_proy'];
            //$id_proyecto = BusquedaColaboradores::idBusquedaColab($id_match);
            $nombreUserColab = Usuario::buscaNombreUsuarioPorId($id_usuarioColab);
            $nombreAptitud = Aptitudes::obtenerAptitudPorNum($id_aptitud);
            $proyecto=Proyecto::obtenerProyectosPorId($fila['id_proyecto']);
            $nombreProyecto = $proyecto[0]['nombre'];

            $opciones = '';
            if($porcentaje_empresa > 0){
                $opciones .= "<p>Un $porcentaje_empresa% de su empresa.</p>";
            }
            if($porcentaje_ventas > 0){
                $opciones .= "<p>El $porcentaje_ventas% de las ventas.</p>";
            }
            if($obra_y_servicio){
                $opciones .= "<p>Trabajar por obra y servicio.</p>";
            }
            if($pacto_a_futuro){
                $opciones .= "<p>Pactar en un futuro la negociación.</p>";
            }


            $contenido.= <<<EO
            <div class="match">
                
                <div class="fila">
                    <div class="columna">
                        <h2>¡Tienes un match con el usuario $nombreUserColab!</h2>
                        <h3>Está interesado en participar en tu proyecto <a href="proyectosMostrarCompleto.php?id=$id_proyecto" >$nombreProyecto</a> usando sus habilidades de $nombreAptitud.</h3>
                        <p>A cambio demanda alguna de las siguientes opciones:</p>
                        $opciones
                    </div>
                </div>
            EO;

            if($confimadoColab == '0'){
            $contenido.= <<<EO
                <div class="filaTitulo">

                    <div class="emoticonos">
                        <a href="matchConfirmarColab.php?id_match=$id_match" >
                            <div class="tick">
                               Aceptar negociación
                            </div>
                        </a>
                    </div>   
                    <div class="emoticonos"> 
                        <a href="matchEliminar.php?id_match=$id_match" >
                            <div class="tick">
                                Rechazar
                            </div>
                        </a>
                        
                    </div>
                </div>
            EO;
            }

            $contenido.= <<<EO
            </div>
            EO;
        }

        return $contenido;

    }
    
}
