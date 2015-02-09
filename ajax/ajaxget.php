<?php
require '../require/comun.php';
header('Content-Type: application/json');
$sesion->administrador("../index.php");
$bd = new BaseDatos();
$modelo = new ModeloPlato($bd);
$idPlato = Leer::get("idPlato");
$aux = $modelo->get($idPlato);
$r = null;
if ($aux !== null) {
    $r = $modelo->getJSON($idPlato);
}
$bd->closeConexion();
if ($r === null) {
    echo '{"r": 0}';
    exit();
} else {
    echo '{"r": 1,' . '"plato": ' . $r.'}';
}