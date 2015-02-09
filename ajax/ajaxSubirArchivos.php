<?php
require '../require/comun.php';
$sesion->administrador("../index.php");
$subir = new SubirArchivos("archivo");
$subir->subir();
$nombres = $subir->getExtensiones();
$idPlato = Leer::get("idPlato");
$bd = new BaseDatos();
$modelo = new ModeloFoto($bd);

foreach ($nombres as $key => $url) 
{
    $foto = new Foto(null, $idPlato, $url);
    $modelo->add($foto);
}
$bd->closeConexion();