<?php
error_reporting(0);
session_start();
require 'pdf/fpdf.php';
require 'net.php';
$folio = $_POST["folio"];
$nombre = $_POST["nombre"];

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
		<link href="../../css/css_propios/estilo_interface3_q.css" type="text/css" rel="stylesheet">
		<link rel="stylesheet" href="../../css/bootstrap/bootstrap.min.css">
		<link rel="stylesheet" href="../../css/bootstrap/bootstrap-theme.min.css">
		<script src="../../js/bootstrap.min.js"></script>
		<title>Protikets Log Gestor</title>
	</head>
	<body>
		<div class="divbar">
			<div class="icono1"></div>
			<div class="icono2">Procuraduría Social de<br> la Ciudad de México</div>
		</div>
		<div class="contenedor">';
        
        if(isset($_POST["folio"]) || isset($_POST["nombre"])) {
            
            $myget2 ="SELECT COUNT(*) FROM tikets T INNER JOIN usuarios U ON T.solicitante_id = U.id_usuario WHERE T.id_folio ='" . $folio . "' OR U.nom_usuario='" . $nombre . "'";
            $result = $mysqli->query($myget2);
            $fila = $result->fetch_row();
            $contador = $fila[0];
            
            if($contador>0) {
                
                echo'
            <table>
                <tr>
                    <td>FOLIO</td>
                    <td>SOLICITANTE</td>
                    <td>ÁREA</td>
                    <td>PISO</td>
                    <td>TIPO DE SOPORTE</td>
                    <td>TÉCNICO</td>
                    <td>FECHA DE SOLICITUD</td>
                    <td>FECHA DE TERMINO</td>
                    <td>SOLUCIÓN</td>
                    <td>SATUS</td>
                </tr>';
                
                for($i=0;$i<$contador;$i++) {
                    
                    $myget="SELECT T.id_folio, U.nom_usuario, A.nom_area, A.piso_area, Ts.texto_tecnico, Te.nom_usuario, T.date_opened, T.date_clossed, T.solucion, S.texto_status FROM tikets T INNER JOIN usuarios U ON T.solicitante_id = U.id_usuario INNER JOIN ref_area A ON U.area = A.id_area LEFT JOIN usuarios Te ON T.asistente = Te.id_usuario INNER JOIN ref_tipo_soporte Ts ON T.tipo_falla = Ts.id_tipo_soporte INNER JOIN ref_status S ON T.status = S.id_status WHERE T.id_folio ='" . $folio . "' OR U.nom_usuario='" . $nombre . "' LIMIT " . $i*20 . ", 20";
                    $result = $mysqli->query($myget);
                    while($fila = $result->fetch_row()) {
                        
                        echo'
                        
                <tr>
                    <form action="reporte_detalle_pdf.php" method="post" target="blanck">
                    <td><input type="submit" name="folio" value="' . $fila[0] . '"></td>
                    <td>' . $fila[1] . '
                    <input type="hidden" value="' . $fila[1] . '" name="usuario"></td>
                    <td>' . $fila[2] . '
                    <input type="hidden" value="' . $fila[2] . '" name="area"></td>
                    <td>' . $fila[3] . '
                    <input type="hidden" value="' . $fila[3] . '" name="piso"></td>
                    </form>
                    <td>' . $fila[4] . '</td>
                    <td>' . $fila[5] . '</td>
                    <td>' . $fila[6] . '</td>
                    <td>' . $fila[7] . '</td>
                    <td>' . $fila[8] . '</td>
                    <td>' . $fila[9] . '</td>
                </tr>';
                        /*print($i);
                        print_r($fila);*/
                        
                    }
                    
                }
                echo'
            </table>';
                
            } else {
                echo'<div class="alert alert-danger" role="alert">
 NO HAY REGISTROS, INTENTE DE NUEVO !!!
</div>';
                echo'
       <div class="container-fluid vh-50" >
            <div class="" >
                <div class="rounded d-flex justify-content-center">
                    <div class="col-md-4 col-sm-12 shadow-lg p-5 bg-light">
                        <div class="text-center">
                            <h3 class="text" style="color:#670F0F;">BUSQUEDA DETALLADA DE TICKET</h3>
                        </div>
                        <form action="reporte_q_detalle.php" method="POST">
                            <div class="p-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-text">NOMBRE</div></span>
                                    <input type="text" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+"  id="nombre" name="nombre" class="form-control">
                                </div>
                                <div class="input-group mb-3">
                                      <div class="input-group-text">FOLIO</div></span>
                                    <input type="text" pattern="[0-9\s]+" id="folio" name="folio" class="form-control">
                                </div>
                                <div class="col text-center d-grid gap-2 col-6 mx-auto">
    				<button class="btn btn-block"  style="background-color:#670F0F; color: white" type="submit">
                                    BURCAR
                                </button>
    			</div>         
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>';
            }
            
        } else {
            
            echo'
            <div class="container-fluid vh-50" >
            <div class="" >
                <div class="rounded d-flex justify-content-center">
                    <div class="col-md-4 col-sm-12 shadow-lg p-5 bg-light">
                        <div class="text-center">
                            <h3 class="text" style="color:#670F0F;">BUSQUEDA DETALLADA DE TICKET</h3>
                        </div>
                        <form action="reporte_q_detalle.php" method="POST">
                            <div class="p-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-text">NOMBRE</div></span>
                                    <input type="text" pattern="[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+"  id="nombre" name="nombre" class="form-control">
                                </div>
                                <div class="input-group mb-3">
                                      <div class="input-group-text">FOLIO</div></span>
                                    <input type="text" pattern="[0-9\s]+" id="folio" name="folio" class="form-control">
                                </div>
                                <div class="col text-center d-grid gap-2 col-6 mx-auto">
    				<button class="btn btn-block"  style="background-color:#670F0F; color: white" type="submit">
                                    BURCAR
                                </button>
    			</div>         
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>';
        
        }
        
        echo '
        
        </div>
        <div class="pie">
            <form action="q_cl_folio.php" method="POST">
            <a href="#" onclick="window.close()"> TERMINÉ </a>
            </form>
        </div>
        <script src="http://code.jquery.com/jquery-latest.js"></script>
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
        </body>
    </html>
    ';
    
}

?>