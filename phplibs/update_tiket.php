<?php
//error_reporting(0);
session_start();
require 'net.php';
$folio = $_POST['folio'];
$pre_tipo_falla = $_POST['pre_tipo_falla'];
$pre_id_tecnico = $_POST['pre_id_tecnico'];
$tipo_falla = $_POST['tipo_falla'];
$id_tecnico = $_POST['id_tecnico'];
$solucion = $_POST['solucion'];
$update = $_POST['update'];

if($_SESSION["rank_usuario"]==3) {
    // Create connection
    $mysqli = new mysqli($serverName, $userName, $password, $dbName);
    if ($mysqli->connect_errno) {
    
        echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    
    } else {
        
        echo '
        
<!DOCTYPE>
<html lang="es">
    <head>
        <meta name="viewport" content="width=device-width"/>
		<meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
		<link href="../css/css_propios/estilo_interface3_q.css" type="text/css" rel="stylesheet">
		<link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css">
		<link rel="stylesheet" href="../css/bootstrap/bootstrap-theme.min.css">
		<script src="../js/bootstrap.min.js"></script>
		<title>Protikets Log Gestor</title>
    </head>
    <body>
        <div class="divbar">
            <div class="icono1"></div>
            <div class="icono2"></div>
        </div>        
        <div class="contenedor">
        
        ';
        
        if($update == " EDITAR ") {
            
            $myupdate = "UPDATE `tikets` SET `tipo_falla`='" . $tipo_falla . "',`asistente`='" . $id_tecnico . "', `solucion`='" . $solucion . "' WHERE id_folio = '" . $folio . "' AND tipo_falla = '" . $pre_tipo_falla . "'";
            $mysqli->query($myupdate);
            $myget = "SELECT * FROM tikets T INNER JOIN ref_tipo_soporte Ts ON T.tipo_falla = Ts.id_tipo_soporte INNER JOIN usuarios U ON T.solicitante_id = U.id_usuario INNER JOIN usuarios Te ON T.asistente = Te.id_usuario INNER JOIN ref_status Rs ON T.status = Rs.id_status INNER JOIN ref_area Ra ON U.area = Ra.id_area WHERE id_folio = " . $folio . " AND tipo_falla = " . $tipo_falla;
            $result = $mysqli->query($myget);
            $fila = $result->fetch_row();
            $myupdate3 = "UPDATE tecnicos SET soportes_vivos = soportes_vivos-1 WHERE id_usuario=" . $pre_id_tecnico;
            $mysqli->query($myupdate3);
            $myupdate3 = "UPDATE tecnicos SET soportes_vivos = soportes_vivos+1 WHERE id_usuario=" . $fila[3];
            $mysqli->query($myupdate3);
            echo '
            
            <table class="edit_f_table">
                    <tr>
                        <td colspan><b>Datos del Soporte "INDIVIDUAL"</b></td>
                        <td><b>Folio: ' . $fila[0] . '</b></td>
                        <td>Status:</td>
                        <td>
                            ' . $fila[29] . '
                        </td>
                    </tr>
                    <tr>
                        <td>Fecha de apertura:</td>
                        <td>' . $fila[5] . '</td>
                        <td>Tipo de soporte:</td>
                        <td>' . $fila[11] . '</td>
                    </tr>
                    <tr>
                        <td>Solicitante:</td>
                        <td>' . $fila[18] . '</td>
                        <td>Piso:</td>
                        <td><b>' . $fila[32] . '</b></td>
                    </tr>
                    <tr>
                        <td>Área Solicitante:</td>
                        <td>' . $fila[31] . '</td>
                        <td>Técnico asignado:</td>
                        <td>' . $fila[26] . '</td>
                    </tr>
                    <tr>
                        <td><b><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Solución:<br><br></b></td>
                        <td colspan="4" class="box_text_solution">' .$fila[7] . '</td>
                    </tr>
            </table>';
            
        } elseif ($update == " TERMINAR ") {
            
            $myupdate = "UPDATE `tikets` SET `status`='3',`date_clossed`=NOW(),`solucion`='" . $solucion . "' WHERE id_folio = " . $folio . " AND tipo_falla = " . $tipo_falla;
            $mysqli->query($myupdate);
            $myget = "SELECT * FROM tikets T INNER JOIN ref_tipo_soporte Ts ON T.tipo_falla = Ts.id_tipo_soporte INNER JOIN usuarios U ON T.solicitante_id = U.id_usuario INNER JOIN usuarios Te ON T.asistente = Te.id_usuario INNER JOIN ref_status Rs ON T.status = Rs.id_status INNER JOIN ref_area Ra ON U.area = Ra.id_area WHERE id_folio = " . $folio . " AND tipo_falla = " . $tipo_falla;
            $result = $mysqli->query($myget);
            $fila = $result->fetch_row();
            $myupdate3 = "UPDATE tecnicos SET soportes_vivos = soportes_vivos-1 WHERE id_usuario=" . $fila[20];
            $mysqli->query($myupdate3);
            $myupdate3 = "UPDATE tecnicos SET soportes_atendidos = soportes_atendidos+1 WHERE id_usuario=" . $fila[20];
            $mysqli->query($myupdate3);
            $myupdate4 = "UPDATE usuarios SET suports_counter = suports_counter+1 WHERE id_usuario=" . $fila[12];
            $mysqli->query($myupdate4);
            echo '
            
            <table class="edit_f_table">
                    <tr>
                        <td colspan><b>Datos del Soporte "INDIVIDUAL"</b></td>
                        <td><b>Folio: ' . $fila[0] . '</b></td>
                        <td>Status:</td>
                        <td>
                            ' . $fila[29] . '
                        </td>
                    </tr>
                    <tr>
                        <td>Fecha de apertura:</td>
                        <td>' . $fila[5] . '</td>
                        <td>Tipo de soporte:</td>
                        <td>' . $fila[11] . '</td>
                    </tr>
                    <tr>
                        <td>Solicitante:</td>
                        <td>' . $fila[18] . '</td>
                        <td>Piso:</td>
                        <td><b>' . $fila[32] . '</b></td>
                    </tr>
                    <tr>
                        <td>Área Solicitante:</td>
                        <td>' . $fila[31] . '</td>
                        <td>Técnico asignado:</td>
                        <td>' . $fila[26] . '</td>
                    </tr>
                    <tr>
                        <td><b><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Solución:<br><br></b></td>
                        <td colspan="4" class="box_text_solution">' .$fila[7] . '</td>
                    </tr>
            </table>';
            
        } else {
            
        }
        
        echo '
        
        </div>
        <div class="pie">
            <form action="q_cl_folio.php" method="POST">
                <input type="hidden" name="elEdit" value="' . $folio . '">
                <input type="submit" value="REGRESAR">
            </form>
        </div>
    </body>
</html>
        
        ';
        $mysqli->close();
    
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