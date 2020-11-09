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

        function crearHijo($nombre, $dom, &$nodo, $valor = null) {
            if ($dom instanceof DOMDocument && $nodo instanceof DOMElement) {
                if (is_null($valor)) {
                    $elemento = $dom->createElement($nombre);
                } else {
                    $elemento = $dom->createElement($nombre, $valor);
                }

                $nodo->appendChild($elemento);
                return $elemento;
            } else {
                return null;
            }
        }

        if (isset($_REQUEST["exportar"])) {

            try {

                $miDB = new PDO(DSN, USER, PASSWORD);
                $prepare = $miDB->prepare("Select * from Departamento");
                $prepare->execute();

                $dom = new DOMDocument("1.0", "UTF-8");
                $dom->preserveWhiteSpace = true;
                $dom->formatOutput = true;


                $root = $dom->createElement("Departamentos");
                $dom->appendChild($root);

                $oDepartamento = $prepare->fetch();
                while ($oDepartamento) {
                    $departamento = crearHijo("Departamento", $dom, $root);
                    crearHijo('CodDepartamento', $dom, $departamento, $oDepartamento['CodDepartamento']);
                    crearHijo('DescDepartamento', $dom, $departamento, $oDepartamento['DescDepartamento']);
                    crearHijo('FechaBaja', $dom, $departamento, $oDepartamento['FechaBaja']);
                    crearHijo('Volumen', $dom, $departamento, $oDepartamento['VolumenNegocio']);

                    $oDepartamento = $prepare->fetch();
                }

                header('Content-Disposition: attachment;filename="SQL.xml"');
                header('Content-Type: text/xml');

                echo $dom->saveXML();
            } catch (Exception $e) {
                echo "Error " . $e->getCode() . ", " . $e->getMessage() . ".";
            } finally {
                unset($miDB);
            }
        }
        ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input type="submit" name="exportar" value="Exportar">
        </form>
    </body>
</html>
