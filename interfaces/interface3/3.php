<?php
//header("refresh: 60;");
error_reporting(0);
session_start();
require '../../phplibs/net.php';

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

//DB: ref_class_soporte
$id_class_soporte = [];
$texto_class_soporte = [];
$no_ref_class_soporte;

//DB: ref_tipo_soporte
$id_tipo_soporte = [];
$class_soporte = [];
$texto_usuario = [];
$texto_tecnico = [];
$no_ref_tipo_soporte;

//DB: Tecnicos
$lista_tecnicos = [];
$no_tecnicos;

//numero de tipo de soporte por cada class de soporte
$noTipXClas = [];

if($_SESSION["rank_usuario"]==3) {
    // Create connection
    $mysqli = new mysqli($serverName, $userName, $password, $dbName);
    if ($mysqli->connect_errno) {
    
        echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    
    } else {
        //DB: ref_class_soporte
        $myget = "SELECT * FROM ref_class_soporte";
        $result = $mysqli->query($myget);
        $nrows = $result->num_rows;
        $no_ref_class_soporte = $nrows;
        for($i=0;$i<$nrows;$i++) {
            $fila = $result->fetch_row();
            $id_class_soporte[] = $fila[0];
            $texto_class_soporte[] = $fila[1];
        }
        //DB: ref_tipo_soporte
        $myget = "SELECT * FROM ref_tipo_soporte";
        $result = $mysqli->query($myget);
        $nrows = $result->num_rows;
        $no_ref_tipo_soporte = $nrows;
        for($i=0;$i<$nrows;$i++) {
            $fila = $result->fetch_row();
            $id_tipo_soporte[] = $fila[0];
            $class_soporte[] = $fila[1];
            $texto_usuario[] = $fila[2];
            $texto_tecnico[] = $fila[3];
        }
        //DB: tecnicos
        $myget = "SELECT nom_usuario FROM tecnicos T INNER JOIN usuarios U ON T.id_usuario = U.id_usuario ORDER BY U.nom_usuario";
        $result = $mysqli->query($myget);
        $nrows = $result->num_rows;
        $no_tecnicos = $nrows;
        for($i=0;$i<$nrows;$i++) {
            $fila = $result->fetch_row();
            $lista_tecnicos[] = $fila[0];
        }
        //numero de tipo de soporte por cada class de soporte
        $myget = "SELECT * FROM ref_tipo_soporte WHERE class_soporte='";
        for($i=0; $i<$no_ref_class_soporte; $i++) {
            $result = $mysqli->query($myget . $i+1 . "'");
            $noTipXClas[] = $result->num_rows;
        }
        
        echo '
<!DOCTYPE>
<html lang="es">
	<head>
		<meta name="viewport" content="width=device-width"/>
		<meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
		<link href="../../css/css_propios/estilo_interface3.css" type="text/css" rel="stylesheet">
		<link rel="stylesheet" href="../../css/bootstrap/bootstrap.min.css">
		<link rel="stylesheet" href="../../css/bootstrap/bootstrap-theme.min.css">
		<script src="../../js/bootstrap.min.js"></script>
		<title>Protikets Gestor</title>
	</head>
	<body>
		<div class="divbar">
			<div class="icono1"></div>
			<div class="icono2"></div>
		</div>
		<div class="contenedor">
            <div class="menu_gestor">
                <a href="../../phplibs/reportes_pdf.php" target="blank"><button type="button" class="boton_menu_gestor">IMPRIMIR PARA FIRMA</button></a>
				<a href="../../phplibs/reporte_q_detalle.php" target="blank"><button type="button" class="boton_menu_gestor">DETALLE DEL TICKET</button></a>
				<a href="../../phplibs/update_usuario.php" target="blank"><button type="button" class="boton_menu_gestor">USUARIOS</button></a>
				<a href="../../dashboard/graficas.php" target="_blank"><button type="button" class="boton_menu_gestor">MONITOREO</button></a> 
				<a href="../../index.php"><button type="button" class="boton_menu_gestor boton_danger salir-boton">SALIR</button></a>
            </div>
            <div class="pool_s_abiertos">
				    <table  class="table" id="tabla_s_abiertos">
                        <thead>
                            <td colspan="7" style=" text-align: center;"><b>TIKETS ENTRADA</b></td>
                        </thead>
                        <tr align="center">
						    <th><b>TIKETs</b></th>
						    <th><b>ÁREA</b></th>
						    <th><b>PISO</b></th>
                            <th><b>SOLICITANTE</b></th>
                            <th><b>SOPORTE</b></th>
                            <th colspan="2"><b>TÉCNICO</b></th>
                        </tr>
						
        ';
        
        //llamado a DB de todos los soportes sin atender
        $myget = "SELECT F.id_folio, F.piso_solicitante, U.nom_usuario, A.nom_area, So.texto_tecnico FROM folios F INNER JOIN usuarios U ON F.id_solicitante = U.id_usuario INNER JOIN ref_area A ON F.id_area_solicitante = A.id_area INNER JOIN tikets Ti ON Ti.id_folio = F.id_folio INNER JOIN ref_tipo_soporte So ON Ti.tipo_falla = So.id_tipo_soporte WHERE F.status_folio=1 ORDER BY id_folio";
        $result = $mysqli->query($myget);
        
        while($fila = $result->fetch_row()) {
            
            echo '
                    <form action="../../phplibs/asigna_folio.php" method="POST">
                        <tr>
						    <td><input type="hidden" value="' . $fila[0] . '" name="folio"><b>' . $fila[0] . '</b></td>
						    <td>' . $fila[3] . '</td>
						    <td>' . $fila[1] . '</td>
                            <td>' . $fila[2] . '</td>
                            <td>' . $fila[4] . '</td>
                            <td>
                                <select name="tecnico">';
            
            
                                    for($i=0; $i<$no_tecnicos; $i++) {
                                    
                                        echo '
                                    
                                            <option value="' . $lista_tecnicos[$i] . '">' . $lista_tecnicos[$i] . '</option>
                                    
                                        ';
                                    
                                    }   
                                    
                                    
                                    
            echo '              </select>
                            </td>
                                <td><input type="submit" name="boton" value=" ASIGNAR "></td>
                        </tr>
                    </form>
            ';
            
        }
        
        echo '
                    </table>
            </div>
            <div class="pool_s_asignados">
                <form action="../../phplibs/q_cl_folio.php" method="POST">
                    <table class="table" id="tabla_s_asignados">
                        <thead>
                            <td colspan="6" style="color: white;  text-align: center;"><b>TIKETS SALIDA</b></td> 
                        </thead>
                    
                        <tr align="center">
				            <th><b>TIKETs</b></th>
						    <th><b>ÁREA</b></th>
				            <th><b>PISO</b></th>
                            <th><b>SOLICITANTE</b></th>
				            <th><b>TÉCNICO</b></th>
                        </tr>  
                    
			
        ';
        
        //llamado a DB de todos los soportes asignados
        $myget = "SELECT F.id_folio, F.piso_solicitante, U.nom_usuario, A.nom_area, Te.nom_usuario FROM folios F INNER JOIN usuarios U ON F.id_solicitante = U.id_usuario INNER JOIN ref_area A ON F.id_area_solicitante = A.id_area LEFT JOIN usuarios Te ON F.id_tecnico = Te.id_usuario WHERE F.status_folio=2 ORDER BY Te.nom_usuario";
        $result = $mysqli->query($myget);
        while($fila = $result->fetch_row()) {
            
            echo '
                        <tr>
                            <td><input type="submit" name="elEdit" value="' . $fila[0] . '"></td>
                            <td>' . $fila[3] . '</td>
                            <td>' . $fila[1] . '</td>
				            <td>' . $fila[2] . '</td>
                            <td>' . $fila[4] . '</td>
                        </tr>                   
            ';
            
        }
        
        echo'
                    </table>
			    </form>
            </div>
            <dic class="lista_tecnicos">
                <table>
                    <tr>
                        <td style="color: #700707;">TÉCNICOS</td>
                        <td style="color: #700707;">SOPORTES ACTÍVOS</td>
                    </tr>';
        $mygetT = "SELECT U.usuario, T.soportes_vivos FROM tecnicos T INNER JOIN usuarios U ON T.id_usuario = U.id_usuario ORDER BY U.usuario";
        $result = $mysqli->query($mygetT);
        while($fila = $result->fetch_row()) {
            
            echo'
            
                    <tr>
                        <td>' . $fila[0] . '</td>
                        <td>' . $fila[1] . '</td>
                    </tr>
            
            ';
            
        }
        
        echo'
                </table>
            </div>
		</div>
        <script src="http://code.jquery.com/jquery-latest.js"></script>
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