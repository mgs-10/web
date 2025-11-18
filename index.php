<?php
error_reporting(0);
session_destroy();
echo '

<!DOCTYPE>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
        <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap/bootstrap-theme.min.css">
        <link href="css/css_propios/estilo_login.css" type="text/css" rel="stylesheet">
        <script src="js/bootstrap.min.js"></script>
        <title>PROTIKETS</title>
    </head>
    <body>
        <div class="divbar">
            <div class="icono1"></div>
            <div class="icono2"></div>
        </div>        
        <div class="contenedor">
            <form action="phplibs/login.php" method="post">
                <div class="card text-center card bg-default mb-3">
                    <div class="card-header">
                        INICIO DE SESION
                    </div>
                    <div class="card-body">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16"><path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/></svg><input type="text" id="user" name="user" class="form-control input-sm chat-input" pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" placeholder="Usuario" required/>
                        <br>
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-key-fill" viewBox="0 0 16 16"><path d="M3.5 11.5a3.5 3.5 0 1 1 3.163-5H14L15.5 8 14 9.5l-1-1-1 1-1-1-1 1-1-1-1 1H6.663a3.5 3.5 0 0 1-3.163 2zM2.5 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/></svg>
                        <input type="password" name="pass" id="Pass" class="form-control input-sm chat-input" pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" placeholder="Contraseña" required/>
                    </div>
                    <div class="card-footer text-muted" colspan="2">
                        <input class="btn btn-secondary" type="submit" id="redyt" value="Entrar"> 
                    </div>
                </div>
            </form>
        </div>
        <script src="http://code.jquery.com/jquery-latest.js"></script>
        <footer>
            <MARQUEE BGCOLOR="#682E2E"><b>INNOVACIÓN EN LA GESTIÓN GUBERNAMENTAL DE 
TECNOLOGÍAS DE LA INFORMACIÓN Y 
COMUNICACIONES: SISTEMA DE INFORMACIÓN PARA 
LA COORDINACIÓN Y ORGANIZACIÓN DE SOLICITUDES 
DE SOPORTE Y RECURSOS TECNOLÓGICOS CON 
ENFOQUE EN GOBIERNO DIGITAL
</MARQUEE>
        </footer>
    </body>
</html>

';
?>

