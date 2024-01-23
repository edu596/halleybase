<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
Class Ordenservicio
{

    //Implementamos nuestro constructor
    public function __construct()
    {
 

    }
 
    //Implementamos un método para insertar registros para factura
    public function insertar($idusuario, $idserie, $SerieReal, $numero_orden, $idproveedor, $fecha_emision, $formapago, $formaentrega, $tiposervicio, $idempresa, $fechaentrega, $anotaciones, $subtotal, $igv, $total, $hora, $idarticulo, $descdet, $cantidad, $valor_unitario, $subtotalBD)
    {
        $sql="insert into ordenservicio
         (
            idusuario,
            serienumero, 
            idproveedor, 
            fechaemision, 
            formapago, 
            formaentrega,
            idempresa, 
            fechaentrega, 
            anotaciones, 
            subtotal, 
            igv, 
            total,
            estado
            )
            values
            (
            '$idusuario',
            '$SerieReal-$numero_orden', 
            '$idproveedor', 
            '$fecha_emision $hora', 
            '$formapago', 
            '$formaentrega', 
            '$idempresa', 
            '$fechaentrega', 
            '$anotaciones', 
            '$subtotal', 
            '$igv', 
            '$total',
            '1'
        )";
        //return ejecutarConsulta($sql);
        $idordennew=ejecutarConsulta_retornarID($sql);
 
        $num_elementos=0;
        $sw=true;

        while ($num_elementos < count($idarticulo))
        {
            //Guardar en Detalle
        $sql_detalle = "insert into 
        detalle_ordenservicio_articulo
        (
        idorden, 
        idarticulo, 
        descripcion, 
        cantidad, 
        valorcosto, 
        totalunitario 
          ) 
          values 
          (
          '$idordennew', 
          '$idarticulo[$num_elementos]',
          '$descdet[$num_elementos]',
          '$cantidad[$num_elementos]',
          '$valor_unitario[$num_elementos]',
          '$subtotalBD[$num_elementos]'
        )";

        //Guardar en Kardex
            $sql_kardex="insert into kardex 
            (
            idcomprobante, 
            idarticulo, 
            transaccion, 
            codigo, 
            fecha, 
            tipo_documento, 
            numero_doc, 
            cantidad, 
            costo_1, 
            unidad_medida, 
            saldo_final, 
            costo_2,
            valor_final
            ) 
            values
            (
            '$idordennew',
            '$idarticulo[$num_elementos]',
            'O.SERVI.', 
            (select codigo from articulo where idarticulo='$idarticulo[$num_elementos]'), 
            '$fecha_emision', 
            '60',
            '$SerieReal-$numero_orden', 
            '$cantidad[$num_elementos]', 
            '',
            '',
            (select saldo_finu - '$cantidad[$num_elementos]' from articulo where idarticulo='$idarticulo[$num_elementos]') ,
            (select precio_final_kardex from articulo where idarticulo='$idarticulo[$num_elementos]'), saldo_final * costo_2
          )";

            //return ejecutarConsulta($sql);
            ejecutarConsulta($sql_detalle) or $sw = false;
            ejecutarConsulta($sql_kardex) or $sw = false;

      // SI EL NUMERO DE COMPROBANTE YA EXISTE NO HARA LA OPERACIon
      if ($idordennew==""){
      $sw=false;
      }
      else
      {
        //ACTUALIZA TABLA ARTICULOS
     $sql_update_articulo="update
      articulo set saldo_finu = saldo_finu - '$cantidad[$num_elementos]', 
      ventast = ventast + '$cantidad[$num_elementos]',
      valor_finu = (saldo_iniu + comprast - ventast) * costo_compra, 
      stock = saldo_finu, 
      valor_fin_kardex=(select valor_final from kardex where idarticulo='$idarticulo[$num_elementos]' and transaccion='ORDENSERVICIO' order by idkardex desc limit 1)
       where
       idarticulo = '$idarticulo[$num_elementos]'";
       ejecutarConsulta($sql_update_articulo) or $sw = false;

        }
            $num_elementos=$num_elementos + 1;
        } //Fin While

                //Para actualizar numeracion de las series de la factura
                 $sql_update_numeracion="update
                  numeracion 
                  set 
                  numero='$numero_orden' 
                  where 
                  idnumeracion='$idserie'";
                 ejecutarConsulta($sql_update_numeracion) or $sw = false;
                 //Fin

            return $sw;
}





//Implementamos un método para dar de baja a factura
public function baja($idfactura,$fecha_baja, $com, $hora)
{
        $sw=true;
$connect = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
mysqli_query( $connect, 'SET NAMES "'.DB_ENCODE.'"');
      //Si tenemos un posible error en la conexión lo mostramos
      if (mysqli_connect_errno())
      {
            printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
            exit();
      }

    $query="select idfactura, idarticulo  from detalle_fac_art where idfactura = '$idfactura'";
    $resultado = mysqli_query($connect,$query);

    $Idf=array();
    $Ida=array();
    $sw=true;

    while ($fila = mysqli_fetch_assoc($resultado)) {
    for($i=0; $i < count($resultado) ; $i++){
        $Idf[$i] = $fila["idfactura"];  
        $Ida[$i] = $fila["idarticulo"];  

    $sql_update_articulo="update detalle_fac_art de 
    inner join 
    articulo a  
    on de.idarticulo=a.idarticulo 
    set 
     a.saldo_finu=a.saldo_finu + de.cantidad_item_12, a.stock=a.stock + de.cantidad_item_12, a.ventast=a.ventast - de.cantidad_item_12, a.valor_finu=(a.saldo_finu + a.comprast - a.ventast) * a.costo_compra
    where 
    de.idfactura='$Idf[$i]' and de.idarticulo='$Ida[$i]'";
        
        
    //ACTUALIZAR TIPO TRANSACCIon KARDEX
    //Guardar en Kardex
    $sql_kardex="insert into kardex (idcomprobante, idarticulo, transaccion, codigo, fecha, tipo_documento, numero_doc, cantidad, costo_1, unidad_medida, saldo_final, costo_2,valor_final) 

            values 

            ('$idfactura', (select a.idarticulo from articulo a inner join detalle_fac_art dtf on a.idarticulo=dtf.idarticulo where a.idarticulo='$Ida[$i]' and dtf.idfactura = '$Idf[$i]'), 

            'ANULADO', 

            (select a.codigo from articulo a inner join detalle_fac_art dtf on a.idarticulo=dtf.idarticulo where a.idarticulo='$Ida[$i]' and dtf.idfactura = '$Idf[$i]'),

             (select fecha_emision_01 from factura where idfactura='$Idf[$i]'), 
             '01',
             (select numeracion_08 from factura where idfactura='$Idf[$i]'), 

             (select dtf.cantidad_item_12 from articulo a inner join detalle_fac_art dtf on a.idarticulo=dtf.idarticulo where a.idarticulo='$Ida[$i]' and dtf.idfactura = '$Idf[$i]'), 

             (select dtf.valor_uni_item_14 from articulo a inner join detalle_fac_art dtf on a.idarticulo=dtf.idarticulo where a.idarticulo='$Ida[$i]' and dtf.idfactura = '$Idf[$i]'),

             (select a.unidad_medida from articulo a inner join detalle_fac_art dtf on a.idarticulo=dtf.idarticulo where a.idarticulo='$Ida[$i]' and dtf.idfactura = '$Idf[$i]'),

             0, 0, 0)";
        }
        //Fin de FOR
         ejecutarConsulta($sql_update_articulo) or $sw=false;
         ejecutarConsulta($sql_kardex) or $sw=false; 
        }
        //Fin de WHILE


         $sqlestado="update factura set estado='3', fecha_baja='$fecha_baja $hora', comentario_baja='$com' where idfactura='$idfactura'";
        ejecutarConsulta($sqlestado) or $sw=false;

//***************************************************************************
//     require_once "../modelos/Factura.php";
//     $factura = new Factura();
//     $datos = $factura->datosemp();
//     $datose = $datos->fetch_object();

//     //Inclusion de la tabla RUTAS
//     require_once "../modelos/Rutas.php";
//     $rutas = new Rutas();
//     $Rrutas = $rutas->mostrar2();
//     $Prutas = $Rrutas->fetch_object();
//     $rutadata=$Prutas->rutadata; // ruta de la carpeta DATA
//     $rutabaja=$Prutas->rutabaja; // ruta de la carpeta BAJA
//     $rutadatalt=$Prutas->rutadatalt; // ruta de la carpeta BAJA


// $query = "select date_format(fecha_emision_01, '%Y-%m-%d') as fecha, 
// date_format(curdate(), '%Y%m%d') as fechabaja2, 
// date_format(fecha_baja, '%Y-%m-%d') as fechabaja, 
// right(substring_index(numeracion_08,'-',1),3) as serie,
// tipodocuCliente, 
// rucCliente, 
// RazonSocial, 
// tipo_moneda_28, 
// total_operaciones_gravadas_monto_18_2 as subtotal, 
// sumatoria_igv_22_1 as igv, 
// importe_total_venta_27 as total, 
// tipo_documento_07 as tipocomp, 
// numeracion_08 as numerodoc, 
// f.estado, 
// comentario_baja  
//   from 
//   factura f inner join persona p on f.idcliente=p.idpersona where f.idfactura='$idfactura'";  



//       //==================================================
//       $result = mysqli_query($connect, $query);  
//       //==================================================


// //==================FACTURA & BOLETAS================================

//        //$mask = $rutabaja.'*';
//        //array_map( "unlink", glob( $mask ) );


//       $fecha=array();
//       $tipocomp=array();
//       $numdocu=array();
//       $rasoc=array();
//       $fechabaja=array();
//       $numeroc=array();
//       $comen=array();
            
//       $con=0;
//       $fecdeldia=date ("Ymd");  
            
//       while($row=mysqli_fetch_assoc($result)){
//       for($i=0; $i <= count($result); $i++){
//            $fecha[$i]=$row["fecha"];
//            $fechabaja[$i]=$row["fechabaja"];
//            $tipocomp[$i]=$row["tipocomp"];
//            $numeroc[$i]=$row["numerodoc"];
//            $comen[$i]=$row["comentario_baja"];
//            $ruc=$datose->numero_ruc;
//            $fbaja2=$row["fechabaja2"];

//            $path=$rutadata.$ruc."-RA-".$fbaja2."-011.cba";
//             $handle=fopen($path, "a");
//            fwrite($handle, $fecha[$i]."|".$fechabaja[$i]."|".$tipocomp[$i]."|".$numeroc[$i]."|".$comen[$i]."|\r\n"); 
//            fclose($handle);

//            $path=$rutadatalt.$ruc."-RA-".$fbaja2."-011.cba";
//             $handle=fopen($path, "a");
//            fwrite($handle, $fecha[$i]."|".$fechabaja[$i]."|".$tipocomp[$i]."|".$numeroc[$i]."|".$comen[$i]."|\r\n"); 
//            fclose($handle);
           
//            $i=$i+1;
//            $con=$con+1;           
//       }
//     }
//**************************************************************************

    return $sw;    

}

//Implementamos un método para dar de baja a factura
public function ActualizarEstado($idfactura,$st)
{
        $sw=true;
        $sqlestado="update factura set estado='$st' where idfactura='$idfactura'";
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

    $query="select idfactura, idarticulo  from detalle_fac_art where idfactura = '$idfactura'";
    $resultado = mysqli_query($connect,$query);

    $Idf=array();
    $Ida=array();
    $sw=true;

    while ($fila = mysqli_fetch_assoc($resultado)) {
    for($i=0; $i < count($resultado) ; $i++){
        $Idf[$i] = $fila["idfactura"];  
        $Ida[$i] = $fila["idarticulo"];  

    $sql_update_articulo="update detalle_fac_art de 
    inner join 
    articulo a  
    on de.idarticulo=a.idarticulo 
    set 
     a.saldo_finu=a.saldo_finu + de.cantidad_item_12, a.stock=a.stock + de.cantidad_item_12, a.ventast=a.ventast - de.cantidad_item_12, a.valor_finu=(a.saldo_finu + a.comprast - a.ventast) * a.costo_compra
    where 
    de.idfactura='$Idf[$i]' and de.idarticulo='$Ida[$i]'";
        
        
    //ACTUALIZAR TIPO TRANSACCIon KARDEX
    //Guardar en Kardex
    $sql_kardex="insert into kardex (idcomprobante, idarticulo, transaccion, codigo, fecha, tipo_documento, numero_doc, cantidad, costo_1, unidad_medida, saldo_final, costo_2,valor_final) 

            values 

            ('$idfactura', (select a.idarticulo from articulo a inner join detalle_fac_art dtf on a.idarticulo=dtf.idarticulo where a.idarticulo='$Ida[$i]' and dtf.idfactura = '$Idf[$i]'), 

            'ANULADO', 

            (select a.codigo from articulo a inner join detalle_fac_art dtf on a.idarticulo=dtf.idarticulo where a.idarticulo='$Ida[$i]' and dtf.idfactura = '$Idf[$i]'),

             (select fecha_emision_01 from factura where idfactura='$Idf[$i]'), 
             '01',
             (select numeracion_08 from factura where idfactura='$Idf[$i]'), 

             (select dtf.cantidad_item_12 from articulo a inner join detalle_fac_art dtf on a.idarticulo=dtf.idarticulo where a.idarticulo='$Ida[$i]' and dtf.idfactura = '$Idf[$i]'), 

             (select dtf.valor_uni_item_14 from articulo a inner join detalle_fac_art dtf on a.idarticulo=dtf.idarticulo where a.idarticulo='$Ida[$i]' and dtf.idfactura = '$Idf[$i]'),

             (select a.unidad_medida from articulo a inner join detalle_fac_art dtf on a.idarticulo=dtf.idarticulo where a.idarticulo='$Ida[$i]' and dtf.idfactura = '$Idf[$i]'),

             0, 0, 0)";
        }

        $sqlestado="update factura  set estado='0' where idfactura='$idfactura'";

        //Fin de FOR
         ejecutarConsulta($sql_update_articulo) or $sw=false;
         ejecutarConsulta($sql_kardex) or $sw=false; 
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
        factura f inner join persona p on f.idcliente=p.idpersona inner join usuario u on f.idusuario=u.idusuario where f.idfactura='$idfactura'";
        return ejecutarConsultaSimpleFila($sql);
    }

    
    public function enviarcorreo($idfactura)
    {

    require_once "../modelos/Factura.php";
    $factura = new Factura();
    $datos = $factura->correo();
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
        $sql="select df.idfactura,df.idarticulo,a.nombre,df.cantidad_item_12, df.valor_uni_item_14, df.valor_venta_item_21, df.igv_item from detalle_fac_art df inner join articulo a on df.idarticulo=a.idarticulo where df.idfactura='$idfactura'";
        return ejecutarConsulta($sql);
    }
 
    //Implementar un método para listar los registros
    public function listar()
    {
        $sql="select os.idorden, os.idusuario, os.serienumero, os.idproveedor, date_format(os.fechaemision,'%d-%m-%Y') as fechaemision, os.formapago, os.formaentrega, os.idempresa, date_format(os.fechaentrega, '%d-%m-%Y') as fechaentrega, os.anotaciones, os.subtotal, os.igv, os.total, os.estado, p.razon_social from ordenservicio os inner join persona p on os.idproveedor=p.idpersona  order by os.idorden desc";
        return ejecutarConsulta($sql);  

    }


    public function ventacabecera($idorden){
        $sql="select 
        o.idorden,
        p.nombre_comercial, 
        o.idusuario, 
        o.serienumero, 
       date_format(o.fechaemision, '%d-%m-%Y') as fechaemision , 
        o.formapago, 
        o.formaentrega, 
        date_format(o.fechaentrega, '%d-%m-%Y') as fechaentrega , 
        o.anotaciones, 
        o.subtotal, 
        o.igv,
        o.total,
        p.razon_social,
        p.numero_documento,
        p.domicilio_fiscal as direccion,
        o.estado
          from
          ordenservicio o inner join detalle_ordenservicio_articulo dos on o.idorden=dos.idorden inner join articulo a on dos.idarticulo=a.idarticulo inner join persona p on o.idproveedor=p.idpersona where o.idorden='$idorden'";
        return ejecutarConsulta($sql);
    }

    

    public function ventadetalle($idorden){
        $sql="select  
        a.nombre as articulo, 
        a.codigo, 
        format(dos.cantidad,2) as cantidad,
        dos.valorcosto, 
        dos.totalunitario,
        dos.descripcion
        from 
        detalle_ordenservicio_articulo  dos inner join articulo a on dos.idarticulo=a.idarticulo where dos.idorden='$idorden'";
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


public function downftp($idfactura){    

    //Inclusion de la tabla RUTAS
    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2();
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
        factura f inner join persona p on 
        f.idcliente=p.idpersona inner join empresa e on 
        f.idempresa=e.idempresa 
        where 
        f.idfactura='$idfactura' ";
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
    $cabext=$rutadata.$archivoFacturaData.'.cab';
    $detext=$rutadata.$archivoFacturaData.'.det';
    $leyext=$rutadata.$archivoFacturaData.'.ley';
    $triext=$rutadata.$archivoFacturaData.'.tri';

    $ficheroData = file_get_contents($url);

    $cab=$archivoFacturaData.'.cab';
    $det=$archivoFacturaData.'.det';
    $ley=$archivoFacturaData.'.ley';
    $tri=$archivoFacturaData.'.tri';

    $rpta = array ('cabext'=>$cabext,'cab'=>$cab,
                   'detext'=>$detext, 'det'=>$det,
                   'leyext'=>$leyext, 'ley'=>$ley,
                   'triext'=>$triext, 'tri'=>$tri
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