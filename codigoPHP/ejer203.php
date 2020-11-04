<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Buscar departamento</title>
    </head>
    <body>
        <?php
        require_once '../core/201020libreriaValidacion.php';
        require_once '../config/confDBPDO.php';
        
            $errores = array(
                "codigo" => null,
                "descripcion" => null,
                "conexion" => null
            );
            
            $formulario = array(
              "codigo" => null,
                "descripcion" => null  
            );
            
            define("OBLIGATORIO", 1);
            $entradaOK = true;
            
            if( isset($_REQUEST['enviar'])){
                
                $errores["codigo"] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['codigo'], 3, 3, OBLIGATORIO);
                $errores["descripcion"] = validacionFormularios::comprobarAlfaNumerico($_REQUEST['descripcion'], 25, 5, OBLIGATORIO);
                
                foreach ($errores as $clave => $error){
                    if($error != null){
                        $_REQUEST[$clave] = "";
                        $entradaOK = false;
                    }
                }
                
                try {
                    $conexion = new PDO( DSN, USER, PASSWORD );
                    $resultado
                } catch (Exception $exc) {
                    $errores['conexion'] = "Error al realizar la conexion ( ".$exc ->getCode()." )";
                    $entradaOK = false;
                } finally {
                    unset($conexion);
                }
                            
            } else {
                $entradaOK = false;
            }
            
            if($entradaOK){
                $formulario['codigo'] = $_REQUEST['codigo'];
                $formulario['descripcion'] = $_REQUEST['descripcion'];
            } else{
                
            }
                
        ?>
    </body>
</html>
