<?php
require '../require/comun.php';
header('Content-Type: application/json');
$sesion->administrador("../index.php");
$bd = new BaseDatos();
$modelo = new ModeloPlato($bd);
$pagina = 0;
if (Leer::get("pagina") != null) {
    $pagina = Leer::get("pagina");
}
$enlaces = Paginacion::getEnlacesPaginacionJSON($pagina, $modelo->count(), Configuracion::RPP);
echo '{"paginas":' . json_encode($enlaces) . ',"platos":' . $modelo->getListJSON($pagina, Configuracion::RPP) . '}';
$bd->closeConexion();
