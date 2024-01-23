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


$ano=$_POST['ano'];
$mes=$_POST['mes'];
$dia=$_POST['dia'];
$estado=$_POST['estado'];
$idempresa=$_SESSION['idempresa'];
$comprobante=$_POST['comprobante'];

      require "../config/global.php";

      $connect = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
      mysqli_query( $connect, 'SET NAMES "'.DB_ENCODE.'"');
      //Si tenemos un posible error en la conexión lo mostramos
      if (mysqli_connect_errno())
      {
            printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
            exit();
      }

    require_once "../modelos/Factura.php";
    $factura = new Factura();
    $datos = $factura->datosemp($_SESSION['idempresa']);
    $datose = $datos->fetch_object();

    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($_SESSION['idempresa']);
    $Prutas = $Rrutas->fetch_object();
    $rutadatalt=$Prutas->rutadatalt; // ruta de la carpeta ENVIO
    $rutadescargas=$Prutas->rutadescargas; // ruta de la carpeta ENVIO
    $rutadata=$Prutas->rutadata; // ruta de la carpeta ENVIO
    


$queryFactura = "select 
date_format(fecha_emision_01, '%Y-%m-%d') as fecha, 
right(substring_index(numerodoc,'-',1),1) as serie, 
hora,
tipodocuCliente, 
rucCliente as numero_documento, 
RazonSocial as razon_social, 
tipo_moneda_28, 
subtotal, 
igv, 
 total, 
 tipocomp, 
numerodoc, 
tdescuento, 
estado,
codigotrib,
nombretrib,
codigointtrib,
idfactura
  from 
  (select date_format(f.fecha_emision_01, '%Y-%m-%d') as fecha, 
     right(substring_index(f.numeracion_08,'-',1),1) as serie,
     date_format(f.fecha_emision_01, '%H:%i:%s') as hora,
     p.tipo_documento as tipodocuCliente, 
     p.numero_documento  as rucCliente, 
     p.razon_social  as RazonSocial, 
     f.tipo_moneda_28, 
     f.total_operaciones_gravadas_monto_18_2 as subtotal, 
     f.sumatoria_igv_22_1 as igv, 
     f.importe_total_venta_27 as total, 
     f.tipo_documento_07 as tipocomp, 
     f.numeracion_08 as numerodoc, 
     f.estado, 
     f.tdescuento,
     fecha_emision_01,
     f.codigo_tributo_22_3 as codigotrib,
     f.nombre_tributo_22_4  as nombretrib,
     f.codigo_internacional_22_5 as codigointtrib,
     f.idfactura
    from 
    factura f 
    inner join persona p on f.idcliente=p.idpersona inner join empresa e on f.idempresa=e.idempresa   where year(fecha_emision_01)='$ano' and month(fecha_emision_01)='$mes' and day(fecha_emision_01)='$dia' and f.estado='$estado' and e.idempresa='$idempresa'  
  )
  as tbventa order by numerodoc";  

$queryFacturaServicio = "select 
date_format(fecha_emision_01, '%Y-%m-%d') as fecha, 
right(substring_index(numerodoc,'-',1),1) as serie, 
hora,
tipodocuCliente, 
rucCliente as numero_documento, 
RazonSocial as razon_social, 
tipo_moneda_28, 
subtotal, 
igv, 
 total, 
 tipocomp, 
numerodoc, 
tdescuento, 
estado,
codigotrib,
nombretrib,
codigointtrib,
idfactura
  from 
  (
  select date_format(f.fecha_emision_01, '%Y-%m-%d') as fecha, 
     right(substring_index(f.numeracion_08,'-',1),1) as serie,
     date_format(f.fecha_emision_01, '%H:%i:%s') as hora,
     p.tipo_documento as tipodocuCliente, 
     p.numero_documento  as rucCliente, 
     p.razon_social  as RazonSocial, 
     f.tipo_moneda_28, 
     f.total_operaciones_gravadas_monto_18_2 as subtotal, 
     f.sumatoria_igv_22_1 as igv, 
     f.importe_total_venta_27 as total, 
     f.tipo_documento_07 as tipocomp, 
     f.numeracion_08 as numerodoc, 
     f.estado, 
     f.tdescuento,
     fecha_emision_01,
     f.codigo_tributo_22_3 as codigotrib,
     f.nombre_tributo_22_4  as nombretrib,
     f.codigo_internacional_22_5 as codigointtrib,
     f.idfactura
    from 
    facturaservicio f 
    inner join persona p on f.idcliente=p.idpersona inner join empresa e on f.idempresa=e.idempresa   where year(fecha_emision_01)='$ano' and month(fecha_emision_01)='$mes' and day(fecha_emision_01)='$dia' and f.estado='$estado' and e.idempresa='$idempresa' 
  )
  as tbventa order by numerodoc";  


$queryBoleta = "select 
date_format(fecha_emision_01, '%Y-%m-%d') as fecha, 
right(substring_index(numerodoc,'-',1),1) as serie, 
hora,
tipodocuCliente, 
rucCliente as numero_documento, 
RazonSocial as razon_social, 
tipo_moneda_28, 
subtotal, 
igv, 
 total, 
 tipocomp, 
numerodoc, 
tdescuento, 
estado,
codigotrib,
nombretrib,
codigointtrib,
idboleta
  from 
  ( 
  select 
  date_format(b.fecha_emision_01, '%Y-%m-%d') as fecha, 
  right(substring_index(b.numeracion_07,'-',1),1) as serie, 
  date_format(b.fecha_emision_01, '%H:%i:%s') as hora,
  p.tipo_documento as tipodocuCliente, 
  p.numero_documento as rucCliente, 
  p.razon_social as RazonSocial, 
  b.tipo_moneda_24 as tipo_moneda_28, 
  b.monto_15_2 as subtotal, 
  b.sumatoria_igv_18_1 as igv, 
  b.importe_total_23 as total, 
  b.tipo_documento_06 as tipocomp, 
  b.numeracion_07 as numerodoc, 
  b.estado,
  b.tdescuento,
  fecha_emision_01,
  b.codigo_tributo_18_3 as codigotrib,
  b.nombre_tributo_18_4  as nombretrib,
  b.codigo_internacional_18_5 as codigointtrib,
  b.idboleta
from 
boleta b 
inner join persona p on b.idcliente=p.idpersona inner join empresa e on b.idempresa=e.idempresa where year(fecha_emision_01)='$ano' and month(fecha_emision_01)='$mes' and day(fecha_emision_01)='$dia' and b.estado='$estado' and e.idempresa='$idempresa') as tbventa order by numerodoc"; 

$queryBoletaServicio = "select 
date_format(fecha_emision_01, '%Y-%m-%d') as fecha, 
right(substring_index(numerodoc,'-',1),1) as serie, 
hora,
tipodocuCliente, 
rucCliente as numero_documento, 
RazonSocial as razon_social, 
tipo_moneda_28, 
subtotal, 
igv, 
 total, 
 tipocomp, 
numerodoc, 
tdescuento, 
estado,
codigotrib,
nombretrib,
codigointtrib,
idboleta
  from 
  ( 
  select 
  date_format(b.fecha_emision_01, '%Y-%m-%d') as fecha, 
  right(substring_index(b.numeracion_07,'-',1),1) as serie, 
  date_format(b.fecha_emision_01, '%H:%i:%s') as hora,
  p.tipo_documento as tipodocuCliente, 
  p.numero_documento as rucCliente, 
  p.razon_social as RazonSocial, 
  b.tipo_moneda_24 as tipo_moneda_28, 
  b.monto_15_2 as subtotal, 
  b.sumatoria_igv_18_1 as igv, 
  b.importe_total_23 as total, 
  b.tipo_documento_06 as tipocomp, 
  b.numeracion_07 as numerodoc, 
  b.estado,
  b.tdescuento,
  fecha_emision_01,
  b.codigo_tributo_18_3 as codigotrib,
  b.nombre_tributo_18_4  as nombretrib,
  b.codigo_internacional_18_5 as codigointtrib,
  b.idboleta
from 
boletaservicio b 
inner join persona p on b.idcliente=p.idpersona inner join empresa e on b.idempresa=e.idempresa where year(fecha_emision_01)='$ano' and month(fecha_emision_01)='$mes' and day(fecha_emision_01)='$dia' and b.estado='$estado' and e.idempresa='$idempresa') as tbventa order by numerodoc";  

