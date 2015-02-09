<?php

/**
 * ClassFoto
 *
 * @version 1.01
 * @author Antonio Javier Pérez Medina
 * @license http://...
 * @copyright izvbycv
 * Esta clase contien los atributos y metodos de las Fotos
 */
class Foto {

    private $idFoto;
    private $idPlato;
    private $url;

    function __construct($idFoto = null, $idPlato = null, $url = "") {
        $this->idFoto = $idFoto;
        $this->idPlato = $idPlato;
        $this->url = $url;
    }

    /**
     * Asigna los datos de las fotos
     * @access public
     * @param array $datos int $inicio 
     */
    function set($datos, $inicio = 0) {
        $this->idFoto = $datos[1 + $inicio];
        $this->idPlato = $datos[0 + $inicio];
        $this->url = $datos[2 + $inicio];
    }

    /**
     * Devuelve la id de la casa
     * @access public
     * @return int idPlato
     */
    function getIdPlato() {
        return $this->idPlato;
    }

    /**
     * Devuelve la id de la foto
     * @access public
     * @return int idFoto
     */
    function getIdFoto() {
        return $this->idFoto;
    }

    /**
     * Devuelve la url de la foto
     * @access public
     * @return string idFoto
     */
    function getUrl() {
        return $this->url;
    }

    /**
     * Asigna la id del plato 
     * @access public
     * @param int idPlato 
     */
    function setIdPlato($idPlato) {
        $this->idPlato = $idPlato;
    }

    /**
     * Asigna la id de la foto 
     * @access public
     * @param int $idFoto 
     */
    function setIdFoto($idFoto) {
        $this->idFoto = $idFoto;
    }

    /**
     * Asigna la url de la foto 
     * @access public
     * @param int $url 
     */
    function setUrl($url) {
        $this->url = $url;
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
