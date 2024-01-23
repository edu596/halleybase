<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";


 
Class Boletaservicio
{
    //Implementamos nuestro constructor
    public function __construct()
    {
 
    }
 
    //Implementamos un método para insertar registros para boleta
    public function insertar($idusuario, $fecha_emision_01, $firma_digital_36, $idempresa, $tipo_documento_06, $numeracion_07, $idcl, $codigo_tipo_15_1, $monto_15_2, $sumatoria_igv_18_1, $sumatoria_igv_18_2,  $sumatoria_igv_18_3,  $sumatoria_igv_18_4, $sumatoria_igv_18_5, $importe_total_23, $codigo_leyenda_26_1, $descripcion_leyenda_26_2, $tipo_documento_25_1, $guia_remision_25,  $version_ubl_37, $version_estructura_38, $tipo_moneda_24, $tasa_igv,  $idarticulo, $numero_orden_item_29, $cantidad_item_12, $codigo_precio_14_1, $precio_unitario, $igvBD, $igvBD2, $afectacion_igv_3, $afectacion_igv_4, $afectacion_igv_5, $afectacion_igv_6, $igvBD3, $vvu, $subtotalBD, $codigo, $unidad_medida, $idserie, $SerieReal, $numero_boleta, $tipodocuCliente, $rucCliente, $RazonSocial, $hora, $descdet, $vendedorsitio, $tcambio, $totaldescu)

    {

       $st='1';
        if ($SerieReal=='0001' ||  $SerieReal=='0002') {
          $st='6';
        }
          
        $sql="insert into 
        boletaservicio (idusuario,
          fecha_emision_01, 
          firma_digital_36, 
          idempresa, 
          tipo_documento_06, 
          numeracion_07, 
          idcliente, 
          codigo_tipo_15_1, 
          monto_15_2, 
          sumatoria_igv_18_1, 
          sumatoria_igv_18_2, 
          codigo_tributo_18_3, 
          nombre_tributo_18_4, 
          codigo_internacional_18_5, 
          importe_total_23, 
          codigo_leyenda_26_1, 
          descripcion_leyenda_26_2, 
          tipo_documento_25_1, 
          guia_remision_25, 
          version_ubl_37, 
          version_estructura_38, 
          tipo_moneda_24, 
          tasa_igv, 
          estado, 
          tipodocuCliente, 
          rucCliente, 
          RazonSocial,
          tdescuento, 
          vendedorsitio,
          tcambio
        )

        values

        ('$idusuario',
        '$fecha_emision_01 $hora',
        '$firma_digital_36',
        '$idempresa',
        '03',
        '$SerieReal-$numero_boleta',
        '$idcl',
        '$codigo_tipo_15_1', 
        '$monto_15_2',
        '$sumatoria_igv_18_1',
        '$sumatoria_igv_18_2',
        '$sumatoria_igv_18_3',
        '$sumatoria_igv_18_4',
        '$sumatoria_igv_18_5',
        '$importe_total_23',
        '$codigo_leyenda_26_1', 
        '$descripcion_leyenda_26_2', 
        '',
        '$guia_remision_25',
        '$version_ubl_37',
        '$version_estructura_38',
        '$tipo_moneda_24',
        '$tasa_igv',
        '$st',
        '$tipodocuCliente',
        '$rucCliente',
        '$RazonSocial',
        '$totaldescu',
        '$vendedorsitio',
        '$tcambio'
      )";
        //return ejecutarConsulta($sql);
        $idBoletaNew=ejecutarConsulta_retornarID($sql);
 
        $num_elementos=0;
        $sw=true;

         while ($num_elementos < count($idarticulo))
        {
            //Guardar en Detalle
        $sql_detalle = "insert into 
        detalle_boleta_producto_ser(idboleta, 
          idarticulo, 
          numero_orden_item_29, 
          cantidad_item_12, 
          codigo_precio_14_1, 
          precio_uni_item_14_2, 
          afectacion_igv_item_monto_27_1, 
          afectacion_igv_item_monto_27_2, 
          afectacion_igv_3, 
          afectacion_igv_4, 
          afectacion_igv_5, 
          afectacion_igv_6, 
          igv_item, 
          valor_uni_item_31, 
          valor_venta_item_32, 
          dcto_item,
          descdet
          )

            values

            (
            '$idBoletaNew', 
            '$idarticulo[$num_elementos]',
            '$numero_orden_item_29[$num_elementos]',
            '$cantidad_item_12',
            '$codigo_precio_14_1',
            '$vvu[$num_elementos]',
            '$igvBD[$num_elementos]',
            '$igvBD2[$num_elementos]',
           '$afectacion_igv_3',
          '$afectacion_igv_4',
          '$afectacion_igv_5',
          '$afectacion_igv_6',
            '$igvBD3[$num_elementos]',
            '$precio_unitario[$num_elementos]',
            '$subtotalBD[$num_elementos]',
            '0',
            '$descdet[$num_elementos]'
            )";

        //Guardar en Kardex
           //  $sql_kardex="insert into 
           //  kardex 
           //  (idcomprobante, 
           //    idarticulo, 
           //    transaccion, 
           //    codigo, 
           //    fecha, 
           //    tipo_documento, 
           //    numero_doc, 
           //    cantidad, 
           //    costo_1, 
           //    unidad_medida, 
           //    saldo_final, 
           //    costo_2,valor_final,
           //    idempresa) 

           //  values
           //  ('$idBoletaNew',
           //  '$idarticulo[$num_elementos]',
           //  'VENTA', 
           //  '$codigo[$num_elementos]', 
           //  '$fecha_emision_01', 
           //  '03' , 
           //  '$SerieReal-$numero_boleta', 
           //  '$cantidad_item_12', 
           //  '$precio_unitario[$num_elementos]',
           //  '$unidad_medida[$num_elementos]',

           //   (select saldo_finu - '$cantidad_item_12[$num_elementos]' from articulo where idarticulo='$idarticulo[$num_elementos]') ,
             
           //   (select precio_final_kardex from articulo where idarticulo='$idarticulo[$num_elementos]')

           //   , saldo_final * costo_2,
           //    '$idempresa')";
           // ejecutarConsulta($sql_kardex) or $sw = false;
           ejecutarConsulta($sql_detalle) or $sw = false;

            
            
    // SI EL NUMERO DE COMPROBANTE YA EXISTE NO HARA LA OPERACION
    if ($idBoletaNew==""){
    $sw=false;
    }
    else
    {

     // $sql_update_articulo="update
     //  articulo 
     //  set 
     //  saldo_finu=saldo_finu - '$cantidad_item_12[$num_elementos]', 
     //  ventast=ventast + '$cantidad_item_12[$num_elementos]', 
     //  valor_finu=(saldo_iniu+comprast-ventast) * costo_compra, 
     //  stock=saldo_finu, 
     //  valor_fin_kardex=(select valor_final 
     //    from 
     //    kardex
     //    where
     //    idarticulo='$idarticulo[$num_elementos]' and transaccion='VENTA' order by idkardex desc limit 1)  
     //    where 
     //    idarticulo='$idarticulo[$num_elementos]'";

     //    ejecutarConsulta($sql_update_articulo) or $sw = false;


         //Para actualizar numeracion de las series de la factura
         $sql_update_numeracion="update 
         numeracion 
         set 
         numero='$numero_boleta' where idnumeracion='$idserie'";
        ejecutarConsulta($sql_update_numeracion) or $sw = false;
         //Fin

    }
            $num_elementos=$num_elementos + 1;
        }

//=============== EXPORTAR COMPROBANTES A TXT ======================

  

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
    $datos = $factura->datosemp($idempresa);
    $datose = $datos->fetch_object();

     //Inclusion de la tabla RUTAS
    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($idempresa);
    $Prutas = $Rrutas->fetch_object();
    $rutadata=$Prutas->rutadata; // ruta de la carpeta DATA
    $rutadatalt=$Prutas->rutadatalt; // ruta de la carpeta DATA

  $query = "select 
  date_format(fecha_emision_01, '%Y-%m-%d') as fecha, 
  right(substring_index(numeracion_07,'-',1),4) as serie, 
  date_format(fecha_emision_01, '%H:%i:%s') as hora,
  p.tipo_documento, 
  p.numero_documento as rucCliente, 
  p.razon_social as RazonSocial, 
  tipo_moneda_24, 
  monto_15_2 as subtotal, 
  sumatoria_igv_18_1 as igv, 
  importe_total_23 as total, 
  tipo_documento_06 as tipocomp, 
  numeracion_07 as numerodoc, 
  b.estado,
  b.tdescuento ,
  b.codigo_tributo_18_3 as codigotrib,
  b.nombre_tributo_18_4  as nombretrib,
  b.codigo_internacional_18_5 as codigointtrib
  from
  boletaservicio b inner join persona p on b.idcliente=p.idpersona 
  where idboleta='$idBoletaNew' and b.estado='1'  order by numerodoc";  


  $querydetbol = "select
   b.tipo_documento_06 as tipocomp, 
   b.numeracion_07 as numerodoc, 
   db.cantidad_item_12 as cantidad, 
   si.codigo, 
   si.descripcion, 
   replace(format(db.valor_uni_item_31, 5),',','') as vui, 
   db.afectacion_igv_item_monto_27_1 as igvi, 
   db.precio_uni_item_14_2 as pvi,
   db.valor_venta_item_32 as vvi,

    db.afectacion_igv_item_monto_27_1 as sutribitem,

       db.afectacion_igv_3 as aigv,
       db.afectacion_igv_4 codtrib,
       db.afectacion_igv_5 as nomtrib,
       db.afectacion_igv_6 as coditrib
   from
   boletaservicio b inner join detalle_boleta_producto_ser db on b.idboleta=db.idboleta inner join servicios_inmuebles si on db.idarticulo=si.id where b.idboleta='$idBoletaNew' and b.estado='1' order by b.fecha_emision_01"; 


  $result = mysqli_query($connect, $query);  
  $resultb = mysqli_query($connect, $querydetbol);

      $fecha=array();
      $serie=array();
      $tipodocu=array();
      $numdocu=array();
      $rasoc=array();
      $moneda=array();
       $codigotrib=array();
      $nombretrib=array();
      $codigointtrib=array();
      $subtotal=array();
      $igv=array();
      $total=array();
      $tdescu=array();
      
      
      $con=0;
            
      while($row=mysqli_fetch_assoc($result)){
      for($i=0; $i <= count($result); $i++){
           $fecha[$i]=$row["fecha"];
           $serie[$i]=$row["serie"];
           $tipodocu[$i]=$row["tipo_documento"];
           $numdocu[$i]=$row["rucCliente"];
           $rasoc[$i]=$row["RazonSocial"];
           $moneda[$i]=$row["tipo_moneda_24"];
           $subtotal[$i]=$row["subtotal"];
           $igv[$i]=$row["igv"];
           $total[$i]=$row["total"];
           $tipocomp=$row["tipocomp"];
           $tdescu[$i]=$row["tdescuento"];
           $numerodoc=$row["numerodoc"];
           $hora=$row["hora"];
           $ruc=$datose->numero_ruc;
           $ubigueo=$datose->ubigueo;

          $codigotrib[$i]=$row["codigotrib"];
           $nombretrib[$i]=$row["nombretrib"];
           $codigointtrib[$i]=$row["codigointtrib"];


        

          require_once "Letras.php";
          $V=new EnLetras(); 
          $con_letra=strtoupper($V->ValorEnLetras($total[$i],"NUEVOS SOLES"));
          // $path=$rutadata.$ruc."-".$tipocomp."-".$numerodoc.".ley";
          // $handle=fopen($path, "w");
          // fwrite($handle,"1000|".$con_letra."|"); 
          // fclose($handle);

          // $path=$rutadata.$ruc."-".$tipocomp."-".$numerodoc.".tri";
          // $handle=fopen($path, "w");
          // fwrite($handle,"1000|IGV|VAT|".$subtotal[$i]."|".$igv[$i]."|"); 
          // //fwrite($handle,"1000|IGV|VAT|S|".$subtotal[$i]."|".$igv[$i]."|");  VERSION 1.1
          // fclose($handle);

          //  $path=$rutadatalt.$ruc."-".$tipocomp."-".$numerodoc.".cab";
          //  $handle=fopen($path, "w");
          //  fwrite($handle,"0101|".$fecha[$i]."|".$hora."|-|0000|".$tipodocu[$i]."|".$numdocu[$i]."|".$rasoc[$i]."|".$moneda[$i]."|".$igv[$i]."|".$subtotal[$i]."|".$total[$i]."|".$tdescu[$i]."|0|0|".$total[$i]."|2.1|2.0|"); 
          //  fclose($handle);


      //FORMATO JSON
      $json = array('cabecera' => array('tipOperacion'=>'0101', 'fecEmision'=>$fecha[$i], 'horEmision'=>$hora, 'fecVencimiento'=>"-", 'codLocalEmisor'=>$ubigueo, 'tipDocUsuario'=>$tipodocu[$i], 'numDocUsuario'=>$numdocu[$i], 'rznSocialUsuario'=>$rasoc[$i], 'tipMoneda'=>$moneda[$i], 'sumTotTributos'=>number_format($igv[$i],2,'.',''), 'sumTotValVenta'=>number_format($subtotal[$i],2,'.',''), 'sumPrecioVenta'=>number_format($total[$i],2,'.',''), 'sumDescTotal'=>number_format($tdescu[$i],2,'.',''), 'sumOtrosCargos'=>"0.00", 'sumTotalAnticipos'=>"0.00", 'sumImpVenta'=>number_format($total[$i],2,'.',''), 'ublVersionId'=>"2.1", 'customizationId'=>"2.0"), 'detalle' => array(), 'leyendas' => array(), 'tributos' => array());


      //Leyenda JSON
      $json['leyendas'][] = array('codLeyenda'=>"1000",'desLeyenda'=>$con_letra);
      $json['tributos'][] = array('ideTributo'=>$codigotrib[$i], 'nomTributo'=>$nombretrib[$i], 'codTipTributo'=>$codigointtrib[$i], 'mtoBaseImponible'=>number_format($subtotal[$i],2,'.',''), 'mtoTributo'=>number_format($igv[$i],2,'.',''));
      //Leyenda JSON
      }
           $i=$i+1;
           $con=$con+1;           
      }



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
      
      
      while($rowb=mysqli_fetch_assoc($resultb)){
      for($if=0; $if < count($resultb); $if++){
           $codigo[$if]=$rowb["codigo"];
           $cantidad[$if]=$rowb["cantidad"];
           $descripcion[$if]=$rowb["descripcion"];
           $vui[$if]=$rowb["vui"];
           $igvi[$if]=$rowb["igvi"];
           $pvi[$if]=$rowb["pvi"];
           $vvi[$if]=$rowb["vvi"];
           //$um[$if]=$rowb["um"];
           $tipocompb=$rowb["tipocomp"];
           $numerodocb=$rowb["numerodoc"];
           $ruc=$datose->numero_ruc;
           $sutribitem[$if]=$rowb["sutribitem"];           

           $aigv[$if]=$rowb["aigv"];
           $codtrib[$if]=$rowb["codtrib"];
           $nomtrib[$if]=$rowb["nomtrib"];
           $coditrib[$if]=$rowb["coditrib"];
          // $codigosunat[$if]=$rowb["codigosunat"];

        //  $pathb=$rutadata.$ruc."-".$tipocompb."-".$numerodocb.".det";
        //  $handleb=fopen($pathb, "a");
        // fwrite($handleb, $um[$if]."|".$cantidad[$if]."|".$codigo[$if]."|-|".$descripcion[$if]."|".$vui[$if]."|".$igvi[$if]."|1000|".$igvi[$if]."|".$vvi[$if]."|IGV|VAT|10|18|-|||||||-||||||".$pvi[$if]."|".$vvi[$if]."|0|\r\n"); 
        //    fclose($handleb);

        //    $pathb=$rutadatalt.$ruc."-".$tipocompb."-".$numerodocb.".det";
        //  $handleb=fopen($pathb, "a");
        // fwrite($handleb,$um[$if]."|".$cantidad[$if]."|".$codigo[$if]."|-|".$descripcion[$if]."|".$vui[$if]."|".$igvi[$if]."|1000|".$igvi[$if]."|".$vui[$if]."|IGV|VAT|10|18|-|||||||-||||||".$pvi[$if]."|".$vvi[$if]."|0|\r\n"); 
        //    fclose($handleb);

    //FORMATO JSON
    $json['detalle'][] = array('codUnidadMedida'=>'ZZZ', 'ctdUnidadItem'=>number_format($cantidad[$if],2,'.',''), 'codProducto'=>$codigo[$if], 'codProductoSUNAT'=>'-', 'desItem'=>$descripcion[$if], 'mtoValorUnitario'=>number_format($vui[$if],5,'.',''), 'sumTotTributosItem'=>number_format($sutribitem[$if],2,'.',''), 'codTriIGV'=>$codtrib[$if], 'mtoIgvItem'=>number_format($sutribitem[$if],2,'.',''), 'mtoBaseIgvItem'=>number_format($vvi[$if],2,'.',''), 'nomTributoIgvItem'=>$nomtrib[$if], 'codTipTributoIgvItem'=>$coditrib[$if], 'tipAfeIGV'=>$aigv[$if], 'porIgvItem'=>"18.0", 'codTriISC'=>"-", 'mtoIscItem'=>"", 'mtoBaseIscItem'=>"", 'nomTributoIscItem'=>"", 'codTipTributoIscItem'=>"", 'tipSisISC'=>"", 'porIscItem'=>"", 'codTriOtroItem'=>"-", 'mtoTriOtroItem'=>"", 'mtoBaseTriOtroItem'=>"", 'nomTributoIOtroItem'=>"", 'codTipTributoIOtroItem'=>"", 'porTriOtroItem'=>"", 'mtoPrecioVentaUnitario'=>number_format($pvi[$if],2,'.',''), 'mtoValorVentaItem'=>number_format($vvi[$if],2,'.',''), 'mtoValorReferencialUnitario'=>"0");

      }
      }

      $path=$rutadata.$ruc."-".$tipocomp."-".$numerodoc.".json";
      $jsonencoded = json_encode($json,JSON_UNESCAPED_UNICODE);
      $fh = fopen($path, 'w');
      fwrite($fh, $jsonencoded);
      fclose($fh);

      return $sw;
    }
//=============== EXPORTAR COMPROBANTES A TXT ========================
 

//Implementamos un método para anular la factura
public function anular($idboleta)
{
        $sqlestado="update 
        boleta 
        set 
        estado='0' 
        where 
        idboleta='$idboleta'";
  
         ejecutarConsulta($sqlestado) or $sw=false; 

   return $sw;    
}

public function baja($idboleta, $fecha_baja, $com, $hora)
{
   $sw=true;
        $sqlestado="update  boletaservicio  set  estado='3', 
        fecha_baja='$fecha_baja $hora', 
        comentario_baja='$com' 
        where 
        idboleta='$idboleta'";
        ejecutarConsulta($sqlestado) or $sw=false; 
   
  return $sw;  

}

 
    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($idboleta)
    {
        $sql="select 
        b.idboleta,
        date(b.fecha_emision_01) as fecha,
        b.idcliente,p.razon_social as cliente,
        p.numero_documento,
        p.domicilio_fiscal,
        u.idusuario,
        u.nombre as usuario,
        b.tipo_documento_06,
        b.numeracion_07, 
        b.importe_total_23, 
        b.estado 
        from 
        boletaservicio b inner join persona p on b.idcliente=p.idpersona inner join usuario u on b.idusuario=u.idusuario WHERE b.idboleta='$idboleta'";
        return ejecutarConsultaSimpleFila($sql);
    }
 

    //Implementar un método para listar los registros
    public function listar($idempresa)
    {
        $sql="select 
        b.idboleta,
        date_format(b.fecha_emision_01,'%d/%m/%y') as fecha,
        b.idcliente,
        left(p.razon_social,20) as cliente,
        b.vendedorsitio,
        u.nombre as usuario,
        b.tipo_documento_06 as tipo_documento,
        b.numeracion_07 as numeracion,
        format(b.importe_total_23,2) as importe_total_23, 
        b.estado, 
        p.nombres, 
        p.apellidos,
        e.numero_ruc,
        p.email
        from 
        boletaservicio b inner join persona p on b.idcliente=p.idpersona 
        inner join usuario u on b.idusuario=u.idusuario 
        inner join empresa e on b.idempresa=e.idempresa where
        e.idempresa='$idempresa'
        order by b.idboleta desc";
        return ejecutarConsulta($sql);      
    }

    //Implementar un método para listar los registros
    public function listarValidar($ano, $mes, $dia, $idempresa)
    {
        $sql="select 
        b.idboleta,
        date_format(b.fecha_emision_01,'%d/%m/%y') as fecha,
        b.idcliente,
        left(p.razon_social,20) as cliente,
        b.vendedorsitio,
        u.nombre as usuario,
        b.tipo_documento_06,
        b.numeracion_07,
        format(b.importe_total_23,2) as importe_total_23, 
        b.estado, 
        p.nombres, 
        p.apellidos,
        e.numero_ruc,
        p.email
        from 
        boletaservicio b inner join persona p on b.idcliente=p.idpersona 
        inner join usuario u on b.idusuario=u.idusuario 
        inner join empresa e on b.idempresa=e.idempresa where
        year(fecha_emision_01)='$ano' and month(fecha_emision_01)='$mes' and day(fecha_emision_01)='$dia' and e.idempresa='$idempresa'
        order by b.idboleta desc";
        return ejecutarConsulta($sql);      
    }


    public function ventacabecera($idboleta, $idempresa){
        $sql="select 
        b.idboleta, 
        b.idcliente, 
        p.razon_social, 
        p.nombres as cliente, 
        p.domicilio_fiscal as direccion, 
        p.tipo_documento,
        p.numero_documento, 
        p.email, 
        p.telefono1, 
        b.idusuario, 
        u.nombre as usuario, 
        b.tipo_documento_06, 
        b.numeracion_07,
        right(substring_index(b.numeracion_07,'-',1),4) as serie, 
        b.numeracion_07 as numerofac,  
        date_format(b.fecha_emision_01,'%d-%m-%Y') as fecha, 
        date_format(b.fecha_emision_01,'%Y-%m-%d') as fecha2, 
        date_format(b.fecha_emision_01, '%H:%i:%s') as hora, 
        b.importe_total_23 as totalLetras, 
        b.importe_total_23 as Itotal, 
        b.estado,
        e.numero_ruc,
        b.tdescuento,
        b.guia_remision_25 as guia,
        b.vendedorsitio,
        b.monto_15_2 as subtotal,
        b.sumatoria_igv_18_1 as igv,
        b.nombre_tributo_18_4 as nombretrib
        from 
        boletaservicio b inner join persona p on b.idcliente=p.idpersona inner join usuario u on 
        b.idusuario=u.idusuario inner join empresa e on b.idempresa=e.idempresa
         where b.idboleta='$idboleta' and e.idempresa='$idempresa'";
        return ejecutarConsulta($sql);
    }

    public function ventadetalle($idboleta){
        $sql="select  
        si.descripcion,
        si.codigo, 
        format(db.cantidad_item_12,2) as cantidad_item_12, 
        db.valor_uni_item_31, 
        db.precio_uni_item_14_2, 
        db.valor_venta_item_32, 
        format((db.cantidad_item_12 * db.precio_uni_item_14_2),2) as subtotal,
        db.dcto_item, 
        db.descdet,
        afectacion_igv_5 as nombretribu,
        db.precio_uni_item_14_2 as precio,
        format(db.valor_venta_item_32,2) as subtotal2,
        db.numero_orden_item_29 as norden
        from
        detalle_boleta_producto_ser db inner join servicios_inmuebles si on db.idarticulo=si.id where db.idboleta='$idboleta'";
        return ejecutarConsulta($sql);
    }

    public function listarDR($ano, $mes, $idempresa)
    {
        $sql="select 
        b.idboleta,
        b.idcliente,
        numeracion_07 as numeroboleta,
        date_format(b.fecha_emision_01,'%d/%m/%y') as fecha,
        date_format(b.fecha_baja,'%d/%m/%y') as fechabaja,
        left(p.razon_social,20) as cliente,
        p.numero_documento as ruccliente,
        b.monto_15_2 as opgravada,        
        b.sumatoria_igv_18_1 as igv,
        format(b.importe_total_23,2) as total,
        b.vendedorsitio,
        b.estado 
        from 
        boleta b inner join persona p on b.idcliente=p.idpersona 
        inner join usuario u on b.idusuario=u.idusuario 
        inner join empresa e on b.idempresa=e.idempresa where year(b.fecha_emision_01)='$ano' and month(b.fecha_emision_01)='$mes' and b.estado in ('0','3') and e.idempresa='$idempresa'
        order by idboleta desc";
        return ejecutarConsulta($sql);  
    }

        public function listarD()
    {
        $sql="select 
        documento 
        from 
        correlativo 
        where 
        documento='factura' or documento='boleta' or documento='nota de credito'or documento='nota de debito' group by documento";
        return ejecutarConsulta($sql);      
    }

    public function datosemp($idempresa)
    {

    $sql="select * from empresa where idempresa='$idempresa'";
    return ejecutarConsulta($sql);      
    }

    //Implementamos un método para dar de baja a factura
public function ActualizarEstado($idboleta,$st)
{
        $sw=true;
        $sqlestado="update boletaservicio set estado='$st' where idboleta='$idboleta'";
        ejecutarConsulta($sqlestado) or $sw=false; 
    return $sw;    
}

public function downftp($idboleta, $idempresa){    

    //Inclusion de la tabla RUTAS
    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($idempresa);
    $Prutas = $Rrutas->fetch_object();
    $rutadata=$Prutas->rutadata; // ruta de la carpeta data

      $connect = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
      mysqli_query( $connect, 'SET NAMES "'.DB_ENCODE.'"');
      //Si tenemos un posible error en la conexión lo mostramos
      if (mysqli_connect_errno())
      {
            printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
            exit();
      }

        $sql="select 
        b.idboleta, 
        p.email,  
        p.nombres, 
        p.apellidos, 
        p.nombre_comercial, 
        e.numero_ruc,
        b.tipo_documento_06,
        b.numeracion_07 
        from 
        boletaservicio b inner join persona p on 
        b.idcliente=p.idpersona inner join empresa e on 
        b.idempresa=e.idempresa 
        where 
        b.idboleta='$idboleta' and e.idempresa='$idempresa'";
        $result = mysqli_query($connect, $sql); 
        $con=0;
      while($row=mysqli_fetch_assoc($result)){
      for($i=0; $i <= count($result); $i++){
           $correocliente=$row["email"];
          }
  //Agregar=====================================================
  // Ruta del directorio donde están los archivos
        $path  = $rutadata; 
        $files = array_diff(scandir($path), array('.', '..')); 
  //=============================================================
        $boletaData=$row['numero_ruc']."-".$row['tipo_documento_06']."-".$row['numeracion_07'];
    //Validar si existe el archivo firmado
    foreach($files as $file){
    // Divides en dos el nombre de tu archivo utilizando el . 
    $dataSt = explode(".", $file);
    // Nombre del archivo
    $fileName = $dataSt[0];
    $st="1";
    // Extensión del archivo 
    $fileExtension = $dataSt[1];
    if($boletaData == $fileName){
        $archivoBoletaData=$fileName;
        // Realizamos un break para que el ciclo se interrumpa
         break;
      }
    }
    $cabext=$rutadata.$archivoBoletaData.'.json';
    $cab=$archivoBoletaData.'.json';
    $rpta = array ('cabext'=>$cabext,'cab'=>$cab
                 );

    return $rpta;

           $i=$i+1;
           $con=$con+1;           
          }
}

 //Implementar un método para mostrar los datos de un registro a modificar
    public function enviarcorreo($idboleta, $idempresa)
    {

    require_once "../modelos/Factura.php";
    $factura = new Factura();
    $datos = $factura->correo();
    $correo = $datos->fetch_object();

     //Inclusion de la tabla RUTAS
    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($idempresa);
    $Prutas = $Rrutas->fetch_object();
    $rutafirma=$Prutas->rutafirma; // ruta de la carpeta FIRMA

      $connect = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
      mysqli_query( $connect, 'SET NAMES "'.DB_ENCODE.'"');
      //Si tenemos un posible error en la conexión lo mostramos
      if (mysqli_connect_errno())
      {
            printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
            exit();
      }

        $sqlsendmail="select 
        b.idboleta, 
        p.email,  
        p.nombres, 
        p.apellidos, 
        p.nombre_comercial, 
        e.numero_ruc,
        b.tipo_documento_06,
        b.numeracion_07 
        from 
        boletaservicio b inner join persona p on 
        b.idcliente=p.idpersona inner join empresa e on 
        b.idempresa=e.idempresa 
        where 
        b.idboleta='$idboleta'  and e.idempresa='$idempresa'";

        $result = mysqli_query($connect, $sqlsendmail); 

      //$variable=array();

      $con=0;
            
      while($row=mysqli_fetch_assoc($result)){
      for($i=0; $i <= count($result); $i++){
           $correocliente=$row["email"];
          }

  //Agregar=====================================================
  // Ruta del directorio donde están los archivos
        $path  = $rutafirma; 
        $pathBoleta  = '../boletasPDF/'; 
        // Arreglo con todos los nombres de los archivos
        $files = array_diff(scandir($path), array('.', '..')); 
        $filesBoleta = array_diff(scandir($pathBoleta), array('.', '..')); 
  //=============================================================
        $boleta=$row['numero_ruc']."-".$row['tipo_documento_06']."-".$row['numeracion_07'];

    //Validar si existe el archivo firmado
    foreach($files as $file){
    // Divides en dos el nombre de tu archivo utilizando el . 
    $dataSt = explode(".", $file);
    // Nombre del archivo
    $fileName = $dataSt[0];
    $st="1";
    // Extensión del archivo 
    $fileExtension = $dataSt[1];

    if($boleta == $fileName){
        $archivoBoleta=$fileName;
        // Realizamos un break para que el ciclo se interrumpa
         break;
      }
    }
//==========================================================================
    //Validar si existe el archivo firmado
    foreach($filesBoleta as $fileBoleta){
    // Divides en dos el nombre de tu archivo utilizando el . 
    $dataStBoleta = explode(".", $fileBoleta);
    // Nombre del archivo
    $fileNameBoleta = $dataStBoleta[0];
    // Extensión del archivo 
    $fileExtensionBoleta = $dataStBoleta[1];

    if($row['numeracion_07'] == $fileNameBoleta){
        $archivoBoletaPdf=$fileNameBoleta;
        // Realizamos un break para que el ciclo se interrumpa
         break;
      }
    }

    $url=$rutafirma.$archivoBoleta.'.xml';
    $fichero = file_get_contents($url);

    $urlBoleta='../boletasPDF/'.$archivoBoletaPdf.'.pdf';
    $ficheroBoleta = file_get_contents($urlBoleta);

// FUNCION PARA ENVIO DE CORREO CON LA FACTURA AL CLIENTE .
  require '../correo/PHPMailer/class.phpmailer.php';
  require '../correo/PHPMailer/class.smtp.php';
  $mail = new PHPMailer;
  $mail->isSMTP();                         // Establecer el correo electrónico para utilizar SMTP
  $mail->Host = $correo->host;             // Especificar el servidor de correo a utilizar 
  $mail->SMTPAuth = true;                  // Habilitar la autenticacion con SMTP
  $mail->Username = $correo->username ;    // Correo electronico saliente ejemplo: tucorreo@gmail.com
  //$clavehash=hash("SHA256",$correo->password);
  $mail->Password = $correo->password;     // Tu contraseña de gmail
  $mail->SMTPSecure = $correo->smtpsecure;                  // Habilitar encriptacion, `ssl` es aceptada
  $mail->Port = $correo->port;                          // Puerto TCP  para conectarse 
  $mail->setFrom($correo->username, utf8_decode($correo->nombre));//Introduzca la dirección de la que debe aparecer el correo electrónico. Puede utilizar cualquier dirección que el servidor SMTP acepte como válida. El segundo parámetro opcional para esta función es el nombre que se mostrará como el remitente en lugar de la dirección de correo electrónico en sí.
  $mail->addReplyTo($correo->username, utf8_decode($correo->nombre));//Introduzca la dirección de la que debe responder. El segundo parámetro opcional para esta función es el nombre que se mostrará para responder
  $mail->addStringAttachment($fichero, $archivoBoleta.'.xml');
  $mail->addStringAttachment($ficheroBoleta, $archivoBoletaPdf.'.pdf');
  $mail->addAddress($correocliente);   // Agregar quien recibe el e-mail enviado
  //$mail->addAttachment();
  $message = file_get_contents('../correo/email_template.html');
  $message = str_replace('{{first_name}}', utf8_decode($correo->nombre),utf8_decode($correo->mensaje));
  $message = str_replace('{{message}}', utf8_decode($correo->mensaje), utf8_decode($correo->mensaje));
  $message = str_replace('{{customer_email}}', $correo->username, utf8_decode($correo->mensaje));
  $mail->isHTML(true);  // Establecer el formato de correo electrónico en HTML
  
  $mail->Subject = $correo->username;
  $mail->msgHTML($message);
  //$mail->send();

  if(!$mail->send()) {
    //echo '<p style="color:red">No se pudo enviar el mensaje..';
    echo $mail->ErrorInfo;
    //echo "</p>";
  } else {
    echo 'Tu mensaje ha sido enviado';
  }
  // FUNCION PARA ENVIO DE CORREO CON LA FACTURA AL CLIENTE .


           $i=$i+1;
           $con=$con+1;           
          }
}

}

    


?>