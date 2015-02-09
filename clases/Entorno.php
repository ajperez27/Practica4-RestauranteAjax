<?php

class Entorno {

    private function __construct() {
        
    }

   static function getEnlaceCarpeta($pagina="")
   {
       //return "http//:".self::getServidor()."r".self::getPuerto().self::getCarpetaServidor().$pagina;
       return "http://".self::getServidor().":".self::getPuerto().self::getCarpetaServidor().$pagina;       
   }

   public static function getServidor() {
        return $_SERVER['SERVER_NAME'];
    }

    public static function getPuerto() {
        return $_SERVER['SERVER_PORT'];
    }

    public static function getRaiz() {
        return $_SERVER['DOCUMENT_ROOT'];
    }

    public static function getMetodo() {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function getParametros() {
        return $_SERVER['QUERY_STRING'];
    }

    public static function getScript() {
        return $_SERVER['SCRIPT_NAME'];
    }

    public static function getPagina() {
        $script = self::getScript();
        $pos = strrpos($script, '/');
        $pagina = substr($script, $pos + 1);
        return $pagina;
    }

    public static function getCarpetaServidor() {
        $carpeta = self::getScript();
        $pos = strrpos($carpeta, '/');
        $pagina = substr($carpeta, 0, $pos + 1);
        return $pagina;
    }

    public static function getPadreRaiz() {
        $raiz = self::getRaiz();
        $pos = strrpos($raiz, '/');
        $pagina = substr($raiz, 0, $pos + 1);
        return $pagina;
    }

    public static function getArrayParametros() {
        $array = array();
        $parametros = self::getParametros();
        $partes = explode('&', $parametros);
        foreach ($partes as $indices => $valor) {
            $subPartes = explode('=', $valor);
            if (!isset($subPartes[1])) {
                $subPartes[1] = "";
            }
            if (isset($array[$subPartes[0]])) {
                if (is_array($array[$subPartes[0]])) {
                    $array[$subPartes[0]][] = $subPartes[1];
                } else {
                    $subArray = array();
                    $subArray[] = $array[$subPartes[0]];
                    $subArray[] = $subPartes[1];
                    $array[$subPartes[0]] = $subArray;
                }
            } else {
                $array[$subPartes[0]] = $subPartes[1];
            }
        }
        return $array;
    }
}

?>
