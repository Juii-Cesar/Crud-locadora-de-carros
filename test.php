<?php
require "vendor/autoload.php";
use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->loadHtml("<h1>Teste</h1>");
$dompdf->render();
$dompdf->stream("teste.pdf");