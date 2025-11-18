<?php

error_reporting(0);
session_start();
require 'net.php';

//DB: ref_area ($f_ref_area_)
$f_ref_area_id_area = [];
$f_ref_area_nom_area = [];
$f_ref_area_piso_area = [];
$f_ref_area_no_area = [];
$no_registros_ref_area;

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
			<div class="icono2"></div>
		</div>
		<div class="contenedor">';
        
        if(isset($_POST["p_no_empleado"]) || isset($_POST["p_nombre"])) {
            $no_empleado = $_POST["p_no_empleado"];
            $nombre = $_POST["p_nombre"];
            
            if(isset($_POST["actualiza_usuario"])) {
                
                $usuario = $_POST["p_usuario"];
                $area = $_POST["p_area"];
                $pass = $_POST["p_pass"];
                $id_usuario = $_POST["p_id_usuario"];
                
                $myupdate ="UPDATE usuarios SET `no_empleado`='" . $no_empleado . "',`pass`='" . $pass . "',`usuario`='" . $usuario . "',`nom_usuario`='" . $nombre . "',`area`='" . $area . "' WHERE id_usuario=" . $id_usuario;
                $mysqli->query($myupdate);
                
                $myget ="SELECT U.usuario, U.no_empleado, U.nom_usuario, A.id_area, A.nom_area, A.piso_area, U.pass, U.id_usuario FROM usuarios U INNER JOIN ref_area A ON U.area = A.id_area WHERE id_usuario=" . $id_usuario;
                $result = $mysqli->query($myget);
                
                if($fila = $result->fetch_row()) {
                    echo'
                    
                <table>
                    <tr>
                        <td>Usuario: ' . $fila[0] . '</td>
                        <td>Numero de Empleado: ' . $fila[1] . '</td>
                        <td>Nombre completo: ' . $fila[2] . '</td>
                        <td>Área: ' . $fila[4] . '</td>
                        <td>Piso: ' . $fila[5] . '</td>
                    </tr>
                </table>';
                    
                }
                
            } else {
                
                $myget = "SELECT * FROM ref_area ORDER BY nom_area";
                $result = $mysqli->query($myget);
                $nrows = $result->num_rows;
                $no_registros_ref_area = $nrows;
                
                for($i=0;$i<$nrows;$i++) {
                    
                    $fila = $result->fetch_row();
                    $f_ref_area_id_area[] = $fila[0];
                    $f_ref_area_nom_area[] = $fila[1];
                    $f_ref_area_piso_area[] = $fila[2];
                    $f_ref_area_no_area[] = $fila[3];
                
                }
                
                //$mycount ="SELECT COUNT(*) FROM usuarios U INNER JOIN ref_area A ON U.area = A.id_area WHERE U.no_empleado='" . $no_empleado . "' OR U.nom_usuario='" . $nombre . "'";
                $myget ="SELECT U.usuario, U.no_empleado, U.nom_usuario, A.id_area, A.nom_area, A.piso_area, U.pass, U.id_usuario FROM usuarios U INNER JOIN ref_area A ON U.area = A.id_area WHERE U.no_empleado='" . $no_empleado . "' OR U.nom_usuario='" . $nombre . "'";
                $result = $mysqli->query($myget);
                
                if($fila = $result->fetch_row()) {
                    echo'
                    
                    
                    
                        <div class="container-fluid vh-50" >
            <div class="" >
                <div class="rounded d-flex justify-content-center">
                    <div class="col-md-9 shadow-lg p-3 bg-light">
                        <div class="text-center">
                            <h3 class="text" style="color:#670F0F;">USUARIOS (EDITAR)</h3>
                        </div>
                        <form action="update_usuario.php" method="POST">
                            <div class="p-4">
                            <div class="input-group mb-3">
                                    <div class="input-group-text">Usuario</div></span>
                                    <input class="form-control" type="text" pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" name="p_usuario" value="' . $fila[0] . '">
                                </div>
                            
                                <div class="input-group mb-3">
                                    <div class="input-group-text">N° empleado</div></span>
                                    <input class="form-control" type="text" pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" name="p_no_empleado" value="' . $fila[1] . '">
                                </div>
                                
                                <div class="input-group mb-3">
                                    <div class="input-group-text">Nombre empleado</div></span>
                                    <input class="form-control" type="text" pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" name="p_nombre" value="' . $fila[2] . '">
                                </div>
                                
                                
                                <div class="input-group mb-3">
                                    <div class="input-group-text">Área</div></span>
                                    <select name="p_area" class="form-control">
                                <option value="' . $fila[3] . '" selected="selected" hidden="hidden">' . $fila[4] . '</option>';
                    
                    for($i=0; $i<$no_registros_ref_area; $i++) {
                        
                        echo '
                                <option value="' . $f_ref_area_id_area[$i] . '">' . $f_ref_area_nom_area[$i] . '</option>';
                    
                    }
                    
                    echo '
            
                            </select>
                                </div>
                                
                                <div class="input-group mb-3">
                                    <div class="input-group-text">Piso: ' . $fila[5] . '</div></span>
                                </div>
                                
                                <div class="input-group mb-3">
                                    <div class="input-group-text">Contraseña</div></span>
                                <input class="form-control" type="password" pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" name="p_pass" value="' . $fila[6] . '"><input type="hidden" name="p_id_usuario" value="' . $fila[7] . '">
                                </div>
                                
                                <div class="col text-center d-grid gap-2 col-6 mx-auto">
    				            <button class="btn btn-block"  style="background-color:#670F0F; color: white" type="submit" name="actualiza_usuario">
                                    GUARDAR
                                </button>
    			</div>         
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
                    
    ';
                    
                } else {
                    
                    echo '<div class="alert alert-danger"  role="alert" >No hay coincidencias, puede registrar como nuevo usuario.</div>
                    
                    <div class="container-fluid vh-50" >
            <div class="" >
                <div class="rounded d-flex justify-content-center">
                    <div class="col-md-9 shadow-lg p-1 bg-light">
                        <div class="text-center">
                            <h3 class="text" style="color:#670F0F;">USUARIOS (REGISTRO)</h3>
                        </div>
                        <form action="create_usuario.php" method="POST">
                            <div class="p-4">
                            <div class="input-group mb-3">
                                    <div class="input-group-text">Usuario</div></span>
                                    <input class="form-control" type="text" pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" name="p_usuario">
                                </div>
                            
                                <div class="input-group mb-3">
                                    <div class="input-group-text">N° empleado</div></span>
                                    <input class="form-control" type="text" pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" name="p_no_empleado">
                                </div>
                                
                                <div class="input-group mb-3">
                                    <div class="input-group-text">Nombre empleado</div></span>
                                    <input class="form-control" type="text" pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" name="p_nombre">
                                </div>
                                
                                
                                <div class="input-group mb-3">
                                    <div class="input-group-text">Área</div></span>
                                    <select name="p_area" class="form-control">';
                    
                    for($i=0; $i<$no_registros_ref_area; $i++) {
                        
                        echo '
                                <option value="' . $f_ref_area_id_area[$i] . '">' . $f_ref_area_nom_area[$i] . '</option>';
                    
                    }
                    
                    echo '
            
                            </select>
                                </div>
                                    <div class="input-group mb-3">
                                    <div class="input-group-text">Contraseña</div></span>
                                <input class="form-control" type="password" pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" name="p_pass">
                                </div>
                                
                                <div class="col text-center d-grid gap-2 col-6 mx-auto">
    				<button class="btn btn-block"  style="background-color:#670F0F; color: white" type="submit" name="actualiza_usuario" value=" CREAR ">
                                    GUARDAR
                                </button>
    			</div>         
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
                    
                    ';
                
                }
                
            }
            
        } else {
            
            echo'
            <div class="container-fluid vh-50" >
            <div class="" >
                <div class="rounded d-flex justify-content-center">
                    <div class="col-md-4 col-sm-12 shadow-lg p-5 bg-light">
                        <div class="text-center">
                            <h3 class="text" style="color:#670F0F;">BUESQUEDA Y REGISTRO DE USUARIOS</h3>
                        </div>
                        <form action="update_usuario.php" method="POST">
                            <div class="p-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-text">N° empleado</div></span>
                                    <input type="text" pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" class="form-control" id="exampleInputusuario" name="p_no_empleado" aria-describedby="folioHelp">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-text">Nombre</div></span>
                                    <input type="text" pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" class="form-control" id="exampleInputName" name="p_nombre">
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
        </div>
            ';
            
        }
        
        echo'
		</div>
        <div class="pie">
            <form action="q_cl_folio.php" method="POST">
            <a href="#" onclick="window.close()">SALIR</a>
            </form>
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