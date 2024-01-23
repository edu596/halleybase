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
require('FacturaCompleta.php');
//require('fpdf.php');
//class PDF extends FPDF
//{
 
//Obtenemos los datos de la cabecera de la venta actuall
require_once "../modelos/Factura.php";
$factura = new Factura();
require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2("1");
    $Prutas = $Rrutas->fetch_object();
    $rutasalidafactura=$Prutas->salidafacturas; 
    $rutalogo=$Prutas->rutalogo; 


$rsptav = $factura->ventacabecera($_GET["id"], $_SESSION['idempresa']);
$datos = $factura->datosemp($_SESSION['idempresa']);
//Recorremos todos los valores obtenidos
$regv = $rsptav->fetch_object();
$datose = $datos->fetch_object();
$logo = $rutalogo.$datose->logo;
$ext_logo = substr($datose->logo, strpos($datose->logo,'.'),-4);


//Establecemos la configuración de la factura
//$pdf = new PDF_Invoice( 'P', 'mm',  'A4' );
//$pdf->AddPage();

#Establecemos los márgenes izquierda, arriba y derecha: 
//$pdf->SetMargins(10, 10 , 10); 

#Establecemos el margen inferior: 
//$pdf->SetAutoPageBreak(true,11); 


$pdf=new PDF_Invoice();
$pdf->AliasNbPages();
$pdf->AddPage();
$y_axis_initial = 25;

//Enviamos los datos de la empresa al método addSociete de la clase Factura
$pdf->addSocietenombre(htmlspecialchars_decode(utf8_decode($datose->nombre_comercial)), $datose->textolibre); //Nuevo

$pdf->addSociete(utf8_decode("Teléfono: ").$datose->telefono1." - ".$datose->telefono2,
    "Email: ".$datose->correo,
    htmlspecialchars_decode(utf8_decode("Dirección: ").$datose->domicilio_fiscal),  $logo, $ext_logo);
//$pdf->addSocietedireccion(htmlspecialchars_decode(utf8_decode("Direción  : ").$datose->domicilio_fiscal)); //Nuevo
$pdf->numFactura("$regv->numeracion_08" , "$datose->numero_ruc");

$pdf->RotatedText($regv->estado, 35,190,'ANULADO - DADO DE BAJA',45);
$pdf->temporaire( "" );
 
//Enviamos los datos del cliente al método addClientAdresse de la clase Factura
$letraCuota="";

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



//Enviamos los datos del cliente al método addClientAdresse de la clase Factura
$pdf->addClientAdresse( $regv->fecha."   /  Hora: ".$regv->hora,    utf8_decode(htmlspecialchars_decode($regv->cliente)), $regv->numero_documento, utf8_decode(htmlspecialchars_decode($regv->direccion)), $regv->estado, utf8_decode($regv->vendedorsitio), utf8_decode($regv->guia), utf8_decode($regv->tipopago), $letraCuota, $regv->moneda, 
    number_format($montocuota,2), $feccuota);





 
if ($regv->nombretrib=="IGV") {
        $nombret="V.U.";
    }else{
        $nombret="PRECIO";
    }

//Establecemos las columnas que va a tener la sección donde mostramos los detalles de la venta
$cols=array( "N"=>10,
                "CODIGO"=>23,
             "DESCRIPCION"=>78,
             "CANTIDAD"=>20,
             $nombret=>20,
             "DSCTO"=>15,
             "SUBTOTAL"=>24);
$pdf->addCols( $cols);
$cols=array( "N"=>"L",
                "CODIGO"=>"L",
             "DESCRIPCION"=>"L",
             "CANTIDAD"=>"C",
             $nombret=>"R",
             "DSCTO" =>"R",
             "SUBTOTAL"=>"C");
$pdf->addLineFormat( $cols);
//Actualizamos el valor de la coordenada "y", que será la ubicación desde donde empezaremos a mostrar los datos
$y= 62;
 


//Obtenemos todos los detalles de la venta actual
$rsptad = $factura->ventadetalle($_GET["id"]);
while ($regd = $rsptad->fetch_object()) {

  
    if ($regd->nombretribu=="IGV") {
        $pv=$regd->valor_uni_item_14;
        $subt=$regd->subtotal;
    }else{
        $pv=$regd->precio;
        $subt=$regd->subtotal2;
    }


  $line = array( "N"=> "$regd->norden",
                    "CODIGO"=> "$regd->codigo",
                "DESCRIPCION"=>  utf8_decode(htmlspecialchars_decode("$regd->articulo"."  "."$regd->descdet")),
                "CANTIDAD"=> "$regd->cantidad_item_12"." "."$regd->unidad_medida",
                $nombret=> number_format($pv,2),
                "DSCTO" => "$regd->descuento",
                "SUBTOTAL"=> $subt);
        
            $size = $pdf->addLine($y, $line);
            $y+= $size + 1;

}




