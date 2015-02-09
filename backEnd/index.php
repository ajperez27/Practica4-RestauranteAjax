<?php
require '../require/comun.php';
$error = Leer::request("error");
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Restaurante</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="../CSS/terceros/reset.css">
        <link rel="stylesheet" href="../CSS/restaurante.css">
    </head>

    <body>
        <div id="contenedor">
            <?php include ("../include/barranavegacion.php"); ?>
            <div id="carta"> 
                <h1 class="titulo" id="error" >Iniciar Sesión</h1>
                <h1 class="titulo" id="error" ><?php echo $error ?></h1>
                <br/>
                <form action="phpLogin.php" id="formCentrar" >
                    <div id="NombreEmail">
                        <div id="FooterNombre">
                            <label>Login</label>
                            <input id="login" type="text" name="login" value="" />
                        </div>
                        <div id="FooterEmail">
                            <label>Contraseña</label>
                            <input id="contraseña"  type="password" name="clave" value="" />
                        </div>
                    </div>
                    <input id="enviar" type="submit" value="Entrar" />
                </form>
            </div>
            <?php include ("../include/pie.php"); ?>  
        </div>
    </body>
</html>