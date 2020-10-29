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
         <table>
             <caption>Con MSQLi</caption>
            <tr>
                <th>Codigo departamento</th>
                <th>Descripcion</th>
                <th>Fecha Baja</th>
                <th>Valor</th>
            </tr>
        <?php
            $conexion = new mysqli (HOST, USER, PASSWORD, DBNAME);
            if($conexion -> connect_errno){
                echo "<p>Error en la conexion: ".$conexion -> connect_error. "(Error: ". $conexion -> connect_errno.")</p>";
            } else {
                $datos = $conexion ->query("select * from Departamento");
                
                foreach($datos as $fila){
                     echo "<tr>\n";
                     echo "<td>".$fila['CodDepartamento']."</td>\n";
                     echo "<td>".$fila['DescDepartamento']."</td>\n";
                     echo "<td>".$fila['FechaBaja']."</td>\n";
                     echo "<td>".$fila['VolumenNegocio']."</td>\n";
                     echo "</tr>\n";
                }
            }
            $conexion ->close()
        ?>
         </table>
    </body>
</html>
