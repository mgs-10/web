<?php
error_reporting(0);
session_start();
require '../../phplibs/net.php';

if ($_SESSION["rank_usuario"] == 4) {
    $id_tecnico = $_SESSION["id_usuario"];

    // Conexión a la base de datos
    $mysqli = new mysqli($serverName, $userName, $password, $dbName);
    if ($mysqli->connect_errno) {
        echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        exit();
    }

    // Consulta para obtener tickets asignados al técnico
    $myget = "SELECT T.id_folio, T.tipo_falla, Ts.texto_tecnico, U.nom_usuario, Ra.nom_area, Ra.piso_area 
            FROM tikets T 
            INNER JOIN ref_tipo_soporte Ts ON T.tipo_falla = Ts.id_tipo_soporte 
            INNER JOIN usuarios U ON T.solicitante_id = U.id_usuario 
            INNER JOIN ref_area Ra ON U.area = Ra.id_area 
            WHERE T.asistente = ? AND T.status = '2'";

    $stmt = $mysqli->prepare($myget);
    $stmt->bind_param("i", $id_tecnico);
    $stmt->execute();
    $result = $stmt->get_result();
    $nrows = $result->num_rows;

    // Obtener el nombre del técnico para mostrarlo como encabezado
    /* $tecnico_nombre = '';
    if ($row = $result->fetch_assoc()) {
        $tecnico_nombre = $row['tecnico']; // Guardar el nombre del técnico
        $result->data_seek(0); // Regresar al inicio del result set
    } */

    echo '
    <!DOCTYPE html>
    <html lang="es">
        <head>
            <meta name="viewport" content="width=device-width"/>
            <meta charset="UTF-8">
            <link href="../../css/css_propios/estilo_interface3_q.css" type="text/css" rel="stylesheet">
            <link rel="stylesheet" href="../css/bootstrap/bootstrap.min.css">
            <script src="../js/bootstrap.min.js"></script>
            <title>Protikets Técnico</title>
        </head>
        <body>
            <div class="divbar">
                <div class="icono1"></div>
                <div class="icono2"></div>
            </div>
            <div class="contenedor"> ';

    if ($nrows == 0) {
        echo '<p>No hay tickets asignados para el Técnico con ID: ' . htmlspecialchars($id_tecnico) . '</p>';
    } else {
        echo '<table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Folio</th>
                        <th>Tipo de Falla</th>
                        <th>Solicitante</th>
                        <th>Área</th>
                        <th>Piso</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>';

        while ($fila = $result->fetch_assoc()) {
            echo '
                <tr>
                    <td>' . $fila['id_folio'] . '</td>
                    <td>' . $fila['texto_tecnico'] . '</td>
                    <td>' . $fila['nom_usuario'] . '</td>
                    <td>' . $fila['nom_area'] . '</td>
                    <td>' . $fila['piso_area'] . '</td>
                    <td>
                        <form action="edit_tiket.php" method="POST" style="display:inline;">
                            <input type="hidden" name="folio" value="' . htmlspecialchars($fila['id_folio']) . '">
                            <input type="submit" name="tiket" value="VER">
                        </form>
                    </td>
                </tr>';
        }

        echo '</tbody></table>';
    }

    echo '
            </div>
            <div class="pie">
                <a href="../../index.php">S A L I R</a>
            </div>
        </body>
    </html>';

    $stmt->close();
    $mysqli->close();
} else {
    echo '
    <!DOCTYPE html>
    <html lang="es">
        <head>
            <meta charset="UTF-8">
            <link href="/../css/estilo_error.css" type="text/css" rel="stylesheet">
            <title>ERROR FATAL DE ACCESO!!</title>
        </head>
        <body>
            <div class="container">
                Error Fatal de Acceso
            </div>
        </body>
    </html>';
}
?>
