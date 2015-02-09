<?php

class Usuario {

    private $login;
    private $clave;
    private $nombre;
    private $apellidos;
    private $email;
    private $fechaalta;
    private $isactivo;
    private $isroot;
    private $rol;
    private $fechalogin;

    function __construct($login = null, $clave = null, $nombre = null, $apellidos = null, $email = null, $fechaalta = null, $isactivo = 0, $isroot = 0, $rol = 'usuario', $fechalogin = null) {
        $this->login = $login;
        $this->clave = $clave;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->email = $email;
        $this->fechaalta = $fechaalta;
        $this->isactivo = $isactivo;
        $this->isroot = $isroot;
        $this->rol = $rol;
        $this->fechalogin = $fechalogin;
    }

    function set($datos, $inicio = 0) {
        $this->login = $datos[0 + $inicio];
        $this->clave = $datos[1 + $inicio];
        $this->nombre = $datos[2 + $inicio];
        $this->apellidos = $datos[3 + $inicio];
        $this->email = $datos[4 + $inicio];
        $this->fechaalta = $datos[5 + $inicio];
        $this->isactivo = $datos[6 + $inicio];
        $this->isroot = $datos[7 + $inicio];
        $this->rol = $datos[8 + $inicio];
        $this->fechalogin = $datos[9 + $inicio];
    }

    public function getLogin() {
        return $this->login;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    public function getClave() {
        return $this->clave;
    }

    public function setClave($clave) {
        $this->clave = $clave;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function getApellidos() {
        return $this->apellidos;
    }

    public function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getFechaalta() {
        return $this->fechaalta;
    }

    public function setFechaalta($fechaalta) {
        $this->fechaalta = $fechaalta;
    }

    public function getIsactivo() {
        return $this->isactivo;
    }

    public function setIsactivo($isactivo) {
        $this->isactivo = $isactivo;
    }

    public function getIsroot() {
        return $this->isroot;
    }

    public function setIsroot($isroot) {
        $this->isroot = $isroot;
    }

    public function getRol() {
        return $this->rol;
    }

    public function setRol($rol) {
        $this->rol = $rol;
    }

    public function getFechalogin() {
        return $this->fechalogin;
    }

    public function setFechalogin($fechalogin) {
        $this->fechalogin = $fechalogin;
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
    
   /**
     * Devuelve la fecha en formato Europeo
     * @access public
     * @return int 
     */
    public function getFechaFormatoEuropeo() {
        $fecha = substr($this->getFechalogin(), 0, 10);
        $hora = substr($this->getFechalogin(), 11, 14);

        $dia = substr($fecha, 8, 2);
        $mes = substr($fecha, 5, 2);
        $ano = substr($fecha, 0, 4);
        
       $fechaEuropea= "$hora $dia-$mes-$ano";
  
        return $fechaEuropea;
    }
}
?>
