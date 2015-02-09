<?php
require '../require/comun.php';
header('Content-Type: application/json');
$sesion->administrador("../index.php");
$bd = new BaseDatos();
$modelo = new ModeloPlato($bd);

$idPlatopk = Leer::post("idPlato");
$pagina = 0;
if (Leer::get("pagina") != null) {
    $pagina = Leer::get("pagina");
}

$nombre = Leer::post("nombre");
$descripcion = Leer::post("descripcion");
$precio = Leer::post("precio");

$plato= new Plato($idPlatopk, $nombre, $descripcion, $precio);
$r = $modelo->edit($plato, $idPlatopk);


if ($r === -1) {
    echo '{"r": 0}';
    $bd->closeConexion();
    exit();
}

$enlaces = Paginacion::getEnlacesPaginacionJSON($pagina, $modelo->count(), Configuracion::RPP);
echo '{"r": 1,"paginas":' . json_encode($enlaces) . ',"platos":' . $modelo->getListJSON($pagina, Configuracion::RPP) . '}';
$bd->closeConexion();
