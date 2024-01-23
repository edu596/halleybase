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
require('BoletaCompleto.php');
//Obtenemos los datos de la cabecera de la venta actual
require_once "../modelos/Boleta.php";
$boleta = new Boleta();
$rsptav = $boleta->ventacabecera($_GET["id"], $_SESSION['idempresa']);
$datos = $boleta->datosemp($_SESSION['idempresa']);
//Recorremos todos los valores obtenidos
$regv = $rsptav->fetch_object();
$datose = $datos->fetch_object(); 

$logo = "../files/logo/".$datose->logo;
$ext_logo = substr($datose->logo, strpos($datose->logo,'.'),-4);

//Establecemos la configuración de la factura
$pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
$pdf->AddPage();

#Establecemos los márgenes izquierda, arriba y derecha: 
$pdf->SetMargins(10, 10 , 10); 

#Establecemos el margen inferior: 
$pdf->SetAutoPageBreak(true,10); 


//Enviamos los datos de la empresa al método addSociete de la clase Factura
$pdf->addSociete(utf8_decode(htmlspecialchars_decode($datose->nombre_comercial)),utf8_decode("Dirección:     ").utf8_decode($datose->domicilio_fiscal)."\n".utf8_decode("Teléfono:     ").$datose->telefono1." - ".$datose->telefono2."\n" ."Email:          ".$datose->correo, $logo, $ext_logo);
$pdf->numBoleta("$regv->numeracion_07",  "$datose->numero_ruc" );
//Datos de la empresa

$pdf->RotatedText($regv->estado, 35,190,'ANULADO - DADO DE BAJA',45);
$pdf->temporaire( "" );
 
//Enviamos los datos del cliente al método addClientAdresse de la clase Factura
$pdf->addClientAdresse( $regv->fecha."   /  Hora: ".$regv->hora, utf8_decode($regv->cliente),utf8_decode($regv->direccion), $regv->numero_documento,$regv->estado, utf8_decode($regv->vendedorsitio), utf8_decode($regv->guia), utf8_decode($regv->tipopago), $regv->nroreferencia );

if ($regv->nombretrib=="IGV") {

        $nombret="PRECIO";
    }else{
        $nombret="PRECIO";
    }
 
//Establecemos las columnas que va a tener la sección donde mostramos los detalles de la venta
$cols=array( "CODIGO"=>23,
             "DESCRIPCION"=>78,
             "CANTIDAD"=>22,
             $nombret=>25,
             "DSCTO"=>20,
             "SUBTOTAL"=>22);
$pdf->addCols( $cols);
$cols=array( "CODIGO"=>"L",
             "DESCRIPCION"=>"L",
             "CANTIDAD"=>"C",
             $nombret=>"R",
             "DSCTO" =>"R",
             "SUBTOTAL"=>"C");
$pdf->addLineFormat( $cols);
$pdf->addLineFormat($cols);

//Actualizamos el valor de la coordenada "y", que será la ubicación desde donde empezaremos a mostrar los datos
$y= 62;
 
//Obtenemos todos los detalles de la venta actual
$rsptad = $boleta->ventadetalle($_GET["id"]);
 
while ($regd = $rsptad->fetch_object()) {
    if ($regd->nombretribu=="IGV") {
        $pv=$regd->precio_uni_item_14_2;
        //$pv=$regd->valor_uni_item_31;
        $subt=$regd->subtotal;
    }else{
        $pv=$regd->precio_uni_item_14_2;
        $subt=$regd->subtotal2;

    }
  $line = array( "CODIGO"=> "$regd->codigo",
                "DESCRIPCION"=>  utf8_decode(htmlspecialchars_decode("$regd->articulo"." - "."$regd->descdet")),
                "CANTIDAD"=> "$regd->cantidad_item_12"." "."$regd->unidad_medida",
                $nombret=> $pv,
                "DSCTO" => "$regd->dcto_item",
                "SUBTOTAL"=> "$regd->subtotal");
            $size = $pdf->addLine( $y, $line );
            $y   += $size + 2;
}

//======= PARA EXTRAER EL HASH DEL DOCUMENTO FIRMADO ========================================
    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($_SESSION['idempresa']);
    $Prutas = $Rrutas->fetch_object();
    $rutafirma=$Prutas->rutafirma; // ruta de la carpeta FIRMA
    $data[0] = "";
    
if ($regv->estado=='5') {
$boletaFirm=$regv->numero_ruc."-".$regv->tipo_documento_06."-".$regv->numeracion_07;
$sxe = new SimpleXMLElement($rutafirma.$boletaFirm.'.xml', null, true);
$urn = $sxe->getNamespaces(true);
$sxe->registerXPathNamespace('ds', $urn['ds']);
$data = $sxe->xpath('//ds:DigestValue');
}
else
{
     $data[0] = "";
}
//======= PARA EXTRAER EL HASH DEL DOCUMENTO FIRMADO ========================================

//Convertimos el total en letras
require_once "Letras.php";
$V=new EnLetras(); 
$con_letra=strtoupper($V->ValorEnLetras($regv->totalLetras,"CON"));
$pdf->addCadreTVAs("".$con_letra);
$pdf->observSunat($regv->numeracion_07, $regv->estado, $data[0], $datose->webconsul , $datose->nresolucion);

//Mostramos el impuesto
$pdf->addTVAs($regv->Itotal,"S/ ",  $regv->tdescuento, $regv->ipagado  , $regv->saldo);
$pdf->addCadreEurosFrancs();
// //==================== PARA IMAGEN DEL CODIGO HASH ================================================
// //set it to writable location, a place for temp generated PNG files
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'/generador-qr/temp'.DIRECTORY_SEPARATOR;
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';
    include 'generador-qr/phpqrcode.php';    
    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    $filename = $PNG_TEMP_DIR.'test.png';
    
    //processing form input
    //remember to sanitize user input in real-life solution !!!
     $dataTxt=$regv->numero_ruc."|".$regv->tipo_documento_06."|".$regv->serie."|".$regv->numerofac."|0.00|".$regv->Itotal."|".$regv->fecha2."|".$regv->tipo_documento."|".$regv->numero_documento."|";;
    $errorCorrectionLevel = 'H';    
    $matrixPointSize = '2';

    // user data
        $filename = $PNG_TEMP_DIR.'test'.md5($dataTxt.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($dataTxt, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        //default data
        //QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
       //display generated file
        $PNG_WEB_DIR.basename($filename);
// // //==================== PARA IMAGEN DEL CODIGO HASH ================================================

$logoQr = $filename;
//$logoQr = "../files/logo/".$datose->logo;
$ext_logoQr = substr($filename, strpos($filename,'.'),-4);
$pdf->ImgQr($logoQr, $ext_logoQr);

 
$Factura=$pdf->Output($regv->numeracion_07.'.pdf','I');
$Factura=$pdf->Output('../boletasPDF/'.$regv->numeracion_07.'.pdf','F');

}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}
 
}
ob_end_flush();
?>