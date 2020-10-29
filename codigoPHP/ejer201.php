<?php

/*
 * @author Luis Puente Fernandez
 * @since 2020-10-28
 */
require_once '../config/confDBPDO.php';
echo "<h2>Primera conexion(tiene que ser exitosa)</h2>";

try {
    $conexion = new PDO(DSN, USER, PASSWORD);
    echo "Conexion exitosa";
} catch (PDOException $ex) {
    echo "<p>Error en la conexion: " . $ex->getMessage() . "(Error: " . $ex->getCode() . ")</p>";
} finally {
    unset($conexion);
}

echo "<h2>Segunda conexion(tiene que fallar)</h2>";
try {
    $conexion2 = new PDO(DSN, USER, "timy");
} catch (PDOException $ex) {
    echo "<p>Error en la conexion: " . $ex->getMessage() . "(Error: " . $ex->getCode() . ")</p>";
} finally {
    unset($conexion2);
}