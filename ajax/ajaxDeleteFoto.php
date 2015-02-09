<?php
require '../require/comun.php';
header('Content-Type: application/json');
$sesion->administrador("../index.php");
$bd = new BaseDatos();
$modelo = new ModeloFoto($bd);
$idFoto = Leer::request("idFoto");

$foto = $modelo->get($idFoto);

$idPlato = $foto->getIdPlato();
$idFoto2 = $foto->getIdFoto();
$modelo->borrarUnaFoto($idFoto);
$modelo->deletePorIdFoto($idFoto);

$bd->closeConexion();
echo '{"r":'.$idFoto2.'}';

