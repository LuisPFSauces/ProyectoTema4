<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Exportar SQL</title>
        <style>
            .error{
                color: red;
            }
        </style>
    </head>
    <body>
        <?php
        $entradaOK = true;
        $conexion = null;
        require_once '../config/confDBPDO.php';
        require_once '../core/201020libreriaValidacion.php';
        define("OBLIGATORIO", 1);

        for ($persona = 0; $persona < 3; $persona++) {
            $formulario[$persona] = array(
                "codigo" => null,
                "descripcion" => null,
                "volumen" => null
            );

            $errores[$persona] = array(
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

                for ($persona = 0; $persona < 3; $persona++) {

                    $errores[$persona]["codigo"] = validacionFormularios::comprobarAlfaNumerico($_REQUEST["codigo"][$persona], 3, 3, OBLIGATORIO);
                    $errores[$persona]["descripcion"] = validacionFormularios::comprobarAlfaNumerico($_REQUEST["descripcion"][$persona], 255, 5, OBLIGATORIO);
                    $errores[$persona]["volumen"] = validacionFormularios::comprobarFloat($_REQUEST["volumen"][$persona], PHP_FLOAT_MAX, 0, OBLIGATORIO);

                    foreach ($errores[$persona] as $clave => $valor) {
                        if (!empty($valor)) {
                            echo "Entrada en el if";
                            $entradaOK = false;
                            $_REQUEST[$clave][$persona] = "";
                        }
                    }

                    if (empty($errores[$persona]["codigo"])) {
                        $prepare->bindParam(":codigo", $_REQUEST["codigo"][$persona]);
                        $ejecucion = $prepare->execute();
                        if ($ejecucion) {
                            if ($prepare->rowCount() > 0) {
                                echo "Duplicado" . $_REQUEST['codigo'][$persona];
                                $entradaOK = false;
                                $_REQUEST['codigo'][$persona] = "";
                                $errores[$persona]["codigo"] .= " El codigo de departamento ya existe por favor introduce otro";
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
            try {
                $miDB = new PDO(DSN, USER, PASSWORD);
                $miDB->beginTransaction();
                $insert = $miDB->prepare("Insert into Departamento(CodDepartamento, DescDepartamento, VolumenNegocio) values (:codigo, :descripcion, :volumen)");
                for ($persona = 0; $persona < 3; $persona++) {
                    $formulario[$persona]['codigo'] = $_REQUEST['codigo'][$persona];
                    $formulario[$persona]['descripcion'] = $_REQUEST['descripcion'][$persona];
                    $formulario[$persona]['volumen'] = $_REQUEST['volumen'][$persona];
                    $valores = array(
                        ":codigo" => $formulario[$persona]['codigo'],
                        ":descripcion" => $formulario[$persona]['descripcion'],
                        ":volumen" => $formulario[$persona]['volumen']
                    );
                    $eje = $insert->execute($valores);
                    var_dump($valores);
                    echo "Valor de eje: ".$eje; 
                    if (!$eje) {
                        throw new Exception("Error al insertar: ".$insert ->errorInfo());
                    }
                }
                $miDB->commit();
            } catch (Exception $e) {
                echo "Error " . $e->getCode() . ", " . $e->getMessage() . ".";
                $miDB->rollBack();
            } finally {
                unset($miDB);
            }
        } else {
            ?>    
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                <?php for ($persona = 0; $persona < 3; $persona++) { ?>
                    <fieldset>
                        <label for="codigo">Introduce el codigo del departamento: </label>
                        <input type="text" id="codigo" name="codigo[]" value="<?php
                        if (isset($_REQUEST["codigo"][$persona])) {
                            echo $_REQUEST["codigo"][$persona];
                        }
                        ?>">
                               <?php
                               echo!empty($errores[$persona]['codigo']) ? "<span class=\"error\">" . $errores[$persona]['codigo'] . "</span>" : "";
                               ?><br>
                        <label for="descripcion">Introduce una descripción del departamento: </label>
                        <input type="text" id="descripcion" name="descripcion[]" value="<?php
                        if (isset($_REQUEST["descripcion"][$persona])) {
                            echo $_REQUEST["descripcion"][$persona];
                        }
                        ?>">
                               <?php
                               echo!empty($errores[$persona]['descripcion']) ? "<span class=\"error\">" . $errores[$persona]['descripcion'] . "</span>" : "";
                               ?><br>
                        <label for="volumen">Introduce el volumen de negocio: </label>
                        <input type="text" id="volumen" name="volumen[]" value="<?php
                               if (isset($_REQUEST["volumen"][$persona])) {
                                   echo $_REQUEST["volumen"][$persona];
                               }
                               ?>">
                               <?php
                               echo!empty($errores[$persona]['volumen']) ? "<span class=\"error\">" . $errores[$persona]['volumen'] . "</span>" : "";
                               echo!empty($errores['conexion']) ? "<span class=\"error\">" . $errores['conexion'] . "</span>" : "";
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
