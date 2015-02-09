<?php
require 'require/comun.php';
$pagina = 0;
if (Leer::get("pagina") != null) {
    $pagina = Leer::get("pagina");
}

$bd = new BaseDatos();
$modelo = new ModeloPlato($bd);
$paginas = $modelo->getNumeroPaginas();
$filas = $modelo->getList($pagina, Configuracion::RPP);
$total = $modelo->count();
$enlaces = Paginacion::getEnlacesPaginacion($pagina, $total[0], Configuracion::RPP);

$modelofoto = new ModeloFoto($bd);
$foto = array();
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Restaurante</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="CSS/terceros/reset.css">
        <link rel="stylesheet" href="CSS/restaurante.css">
    </head>

    <body>
        <div id="contenedor">
            <?php include ("include/barranavegacion.php"); ?>
            <div id="carta">
                <?php
                foreach ($filas as $indice => $objeto) {
                    $foto = $modelofoto->getFotoIdPlato($objeto->getIdPlato());
                    ?> 
                    <div id="bandaCrepe2" class="cartaBandaBlanca">
                        <div id="datosCrepe7" class="datosCrepe">
                            <h1><?php echo $objeto->getNombre(); ?> </h1>
                            <p>
                                <?php echo$objeto->getDescripcion(); ?>
                            </p> 
                            <a id="ver" data-idPlato='<?php echo $objeto->getIdPlato(); ?>'
                               href='frontEnd/viewPlato.php?idPlato=<?php echo $objeto->getIdPlato(); ?>'>
                                <input  id="enviar2" type="submit" value="Ver Más" />  
                            </a>                          
                        </div>
                    </div>
                    <div class="cartaDerecha" id="tituloFoto2">                       
                        <div class="plato" id="plato7" > 
                            <?php
                            if ($foto) {
                                $ruta = $foto[0]->getUrl();
                                $longitud = strlen($ruta);
                                $ruta = substr($ruta, 3, $longitud - 3);
                                ?>                        
                                <img width="100%" height="400px" src="<?php echo $ruta ?>"/> 
                            <?php } ?>  
                        </div>
                    </div>
                    <?php
                }
                ?>               
            </div>
            <div id="paginacion">
                <?php echo $enlaces["inicio"]; ?>
                <?php echo $enlaces["anterior"]; ?>
                <?php echo $enlaces["primero"]; ?>
                <?php echo $enlaces["segundo"]; ?>
                <?php echo $enlaces["actual"]; ?>
                <?php echo $enlaces["cuarto"]; ?>
                <?php echo $enlaces["quinto"]; ?>
                <?php echo $enlaces["siguiente"]; ?>
                <?php echo $enlaces["ultimo"]; ?>
            </div>
            <?php include ("include/pie.php"); ?>  
        </div>
    </body>
</html>
<?php
$bd->closeConexion();
?>