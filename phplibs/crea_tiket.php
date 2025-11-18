<?php
error_reporting(0);
session_start();
require 'net.php';

$compFallas = [];
$compTiket = [];

//aterrizando variables
$id_usuario = $_SESSION["id_usuario"];
$no_empleado = $_SESSION["no_empleado"];
$rank_usuario = $_SESSION["rank_usuario"];
$suports_counter = $_SESSION["suports_counter"];
$pass = $_SESSION["pass"];
$usuario = $_SESSION["usuario"];
$area = $_SESSION["area"];
$nom_area = $_SESSION["nom_area"];
$piso_area = $_SESSION["piso_area"];

// Create connection
$mysqli = new mysqli($serverName, $userName, $password, $dbName);
if ($mysqli->connect_errno) {
    
    echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;

} else {
    
    //DB: ref_tipo_soporte (cargamos todas las variables de entorno guardadas en la tabla ref_tipo_soporte)
    $myget = "SELECT * FROM ref_tipo_soporte";
    $result = $mysqli->query($myget);
    $nrows = $result->num_rows;
    $no_ref_tipo_soporte = $nrows;
    //$ref_tipo_soporte=$result;
    
    //agrupamos los soportes en un arreglo
    for($i=0; $i<$no_ref_tipo_soporte; $i++) {
        if(isset($_POST['inputFalla' . $i])) {
            $compFallas[] = $_POST['inputFalla' . $i];
        }
    }
    
    //Agrupamos las peticiones junto con sus respectivos datos y generamos un tiket
    //1.- Asignamos folio
    //$myinsert = "INSERT INTO `folios`(`soportes_x_folio`, `status_folio`) VALUES ('" . count($compFallas) . "', '1')";
    $myinsert = "INSERT INTO `folios`(`soportes_x_folio`, `id_solicitante`, `id_area_solicitante`, `piso_solicitante`, `status_folio`) VALUES ('" . count($compFallas) . "', '" . $id_usuario . "','" . $area . "','" . $piso_area . "','1')";
    if(count($compFallas)>0) {
        $mysqli->query($myinsert);
        //2.- Recuperamos el numero de folio y asignamos tikets con el folio recuperado
        $myget = "SELECT MAX(id_folio) AS id FROM folios";
        $result = $mysqli->query($myget);
        $fila = $result->fetch_row();
        $folio = $fila[0];
        $solicitante = $_SESSION["id_usuario"];
        for($i=0; $i<count($compFallas); $i++) {
        
            $myinsert = "INSERT INTO `tikets`(`id_folio`, `tipo_falla`, `solicitante_id`, `status`, `date_opened`) VALUES (" . $folio . "," . $compFallas[$i] . "," . $solicitante . ",'1',NOW())";
            $mysqli->query($myinsert);
        
        }
        //3.- Modificamos el folio para cargar los tikets asignados a él
        $myget = "SELECT * FROM tikets WHERE id_folio='" . $folio . "'";
        $result = $mysqli->query($myget);
        $nrows = $result->num_rows;
        $saveTikets = [];
        for($i=0; $i<$nrows; $i++) {
            $fila = $result->fetch_row();
            $saveTikets[] = $fila[0];
        }
        $myupdate = "UPDATE `folios` SET `soportes_x_folio`='" . count($compFallas) . "' WHERE id_folio='" . $folio .  "'";
        $mysqli->query($myupdate);
    }
    
    $saveTikets = [];
    $mysqli->close();
    header("Location: /../interfaces/interface5/5.php");
    die();
    
    }

?>