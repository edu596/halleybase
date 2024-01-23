<?php

$boton=$_POST["boton"];



if($boton=='btnpdf') {

        $tipodoc=$_POST["tipodoc"];
        $serienumero=$_POST["serienumero"];
        $nruc=$_POST["nruc"];
        $idempresa=$_POST["idempresa"];


require('Factura.php');
require_once "../modelos/Venta.php";
$venta = new Venta();
require_once "../modelos/Factura.php";
$factura = new Factura();
//PARA COMPROBANTES BOLETA Y FACTURA


    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2("1");
    $Prutas = $Rrutas->fetch_object();
    $rutasalidafactura=$Prutas->salidafacturas; 
    $rutalogo=$Prutas->rutalogo; 


if ($tipodoc=='01' || $tipodoc=='03') {
//$rsptav = $venta->ventacabeceraConsulta($tipodoc,trim($serienumero),$fechaemision, $montototal);
$rsptav = $venta->ventacabeceraConsulta($tipodoc, trim($nruc) , trim($serienumero));
//PARA COMPROBANTES NOTAS DE CREDITO Y DEBITO
$datos = $factura->datosemp($idempresa);
$regv = $rsptav->fetch_object();
$datose = $datos->fetch_object();

 $logo = $rutalogo.$datose->logo;
 $ext_logo = substr($datose->logo, strpos($datose->logo,'.'),-4);

if ($regv !="") {

$pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
$pdf->AddPage();
#Establecemos los márgenes izquierda, arriba y derecha: 
$pdf->SetMargins(10, 10 , 10); 
#Establecemos el margen inferior: 
$pdf->SetAutoPageBreak(true,10); 



$pdf->addSocietenombre(htmlspecialchars_decode(utf8_decode($datose->nombre_comercial)), 'dasda'); //Nuevo


$pdf->addSociete( utf8_decode("Teléfono: ").$datose->telefono1." - ".$datose->telefono2,
    "Email: ".$datose->correo,
    htmlspecialchars_decode(utf8_decode("Dirección: ").$datose->domicilio_fiscal),  
    $logo, 
    $ext_logo);

$pdf->addSocietedireccion(htmlspecialchars_decode(utf8_decode("Direción  : ").$datose->domicilio_fiscal)); //Nuevo


$pdf->numComprobante("$regv->numeracion_08" , "$datose->numero_ruc", $regv->tipo_documento_07);
//$pdf->RotatedText($regv->estado, 35,190,'ANULADO - DADO DE BAJA',45);
$pdf->temporaire( "" );
//Enviamos los datos del cliente al método addClientAdresse de la clase Factura

if ($regv->formapago == "Credito")
{
    $letraCuota="Fecha de vencimiento: ";
    $montocuota="";
    $feccuota=$regv->fechavenc;
}else{
    $letraCuota="";
    $montocuota="";
    $feccuota="";
}


$pdf->addClientAdresse(
$regv->fecha."   /  Hora: ".$regv->hora,
utf8_decode(htmlspecialchars_decode($regv->razon_social)), 
$regv->numero_documento, 
utf8_decode(htmlspecialchars_decode($regv->domicilio_fiscal)), 
$regv->estado, 
utf8_decode($regv->vendedorsitio), 
utf8_decode($regv->guia), 
utf8_decode($regv->tipopago), 
$regv->nroreferencia, 
$regv->moneda,
 $montocuota, 
    $feccuota);

$cols=array( "CODIGO"=>23,
             "DESCRIPCION"=>78,
             "CANTIDAD"=>22,
             "V.U."=>25,
             "DSCTO"=>20,
             "SUBTOTAL"=>22);
$pdf->addColsComprobante( $cols);
$cols=array( "CODIGO"=>"L",
             "DESCRIPCION"=>"L",
             "CANTIDAD"=>"C",
             "V.U."=>"R",
             "DSCTO" =>"R",
             "SUBTOTAL"=>"C");
$pdf->addLineFormat( $cols);
$pdf->addLineFormat($cols);
//Actualizamos el valor de la coordenada "y", que será la ubicación desde donde empezaremos a mostrar los datos
$y= 62;
//Obtenemos todos los detalles de la venta actual
//$rsptad = $venta->ventadetalleConsulta($tipodoc,$serienumero,$fechaemision, $montototal);
$rsptad = $venta->ventadetalleConsulta($tipodoc,$serienumero);
 
while ($regd = $rsptad->fetch_object()) {
  $line = array( "CODIGO"=> "$regd->codigo",
                "DESCRIPCION"=> utf8_decode("$regd->articulo"." - "."$regd->descdet"),
                "CANTIDAD"=> "$regd->cantidad_item_12",
                "V.U."=> "$regd->valor_uni_item_14",
                "DSCTO" => "0",
                "SUBTOTAL"=> "$regd->subtotal");
            $size = $pdf->addLine( $y, $line );
            $y   += $size + 2;
}
//======= PARA EXTRAER EL HASH DEL DOCUMENTO FIRMADO ========================================
    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($idempresa);
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
    $dataTxt=$regv->numero_ruc."|".$regv->tipo_documento_07."|".$regv->serie."|".$regv->numerofac."|".$regv->sumatoria_igv_22_1."|".$regv->itotal."|".$regv->fecha2."|".$regv->tipo_documento."|".$regv->numero_documento."|";

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
$pdf->ImgQrComprobante($logoQr, $ext_logoQr);
//======= PARA EXTRAER EL HASH DEL DOCUMENTO FIRMADO ========================================



//Convertimos el total en letras
require_once "Letras.php";
$V=new EnLetras(); 
$con_letra=strtoupper($V->ValorEnLetras($regv->itotal,"CON"));
$pdf->addCadreTVAsComprobante("".$con_letra);
$pdf->observSunatComprobante($regv->numeracion_08,$regv->estado, $data[0], $tipodoc, $datose->webconsul);
//Mostramos el impuesto
$pdf->addTVAsComprobante( $regv->sumatoria_igv_22_1 , $regv->subtotal,"S/ ", $regv->tdescuento, $regv->ipagado  , $regv->saldo, $regv->icbper);
$pdf->addComprobante($regv->sumatoria_igv_22_1);
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 0 );
ini_set('log_errors',1);
ob_end_clean();
//Linea para guardar la factura en la carpeta facturas PDF
$pdf->Output($regv->numeracion_08.'.pdf','I',true);

}
else
{
?>
<script>
alert("NO SE ENCUENTRA COMPROBANTE O ESTA ANULADO");
</script> 
<?php
}


}
elseif($tipodoc=='07' || $tipodoc=='08')
{ // PARA LAS NOTAS



$rsptav = $venta->ventacabeceraConsultaNCD($tipodoc, trim($nruc)   ,trim($serienumero));
$datos = $factura->datosemp($idempresa);
$regv = $rsptav->fetch_object();
$datose = $datos->fetch_object();
 
$logo = "../files/logo/".$datose->logo;
$ext_logo = substr($datose->logo, strpos($datose->logo,'.'),-4);
 if ($regv !="") {
$pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
$pdf->AddPage();
//Enviamos los datos de la empresa al método addSociete de la clase Factura
$pdf->addSociete( 
    utf8_decode("Teléfono: ").$datose->telefono1." - ".$datose->telefono2,
    "Email: ".$datose->correo,
    htmlspecialchars_decode(utf8_decode("Dirección: ").$datose->domicilio_fiscal),  
    $logo, 
    $ext_logo);

$pdf->numComprobante("$regv->numeroserienota" , "$datose->numero_ruc", $regv->codigo_nota);
//$pdf->RotatedText($regv->estado, 35,190,'ANULADO - DADO DE BAJA',45);
$pdf->temporaire( "" );

$pdf->addClientAdresseNC(utf8_decode($regv->razon_social),utf8_decode($regv->domicilio_fiscal), $regv->fecha, $regv->ncomprobante, utf8_decode($regv->femisionfac), utf8_decode($regv->observacion), utf8_decode($regv->vendedorsitio), $regv->numero_documento);

//Establecemos las columnas que va a tener la sección donde mostramos los detalles de la venta
$cols=array( "CODIGO"=>23,
             "DESCRIPCION"=>85,
             "CANTIDAD"=>22,
             "V.U."=>22,
             "IMPORTE"=>50);
$pdf->addColsComprobante( $cols);
$cols=array( "CODIGO"=>"L",
             "DESCRIPCION"=>"L",
             "CANTIDAD"=>"L",
             "V.U."=>"L",
             "IMPORTE" =>"C");
$pdf->addLineFormat( $cols);
//$pdf->addLineFormat($cols);

//Actualizamos el valor de la coordenada "y", que será la ubicación desde donde empezaremos a mostrar los datos
$y= 61;
 //Obtenemos todos los detalles de la venta actual
$rsptad = $venta->detalleNota($tipodoc, trim($nruc) ,trim($serienumero));
while ($regd = $rsptad->fetch_object()) {
  $line = array( "CODIGO"=> utf8_decode("$regd->codigo"),
                "DESCRIPCION"=> utf8_decode("$regd->articulo"),
                "CANTIDAD"=> "$regd->cantidad",
                "V.U."=> "$regd->valor_unitario",
                "IMPORTE"=> "$regd->valor_venta");
            $size = $pdf->addLine( $y, $line );
            $y   += $size + 2;
}
//======= PARA EXTRAER EL HASH DEL DOCUMENTO FIRMADO ========================================
    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($idempresa);
    $Prutas = $Rrutas->fetch_object();
    $rutafirma=$Prutas->rutafirma; // ruta de la carpeta FIRMA
    $data[0] = "";

//===========PARA EXTRAER EL CODIGO HASH =============================
if ($regv->estado=='5') {
$facturaFirm=$regv->numero_ruc."-".$regv->codigo_nota."-".$regv->numeroserienota;
$sxe = new SimpleXMLElement($rutafirma.$facturaFirm.'.xml', null, true);
$urn = $sxe->getNamespaces(true);
$sxe->registerXPathNamespace('ds', $urn['ds']);
$data = $sxe->xpath('//ds:DigestValue');
}
else
{
     $data[0] = "";
}
//Convertimos el total en letras
require_once "Letras.php";
$V=new EnLetras(); 
$con_letra=strtoupper($V->ValorEnLetras($regv->itotal,"CON"));
$pdf->addCadreTVAsComprobante("".$con_letra);
$pdf->observSunatComprobante($regv->numeroserienota,$regv->estado, $data[0], $tipodoc, $datose->webconsul   );

//Mostramos el impuesto
$pdf->addTVAs( $regv->sumatoria_igv_22_1 , $regv->subtotal,"S/ ", $regv->tdescuento, $regv->ipagado  , $regv->saldo, $regv->icbper);
$pdf->addCadreEurosFrancs($regv->sumatoria_igv_22_1, $regv->nombretrib);

$pdf->Output($regv->numeroserienota.'.pdf','I',true);

}
else
{
?>
<script>
alert("NO SE ENCUENTRA COMPROBANTE O ESTA ANULADO");
</script> 
<?php
}
}

