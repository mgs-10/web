<?php
error_reporting(0);
session_start();
require 'net.php';
$folio = $_POST["folio"];
$tipo_falla = $_POST["tipo_falla"];
$_SESSION["folio"] = $folio;
$edit_finish_bool = $_POST["tiket"];

//DB: ref_class_soporte ($f_class_soporte_)
$f_class_soporte_id_class_soporte = [];
$f_class_soporte_texto_class_soporte = [];
$no_registros_class_soporte;
    
//DB: ref_tipo_soporte ($f_ref_tipo_soporte_)
$f_ref_tipo_soporte_id_tipo_soporte = [];
$f_ref_tipo_soporte_class_soporte = [];
$f_ref_tipo_soporte_texto_usuario = [];
$f_ref_tipo_soporte_texto_tecnico = [];
$no_registros_ref_tipo_soporte;
    
//DB: tecnicos ($f_tecnicos_)
$f_tecnicos_id_usuario = [];
$f_tecnicos_nom_usuario = [];
$no_registros_tecnicos;

//DB: ref_status ($f_ref_status_)
$f_ref_status_id_status = [];
$f_ref_status_texto_status = [];
$no_registros_ref_status;

if($_SESSION["rank_usuario"]==3) {
    // Create connection
    $mysqli = new mysqli($serverName, $userName, $password, $dbName);
    if ($mysqli->connect_errno) {
    
        echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    
    } else {
        
        //DB: ref_tipo_soporte
        $myget = "SELECT * FROM ref_tipo_soporte";
        $result = $mysqli->query($myget);
        $nrows = $result->num_rows;
        $no_registros_ref_tipo_soporte = $nrows;
        for($i=0;$i<$nrows;$i++) {
            
            $fila = $result->fetch_row();
            $f_ref_tipo_soporte_id_tipo_soporte[] = $fila[0];
            $f_ref_tipo_soporte_class_soporte[] = $fila[1];
            $f_ref_tipo_soporte_texto_usuario[] = $fila[2];
            $f_ref_tipo_soporte_texto_tecnico[] = $fila[3];
            
        }
        
        //DB: tecnicos
        $myget = "SELECT U.id_usuario, nom_usuario FROM tecnicos T INNER JOIN usuarios U ON T.id_usuario = U.id_usuario";
        $result = $mysqli->query($myget);
        $nrows = $result->num_rows;
        $no_registros_tecnicos = $nrows;
        for($i=0;$i<$nrows;$i++) {
            $fila = $result->fetch_row();
            $f_tecnicos_id_usuario[] = $fila[0];
            $f_tecnicos_nom_usuario[] = $fila[1];
        }
        
        //DB: ref_status
        $myget = "SELECT * FROM ref_status";
        $result = $mysqli->query($myget);
        $nrows = $result->num_rows;
        $no_registros_ref_status = $nrows;
        for($i=0;$i<$nrows;$i++) {
            $fila = $result->fetch_row();
            $f_ref_status_id_status[] = $fila[0];
            $f_ref_status_texto_status[] = $fila[1];
        }
        
        //llenado del tiket
        $myget = "SELECT T.id_folio, T.tipo_falla, T.status, T.date_opened, T.solucion, Ts.texto_tecnico, U.nom_usuario, Ra.nom_area, Ra.piso_area, Te.nom_usuario, Te.id_usuario, Rs.texto_status FROM tikets T INNER JOIN ref_tipo_soporte Ts ON T.tipo_falla = Ts.id_tipo_soporte INNER JOIN usuarios U ON T.solicitante_id = U.id_usuario INNER JOIN usuarios Te ON T.asistente = Te.id_usuario INNER JOIN ref_status Rs ON T.status = Rs.id_status INNER JOIN ref_area Ra ON U.area = Ra.id_area WHERE id_folio = " . $folio . " AND tipo_falla = " . $tipo_falla;
        $result = $mysqli->query($myget);
        $fila = $result->fetch_row();
        
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
        <div class="contenedor">
        
        
        ';
        
        
        if($edit_finish_bool == " EDITAR ") {
            
            echo'
            
            
            <table class="edit_f_table">
                <form action="update_tiket.php" method="POST">
                    <tr>
                        <td colspan>Datos del Soporte "INDIVIDUAL"</td>
                        <td>Folio: ' . $fila[0] . '</td>
                        <td>Status:</td>
                        <td>
                            ' . $fila[11] . '
                        </td>
                    </tr>
                    <tr>
                        <td>Fecha de apertura:</td>
                        <td>' . $fila[3] . '</td>
                        <td>Tipo de soporte:</td>
                        <td>
                            <input type="hidden" value="' . $fila[1] . '" name="pre_tipo_falla">
                            <select name="tipo_falla">
                                <option value="' . $fila[1] . '" selected="selected" hidden="hidden">' . $fila[5] . '</option>
                            
            ';
        
        for($i=0; $i<$no_registros_ref_tipo_soporte; $i++) {
            
            echo '
                                <option value="' . $f_ref_tipo_soporte_id_tipo_soporte[$i] . '">' . $f_ref_tipo_soporte_texto_tecnico[$i] . '</option>
                ';
            
        }
        
        
            echo    '
            
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Solicitante:</td>
                        <td>' . $fila[6] . '</td>
                        <td>Piso:</td>
                        <td>' . $fila[8] . '</td>
                    </tr>
                    <tr>
                        <td>Área Solicitante:</td>
                        <td>' . $fila[7] . '</td>
                        <td>Técnico asignado:</td>
                        <td>
                            <input type="hidden" value="' . $fila[10] . '" name="pre_id_tecnico">
                            <select name="id_tecnico">
                                <option value="' . $fila[10] . '" selected="selected" hidden="hidden">' . $fila[9] . '</option>';
                        
        for($i=0; $i<$no_registros_tecnicos; $i++) {
            
            echo '
                                <option value="' . $f_tecnicos_id_usuario[$i] . '">' . $f_tecnicos_nom_usuario[$i] . '</option>
                ';
            
        }
        
        
            echo '
        
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Solución:<br><br></td>
                        <td colspan="4" class="box_text_solution"><input type="text" pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" name="solucion" value="' .$fila[4] . '" placeholder="Solución que se le dio al problema"></td>
                    </tr>
                    <tr>
                        <input type="hidden" value="' . $folio . '" name="folio">
                        <td colspan="4"><input type="submit" name="update" value=" EDITAR " class="ENVIAR"></td>
                    </tr>
                </form>
            </table>';
            
        } elseif ($edit_finish_bool == " TERMINAR ") {
            
            echo'
            
            
            <table class="edit_f_table">
                <form action="update_tiket.php" method="POST">
                    <tr>
                        <td colspan>Datos del Soporte "INDIVIDUAL"</td>
                        <td>
                            Folio: ' . $fila[0] . '
                            <input type="hidden" name="folio" value="' . $fila[0] . '">
                            <input type="hidden" name="pre_tipo_falla" value="' . $fila[1] . '">
                            <input type="hidden" name="tipo_falla" value="' . $fila[1] . '">
                            <input type="hidden" value="' . $fila[10] . '" name="pre_id_tecnico">
                            <input type="hidden" name="id_tecnico" value="' . $fila[10] . '">
                            <input type="hidden" name="solucion" value="' . $fila[4] . '">
                        </td>
                        <td>Status:</td>
                        <td>
                            ' . $fila[11] . '
                        </td>
                    </tr>
                    <tr>
                        <td>Fecha de apertura:</td>
                        <td>' . $fila[3] . '</td>
                        <td>Tipo de soporte:</td>
                        <td>
                            <input type="hidden" value="' . $fila[1] . '" name="pre_tipo_falla">
                            ' . $fila[5] . '
                        </td>
                    </tr>
                    <tr>
                        <td>Solicitante:</td>
                        <td>' . $fila[6] . '</td>
                        <td>Piso:</td>
                        <td>' . $fila[8] . '</td>
                    </tr>
                    <tr>
                        <td>Área Solicitante:</td>
                        <td>' . $fila[7] . '</td>
                        <td>Técnico asignado:</td>
                        <td>' . $fila[9] . '</td>
                    </tr>
                    <tr>
                        <td><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Solución:<br><br></td>
                        <td colspan="4" class="box_text_solution"><input type="text" pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" name="solucion" value="' .$fila[4] . '" placeholder="Solución que se le dio al problema"></td>
                    </tr>
                    <tr>
                        <input type="hidden" value="' . $folio . '" name="folio">
                        <td colspan="4"><input type="submit" name="update" value=" TERMINAR " class="ENVIAR"></td>
                    </tr>
                </form>
            </table>';
            
        } elseif ($edit_finish_bool == " TERMINAR TODOS ") {
            
            echo 'Terminar TODOS';
            
        } else {
            
            echo 'Error al llamar la función';
            
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