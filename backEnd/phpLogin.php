<?php

require '../require/comun.php';
$bd = new BaseDatos();

$login = Leer::request("login");
$clave = Leer::request("clave");
echo $login;
echo $clave;

$modelo = new ModeloUsuario($bd);
$r = $modelo->autentifica($login, $clave);

if ($r instanceof Usuario) {
    $sesion->setUsuario($r);
    $bd->closeConexion();   
    header("Location: ../ajax/index.php ");

} else {
    $sesion->cerrar();
    $bd->closeConexion();
    header("Location: index.php?error=Datos Incorrectos&r=-1");
}