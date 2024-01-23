<?php
//Activamos el almacenamiento en el buffer
ob_start();
if (strlen(session_id()) < 1) 
  session_start();
 
if (!isset($_SESSION["nombre"]))
{
  echo 'Debe ingresar al sistema correctamente para visualizar ';
}
else
{
if ($_SESSION['ventas']==1)
{

//$tipodoc=$_GET["tipodoc"];

//Incluímos el archivo Factura.php
require('Factura.php');
 
//Obtenemos los datos de la cabecera de la venta actual
require_once "../modelos/Notacd.php"; 
$ncredito = new Notacd();

require_once "../modelos/Factura.php";
$factura = new Factura();



 require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2("1");
    $Prutas = $Rrutas->fetch_object();
    $rutasalidafactura=$Prutas->salidafacturas; 
    $rutalogo=$Prutas->rutalogo; 


    

$tipodoc=$_GET['tipodoc'];


if ($tipodoc=="01") {

$rsptav = $ncredito->cabecerancreditoFac($_GET["id"], $_SESSION['idempresa']);
$datos = $factura->datosemp($_SESSION['idempresa']);
//Recorremos todos los valores obtenidos
$regv = $rsptav->fetch_object();
$datose = $datos->fetch_object();

 $logo = $rutalogo.$datose->logo;
 $ext_logo = substr($datose->logo, strpos($datose->logo,'.'),-4);
 
//Establecemos la configuración de la factura
$pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
$pdf->AddPage();
#Establecemos los márgenes izquierda, arriba y derecha: 
$pdf->SetMargins(10, 10 , 10); 
#Establecemos el margen inferior: 
$pdf->SetAutoPageBreak(true,10); 

//===================PRIMERA COPIA ================================================================
//Enviamos los datos de la empresa al método addSociete de la clase Factura
$pdf->addSocieteNCD( utf8_decode(htmlspecialchars_decode($datose->nombre_comercial)), utf8_decode(htmlspecialchars_decode("Dirección  : ")). utf8_decode(htmlspecialchars_decode($datose->domicilio_fiscal))."\n".utf8_decode("Teléfono   : ").$datose->telefono1."\n" ."Email        : ".$datose->correo, $logo, $ext_logo);
//
$pdf->numNotac("$regv->numerncd" , "$datose->numero_ruc");


$pdf->RotatedText($regv->estado, 35,190,'ANULADO - DADO DE BAJA',45);
$pdf->temporaire( "" );
 

//Enviamos los datos del cliente al método addClientAdresse de la clase Factura
$pdf->addClientAdresseNC( utf8_decode(htmlspecialchars_decode($regv->cliente)), utf8_decode(htmlspecialchars_decode($regv->domicilio)), $regv->femision, $regv->nfactura, utf8_decode($regv->femisionfac),  utf8_decode(htmlspecialchars_decode($regv->observacion)), utf8_decode($regv->vendedorsitio), $regv->numero_documento, $regv->tmoneda, $regv->tmonedafac);
 
//Establecemos las columnas que va a tener la sección donde mostramos los detalles de la venta
$cols=array( "CODIGO"=>23,
             "DESCRIPCION"=>85,
             "CANTIDAD"=>22,
             "V.U."=>22,
             "IMPORTE"=>50);
$pdf->addColsNC( $cols);
$cols=array( "CODIGO"=>"L",
             "DESCRIPCION"=>"L",
             "CANTIDAD"=>"L",
             "V.U."=>"L",
             "IMPORTE" =>"C");
$pdf->addLineFormat( $cols);
//$pdf->addLineFormat($cols);

//Actualizamos el valor de la coordenada "y", que será la ubicación desde donde empezaremos a mostrar los datos
$y= 51;
 
//Obtenemos todos los detalles de la venta actual
 $rsptad = $ncredito->detalleNotacredito($_GET["id"], $_SESSION['idempresa']  ,  $regv->nfactura);
 
while ($regd = $rsptad->fetch_object()) {
  $line = array( "CODIGO"=>  utf8_decode(htmlspecialchars_decode("$regd->codigo")),
                "DESCRIPCION"=>  utf8_decode(htmlspecialchars_decode("$regd->articulo"))." - ".utf8_decode("$regd->descripitem"),
                "CANTIDAD"=> "$regd->cantidad",
                "V.U."=> "$regd->valor_unitario",
                "IMPORTE"=> "$regd->valor_venta");
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

//===========PARA EXTRAER EL CODIGO HASH =============================
if ($regv->estado=='5') {
$notaFirm=$regv->numero_ruc."-".$regv->codigo_nota."-".$regv->numerncd;
$sxe = new SimpleXMLElement($rutafirma.$notaFirm.'.xml', null, true);
$urn = $sxe->getNamespaces(true);
$sxe->registerXPathNamespace('ds', $urn['ds']);
$data = $sxe->xpath('//ds:DigestValue');
}
else
{
     $data[0] = "";
}
//======= PARA EXTRAER EL HASH DEL DOCUMENTO FIRMADO ========================================
$viewmon="";
if ($regv->tmoneda=='USD'){$viewmon=" DOLARES";}else{$viewmon=" SOLES";}
 //Convertimos el total en letras
 require_once "Letras.php";
 $V=new EnLetras(); 
 $con_letra=strtoupper($V->ValorEnLetras($regv->total,"CON"));
 $pdf->addCadreTVAsNC($con_letra, $viewmon);
$pdf->observSunatNC("$regv->numerncd","$regv->estado",$data[0], $datose->webconsul , $datose->nresolucion); 
// //Mostramos el impuesto
 $pdf->addTVAsNC( $regv->igv, $regv->total,"");
 $pdf->addCadreEurosFrancsNC($regv->igv);



//Enviamos los datos de la empresa al método addSociete de la clase Factura
$pdf->addSocieteNCD2( utf8_decode(htmlspecialchars_decode($datose->nombre_comercial)), utf8_decode(htmlspecialchars_decode("Dirección  : ")). utf8_decode(htmlspecialchars_decode($datose->domicilio_fiscal))."\n".utf8_decode("Teléfono   : ").$datose->telefono1."\n" ."Email        : ".$datose->correo, $logo, $ext_logo);
//
$pdf->numNotac2("$regv->numerncd" , "$datose->numero_ruc");
$pdf->temporaire( "" );
//Enviamos los datos del cliente al método addClientAdresse de la clase Factura
$pdf->addClientAdresseNC2( utf8_decode(htmlspecialchars_decode($regv->cliente)), utf8_decode(htmlspecialchars_decode($regv->domicilio)), $regv->femision, $regv->nfactura, utf8_decode($regv->femisionfac),  utf8_decode(htmlspecialchars_decode($regv->observacion)), utf8_decode($regv->vendedorsitio),  $regv->tmoneda, $regv->tmonedafac);
//Establecemos las columnas que va a tener la sección donde mostramos los detalles de la venta
$cols=array( "CODIGO"=>23,
             "DESCRIPCION"=>85,
             "CANTIDAD"=>22,
             "V.U."=>22,
             "IMPORTE"=>50);
$pdf->addColsNC2( $cols);
$cols=array( "CODIGO"=>"L",
             "DESCRIPCION"=>"L",
             "CANTIDAD"=>"L",
             "V.U."=>"L",
             "IMPORTE" =>"C");
$pdf->addLineFormat( $cols);
//$pdf->addLineFormat($cols);

$y= 200;//Actualizamos el valor de la coordenada "y", que será la ubicación desde donde empezaremos a mostrar los datos
//Obtenemos todos los detalles de la venta actual
 $rsptad = $ncredito->detalleNotacredito($_GET["id"],  $_SESSION['idempresa']  , $regv->nfactura);
while ($regd = $rsptad->fetch_object()) {
  $line = array( "CODIGO"=>  utf8_decode(htmlspecialchars_decode("$regd->codigo")),
                "DESCRIPCION"=>  utf8_decode(htmlspecialchars_decode("$regd->articulo"))." - ".utf8_decode("$regd->descripitem"),
                "CANTIDAD"=> "$regd->cantidad",
                "V.U."=> "$regd->valor_unitario",
                "IMPORTE"=> "$regd->valor_venta");
            $size = $pdf->addLine2NC( $y, $line );
            $y   += $size + 2;
}
//Convertimos el total en letras
$viewmon="";
if ($regv->tmoneda=='USD'){$viewmon=" DOLARES";}else{$viewmon=" SOLES";}
 require_once "Letras.php";
 $V=new EnLetras(); 
 $con_letra=strtoupper($V->ValorEnLetras($regv->total,"CON"));
 $pdf->addCadreTVAsNC2($con_letra, $viewmon);
$pdf->observSunatNC2("$regv->numerncd","$regv->estado",$data[0], $datose->webconsul , $datose->nresolucion); 
//Mostramos el impuesto
 $pdf->addTVAsNC2( $regv->igv, $regv->total,"");
 $pdf->addCadreEurosFrancsNC2($regv->igv);



}else{ //SI ES BOLETA ================================




$rsptavB = $ncredito->cabecerancreditoBol($_GET["id"], $_SESSION['idempresa']);
$datos = $factura->datosemp($_SESSION['idempresa']);
//Recorremos todos los valores obtenidos
$regv = $rsptavB->fetch_object();
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
//===================PRIMERA COPIA ================================================================
//Enviamos los datos de la empresa al método addSociete de la clase Factura
$pdf->addSocieteNCD( utf8_decode(htmlspecialchars_decode($datose->nombre_comercial)), utf8_decode(htmlspecialchars_decode("Dirección  : ")). utf8_decode(htmlspecialchars_decode($datose->domicilio_fiscal))."\n".utf8_decode("Teléfono   : ").$datose->telefono1."\n" ."Email        : ".$datose->correo, $logo, $ext_logo);
$pdf->numNotac("$regv->numerncd" , "$datose->numero_ruc");
$pdf->temporaire( "" );
//Enviamos los datos del cliente al método addClientAdresse de la clase Factura
$pdf->addClientAdresseNC( utf8_decode(htmlspecialchars_decode($regv->cliente)), utf8_decode(htmlspecialchars_decode($regv->domicilio)), $regv->femision, $regv->nboleta, utf8_decode($regv->femisionbol),  utf8_decode(htmlspecialchars_decode($regv->observacion)), utf8_decode($regv->vendedorsitio), $regv->numero_documento);
//Establecemos las columnas que va a tener la sección donde mostramos los detalles de la venta
$cols=array( "CODIGO"=>23,
             "DESCRIPCION"=>85,
             "CANTIDAD"=>22,
             "V.U."=>22,
             "IMPORTE"=>50);
$pdf->addColsNC( $cols);
$cols=array( "CODIGO"=>"L",
             "DESCRIPCION"=>"L",
             "CANTIDAD"=>"L",
             "V.U."=>"L",
             "IMPORTE" =>"C");
$pdf->addLineFormat( $cols);
//$pdf->addLineFormat($cols);

//Actualizamos el valor de la coordenada "y", que será la ubicación desde donde empezaremos a mostrar los datos
$y= 51;
 
//Obtenemos todos los detalles de la venta actual
 $rsptad = $ncredito->detalleNotacreditoBol($_GET["id"], $_SESSION['idempresa'], $regv->nboleta );
 
while ($regd = $rsptad->fetch_object()) {
  $line = array( "CODIGO"=>  utf8_decode(htmlspecialchars_decode("$regd->codigo")),
                "DESCRIPCION"=>  utf8_decode(htmlspecialchars_decode("$regd->articulo")),
                "CANTIDAD"=> "$regd->cantidad",
                "V.U."=> "$regd->valor_unitario",
                "IMPORTE"=> "$regd->valor_venta");
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

//===========PARA EXTRAER EL CODIGO HASH =============================
if ($regv->estado=='5') {
$notaFirm=$regv->numero_ruc."-".$regv->codigo_nota."-".$regv->numerncd;
$sxe = new SimpleXMLElement($rutafirma.$notaFirm.'.xml', null, true);
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
 $con_letra=strtoupper($V->ValorEnLetras($regv->total,"NUEVOS SOLES"));
 $pdf->addCadreTVAsNC("".$con_letra);
$pdf->observSunatNC("$regv->numerncd","$regv->estado",$data[0], $datose->webconsul , $datose->nresolucion); 
// //Mostramos el impuesto
 $pdf->addTVAsNC( $regv->igv, $regv->total,"S/ ");
 $pdf->addCadreEurosFrancsNC($regv->igv);



 //Enviamos los datos de la empresa al método addSociete de la clase Factura
$pdf->addSocieteNCD2( utf8_decode(htmlspecialchars_decode($datose->nombre_comercial)), utf8_decode(htmlspecialchars_decode("Dirección  : ")). utf8_decode(htmlspecialchars_decode($datose->domicilio_fiscal))."\n".utf8_decode("Teléfono   : ").$datose->telefono1."\n" ."Email        : ".$datose->correo, $logo, $ext_logo);
//
$pdf->numNotac2("$regv->numerncd" , "$datose->numero_ruc");
$pdf->temporaire( "" );
//Enviamos los datos del cliente al método addClientAdresse de la clase Factura
$pdf->addClientAdresseNC2( utf8_decode(htmlspecialchars_decode($regv->cliente)), utf8_decode(htmlspecialchars_decode($regv->domicilio)), $regv->femision, $regv->nboleta, utf8_decode($regv->femisionbol),  utf8_decode(htmlspecialchars_decode($regv->observacion)), utf8_decode($regv->vendedorsitio));
//Establecemos las columnas que va a tener la sección donde mostramos los detalles de la venta
$cols=array( "CODIGO"=>23,
             "DESCRIPCION"=>85,
             "CANTIDAD"=>22,
             "V.U."=>22,
             "IMPORTE"=>50);
$pdf->addColsNC2( $cols);
$cols=array( "CODIGO"=>"L",
             "DESCRIPCION"=>"L",
             "CANTIDAD"=>"L",
             "V.U."=>"L",
             "IMPORTE" =>"C");
$pdf->addLineFormat( $cols);
//$pdf->addLineFormat($cols);

$y= 200;//Actualizamos el valor de la coordenada "y", que será la ubicación desde donde empezaremos a mostrar los datos
//Obtenemos todos los detalles de la venta actual
 $rsptad = $ncredito->detalleNotacreditoBol($_GET["id"], $_SESSION['idempresa'], $regv->nboleta);
while ($regd = $rsptad->fetch_object()) {
  $line = array( "CODIGO"=>  utf8_decode(htmlspecialchars_decode("$regd->codigo")),
                "DESCRIPCION"=>  utf8_decode(htmlspecialchars_decode("$regd->articulo")),
                "CANTIDAD"=> "$regd->cantidad",
                "V.U."=> "$regd->valor_unitario",
                "IMPORTE"=> "$regd->valor_venta");
            $size = $pdf->addLine2NC( $y, $line );
            $y   += $size + 2;
}
//Convertimos el total en letras
 require_once "Letras.php";
 $V=new EnLetras(); 
 $con_letra=strtoupper($V->ValorEnLetras($regv->total,"NUEVOS SOLES"));
 $pdf->addCadreTVAsNC2("".$con_letra);
$pdf->observSunatNC2("$regv->numerncd","$regv->estado",$data[0], $datose->webconsul , $datose->nresolucion); 
//Mostramos el impuesto
 $pdf->addTVAsNC2( $regv->igv, $regv->total,"S/ ");
 $pdf->addCadreEurosFrancsNC2($regv->igv);




}
//===================PRIMERA COPIA ================================================================





//Linea para guardar la notas en la carpeta notasPDF
$Factura=$pdf->Output($regv->numerncd.'.pdf','I');
//$Factura=$pdf->Output('../notasPDF/'.$regv->numerncd.'.pdf','F');
$Factura=$pdf->Output('C:/sfs/notasPDF/'.$regv->numerncd.'.pdf','F');

 
$pdf->Output('Reporte de Venta','I');


}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}
 
}
ob_end_flush();
?>