// &&&&&&&&&&&&&&&&&&& DETALLES  &&&&&&&&&&&&&&&&&&&&&&&&&&&&&&& 

$querynotacd = "select 
n.codigo_nota, 
n.numeroserienota, 
date_format(n.fecha,'%Y-%m-%d') as fecha, 
date_format(n.fecha, '%H:%i:%s') as hora,
n.codtiponota, 
c.descripcion, 
n.tipo_doc_mod, 
n.serie_numero, 
n.tipo_doc_ide, 
n.numero_doc_ide, 
n.razon_social, 
n.tipo_moneda, 
n.sum_ot, 
n.total_val_venta_og, 
n.total_val_venta_oi, 
n.total_val_venta_oe, 
n.sum_igv, n.sum_isc, 
n.sum_ot, 
n.importe_total as total,
n.adicional,
n.idnota
from 
notacd n inner join catalogo9 c on n.codtiponota=c.codigo inner join empresa e on n.idempresa=e.idempresa  where year(n.fecha)='$ano' and month(n.fecha)='$mes' and day(n.fecha)='$dia' and n.estado='$estado' and e.idempresa='$idempresa' ";

      //==================================================
      $result = mysqli_query($connect, $queryFactura);  //&&
      $resultboleta = mysqli_query($connect, $queryBoleta);  //&&
      $resultfservicio = mysqli_query($connect, $queryFacturaServicio);  //&&
      $resultboletaServicio = mysqli_query($connect, $queryBoletaServicio);  //&&

      $resultnc = mysqli_query($connect, $querynotacd);  

      //==================================================


//Boorar contenido de la carpeta descargas
 $mask = $rutadescargas."*";
 array_map( "unlink", glob( $mask ) );


