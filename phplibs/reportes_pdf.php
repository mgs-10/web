<?php
//error_reporting(0);
session_start();
require 'pdf/fpdf.php';
require 'net.php';

class pdf extends fpdf {
    public function Header() {
        $this->SetFont('Arial', 'B', 7);
        $this->SetTextColor(0,0,0);
        $this->Image('../img/logo_pdf.png', 10, 5, 80, 20);
        $this->Cell(195, 20, '', 0, 0, 'C');
        $this->Multicell(70, 3, utf8_decode('Procuraduría Social de la Ciudad de Mexico
Coordinacion General Administrativa
Jefatura de Unidad Departamental de Tecnologías de la Información y Comunicaciones'), 0, 'R', 0);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(150, 10, '**SOPORTES IMPRESOS PARA FIRMA**', 0, 0, 'R');
        $this->Cell(115, 10, 'Fecha: ' .date("d-m-Y"), 0, 1, 'R');
    }
}

if($_SESSION["rank_usuario"]==3) {
    // Create connection
    $mysqli = new mysqli($serverName, $userName, $password, $dbName);
    if ($mysqli->connect_errno) {
    
        echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    
    } else {
        
        $myget ="SELECT T.id_folio, U.nom_usuario, A.nom_area, A.piso_area, Te.nom_usuario, T.solucion, Cs.texto_tecnico, T.tipo_falla FROM tikets T INNER JOIN usuarios U ON T.solicitante_id = U.id_usuario INNER JOIN ref_area A ON U.area = A.id_area INNER JOIN usuarios Te ON T.asistente = Te.id_usuario INNER JOIN ref_tipo_soporte Cs ON T.tipo_falla = Cs.id_tipo_soporte WHERE status ='3' ORDER BY T.id_folio";
        
        
        $pdf = new pdf('L', 'mm', 'Letter');
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',7);
        
        $myget2 ="SELECT COUNT(*) FROM tikets  WHERE status ='3'";
        $result2 = $mysqli->query($myget2);
        $count_r = $result2->fetch_row();
        $count = $count_r[0];
        
        while ($count > 0) {
            
            $count = $count-1;
            $result = $mysqli->query($myget);
            $fila = $result->fetch_row();
            $pdf->SetFont('Arial','B',7);
            $pdf->SetTextColor(255,255,255);
            $pdf->Cell(20, 5, 'Folio: ' . $fila[0], 1, 0, 'C', 1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(90, 5, utf8_decode($fila[6]), 1, 0, 'C');
            $pdf->Cell(140, 5, utf8_decode($fila[2]), 1, 0, 'C');
            $pdf->Cell(10, 5, utf8_decode('Piso: ' . $fila[3]), 1, 1, 'C');
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(110, 5, utf8_decode('Técnico: ' . $fila[4]), 1, 0, 'C');
            $pdf->Cell(110, 5, utf8_decode('Solicitante: ' . $fila[1]), 1, 1, 'C');
            $pdf->SetFont('Arial','',7);
            $pdf->Cell(170, 5, utf8_decode($fila[5]), 1, 0, 'C');
            $pdf->SetFont('Arial','B',7);
            $pdf->Cell(50, 5, utf8_decode('Firma aquí -->'), 1, 1, 'R');
            $pdf->SetFont('Arial','',7);

            $pdf->Cell(260, 3, '', 0, 1, 'C');
            
            $myupdate = "UPDATE `tikets` SET `status`='4' WHERE id_folio='" . $fila[0] . "' AND tipo_falla='" . $fila[7] . "'";
            $mysqli->query($myupdate);
            
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