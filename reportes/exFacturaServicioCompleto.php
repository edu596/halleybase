<?php
//Activamos el almacenamiento en el buffer
ob_start();
if (strlen(session_id()) < 1) 
  session_start();
 
if (!isset($_SESSION["nombre"]))
{
  echo 'Debe ingresar al sistema correctamente para visualizar el reporte';
}
else
{
if ($_SESSION['ventas']==1)
{
//Incluímos el archivo Factura.php
require('Factura_servicio.php');
 
//Obtenemos los datos de la cabecera de la venta actuall
require_once "../modelos/Servicio.php";
$servicio = new Servicio();
$rsptav = $servicio->ventacabecera($_GET["id"], $_SESSION['idempresa']);
$datos = $servicio->datosemp($_SESSION['idempresa']);
//Recorremos todos los valores obtenidos
$regv = $rsptav->fetch_object();

$datose = $datos->fetch_object();

 $logo = "../files/logo/".$datose->logo;
 $ext_logo = substr($datose->logo, strpos($datose->logo,'.'),-4);

// $logo = "";
// $ext_logo = "";
 
//Establecemos la configuración de la factura
$pdf = new PDF_Invoice( 'P', 'mm',  'A4' );
$pdf->AddPage();

#Establecemos los márgenes izquierda, arriba y derecha: 
$pdf->SetMargins(10, 10 , 10); 

#Establecemos el margen inferior: 
$pdf->SetAutoPageBreak(true,10); 

//Enviamos los datos de la empresa al método addSociete de la clase Factura
$pdf->addSociete(utf8_decode(htmlspecialchars_decode($datose->nombre_comercial)),utf8_decode("Dirección    : ").utf8_decode($datose->domicilio_fiscal)."\n".utf8_decode("Teléfono     : ").$datose->telefono1." - ".$datose->telefono2."\n" ."Email          : ".$datose->correo, $logo, $ext_logo);

$pdf->numFactura("$regv->numeracion_08" , "$datose->numero_ruc");

$pdf->RotatedText($regv->estado, 35,190,'ANULADO - DADO DE BAJA',45);
$pdf->temporaire( "" );
 
//Enviamos los datos del cliente al método addClientAdresse de la clase Factura
$pdf->addClientAdresse( $regv->fecha."   /  Hora: ".$regv->hora,    utf8_decode(htmlspecialchars_decode($regv->cliente)), $regv->numero_documento, utf8_decode($regv->direccion), $regv->estado, utf8_decode($regv->vendedorsitio), utf8_decode($regv->guia) );
 
//Establecemos las columnas que va a tener la sección donde mostramos los detalles de la venta
$cols=array( "ITEM"=>10,
             "DESCRIPCION"=>140,
             //"CANTIDAD"=>22,
             //"V.U."=>25,
             //"DSCTO"=>20,
             "IMPORTE"=>50);
$pdf->addCols3( $cols);
$cols=array( "ITEM"=>"L",
             "DESCRIPCION"=>"L",
             //"CANTIDAD"=>"C",
             //"V.U."=>"R",
             //"DSCTO" =>"R",
             "IMPORTE"=>"C");
$pdf->addLineFormat( $cols);
$pdf->addLineFormat($cols);

//Actualizamos el valor de la coordenada "y", que será la ubicación desde donde empezaremos a mostrar los datos
$y= 62;
 
//Obtenemos todos los detalles de la venta actual
$rsptad = $servicio->ventadetalle($_GET["id"], $_SESSION['idempresa']);
 $item=1;
while ($regd = $rsptad->fetch_object()) {
  $line = array( "ITEM"=> "$regd->norden",
                "DESCRIPCION"=> utf8_decode("$regd->descripcion"."\n"."$regd->descdet"),
                //"CANTIDAD"=> "$regd->cantidad_item_12",
                //"V.U."=> "$regd->valor_uni_item_14",
               // "DSCTO" => "0",
                "IMPORTE"=> "$regd->precio");
            $size = $pdf->addLine( $y, $line );
            $y   += $size + 2;
            $item=$item + 1;
}

//======= PARA EXTRAER EL HASH DEL DOCUMENTO FIRMADO ========================================
    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($_SESSION['idempresa']);
    $Prutas = $Rrutas->fetch_object();
    $rutafirma=$Prutas->rutafirma; // ruta de la carpeta FIRMA
    $data[0] = "";

//===========PARA EXTRAER EL CODIGO HASH =============================
if ($regv->estado=='5') {
$facturaFirm=$regv->numero_ruc."-".$regv->tipo_documento_07."-".$regv->numeracion_08;
$sxe = new SimpleXMLElement($rutafirma.$facturaFirm.'.xml', null, true);
$urn = $sxe->getNamespaces(true);
$sxe->registerXPathNamespace('ds', $urn['ds']);
$data = $sxe->xpath('//ds:DigestValue');
}
else
{
     $data[0] = "";
}

//==================== PARA IMAGEN DEL CODIGO HASH ================================================
//set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'/generador-qr/temp'.DIRECTORY_SEPARATOR;
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';
    include 'generador-qr/phpqrcode.php';    
    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR)){
        mkdir($PNG_TEMP_DIR);
    }
    
    $filename = $PNG_TEMP_DIR.'test.png';
    //processing form input
    //remember to sanitize user input in real-life solution !!!
    $dataTxt=$regv->numero_ruc."|".$regv->tipo_documento_07."|".$regv->serie."|".$regv->numerofac."|".$regv->sumatoria_igv_22_1."|".$regv->importe_total_venta_27."|".$regv->fecha2."|".$regv->tipo_documento."|".$regv->numero_documento."|";

    $errorCorrectionLevel = 'H';    
    $matrixPointSize = '2';

    // user data
        $filename = $PNG_TEMP_DIR.'test'.md5($dataTxt.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($dataTxt, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        //default data
        //QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
       //display generated file
        $PNG_WEB_DIR.basename($filename);

// //==================== PARA IMAGEN  ================================================
$logoQr = $filename;
//$logoQr = "../files/logo/".$datose->logo;
$ext_logoQr = substr($filename, strpos($filename,'.'),-4);
$pdf->ImgQr2($logoQr, $ext_logoQr);
//======= PARA EXTRAER EL HASH DEL DOCUMENTO FIRMADO ========================================


//Convertimos el total en letras
require_once "Letras.php";
$V=new EnLetras(); 
$con_letra=strtoupper($V->ValorEnLetras($regv->importe_total_venta_27,"CON"));
$pdf->addCadreTVAs2("".$con_letra);
$pdf->observSunat2($regv->numeracion_08,$regv->estado, $data[0], $datose->webconsul, $datose->nresolucion);
 
//Mostramos el impuesto
$pdf->addTVAs2( $regv->sumatoria_igv_22_1 , $regv->importe_total_venta_27,"S/ ");
$pdf->addCadreEurosFrancs2($regv->sumatoria_igv_22_1);





//Linea para guardar la factura en la carpeta facturas PDF
$Factura=$pdf->Output($regv->numeracion_08.'.pdf','I');
$Factura=$pdf->Output('../facturasPDF/'.$regv->numeracion_08.'.pdf','F');




}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}
 
}
ob_end_flush();
?>