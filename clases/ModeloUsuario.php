<?php

/**
 * Class ModeloUsuario
 *
 * @version 1.01
 * @author Antonio Javier Pérez Medina
 * @license http://...
 * @copyright izvbycv
 * Esta clase gestiona los Usuarios con la base de datos.
 */
class ModeloUsuario {

    private $bd;
    private $tabla = "usuario";

    function __construct(BaseDatos $bd) {
        $this->bd = $bd;
    }

    /**
     * Devuelve -1 si no añade correctamente
     * @access public
     * @return int 
     */
    function add(Usuario $objeto) {
        $sql = "insert into $this->tabla values ( :login, :clave, :nombre, :apellidos, :email, curdate(),
                                                 :isactivo, :isroot, :rol, null);";
        $parametros["login"] = $objeto->getLogin();
        $parametros["clave"] = sha1($objeto->getClave());
        $parametros["nombre"] = $objeto->getNombre();
        $parametros["apellidos"] = $objeto->getApellidos();
        $parametros["email"] = $objeto->getEmail();
        //$parametros["fechaalta"] = $objeto->getFechaalta();
        $parametros["isactivo"] = $objeto->getIsactivo();
        $parametros["isroot"] = $objeto->getIsroot();
        $parametros["rol"] = $objeto->getRol();
        // $parametros["fechalogin"] = $objeto->getFechalogin();
        $r = $this->bd->setConsulta($sql, $parametros);