//======= PARA EXTRAER EL HASH DEL DOCUMENTO FIRMADO ========================================
    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($_SESSION['idempresa']);
    $Prutas = $Rrutas->fetch_object();
    $rutafirma=$Prutas->rutafirma; // ruta de la carpeta FIRMA
    $data[0] = "";

//===========PARA EXTRAER EL CODIGO HASH =============================
// if ($regv->estado=='5') {
// $facturaFirm=$regv->numero_ruc."-".$regv->tipo_documento_07."-".$regv->numeracion_08;
// $sxe = new SimpleXMLElement($rutafirma.$facturaFirm.'.xml', null, true);
// $urn = $sxe->getNamespaces(true);
// $sxe->registerXPathNamespace('ds', $urn['ds']);
// $data = $sxe->xpath('//ds:DigestValue');
// }
// else
// {
//      $data[0] = "";
// }

//==================== PARA IMAGEN DEL CODIGO HASH ================================================
//set it to writable location, a place for temp generated PNG files
//     $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'/generador-qr/temp'.DIRECTORY_SEPARATOR;
//     //html PNG location prefix
//     $PNG_WEB_DIR = 'temp/';
//     include 'generador-qr/phpqrcode.php';    
    
//     //ofcourse we need rights to create temp dir
//     if (!file_exists($PNG_TEMP_DIR)){
//         mkdir($PNG_TEMP_DIR);
//     }
    
//     $filename = $PNG_TEMP_DIR.'test.png';
//     //processing form input
//     //remember to sanitize user input in real-life solution !!!
//     $dataTxt=$regv->numero_ruc."|".$regv->tipo_documento_07."|".$regv->serie."|".$regv->numerofac."|".$regv->sumatoria_igv_22_1."|".$regv->importe_total_venta_27."|".$regv->fecha2."|".$regv->tipo_documento."|".$regv->numero_documento."|";

//     $errorCorrectionLevel = 'H';    
//     $matrixPointSize = '2';

//     // user data
//         $filename = $PNG_TEMP_DIR.'test'.md5($dataTxt.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
//         QRcode::png($dataTxt, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
//         //default data
//         //QRcode::png('PHP QR Code :)', $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
//        //display generated file
//         $PNG_WEB_DIR.basename($filename);

// // //==================== PARA IMAGEN  ================================================
// $logoQr = $filename;
// //$logoQr = "../files/logo/".$datose->logo;
// $ext_logoQr = substr($filename, strpos($filename,'.'),-4);
// $pdf->ImgQr($logoQr, $ext_logoQr);
//======= PARA EXTRAER EL HASH DEL DOCUMENTO FIRMADO ========================================



$viewmon="";
if ($regv->moneda=='USD'){$viewmon=" DOLARES";}else{$viewmon=" SOLES";}

//Convertimos el total en letras
require_once "Letras.php";
$V=new EnLetras(); 
$con_letra=strtoupper($V->ValorEnLetras($regv->importe_total_venta_27,"CON"));
$pdf->addCadreTVAs($con_letra, $viewmon);
//$pdf->observSunat($regv->numeracion_08,$regv->estado, $data[0], $datose->webconsul,  $datose->nresolucion);
$pdf->observSunat($regv->numeracion_08,$regv->estado, $regv->hashc, $datose->webconsul,  $datose->nresolucion);

$pdf->numerocuentas($datose->banco1, $datose->cuenta1, $datose->banco2, $datose->cuenta2, $datose->banco3, $datose->cuenta3, $datose->banco4, $datose->cuenta4, $datose->cuentacci1, $datose->cuentacci2, $datose->cuentacci3, $datose->cuentacci4);
 
//Mostramos el impuesto
$pdf->addTVAs( $regv->sumatoria_igv_22_1 , $regv->subtotal,"", $regv->tdescuento, 
    $regv->ipagado  , $regv->saldo, $regv->icbper,  $regv->otroscargos);
$pdf->addCadreEurosFrancs($regv->sumatoria_igv_22_1, $regv->nombretrib, $viewmon);


$pdf->AutoPrint();

//Linea para guardar la factura en la carpeta facturas PDF
$Factura=$pdf->Output($regv->numeracion_08.'.pdf','I');
//$Factura=$pdf->Output('../facturasPDF/'.$regv->numeracion_08.'.pdf','F');
$Factura=$pdf->Output($rutasalidafactura.$regv->numeracion_08.'.pdf','F');




}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}
 
}
ob_end_flush();
?>