//==================================

}
elseif ($boton=='btnxml') // ELSE SI ES DESCARGA DE XML
{

$tipodoc=$_POST["tipodoc"];
$serienumero=$_POST["serienumero"];
$idempresa=$_POST["idempresa"];
$nruc=$_POST["nruc"];


require_once "../modelos/Rutas.php";
require_once "../modelos/Venta.php";
require_once "../modelos/Factura.php";

$rutas = new Rutas();
$venta = new Venta();
$factura = new Factura();

$Rrutas = $rutas->mostrar2($idempresa);
$Prutas = $Rrutas->fetch_object();
$rutafirma=$Prutas->rutafirma; // ruta de la carpeta FIRMA

$datos = $factura->datosemp($idempresa);
$datose = $datos->fetch_object();

if ($tipodoc=='01' || $tipodoc=='03') {

 $rsptav = $venta->ventacabeceraConsulta($tipodoc, trim($nruc), trim($serienumero));
 $regv = $rsptav->fetch_object();

if ($regv !="") {
 $path  = $rutafirma; 
 $files = array_diff(scandir($path), array('.', '..')); 

 $nombrexml=$datose->numero_ruc."-".$regv->tipo_documento_07."-".$regv->numeracion_08;
 $Axml=$rutafirma.$nombrexml.".xml";
    header('Content-Description: File Transfer');
    header('Content-Type: text/xml');
    header('Content-Disposition: attachment; filename="'.basename($Axml).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($Axml));
    readfile($Axml);
}
   else // sin NO encuentra el xml
{
?>
<script>
alert("NO SE ENCUENTRA COMPROBANTE O ESTA ANULADO");
</script> 
<?php
}



}elseif($tipodoc=='07' || $tipodoc=='08') {

 $rsptav = $venta->ventacabeceraConsultaNCD($tipodoc, trim($nruc), trim($serienumero));
 $regv = $rsptav->fetch_object();

if ($regv !="") {
 $path  = $rutafirma; 
 $files = array_diff(scandir($path), array('.', '..')); 

 $nombrexml=$datose->numero_ruc."-".$regv->codigo_nota."-".$regv->numeroserienota;
 $Axml=$rutafirma.$nombrexml.".xml";
    header('Content-Description: File Transfer');
    header('Content-Type: text/xml');
    header('Content-Disposition: attachment; filename="'.basename($Axml).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    //header('Content-Length: ' . filesize($Axml));
    readfile($Axml);
}
   else // sin NO encuentra el xml
{
?>
<script>
alert("NO SE ENCUENTRA COMPROBANTE O ESTA ANULADO");
</script> 
<?php
}

}


 
} elseif($boton=='btnrpta'){ // SIE ES PARA SOLICITAR EL ARCHIVO RPTA &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&


$tipodoc=$_POST["tipodoc"];
$serienumero=$_POST["serienumero"];
$nruc=$_POST["nruc"];
$idempresa=$_POST["idempresa"];

require_once "../modelos/Rutas.php";
require_once "../modelos/Venta.php";
require_once "../modelos/Factura.php";

$rutas = new Rutas();
$venta = new Venta();
$factura = new Factura();

$Rrutas = $rutas->mostrar2($idempresa);
$Prutas = $Rrutas->fetch_object();
$rutarpta=$Prutas->rutarpta; // ruta de la carpeta FIRMA

$datos = $factura->datosemp($idempresa);
$datose = $datos->fetch_object();

if ($tipodoc=='01' || $tipodoc=='03') {

 $rsptav = $venta->ventacabeceraConsulta($tipodoc, trim($nruc) , trim($serienumero));
 $regv = $rsptav->fetch_object();

if ($regv !="") {
 $path  = $rutarpta; 
 $files = array_diff(scandir($path), array('.', '..')); 

 $nombrezip=$datose->numero_ruc."-".$regv->tipo_documento_07."-".$regv->numeracion_08;
 $Azip=$rutarpta."R".$nombrezip.".zip";
    header('Content-Description: File Transfer');
    header('Content-Type: text/zip');
    header('Content-Disposition: attachment; filename="'.basename($Azip).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($Azip));
    readfile($Azip);
}
   else // sin NO encuentra el xml
{
?>
<script>
alert("NO SE ENCUENTRA COMPROBANTE O ESTA ANULADO");
</script> 
<?php
}



}elseif($tipodoc=='07' || $tipodoc=='08') {

 $rsptav = $venta->ventacabeceraConsultaNCD($tipodoc, trim($nruc)  ,trim($serienumero));
 $regv = $rsptav->fetch_object();

if ($regv !="") {
 $path  = $rutarpta; 
 $files = array_diff(scandir($path), array('.', '..')); 

 $nombrezip=$datose->numero_ruc."-".$regv->codigo_nota."-".$regv->numeroserienota;
 $Azip=$rutarpta."R".$nombrezip.".zip";
    header('Content-Description: File Transfer');
    header('Content-Type: text/zip');
    header('Content-Disposition: attachment; filename="'.basename($Azip).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($Azip));
    readfile($Azip);
}
   else // sin NO encuentra el xml
{
?>
<script>
alert("NO SE ENCUENTRA COMPROBANTE O ESTA ANULADO");
</script> 
<?php
}

}
} // Fin de condicional de boton 

?>

