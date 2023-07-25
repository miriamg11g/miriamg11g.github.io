<?php
namespace es\ucm\fdi\aw;

class FormularioNegociadorColaborarEnProyecto extends Formulario
{
    private $fila;

    public function __construct($fila) {

       $this->fila = $fila;
       parent::__construct('formBusqueda', [ 'action' => '', 'enctype' => 'multipart/form-data']);
    }
    
    protected function generaCamposFormulario(&$datos)
    {

        $id_proyecto = $this->fila['id_proyecto'];
        $nombre = $this->fila['nombre'];
        $short_description = $this->fila['short_description'];
        $sector = $this->fila['sector'];
        $ruta = Imagen::getRutaFromBBDD($this->fila['imagen']);
        

        $html = <<<EOF
            <div class="proyecto">
                <div class="filaTitulo">
                <h2>$nombre</h2>
                </div>

                <div class="fila">
                    <div class="columnaImg">
                        <img src="$ruta" alt="ImgProject">
                    </div>
                    <div class="columna">
                        <p>$short_description</p>
                        <a href="proyectosMostrarCompleto.php?id=$id_proyecto">Leer más</a>
                    </div>
                </div>

                <div class="boton">
                    <button class="boton" type="submit" value="$id_proyecto" name="id_proyecto">Seleccionar proyecto</button>
                </div>
            </div>
            EOF;
            return $html;
    }
    

    protected function procesaFormulario(&$datos){

         $id_proyecto = $datos['id_proyecto'];

         //$_SESSION['proyecto']=$id_proyecto;
         if (!$id_proyecto) {
            $this->errores['proyecto'] = 'No ha seleccionado ningún sector.';
        }
        else{        
            header("Location: negociadorProcesarBusquedaColaborarPorProyecto.php?proyecto=$id_proyecto");
        }
    }

    

}