<?php
error_reporting(0);
session_start();
require 'net.php';

// Create connection
$mysqli = new mysqli($serverName, $userName, $password, $dbName);
if ($mysqli->connect_errno) {
    
    echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;

} else {
    
    
    $nom_tecnico = $_POST["tecnico"];
    $folio = $_POST["folio"];
    $myget = "SELECT id_usuario FROM `usuarios` WHERE nom_usuario = '" . $nom_tecnico . "'";
    $result = $mysqli->query($myget);
    $imp = $result->fetch_row();
    $id_tecnico = $imp[0];
    
    $myupdate1 = "UPDATE `folios` SET `id_tecnico`='" . $id_tecnico . "',`status_folio`='2' WHERE id_folio =" .$folio;
    $mysqli->query($myupdate1);
    $myupdate2 = "UPDATE `tikets` SET `asistente`='" . $id_tecnico . "',`status`='2' WHERE id_folio =" .$folio;
    $mysqli->query($myupdate2);
    $count = $mysqli->query("SELECT COUNT(*) FROM tikets WHERE id_folio=" . $folio);
    $contador = $count->fetch_row();
    $myupdate3 = "UPDATE tecnicos SET soportes_vivos = soportes_vivos+" . $contador[0] . " WHERE id_usuario=" . $id_tecnico;
    $mysqli->query($myupdate3);
    
    header("Location: /../interfaces/interface3/3.php");
    die();
    
}

?>