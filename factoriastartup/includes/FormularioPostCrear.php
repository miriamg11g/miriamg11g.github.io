<?php
namespace es\ucm\fdi\aw;

require_once __DIR__.'/Formulario.php';
use es\ucm\fdi\aw\src\Utils;

class FormularioPostCrear extends Formulario {

    public function __construct() {
        parent::__construct('formCrearPost', ['urlRedireccion' => 'PostMostrar.php', 'action' => '', 'enctype' => 'multipart/form-data']);
    }

    protected function generaCamposFormulario(&$datosIniciales) {
        
        $titulo = $datos['titulo'] ?? '';
        $shortDescription = $datos['shortDescription'] ?? '';
        $description = $datos['description'] ?? '';
        $img = $datos['img'] ?? '';
        /*
        $mensajeError = '';
        if (in_array("El título del post debe tener al menos 5 caracteres.", $this->errores)) {
            $mensajeError = '<span class="error">El título del post debe tener al menos 5 caracteres. Vuélvelo a intentar</span>';
        }else if(in_array("No se ha podido crear el post.", $this->errores)) {
            $mensajeError = '<span class="error">No se ha podido crear el post.</span>';
        }else if(in_array("La descripción corta debe tener al menos 10 caracteres.", $this->errores)) {
            $mensajeError = '<span class="error">La descripción corta debe tener al menos 10 caracteres.</span>';
        }else if(in_array("La descripción completa debe tener al menos 50 caracteres.", $this->errores)) {
            $mensajeError = '<span class="error">La descripción completa debe tener al menos 50 caracteres.</span>';
        }*/

        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['titulo', 'shortDescription', 'description', 'img'], $this->errores, 'span', array('class' => 'error'));


        $html = <<<EOF
        <div class="formulario">
                <p class="aviso">
                <span class="obligatorio"> * </span>Los campos son obligatorios.
                </p> 
                <br>
                
                <label>Título:</label>
                <input type="text" name="titulo" placeholder="Escribe el título del post" value="$titulo" />
                {$erroresCampos['titulo']}

                <label>Descripción corta:</label>
                <input type="text" name="shortDescription" placeholder="Escribe una descripción corta" value="$shortDescription" />
                {$erroresCampos['shortDescription']}

                <label>Descripción completa:</label>
                <textarea name="description" placeholder="Escribe la descripción completa">$description</textarea>
                {$erroresCampos['description']}

                <label for="img">Imagen:</label>
                <input type="file" name="img" value="$img"/>
                {$erroresCampos['img']}

                <div class="botonn">
                    <button type="submit" name="crearProyecto">Crear post</button>
                </div>
           
        </div>
        EOF;

        return $html;
    }

    protected function procesaFormulario(&$datos) {
        
        $this->errores = [];

        $titulo = trim($datos['titulo'] ?? '');
        $titulo = filter_var($titulo, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( empty($titulo) || mb_strlen($titulo) < 5 ) {
            $this->errores['titulo'] = "El titulo tiene que tener una longitud de al menos 5 caracteres.";
        }

        $shortDescription = trim($datos['shortDescription'] ?? '');
        $shortDescription = filter_var($shortDescription, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( empty($shortDescription) || mb_strlen($shortDescription) < 5 ) {
            $this->errores['shortDescription'] = "El shortDescription tiene que tener una longitud de al menos 5 caracteres.";
        }

        $description = trim($datos['description'] ?? '');
        $description = filter_var($description, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ( empty($description) || mb_strlen($description) < 5 ) {
            $this->errores['description'] = "El description tiene que tener una longitud de al menos 5 caracteres.";
        }
        
        
        
        
        
        //$result = array();

      
        //Control de errores de la imagen

        if (!empty($_FILES['img'])){
            
            $errorArchivo = $_FILES['img']['error'] == UPLOAD_ERR_OK && count($_FILES) == 1;

            if (!$errorArchivo) {
                $this->errores['img'] = 'Error al subir el archivo';
            }
            else{
                $nombreFoto = $_FILES['img']['name'];

                $ok = Imagen::check_file_uploaded_name($nombreFoto) && Imagen::check_file_uploaded_length($nombreFoto);

                $ok = Imagen::sanitize_file_uploaded_name($nombreFoto);

                $extension = pathinfo($nombreFoto, PATHINFO_EXTENSION);
                $ok = $ok && in_array($extension, Imagen::EXTENSIONES_PERMITIDAS);

                $finfo = new \finfo(FILEINFO_MIME_TYPE);
                $mimeType = $finfo->file($_FILES['img']['tmp_name']);
                $ok = preg_match('/image\/*./', $mimeType);

                $mimeType = $finfo->file($_FILES['img']['tmp_name']);

                if (!$ok) {
                    $this->errores['img'] = 'El archivo tiene un nombre o tipo no soportado';
                }
            } 
        }

        if (count($this->errores) === 0) {
            
            //SUBIR IMAGEN
            if (!empty($_FILES['img'])){

                $tmp_name = $_FILES['img']['tmp_name']; 
                $imagen = Imagen::crea('', $nombreFoto, $mimeType, "fotosPost");
                $imagen->guarda($imagen);
                $variableId = $imagen->getIdImagen();
                $carpeta = $imagen->getCarpeta();
                $fichero = "img/{$carpeta}/{$variableId}.{$extension}";
                $imagen->setRuta($fichero);
                $imagen->cambia();
                
                if (!move_uploaded_file($tmp_name, $imagen->getRuta())) {
                    $this->errores['img'] = 'Error al mover el archivo';
                }
            }   


            $idUsuario = Usuario::buscaIdUsuario($_SESSION['nombreUsuario']);
            

            //$post = new Post(null, $titulo, $shortDescription, $description);
            $post= Post::crearPost($_SESSION['id_usuario'], $titulo, $shortDescription, $description, $imagen->getIdImagen());
            //Post::crearPost($post);
            if ( !$post ) {
                $result[] = "No se ha podido crear el post.";
            } else {
                $result[] = "Creado el post.";
                header('Location: recursos.php');
            }
        }

       

        return $result;
    }
}
