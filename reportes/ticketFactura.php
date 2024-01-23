<?php
include "fpdf.php";

$pdf = new FPDF($orientation='P',$unit='mm', array(45,350));
$pdf->AddPage();
$pdf->SetFont('Arial','B',8);    //Letra Arial, negrita (Bold), tam. 20
$textypos = 5;
$pdf->setY(2);
$pdf->setX(2);
$pdf->Cell(5,$textypos,"NOMBRE DE LA EMPRESA");
$pdf->SetFont('Arial','',5);    //Letra Arial, negrita (Bold), tam. 20
$textypos+=6;
$pdf->setX(2);
$pdf->Cell(5,$textypos,'-------------------------------------------------------------------');
$textypos+=6;
$pdf->setX(2);
$pdf->Cell(5,$textypos,'CANT.  ARTICULO       PRECIO               TOTAL');

$total =0;
$off = $textypos+6;
$producto = array(
	"q"=>1,
	"name"=>"Computadora Lenovo i5",
	"price"=>100
);
$productos = array($producto, $producto, $producto, $producto, $producto );
foreach($productos as $pro){
$pdf->setX(2);
$pdf->Cell(5,$off,$pro["q"]);
$pdf->setX(6);
$pdf->Cell(35,$off,  strtoupper(substr($pro["name"], 0,12)) );
$pdf->setX(20);
$pdf->Cell(11,$off,  "$".number_format($pro["price"],2,".",",") ,0,0,"R");
$pdf->setX(32);
$pdf->Cell(11,$off,  "$ ".number_format($pro["q"]*$pro["price"],2,".",",") ,0,0,"R");

$total += $pro["q"]*$pro["price"];
$off+=6;
}
$textypos=$off+6;

$pdf->setX(2);
$pdf->Cell(5,$textypos,"TOTAL: " );
$pdf->setX(38);
$pdf->Cell(5,$textypos,"$ ".number_format($total,2,".",","),0,0,"R");

$pdf->setX(2);
$pdf->Cell(5,$textypos+6,'GRACIAS POR TU COMPRA ');

$pdf->output();
