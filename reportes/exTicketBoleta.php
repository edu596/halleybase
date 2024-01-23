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
if ($_SESSION['ventas']==1  || $_SESSION['inventarios']==1)
{
//Incluímos el archivo Factura.php
require('PlantillaTicket.php');
//Obtenemos los datos de la cabe    cera de la venta actual
require_once "../modelos/Boleta.php";
$boleta = new Boleta();


$rutasalidaboleta="";
require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2("1");
    $Prutas = $Rrutas->fetch_object();
    $rutasalidaboleta=$Prutas->salidaboletas; 
    $rutalogo=$Prutas->rutalogo; 

$rsptav = $boleta->ventacabecera($_GET["id"], $_SESSION['idempresa']);
$datos = $boleta->datosemp($_SESSION['idempresa']);
$regv = $rsptav->fetch_object();
$datose = $datos->fetch_object(); 


$logo = $rutalogo.$datose->logo;
$ext_logo = substr($datose->logo, strpos($datose->logo,'.'),-4);

$pdf = new PDF_Invoice($orientation='P',$unit='mm', array(58,350));
$pdf->AddPage();

$pdf->SetAutoPageBreak(true,10); 

$pdf->addSocietenombre(htmlspecialchars_decode(utf8_decode($datose->nombre_comercial)), $datose->textolibre,  $logo, $ext_logo); //Nuevo

$pdf->addSociete(utf8_decode("Teléfono: ").$datose->telefono1." - ".$datose->telefono2,
    "Email: ".$datose->correo,
    htmlspecialchars_decode(utf8_decode("Dirección: ").$datose->domicilio_fiscal));

$pdf->numBoleta("$regv->numeracion_07",  "$datose->numero_ruc" );

$pdf->RotatedText($regv->estado, 35,190,'ANULADO - DADO DE BAJA',45);
$pdf->temporaire( "" );
 
//Enviamos los datos del cliente al método addClientAdresse de la clase Factura
$pdf->addClientAdresse( $regv->fecha."/Hora: ".$regv->hora, utf8_decode($regv->cliente),utf8_decode($regv->direccion), $regv->numero_documento,$regv->estado, utf8_decode($regv->vendedorsitio), utf8_decode($regv->guia), utf8_decode($regv->tipopago), $regv->nroreferencia, $regv->moneda );


$rsptad = $boleta->ventadetalle($_GET["id"]);
$rsptadAlt = $boleta->ventadetalle($_GET["id"]);
$nveces=0;

while ($regdAlt = $rsptadAlt->fetch_object()) {
    $nveces++;
}

if ($regv->nombretrib=="IGV") {

        $nombret="PRECIO";
    }else{
        $nombret="PRECIO";
    }
 

$cols=array( "CODIGO"=>10,
             "DESCRIPCION"=>14,
             "CANTIDAD"=>10,
             $nombret=>10,
             "SUBTOTAL"=>10);
$pdf->addCols($cols, $nveces);
$cols=array( "CODIGO"=>"C",
             "DESCRIPCION"=>"C",
             "CANTIDAD"=>"C",
             $nombret=>"C",
             "SUBTOTAL"=>"C");
$pdf->addLineFormat($cols);


//Actualizamos el valor de la coordenada "y", que será la ubicación desde donde empezaremos a mostrar los datos
$y= 88;
 
//Obtenemos todos los detalles de la venta actual


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
    
// if ($regv->estado=='5') {
// $boletaFirm=$regv->numero_ruc."-".$regv->tipo_documento_06."-".$regv->numeracion_07;
// $sxe = new SimpleXMLElement($rutafirma.$boletaFirm.'.xml', null, true);
// $urn = $sxe->getNamespaces(true);
// $sxe->registerXPathNamespace('ds', $urn['ds']);
// $data = $sxe->xpath('//ds:DigestValue');
// }
// else
// {
//      $data[0] = "";
// }
//======= PARA EXTRAER EL HASH DEL DOCUMENTO FIRMADO ========================================


$viewmon="";
if ($regv->moneda=='USD'){$viewmon=" DOLARES";}else{$viewmon=" SOLES";}


//Convertimos el total en letras
require_once "Letras.php";
$V=new EnLetras(); 
$con_letra=strtoupper($V->ValorEnLetras($regv->totalLetras,"CON"));
$pdf->addCadreEurosFrancs($regv->Itotal,$regv->subtotal,  $regv->tdescuento, $regv->ipagado  , $regv->saldo,  $regv->icbper, $nveces);
$pdf->addCadreTVAs($con_letra, $viewmon, $nveces);
$pdf->observSunat($regv->numeracion_07, $regv->estado, $regv->hashc, $datose->webconsul , $datose->nresolucion, $nveces);




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
        $PNG_WEB_DIR.basename($filename);
// // //==================== PARA IMAGEN DEL CODIGO HASH ================================================

$logoQr = $filename;
$ext_logoQr = substr($filename, strpos($filename,'.'),-4);
$pdf->ImgQr($logoQr, $ext_logoQr, $nveces);

//===============SEGUNDA COPIA DE BOLETA=========================


//==========================================================================
$pdf->AutoPrint();
$pdf->Output($regv->numeracion_07.'.pdf','I');
//$Factura=$pdf->Output('../boletasPDF/'.$regv->numeracion_07.'.pdf','F');
$pdf->Output($rutasalidaboleta.$regv->numeracion_07.'.pdf','F');

}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}
 
}
ob_end_flush();
?>