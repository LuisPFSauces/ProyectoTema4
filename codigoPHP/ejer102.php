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
            try {
                $conexion = new PDO("mysql:host=192.168.1.115;dbname=DAW204DBDepartamentos", "usuarioDAW204DBDepartamentos", "P@ssw0rd");
                 $datos = $conexion -> query("select * from Departamento");
                 
                 
                 foreach($datos as $fila){
                     echo "<tr>\n";
                     echo "<td>".$fila['CodDepartamento']."</td>\n";
                     echo "<td>".$fila['DescDepartamento']."</td>\n";
                     echo "<td>".$fila['FechaBaja']."</td>\n";
                     echo "<td>".$fila['VolumenNegocio']."</td>\n";
                     echo "</tr>\n";
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
