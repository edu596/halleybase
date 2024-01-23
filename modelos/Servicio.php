<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";


    

Class Servicio
{

    //Implementamos nuestro constructor
    public function __construct()
    {
 

    }


 
 
    //Implementamos un método para insertar registros para factura
    public function insertar($idusuario, $fecha_emision, $firma_digital, $idempresa, $tipo_documento, $numeracion, $idcliente, $total_operaciones_gravadas_codigo, $total_operaciones_gravadas_monto, $sumatoria_igv_1, $sumatoria_igv_2, $codigo_tributo_3, $nombre_tributo_4, $codigo_internacional_5, $importe_total_venta, $tipo_documento_guia, $guia_remision_29_2, $codigo_leyenda_1, $descripcion_leyenda_2, $version_ubl, $version_estructura, $tipo_moneda, $tasa_igv ,   $idarticulo, $numero_orden_item, $cantidad, $codigo_precio, $pvt, $igvBD2, $igvBD2, $afectacion_igv_3, $afectacion_igv_4, $afectacion_igv_5, $afectacion_igv_6, $igvBD, $valor_unitario, $subtotalBD, $codigo, $unidad_medida, $idserie, $SerieReal, $numero_factura, $tipodocuCliente ,$rucCliente,  $RazonSocial, $hora, $descdet, $vendedorsitio, $email, $domicilio_fiscal2)
    {


        $sql="insert into 
        facturaservicio
         (  
            
            idusuario,
            fecha_emision_01, 
            firmadigital_02, 
            idempresa, 
            tipo_documento_07, 
            numeracion_08, 
            idcliente, 
            total_operaciones_gravadas_codigo_18_1, 
            total_operaciones_gravadas_monto_18_2, 
            sumatoria_igv_22_1, 
            sumatoria_igv_22_2, 
            codigo_tributo_22_3, 
            nombre_tributo_22_4, 
            codigo_internacional_22_5, 
            importe_total_venta_27, 
            tipo_documento_29_1,
             guia_remision_29_2, 
             codigo_leyenda_31_1, 
             descripcion_leyenda_31_2, 
             version_ubl_36, 
             version_estructura_37, 
             tipo_moneda_28, 
             tasa_igv, 
             estado, 
             tipodocuCliente, 
             rucCliente, 
             RazonSocial,
             tdescuento,
             vendedorsitio
          )
          values
          (
          
          '$idusuario',
          '$fecha_emision $hora',
          '$firma_digital',
          '$idempresa',
          '$tipo_documento',
          '$SerieReal-$numero_factura',
          '$idcliente',
          '$total_operaciones_gravadas_codigo',
          '$total_operaciones_gravadas_monto',
          '$sumatoria_igv_1',
          '$sumatoria_igv_2',
          '$codigo_tributo_3',
          '$nombre_tributo_4',
          '$codigo_internacional_5',
          '$importe_total_venta',
          '$tipo_documento_guia',
          '$guia_remision_29_2',
          '$codigo_leyenda_1',
          '$descripcion_leyenda_2',
          '$version_ubl',
          '$version_estructura',
          '$tipo_moneda',
          '$tasa_igv',
          '1', 
          '$tipodocuCliente ',
          '$rucCliente',
          '$RazonSocial',
          '0.00',
          '$vendedorsitio'
        )";
        //return ejecutarConsulta($sql);
        $idfacturanew=ejecutarConsulta_retornarID($sql);
 
        

        $num_elementos=0;
        $sw=true;

        while ($num_elementos < count($idarticulo))
        {
            //Guardar en Detalle
        $sql_detalle = "insert into 
        detalle_fac_art_ser
        (
        idfactura, 
        idarticulo, 
        numero_orden_item_33, 
        cantidad_item_12, 
        codigo_precio_15_1, 
        precio_venta_item_15_2, 
        afectacion_igv_item_16_1, 
        afectacion_igv_item_16_2, 
        afectacion_igv_item_16_3, 
        afectacion_igv_item_16_4, 
        afectacion_igv_item_16_5, 
        afectacion_igv_item_16_6, 
        igv_item, 
        valor_uni_item_14, 
        valor_venta_item_21, 
        descdet
        ) 
          values 
          (
          '$idfacturanew', 
          '$idarticulo[$num_elementos]',
          '$numero_orden_item[$num_elementos]',
          '$cantidad',
          '$codigo_precio',
          '$valor_unitario[$num_elementos]',
          '$igvBD2[$num_elementos]',
          '$igvBD2[$num_elementos]',
          '$afectacion_igv_3',
          '$afectacion_igv_4',
          '$afectacion_igv_5',
          '$afectacion_igv_6',
          '$igvBD[$num_elementos]',
          '$pvt[$num_elementos]'/1.18,
          '$subtotalBD[$num_elementos]', 
          '$descdet[$num_elementos]'
        )";

     
          $sqlupdatecorreocliente="update persona set email='$email', domicilio_fiscal='$domicilio_fiscal2', razon_social='$RazonSocial', nombre_comercial='$RazonSocial'   where idpersona='$idcliente'";

            //return ejecutarConsulta($sql);
            ejecutarConsulta($sql_detalle) or $sw = false;
            ejecutarConsulta($sqlupdatecorreocliente) or $sw = false;

      // SI EL NUMERO DE COMPROBANTE YA EXISTE NO HARA LA OPERACIon
      if ($idfacturanew==""){
      $sw=false;
      }

            $num_elementos=$num_elementos + 1;
        } //Fin While

                //Para actualizar numeracion de las series de la factura
                 $sql_update_numeracion="update
                  numeracion 
                  set 
                  numero='$numero_factura' 
                  where 
                  idnumeracion='$idserie'";
                 ejecutarConsulta($sql_update_numeracion) or $sw = false;
                 //Fin



//================ EXPORTAR COMPROBANTES A TXT =============
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
    $rutadatalt=$Prutas->rutadatalt; // ruta de la carpeta BAJA

    $query = "select
     date_format(f.fecha_emision_01, '%Y-%m-%d') as fecha, 
     right(substring_index(f.numeracion_08,'-',1),1) as serie,
     date_format(f.fecha_emision_01, '%H:%i:%s') as hora,
     p.tipo_documento as  tipodocuCliente, 
     p.numero_documento, 
     p.razon_social, 
     f.tipo_moneda_28, 
     f.total_operaciones_gravadas_monto_18_2 as subtotal, 
     f.sumatoria_igv_22_1 as igv, 
     f.importe_total_venta_27 as total, 
     f.tipo_documento_07 as tipocomp, 
     f.numeracion_08 as numerodoc, 
     f.estado, 
     f.tdescuento
     from 
     facturaservicio f inner join persona p on f.idcliente=p.idpersona where idfactura='$idfacturanew' and f.estado='1' order by numerodoc";

    $querydetfac = "select
       f.tipo_documento_07 as tipocomp, 
       f.numeracion_08 as numerodoc,  
       df.cantidad_item_12 as cantidad, 
       si.codigo, 
       si.descripcion, 
       replace(format(df.valor_uni_item_14,5),',','') as vui, 
       df.igv_item as igvi, 
       df.precio_venta_item_15_2 as pvi, 
       df.valor_venta_item_21 as vvi,
       df.afectacion_igv_item_16_1 as sutribitem
       from
       facturaservicio f inner join detalle_fac_art_ser df on f.idfactura=df.idfactura inner join servicios_inmuebles si on df.idarticulo=si.id
          where f.idfactura='$idfacturanew' and f.estado='1' order by f.fecha_emision_01";


      $result = mysqli_query($connect, $query);  
      $resultf = mysqli_query($connect, $querydetfac); 

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

        
      // $path=$rutadata.$ruc."-".$tipocomp."-".$numerodoc.".cab";
      // $handle=fopen($path, "w");
      // fwrite($handle,"0101|".$fecha[$i]."|".$hora."|-|0000|".$tipodocu[$i]."|".$numdocu[$i]."|".$rasoc[$i]."|".$moneda[$i]."|".$igv[$i]."|".$subtotal[$i]."|".$total[$i]."|".$tdescu[$i]."|0|0|".$total[$i]."|2.1|2.0|"); 
      // fclose($handle);


      // $path=$rutadatalt.$ruc."-".$tipocomp."-".$numerodoc.".cab"; //RUTA ALTERNA DE DESCARGA
      // $handle=fopen($path, "w");
      // fwrite($handle,"0101|".$fecha[$i]."|".$hora."|-|0000|".$tipodocu[$i]."|".$numdocu[$i]."|".$rasoc[$i]."|".$moneda[$i]."|".$igv[$i]."|".$subtotal[$i]."|".$total[$i]."|".$tdescu[$i]."|0|0|".$total[$i]."|2.1|2.0|");  
      // fclose($handle);


      require_once "Letras.php";
      $V=new EnLetras(); 
      $con_letra=strtoupper($V->ValorEnLetras($total[$i],"NUEVOS SOLES"));
      // $path=$rutadata.$ruc."-".$tipocomp."-".$numerodoc.".ley";
      // //$server_ley = $path; //Nombre archivo en FTP
      // $handle=fopen($path, "w");
      // fwrite($handle,"1000|".$con_letra."|"); 
      // fclose($handle);

      // $path=$rutadata.$ruc."-".$tipocomp."-".$numerodoc.".tri";
      // //$server_tri = $path; //Nombre archivo en FTP
      // $handle=fopen($path, "w");
      // //fwrite($handle,"1000|IGV|VAT|S|".$subtotal[$i]."|".$igv[$i]."|");  VERSION 1.1
      // fwrite($handle,"1000|IGV|VAT|".$subtotal[$i]."|".$igv[$i]."|"); 
      // fclose($handle);


       //FORMATO JSON
      $json = array('cabecera' => array('tipOperacion'=>'0101', 'fecEmision'=>$fecha[$i], 'horEmision'=>$hora, 'fecVencimiento'=>"-", 'codLocalEmisor'=>"0000", 'tipDocUsuario'=>$tipodocu[$i], 'numDocUsuario'=>$numdocu[$i], 'rznSocialUsuario'=>$rasoc[$i], 'tipMoneda'=>$moneda[$i], 'sumTotTributos'=>number_format($igv[$i],2,'.',''), 'sumTotValVenta'=>number_format($subtotal[$i],2,'.',''), 'sumPrecioVenta'=>number_format($total[$i],2,'.',''), 'sumDescTotal'=>"0.00", 'sumOtrosCargos'=>"0.00", 'sumTotalAnticipos'=>"0.00", 'sumImpVenta'=>number_format($total[$i],2,'.',''), 'ublVersionId'=>"2.1", 'customizationId'=>"2.0"), 'detalle' => array(), 'leyendas' => array(), 'tributos' => array());


      //Leyenda JSON
      $json['leyendas'][] = array('codLeyenda'=>"1000",'desLeyenda'=>$con_letra);
      $json['tributos'][] = array('ideTributo'=>"1000", 'nomTributo'=>"IGV", 'codTipTributo'=>"VAT", 'mtoBaseImponible'=>number_format($subtotal[$i],2,'.',''), 'mtoTributo'=>number_format($igv[$i],2,'.',''));
      //Leyenda JSON

          }
           $i=$i+1;
           $con=$con+1;           
          }

          
      $codigo=array();
      $cantidad=array();
      $descripcion=array();
      $um=array();
      $vui=array();
      $igvi=array();
      $pvi=array();
      $vvi=array();
      $sutribitem=array();
      
      while($rowf=mysqli_fetch_assoc($resultf)){
      for($if=0; $if < count($resultf); $if++){
           $codigo[$if]=$rowf["codigo"];
           $cantidad[$if]=$rowf["cantidad"];
           $descripcion[$if]=$rowf["descripcion"];
           $vui[$if]=$rowf["vui"];
           $sutribitem[$if]=$rowf["sutribitem"];           
           $igvi[$if]=$rowf["igvi"];
           $pvi[$if]=$rowf["pvi"];
           $vvi[$if]=$rowf["vvi"];
           $tipocompf=$rowf["tipocomp"];
           $numerodocf=$rowf["numerodoc"];
           $ruc=$datose->numero_ruc;

          
    // $pathf=$rutadata.$ruc."-".$tipocompf."-".$numerodocf.".det";
    // $handlef=fopen($pathf, "a");
    // fwrite($handlef, "SER|".$cantidad[$if]."|".$codigo[$if]."|-|".$descripcion[$if]."|".$vui[$if]."|".$sutribitem[$if]."|1000|".$sutribitem[$if]."|".$vvi[$if]."|IGV|VAT|10|18|-|||||||-||||||".$pvi[$if]."|".$vvi[$if]."|0|\r\n");  
    //        fclose($handlef);

    // $pathf=$rutadatalt.$ruc."-".$tipocompf."-".$numerodocf.".det";
    // $handlef=fopen($pathf, "a");
    // fwrite($handlef,"SER|".$cantidad[$if]."|".$codigo[$if]."|-|".$descripcion[$if]."|".$vui[$if]."|".$sutribitem[$if]."|1000|".$sutribitem[$if]."|".$vvi[$if]."|IGV|VAT|10|18|-|||||||-||||||".$pvi[$if]."|".$vvi[$if]."|0|\r\n");    
    //        fclose($handlef);
 $json['detalle'][] = array('codUnidadMedida'=>"NIU", 'ctdUnidadItem'=>number_format($cantidad[$if],2,'.',''), 'codProducto'=>$codigo[$if], 'codProductoSUNAT'=>"-", 'desItem'=>$descripcion[$if], 'mtoValorUnitario'=>number_format($vui[$if],5,'.',''), 'sumTotTributosItem'=>number_format($sutribitem[$if],2,'.',''), 'codTriIGV'=>"1000", 'mtoIgvItem'=>number_format($sutribitem[$if],2,'.',''), 'mtoBaseIgvItem'=>number_format($vvi[$if],2,'.',''), 'nomTributoIgvItem'=>"IGV", 'codTipTributoIgvItem'=>"VAT", 'tipAfeIGV'=>"10", 'porIgvItem'=>"18.0", 'codTriISC'=>"-", 'mtoIscItem'=>"", 'mtoBaseIscItem'=>"", 'nomTributoIscItem'=>"", 'codTipTributoIscItem'=>"", 'tipSisISC'=>"", 'porIscItem'=>"", 'codTriOtroItem'=>"-", 'mtoTriOtroItem'=>"", 'mtoBaseTriOtroItem'=>"", 'nomTributoIOtroItem'=>"", 'codTipTributoIOtroItem'=>"", 'porTriOtroItem'=>"", 'mtoPrecioVentaUnitario'=>number_format($pvi[$if],2,'.',''), 'mtoValorVentaItem'=>number_format($vvi[$if],2,'.',''), 'mtoValorReferencialUnitario'=>"0");
      }
      }


      $path=$rutadata.$ruc."-".$tipocomp."-".$numerodoc.".json";
      $jsonencoded = json_encode($json,JSON_UNESCAPED_UNICODE);
      $fh = fopen($path, 'w');
      fwrite($fh, $jsonencoded);
      fclose($fh);


      $path=$rutadatalt.$ruc."-".$tipocomp."-".$numerodoc.".json";
      $jsonencoded = json_encode($json,JSON_UNESCAPED_UNICODE);
      $fh = fopen($path, 'w');
      fwrite($fh, $jsonencoded);
      fclose($fh);





