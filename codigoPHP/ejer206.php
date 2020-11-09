<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require_once '../config/confDBPDO.php';
        try {
            $miDB = new PDO(DSN, USER, PASSWORD);
            $prepare = $miDB->prepare("Insert ignore into Departamento (CodDepartamento,DescDepartamento,VolumenNegocio) values (:codigo, :descripcion, :volumen)");
            $elementos = array(
                ":codigo" => "PRU",
                ":descripcion" => "Pruebas con prepare statment",
                ":volumen" => 1
            );
            $ejecucion = $prepare->execute($elementos);
            if ($ejecucion) {
                echo "<p>Introducido con exito</p>";
            } else {
                echo "<p>Algo ha fallado</p>";
            }
        } catch (Exception $e) {
            echo "Error " . $e->getCode() . ", " . $e->getMessage() . ".";
        } finally {
            unset($miDB);
        }
        ?>
    </body>
</html>
