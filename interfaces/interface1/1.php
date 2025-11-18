<?php
error_reporting(0);
session_start();
if($_SESSION["rank_usuario"]==1) {
    echo '

<!DOCTYPE>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
        <link href="../../css/css_propios/estilo_login.css" type="text/css" rel="stylesheet">
        <title>Protikets Log Maestro</title>
    </head>
    <body>
        <div class="encabezado">
            <div class="icono1"></div>
            <div class="icono2">Procuraduría Social de<br> la Ciudad de México</div>
        </div>
        <div class="d1">
            Hola Maestro
        </div>
        <div class="piei">
        </div>
        <script src="http://code.jquery.com/jquery-latest.js"></script>
    </body>
</html>

';
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