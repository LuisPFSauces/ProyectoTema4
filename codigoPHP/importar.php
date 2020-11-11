<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Exportar SQL</title>
    </head>
    <body>
        <h1>Pincha el jodido boton</h1>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="submit" name="exportar" value="exportar">
        </form>
        <?php
        
        require_once '../config/confDBMySQLi.php';
        $SQL;
        if(isset($_REQUEST['exportar'])){
            exec("mysqldump -h".HOST." -u".USER." --password=".PASSWORD."> ".$SQL);
            echo $SQL;
        }
        ?>
    </body>
</html>