//======================== EXPORTAR COMPROBANTES A TXT ==============================

            return $sw;
//=======================================





}

// FIN ========== EXPORTAR COMPROBANTES A txt =============
 


//Implementamos un método para dar de baja a factura
public function baja($idfactura,$fecha_baja, $com, $hora)
{
        $sw=true;

         $sqlestado="update facturaservicio set estado='3', fecha_baja='$fecha_baja $hora', comentario_baja='$com' where idfactura='$idfactura'";
        ejecutarConsulta($sqlestado) or $sw=false;

    return $sw;    

}

//Implementamos un método para dar de baja a factura
public function ActualizarEstado($idfactura,$st)
{
        $sw=true;
        $sqlestado="update facturaservicio set estado='$st' where idfactura='$idfactura'";
        ejecutarConsulta($sqlestado) or $sw=false; 
    return $sw;    
}



//Implementamos un método para anular la factura
public function anular($idfactura)
{
       
$connect = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
      mysqli_query( $connect, 'SET NAMES "'.DB_ENCODE.'"');
      //Si tenemos un posible error en la conexión lo mostramos
      if (mysqli_connect_errno())
      {
            printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
            exit();
      }

    $query="select idfactura, idarticulo  from detalle_fac_art_ser where idfactura = '$idfactura'";
    $resultado = mysqli_query($connect,$query);

    $Idf=array();
    $Ida=array();
    $sw=true;

    while ($fila = mysqli_fetch_assoc($resultado)) {
    for($i=0; $i < count($resultado) ; $i++){
        $Idf[$i] = $fila["idfactura"];  
        $Ida[$i] = $fila["idarticulo"];  

    $sql_update_articulo="update detalle_fac_art_ser de 
    inner join 
    articulo a  
    on de.idarticulo=a.idarticulo 
    set 
     a.saldo_finu=a.saldo_finu + de.cantidad_item_12, a.stock=a.stock + de.cantidad_item_12, a.ventast=a.ventast - de.cantidad_item_12, a.valor_finu=(a.saldo_finu + a.comprast - a.ventast) * a.costo_compra
    where 
    de.idfactura='$Idf[$i]' and de.idarticulo='$Ida[$i]'";
        
        
    // //ACTUALIZAR TIPO TRANSACCIon KARDEX
    // //Guardar en Kardex
    // $sql_kardex="insert into kardex (idcomprobante, idarticulo, transaccion, codigo, fecha, tipo_documento, numero_doc, cantidad, costo_1, unidad_medida, saldo_final, costo_2,valor_final) 

    //         values 

    //         ('$idfactura', (select a.idarticulo from articulo a inner join detalle_fac_art_ser dtf on a.idarticulo=dtf.idarticulo where a.idarticulo='$Ida[$i]' and dtf.idfactura = '$Idf[$i]'), 

    //         'ANULADO', 

    //         (select a.codigo from articulo a inner join detalle_fac_art_ser dtf on a.idarticulo=dtf.idarticulo where a.idarticulo='$Ida[$i]' and dtf.idfactura = '$Idf[$i]'),

    //          (select fecha_emision_01 from factura where idfactura='$Idf[$i]'), 
    //          '01',
    //          (select numeracion_08 from factura where idfactura='$Idf[$i]'), 

    //          (select dtf.cantidad_item_12 from articulo a inner join detalle_fac_art_ser dtf on a.idarticulo=dtf.idarticulo where a.idarticulo='$Ida[$i]' and dtf.idfactura = '$Idf[$i]'), 

    //          (select dtf.valor_uni_item_14 from articulo a inner join detalle_fac_art_ser dtf on a.idarticulo=dtf.idarticulo where a.idarticulo='$Ida[$i]' and dtf.idfactura = '$Idf[$i]'),

    //          (select a.unidad_medida from articulo a inner join detalle_fac_art_ser dtf on a.idarticulo=dtf.idarticulo where a.idarticulo='$Ida[$i]' and dtf.idfactura = '$Idf[$i]'),

    //          0, 0, 0)";
        }

        $sqlestado="update factura  set estado='0' where idfactura='$idfactura'";

        //Fin de FOR
         ejecutarConsulta($sql_update_articulo) or $sw=false;
         //ejecutarConsulta($sql_kardex) or $sw=false; 
         ejecutarConsulta($sqlestado) or $sw=false; 
        }
        //Fin de WHILE
    return $sw;    
}

 
    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($idfactura)
    {
        $sql="select 
        f.idfactura,
        date(f.fecha_emision_01) as fecha,
        f.idcliente,
        p.razon_social as cliente,
        p.numero_documento,
        p.domicilio_fiscal,
        u.idusuario,
        u.nombre as usuario,
        f.tipo_documento_07,
        f.numeracion_08, 
        f.total_operaciones_gravadas_monto_18_2, 
        f.sumatoria_igv_22_1, 
        f.importe_total_venta_27, 
        f.estado 
        from 
        facturaservicio f inner join persona p on f.idcliente=p.idpersona inner join usuario u on f.idusuario=u.idusuario where f.idfactura='$idfactura'";
        return ejecutarConsultaSimpleFila($sql);
    }

    
    public function enviarcorreo($idfactura)
    {

    require_once "../modelos/Servicio.php";
    $servicio = new Servicio();
    $datos = $servicio->correo();
    $correo = $datos->fetch_object();

     //Inclusion de la tabla RUTAS
    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2();
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
        f.idfactura, 
        p.email,  
        p.nombres, 
        p.apellidos, 
        p.nombre_comercial, 
        e.numero_ruc,
        f.tipo_documento_07,
        f.numeracion_08 
        from 
        factura f inner join persona p on 
        f.idcliente=p.idpersona inner join empresa e on 
        f.idempresa=e.idempresa 
        where 
        f.idfactura='$idfactura' ";

        $result = mysqli_query($connect, $sqlsendmail); 

      $con=0;
            
      while($row=mysqli_fetch_assoc($result)){
      for($i=0; $i <= count($result); $i++){
           $correocliente=$row["email"];
          }

  //Agregar=====================================================
  // Ruta del directorio donde están los archivos
        $path  = $rutafirma; 
        $pathFactura  = '../facturasPDF/'; 
        // Arreglo con todos los nombres de los archivos
        $files = array_diff(scandir($path), array('.', '..')); 
        $filesFactura = array_diff(scandir($pathFactura), array('.', '..')); 
  //=============================================================
        $factura=$row['numero_ruc']."-".$row['tipo_documento_07']."-".$row['numeracion_08'];

    //Validar si existe el archivo firmado
    foreach($files as $file){
    // Divides en dos el nombre de tu archivo utilizando el . 
    
    $dataSt = explode(".", $file);
    // Nombre del archivo
    $fileName = $dataSt[0];
    $st="1";
    // Extensión del archivo 
    $fileExtension = $dataSt[1];

    if($factura == $fileName){
        $archivoFactura=$fileName;
        
        // Realizamos un break para que el ciclo se interrumpa
         break;
      }
    }
//=========================================================================

    //Validar si existe el archivo firmado
    foreach($filesFactura as $fileFactura){
    // Divides en dos el nombre de tu archivo utilizando el . 
    $dataStF = explode(".", $fileFactura);
    // Nombre del archivo
    $fileNameF = $dataStF[0];
    // Extensión del archivo 
    $fileExtensionF = $dataStF[1];

    if($row['numeracion_08'] == $fileNameF){
        $archivoFacturaPDF=$fileNameF;
        // Realizamos un break para que el ciclo se interrumpa
         break;
      }
    }
    
    $url=$rutafirma.$archivoFactura.'.xml';
    $fichero = file_get_contents($url);

    $urlFac='../facturasPDF/'.$archivoFacturaPDF.'.pdf';
    $ficheroFact = file_get_contents($urlFac);

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
  $mail->addStringAttachment($fichero, $archivoFactura.'.xml');
  $mail->addStringAttachment($ficheroFact, $archivoFacturaPDF.'.pdf');
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
//Guardar en tabla envicorreo =========================================
$sql="insert into 
        enviocorreo
         (  
            numero_documento,
            cliente, 
            correo, 
            comprobante, 
            fecha_envio
          )
          values
          (
          
          (select numero_documento from factura f inner join persona p on f.idcliente=p.idpersona where f.idfactura='$idfactura'),
          (select razon_social from factura f inner join persona p on f.idcliente=p.idpersona where f.idfactura='$idfactura'),
          (select email from factura f inner join persona p on f.idcliente=p.idpersona where f.idfactura='$idfactura'),
          (select numeracion_08 from factura where idfactura='$idfactura'),
          now()
        )";
        //return ejecutarConsulta($sql);
        $enviarcorreo=ejecutarConsulta($sql);
  //Guardar en tabla envicorreo =========================================



}


    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrarCabFac()
    {
        $sql="select
        f.idfactura,
     e.numero_ruc as ruc,
     f.tipo_documento_07 as tipodoc,
     f.numeracion_08 as numerodoc
     from 
     factura f inner join persona p on f.idcliente=p.idpersona
     inner join empresa e on f.idempresa=f.idempresa
     ";
        return ejecutarConsulta($sql);
    }
 
    public function listarDetalle($idfactura)
    {
        $sql="select df.idfactura,df.idarticulo,a.nombre,df.cantidad_item_12, df.valor_uni_item_14, df.valor_venta_item_21, df.igv_item from detalle_fac_art_ser df inner join articulo a on df.idarticulo=a.idarticulo where df.idfactura='$idfactura'";
        return ejecutarConsulta($sql);
    }
 
    //Implementar un método para listar los registros
    public function listarServicio($idempresa)
    {
        $sql="select 
        fs.idfactura,
        date_format(fs.fecha_emision_01,'%d/%m/%y') as fecha,
        date_format(curdate(),'%Y%m%d') as fechabaja,
        fs.idcliente,
        left(p.razon_social,20) as cliente,
        fs.vendedorsitio,
        u.nombre as usuario,
        fs.tipo_documento_07,
        fs.numeracion_08,
        format(fs.importe_total_venta_27,2)as importe_total_venta_27 ,
        fs.sumatoria_igv_22_1,
        fs.estado,
        e.numero_ruc,
        p.email 
        from 
        facturaservicio fs inner join persona p on fs.idcliente=p.idpersona 
        inner join usuario u on fs.idusuario=u.idusuario 
        inner join empresa e on fs.idempresa=e.idempresa where e.idempresa='$idempresa'
        order by idfactura desc";
        return ejecutarConsulta($sql);  

    }

      public function listarValidar($ano, $mes, $dia, $idempresa)
    {
        $sql="select 
        f.idfactura,
        date_format(f.fecha_emision_01,'%d/%m/%y') as fecha,
        date_format(curdate(),'%Y%m%d') as fechabaja,
        f.idcliente,
        left(p.razon_social,20) as cliente,
        f.vendedorsitio,
        u.nombre as usuario,
        f.tipo_documento_07,
        f.numeracion_08,
        format(f.importe_total_venta_27,2)as importe_total_venta_27 ,
        f.sumatoria_igv_22_1,f.estado,
        e.numero_ruc,
        p.email 
        from 
        facturaservicio f inner join persona p on f.idcliente=p.idpersona 
        inner join usuario u on f.idusuario=u.idusuario 
        inner join empresa e on f.idempresa=e.idempresa where
        year(fecha_emision_01)='$ano' and month(fecha_emision_01)='$mes' and day(fecha_emision_01)='$dia'
        order by idfactura desc";
        return ejecutarConsulta($sql);  

    }

     public function listarDR($ano, $mes)
    {
        $sql="select 
        f.idfactura,
        f.idcliente,
        numeracion_08 as numerofactura,
        date_format(f.fecha_emision_01,'%d/%m/%y') as fecha,
        date_format(f.fecha_baja,'%d/%m/%y') as fechabaja,
        left(p.razon_social,20) as cliente,
        p.numero_documento as ruccliente,
        f.total_operaciones_gravadas_monto_18_2 as opgravada,        
        f.sumatoria_igv_22_1 as igv,
        format(f.importe_total_venta_27,2) as total,
        f.vendedorsitio,
        f.estado 
        from 
        factura f inner join persona p on f.idcliente=p.idpersona 
        inner join usuario u on f.idusuario=u.idusuario 
        inner join empresa e on f.idempresa=e.idempresa where  year(f.fecha_emision_01)='$ano' and month(f.fecha_emision_01)='$mes' and f.estado in ('0','3')
        order by idfactura desc";
        return ejecutarConsulta($sql);  
    }

     public function listarDRdetallado($idcomp)
    {
        $sql="select 
        ncd.codigo_nota,
        ncd.numeroserienota as numero,
        f.numeracion_08,
        date_format(ncd.fecha,'%d/%m/%y') as fecha,
        ncd.desc_motivo as motivo,
        ncd.total_val_venta_og as subtotal,
        ncd.sum_igv as igv,
        ncd.importe_total as total
        from 
        factura f inner join persona p on f.idcliente=p.idpersona 
        inner join usuario u on f.idusuario=u.idusuario 
        inner join empresa e on f.idempresa=e.idempresa inner join notacd ncd on f.idfactura=ncd.idcomprobante
        where f.idfactura='$idcomp'";
        return ejecutarConsulta($sql);  

    }


    public function ventacabecera($idfactura, $idempresa){
        $sql="select 
        f.idfactura, 
        f.idcliente, 
        p.razon_social as cliente, 
        p.domicilio_fiscal as direccion, 
        p.tipo_documento, 
        p.numero_documento, 
        p.email, 
        p.telefono1, 
        p.nombre_comercial, 
        f.idusuario, 
        concat(u.nombre,' ',u.apellidos) as usuario, 
        f.tipo_documento_07,
        right(substring_index(f.numeracion_08,'-',1),4) as serie, 
        right(substring_index(f.numeracion_08,'-',-1),10) as numerofac, 
        f.numeracion_08, 
        date_format(f.fecha_emision_01,'%d-%m-%Y') as fecha, 
        date_format(f.fecha_emision_01,'%Y-%m-%d') as fecha2,
        date_format(f.fecha_emision_01, '%H:%i:%s') as hora, 
        f.sumatoria_igv_22_1, 
        f.importe_total_venta_27, 
        f.tasa_igv, 
        f.guia_remision_29_2 as guia, 
        f.estado,
        e.numero_ruc, 
        f.tdescuento,
        f.total_operaciones_gravadas_monto_18_2 as subtotal,
        f.vendedorsitio
          from
          facturaservicio f inner join persona p on f.idcliente=p.idpersona inner join empresa e 
          on e.idempresa=f.idempresa
          inner join
          usuario u on f.idusuario=u.idusuario where f.idfactura='$idfactura' and e.idempresa='$idempresa'";
        return ejecutarConsulta($sql);
    }

    

    public function ventadetalle($idfactura, $idempresa){
        $sql="select  
        si.descripcion,
        si.codigo, 
        format(dfa.cantidad_item_12,2) as cantidad_item_12, 
        dfa.valor_uni_item_14, 
        format((dfa.cantidad_item_12 * dfa.valor_uni_item_14),2) as subtotal, 
        dfa.precio_venta_item_15_2, 
        dfa.valor_venta_item_21,
        dfa.dcto_item as descuento,
        dfa.descdet,
        format(dfa.precio_venta_item_15_2,2) as precio,
        dfa.numero_orden_item_33 as norden
        from 
        detalle_fac_art_ser dfa inner join servicios_inmuebles si on dfa.idarticulo=si.id inner join facturaservicio fs on dfa.idfactura=fs.idfactura inner join empresa e on fs.idempresa=e.idempresa where dfa.idfactura='$idfactura' and e.idempresa='$idempresa'";
        return ejecutarConsulta($sql);
    }

        public function listarD()
    {
        $sql="select documento from correlativo where documento='factura' or documento='boleta' or documento='nota de credito'or documento='nota de debito' group by documento";
        return ejecutarConsulta($sql);      
    }


     public function listarS($serie)
    {
        $sql="select serie from correlativo where documento='$serie'"; 
        return ejecutarConsulta($sql);      
    }

    public function sumarC($tipo_comprobante, $serie_comprobante){

        $sql="select (numero + 1) as addnumero from `correlativo` where documento='$tipo_comprobante' and serie='$serie_comprobante' order by numero desc limit 1";
        return ejecutarConsulta($sql);      
    }

    public function autogenerarN(){

    $sql="select (idfactura + 1) as Nnum from factura order by idfactura desc limit 1";
    return ejecutarConsulta($sql);      

    }

    public function datosemp()
    {

    $sql="select * from empresa where idempresa='1'";
    return ejecutarConsulta($sql);      
    }

    public function correo()
    {

    $sql="select * from correo";
    return ejecutarConsulta($sql);      
    }


public function downftp($idfactura, $idempresa){    

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
        f.idfactura, 
        p.email,  
        p.nombres, 
        p.apellidos, 
        p.nombre_comercial, 
        e.numero_ruc,
        f.tipo_documento_07,
        f.numeracion_08 
        from 
        facturaservicio f inner join persona p on 
        f.idcliente=p.idpersona inner join empresa e on 
        f.idempresa=e.idempresa 
        where 
        f.idfactura='$idfactura' and e.idempresa='$idempresa' ";
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
        $facturaData=$row['numero_ruc']."-".$row['tipo_documento_07']."-".$row['numeracion_08'];
    //Validar si existe el archivo firmado
    foreach($files as $file){
    // Divides en dos el nombre de tu archivo utilizando el . 
    $dataSt = explode(".", $file);
    // Nombre del archivo
    $fileName = $dataSt[0];
    $st="1";
    // Extensión del archivo 
    $fileExtension = $dataSt[1];
    if($facturaData == $fileName){
        $archivoFacturaData=$fileName;
        // Realizamos un break para que el ciclo se interrumpa
         break;
      }
    }
    $cabext=$rutadata.$archivoFacturaData.'.json';
    // $cabext=$rutadata.$archivoFacturaData.'.cab';
    // $detext=$rutadata.$archivoFacturaData.'.det';
    // $leyext=$rutadata.$archivoFacturaData.'.ley';
    // $triext=$rutadata.$archivoFacturaData.'.tri';

   // $ficheroData = file_get_contents($url);

    $cab=$archivoFacturaData.'.json';
    // $cab=$archivoFacturaData.'.cab';
    // $det=$archivoFacturaData.'.det';
    // $ley=$archivoFacturaData.'.ley';
    // $tri=$archivoFacturaData.'.tri';

    $rpta = array ('cabext'=>$cabext,'cab'=>$cab
                   // 'detext'=>$detext, 'det'=>$det,
                   // 'leyext'=>$leyext, 'ley'=>$ley,
                   // 'triext'=>$triext, 'tri'=>$tri
                 );

    return $rpta;

           $i=$i+1;
           $con=$con+1;           
          }
}