        if (!$r) {
            return -1;
        }
        return $r;
        //return $this->bd->getAutonumerico(); //0
    }

    /**
     * Devuelve -1 si no borra correctamente
     * @access public
     * @return int 
     */
    function delete(Usuario $objeto) {
        $sql = "delete from $this->tabla where login = :login";
        $parametros["login"] = $objeto->getLogin();
        $r = $this->bd->setConsulta($sql, $parametros);

        if (!$r) {
            return -1;
        }
        return $r; //0
    }

    /**
     * Devuelve el resultado del borrado
     * @access public
     * @return int 
     */
    function deletePorId($id) {
        return $this->delete(new Usuario($id));
    }

    /**
     * Devuelve -1 si no edita correctamente
     * @access public
     * @return int 
     */
    function edit(Usuario $objeto, $loginpk) {
        $sql = "update into $this->tabla set login = :login, clave= :clave, nombre = :nombre, 
                                                       apellidos = :apellidos, email= :email, 
                                                       fechaalta = :fechaalta, isactivo = :isactivo, 
                                                       isroot = :isroot, :rol, where login = loginpk;";
        $parametros["login"] = $objeto->getLogin();
        $parametros["clave"] = $objeto->getClave();
        $parametros["nombre"] = $objeto->getNombre();
        $parametros["apellidos"] = $objeto->getApellidos();
        $parametros["email"] = $objeto->getEmail();
        //$parametros["fechaalta"] = $objeto->getFechaalta();
        $parametros["isactivo"] = $objeto->getIsactivo();
        $parametros["isroot"] = $objeto->getIsroot();
        $parametros["rol"] = $objeto->getRol();
        //$parametros["fechalogin"] = $objeto->getFechalogin();
        $r = $this->bd->setConsulta($sql, $parametros);

        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas(); //0
    }

    /**
     * Devuelve -1 si no edita correctamente
     * @access public
     * @return int 
     */
    function editConsulta($asignacion, $condicion = "1=1", $parametros = array()) {
        $sql = "update $this->tabla set $asignacion where $condicion";
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return - 1;
        }
        return $this->bd->getNumeroFilas();
    }

    /**
     * Devuelve -1 si no edita con clave correctamente
     * @access public
     * @return int 
     */
    function editConClave(Usuario $objeto, $login, $claveold) {
        $asignacion = "login = :login, clave = :clave, nombre = :nombre, "
                . "apellidos= :apellidos, email= :email";
        $condicion = "login = :loginpk and clave= :claveold";
        $parametros["login"] = $objeto->getLogin();
        $parametros["clave"] = sha1($objeto->getClave());
        $parametros["nombre"] = $objeto->getNombre();
        $parametros["apellidos"] = $objeto->getApellidos();
        $parametros["email"] = $objeto->getEmail();
        $parametros["loginpk"] = $login;
        $parametros["claveold"] = $claveold;
        return $this->editConsulta($asignacion, $condicion, $parametros);
    }

    /**
     * Devuelve -1 si no edita sin clave correctamente
     * @access public
     * @return int 
     */
    function editSinClave(Usuario $objeto, $login) {
        $asignacion = "login = :login, nombre = :nombre, apellidos= :apellidos, email= :email";
        $condicion = "login = :loginpk";
        $parametros["login"] = $objeto->getLogin();
        //$parametros["clave"] = sha1($objeto->getClave());
        $parametros["nombre"] = $objeto->getNombre();
        $parametros["apellidos"] = $objeto->getApellidos();
        $parametros["email"] = $objeto->getEmail();
        $parametros["loginpk"] = $login;

        return $this->editConsulta($asignacion, $condicion, $parametros);
    }

    /**
     * Devuelve -1 si no edita correctamente por la primary key antigua
     * @access public
     * @return int 
     */
    function editPK(Usuario $objetoOriginal, Usuario $objetoNuevo) {
        $sql = "update into $this->tabla set login = :login, clave= :clave, nombre = :nombre, 
                                                       apellidos = :apellidos, email= :email, 
                                                       fechaalta = :fechaalta, isactivo = :isactivo, 
                                                       isroot = :isroot, :rol, fechalogin = :fechalogin,
                                                       login = :loginpk;";
        $parametros["login"] = $objetoNuevo->getLogin();
        $parametros["clave"] = $objetoNuevo->getClave();
        $parametros["nombre"] = $objetoNuevo->getNombre();
        $parametros["apellidos"] = $objetoNuevo->getApellidos();
        $parametros["email"] = $objetoNuevo->getEmail();
        $parametros["fechaalta"] = $objetoNuevo->getFechaalta();
        $parametros["isactivo"] = $objetoNuevo->getIsactivo();
        $parametros["isroot"] = $objetoNuevo->getIsroot();
        $parametros["rol"] = $objetoNuevo->getRol();
        $parametros["fechalogin"] = $objetoNuevo->getFechalogin();
        $parametros["loginpk"] = $objetoOriginal->getLogin();

        $r = $this->bd->setConsulta($sql, $parametros);

        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas(); //0
    }

       /**
     * Devuelve -1 si no edita correctamente por la primary key antigua
     * @access public
     * @return int 
     */
    function editPK2(Usuario $objeto, $loginpk) {
        $sql = "update $this->tabla set login=:login, clave=:clave, nombre=:nombre, "
                . "apellidos=:apellidos, email=:email, "
//. "fechalta=:fechaalta "
                . "isactivo=:isactivo, isroot=:isroot, rol=:rol "
//. "fechalogin=:fechalogin "
                . "where login=:loginpk;";
        $parametros["login"] = $objeto->getLogin();
        $parametros["clave"] = sha1($objeto->getClave());
        $parametros["nombre"] = $objeto->getNombre();
        $parametros["apellidos"] = $objeto->getApellidos();
        $parametros["email"] = $objeto->getEmail();
//$parametros["fechaalta"] = $objeto->getFechaalta();
        $parametros["isactivo"] = $objeto->getIsactivo();
        $parametros["isroot"] = $objeto->getIsroot();
        $parametros["rol"] = $objeto->getRol();
//$parametros["fechalogin"] = $objeto->getFechalogin();
//$parametros["loginpk"] = $objetoOriginal->getLogin();
        $parametros["loginpk"] = $loginpk;
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas();
    }

    /**
     * Devuelve el usuario buscado
     * @access public
     * @return Usuario $usuario 
     */
    function get($login) {
        $sql = "select * from $this->tabla where login= :login";
        $parametros["login"] = $login;
        $r = $this->bd->setConsulta($sql, $parametros);
        if ($r) {
            $usuario = new Usuario();
            $usuario->set($this->bd->getFila());
            return $usuario;
        }
        return null;
    }

    /**
     * Devuelve el numeo de paginas
     * @access public
     * @return int 
     */
    function getNumeroPaginas($rpp = Configuracion::RPP) {
        $lista = $this->count();
        return (ceil($lista[0] / $rpp) - 1);
    }

    /**
     * Devuelve -1 si no realiza la consulta corectamente
     * @access public
     * @return int 
     */
    function count($condicion = "1=1", $parametros = array()) {
        $sql = "select count(*) from $this->tabla where $condicion";
        $r = $this->bd->setConsulta($sql, $parametros);
        if ($r) {
            $aux = $this->bd->getFila();
            return $aux[0];
        }
        return -1;
    }
    


    /**
     * Devuelve un array con los usuarios
     * @access public
     * @return array $list
     */
    function getList($pagina = 0, $rpp = 10, $condicion = "1=1", $parametros = array(), $orderby = "1") {
        $list = array();
        $principio = $pagina * $rpp;
        $sql = "select * from $this->tabla where $condicion order by $orderby limit $principio,$rpp";
        $r = $this->bd->setConsulta($sql, $parametros);
        if ($r) {
            while ($fila = $this->bd->getFila()) {
                $usuario = new Usuario();
                $usuario->set($fila);
                $list[] = $usuario;
            }
        } else {
            return null;
        }
        return $list;
    }

    /**
     * Devuelve un array con los usuarios
     * @access public
     * @return array $list
     */
    function getList2($condicion = "1=1", $parametros = array(), $orderBy = "1") {
        $list = array(); //$list = [];
        $sql = "select * from $this->tabla where $condicion order by $orderBy";
        $r = $this->bd->setConsulta($sql, $parametros);
        if ($r) {
            while ($fila = $this->bd->getFila()) {
                $usuario = new Usuario();
                $usuario->set($fila);
                $list[] = $usuario;
            }
        } else {
            return null;
        }
        return $list;
    }

    /**
     * Devuelve un array con los usuarios
     * @access public
     * @return array $list
     */
    function selectHtml($login, $name, $condicion, $parametros, $valorSelecctionado = "", $blanco = true, $orderby = "1") {
        $select = "<select  name='$name' login='$login'>";
        if ($blanco) {
            $select.= "<option value='' >&nbsp $ </option>";
        }
        $lista = $this->getList($condicion, $parametros, $orderby);
        foreach ($lista as $obejeto) {
            $selected = "";
            if ($obejeto->getLogin() == $valorSelecctionado) {
                $selected = "selected";
            }

            $select = "<option $selected value='" . $obejeto->getLogin() . "' >" .
                    $obejeto->getClave() . "," . $obejeto->getNombre() .
                    $obejeto->getApellidos() . "," . $obejeto->getEmail() .
                    $obejeto->getFechaalta() . "," . $obejeto->getIsactivo() .
                    $obejeto->getIsroot() . "," . $obejeto->getRol() .
                    $obejeto->getFechalogin() . "</option>";
        }

        $select.="</select>";
        return $select;
    }

    /**
     * Devuelve -1 si no activa correctamente
     * @access public
     * @return int 
     */
    function activa($id) {
        $sql = "update usuario 
                set isactivo = 1
                Where isactivo=0 
                and md5(concat(email,'" . Configuracion::PEZARANA . "', login))=:id";
        $parametros["id"] = $id;
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas(); //0
    }

    /**
     * Devuelve -1 si no desactiva correctamente
     * @access public
     * @return int 
     */
    function desactiva($loginpk) {
        $sql = "update $this->tabla set isactivo=0 where login=:login;";
        $parametros["login"] = $loginpk;
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas();
    }

    /**
     * Devuelve el resultado de editConsulta
     * @access public
     * @return int 
     */
    function actualiza($login) {
        $condicion = "login= :login";
        $parametros["login"] = $login;
        $asignacion = "fechalogin = now()";
        //$parametros["fechalogin"] = "now()";
        return $this->editConsulta($asignacion, $condicion, $parametros);
    }

    /**
     * Devuelve false si no autentifica correctamente
     * @access public
     * @return int 
     */
    function autentifica($login, $clave) {
        $condicion = "login = :login and clave= :clave and isactivo = 1";
        $parametros["login"] = $login;
        $parametros["clave"] = sha1($clave);
        $r = $this->getConsulta($condicion, $parametros);

        if (sizeof($r) == 1) {            
            $this->actualiza($login);
            return $r[0];
        }
        return false;
    }

    /**
     * Devuelve una lista con los usuarios
     * @access public
     * @return int 
     */
    function getConsulta($condicion = "1=1", $parametros = array(), $orderby = "1") {
        $list = array();
        $sql = "select * from $this->tabla where $condicion order by $orderby";
        $r = $this->bd->setConsulta($sql, $parametros);
        if ($r) {
            while ($fila = $this->bd->getFila()) {
                $usuario = new Usuario();
                $usuario->set($fila);
                $list[] = $usuario;
            }
        } else {
            return null;
        }
        return $list;
    }

    /**
     * Devuelve una lista con los usuarios en formato Json
     * @access public
     * @return int 
     */
    function getListJSON($pagina = 0, $rpp = 3, $condicion = "1=1", $parametros = array(), $orderby = "1") {
        $post = $pagina * $rpp;
        $sql = "select * from $this->tabla where $condicion order by $orderby limit $post, $rpp";

        $this->bd->setConsulta($sql, $parametros);
        $r = "[ ";
        while ($fila = $this->bd->getFila()) {
            $objeto = new Usuario();
            $objeto->set($fila);
            $r .= $objeto->getJSON() . ",";
        }
        $r = substr($r, 0, -1) . "]";
        return $r;
    }

    /**
     * Devuelve -1 si no cambia la clave
     * @access public
     * @return int 
     */
    function cambiarClave($login, $id) {
        $sql = "select * from $this->tabla "
                . "where login=:login and md5(concat(login,'" . Configuracion::PEZARANA . "',email))=:id;";
        $parametros["login"] = $login;
        $parametros["id"] = $id;
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas();
    }    
}

?>
