<?php
namespace es\ucm\fdi\aw;

class FormularioProyectoEliminar extends Formulario
{
    public function __construct()
    {
        parent::__construct('formEliminarProyecto', ['urlRedireccion' => 'procesoEliminarProyecto.php']);
    }

    protected function generaCamposFormulario(&$datos)
    {
        $html = <<<EOF
        <form id="formEliminarProyecto" method="post">
            <h2>Eliminar proyecto</h2>
            <label for="id_proyecto">Nombre del proyecto:</label>
            <input type="text" name="id_proyecto" required>
            <button type="submit">Eliminar proyecto</button>
        </form>
EOF;

        return $html;
    }

    protected function procesaFormulario(&$datos)
    {
        // Eliminar el proyecto de la base de datos
        Proyecto::eliminarProyectoPorNombre($datos['id_proyecto']);
   
    }
    
}
