<?php


ob_start();
if (strlen(session_id()) < 1) 
  session_start();
 
if (!isset($_SESSION["nombre"]))
{
  echo 'Debe ingresar al sistema correctamente para visualizar el reporte';
}
else
{
if ($_SESSION['escritorio']==1)
{

$tipodoc=$_POST["tipodoc"];
$serienumero=$_POST["serienumero"];
$idempresa=$_SESSION['idempresa'];


require('Factura_.php');
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
$rsptav = $venta->BuscacabeceraConsulta($tipodoc, trim($serienumero), $idempresa);
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


//Enviamos los datos de la empresa al método addSociete de la clase Factura
$pdf->addSociete(utf8_decode($datose->nombre_comercial),utf8_decode("Dirección    : ").utf8_decode($datose->domicilio_fiscal)."\n".utf8_decode("Teléfono     : ").$datose->telefono1."\n" ."Email          : ".$datose->correo, $logo, $ext_logo);

$pdf->numComprobante("$regv->numeracion_08" , "$datose->numero_ruc", $regv->tipo_documento_07);
//$pdf->RotatedText($regv->estado, 35,190,'ANULADO - DADO DE BAJA',45);
$pdf->temporaire( "" );
//Enviamos los datos del cliente al método addClientAdresse de la clase Factura
$pdf->addClientAdresse($regv->fecha, utf8_decode($regv->razon_social), $regv->numero_documento, utf8_decode($regv->domicilio_fiscal), $regv->estado, utf8_decode($regv->vendedorsitio), $regv->guia, utf8_decode($regv->vendedorsitio),'','');
//Establecemos las columnas que va a tener la sección donde mostramos los detalles de la venta
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
$pdf->addTVAsComprobante( $regv->sumatoria_igv_22_1, $regv->itotal,"S/ ");
$pdf->addComprobante($regv->sumatoria_igv_22_1);
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
}elseif($tipodoc=='07' || $tipodoc=='08') { // PARA LAS NOTAS

$rsptav = $venta->BuscacabeceraConsultaNCD($tipodoc, trim($serienumero), $idempresa);
$datos = $factura->datosemp($idempresa);
$regv = $rsptav->fetch_object();
$datose = $datos->fetch_object();
 
$logo = "../files/logo/".$datose->logo;
$ext_logo = substr($datose->logo, strpos($datose->logo,'.'),-4);
 if ($regv !="") {
$pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
$pdf->AddPage();
//Enviamos los datos de la empresa al método addSociete de la clase Factura
$pdf->addSociete(utf8_decode($datose->nombre_comercial),utf8_decode("Dirección    : ").utf8_decode($datose->domicilio_fiscal)."\n".utf8_decode("Teléfono     : ").$datose->telefono1."\n" ."Email          : ".$datose->correo, $logo, $ext_logo);

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
$rsptad = $venta->detalleNotaBusca($tipodoc, trim($serienumero));
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
$pdf->addTVAsComprobante($regv->subtotal, $regv->itotal,"S/ ");
$pdf->addComprobante($regv->subtotal);

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


}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}
 
}
ob_end_flush();



?>

