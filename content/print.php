<?php 
require __DIR__ . '/../vendor/autoload.php';
use Dompdf\Dompdf;
use Dompdf\Options;

$dompdf = new Dompdf;
$option = new Options;
$option->setChroot(__DIR__);
$option->setIsRemoteEnabled(true);
$dompdf->setPaper('A4', 'portrait');
ob_start();
include 'print-kehadiran.php';
$html = ob_get_clean();
$dompdf->loadHtml($html);
$dompdf->render();
$dompdf->stream('hello_world.pdf',["Attachment"=>0]);

?>