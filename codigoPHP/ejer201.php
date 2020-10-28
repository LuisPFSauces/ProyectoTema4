<?php

/*
 * @author Luis Puente Fernandez
 * @since 2020-10-28
 */
echo "<h2>Primera conexion(tiene que ser exitosa)</h2>";

try{
$conexion = new PDO("mysql:host=192.168.1.115;dbname=DAW204DBDepartamentos", "usuarioDAW204DBDepartamentos", "P@ssw0rd");
echo "Conexion exitosa";
} catch (PDOException $ex){
   echo "<p>Error en la conexion: ".$ex ->getMessage(). "(Error: ". $ex ->getCode().")</p>";
} finally {
    unset($conexion);
}

echo "<h2>Segunda conexion(tiene que fallar)</h2>";
try{
$conexion2 = new PDO("mysql:host=192.168.1.115;dbname=DAW204DBDepartamentos", "usuarioDAW204DBDepartamentos", "paso");
} catch (PDOException $ex){
   echo "<p>Error en la conexion: ".$ex ->getMessage(). "(Error: ". $ex ->getCode().")</p>";
} finally {
    unset($conexion2);
}