public function uploadFtp()
{
// FTP detalles de servidor
$ftpHost   = 'tecnologosperu.com';
$ftpUsername = 'ago08ted';
$ftpPassword = '7pDramPW0mxP';
// Abrir FTP connection
$connId = ftp_connect($ftpHost) or die ("Couldn't connect to $ftpHost");
// login to FTP server
$ftpLogin = ftp_login($connId, $ftpUsername, $ftpPassword);

    //Inclusion de la tabla RUTAS
    // require_once "../modelos/Rutas.php";
    // $rutas = new Rutas();
    // $Rrutas = $rutas->mostrar2();
    // $Prutas = $Rrutas->fetch_object();
    // $rutadata=$Prutas->rutadata; // ruta de la carpeta data

    // $connect = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
    // mysqli_query( $connect, 'SET NAMES "'.DB_ENCODE.'"');
    // //Si tenemos un posible error en la conexión lo mostramos
    // if (mysqli_connect_errno())
    // {
    //   printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
    //   exit();
    // }

    //     $sql="select 
    //     f.idfactura, 
    //     p.email,  
    //     p.nombres, 
    //     p.apellidos, 
    //     p.nombre_comercial, 
    //     e.numero_ruc,
    //     f.tipo_documento_07,
    //     f.numeracion_08 
    //     from 
    //     factura f inner join persona p on 
    //     f.idcliente=p.idpersona inner join empresa e on 
    //     f.idempresa=e.idempresa 
    //     where 
    //     f.idfactura='$idfactura' ";
    //     $result = mysqli_query($connect, $sql); 
    //     $con=0;

      //while($row=mysqli_fetch_assoc($result)){
        //$path  = $rutadata; 
        //$facturaData=$row['numero_ruc']."-".$row['tipo_documento_07']."-".$row['numeracion_08'];
        //$aLocalfirmado="D:/SFS_v1.2/sunat_archivos/sfs/FIRMA/".$facturaData.'.xml';

        //$aLocalfirmado="D:/SFS_v1.2/sunat_archivos/sfs/FIRMA/".$facturaData.'.xml';
        //$remoteFilePath = '/public_html/halley/sfs/firma/'.$facturaData.'.xml';

        $aLocalfirmado='20100088917-01-F001-173.xml';
        $remoteFilePath = '/public_html/halley/sfs/firma/20100088917-01-F001-173.xml';
        // try to upload file
        if(ftp_put($connId, $remoteFilePath,$aLocalfirmado, FTP_BINARY)){
            echo "Archivo subido correctamente - $aLocalfirmado";
        }else{
            echo "Error subiendo $aLocalfirmado";
        }
          // $i=$i+1;
          // $con=$con+1;           
                                                          //  }

ftp_close($connId);

}



public function AutocompletarRuc($buscar){

  $connect = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
      mysqli_query( $connect, 'SET NAMES "'.DB_ENCODE.'"');
      //Si tenemos un posible error en la conexión lo mostramos
      if (mysqli_connect_errno())
      {
            printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
            exit();
      }

        $sql="select numero_documento, razon_social, domicilio_fiscal from persona where numero_documento like '%$buscar' and estado='1' and tipo_persona='cliente'";

        $Result=mysqli_query($connect, $sql);

        if ($Result->num_rows > 0)
        {
          while($fila=$result->fecth_array())
          {
            $datos[]=$fila['numero_documento'];
          }
          echo json_encode($datos);
        }

      }
    
}
?>