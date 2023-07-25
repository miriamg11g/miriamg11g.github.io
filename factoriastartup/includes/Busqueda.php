<?php
namespace es\ucm\fdi\aw;

abstract class Busqueda {

    protected $id_usuario;
    protected $porcentaje_empresa;
    protected $porcentaje_ventas;
    protected $obra_y_servicio;
    protected $pacto_a_futuro;

    public function __construct($id_usuario, $porcentaje_empresa, $porcentaje_ventas, $obra_y_servicio, $pacto_a_futuro) {
        $this->id_usuario = $id_usuario;
        $this->porcentaje_empresa = $porcentaje_empresa;
        $this->porcentaje_ventas = $porcentaje_ventas;
        $this->obra_y_servicio = $obra_y_servicio;
        $this->pacto_a_futuro = $pacto_a_futuro;
    }

    /**
     * Mirar si se ha realizado una búsqueda de este tipo con anterioridad
     * 
     * @return array
     */
    abstract protected function existeBusqueda();

    /**
     * Insertar Búsqueda en sus respectivas tablas
     * 
     * @return string //id_aptitud o mensaje
     */
    abstract protected function insertarBusqueda();

}