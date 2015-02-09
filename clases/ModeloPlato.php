<?php

/**
 * Class ModeloPlato
 *
 * @version 1.01
 * @author Antonio Javier Pérez Medina
 * @license http://...
 * @copyright izvbycv
 * Esta clase gestiona los platos con la base de datos.
 */
class ModeloPlato {

    private $bd;
    private $tabla = "plato";

    function __construct(BaseDatos $bd) {
        $this->bd = $bd;
    }

    /**
     * Devuelve -1 si no añade correctamente
     * @access public
     * @return int 
     */
    function add(Plato $objeto) {
        $sql = "insert into $this->tabla values (null, :nombre, :descripcion, "
                . ":precio);";
        $parametros["nombre"] = $objeto->getNombre();
        $parametros["descripcion"] = $objeto->getDescripcion();
        $parametros["precio"] = $objeto->getPrecio();
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getAutonumerico(); //0         
    }

    /**
     * Devuelve -1 si no borra correctamente
     * @access public
     * @return int 
     */
    function delete(Plato $objeto) {
        $sql = "delete from $this->tabla where idPlato = :idPlato";
        $parametros["idPlato"] = $objeto->getIdPlato();
        $r = $this->bd->setConsulta($sql, $parametros);

        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas(); //0    
    }

    /**
     * Devuelve el resultado del borrado
     * @access public
     * @return int 
     */
    function deletePorId($idPlato) {
        return $this->delete(new Plato($idPlato));
    }

    /**
     * Devuelve -1 si no edita correctamente
     * @access public
     * @return int 
     */
    function edit(Plato $objeto) {
        $sql = "update $this->tabla set nombre = :nombre, descripcion = :descripcion,"
                . "precio = :precio "
                . "where idPlato= :idPlato;";
        $parametros["nombre"] = $objeto->getNombre();
        $parametros["descripcion"] = $objeto->getDescripcion();
        $parametros["precio"] = $objeto->getPrecio();
        $parametros["idPlato"] = $objeto->getIdPlato();
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
    function editPK(Plato $objetoOriginal, Plato $objetoNuevo) {
        $sql = "update $this->tabla set nombre = :nombre, descripcion = :descripcion,"
                . "precio = :precio where idPlato= :idPlatopk;";
        $parametros["nombre"] = $objetoNuevo->getNombre();
        $parametros["descripcion"] = $objetoNuevo->getDescripcion();
        $parametros["precio"] = $objetoNuevo->getPrecio();
        $parametros["idPlato"] = $objetoNuevo->getIdPlato();
        $parametros["idPlatopk"] = $objetoOriginal->getIdPlato();
        $r = $this->bd->setConsulta($sql, $parametros);

        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas(); //0
    }

    /**
     * Devuelve el plato buscado
     * @access public
     * @return Plato $plato
     */
    function get($idPlato) {
        $sql = "select * from $this->tabla where idPlato= :idPlato";
        $parametros["idPlato"] = $idPlato;
        $r = $this->bd->setConsulta($sql, $parametros);
        if ($r) {
            $plato = new Plato();
            $plato->set($this->bd->getFila());
            return $plato;
        }
        return null;
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
     * Devuelve el numeo de paginas
     * @access public
     * @return int 
     */
    function getNumeroPaginas($rpp = Configuracion::RPP) {
        $lista = $this->count();
        return (ceil($lista[0] / $rpp) - 1);
    }

    /**
     * Devuelve un array con los platos
     * @access public
     * @return array $list
     */
    function getList($pagina = 0, $rpp = Configuracion::RPP, $condicion = "1=1", $parametros = array(), $orderby = "1") {
        $list = array();
        $principio = $pagina * $rpp;
        $sql = "select * from $this->tabla where $condicion order by $orderby limit $principio,$rpp";
        $r = $this->bd->setConsulta($sql, $parametros);
        if ($r) {
            while ($fila = $this->bd->getFila()) {
                $plato = new Plato();
                $plato->set($fila);
                $list[] = $plato;
            }
        } else {
            return null;
        }
        return $list;
    }

    /**
     * Devuelve un array con los platos
     * @access public
     * @return array $list
     */
    function selectHtml($idPlato, $name, $condicion, $parametros, $valorSeleccionado = "", $blanco = true, $orderby = "1") {
        $select = "<select  name='$name' id='$idPlato'>";
        if ($blanco) {
            $select.= "<option value='' />&nbsp $ </option>";
        }
        $lista = $this->getList($condicion, $parametros, $orderby);
        foreach ($lista as $objeto) {
            $selected = "";
            if ($objeto->getIdPlato() == $valorSeleccionado) {
                $selected = "selected";
            }

            $select = "<option $selected value='" . $objeto->getIdPlato() . "' >" . $objeto->getNombre() . "," . $objeto->getDescripcion() .
                    $objeto->getPrecio() . "</option>";
        }

        $select.="</select>";
        return $select;
    }

    /**
     * Devuelve el nombre de la tabla 
     * @access public
     * @return string tabla
     */
    function getTabla() {
        return $this->tabla;
    }
    
      function getJSON($idPlato) {
        return $this->get($idPlato)->getJSON();
    }
    
    
        /**
     * Devuelve una lista con los platos en formato Json
     * @access public
     * @return int 
     */
    function getListJSON($pagina = 0, $rpp = 3, $condicion = "1=1", $parametros = array(), $orderby = "1") {
        $post = $pagina * $rpp;
        $sql = "select * from $this->tabla where $condicion order by $orderby limit $post, $rpp";

        $this->bd->setConsulta($sql, $parametros);
        $r = "[ ";
        while ($fila = $this->bd->getFila()) {
            $objeto = new Plato();
            $objeto->set($fila);
            $r .= $objeto->getJSON() . ",";
        }
        $r = substr($r, 0, -1) . "]";
        return $r;
    }
}

?>
