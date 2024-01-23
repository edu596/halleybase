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

<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<link href="../public/css/ticket.css" rel="stylesheet" type="text/css">

</head>
<body onload="window.print();">
<?php
 
//Incluímos la clase Venta
require_once "../modelos/Factura.php";
$factura = new Factura();
$datos = $factura->datosemp($_SESSION['idempresa']);
$datose = $datos->fetch_object();
//En el objeto $rspta Obtenemos los valores devueltos del método ventacabecera del modelo
$rspta = $factura->ventacabecera($_GET["id"], $_SESSION['idempresa'] );

$logo = "../files/logo/".$datose->logo;
$ext_logo = substr($datose->logo, strpos($datose->logo,'.'),-5);
//$ext_logo = 'png';
//Recorremos todos los valores obtenidos
$reg = $rspta->fetch_object();


 if ($reg->nombretrib=="IGV") {

        $nombretigv=$reg->subtotal;
        $nombretexo="0.00";
    }else{
        $nombretigv="0.00";
        $nombretexo=$reg->subtotal;
    }
 
?>
<!-- <div class="zona_impresion"> -->
<!-- codigo imprimir -->
<br>
<table border="0" align="center" width="230px">
    <tr>
        <td align="center">
        <!-- Mostramos los datos de la empresa en el documento HTML -->
        <img src="<?php echo $logo.'.'.$ext_logo;?>" width="70" ><br>
        .::<strong> <?php echo utf8_decode(htmlspecialchars_decode($datose->nombre_comercial)) ?></strong>::.<br>
        <strong> R.U.C.  <?php echo $datose->numero_ruc; ?></strong><br>
        <?php echo utf8_decode($datose->domicilio_fiscal) .' - '.$datose->telefono1. "-". $datose->telefono2 ; ?><br>
        <?php echo utf8_decode(strtolower($datose->correo)); ?><br>
         <?php  echo utf8_decode(strtolower($datose->web)); ?>  

        </td>

        <tr>
        <td style="text-align: center;" >-------------------------------------------------------</td>
        </tr>   

        <tr>
        <td align="center">
    <strong> FACTURA DE VENTA </br>
         ELECTRÓNICA </br>
         <?php echo $reg->numeracion_08; ?>
     </strong></td>
        </tr>

        <tr>
        <td style="text-align: center;">-------------------------------------------------------</td>
        </tr> 
    </tr>

    <tr>
        <td align="left"><strong>Cliente:</strong> </br>
         <?php echo $reg->cliente; ?></td>
    </tr>

    <tr>
        <td align="left"><strong>RUC:</strong> </br>
         <?php echo $reg->numero_documento; ?></td>
    </tr>

    <tr>
        <td align="left"><strong>Dirección:</strong> </br>
         <?php  echo utf8_decode(strtolower($reg->direccion)); ?></td>
    </tr>

    <tr>
        <td align="left"><strong>Fecha de emisión:</strong> 
         <?php echo $reg->fecha; ?></td>
    </tr>

    <tr>
        <td align="left"><strong>Fecha de Vcto:</strong> 
         <?php echo "."; ?></td>
    </tr>

    <tr>
        <td align="left"><strong>Moneda:</strong> 
         SOLES</td>
    </tr>

    <tr>
        <td align="left"><strong>Atención:</strong> 
         <?php echo $reg->vendedorsitio; ?></td>
    </tr>

    <tr>
        <td align="left"><strong>Tipo de pago:</strong> 
         <?php echo $reg->tipopago; ?></td>
    </tr>

    <tr>
        <td align="left"><strong>Nro referencia:</strong> 
         <?php echo $reg->nroreferencia; ?></td>
    </tr>
    
</table>

<br>

<!-- Mostramos los detalles de la venta en el documento HTML -->
<table border="0" align="center" width="220px" style="font-size: 11px" >
    <tr>
        <td>Cant.</td>
        <td align="left">Producto</td>
        <td>V.u.</td>
        <td >Importe</td>
    </tr>

    <tr>
      <td colspan="5">-----------------------------------------------------</td>
    </tr>

    <?php

//======= PARA EXTRAER EL HASH DEL DOCUMENTO FIRMADO ========================================
    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($_SESSION['idempresa']);
    $Prutas = $Rrutas->fetch_object();
    $rutafirma=$Prutas->rutafirma; // ruta de la carpeta FIRMA
    $data[0] = "";

