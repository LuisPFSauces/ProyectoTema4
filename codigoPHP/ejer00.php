<?php

echo "<h2>Crear base de datos</h2>";
highlight_file("../scriptDB/CreaDAW204DBDepartamentos.sql");
echo "<h2>Carga inicial</h2>";
highlight_file("../scriptDB/CargaInicialDAW204DBDepartamentos.sql");
echo "<h2>Borrar base de datos</h2>";
highlight_file("../scriptDB/BorraDAW204DBDepartamentos.sql");
echo "<h2>Archivos de configuracion</h2>";
echo "<h2>PDO</h2>";
highlight_file("../config/confDBPDO.php");
echo "<h2>MySQLi</h2>";
highlight_file("../config/confDBMySQLi.php");