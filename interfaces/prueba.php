<?php
error_reporting(0);
session_start();
require '../../phplibs/net.php';

// Atarizando variables
$id_usuario = $_SESSION["id_usuario"];
$rank_usuario = $_SESSION["rank_usuario"];

if ($rank_usuario == 5) {
    // Crear conexión
    $mysqli = new mysqli($serverName, $userName, $password, $dbName);
    if ($mysqli->connect_errno) {
        echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    } else {
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
            'Impreso para firma' => 0,
            'Impreso, firmado' => 0,
        ];

        while ($row = $result->fetch_assoc()) {
            $ticketCounts[$row['texto_status']] = $row['total'];
        }

        echo '
            <!DOCTYPE>
            <html lang="es">
                <head>
                    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
                    <link href="../../css/css_propios/estilo_interface5.css" type="text/css" rel="stylesheet">
                    <link rel="stylesheet" href="../../css/bootstrap/bootstrap.min.css">
                    <link rel="stylesheet" href="../../css/bootstrap/bootstrap-theme.min.css">
                    <script src="../../js/bootstrap.min.js"></script>
                    <title>Usuario</title>
                </head>
                <body>
                    <div class="divbar">
                        <div class="icono1"></div>
                        <div class="icono2"></div>
                    </div>
                    <div class="contenedor">
                        <h2>Mis Tickets</h2>
                        <div class="ticket-counts">
                            <p><strong>Tickets Abiertos:</strong> ' . $ticketCounts['Abierto'] . '</p>
                            <p><strong>Tickets Asignados:</strong> ' . $ticketCounts['Asignado'] . '</p>
                            <p><strong>Tickets Cerrados:</strong> ' . $ticketCounts['Cerrado'] . '</p>
                            <p><strong>Tickets Impresos para firma:</strong> ' . $ticketCounts['Impreso para firma'] . '</p>
                            <p><strong>Tickets Impresos, firmados:</strong> ' . $ticketCounts['Impreso, firmado'] . '</p>
                        </div>
                        <div class="marco_formulario">
                            <form action="../../phplibs/crea_tiket.php" method="post">
        ';

        // Código existente para mostrar tipos de soporte
        // ...

        echo '
                                    <button type="submit" class="btn btn-outline-success">ENVIAR</button>
                                    <a class="btn btn-outline-danger" href="/../../index.php" role="button">SALIR</a>
                                </form>
                            </div>
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
            </body>
        </html>
    ';
}
?>
