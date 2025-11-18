<?php
// Iniciar la sesión y deshabilitar errores si es necesario
// session_start();
// error_reporting(0);

require '../phplibs/net.php';

// Conexión a la base de datos
$mysqli = new mysqli($serverName, $userName, $password, $dbName);
if ($mysqli->connect_errno) {
    die("Error de conexión a MySQL: " . $mysqli->connect_error);
}

// Consultar tickets
$query = "SELECT T.*, RTS.texto_usuario FROM tikets T LEFT JOIN ref_tipo_soporte RTS ON T.tipo_falla = RTS.id_tipo_soporte";
$result = $mysqli->query($query);

if (!$result) {
    die("Error en la consulta: " . $mysqli->error);
}

$tickets = [];
while ($row = $result->fetch_assoc()) {
    $tickets[] = $row;
}

// Calcular datos para el dashboard
$totalTickets = count($tickets);
$totalResueltos = count(array_filter($tickets, fn($t) => $t['status'] == 'Cerrado'));
$promedioResolucion = 0;

foreach ($tickets as $ticket) {
    if ($ticket['date_clossed']) {
        $duracion = strtotime($ticket['date_clossed']) - strtotime($ticket['date_opened']);
        $promedioResolucion += $duracion;
    }
}
$promedioResolucion = $totalResueltos ? round($promedioResolucion / $totalResueltos / 60) : 0; // en minutos

// Contar tipos de tickets
$tiposTickets = [];
foreach ($tickets as $ticket) {
    $tipo = $ticket['texto_usuario']; // Usar el texto del tipo
    if (!isset($tiposTickets[$tipo])) {
        $tiposTickets[$tipo] = 0;
    }
    $tiposTickets[$tipo]++;
}

$tiposJSON = json_encode($tiposTickets);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta name="viewport" content="width=device-width"/>
    <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
    <link href="../../css/css_propios/estilo_interface3_q.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/bootstrap/bootstrap-theme.min.css">
    <script src="../../js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Monitoreo</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 80%; margin: auto; }
        canvas { max-width: 600px; }
    </style>
</head>
<body>
    <div class="divbar">
        <div class="icono1"></div>
        <div class="icono2"></div>
    </div>

    <div class="container">
        <h1>CENTRO DE MONITOREO</h1>
        <div>
            <h3>Total de Tickets: <?= $totalTickets ?></h3>
            <h3>Total Resueltos: <?= $totalResueltos ?></h3>
            <h3>Tiempo Promedio de Resolución: <?= $promedioResolucion ?> minutos</h3>
        </div>
        
        <canvas id="ticketsChart"></canvas>
    </div>

    <script>
        const tiposTickets = <?= $tiposJSON ?>;
        const labels = Object.keys(tiposTickets);
        const data = Object.values(tiposTickets);

        const ctx = document.getElementById('ticketsChart').getContext('2d');
        const ticketsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Tickets por Tipo',
                    data: data,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>

    <div class="pie">
        <form action="q_cl_folio.php" method="POST">
            <a href="#" onclick="window.close()">SALIR</a>
        </form>
    </div>

    <script src="http://code.jquery.com/jquery-latest.js"></script>
</body>
</html>

<?php
$mysqli->close();
?>
