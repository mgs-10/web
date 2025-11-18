<?php
//error_reporting(0);
session_start();
require 'pdf/fpdf.php';
require 'net.php';
$folio = $_POST["folio"];
$usuario = $_POST["usuario"];
$area = $_POST["area"];
$piso = $_POST["piso"];

class pdf extends fpdf {
    public function Header() {
        $fol = $_POST["folio"];
        $usu = $_POST["usuario"];
        $are = $_POST["area"];
        $pis = $_POST["piso"];
        
        $this->SetFont('Arial', 'B', 7);
        $this->SetTextColor(0,0,0);
        $this->Image('../img/logo_pdf.png', 10, 5, 80, 20);
        $this->Cell(195, 20, '', 0, 0, 'C');
        $this->Multicell(70, 3, utf8_decode('Procuraduría Social de la Ciudad de Mexico
Coordinacion General Administrativa
Jefatura de Unidad Departamental de Tecnologías de la Información y Comunicaciones'), 0, 'R', 0);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(150, 10, 'INFORME DETALLADO DEL TIKET FOLIO   ' . $fol, 0, 0, 'R');
        $this->Cell(115, 10, 'Fecha: ' .date("d-m-Y"), 0, 1, 'R');
        $this->Cell(12, 5, utf8_decode('Usuario:'), 0, 0, 'R', 0);
        $this->Cell(110, 5, utf8_decode($usu), 0, 0, 'L', 0);
        $this->Cell(10, 5, utf8_decode('Área:'), 0, 0, 'R', 0);
        $this->Cell(114, 5, utf8_decode($are), 0, 0, 'L', 0);
        $this->Cell(8, 5, utf8_decode('Piso:'), 0, 0, 'R', 0);
        $this->Cell(6, 5, utf8_decode($pis), 0, 1, 'L', 0);
        $this->Cell(260, 3, '', 0, 1, 'C');
        
    }
}

if($_SESSION["rank_usuario"]==3) {
    // Create connection
    $mysqli = new mysqli($serverName, $userName, $password, $dbName);
    if ($mysqli->connect_errno) {
    
        echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    
    } else {
        
        $myget="SELECT T.id_folio, U.nom_usuario, A.nom_area, A.piso_area, Ts.texto_tecnico, Te.nom_usuario, T.date_opened, T.date_clossed, T.solucion, S.texto_status FROM tikets T INNER JOIN usuarios U ON T.solicitante_id = U.id_usuario INNER JOIN ref_area A ON U.area = A.id_area LEFT JOIN usuarios Te ON T.asistente = Te.id_usuario INNER JOIN ref_tipo_soporte Ts ON T.tipo_falla = Ts.id_tipo_soporte INNER JOIN ref_status S ON T.status = S.id_status WHERE T.id_folio =" . $folio;
        
        
        $pdf = new pdf('L', 'mm', 'Letter');
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',7);
        //$pdf->SetTextColor(255,255,255);
        $result = $mysqli->query($myget);
        
        while ($fila = $result->fetch_row()) {
            
            $pdf->Cell(38, 5, 'Apertura:  ' . $fila[6], 1, 0, 'R', 0);
            $pdf->Cell(90, 5, utf8_decode('Problema:  ' . $fila[4]), 1, 0, 'L', 0);
            $pdf->Cell(132, 5, utf8_decode('Técnico:  ' . $fila[5]), 1, 1, 'L', 0);
            
            $pdf->Cell(38, 5, 'Cierre:  ' . $fila[7], 1, 0, 'R', 0);
            $pdf->Cell(90, 5, utf8_decode('Solución:  ' . $fila[8]), 1, 0, 'L', 0);
            $pdf->Cell(132, 5, utf8_decode('Status:  ' . $fila[9]), 1, 1, 'L', 0);
            $pdf->Cell(260, 3, '', 0, 1, 'C');
            
        }
        
        $pdf->Output('I', 'documento.pdf', true);
        
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