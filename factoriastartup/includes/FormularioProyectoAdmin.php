<?php
namespace es\ucm\fdi\aw;

class FormularioProyectoAdmin extends Formulario
{
    public function __construct()
    {
        parent::__construct('formProyecto', ['urlRedireccion' => 'ProyectosMostrar.php', 'enctype'=> 'multipart/form-data']);
    }

    protected function generaCamposFormulario(&$datos)
    {
        $nombre = $datos['nombre'] ?? '';
        $sector = $datos['sector'] ?? '';
        $short_description = $datos['short_description'] ?? '';
        $description = $datos['description'] ?? '';
        $needs = $datos['needs'] ?? '';
        $img = $datos['img'] ?? '';

        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['nombre', 'sector', 'short_description', 'description', 'needs', 'img'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
            $htmlErroresGlobales
            <div class="formulario">                          
                    <p class="aviso">
                    <span class="obligatorio"> * </span>Los campos son obligatorios.
                    </p> 
                    
                    <label for="nombre">Nombre del proyecto:</label>
                    <input type="text" name="nombre" required="obligatorio" name="archivo" value="$nombre" />
                    {$erroresCampos['nombre']}

                    <label for="sector">Sector del proyecto:</label>
                    <input type="text" name="sector" required="obligatorio" name="archivo" value="$sector" />
                    {$erroresCampos['sector']}

                    <label for="short_description">Descripción corta del Proyecto:</label>
                    <textarea name="short_description"  value="$short_description" /></textarea>
                    {$erroresCampos['short_description']}

                    <label for="description">Descripción:</label>
                    <textarea name="description" value="$description" /></textarea>
                    {$erroresCampos['description']}

                    <label for="needs">Descripción de las necesidades:</label>
                    <textarea name="needs"  value="$needs" /></textarea>
                    {$erroresCampos['needs']}

                    <label for="img">Imagen:</label>
                    <input type="file" name="img" value="$img"/>
                    {$erroresCampos['img']}

                    <div class="botonn">
                    <button type="submit" name="crearProyecto">Crear proyecto</button>
                    </div>
                             
                </form>

                    
            </div>  
                    
    EOF;
    return $html;

    }


    protected function procesaFormulario(&$datos){
        
        $this->errores = [];

        $nombre = trim($datos['nombre'] ?? '');
        $nombre = filter_var($nombre, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( empty($nombre) || mb_strlen($nombre) < 5 ) {
            $this->errores['nombre'] = "El nombre tiene que tener una longitud de al menos 5 caracteres.";
        }

        $sector = trim($datos['sector'] ?? '');
        $sector = filter_var($sector, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( empty($sector) || mb_strlen($sector) < 5 ) {
            $this->errores['sector'] = "El sector tiene que tener una longitud de al menos 5 caracteres.";
        }

        $short_description = trim($datos['short_description'] ?? '');
        $short_description = filter_var($short_description, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( empty($short_description) || mb_strlen($short_description) < 5 ) {
            $this->errores['short_description'] = "El short_description tiene que tener una longitud de al menos 5 caracteres.";
        }
        if ( mb_strlen($short_description) > 500 ) {
            $this->errores['short_description'] = "El short_description no puede tener una longitud de más de 500 caracteres.";
        }

        $description = trim($datos['description'] ?? '');
        $description = filter_var($description, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( empty($description) || mb_strlen($description) < 5 ) {
            $this->errores['description'] = "El description tiene que tener una longitud de al menos 5 caracteres.";
        }
        
        $needs = trim($datos['needs'] ?? '');
        $needs = filter_var($needs, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( empty($needs) || mb_strlen($needs) < 5 ) {
            $this->errores['needs'] = "El needs tiene que tener una longitud de al menos 5 caracteres.";
        }
        
        /*$img = $datos['img'] ?? null;*/
        
       //Control de errores de la imagen
        $errorArchivo = $_FILES['img']['error'] == UPLOAD_ERR_OK && count($_FILES) == 1;

        if (!$errorArchivo) {
            $this->errores['img'] = 'Error al subir el archivo';
        }
        else{
            $nombreFoto = $_FILES['img']['name'];

            /* 1.a) Valida el nombre del archivo */
            $ok = Imagen::check_file_uploaded_name($nombreFoto) && Imagen::check_file_uploaded_length($nombreFoto);

            // 1.b) Sanitiza el nombre del archivo (elimina los caracteres que molestan)
            $ok = Imagen::sanitize_file_uploaded_name($nombreFoto);

            /* 2. comprueba si la extensión está permitida */
            $extension = pathinfo($nombreFoto, PATHINFO_EXTENSION);
            $ok = $ok && in_array($extension, Imagen::EXTENSIONES_PERMITIDAS);

            /* 3. comprueba el tipo mime del archivo corresponde a una imagen image*/
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->file($_FILES['img']['tmp_name']);
            $ok = preg_match('/image\/*./', $mimeType);

            //$pos = strpos($mimeType, '/');
            //$extension = substr($extension, $pos + 1);
            //var_dump($subMimeType);
            //exit(0);


            $mimeType = $finfo->file($_FILES['img']['tmp_name']);

            if (!$ok) {
                $this->errores['img'] = 'El archivo tiene un nombre o tipo no soportado';
            }
        } 
        

        if (count($this->errores) === 0) {

            //SUBIR IMAGEN
            $tmp_name = $_FILES['img']['tmp_name']; 
            $imagen = Imagen::crea('', $nombreFoto, $mimeType, "fotosProyectos");
            $imagen->guarda($imagen);
            $variableId = $imagen->getIdImagen();
            $carpeta = $imagen->getCarpeta();
            $fichero = "img/{$carpeta}/{$variableId}.{$extension}";
            $imagen->setRuta($fichero);
            $imagen->cambia();
            

            if (!move_uploaded_file($tmp_name, $imagen->getRuta())) {
                $this->errores['img'] = 'Error al mover el archivo';
            }

            
            
            $idUsuario = Usuario::buscaIdUsuario($_SESSION['nombreUsuario']);

            $proyecto = Proyecto::crearProyecto($idUsuario, $nombre, $sector, $short_description, $description, $needs, $imagen->getIdImagen());
            if (!$proyecto) {
                $this->errores['nombre'] = "El nombre de proyecto ya está asociado a otro proyecto.";
            } 
        }       
       
    }
}