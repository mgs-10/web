<?php
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

//numero de tipo de soporte por cada class de soporte
$noTipXClas = [];
//contador de fallas
$contFallas=0;

if($_SESSION["rank_usuario"]==5) {
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
        
        //numero de tipo de soporte por cada class de soporte
        for($i=0; $i<$no_ref_class_soporte; $i++) {
            $myget = "SELECT * FROM ref_tipo_soporte WHERE class_soporte='" . strval($i+1) . "'";
            $result = $mysqli->query($myget);
            $noTipXClas[] = $result->num_rows;
        }
        
        // Consultar conteo de tickets por estado
        $query = "SELECT Rs.texto_status, COUNT(*) as total 
                FROM tikets T 
                INNER JOIN ref_status Rs ON T.status = Rs.id_status 
                WHERE T.solicitante_id = '$id_usuario' 
                GROUP BY T.status";
        
        $result = $mysqli->query($query);

        // Inicializar el contador de estados
        $ticketCounts = [
            'Abierto' => 0,
            'Asignado' => 0,
            'Cerrado' => 0,
            'Impreso para Firma' => 0,
            'Impreso y Firmado' => 0,
        ];

        while ($row = $result->fetch_assoc()) {
            $ticketCounts[$row['texto_status']] = $row['total'];
        }


        echo'
                <!DOCTYPE>
                <html lang="es">
                    <head>
                        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
                        <link href="../../css/css_propios/estilo_interface5.css" type="text/css" rel="stylesheet">
                        <link rel="stylesheet" href="../../css/bootstrap/bootstrap.min.css">
                        <link rel="stylesheet" href="../../css/bootstrap/bootstrap-theme.min.css">
                        <link rel="stylesheet" href="sweetalert2.min.css">
                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.17/dist/sweetalert2.all.min.js"></script>
                        <script src="../../js/bootstrap.min.js"></script>
                        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        <script src="../../js/sidebar.js" defer></script>
                        <title>Usuario</title>
                            <style>
                                .sidebar {
                                    position: fixed;
                                    right: -250px; /* Oculta la barra inicialmente */
                                    top: 0;
                                    width: 250px;
                                    height: 100%;
                                    background: #5F9EA0;
                                    padding: 20px;
                                    box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
                                    transition: right 0.3s; /* Transición suave */
                                }
                                .sidebar.active {
                                    right: 0; /* Muestra la barra al pasar el mouse */
                                }
                                .contenedor {
                                    margin-right: 270px; /* Espacio para la barra lateral */
                                }
                                .sidebar-toggle {
                                    position: fixed;
                                    right: 0;
                                    top: 50%;
                                    transform: translateY(-50%);
                                    cursor: pointer;
                                    padding: 10px;
                                    background: #6F9EA0;
                                    color: white;
                                    border: none;
                                    border-radius: 5px;
                                    z-index: 1000;
                                }
                            </style>
                    </head>
                    <body>
                        <div class="divbar">
                            <div class="icono1"></div>
                            <div class="icono2"></div>
                        </div>
                        <div class="contenedor">
                            <div class="marco_formulario">
                                <form action="../../phplibs/crea_tiket.php" method="post" >
        ';
                                
                        for($i=0; $i<$no_ref_class_soporte; $i++) {
                                    
                            echo '
                                    
                            <div class="marco_botones" id="marco' . strval($i+1) . '">
                                    <a class="boton" data-bs-toggle="collapse" href="#inputs' . strval($i+1) . '"><div class="tFalla" id="tFalla' . strval($i+1) . '">' . $texto_class_soporte[$i] . '</div></a>
                                <div  class="collapse" id="inputs' . strval($i+1) . '">
                                    
                            ';
                                    
                                        for($j=0; $j<$noTipXClas[$i]; $j++) {
                                        
                                            echo '
                                        
                                                <input type="checkbox" class="btn-check" id="btn-check' . $contFallas . '" name="inputFalla' . $contFallas . '" value="' . strval($contFallas+1) . '"/>
                                                <label  class="btn btn-primary" for="btn-check' . $contFallas . '">   ' . $texto_usuario[$contFallas] . '</label>
                                        
                                            ';
                                            $contFallas++;
                                
                                        }
                            echo '
                                
                                </div>
                            </div>
                                    
                            ';
                        }
        
                                $contFallas=0;
                                        
        echo '
                                    <button  type="submit" class="btn btn-outline-success">ENVIAR</button>
                                    <a class="btn btn-outline-danger" href="/../../index.php" role="button">SALIR</a>
                                
                                </form>
                            </div>
                        
                        </div>
                            <div class="sidebar">
                                <h4>Mis Tickets</h4>
                                <p><strong>Tickets Abiertos:</strong> ' . $ticketCounts['Abierto'] . '</p>
                                <p><strong>Tickets Asignados:</strong> ' . $ticketCounts['Asignado'] . '</p>
                                <p><strong>Tickets Cerrados:</strong> ' . $ticketCounts['Cerrado'] . '</p>
                                <p><strong>Tickets Impresos para Firma:</strong> ' . $ticketCounts['Impreso para Firma'] . '</p>
                                <p><strong>Tickets Impresos y Firmados:</strong> ' . $ticketCounts['Impreso y Firmado'] . '</p>
                            </div>
                            <button class="sidebar-toggle" id="toggleSidebar">☰</button>
                                
                        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        <script src="/../../js/alert2.js"></script>
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