if ($comprobante=='01') {
//==================FACTURA ================================
      $fecha=array();
      $serie=array();
      $tipodocu=array();
      $numdocu=array();
      $rasoc=array();
      $moneda=array();
      $subtotal=array();
      $igv=array();
      $total=array();
      $tdescu=array();
      $codigotrib=array();
      $nombretrib=array();
      $codigointtrib=array();
      $idfactura=array();
      
      $con=0;
            
      while($row=mysqli_fetch_assoc($result)){
      for($i=0; $i <= count($result); $i++){
          $fecha[$i]=$row["fecha"];
           $serie[$i]=$row["serie"];
           $tipodocu[$i]=$row["tipodocuCliente"];
           $numdocu[$i]=$row["numero_documento"];
           $rasoc[$i]=$row["razon_social"];
           $moneda[$i]=$row["tipo_moneda_28"];
           $subtotal[$i]=$row["subtotal"];
           $igv[$i]=$row["igv"];
           $total[$i]=$row["total"];
           $tdescu[$i]=$row["tdescuento"];
           $hora=$row["hora"];
           $tipocomp=$row["tipocomp"];
           $numerodoc=$row["numerodoc"];
           $ruc=$datose->numero_ruc;
           $ubigueo=$datose->ubigueo;

           $codigotrib[$i]=$row["codigotrib"];
           $nombretrib[$i]=$row["nombretrib"];
           $codigointtrib[$i]=$row["codigointtrib"];
           $idfactura[$i]=$row["idfactura"];
          
       require_once "Letras.php";
       $V=new EnLetras(); 
       $con_letra=strtoupper($V->ValorEnLetras($total[$i],"NUEVOS SOLES"));

      //FORMATO JSON
  $json = array('cabecera' => array('tipOperacion'=>'0101', 'fecEmision'=>$fecha[$i], 'horEmision'=>$hora, 'fecVencimiento'=>"-", 'codLocalEmisor'=>$ubigueo, 'tipDocUsuario'=>$tipodocu[$i], 'numDocUsuario'=>$numdocu[$i], 'rznSocialUsuario'=>$rasoc[$i], 'tipMoneda'=>$moneda[$i], 'sumTotTributos'=>number_format($igv[$i],2,'.',''), 'sumTotValVenta'=>number_format($subtotal[$i],2,'.',''), 'sumPrecioVenta'=>number_format($total[$i],2,'.',''), 'sumDescTotal'=>number_format($tdescu[$i],2,'.',''), 'sumOtrosCargos'=>"0.00", 'sumTotalAnticipos'=>"0.00", 'sumImpVenta'=>number_format($total[$i],2,'.',''), 'ublVersionId'=>"2.1", 'customizationId'=>"2.0"), 'detalle' => array(), 'leyendas' => array(), 'tributos' => array());

         //Leyenda JSON
  $json['leyendas'][] = array('codLeyenda'=>"1000",'desLeyenda'=>$con_letra);
  $json['tributos'][] = array('ideTributo'=>$codigotrib[$i], 'nomTributo'=>$nombretrib[$i], 'codTipTributo'=>$codigointtrib[$i], 'mtoBaseImponible'=>number_format($subtotal[$i],2,'.',''), 'mtoTributo'=>number_format($igv[$i],2,'.',''));

      $path=$rutadescargas.$ruc."-".$tipocomp."-".$numerodoc.".json";
      $jsonencoded = json_encode($json,JSON_UNESCAPED_UNICODE);
      $fh = fopen($path, 'w');
      fwrite($fh, $jsonencoded);
      fclose($fh);



$querydetfac = "select 
f.tipo_documento_07 as tipocomp, 
f.numeracion_08 as numerodoc,  
df.cantidad_item_12 as cantidad, 
a.codigo, 
a.nombre as descripcion, 
a.unidad_medida as um,
df.valor_uni_item_14 as vui, 
df.igv_item as igvi, 
df.precio_venta_item_15_2 as pvi, 
df.valor_venta_item_21 as vvi ,
 df.afectacion_igv_item_16_1 as sutribitem,

       df.afectacion_igv_item_16_3 as aigv,
       df.afectacion_igv_item_16_4 codtrib,
       df.afectacion_igv_item_16_5 as nomtrib,
       df.afectacion_igv_item_16_6 as coditrib,
        a.codigosunat
from 
factura f inner join detalle_fac_art df on f.idfactura=df.idfactura inner join articulo a on df.idarticulo=a.idarticulo inner join empresa e on f.idempresa=e.idempresa where year(f.fecha_emision_01)='$ano' and month(f.fecha_emision_01)='$mes' and day(f.fecha_emision_01)='$dia' and f.estado='$estado' and e.idempresa='$idempresa' and f.idfactura='$idfactura[$i]'  order by f.fecha_emision_01"; 

$resultf = mysqli_query($connect, $querydetfac);  //&& FACTURA 

//==================== DETALLE FACTURA ======================
      $codigo=array();
      $cantidad=array();
      $descripcion=array();
      $vui=array();
      $igvi=array();
      $pvi=array();
      $vvi=array();
      $um=array();

      $sutribitem=array();

      $aigv=array();
      $codtrib=array();
      $nomtrib=array();
      $coditrib=array();
      $codigosunat=array();
      $conf=0;
      while($rowf=mysqli_fetch_assoc($resultf)){
      for($if=0; $if < count($resultf); $if++){
           $codigo[$if]=$rowf["codigo"];
           $cantidad[$if]=$rowf["cantidad"];
           $descripcion[$if]=$rowf["descripcion"];
           $vui[$if]=$rowf["vui"];
           $igvi[$if]=$rowf["igvi"];
           $pvi[$if]=$rowf["pvi"];
           $vvi[$if]=$rowf["vvi"];
           $um[$if]=$rowf["um"];
           $tipocompf=$rowf["tipocomp"];
           $numerodocf=$rowf["numerodoc"];
           $ruc=$datose->numero_ruc;
           $sutribitem[$if]=$rowf["sutribitem"];           

           $aigv[$if]=$rowf["aigv"];
           $codtrib[$if]=$rowf["codtrib"];
           $nomtrib[$if]=$rowf["nomtrib"];
           $coditrib[$if]=$rowf["coditrib"];
           $codigosunat[$if]=$rowf["codigosunat"];

//FORMATO JSON
    $json['detalle'][] = array('codUnidadMedida'=>$um[$if], 'ctdUnidadItem'=>number_format($cantidad[$if],2,'.',''), 'codProducto'=>$codigo[$if], 'codProductoSUNAT'=>$codigosunat[$if], 'desItem'=>$descripcion[$if], 'mtoValorUnitario'=>number_format($vui[$if],5,'.',''), 'sumTotTributosItem'=>number_format($sutribitem[$if],2,'.',''), 'codTriIGV'=>$codtrib[$if], 'mtoIgvItem'=>number_format($sutribitem[$if],2,'.',''), 'mtoBaseIgvItem'=>number_format($vvi[$if],2,'.',''), 'nomTributoIgvItem'=>$nomtrib[$if], 'codTipTributoIgvItem'=>$coditrib[$if], 'tipAfeIGV'=>$aigv[$if], 'porIgvItem'=>"18.0", 'codTriISC'=>"-", 'mtoIscItem'=>"", 'mtoBaseIscItem'=>"", 'nomTributoIscItem'=>"", 'codTipTributoIscItem'=>"", 'tipSisISC'=>"", 'porIscItem'=>"", 'codTriOtroItem'=>"-", 'mtoTriOtroItem'=>"", 'mtoBaseTriOtroItem'=>"", 'nomTributoIOtroItem'=>"", 'codTipTributoIOtroItem'=>"", 'porTriOtroItem'=>"", 'mtoPrecioVentaUnitario'=>number_format($pvi[$if],2,'.',''), 'mtoValorVentaItem'=>number_format($vvi[$if],2,'.',''), 'mtoValorReferencialUnitario'=>"0");


          } //fin for
      } //fin while

      $path=$rutadescargas.$ruc."-".$tipocomp."-".$numerodoc.".json";
      $jsonencoded = json_encode($json,JSON_UNESCAPED_UNICODE);
      $fh = fopen($path, 'w');
      fwrite($fh, $jsonencoded);
      fclose($fh);
//==================================================




      }
     }


}elseif ($comprobante=='03') {

//================== BOLETA ================================
      $fecha=array();
      $serie=array();
      $tipodocu=array();
      $numdocu=array();
      $rasoc=array();
      $moneda=array();
      $subtotal=array();
      $igv=array();
      $total=array();
      $tdescu=array();
      $codigotrib=array();
      $nombretrib=array();
      $codigointtrib=array();
      $idboleta=array();
      
      $con=0;
            
      while($row=mysqli_fetch_assoc($resultboleta)){
      for($i=0; $i <= count($result); $i++){
          $fecha[$i]=$row["fecha"];
           $serie[$i]=$row["serie"];
           $tipodocu[$i]=$row["tipodocuCliente"];
           $numdocu[$i]=$row["numero_documento"];
           $rasoc[$i]=$row["razon_social"];
           $moneda[$i]=$row["tipo_moneda_28"];
           $subtotal[$i]=$row["subtotal"];
           $igv[$i]=$row["igv"];
           $total[$i]=$row["total"];
           $tdescu[$i]=$row["tdescuento"];
           $hora=$row["hora"];
           $tipocomp=$row["tipocomp"];
           $numerodoc=$row["numerodoc"];
           $ruc=$datose->numero_ruc;
           $ubigueo=$datose->ubigueo;

           $codigotrib[$i]=$row["codigotrib"];
           $nombretrib[$i]=$row["nombretrib"];
           $codigointtrib[$i]=$row["codigointtrib"];
           $idboleta[$i]=$row["idboleta"];
          
       require_once "Letras.php";
       $V=new EnLetras(); 
       $con_letra=strtoupper($V->ValorEnLetras($total[$i],"NUEVOS SOLES"));

      //FORMATO JSON
  $json = array('cabecera' => array('tipOperacion'=>'0101', 'fecEmision'=>$fecha[$i], 'horEmision'=>$hora, 'fecVencimiento'=>"-", 'codLocalEmisor'=>$ubigueo, 'tipDocUsuario'=>$tipodocu[$i], 'numDocUsuario'=>$numdocu[$i], 'rznSocialUsuario'=>$rasoc[$i], 'tipMoneda'=>$moneda[$i], 'sumTotTributos'=>number_format($igv[$i],2,'.',''), 'sumTotValVenta'=>number_format($subtotal[$i],2,'.',''), 'sumPrecioVenta'=>number_format($total[$i],2,'.',''), 'sumDescTotal'=>number_format($tdescu[$i],2,'.',''), 'sumOtrosCargos'=>"0.00", 'sumTotalAnticipos'=>"0.00", 'sumImpVenta'=>number_format($total[$i],2,'.',''), 'ublVersionId'=>"2.1", 'customizationId'=>"2.0"), 'detalle' => array(), 'leyendas' => array(), 'tributos' => array());

         //Leyenda JSON
  $json['leyendas'][] = array('codLeyenda'=>"1000",'desLeyenda'=>$con_letra);
  $json['tributos'][] = array('ideTributo'=>$codigotrib[$i], 'nomTributo'=>$nombretrib[$i], 'codTipTributo'=>$codigointtrib[$i], 'mtoBaseImponible'=>number_format($subtotal[$i],2,'.',''), 'mtoTributo'=>number_format($igv[$i],2,'.',''));

      $path=$rutadescargas.$ruc."-".$tipocomp."-".$numerodoc.".json";
      $jsonencoded = json_encode($json,JSON_UNESCAPED_UNICODE);
      $fh = fopen($path, 'w');
      fwrite($fh, $jsonencoded);
      fclose($fh);

      $querydetbol = "
select 
b.tipo_documento_06 as tipocomp , 
b.numeracion_07 as numerodoc,  
db.cantidad_item_12 as cantidad, 
a.codigo, 
a.nombre as descripcion, 
a.unidad_medida as um,
db.valor_uni_item_31 as vui, 
db.afectacion_igv_item_monto_27_1 as igvi, 
db.precio_uni_item_14_2 as pvi, 
db.valor_venta_item_32 as vvi ,
db.afectacion_igv_item_monto_27_1 as sutribitem,

      db.afectacion_igv_3 as aigv,
       db.afectacion_igv_4 codtrib,
       db.afectacion_igv_5 as nomtrib,
       db.afectacion_igv_6 as coditrib,
       a.codigosunat
from 
boleta b inner join detalle_boleta_producto db on b.idboleta=db.idboleta inner join articulo a on db.idarticulo=a.idarticulo inner join empresa e on b.idempresa=e.idempresa
where 
year(b.fecha_emision_01)='$ano' and month(b.fecha_emision_01)='$mes' and day(b.fecha_emision_01)='$dia' and b.estado='$estado' and e.idempresa='$idempresa' and b.idboleta='$idboleta[$i]' order by b.fecha_emision_01"; 

$resultb = mysqli_query($connect, $querydetbol);  


//================DETALLE BOLETA==================================
      $codigo=array();
      $cantidad=array();
      $descripcion=array();
      $vui=array();
      $igvi=array();
      $pvi=array();
      $vvi=array();
      $um=array();

      $sutribitem=array();

      $aigv=array();
      $codtrib=array();
      $nomtrib=array();
      $coditrib=array();
      $codigosunat=array();

      
      $con=0;
      while($rowb=mysqli_fetch_assoc($resultb)){
      for($if=0; $if < count($resultb); $if++){
           $codigo[$if]=$rowb["codigo"];
           $cantidad[$if]=$rowb["cantidad"];
           $descripcion[$if]=$rowb["descripcion"];
           $vui[$if]=$rowb["vui"];
           $igvi[$if]=$rowb["igvi"];
           $pvi[$if]=$rowb["pvi"];
           $vvi[$if]=$rowb["vvi"];
           $tipocompb=$rowb["tipocomp"];
           $um=$rowb["um"];
           $numerodocb=$rowb["numerodoc"];
           $ruc=$datose->numero_ruc;

           $aigv[$if]=$rowb["aigv"];
           $codtrib[$if]=$rowb["codtrib"];
           $nomtrib[$if]=$rowb["nomtrib"];
           $coditrib[$if]=$rowb["coditrib"];
           $codigosunat[$if]=$rowb["codigosunat"];
           //FORMATO JSON
    $json['detalle'][] = array('codUnidadMedida'=>$um[$if], 'ctdUnidadItem'=>number_format($cantidad[$if],2,'.',''), 'codProducto'=>$codigo[$if], 'codProductoSUNAT'=>"-", 'desItem'=>$descripcion[$if], 'mtoValorUnitario'=>number_format($vui[$if],5,'.',''), 'sumTotTributosItem'=>number_format($igvi[$if],2,'.',''), 'codTriIGV'=>"1000", 'mtoIgvItem'=>number_format($igvi[$if],2,'.',''), 'mtoBaseIgvItem'=>number_format($vvi[$if],2,'.',''), 'nomTributoIgvItem'=>"IGV", 'codTipTributoIgvItem'=>"VAT", 'tipAfeIGV'=>"10", 'porIgvItem'=>"18.0", 'codTriISC'=>"-", 'mtoIscItem'=>"", 'mtoBaseIscItem'=>"", 'nomTributoIscItem'=>"", 'codTipTributoIscItem'=>"", 'tipSisISC'=>"", 'porIscItem'=>"", 'codTriOtroItem'=>"-", 'mtoTriOtroItem'=>"", 'mtoBaseTriOtroItem'=>"", 'nomTributoIOtroItem'=>"", 'codTipTributoIOtroItem'=>"", 'porTriOtroItem'=>"", 'mtoPrecioVentaUnitario'=>number_format($pvi[$if],2,'.',''), 'mtoValorVentaItem'=>number_format($vvi[$if],2,'.',''), 'mtoValorReferencialUnitario'=>"0");
         
      }
     }

      $path=$rutadescargas.$ruc."-".$tipocomp."-".$numerodoc.".json";
      $jsonencoded = json_encode($json,JSON_UNESCAPED_UNICODE);
      $fh = fopen($path, 'w');
      fwrite($fh, $jsonencoded);
      fclose($fh);

      }
      }



}elseif ($comprobante=='04') {
  
//================== FACTURA SERVICIO ================================
      $fecha=array();
      $serie=array();
      $tipodocu=array();
      $numdocu=array();
      $rasoc=array();
      $moneda=array();
      $subtotal=array();
      $igv=array();
      $total=array();
      $tdescu=array();
      $codigotrib=array();
      $nombretrib=array();
      $codigointtrib=array();
      $idfactura=array();
      
      $con=0;
            
      while($row=mysqli_fetch_assoc($resultfservicio)){
      for($i=0; $i <= count($resultfservicio); $i++){
          $fecha[$i]=$row["fecha"];
           $serie[$i]=$row["serie"];
           $tipodocu[$i]=$row["tipodocuCliente"];
           $numdocu[$i]=$row["numero_documento"];
           $rasoc[$i]=$row["razon_social"];
           $moneda[$i]=$row["tipo_moneda_28"];
           $subtotal[$i]=$row["subtotal"];
           $igv[$i]=$row["igv"];
           $total[$i]=$row["total"];
           $tdescu[$i]=$row["tdescuento"];
           $hora=$row["hora"];
           $tipocomp=$row["tipocomp"];
           $numerodoc=$row["numerodoc"];
           $ruc=$datose->numero_ruc;
           $ubigueo=$datose->ubigueo;

           $codigotrib[$i]=$row["codigotrib"];
           $nombretrib[$i]=$row["nombretrib"];
           $codigointtrib[$i]=$row["codigointtrib"];
           $idfactura[$i]=$row["idfactura"];
          
       require_once "Letras.php";
       $V=new EnLetras(); 
       $con_letra=strtoupper($V->ValorEnLetras($total[$i],"NUEVOS SOLES"));

      //FORMATO JSON
  $json = array('cabecera' => array('tipOperacion'=>'0101', 'fecEmision'=>$fecha[$i], 'horEmision'=>$hora, 'fecVencimiento'=>"-", 'codLocalEmisor'=>$ubigueo, 'tipDocUsuario'=>$tipodocu[$i], 'numDocUsuario'=>$numdocu[$i], 'rznSocialUsuario'=>$rasoc[$i], 'tipMoneda'=>$moneda[$i], 'sumTotTributos'=>number_format($igv[$i],2,'.',''), 'sumTotValVenta'=>number_format($subtotal[$i],2,'.',''), 'sumPrecioVenta'=>number_format($total[$i],2,'.',''), 'sumDescTotal'=>number_format($tdescu[$i],2,'.',''), 'sumOtrosCargos'=>"0.00", 'sumTotalAnticipos'=>"0.00", 'sumImpVenta'=>number_format($total[$i],2,'.',''), 'ublVersionId'=>"2.1", 'customizationId'=>"2.0"), 'detalle' => array(), 'leyendas' => array(), 'tributos' => array());

         //Leyenda JSON
  $json['leyendas'][] = array('codLeyenda'=>"1000",'desLeyenda'=>$con_letra);
  $json['tributos'][] = array('ideTributo'=>$codigotrib[$i], 'nomTributo'=>$nombretrib[$i], 'codTipTributo'=>$codigointtrib[$i], 'mtoBaseImponible'=>number_format($subtotal[$i],2,'.',''), 'mtoTributo'=>number_format($igv[$i],2,'.',''));

      $path=$rutadescargas.$ruc."-".$tipocomp."-".$numerodoc.".json";
      $jsonencoded = json_encode($json,JSON_UNESCAPED_UNICODE);
      $fh = fopen($path, 'w');
      fwrite($fh, $jsonencoded);
      fclose($fh);


      $querydetfacServicio = "select 
f.tipo_documento_07 as tipocomp, 
f.numeracion_08 as numerodoc,  
df.cantidad_item_12 as cantidad, 
a.codigo, 
a.descripcion, 
a.codigo as um,
df.valor_uni_item_14 as vui, 
df.igv_item as igvi, 
df.precio_venta_item_15_2 as pvi, 
df.valor_venta_item_21 as vvi ,
df.afectacion_igv_item_16_1 as sutribitem,

       df.afectacion_igv_item_16_3 as aigv,
       df.afectacion_igv_item_16_4 codtrib,
       df.afectacion_igv_item_16_5 as nomtrib,
       df.afectacion_igv_item_16_6 as coditrib
       from 
facturaservicio f inner join detalle_fac_art_ser df on f.idfactura=df.idfactura inner join servicios_inmuebles a on df.idarticulo=a.id inner join empresa e on f.idempresa=e.idempresa where year(f.fecha_emision_01)='$ano' and month(f.fecha_emision_01)='$mes' and day(f.fecha_emision_01)='$dia' and f.estado='$estado' and e.idempresa='$idempresa' and f.idfactura='$idfactura[$i]' order by f.fecha_emision_01"; 

$resultfdservicio = mysqli_query($connect, $querydetfacServicio);  //&& FACTURA SERVICIO

//==================== DETALLE FACTURA ======================
      $codigo=array();
      $cantidad=array();
      $descripcion=array();
      $vui=array();
      $igvi=array();
      $pvi=array();
      $vvi=array();
      $um=array();

      $sutribitem=array();

      $aigv=array();
      $codtrib=array();
      $nomtrib=array();
      $coditrib=array();
      $codigosunat=array();
      $conf=0;
      while($rowf=mysqli_fetch_assoc($resultfdservicio)){
      for($if=0; $if < count($resultfdservicio); $if++){
           $codigo[$if]=$rowf["codigo"];
           $cantidad[$if]=$rowf["cantidad"];
           $descripcion[$if]=$rowf["descripcion"];
           $vui[$if]=$rowf["vui"];
           $igvi[$if]=$rowf["igvi"];
           $pvi[$if]=$rowf["pvi"];
           $vvi[$if]=$rowf["vvi"];
           $um[$if]=$rowf["um"];
           $tipocompf=$rowf["tipocomp"];
           $numerodocf=$rowf["numerodoc"];
           $ruc=$datose->numero_ruc;
           $sutribitem[$if]=$rowf["sutribitem"];           

           $aigv[$if]=$rowf["aigv"];
           $codtrib[$if]=$rowf["codtrib"];
           $nomtrib[$if]=$rowf["nomtrib"];
           $coditrib[$if]=$rowf["coditrib"];
           //$codigosunat[$if]=$rowf["codigosunat"];

//FORMATO JSON
    $json['detalle'][] = array('codUnidadMedida'=>$um[$if], 'ctdUnidadItem'=>number_format($cantidad[$if],2,'.',''), 'codProducto'=>$codigo[$if], 'codProductoSUNAT'=>"", 'desItem'=>$descripcion[$if], 'mtoValorUnitario'=>number_format($vui[$if],5,'.',''), 'sumTotTributosItem'=>number_format($sutribitem[$if],2,'.',''), 'codTriIGV'=>$codtrib[$if], 'mtoIgvItem'=>number_format($sutribitem[$if],2,'.',''), 'mtoBaseIgvItem'=>number_format($vvi[$if],2,'.',''), 'nomTributoIgvItem'=>$nomtrib[$if], 'codTipTributoIgvItem'=>$coditrib[$if], 'tipAfeIGV'=>$aigv[$if], 'porIgvItem'=>"18.0", 'codTriISC'=>"-", 'mtoIscItem'=>"", 'mtoBaseIscItem'=>"", 'nomTributoIscItem'=>"", 'codTipTributoIscItem'=>"", 'tipSisISC'=>"", 'porIscItem'=>"", 'codTriOtroItem'=>"-", 'mtoTriOtroItem'=>"", 'mtoBaseTriOtroItem'=>"", 'nomTributoIOtroItem'=>"", 'codTipTributoIOtroItem'=>"", 'porTriOtroItem'=>"", 'mtoPrecioVentaUnitario'=>number_format($pvi[$if],2,'.',''), 'mtoValorVentaItem'=>number_format($vvi[$if],2,'.',''), 'mtoValorReferencialUnitario'=>"0");


          } //fin for
      } //fin while
       $path=$rutadescargas.$ruc."-".$tipocomp."-".$numerodoc.".json";
      $jsonencoded = json_encode($json,JSON_UNESCAPED_UNICODE);
      $fh = fopen($path, 'w');
      fwrite($fh, $jsonencoded);
      fclose($fh);
//==================================================




      }
      }



  }elseif ($comprobante=='05') {

    //================== BOLETA SERVICIO ================================
      $fecha=array();
      $serie=array();
      $tipodocu=array();
      $numdocu=array();
      $rasoc=array();
      $moneda=array();
      $subtotal=array();
      $igv=array();
      $total=array();
      $tdescu=array();
      $codigotrib=array();
      $nombretrib=array();
      $codigointtrib=array();
      $idboleta=array();
      
      $con=0;
            
      while($row=mysqli_fetch_assoc($resultboletaServicio)){
      for($i=0; $i <= count($resultboletaServicio); $i++){
          $fecha[$i]=$row["fecha"];
           $serie[$i]=$row["serie"];
           $tipodocu[$i]=$row["tipodocuCliente"];
           $numdocu[$i]=$row["numero_documento"];
           $rasoc[$i]=$row["razon_social"];
           $moneda[$i]=$row["tipo_moneda_28"];
           $subtotal[$i]=$row["subtotal"];
           $igv[$i]=$row["igv"];
           $total[$i]=$row["total"];
           $tdescu[$i]=$row["tdescuento"];
           $hora=$row["hora"];
           $tipocomp=$row["tipocomp"];
           $numerodoc=$row["numerodoc"];
           $ruc=$datose->numero_ruc;
           $ubigueo=$datose->ubigueo;

           $codigotrib[$i]=$row["codigotrib"];
           $nombretrib[$i]=$row["nombretrib"];
           $codigointtrib[$i]=$row["codigointtrib"];
           $idboleta[$i]=$row["idboleta"];
          
       require_once "Letras.php";
       $V=new EnLetras(); 
       $con_letra=strtoupper($V->ValorEnLetras($total[$i],"NUEVOS SOLES"));

      //FORMATO JSON
  $json = array('cabecera' => array('tipOperacion'=>'0101', 'fecEmision'=>$fecha[$i], 'horEmision'=>$hora, 'fecVencimiento'=>"-", 'codLocalEmisor'=>$ubigueo, 'tipDocUsuario'=>$tipodocu[$i], 'numDocUsuario'=>$numdocu[$i], 'rznSocialUsuario'=>$rasoc[$i], 'tipMoneda'=>$moneda[$i], 'sumTotTributos'=>number_format($igv[$i],2,'.',''), 'sumTotValVenta'=>number_format($subtotal[$i],2,'.',''), 'sumPrecioVenta'=>number_format($total[$i],2,'.',''), 'sumDescTotal'=>number_format($tdescu[$i],2,'.',''), 'sumOtrosCargos'=>"0.00", 'sumTotalAnticipos'=>"0.00", 'sumImpVenta'=>number_format($total[$i],2,'.',''), 'ublVersionId'=>"2.1", 'customizationId'=>"2.0"), 'detalle' => array(), 'leyendas' => array(), 'tributos' => array());

         //Leyenda JSON
  $json['leyendas'][] = array('codLeyenda'=>"1000",'desLeyenda'=>$con_letra);
  $json['tributos'][] = array('ideTributo'=>$codigotrib[$i], 'nomTributo'=>$nombretrib[$i], 'codTipTributo'=>$codigointtrib[$i], 'mtoBaseImponible'=>number_format($subtotal[$i],2,'.',''), 'mtoTributo'=>number_format($igv[$i],2,'.',''));

      $path=$rutadescargas.$ruc."-".$tipocomp."-".$numerodoc.".json";
      $jsonencoded = json_encode($json,JSON_UNESCAPED_UNICODE);
      $fh = fopen($path, 'w');
      fwrite($fh, $jsonencoded);
      fclose($fh);

$querydetbolServicio = "
select 
b.tipo_documento_06 as tipocomp , 
b.numeracion_07 as numerodoc,  
db.cantidad_item_12 as cantidad, 
a.codigo, 
a.descripcion, 
a.codigo as um,
db.valor_uni_item_31 as vui, 
db.afectacion_igv_item_monto_27_1 as igvi, 
db.precio_uni_item_14_2 as pvi, 
db.valor_venta_item_32 as vvi ,
db.afectacion_igv_item_monto_27_1 as sutribitem,

      db.afectacion_igv_3 as aigv,
       db.afectacion_igv_4 codtrib,
       db.afectacion_igv_5 as nomtrib,
       db.afectacion_igv_6 as coditrib
from 
boletaservicio b inner join detalle_boleta_producto_ser db on b.idboleta=db.idboleta inner join servicios_inmuebles a on db.idarticulo=a.id inner join empresa e on b.idempresa=e.idempresa
where 
year(b.fecha_emision_01)='$ano' and month(b.fecha_emision_01)='$mes' and day(b.fecha_emision_01)='$dia' and b.estado='$estado' and e.idempresa='$idempresa' and b.idboleta='$idboleta[$i]' order by b.fecha_emision_01"; 

$resultdbServicio = mysqli_query($connect, $querydetbolServicio);  //&&& BOLETA DE SERVICIO

//================DETALLE BOLETA==================================
      $codigo=array();
      $cantidad=array();
      $descripcion=array();
      $vui=array();
      $igvi=array();
      $pvi=array();
      $vvi=array();
      $um=array();

      $sutribitem=array();

      $aigv=array();
      $codtrib=array();
      $nomtrib=array();
      $coditrib=array();
      $codigosunat=array();

      
      $con=0;
      while($rowb=mysqli_fetch_assoc($resultdbServicio)){
      for($if=0; $if < count($resultdbServicio); $if++){
           $codigo[$if]=$rowb["codigo"];
           $cantidad[$if]=$rowb["cantidad"];
           $descripcion[$if]=$rowb["descripcion"];
           $vui[$if]=$rowb["vui"];
           $igvi[$if]=$rowb["igvi"];
           $pvi[$if]=$rowb["pvi"];
           $vvi[$if]=$rowb["vvi"];
           $tipocompb=$rowb["tipocomp"];
           $um=$rowb["um"];
           $numerodocb=$rowb["numerodoc"];
           $ruc=$datose->numero_ruc;

           $aigv[$if]=$rowb["aigv"];
           $codtrib[$if]=$rowb["codtrib"];
           $nomtrib[$if]=$rowb["nomtrib"];
           $coditrib[$if]=$rowb["coditrib"];
           //$codigosunat[$if]=$rowb["codigosunat"];
           //FORMATO JSON
    $json['detalle'][] = array('codUnidadMedida'=>$um[$if], 'ctdUnidadItem'=>number_format($cantidad[$if],2,'.',''), 'codProducto'=>$codigo[$if], 'codProductoSUNAT'=>"-", 'desItem'=>$descripcion[$if], 'mtoValorUnitario'=>number_format($vui[$if],5,'.',''), 'sumTotTributosItem'=>number_format($igvi[$if],2,'.',''), 'codTriIGV'=>"1000", 'mtoIgvItem'=>number_format($igvi[$if],2,'.',''), 'mtoBaseIgvItem'=>number_format($vvi[$if],2,'.',''), 'nomTributoIgvItem'=>"IGV", 'codTipTributoIgvItem'=>"VAT", 'tipAfeIGV'=>"10", 'porIgvItem'=>"18.0", 'codTriISC'=>"-", 'mtoIscItem'=>"", 'mtoBaseIscItem'=>"", 'nomTributoIscItem'=>"", 'codTipTributoIscItem'=>"", 'tipSisISC'=>"", 'porIscItem'=>"", 'codTriOtroItem'=>"-", 'mtoTriOtroItem'=>"", 'mtoBaseTriOtroItem'=>"", 'nomTributoIOtroItem'=>"", 'codTipTributoIOtroItem'=>"", 'porTriOtroItem'=>"", 'mtoPrecioVentaUnitario'=>number_format($pvi[$if],2,'.',''), 'mtoValorVentaItem'=>number_format($vvi[$if],2,'.',''), 'mtoValorReferencialUnitario'=>"0");
         
       }
     }

      $path=$rutadescargas.$ruc."-".$tipocomp."-".$numerodoc.".json";
      $jsonencoded = json_encode($json,JSON_UNESCAPED_UNICODE);
      $fh = fopen($path, 'w');
      fwrite($fh, $jsonencoded);
      fclose($fh);


      }
    }



  }elseif ($comprobante=='07'){

       
// //==================NOTA & CREDITO/DEBITO ================================

//CABECERA NOTA DE CREDITO Y DEBITO
      $fecha=array();
      $codtiponotanc=array();
      $descrip=array();
      $tipodocmodnc=array();
      $serienumeronc=array();
      $tdoccliente=array();
      $ndocucliente=array();
      $rsocialcliente=array();
      $tipomone=array();
      $sumot=array();
      $totvalvenog=array();
      $totvalvenoi=array();
      $totvalvenoe=array();
      $sumigv=array();
      $sumisc=array();
      $sumot=array();
      $imptotal=array();

      $codigo_nota="";
      $numeroserienota="";

      $idnota=array();

      $connc=0;
            
      while($rownc=mysqli_fetch_assoc($resultnc)){
      for($i=0; $i <= count($resultnc); $i++){
           $codigo_nota=$rownc["codigo_nota"];
           $numeroserienota=$rownc["numeroserienota"];

           $fecha[$i]=$rownc["fecha"];
           $codtiponotanc[$i]=$rownc["codtiponota"];
           $descrip[$i]=$rownc["descripcion"];
           $tipodocmodnc[$i]=$rownc["tipo_doc_mod"];
           $serienumeronc[$i]=$rownc["serie_numero"];
           $tdoccliente[$i]=$rownc["tipo_doc_ide"];
           $ndocucliente[$i]=$rownc["numero_doc_ide"];
           $rsocialcliente[$i]=$rownc["razon_social"];
           $tipomone[$i]=$rownc["tipo_moneda"];
           $sumot[$i]=$rownc["sum_ot"];
           $totvalvenog[$i]=$rownc["total_val_venta_og"];
           $totvalvenoi[$i]=$rownc["total_val_venta_oi"];
           $totvalvenoe[$i]=$rownc["total_val_venta_oe"];
           $sumigv[$i]=$rownc["sum_igv"];
           $sumisc[$i]=$rownc["sum_isc"];
           $sumot[$i]=$rownc["sum_ot"];
           $hora=$rownc["hora"];
           $adicional=$rownc["adicional"];
           $imptotal[$i]=$rownc["total"];
           $ruc=$datose->numero_ruc;

           $idnota[$i]=$rownc["idnota"];

        require_once "Letras.php";
       $V=new EnLetras(); 
       $con_letra=strtoupper($V->ValorEnLetras($imptotal[$i],"NUEVOS SOLES"));
        $json = array('cabecera' => array('tipOperacion'=>'0101', 'fecEmision'=>$fecha[$i], 'horEmision'=>$hora, 'codLocalEmisor'=>"0000", 'tipDocUsuario'=>$tdoccliente[$i], 'numDocUsuario'=>$ndocucliente[$i], 'rznSocialUsuario'=>$rsocialcliente[$i], 'tipMoneda'=>$tipomone[$i], 'codMotivo'=>$codtiponotanc[$i], 'desMotivo'=>$descrip[$i], 'tipDocAfectado'=>$tipodocmodnc[$i], 'numDocAfectado'=>$serienumeronc[$i], 'sumTotTributos'=>$sumigv[$i], 'sumTotValVenta'=>$totvalvenog[$i], 'sumPrecioVenta'=>$imptotal[$i],'sumDescTotal'=>'0.00' , 'sumOtrosCargos'=>'0.00','sumTotalAnticipos'=>'0.00', 'sumImpVenta'=>$imptotal[$i], 'ublVersionId'=>"2.1", 'customizationId'=>"2.0"), 'detalle' => array(), 'leyendas' => array(), 'tributos' => array());


      //Leyenda JSON
      $json['leyendas'][] = array('codLeyenda'=>"1000",'desLeyenda'=>$con_letra);
      $json['tributos'][] = array('ideTributo'=>"1000", 'nomTributo'=>"IGV", 'codTipTributo'=>"VAT", 'mtoBaseImponible'=>number_format($totvalvenog[$i],2,'.',''), 'mtoTributo'=>number_format($sumigv[$i],2,'.',''));
      //Leyenda JSON

      $path=$rutadescargas.$ruc."-".$codigo_nota."-".$numeroserienota.".json";
      $jsonencoded = json_encode($json,JSON_UNESCAPED_UNICODE);
      $fh = fopen($path, 'w');
      fwrite($fh, $jsonencoded);
      fclose($fh);

if ($tipodocmodnc[$i]=='01') {

  $querydetfacncd = 
"select 
tipocomp,  
numerodoc, 
cantidad, 
codigo, 
descripcion, 
vui, 
igvi, 
pvi, 
vvi, 
codigo_nota, 
numeroserienota, 
um, 
sum_igv   
from
(
select 
f.tipo_documento_07 as tipocomp,  
f.numeracion_08 as numerodoc, 
dncd.cantidad, 
a.codigo, 
a.nombre as descripcion, 
dncd.valor_unitario as vui, 
dncd.igv as igvi, 
dncd.precio_venta as pvi, 
dncd.valor_venta as vvi, 
ncd.codigo_nota, 
ncd.numeroserienota, 
a.unidad_medida as um, 
ncd.sum_igv
from   
factura f inner join  notacd ncd on f.idfactura=ncd.idcomprobante inner join detalle_notacd_art dncd on ncd.idnota=dncd.idnotacd  inner join articulo a on dncd.idarticulo=a.idarticulo inner join empresa e on f.idempresa=e.idempresa
where year(ncd.fecha)='$ano' and month(ncd.fecha)='$mes' and day(ncd.fecha)='$dia' and ncd.estado='$estado' and e.idempresa='$idempresa' and ncd.idnota='$idnota[$i]'
union all
select 
f.tipo_documento_07 as tipocomp,  
f.numeracion_08 as numerodoc, 
dncd.cantidad, 
a.codigo, 
a.descripcion, 
dncd.valor_unitario as vui, 
dncd.igv as igvi, 
dncd.precio_venta as pvi, 
dncd.valor_venta as vvi, 
ncd.codigo_nota, 
ncd.numeroserienota, 
a.codigo as um, 
ncd.sum_igv
from   
facturaservicio f inner join  notacd ncd on f.idfactura=ncd.idcomprobante inner join detalle_notacd_art dncd on ncd.idnota=dncd.idnotacd  inner join servicios_inmuebles a on dncd.idarticulo=a.id inner join empresa e on f.idempresa=e.idempresa
where year(ncd.fecha)='$ano' and month(ncd.fecha)='$mes' and day(ncd.fecha)='$dia' and ncd.estado='$estado' and e.idempresa='$idempresa' and ncd.idnota='$idnota[$i]'
) as tabla 
order by numeroserienota";

$resultdfnc = mysqli_query($connect, $querydetfacncd);  


//++++++++++++++++++++++++++++++++++++++++++++++
// DETALLES  DE NOTA DE CREDITO 

      //FACTURAS
      $codigo=array();
      $cantidad=array();
      $descripcion=array();
      $vui=array();
      $igvi=array();
      $pvi=array();
      $vvi=array();
      $sum_igv=array();
      $um=array();


      while($rowdfncd=mysqli_fetch_assoc($resultdfnc)){
      for($ifnc=0; $ifnc < count($resultdfnc); $ifnc++){
           $codigo[$ifnc]=$rowdfncd["codigo"];
           $cantidad[$ifnc]=$rowdfncd["cantidad"];
           $descripcion[$ifnc]=$rowdfncd["descripcion"];
           $vui[$ifnc]=$rowdfncd["vui"];
           $igvi[$ifnc]=$rowdfncd["igvi"];
           $pvi[$ifnc]=$rowdfncd["pvi"];
           $vvi[$ifnc]=$rowdfncd["vvi"];
           $um[$ifnc]=$rowdfncd["um"];
           $sum_igv[$ifnc]=$rowdfncd["sum_igv"];
           $ruc=$datose->numero_ruc;
           $tipocompf=$rowdfncd["codigo_nota"];
           $numerodocf=$rowdfncd["numeroserienota"];
           $ruc=$datose->numero_ruc;

           $json['detalle'][] = array('codUnidadMedida'=>$um[$ifnc], 'ctdUnidadItem'=>number_format($cantidad[$ifnc],2,'.',''), 'codProducto'=>$codigo[$ifnc], 'codProductoSUNAT'=>"-", 'desItem'=>$descripcion[$ifnc], 'mtoValorUnitario'=>number_format($vui[$ifnc],2,'.',''), 'sumTotTributosItem'=>number_format($igvi[$ifnc],2,'.',''), 'codTriIGV'=>"1000", 'mtoIgvItem'=>number_format($igvi[$ifnc],2,'.',''), 'mtoBaseIgvItem'=>number_format($vvi[$ifnc],2,'.',''), 'nomTributoIgvItem'=>"IGV", 'codTipTributoIgvItem'=>"VAT", 'tipAfeIGV'=>"10", 'porIgvItem'=>"18.0", 'codTriISC'=>"-", 'mtoIscItem'=>"", 'mtoBaseIscItem'=>"", 'nomTributoIscItem'=>"", 'codTipTributoIscItem'=>"", 'tipSisISC'=>"", 'porIscItem'=>"", 'codTriOtroItem'=>"-", 'mtoTriOtroItem'=>"", 'mtoBaseTriOtroItem'=>"", 'nomTributoIOtroItem'=>"", 'codTipTributoIOtroItem'=>"", 'porTriOtroItem'=>"", 'mtoPrecioVentaUnitario'=>number_format($pvi[$ifnc],2,'.',''), 'mtoValorVentaItem'=>number_format($vvi[$ifnc],2,'.',''), 'mtoValorReferencialUnitario'=>"0");
         
      }
      }

       $path=$rutadescargas.$ruc."-".$codigo_nota."-".$numeroserienota.".json";
      $jsonencoded = json_encode($json,JSON_UNESCAPED_UNICODE);
      $fh = fopen($path, 'w');
      fwrite($fh, $jsonencoded);
      fclose($fh);

    }else{ // SI ES DE BOLETA

      $querydetbolncd = 
"select 
tipocomp, 
numerodoc, 
cantidad, 
codigo, 
descripcion, 
vui, 
igvi, 
pvi, 
vvi, 
codigo_nota, 
numeroserienota, 
um, 
sum_igv  
from
(
select 
b.tipo_documento_06 as tipocomp, 
b.numeracion_07 as numerodoc, 
dncd.cantidad, 
a.codigo, 
a.nombre as descripcion, 
dncd.valor_unitario as vui, 
dncd.igv as igvi, 
dncd.precio_venta as pvi, 
dncd.valor_venta as vvi, 
ncd.codigo_nota, 
ncd.numeroserienota, 
a.unidad_medida as um, 
ncd.sum_igv  
from 
boleta b inner join notacd ncd on b.idboleta=ncd.idcomprobante inner join detalle_notacd_art dncd on ncd.idnota=dncd.idnotacd  inner join articulo a on dncd.idarticulo=a.idarticulo inner join empresa e on b.idempresa=e.idempresa
where year(ncd.fecha)='$ano' and month(ncd.fecha)='$mes' and day(ncd.fecha)='$dia' and ncd.estado='$estado' and e.idempresa='$idempresa' and ncd.idnota='$idnota[$i]'
union all 
select 
b.tipo_documento_06 as tipocomp, 
b.numeracion_07 as numerodoc, 
dncd.cantidad, 
a.codigo, 
a.descripcion,
dncd.valor_unitario as vui, 
dncd.igv as igvi, 
dncd.precio_venta as pvi, 
dncd.valor_venta as vvi, 
ncd.codigo_nota, 
ncd.numeroserienota, 
a.codigo as um, 
ncd.sum_igv  
from 
boletaservicio b inner join notacd ncd on b.idboleta=ncd.idcomprobante inner join detalle_notacd_art dncd on ncd.idnota=dncd.idnotacd  inner join servicios_inmuebles a on dncd.idarticulo=a.id inner join empresa e on b.idempresa=e.idempresa
where year(ncd.fecha)='$ano' and month(ncd.fecha)='$mes' and day(ncd.fecha)='$dia' and ncd.estado='$estado' and e.idempresa='$idempresa' and ncd.idnota='$idnota[$i]'
)
as tabla  order by numeroserienota"; 

$resultdbnc = mysqli_query($connect, $querydetbolncd);  

//---------------------------------------------------------------------
      //BOLETA
      $codigo=array();
      $cantidad=array();
      $descripcion=array();
      $vui=array();
      $igvi=array();
      $pvi=array();
      $vvi=array();
      $sum_igv=array();
      $um=array();

      
      while($rowdbncd=mysqli_fetch_assoc($resultdbnc)){
      for($i=0; $i < count($resultdbnc); $i++){
            $codigo[$i]=$rowdbncd["codigo"];
            $cantidad[$i]=$rowdbncd["cantidad"];
           $descripcion[$i]=$rowdbncd["descripcion"];
           $vui[$i]=$rowdbncd["vui"];
           $igvi[$i]=$rowdbncd["igvi"];
           $pvi[$i]=$rowdbncd["pvi"];
           $vvi[$i]=$rowdbncd["vvi"];
           $um[$i]=$rowdbncd["um"];
           $sum_igv[$i]=$rowdbncd["sum_igv"];
           $tipocompb=$rowdbncd["codigo_nota"];
           $numerodocb=$rowdbncd["numeroserienota"];
           $ruc=$datose->numero_ruc;

    $json['detalle'][] = array('codUnidadMedida'=>$um[$i], 'ctdUnidadItem'=>number_format($cantidad[$i],2,'.',''), 'codProducto'=>$codigo[$i], 'codProductoSUNAT'=>"-", 'desItem'=>$descripcion[$i], 'mtoValorUnitario'=>number_format($vui[$i],2,'.',''), 'sumTotTributosItem'=>number_format($igvi[$i],2,'.',''), 'codTriIGV'=>"1000", 'mtoIgvItem'=>number_format($igvi[$i],2,'.',''), 'mtoBaseIgvItem'=>number_format($vvi[$i],2,'.',''), 'nomTributoIgvItem'=>"IGV", 'codTipTributoIgvItem'=>"VAT", 'tipAfeIGV'=>"10", 'porIgvItem'=>"18.0", 'codTriISC'=>"-", 'mtoIscItem'=>"", 'mtoBaseIscItem'=>"", 'nomTributoIscItem'=>"", 'codTipTributoIscItem'=>"", 'tipSisISC'=>"", 'porIscItem'=>"", 'codTriOtroItem'=>"-", 'mtoTriOtroItem'=>"", 'mtoBaseTriOtroItem'=>"", 'nomTributoIOtroItem'=>"", 'codTipTributoIOtroItem'=>"", 'porTriOtroItem'=>"", 'mtoPrecioVentaUnitario'=>number_format($pvi[$i],2,'.',''), 'mtoValorVentaItem'=>number_format($vvi[$i],2,'.',''), 'mtoValorReferencialUnitario'=>"0");
         
      }
      }

      $path=$rutadescargas.$ruc."-".$codigo_nota."-".$numeroserienota.".json";
      $jsonencoded = json_encode($json,JSON_UNESCAPED_UNICODE);
      $fh = fopen($path, 'w');
      fwrite($fh, $jsonencoded);
      fclose($fh);


      }
      }

// //++++++++++++++++++++++++++++++++++++++++++++++
//      // detalle factura Nota de DEBITO
//       $codigo=array();
//       $cantidad=array();
//       $descripcion=array();
//       $vui=array();
//       $igvi=array();
//       $pvi=array();
//       $vvi=array();

//       while($rowdfncd=mysqli_fetch_assoc($resultdfnc)){
//       for($ifnc=0; $ifnc < count($resultdfnc); $ifnc++){
//            $codigo[$ifnc]=$rowdfncd["codigo"];
//            $cantidad[$ifnc]=$rowdfncd["cantidad"];
//            $descripcion[$ifnc]=$rowdfncd["descripcion"];
//            $vui[$ifnc]=$rowdfncd["vui"];
//            $igvi[$ifnc]=$rowdfncd["igvi"];
//            $pvi[$ifnc]=$rowdfncd["pvi"];
//            $vvi[$ifnc]=$rowdfncd["vvi"];
//            $um[$ifnc]=$rowdfncd["um"];
//            $tipocompf=$rowdfncd["codigo_nota"];
//            $numerodocf=$rowdfncd["numeroserienota"];
//            $ruc=$datose->numero_ruc;
//            $um[$ifnc]=$rowdbncd["um"];


//        $json['detalle'][] = array('codUnidadMedida'=>$um[$i], 'ctdUnidadItem'=>number_format($cantidad[$i],2,'.',''), 'codProducto'=>$codigo[$i], 'codProductoSUNAT'=>"-", 'desItem'=>$descripcion[$i], 'mtoValorUnitario'=>number_format($vui[$i],2,'.',''), 'sumTotTributosItem'=>number_format($igvi[$i],2,'.',''), 'codTriIGV'=>"1000", 'mtoIgvItem'=>number_format($igvi[$i],2,'.',''), 'mtoBaseIgvItem'=>number_format($vvi[$i],2,'.',''), 'nomTributoIgvItem'=>"IGV", 'codTipTributoIgvItem'=>"VAT", 'tipAfeIGV'=>"10", 'porIgvItem'=>"18.0", 'codTriISC'=>"-", 'mtoIscItem'=>"", 'mtoBaseIscItem'=>"", 'nomTributoIscItem'=>"", 'codTipTributoIscItem'=>"", 'tipSisISC'=>"", 'porIscItem'=>"", 'codTriOtroItem'=>"-", 'mtoTriOtroItem'=>"", 'mtoBaseTriOtroItem'=>"", 'nomTributoIOtroItem'=>"", 'codTipTributoIOtroItem'=>"", 'porTriOtroItem'=>"", 'mtoPrecioVentaUnitario'=>number_format($pvi[$i],2,'.',''), 'mtoValorVentaItem'=>number_format($vvi[$i],2,'.',''), 'mtoValorReferencialUnitario'=>"0");
//       }
//       }


//       $path=$rutadescargas.$ruc."-".$codigo_nota."-".$numeroserienota.".json";
//       $jsonencoded = json_encode($json,JSON_UNESCAPED_UNICODE);
//       $fh = fopen($path, 'w');
//       fwrite($fh, $jsonencoded);
//       fclose($fh);
// //++++++++++++++++++++++++++++++++++++++++++++++

// //---------------------------------------------------------------------
//       $codigo=array();
//       $cantidad=array();
//       $descripcion=array();
//       $vui=array();
//       $igvi=array();
//       $pvi=array();
//       $vvi=array();
      
//       while($rowdbncd=mysqli_fetch_assoc($resultdbnc)){
//       for($i=0; $i < count($resultdbnc); $i++){
//             $codigo[$i]=$rowdbncd["codigo"];
//             $cantidad[$i]=$rowdbncd["cantidad"];
//            $descripcion[$i]=$rowdbncd["descripcion"];
//            $vui[$i]=$rowdbncd["vui"];
//            $igvi[$i]=$rowdbncd["igvi"];
//            $pvi[$i]=$rowdbncd["pvi"];
//            $vvi[$i]=$rowdbncd["vvi"];
//            $um[$ifnc]=$rowdfncd["um"];
//            $tipocompb=$rowdbncd["codigo_nota"];
//            $numerodocb=$rowdbncd["numeroserienota"];
//            $ruc=$datose->numero_ruc;

        
//           $json['detalle'][] = array('codUnidadMedida'=>$um[$ifnc], 'ctdUnidadItem'=>number_format($cantidad[$ifnc],2,'.',''), 'codProducto'=>$codigo[$ifnc], 'codProductoSUNAT'=>"-", 'desItem'=>$descripcion[$ifnc], 'mtoValorUnitario'=>number_format($vui[$ifnc],2,'.',''), 'sumTotTributosItem'=>number_format($igvi[$ifnc],2,'.',''), 'codTriIGV'=>"1000", 'mtoIgvItem'=>number_format($igvi[$ifnc],2,'.',''), 'mtoBaseIgvItem'=>number_format($vvi[$ifnc],2,'.',''), 'nomTributoIgvItem'=>"IGV", 'codTipTributoIgvItem'=>"VAT", 'tipAfeIGV'=>"10", 'porIgvItem'=>"18.0", 'codTriISC'=>"-", 'mtoIscItem'=>"", 'mtoBaseIscItem'=>"", 'nomTributoIscItem'=>"", 'codTipTributoIscItem'=>"", 'tipSisISC'=>"", 'porIscItem'=>"", 'codTriOtroItem'=>"-", 'mtoTriOtroItem'=>"", 'mtoBaseTriOtroItem'=>"", 'nomTributoIOtroItem'=>"", 'codTipTributoIOtroItem'=>"", 'porTriOtroItem'=>"", 'mtoPrecioVentaUnitario'=>number_format($pvi[$ifnc],2,'.',''), 'mtoValorVentaItem'=>number_format($vvi[$ifnc],2,'.',''), 'mtoValorReferencialUnitario'=>"0");
        
//           }
//          }

//       $path=$rutadescargas.$ruc."-".$codigo_nota."-".$numeroserienota.".json";
//       $jsonencoded = json_encode($json,JSON_UNESCAPED_UNICODE);
//       $fh = fopen($path, 'w');
//       fwrite($fh, $jsonencoded);
//       fclose($fh);
//---------------------------------------------------------------------
//==================NOTA & CREDITO/DEBITO =============================

}

}
             echo "Proceso Finalizado!! los archivos planos se descargarón en la carpeta <p1>descargas</p1> <br/><br/>
                  <a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a>";



}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}
 
}
ob_end_flush();
?>


