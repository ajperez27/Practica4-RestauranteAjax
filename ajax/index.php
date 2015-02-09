<?php
require '../require/comun.php';
$ajax = true;
$sesion->administrador("../index.php");
$pagina = 0;
if (Leer::get("pagina") != null) {
    $pagina = Leer::get("pagina");
}
$bd = new BaseDatos();
$modelo = new ModeloUsuario($bd);
$actual = "usuario";
$dir = "../";
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <?php include ("../include/head.php"); ?>
        <title>Restaurante</title> 
        <link rel="stylesheet" href="../CSS/terceros/reset.css">
        <link rel="stylesheet" href="../CSS/restaurante.css">
    </head>
    <body>
        <div id="contenedor">
            <?php include ("../include/barranavegacion.php"); ?>
            <div id="carta">  
            </div>
            <input id="btverinsertar"  type="button" value="Insertar Plato" />
            <form action="../backEnd/phplogout.php">
                <input id="cerrarSesion"  type="submit" value="Cerrar Sesion" />
            </form>
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="exampleModalLabel">Insertar Plato</h4>
                        </div>
                        <div class="modal-body">
                            <form enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="recipient-name" class="control-label">Nombre:</label>
                                    <input type="text" style="width: 90%;" class="form-control" id="nombre">
                                </div>
                                <div class="form-group">
                                    <label for="message-text" class="control-label">Descripcion:</label>
                                    <textarea class="form-control" style="width: 90%;" id="descripcion"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="control-label">Precio:</label>
                                    <input type="text" class="form-control" style="width: 90%;" id="precio">
                                </div>
                                <div id="imagenes"></div>
                                <div class="form-group">
                                    <input type="file" id="archivo" multiple />
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btsiI" class="btn btn-primary">Insertar</button>
                            <button type="button" id="btnoI" class="btn btn-default" data-dismiss="modal">Cancelar</button>                            
                        </div>
                    </div>
                </div>
            </div>
            <?php include ("../include/pie.php"); ?>  
        </div>
        <?php include ("../include/dialogoModal.php"); ?>
        <?php include ("../include/script.php"); ?>
        <script src="script/codigo.js"></script>
    </body>
</html>