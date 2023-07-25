<?php
namespace es\ucm\fdi\aw;

$resultado = Proyecto::obtenerTotalSectores();

?>
    
    <aside id="sideBarIzq">

        <div class="sidebar bar-block light-grey" style="width:25%">
            <div class="container dark-grey">Sectores</div>
            
            <?php

                $html  = '';
                $html .= <<<EOF
                    <a href="proyectosMostrar.php?sector=ALL" class="bar-item button blue">Todos los sectores</a>
                EOF;
            ?>


<?php
        foreach ($resultado as $fila) {

            $sector = $fila['sector'];
            if (is_numeric($sector)) {
                $sectorNombre = Sector::obtenerSectorPorNum($sector);
            } else {
                $sectorNombre = $sector;
            }

            $numProyectos = $fila['numProyectos'];


            $html .= <<<EO
                <a href="proyectosMostrar.php?sector='$sector'" class="bar-item button">$sectorNombre<span class="tag blue right margin-right">$numProyectos</span></a>
            EO;
        
        }
        
        echo $html;

        ?>

        </div>

    </aside>


<?php
