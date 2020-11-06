<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <?php
        require_once '../config/confDBPDO.php';
        $errores = array(
            "conexion" => null
        );
        $formulario = array(
            "descripcion" => null
        );
        $entradaOK = true;

        if (!isset($_REQUEST['enviar'])) {
            $entradaOK = false;
        }

        if ($entradaOK) {
            $formulario["descripcion"] = $_REQUEST["descripcion"];
            try {
                $miDB = new PDO(DSN, USER, PASSWORD);
                if (empty($formulario["descripcion"])) {
                    $prepare = $miDB->prepare("Select * from Departamento");
                } else {
                    $prepare = $miDB->prepare("Select * from Departamento where DescDepartamento like :descripcion");
                }
                $parametro = "%".$formulario['descripcion']."%";
                $prepare->bindParam(":descripcion", $parametro);
                $ejecucion = $prepare->execute();

                if ($ejecucion) {

                    if ($prepare->rowCount() > 0) {

                        echo "<table>\n<caption>Busqueda</caption>\n<tr>\n<th>Codigo departamento</th>\n<th>Descripcion</th>\n<th>Fecha Baja</th>\n<th>Valor</th>\n</tr>";
                        $resultado = $prepare->fetch();
                        while ($resultado) {
                            echo "<tr>\n";
                            echo "<td>" . $resultado['CodDepartamento'] . "</td>\n";
                            echo "<td>" . $resultado['DescDepartamento'] . "</td>\n";
                            echo "<td>" . $resultado['FechaBaja'] . "</td>\n";
                            echo "<td>" . $resultado['VolumenNegocio'] . "</td>\n";
                            echo "</tr>\n";
                            $resultado = $prepare->fetch();
                        }
                        echo"</table>";
                    } else {
                        echo '<p>Ningun valor coincide con lo introducido</p>';
                    }
                } else {
                    throw new ErrorException("Error al ejecutar la sentencia: " . $prepare->errorInfo());
                }
            } catch (Exception $e) {
                echo "<p>Se ha producido un error al conectar con la base de datos( " . $e->getMessage() . ", " . $e->getCode() . ")</p>";
            } finally {
                unset($miDB);
            }
        } else {
            ?>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <input type="text" name="descripcion">
                <input type="submit" name="enviar" value="Buscar">
    <?php echo!empty($errores["conexion"]) ? "<p class=\"error\">" . $errores['conexion'] . "</p>" : ""; ?>
            </form>

                <?php
            }
            ?>


    </body>
</html>