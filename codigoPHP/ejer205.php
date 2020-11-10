<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Exportar SQL</title>
    </head>
    <body>
        <?php
        $entradaOK = true;
        $conexion = null;
        require_once '../config/confDBPDO.php';
        require_once '../core/201020libreriaValidacion.php';
        define("OBLIGATORIO", 1);

        for ($insert = 0; $insert < 3; $insert++) {
            $formulario[$insert] = array(
                "codigo" => null,
                "descripcion" => null,
                "volumen" => null
            );
            
            $errores[$insert] = array(
                "codigo" => null,
                "descripcion" => null,
                "volumen" => null
            );
        }
        $errores["conexion"] = null;

        if (isset($_REQUEST['enviar'])) {
            try {
                $miDB = new PDO(DSN, USER, PASSWORD);
                $prepare = $miDB->prepare("Select CodDepartamento from Departamento where CodDepartamento = :codigo");
                
                for ($insert = 0; $insert < 3; $insert++) {
                    
                    $errores[$insert]["codigo"] = validacionFormularios::comprobarAlfaNumerico($_REQUEST["codigo"][$insert], 3, 3, OBLIGATORIO);
                    $errores[$insert]["descripcion"] = validacionFormularios::comprobarAlfaNumerico($_REQUEST["descripcion"][$insert], 255, 5, OBLIGATORIO);
                    $errores[$insert]["volumen"] = validacionFormularios::comprobarFloat($_REQUEST["volumen"][$insert], PHP_FLOAT_MAX, 0, OBLIGATORIO);
                    
                    /*$errores[$insert]["codigo"] =$_REQUEST["codigo"][$insert];
                    $errores[$insert]["descripcion"] = $_REQUEST["descripcion"][$insert];
                    $errores[$insert]["volumen"] = $_REQUEST["volumen"][$insert];*/
                    /*
                    echo $_REQUEST["codigo"][$insert]."<br>";
                    echo$_REQUEST["descripcion"][$insert]."<br>";
                    echo $_REQUEST["volumen"][$insert]."<br>";
                     
                    echo $_REQUEST["codigo"][$insert]."<br>";
                    echo$_REQUEST["descripcion"][$insert]."<br>";
                    echo $_REQUEST["volumen"][$insert]."<br>";
                    foreach ($errores[$insert] as $clave => $valor) {
                        if (!is_null($valor)) {
                            $entradaOK = false;
                            $_REQUEST[$clave] = "";
                        }
                    }
*/
                    if ($errores[$insert]["codigo"] == null) {
                        $prepare->bindParam(":codigo", "TIC");
                        $ejecucion = $prepare->execute();
                        if ($ejecucion) {
                            if ($prepare->rowCount() > 0) {
                                $entradaOK = false;
                                $_REQUEST['codigo'] = "";
                                $errores["codigo"] .= " El codigo de departamento ya existe por favor introduce otro";
                            }
                        } else {
                            throw new ErrorException("Error al ejecutar la sentencia");
                        }
                    }
                }
            } catch (Exception $e) {
                echo "Error al realizar la conexion ( " . $e->getCode() . " )";
                $entradaOK = false;
            } finally {
                unset($miDB);
            }
        } else {
            $entradaOK = false;
        }
        if ($entradaOK) {
        } else {
            ?>    
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                <?php for ($insert = 0; $insert < 3; $insert++) { ?>
                    <fieldset>
                        <label for="codigo">Introduce el codigo del departamento: </label>
                        <input type="text" id="codigo" name="codigo[<?php echo $insert; ?>]" value="<?php if (isset($_REQUEST["codigo"][$insert])){echo $_REQUEST["codigo"][$insert];} ?>"><br>
                        <?php
                        echo!empty($errores['codigo'][$insert]) ? "<p class=\"error\">" . $errores['codigo'][$insert] . "</p>" : "";
                        ?>
                        <label for="descripcion">Introduce una descripción del departamento: </label>
                        <input type="text" id="descripcion" name="descripcion[<?php echo $insert; ?>]" value="<?php if (isset($_REQUEST["descripcion"][$insert])){echo $_REQUEST["descripcion"][$insert];} ?>"><br>
                        <?php
                        echo!empty($errores['descripcion'][$insert]) ? "<p class=\"error\">" . $errores['descripcion'][$insert] . "</p>" : "";
                        ?>
                        <label for="volumen">Introduce el volumen de negocio: </label>
                        <input type="text" id="volumen" name="volumen[<?php echo $insert; ?>]" value="<?php if (isset($_REQUEST["volumen"][$insert])){echo $_REQUEST["volumen"][$insert];} ?>"><br>
                        <?php
                        echo!empty($errores['volumen'][$insert]) ? "<p class=\"error\">" . $errores['volumen'][$insert] . "</p>" : "";
                        echo!empty($errores['conexion']) ? "<p class=\"error\">" . $errores['conexion'] . "</p>" : "";
                        ?>
                    </fieldset>
                <?php } ?>
                <input type="submit" name="enviar" value="Enviar">
            </form>
            <?php
        }
        ?>
    </body>
</html>
