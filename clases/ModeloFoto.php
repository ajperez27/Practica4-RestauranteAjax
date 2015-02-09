<?php

/**
 * Class ModeloFoto
 *
 * @version 1.01
 * @author Antonio Javier Pérez Medina
 * @license http://...
 * @copyright izvbycv
 * Esta clase gestiona las fotos con la base de datos.
 */
class ModeloFoto {

    private $bd;
    private $tabla = "foto";

    function __construct(BaseDatos $bd) {
        $this->bd = $bd;
    }

    /**
     * Devuelve -1 si no añade correctamente
     * @access public
     * @return int 
     */
    function add(Foto $objeto) {
        $sql = "insert into $this->tabla values (null, :idPlato, :url);";
        $parametros["idPlato"] = $objeto->getIdPlato();
        $parametros["url"] = $objeto->getUrl();
        $r = $this->bd->setConsulta($sql, $parametros);
        if (!$r) {
            return -1;
        }
        return $this->bd->getAutonumerico();
    }

    /**
     * Devuelve -1 si no borra correctamente
     * @access public
     * @return int 
     */
    function delete(Foto $objeto) {
        $sql = "delete from $this->tabla where idFoto = :idFoto";
        $parametros["idFoto"] = $objeto->getIdFoto();
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
    function deletePorIdFoto($idFoto) {
        return $this->delete(new Foto($idFoto));
    }

    /**
     * Devuelve -1 si no edita correctamente
     * @access public
     * @return int 
     */
    function edit(Foto $objeto) {
        $sql = "update $this->tabla set url = :url, idPlato = :idPlato where idFoto = :idFoto;";
        $parametros["url"] = $objeto->getUrl();
        $parametros["idPlato"] = $objeto->getIdPlato();
        $parametros["idFoto"] = $objeto->getIdFoto();
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
    function editPK(Foto $objetoOriginal, Foto $objetoNuevo) {
        $sql = "update $this->tabla set url = :url where idFoto= :idFotopk;";
        $parametros["url"] = $objetoNuevo->getUrl();
        $parametros["idFoto"] = $objetoNuevo->getIdFoto();
        $parametros["idPlato"] = $objetoNuevo->getIdPlato();
        $parametros["idFotopk"] = $objetoOriginal->getIdFoto();
        $r = $this->bd->setConsulta($sql, $parametros);

        if (!$r) {
            return -1;
        }
        return $this->bd->getNumeroFilas(); //0
    }

    /**
     * Devuelve la foto buscada
     * @access public
     * @return Foto $foto
     */
    function get($idFoto) {
        $sql = "select * from $this->tabla where idFoto= :idFoto";
        $parametros["idFoto"] = $idFoto;
        $r = $this->bd->setConsulta($sql, $parametros);
        if ($r) {
            $foto = new Foto();
            $foto->set($this->bd->getFila());
            return $foto;
        }
        return null;
    }

    /**
     * Devuelve un array con las FOTOS
     * @access public
     * @return array $list
     */
    function getFotoIdPlato($idPlato) {
        $sql = "select * from $this->tabla where idPlato= :idPlato";
        $parametros["idPlato"] = $idPlato;
        $r = $this->bd->setConsulta($sql, $parametros);
        $arrayFotos = array();
        if ($r) {
            while ($fila = $this->bd->getFila()) {
                $foto = new Foto();
                $foto->set($fila);
                $arrayFotos[] = $foto;
            }
            return $arrayFotos;
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
     * Devuelve un array con las casas
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
                $foto = new Foto();
                $foto->set($fila);
                $list[] = $foto;
            }
        } else {
            return null;
        }
        return $list;
    }

    /**
     * Devuelve un select de html construido 
     * @access public
     * @return string $select
     */
    function selectHtml($idFoto, $name, $condicion, $parametros, $valorSeleccionado = "", $blanco = true, $orderby = "1") {
        $select = "<select  name='$name' id='$idFoto'>";
        if ($blanco) {
            $select.= "<option value='' />&nbsp $ </option>";
        }
        $lista = $this->getList($condicion, $parametros, $orderby);
        foreach ($lista as $objeto) {
            $selected = "";
            if ($objeto->getIdFoto() == $valorSeleccionado) {
                $selected = "selected";
            }

            $select = "<option $selected value='" . $objeto->getIdFoto() . "' >" . $objeto->getIdPlato() . "," . $objeto->getUrl() .
                    "</option>";
        }

        $select.="</select>";
        return $select;
    }

    /**
     * Borra las fotos de la carpeta 
     * @access public
     * @return string $select
     */
    function borrarFotoCarpeta($idPlato) {
        $fotos = $this->getFotoIdPlato($idPlato);
        foreach ($fotos as $key => $foto) {
            unlink($foto->getUrl());
        }
    }

    /**
     * Borra una foto de la carpeta 
     * @access public
     * @return 
     */
    function borrarUnaFoto($idFoto) {
        $foto = $this->get($idFoto);
        unlink($foto->getUrl());
    }

    /**
     * Devuelve una foto en formato Json
     * @access public
     * @return string
     */
    function getJSON($idFoto) {
        return $this->get($idFoto)->getJSON();
    }

    /**
     * Devuelve una lista con las fotos en formato Json
     * @access public
     * @return string
     */
    function getListJSON($pagina = 0, $rpp = 3, $condicion = "1=1", $parametros = array(), $orderby = "1") {
        $post = $pagina * $rpp;
        $sql = "select * from $this->tabla where $condicion order by $orderby limit $post, $rpp";

        $this->bd->setConsulta($sql, $parametros);
        $r = "[ ";
        while ($fila = $this->bd->getFila()) {
            $objeto = new Foto();
            $objeto->set($fila);
            $r .= $objeto->getJSON() . ",";
        }
        $r = substr($r, 0, -1) . "]";
        return $r;
    }

    function getListJSONIdPlato($idPlato) {
        $sql = "select * from $this->tabla where idPlato=:idPlato";
        $parametros["idPlato"] = $idPlato;
        $this->bd->setConsulta($sql, $parametros);
        $r = "[ ";
        while ($datos = $this->bd->getFila()) {
            $foto = new Foto();
            $foto->set($datos);
            $r .= $foto->getJSON() . ",";
        }
        $r = substr($r, 0, -1) . "]";
        return $r;
    }

}

?>
