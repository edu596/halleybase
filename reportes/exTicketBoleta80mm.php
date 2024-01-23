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
?>
<html>
<head>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="../public/css/ticket.css" rel="stylesheet" type="text/css">
</head>

    <body  onload="imprimirElemento(imprimible);">

<div align="center">
<button id="btnImprimirDiv" >Imprimir</button>
</div>

<div  id="imprimible" name="imprimible">

<?php
 
//Incluímos la clase Venta
require_once "../modelos/Boleta.php";
require_once "../modelos/Factura.php";
//Instanciamos a la clase con el objeto venta
$boleta = new Boleta();
$factura = new Factura();
$datos = $factura->datosempImpresiones($_SESSION['idempresa']);
//En el objeto $rspta Obtenemos los valores devueltos del método ventacabecera del modelo
$rspta = $boleta->ventacabecera($_GET["id"], $_SESSION['idempresa']);


//Recorremos todos los valores obtenidos
$reg = $rspta->fetch_object();
$datose = $datos->fetch_object();

//$logo = "../files\logo\\".$datose->logo;
$logo = $datose->rutalogo.$datose->logo;

$ext_logo = substr($datose->logo, strpos($datose->logo,'.'),-4);

if ($reg->nombretrib=="IGV") {

        $nombretigv=$reg->subtotal;
        $nombretexo="0.00";
    }else{
        $nombretigv=$reg->subtotal;
        $nombretexo=$reg->subtotal;
    }
 
 
?>

<table align="center" cellpadding="0" cellspacing="0" style="font-family: Arial, Helvetica, sans-serif; font-size: 11px;">
    <tbody>
     <tr align="center">
        <td>
            
            <img src="<?php echo $logo;?>" width="100" >
        </td>
    </tr>

        <tr align="center">
            <td >
        .::<strong> 
            <?php echo utf8_decode(htmlspecialchars_decode($datose->nombre_comercial)) ?>
        </strong>::.
            </td>
        </tr>
   
        <tr align="center">
        <td> 
        <?php echo $datose->textolibre; ?>
            </td>
        </tr>
   
        <tr align="center">
            <td>
        <strong> R.U.C.  <?php echo $datose->numero_ruc; ?></strong>
            </td>
        </tr>
   
         <tr align="center">
            <td>
         <?php echo utf8_decode($datose->domicilio_fiscal) .' - '.$datose->telefono1. "-". $datose->telefono2 ; ?>
             </td>
         </tr>
   
        <tr align="center">
            <td>
        <?php echo utf8_decode(strtolower($datose->correo)); ?>
                </td>
            </tr>
   
         <tr align="center">
            <td>
         <?php  echo utf8_decode(strtolower($datose->web)); ?>  
                </td>
            </tr>

        <tr align="center">
        <td >
    <strong> BOLETA DE VENTA 
         ELECTRÓNICA <br> <?php echo $reg->numeracion_07; ?>
     </strong></td>
        </tr>
    </tbody>
</table>
<br>

<table  cellpadding="0" cellspacing="0" style="font-family: Arial, Helvetica, sans-serif; font-size: 11px;">
    <tbody>
         
    <tr >
        <td ><strong>Cliente:</strong> </td> 
        <td><?php echo $reg->cliente; ?></td>
    </tr>

    <tr >
        <td ><strong>RUC/DNI:</strong> </td> <td>
         <?php echo $reg->numero_documento; ?></td>
    </tr>

    <tr >
        <td ><strong>Dirección:</strong> </td> <td>
         <?php echo $reg->direccion; ?></td>
    </tr>

    <tr >
        <td ><strong>Fecha emisión:</strong> </td> <td>
         <?php echo $reg->fecha ." / ".$reg->hora; ?></td>
    </tr>

   <!--  <tr>
        <td ><strong>Fecha de Vcto:</strong> 
         <?php echo "."; ?></td>
    </tr> -->

    <tr >
        <td ><strong>Moneda:</strong></td> <td> 
        SOLES</td>
    </tr>

     <tr >
        <td ><strong>Atención:</strong> </td> <td>
         <?php echo $reg->vendedorsitio; ?></td>
    </tr>

   <!--  <tr>
        <td ><strong>Tipo de pago:</strong> 
         <?php echo $reg->tipopago; ?></td>
    </tr> -->

   <!--  <tr>
        <td ><strong>Nro referencia:</strong> 
         <?php echo $reg->nroreferencia; ?></td>
    </tr> -->
    </tbody>
</table>

<br>




<!-- Mostramos los detalles de la venta en el documento HTML -->
<table border="0" align="center" width="280px" cellpadding="0" cellspacing="0" style="font-family: Arial, Helvetica, sans-serif; font-size: 11px;">
    <tr align="center">
        <td><strong>Cantidad</strong></td>
        <td><strong>Producto</strong></td>
        <td><strong>Précio</strong></td>
        <td align="right"><strong>Importe</strong></td>
    </tr>

    <tr>
      
    </tr>

    <?php

//======= PARA EXTRAER EL HASH DEL DOCUMENTO FIRMADO ========================================
    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($_SESSION['idempresa']);
    $Prutas = $Rrutas->fetch_object();
    $rutafirma=$Prutas->rutafirma; // ruta de la carpeta FIRMA
    $data[0] = "";
    