//===========PARA EXTRAER EL CODIGO HASH =============================
if ($reg->estado=='5') {
$facturaFirm=$reg->numero_ruc."-".$reg->tipo_documento_07."-".$reg->numeracion_08;
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
    $dataTxt=$reg->numero_ruc."|".$reg->tipo_documento_07."|".$reg->serie."|".$reg->numerofac."|".$reg->sumatoria_igv_22_1."|".$reg->importe_total_venta_27."|".$reg->fecha2."|".$reg->tipo_documento."|".$reg->numero_documento."|";
    $errorCorrectionLevel = 'H';    
    $matrixPointSize = '2';
    // user data
    $filename = 'generador-qr/temp/test'.md5($dataTxt.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
        QRcode::png($dataTxt, $filename, $errorCorrectionLevel, $matrixPointSize, 2);    
        $PNG_WEB_DIR.basename($filename);
// //==================== PARA IMAGEN  ================================================
$logoQr = $filename;
//$logoQr = "generador-qr/temp/".$datose->logo;
$ext_logoQr = substr($filename, strpos($filename,'.'),-4);
//ImgQrT($logoQr, $ext_logoQr);
//======= PARA EXTRAER EL HASH DEL DOCUMENTO FIRMADO ========================================



    $rsptad = $factura->ventadetalle($_GET["id"]);
    $cantidad=0;
    while ($regd = $rsptad->fetch_object()) {

        if ($regd->nombretribu=="IGV") {
        $pv=$regd->valor_uni_item_14;
        $subt=$regd->subtotal;
    }else{
        $pv=$regd->precio;
        $subt=$regd->subtotal2;

    }
        echo "<tr>";
        echo "<td>".$regd->cantidad_item_12."</td>";
        echo "<td>".strtolower($regd->articulo)."</td>";
        echo "<td>".$pv ."</td>";
        echo "<td align='right'>".$subt."</td>";
        echo "</tr>";
      
        $cantidad+=$regd->cantidad_item_12;
    }
    ?>
      </table>

    <?php
    require_once "Letras.php";
    $V=new EnLetras(); 
    $con_letra=strtolower($V->ValorEnLetras($reg->importe_total_venta_27,"NUEVOS SOLES"));

    echo "<table border='0'  width='220px' style='font-size: 12px' align='center' >
    <tr><td>-----------------------------------------------------</td></tr>";
    echo "<tr><td></br><strong>Son: </strong>".$con_letra."</td></tr></table>";
    ?>

    
        <table border='0'  width='220px' style='font-size: 12px'  align="center">
        <tr><td colspan='5'><strong>Total descuento: </strong></td><td><?php  echo $reg->tdescuento ?></td></tr>
        <tr><td colspan='5'><strong>OP. gravada: </strong></td><td><?php  echo $nombretigv; ?></td></tr>
        <tr><td colspan='5' ><strong>OP. exonerado: </strong></td><td><?php  echo $nombretexo; ?></td></tr>
        <tr><td colspan='5'><strong>OP. inafecto: </strong></td><td>0.00</td></tr>
        <tr><td colspan='5'><strong>I.G.V. 18.00: </strong></td><td><?php  echo $reg->sumatoria_igv_22_1 ?></td></tr>
        <tr><td colspan='5'><strong>Imp. Pagado: </strong></td><td><?php  echo $reg->ipagado ?></td></tr>
        <tr><td colspan='5'><strong>Saldo/vuelto: </strong></td><td><?php  echo $reg->saldo ?></td></tr>
        </table>
   

    <!-- Mostramos los totales de la venta en el documento HTML -->
    
<table border='0'  width='220px' style='font-size: 12px'  align="center">
    <tr><td align='right'><strong>TOTAL:  <?php echo $reg->importe_total_venta_27 ?></strong></td></tr><br>
    <tr>
        <td><strong>Vendedor: <?php echo $reg->vendedorsitio  ?></strong></td>
    </tr>

    <tr>
      <td colspan="5">================================</td>
    </tr>

    
    <tr>
      <td colspan="5" align="center"><?php echo utf8_decode($datose->nombre_comercial) ?></td>
    </tr>
    <tr>
      
    </tr>
     
</table>
<br>

<div style="text-align: center;" >
    <img src=<?php  echo $logoQr;   ?> width="130" height="130"><br>
    <label>Código HASH: <?php echo $data[0] ; ?> </label>
    <br>
    <br>
    <label>::.GRACIAS POR SU COMPRA.::</label>
</div>

<!-- </div> -->
<p>&nbsp;</p>
 
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
