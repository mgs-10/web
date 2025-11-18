<?php
error_reporting(0);
session_start();
require 'net.php';

$folio = $_POST['elEdit'];
$_SESSION["folio"] = $folio;
    
if($_SESSION["rank_usuario"]==3) {
    // Create connection
    $mysqli = new mysqli($serverName, $userName, $password, $dbName);
    if ($mysqli->connect_errno) {
    
        echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    
    } else {
        
        $myget = "SELECT T.id_folio, T.tipo_falla, T.status, T.date_opened, T.solucion, Ts.texto_tecnico, U.nom_usuario, Ra.nom_area, Ra.piso_area, Te.nom_usuario, Te.id_usuario, Rs.texto_status FROM tikets T INNER JOIN ref_tipo_soporte Ts ON T.tipo_falla = Ts.id_tipo_soporte INNER JOIN usuarios U ON T.solicitante_id = U.id_usuario INNER JOIN usuarios Te ON T.asistente = Te.id_usuario INNER JOIN ref_status Rs ON T.status = Rs.id_status INNER JOIN ref_area Ra ON U.area = Ra.id_area WHERE id_folio ='" . $folio . "' AND T.status = '2' ORDER BY T.id_folio";
        $result = $mysqli->query($myget);
        $nrows = $result->num_rows;
        /*//tikets
        id_folio	$fila[0]
        tipo_falla	$fila[1]
        status		$fila[2]
        date_opened	$fila[3]
        solucion	$fila[4]

        //ref_tipo_soporte
        texto_tecnico	$fila[5]

        //usuarios (solicitante)
        nom_usuario	$fila[6]
            
        //ref_area (solicitante)
        nom_area	$fila[7]
        piso_area	$fila[8]

        //usuarios (tecnicos)
        nom_usuario	$fila[9]
        id_usuario	$fila[10]

        //ref_status
        texto_status	$fila[11]*/
        
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
		<div class="contenedor">';
        
        if($nrows == 0){
            
            echo '<p style="text-align:center"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ya no hay soportes para éste folio</b><p>';
            $myupdate = "UPDATE `folios` SET status_folio='3' WHERE id_folio =" . $folio;
            $mysqli->query($myupdate);
            
        } else {
            
            echo'
            
            <table>
                <tr>
                    <form action="edit_tiket.php" method="POST">
                        <td colspan="6">
                            <b>Soportes del folio: ' . $folio . '</b><br><br>
                            <input type="hidden" name="folio" value="' . $folio . '">
                            <input type="hidden" name="tipo_falla" value="0">
                            <input type="hidden" name="tiket" value="0">
                        </td>
                    </form>
                </tr>';
            //<td><input type="submit" name="tiket" value=" TERMINAR TODOS "></td>
                while($fila = $result->fetch_row()) {
            
            
                //creando tabla
                echo '
            
            <form action="edit_tiket.php" method="POST">
                <input type="hidden" value="' . $fila[0] . '" name="folio">
                <tr>
                    <td><input type="hidden" value="' . $fila[1] . '" name="tipo_falla"><b>Tipo de falla:</b><br>' . $fila[5] . '</td>
                    <td><b>Usuario:</b><br>' . $fila[6] . '</td>
                    <td><b>Área:</b><br>' . $fila[7] . '</br>
                    <td><b>Piso:</b><br>' . $fila[8] . '</br>
                    <td><b>Técnico:</b><br>' . $fila[9] . '</br>
                    <td><input type="submit" name="tiket" value=" TERMINAR "><input type="submit" name="tiket" value=" EDITAR "></td>
                </tr>
            </form>';
            
                }
        
        echo '</table>';
            
        }
        
        echo'
        
        </div>
        <div class="pie">
            <form action="q_cl_folio.php" method="POST">
            <a href="../interfaces/interface3/3.php">REGRESAR</a>
            </form>
        </div>
    </body>
</html>';
        
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