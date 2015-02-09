<?php
require '../require/comun.php';
$bd = new BaseDatos();
$idPlato = Leer::request("idPlato");
$modelo = new ModeloPlato($bd);
$plato = $modelo->get($idPlato);

$modelofoto = new ModeloFoto($bd);
$foto = $modelofoto->getFotoIdPlato($idPlato);
$bd->closeConexion();
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
                <div id="bandaCrepe2" class="cartaBandaBlanca">
                    <div id="datosCrepe7" class="datosCrepe">
                        <h1><?php echo $plato->getNombre(); ?> </h1>
                        <p>
                            <?php echo $plato->getDescripcion(); ?>
                        </p> 
                        <p id="precio">
                            <?php echo $plato->getPrecio(); ?> €
                        </p> 
                        <a id="ver" href='../index.php'>
                            <input  id="enviar2" type="submit" value="Atras" />  
                        </a>                          
                    </div>
                </div>
                <div class="cartaDerecha" id="tituloFoto2">  
                    <?php
                    foreach ($foto as $indice => $objeto) {
                        ?> 
                        <div class="plato" id="plato7" > 
                            <img  width="100%" height="400px" src="<?php echo$foto[$indice]->getUrl(); ?>"/>  
                        </div>
                        <?php
                    }
                    ?> 
                </div>  
                <a id="ver" href='../index.php'>
                    <input  id="enviar2" type="submit" value="Atras" />  
                </a>

            </div>
            <?php include ("../include/pie.php"); ?>  
        </div>
    </body>
</html>
<?php
$bd->closeConexion();
?>