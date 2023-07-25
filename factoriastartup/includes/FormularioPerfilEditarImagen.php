<?php
namespace es\ucm\fdi\aw;

class FormularioPerfilEditarImagen extends Formulario
{
    public function __construct()
    {
        parent::__construct('formBuscador', ['urlRedireccion' => 'perfil.php', 'enctype'=> 'multipart/form-data']);
    }

    protected function generaCamposFormulario(&$datos)
    {
        $infoUser = Usuario::buscaInfoUsuario($_SESSION['id_usuario']);

        $ruta = Imagen::getRutaFromBBDD($infoUser->getImg());
        if(!$ruta) $ruta= RUTA_IMGS .'/fotosUsers/user.png';

        $img = $datos['img'] ?? '';
        
        $htmlErroresGlobales = self::generaListaErroresGlobales($this->errores);
        $erroresCampos = self::generaErroresCampos(['img'], $this->errores, 'span', array('class' => 'error'));

        $html = <<<EOF
            $htmlErroresGlobales
            <div class="info"> 
                <div class="columnaImg">
                    <div class="img">
                        <img src=$ruta alt="ImgUser">
                        </div>
                </div>                         
                    
                <div class="fila">
                <label for="img">Imagen:</label>
                <input type="file" name="img" value="$img"/>
                {$erroresCampos['img']}
                </div>                
                
                <button type="submit">Aceptar</button>
                                             
                </form>                    
            </div>                      
        EOF;

    return $html;
    }


    protected function procesaFormulario(&$datos){
        
        $this->errores = [];

        if (!empty($_FILES['img'])){

            //Control de errores de la imagen
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

                //$pos = strpos($mimeType, '/');
                //$extension = substr($extension, $pos + 1);
                //var_dump($subMimeType);
                //exit(0);


                $mimeType = $finfo->file($_FILES['img']['tmp_name']);

                if (!$ok) {
                    $this->errores['img'] = 'El archivo tiene un nombre o tipo no soportado';
                }
            } 
        }

        if (count($this->errores) === 0) {

            
            if (!empty($_FILES['img'])){
                //SUBIR IMAGEN
                $tmp_name = $_FILES['img']['tmp_name']; 
                $imagen = Imagen::crea('', $nombreFoto, $mimeType, "fotosUsers");
                $imagen->guarda($imagen);
                $variableId = $imagen->getIdImagen();
                $carpeta = $imagen->getCarpeta();
                $fichero = "img/{$carpeta}/{$variableId}.{$extension}";
                $imagen->setRuta($fichero);
                $imagen->cambia();
            

                if (!move_uploaded_file($tmp_name, $imagen->getRuta())) {
                    $this->errores['img'] = 'Error al mover el archivo';
                }
                //UPDATE IMG
            }
        }  
    }
}
