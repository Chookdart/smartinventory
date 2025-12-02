<?php
require __DIR__ . '/../vendor/autoload.php';

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
/*
$qrText = "PAPER01";
$qrText = "COLOR01";
$qrText = "ERASER01";
*/
$qrText = "PENCIL01";
//$qrText = "BALLPEN01";
//$qrText = "TUX01";
//$qrText = "GOWN01";
//$qrText = "NT01";
//$qrText = "POLO01";
//$qrText = "SHIRT01";
//$qrText = "BB01";
//$qrText = "VB01";
//$qrText = "JERSEY01";
//$qrText = "SHORTS01";
//$qrText = "PC01";
//$qrText = "CC01";
//$qrText = "M01";
//$qrText = "PC02";
//$qrText = "PC03";


$result = Builder::create()
    ->writer(new PngWriter())
    ->data($qrText)
    ->size(300) 
    ->margin(10)
    ->build();

$result->saveToFile(__DIR__ . "/qrcodes/{$qrText}.png");

echo "QR code created!";
