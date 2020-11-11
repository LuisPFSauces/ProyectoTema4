<?php
if (isset($_REQUEST['exportar'])) {
    header('Content-Disposition: attachment;filename="SQL.xml"');
    header('Content-Type: text/xml');
    readfile("../tmp/SQL.xml");
} else{
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Exportar PHP</title>
        <style>

            .descarga{
                display: inline-block;
                text-decoration: none;
                background: coral;
                color: white;
                height:40px;
                line-height: 40px;
                width: 15%;
                text-align: center;
                margin: auto;
            }
        </style>
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

        try {

            $miDB = new PDO(DSN, USER, PASSWORD);
            $consulta = $miDB->prepare("Select * from Departamento");
            $consulta->execute();

            $dom = new DOMDocument("1.0", "UTF-8");
            $dom->preserveWhiteSpace = true;
            $dom->formatOutput = true;


            $root = $dom->createElement("Departamentos");
            $dom->appendChild($root);

            $oDepartamento = $consulta->fetchObject();
            while ($oDepartamento) {
                $departamento = crearHijo("Departamento", $dom, $root);
                crearHijo('CodDepartamento', $dom, $departamento, $oDepartamento->CodDepartamento);
                crearHijo('DescDepartamento', $dom, $departamento, $oDepartamento->DescDepartamento);
                crearHijo('FechaBaja', $dom, $departamento, $oDepartamento->FechaBaja);
                crearHijo('Volumen', $dom, $departamento, $oDepartamento->VolumenNegocio);

                $oDepartamento = $consulta->fetchObject();
            }
            $dom->save("../tmp/SQL.xml");
            echo "<div>";
            highlight_file("../tmp/SQL.xml");
            echo "</div>";
        } catch (Exception $e) {
            echo "Error " . $e->getCode() . ", " . $e->getMessage() . ".";
        } finally {
            unset($miDB);
        }
        ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST"  enctype = "multipart/form-data">
            <input type="submit" name="exportar" value="exportar" class="descarga">
        </form>
    </body>
</html>
<?php } ?>