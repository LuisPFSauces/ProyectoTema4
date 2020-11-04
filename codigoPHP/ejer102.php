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
        require_once '../config/confDBMySQLi.php';
        //Establece la conexion a la base de datos mediante las constantes declaradas en el archivo confMySQLi
            $conexion = new mysqli (HOST, USER, PASSWORD, DBNAME);
            //Si la conexión devuelve algo distindo de 0 entrará en el if y saldra un mensaje de error
            if($conexion -> connect_errno){
                echo "<p>Error en la conexion: ".$conexion -> connect_error. "(Error: ". $conexion -> connect_errno.")</p>";
            } else {//En caso de una conexion exitosa almacena el resultado del query en $datos
                $datos = $conexion ->query("select * from Departamento");
                
                foreach($datos as $fila){//Se recorre los datos del query
                     echo "<tr>\n";
                     echo "<td>".$fila['CodDepartamento']."</td>\n";
                     echo "<td>".$fila['DescDepartamento']."</td>\n";
                     echo "<td>".$fila['FechaBaja']."</td>\n";
                     echo "<td>".$fila['VolumenNegocio']."</td>\n";
                     echo "</tr>\n";
                }
            }
            $conexion ->close()//Se cierra la conexion
        ?>
         </table>
    </body>
</html>
