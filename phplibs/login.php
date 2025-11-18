<?php
error_reporting(0);
session_start();
require 'net.php';
$user = $_POST['user'];
$pass = $_POST['pass'];


// Create connection
$mysqli = new mysqli($serverName, $userName, $password, $dbName);
if ($mysqli->connect_errno) {
    
    echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    
} else {
    
    //aquí comienza todos los inicios de seción con capas de usuario
    $myget = "SELECT id_usuario, no_empleado, rank_usuario, suports_counter, pass, usuario, area, nom_area, piso_area FROM usuarios U INNER JOIN ref_area A ON U.area = A.id_area WHERE usuario = '$user'";
    $result = $mysqli->query($myget);
    if($result->num_rows > 0) {
        
        $fila = $result->fetch_row();
        if($fila[4]==$pass) {
            
            $_SESSION["id_usuario"] = $fila[0];
            $_SESSION["no_empleado"] = $fila[1];
            $_SESSION["rank_usuario"] = $fila[2];
            $_SESSION["suports_counter"] = $fila[3];
            $_SESSION["pass"] = $fila[4];
            $_SESSION["usuario"] = $fila[5];
            $_SESSION["area"] = $fila[6];
            $_SESSION["nom_area"] = $fila[7];
            $_SESSION["piso_area"] = $fila[8];
            
            header("Location: /../interfaces/interface" . $fila[2] . "/" . $fila[2] . ".php");
            die();
            
        } else {
            
            echo '<script type="text/javascript">
            alert("Contraseña incorrecta !!!");
            window.location.assign("/../index.php");
            </script>';
            
        }
    
    } else {
        
        echo '<script type="text/javascript">
        alert("Usuario no valido !!!");
        window.location.assign("/../index.php");
        </script>';
        
    }
    $mysqli->close();
    
}

?>