if ($reg->estado=='5') {
$boletaFirm=$reg->numero_ruc."-".$reg->tipo_documento_06."-".$reg->numeracion_07;
$sxe = new SimpleXMLElement($rutafirma.$boletaFirm.'.xml', null, true);
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
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    $filename = $PNG_TEMP_DIR.'test.png';
    
    //processing form input
    //remember to sanitize user input in real-life solution !!!
     $dataTxt=$reg->numero_ruc."|".$reg->tipo_documento_06."|".$reg->serie."|".$reg->numerofac."|0.00|".$reg->Itotal."|".$reg->fecha2."|".$reg->tipo_documento."|".$reg->numero_documento."|";;
    $errorCorrectionLevel = 'H';    
    $matrixPointSize = '2';

    // user data
        $filename = 'generador-qr/temp/test'.md5($dataTxt.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($dataTxt, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        $PNG_WEB_DIR.basename($filename);
// //==================== PARA IMAGEN DEL CODIGO HASH ================================================

$logoQr = $filename;
$ext_logoQr = substr($filename, strpos($filename,'.'),-4);

//===============SEGUNDA COPIA DE BOLETA=========================
    $rsptad = $boleta->ventadetalle($_GET["id"]);
    $cantidad=0;
    while ($regd = $rsptad->fetch_object()) {

        if ($regd->nombretribu=="IGV") {
        $pv=$regd->precio;
        $subt=$regd->subtotal;
    }else{
        $pv=$regd->precio;
        $subt=$regd->subtotal2;

    }
        echo "<tr>";
        echo "<td>".$regd->cantidad_item_12."</td>";
        echo "<td align='left'>".strtolower($regd->articulo)."</td>";
        echo "<td align='right'>".number_format($pv,2) ."</td>";
        echo "<td align='right'>".$subt."</td>";
        
        echo "</tr>";
        $cantidad+=$regd->cantidad_item_12;
    }
    ?>
        </table>
        <br>
    <?php

    $viewmon="";
    if ($reg->moneda=='USD'){$viewmon=" DOLARES";}else{$viewmon=" SOLES";}


    require_once "Letras.php";
    $V=new EnLetras(); 
    $con_letra=strtolower($V->ValorEnLetrasTicket($reg->Itotal," CON ", $viewmon));

    echo "<table border='0'  align='center' width='280px' cellpadding='0' cellspacing='0' style='font-family: Arial, Helvetica, sans-serif; font-size:11px;'>
    <tr></tr>";
    echo "<tr><td><strong>Son: </strong>".$con_letra."</td></tr></table>";
    ?>
        <table border='0'  width='280px' style='font-size: 12px'  align="center">
        <!-- <tr><td colspan='5'><strong>Total descuento </strong></td><td>:</td><td><?php  echo $reg->tdescuento ?></td></tr> -->
        <tr><td colspan='5' ><strong>OP. gravada </strong></td><td>:</td><td align='right'><?php  echo $nombretigv; ?></td></tr>
        <!-- <tr><td colspan='5' ><strong>OP. exonerado </strong></td><td >:</td><td><?php  echo $nombretexo; ?></td></tr>
        <tr><td colspan='5' ><strong>OP. inafecto </strong></td><td >:</td><td>0.00</td></tr>
        <tr><td colspan='5'><strong>I.G.V. 18.00 </strong></td><td >:</td><td><?php echo $reg->igv ?></td></tr> -->
        <!-- <tr><td colspan='5'><strong>ICBPER</strong></td><td >:</td><td><?php echo $reg->icbper ?></td></tr>
        <tr><td colspan='5'><strong>Imp. Pagado: </strong></td><td >:</td><td><?php  echo $reg->ipagado ?></td></tr>
        <tr><td colspan='5'><strong>Saldo/vuelto: </strong></td><td >:</td><td><?php  echo $reg->saldo ?></td></tr> -->

        <!-- <tr><td colspan='5'><strong>I.G.V. 18.00 </strong></td><td >:</td><td><?php echo $reg->sumatoria_igv_18_1; ?></td></tr> -->
        </table>


    <!-- Mostramos los totales de la venta en el documento HTML -->
    
<table border='0'  width='280px' align="center" cellpadding="0" cellspacing="0" style="font-family: Arial, Helvetica, sans-serif; font-size: 11px;">
    <tr><td align='right'><strong>TOTAL:  <?php echo $reg->Itotal ?></strong></td></tr>

     <tr>
      <td colspan="5" align="center"><?php echo utf8_decode($datose->nombre_comercial) ?></td>
    </tr>

    <tr>
      <td colspan="5" align="center">::.GRACIAS POR SU COMPRA.::</td>
    </tr>

    <tr>
      <td  align="center"><img src=<?php  echo $logoQr;   ?> width="100" height="100"></td>
    </tr>

    <tr>
      <td align="center">Código HASH: <?php echo $reg->hashc; ; ?> </td>
    </tr>

     
</table>


</div>

<script type="text/javascript">
function imprimirElemento(elemento){
  var ventana = window.open('', 'PRINT', 'height=400,width=600');
  ventana.document.write('<html><head><title>' + document.title + '</title>');
  ventana.document.write('</head><body >');
  ventana.document.write(elemento.innerHTML);
  ventana.document.write('</body></html>');
  ventana.document.close();
  ventana.focus();
  ventana.print();
  ventana.close();
  return true;
}

document.querySelector("#btnImprimirDiv").addEventListener("click", function() {
  var div = document.querySelector("#imprimible");
  imprimirElemento(div);
});
</script>



</body>
</html>





<?php 
}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}
 
}
ob_end_flush();
?>
