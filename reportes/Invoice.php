<?php

//require('../fpdf17/fpdf.php');
require('Factura.php');
//require('../fpdf181/fpdf.php');

//A4 width : 219mm
//default margin : 10mm each side
//writable horizontal : 219-(10*2)=189mm

//create pdf object
//$pdf = new FPDF('P','mm','A4');
//add new page
//$pdf->AddPage();
//output the result



//Establecemos la configuración de la factura
$pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
$pdf->AddPage();


//Establecemos los datos de la empresa
$logo = "logo.jpg";
$ext_logo = "jpg";
$empresa = "COMERCIAL ESTRELLA S.A.C.";
$documento = "20100088917";
$direccion = "Prolong. Unánue Nro. 1418 - Urb. Matute - Lima";
$telefono = "4739338 / 473-1490";
$email = "@gmail.com";




require_once "../modelos/Factura.php";
$factura = new Factura();
$rsptav = $factura->ventacabecera($_GET["id"]);
//Recorremos todos los valores obtenidos
$regv = $rsptav->fetch_object();


//set font to arial, bold, 14pt
$pdf->SetFont('Arial','B',14);

//Cell(width , height , text , border , end line , [align] )

$pdf->Cell(130 ,5,utf8_decode($empresa),0,0);
$pdf->Cell(59 ,5,'FACTURA',0,1);//end of line

//set font to arial, regular, 12pt
$pdf->SetFont('Arial','',12);

$pdf->Cell(130 ,5,utf8_decode($direccion),0,0);
$pdf->Cell(59 ,5,'',0,1);//end of line

$pdf->Cell(25 ,5,'RUC: ',0,0);
$pdf->Cell(34 ,5, $documento,  0,1);//end of line

$pdf->Cell(25 ,5,'Fecha: ',0,0);
$pdf->Cell(34 ,5, $regv->fecha,  0,1);//end of line

$pdf->Cell(25 ,5,'Telefono: ',0,0);
$pdf->Cell(34 ,5, $telefono,  0,1);//end of line

$pdf->Cell(130 ,5,'',0,0);
$pdf->Cell(25 ,5,'Factura #',0,0);
$pdf->Cell(34 ,5,$regv->numeracion_08,0,1);//end of line

 
//make a dummy empty cell as a vertical spacer
$pdf->Cell(189 ,4,'',0,1);//end of line

//billing address
$pdf->Cell(100 ,5,'Cliente: ',0,1);//end of line

//add dummy cell at beginning of each line for indentation
$pdf->Cell(10 ,5,'',0,0);
$pdf->Cell(90 ,5,'Nombre: '.$regv->cliente,0,1);

$pdf->Cell(10 ,5,'',0,0);
$pdf->Cell(90 ,5,'Nombre comercial: '.$regv->nombre_comercial,0,1);

$pdf->Cell(10 ,5,'',0,0);
$pdf->Cell(90 ,5,'RUC: '.$regv->numero_documento,0,1);

$pdf->Cell(10 ,5,'',0,0);
$pdf->Cell(90 ,5,utf8_decode('Dirección: ').$regv->direccion,0,1);

$pdf->Cell(10 ,5,'',0,0);
$pdf->Cell(90 ,5,utf8_decode('Teléfono: ').$regv->telefono1,0,1);

//make a dummy empty cell as a vertical spacer
$pdf->Cell(189 ,10,'',0,1);//end of line


// //Establecemos las columnas que va a tener la sección donde mostramos los detalles de la venta
// $cols=array( "CODIGO"=>23,
//              "DESCRIPCION"=>78,
//              "CANTIDAD"=>22,
//              "P.U."=>25,
//              "SUBTOTAL"=>22);
// $pdf->addCols( $cols);
// $cols=array( "CODIGO"=>"L",
//              "DESCRIPCION"=>"L",
//              "CANTIDAD"=>"C",
//              "P.U."=>"R",
//              "SUBTOTAL"=>"C");
// $pdf->addLineFormat( $cols);
// $pdf->addLineFormat($cols);
// $y= 89;
// //Obtenemos todos los detalles de la venta actual
// $rsptad = $factura->ventadetalle($_GET["id"]);
 
// while ($regd = $rsptad->fetch_object()) {
//   $line = array( "CODIGO"=> "$regd->codigo",
//                 "DESCRIPCION"=> utf8_decode("$regd->articulo"),
//                 "CANTIDAD"=> "$regd->cantidad_item_12",
//                 "P.U."=> "$regd->precio_venta_item_15_2",
//                 "DSCTO" => "0",
//                 "SUBTOTAL"=> "$regd->valor_venta_item_21");
//             $size = $pdf->addLine( $y, $line );
//             $y   += $size + 2;
// }




//invoice contents
$pdf->SetFont('Arial','B',12);

$pdf->Cell(25 ,5,'CODIGO',1,0);
$pdf->Cell(80 ,5,'DESCRIPCION',1,0);
$pdf->Cell(25 ,5,'CANTIDAD',1,0);
$pdf->Cell(25 ,5,'PRECIO U.',1,0);
$pdf->Cell(34 ,5,'SUBTOTAL',1,1);//end of line


$pdf->SetFont('Arial','',12);

//Numbers are right-aligned so we give 'R' after new line parameter

$pdf->Cell(25 ,5,'C0702',1,0);
$pdf->Cell(80 ,5,'TAFETA',1,0);
$pdf->Cell(25 ,5,'5',1,0);
$pdf->Cell(25 ,5,'18',1,0);
$pdf->Cell(34 ,5,'3,250',1,1,'R');//end of line

$pdf->Cell(25 ,5,'C0702',1,0);
$pdf->Cell(80 ,5,'TAFETA',1,0);
$pdf->Cell(25 ,5,'5',1,0);
$pdf->Cell(25 ,5,'18',1,0);
$pdf->Cell(34 ,5,'3,250',1,1,'R');//end of line

$pdf->Cell(25 ,5,'C0702',1,0);
$pdf->Cell(80 ,5,'TAFETA',1,0);
$pdf->Cell(25 ,5,'5',1,0);
$pdf->Cell(25 ,5,'18',1,0);
$pdf->Cell(34 ,5,'3,250',1,1,'R');//end of line

$pdf->Cell(25 ,5,'C0702',1,0);
$pdf->Cell(80 ,5,'TAFETA',1,0);
$pdf->Cell(25 ,5,'5',1,0);
$pdf->Cell(25 ,5,'18',1,0);
$pdf->Cell(34 ,5,'3,250',1,1,'R');//end of line

$pdf->Cell(25 ,5,'C0702',1,0);
$pdf->Cell(80 ,5,'TAFETA',1,0);
$pdf->Cell(25 ,5,'5',1,0);
$pdf->Cell(25 ,5,'18',1,0);
$pdf->Cell(34 ,5,'3,250',1,1,'R');//end of line

//summary
$pdf->Cell(130 ,5,'',0,0);
$pdf->Cell(25 ,5,'SUBTOTAL',0,0);
$pdf->Cell(4 ,5,'$',1,0);
$pdf->Cell(30 ,5,'4,450',1,1,'R');//end of line

$pdf->Cell(130 ,5,'',0,0);
$pdf->Cell(25 ,5,'IGV',0,0);
$pdf->Cell(4 ,5,'$',1,0);
$pdf->Cell(30 ,5,'0',1,1,'R');//end of line

$pdf->Cell(130 ,5,'',0,0);
$pdf->Cell(25 ,5,'TOTAL',0,0);
$pdf->Cell(4 ,5,'$',1,0);
$pdf->Cell(30 ,5,'10%',1,1,'R');//end of line



$pdf->Output();


?>