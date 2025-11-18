<?php

error_reporting(0);
session_start();
require 'net.php';

if($_SESSION["rank_usuario"]==3) {
    // Create connection
    $mysqli = new mysqli($serverName, $userName, $password, $dbName);
    if ($mysqli->connect_errno) {
    
        echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    
    } else {
        
        $no_empleado = $_POST["p_no_empleado"];
        $nombre = $_POST["p_nombre"];
        $usuario = $_POST["p_usuario"];
        $area = $_POST["p_area"];
        $pass = $_POST["p_pass"];
        $id_usuario = $_POST["p_id_usuario"];
        $myinsert ="INSERT INTO `usuarios`(`no_empleado`, `rank_usuario`, `suports_counter`, `pass`, `usuario`, `nom_usuario`, `area`) VALUES ('" . $no_empleado . "','5','0','" . $pass . "','" . $usuario . "','" . $nombre . "','" . $area . "')";
        $mysqli->query($myinsert);
        
        $mysqli->close();
        echo "<script>alert('Usuario Creado!!');</script>";
        echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
        
    }
    
} else {
    echo '
    <!DOCTYPE>
    <html lang="es">
        <head>
            <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
            <link href="/../css/estilo_error.css" type="text/css" rel="stylesheet">
            <title>ERROR FATAL DE ACCESO!!</title>
        </head>
        <body>
            <div class="container">
                Error Fatal de Acceso
            </div>
        <body>
    </html>
    ';
}

?>