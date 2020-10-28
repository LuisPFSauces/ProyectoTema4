<?php


/*
*@author Luis Puente Fernandez
*@since 2020-10-28
*/
echo "<h2>Primera conexion(tiene que ser exitosa)</h2>";

$conexion = new mysqli("192.168.1.115", "usuarioDAW204DBDepartamentos", "P@ssw0rd", "DAW204DBDepartamentos");

if($conexion -> connect_errno){
    echo "<p>Error en la conexion: ".$conexion -> connect_error. "(Error: ". $conexion -> connect_errno.")</p>";
} else {
    echo "<p>Conexion satifactoria</p>";
}

echo "<h2>Segunda conexion(tiene que falalr)</h2>";

$conexion = new mysqli("192.168.1.115", "usuarioDAW204DBDepartamentos", "Pssw0rd", "DAW204DBDepartamentos");

if($conexion -> connect_errno){
    echo "<p>Error en la conexion: ".$conexion -> connect_error. "(Error: ". $conexion -> connect_errno.")</p>";
} else {
    echo "<p>Conexion satifactoria</p>";
}

 $conexion -> close();