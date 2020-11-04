<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <table>
            <caption>Con PDO</caption>
            <tr>
                <th>Codigo departamento</th>
                <th>Descripcion</th>
                <th>Fecha Baja</th>
                <th>Valor</th>
            </tr>
        <?php
            require_once "../config/confDBPDO.php";
            try {
                $conexion = new PDO(DSN, USER, PASSWORD);
                 $prepare = $conexion ->prepare("select * from Departamento");
                 $ejecucion = $prepare ->execute();
                 if( !$ejecucion ){
                     throw new Exception("Error al realizar la consulta");
                 }
                 
                 $resultado = $prepare ->fetch();
                 while ($resultado){
                     echo "<tr>\n";
                     echo "<td>".$resultado['CodDepartamento']."</td>\n";
                     echo "<td>".$resultado['DescDepartamento']."</td>\n";
                     echo "<td>".$resultado['FechaBaja']."</td>\n";
                     echo "<td>".$resultado['VolumenNegocio']."</td>\n";
                     echo "</tr>\n";
                     $resultado = $prepare ->fetch();
                 }
            } catch (Exception $ex) {
                echo "<p>Error en la conexion: ".$ex ->getMessage(). "(Error: ". $ex ->getCode().")</p>";
            } finally {
                unset($conexion);
            }
            
            
        ?>
            </table>
    </body>
</html>
