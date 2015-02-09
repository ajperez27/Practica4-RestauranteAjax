<?php
require '../require/comun.php';
header('Content-Type: application/json');
$sesion->administrador("../index.php");
$bd = new BaseDatos();
$modelo = new ModeloFoto($bd);
$idPlato = Leer::get("idPlato");


echo "{";
echo '"fotos":'.$modelo->getListJSONIdPlato($idPlato);
echo '}';
$bd->closeConexion();