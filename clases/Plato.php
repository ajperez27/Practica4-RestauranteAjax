<?php

class Plato {
    private $idPlato;
    private $nombre;
    private $descripcion;
    private $precio; 

    function __construct($idPlato = null, $nombre = null, $descripcion = null, $precio = null) {
        $this->idPlato = $idPlato;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
    }

    function set($datos, $inicio = 0) {
        $this->idPlato = $datos[0 + $inicio];
        $this->nombre = $datos[1 + $inicio];
        $this->descripcion = $datos[2 + $inicio];
        $this->precio = $datos[3 + $inicio];
    }

    function getIdPlato() {
        return $this->idPlato;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getPrecio() {
        return $this->precio;
    }

    function setIdPlato($idPlato) {
        $this->idPlato = $idPlato;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setPrecio($precio) {
        $this->precio = $precio;
    }
    
      /**
     * Devuelve un objeto en formato JSON
     * @access public
     * @return int 
     */
    public function getJSON() {
        $prop = get_object_vars($this);
        $resp = "{ ";
        foreach ($prop as $key => $value) {
            $resp.= '"' . $key . '":' . json_encode(htmlspecialchars_decode($value)) . ',';
        }
        $resp = substr($resp, 0, -1) . "}";
        return $resp;
    }
}
?>
