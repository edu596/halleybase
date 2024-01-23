<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Cotizacion
{

    //Implementamos nuestro constructor
    public function __construct()
    {
 

    }


public function insertarTc($fechatc, $compra, $venta)
    {
        $sql="insert into tcambio (fecha, compra, venta)
        values ('$fechatc', '$compra', '$venta')";
        return ejecutarConsulta($sql);
    }

  //Implementamos un método para editar registros
  public function editarTc($id, $fechatc, $compra, $venta)
  {
        $sql="update tcambio  set fecha='$fechatc', compra='$compra', venta='$venta' where idtipocambio='$id' ";
        return ejecutarConsulta($sql);
  }

 
 
    //Implementamos un método para insertar registros para factura
    public function insertar($idempresa, $idusuario, $idcliente, $serienota, 
      $moneda, $fechaemision, $hora, $tipocotizacion, $subtotal, $impuesto, 
      $total, $observacion, $vendedor, $idarticulo, $codigo, $cantidad, 
      $precio_unitario, $numero_cotizacion, $idserie, $descdet, $norden, 
      $fechavalidez, $tcambio, $valorventa, $valorunitario, $igvitem, $igventa)
    {

        
        $sql="insert into 
        cotizacion
         (  
            idempresa,
            idusuario, 
            idcliente, 
            serienota, 
            moneda, 
            fechaemision, 
            tipocotizacion, 
            subtotal, 
            impuesto, 
            total, 
            observacion, 
            vendedor,
            tipocambio,
            fechavalidez
          )
          values
          (
          '$idempresa',
          '$idusuario',
          '$idcliente',
          '$serienota',
          '$moneda',
          '$fechaemision $hora',
          '$tipocotizacion',
          '$subtotal',
          '$impuesto',
          '$total',
          '$observacion',
          '$vendedor',
          '$tcambio',
          '$fechavalidez'
        )";
        //return ejecutarConsulta($sql);
        $idcotizacionnew=ejecutarConsulta_retornarID($sql);
        

        $num_elementos=0;
        $sw=true;

        while ($num_elementos < count($idarticulo))
        {
            //Guardar en Detalle
        $sql_detalle = "insert into 
        detalle_articulo_cotizacion
        (
        idcotizacion, 
        iditem, 
        codigo, 
        cantidad, 
        precio,
        descdet,
        norden,
        valorventa,
        valorunitario,
        igvvalorventa,
        igvitem
          ) 
          values 
          (
          '$idcotizacionnew', 
          '$idarticulo[$num_elementos]',
          '$codigo[$num_elementos]',
          '$cantidad[$num_elementos]',
          '$precio_unitario[$num_elementos]',
          '$descdet[$num_elementos]',
          '$norden[$num_elementos]',
          '$valorventa[$num_elementos]',
          '$valorunitario[$num_elementos]',
          '$igventa[$num_elementos]',
          '$igvitem[$num_elementos]'
        )";

         //Para actualizar numeracion de las series de la factura
         $sql_update_numeracion="update 
         numeracion 
         set 
         numero='$numero_cotizacion' where idnumeracion='$idserie'";
        ejecutarConsulta($sql_update_numeracion) or $sw = false;
         //Fin 

          //$sqlupdatecorreocliente="update persona set email='$email', domicilio_fiscal='$domicilio_fiscal2', razon_social='$RazonSocial', nombre_comercial='$RazonSocial'   where idpersona='$idcliente'";

            //return ejecutarConsulta($sql);
            ejecutarConsulta($sql_detalle) or $sw = false;
           //ejecutarConsulta($sqlupdatecorreocliente) or $sw = false;

      $num_elementos=$num_elementos + 1;
      
      }  


       $sqldetallesesionusuario="insert into detalle_usuario_sesion 
              (idusuario, tcomprobante, idcomprobante, fechahora) 
               values 
              ('$idusuario', 'COTI','$idcotizacionnew', now())";
                 ejecutarConsulta($sqldetallesesionusuario);


return $idcotizacionnew; //FIN DE LA FUNCION

}








public function mostrarultimocomprobante($idempresa)
  {
    $sql="select numeracion_08 from factura f inner join empresa e on f.idempresa=e.idempresa  where e.idempresa='$idempresa'  order by idfactura desc limit 1";
    return ejecutarConsultaSimpleFila($sql);    
  }


public function crearPDF($idfactura, $idempresa)
{
require('Factura.php');
//Obtenemos los datos de la cabecera de la venta actuall
require_once "../modelos/Factura.php";
$factura = new Factura();
$rsptav = $factura->ventacabecera($idfactura, $idempresa);
$datos = $factura->datosemp($idempresa);
//Recorremos todos los valores obtenidos
$regv = $rsptav->fetch_object();
$datose = $datos->fetch_object();
$logo = "../files/logo/".$datose->logo;
$ext_logo = substr($datose->logo, strpos($datose->logo,'.'),-4);
//Establecemos la configuración de la factura
$pdf = new PDF_Invoice( 'P', 'mm',  'A4' );
$pdf->AddPage();
#Establecemos los márgenes izquierda, arriba y derecha: 
$pdf->SetMargins(10, 10 , 10); 
#Establecemos el margen inferior: 
$pdf->SetAutoPageBreak(true,10); 
//Enviamos los datos de la empresa al método addSociete de la clase Factura
$pdf->addSociete(utf8_decode(htmlspecialchars_decode($datose->nombre_comercial)),utf8_decode("Dirección    : ").utf8_decode($datose->domicilio_fiscal)."\n".utf8_decode("Teléfono     : ").$datose->telefono1." - ".$datose->telefono2."\n" ."Email          : ".$datose->correo, $logo, $ext_logo);
$pdf->numFactura("$regv->numeracion_08" , "$datose->numero_ruc");
$pdf->RotatedText($regv->estado, 35,190,'ANULADO - DADO DE BAJA',45);
$pdf->temporaire( "" );
//Enviamos los datos del cliente al método addClientAdresse de la clase Factura
$pdf->addClientAdresse( $regv->fecha."   /  Hora: ".$regv->hora,    utf8_decode(htmlspecialchars_decode($regv->cliente)), $regv->numero_documento, utf8_decode($regv->direccion), $regv->estado, utf8_decode($regv->vendedorsitio), utf8_decode($regv->guia) );
if ($regv->nombretrib=="IGV") {
        $nombret="V.U.";
    }else{
        $nombret="PRECIO";
    }
//Establecemos las columnas que va a tener la sección donde mostramos los detalles de la venta
$cols=array( "CODIGO"=>23,
             "DESCRIPCION"=>78,
             "CANTIDAD"=>22,
             $nombret=>25,
             "DSCTO"=>20,
             "SUBTOTAL"=>22);
$pdf->addCols( $cols);
$cols=array( "CODIGO"=>"L",
             "DESCRIPCION"=>"L",
             "CANTIDAD"=>"C",
             $nombret=>"R",
             "DSCTO" =>"R",
             "SUBTOTAL"=>"C");
$pdf->addLineFormat( $cols);
$pdf->addLineFormat($cols); 
//Actualizamos el valor de la coordenada "y", que será la ubicación desde donde empezaremos a mostrar los datos
$y= 62;
//Obtenemos todos los detalles de la venta actual
$rsptad = $factura->ventadetalle($idfactura);
 
while ($regd = $rsptad->fetch_object()) {
    if ($regd->nombretribu=="IGV") {
        $pv=$regd->valor_uni_item_14;
        $subt=$regd->subtotal;
    }else{
        $pv=$regd->precio;
        $subt=$regd->subtotal2;
    }
  $line = array( "CODIGO"=> "$regd->codigo",
                "DESCRIPCION"=> utf8_decode("$regd->articulo"),
                "CANTIDAD"=> "$regd->cantidad_item_12"." "."$regd->unidad_medida",
                $nombret=> $pv,
                "DSCTO" => "$regd->descuento",
                "SUBTOTAL"=> $subt);
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
$dataTxt=$regv->numero_ruc."|".$regv->tipo_documento_07."|".$regv->serie."|".$regv->numerofac."|".$regv->sumatoria_igv_22_1."|".$regv->importe_total_venta_27."|".$regv->fecha2."|".$regv->tipo_documento."|".$regv->numero_documento."|";
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
$pdf->ImgQr($logoQr, $ext_logoQr);
//======= PARA EXTRAER EL HASH DEL DOCUMENTO FIRMADO ========================================
//Convertimos el total en letras
require_once "Letras.php";
$V=new EnLetras(); 
$con_letra=strtoupper($V->ValorEnLetras($regv->importe_total_venta_27,"CON"));
$pdf->addCadreTVAs("".$con_letra);
$pdf->observSunat($regv->numeracion_08,$regv->estado, $data[0], $datose->webconsul,  $datose->nresolucion);
//Mostramos el impuesto
$pdf->addTVAs( $regv->sumatoria_igv_22_1 , $regv->importe_total_venta_27,"S/ ", $regv->tdescuento);
$pdf->addCadreEurosFrancs($regv->sumatoria_igv_22_1, $regv->nombretrib);
//===============SEGUNDA COPIA DE FACTURA=========================
//Enviamos los datos de la empresa al método addSociete de la clase Factura
$pdf->addSociete2(utf8_decode(htmlspecialchars_decode($datose->nombre_comercial)),utf8_decode("Dirección: ").utf8_decode($datose->domicilio_fiscal)."\n".utf8_decode("Teléfono: ").$datose->telefono1." - ".$datose->telefono2."\n" ."Email : ".$datose->correo, $logo, $ext_logo);
//Datos de la empresa
$pdf->numFactura2("$regv->numeracion_08" , "$datose->numero_ruc" );
$pdf->temporaire( "" );
////Enviamos los datos del cliente al método addClientAdresse de la clase Factura
$pdf->addClientAdresse2( $regv->fecha."   /  Hora: ".$regv->hora, utf8_decode($regv->cliente), $regv->numero_documento, utf8_decode($regv->direccion), $regv->estado, utf8_decode($regv->vendedorsitio), utf8_decode($regv->guia));
if ($regv->nombretrib=="IGV") {

        $nombret="V.U.";
    }else{
        $nombret="PRECIO";
    }

//Establecemos las columnas que va a tener la sección donde mostramos los detalles de la venta
$cols=array( "CODIGO"=>23,
             "DESCRIPCION"=>78,
             "CANTIDAD"=>22,
             $nombret=>25,
             "DSCTO"=>20,
             "SUBTOTAL"=>22);
$pdf->addCols2( $cols);
$cols=array( "CODIGO"=>"L",
             "DESCRIPCION"=>"L",
             "CANTIDAD"=>"C",
             $nombret=>"R",
             "DSCTO" =>"R",
             "SUBTOTAL"=>"C");
$pdf->addLineFormat2( $cols);
$pdf->addLineFormat2($cols);
//Actualizamos el valor de la coordenada "y", que será la ubicación desde donde empezaremos a mostrar los datos
$y2= 208; // para el tamaño del cuadro del segundo detalle
//Obtenemos todos los detalles de la venta actual
$rsptad = $factura->ventadetalle($idfactura);
while ($regd = $rsptad->fetch_object()) {
  if ($regd->nombretribu=="IGV") {
        $pv=$regd->valor_uni_item_14;
        $subt=$regd->subtotal;
    }else{
        $pv=$regd->precio;
        $subt=$regd->subtotal2;
    }
  $line = array( "CODIGO"=> "$regd->codigo",
                "DESCRIPCION"=> utf8_decode("$regd->articulo"." - "."$regd->descdet"),
                "CANTIDAD"=> "$regd->cantidad_item_12"." "."$regd->unidad_medida",
                $nombret=> $pv,
                "DSCTO" => "$regd->descuento",
                "SUBTOTAL"=> $subt);
            $size2 = $pdf->addLine2( $y2, $line );
            $y2   += $size2 + 2;
}

$V=new EnLetras(); 
$con_letra=strtoupper($V->ValorEnLetras($regv->importe_total_venta_27,"CON"));
$pdf->addCadreTVAs2("".$con_letra);
$pdf->observSunat2($regv->numeracion_08,$regv->estado,$data[0], $datose->webconsul, $datose->nresolucion);
//Mostramos el impuesto
$pdf->addTVAs2( $regv->sumatoria_igv_22_1, $regv->importe_total_venta_27,"S/ ", $regv->tdescuento);
$pdf->addCadreEurosFrancs2($regv->sumatoria_igv_22_1, $regv->nombretrib);
//Linea para guardar la factura en la carpeta facturas PDF
//$Factura=$pdf->Output($regv->numeracion_08.'.pdf','I');
$Factura=$pdf->Output('../facturasPDF/'.$regv->numeracion_08.'.pdf','F');
}













//Implementamos un método para dar de baja a factura
public function baja($idcotizacion)
{
          $sw=true;
          $sqlestado="update cotizacion set estado='3'  where idcotizacion='$idcotizacion'";
         ejecutarConsulta($sqlestado) or $sw=false;

   


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

    
    public function enviarcorreo($idfactura, $idempresa)
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
        f.idfactura='$idfactura' and e.idempresa='$idempresa' ";

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
  $mail->isSMTP();  
  //$mail -> SMTPDebug  =  2 ;                       // Establecer el correo electrónico para utilizar SMTP
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
          (select numeracion_08 from factura f inner join persona p on f.idcliente=p.idpersona where f.idfactura='$idfactura'),
          now()
        )";
        //return ejecutarConsulta($sql);
        $enviarcorreo=ejecutarConsulta($sql);
//Guardar en tabla envicorreo =========================================



}


    
 
    //Implementar un método para listar los registros
    public function listar($idempresa)
    {
        $sql="select 
        c.idcotizacion,
        date_format(c.fechaemision,'%d/%m/%y') as fecha,
        c.idcliente,
        p.razon_social as cliente,
        c.vendedor,
        u.nombre as usuario,
        c.serienota,
        format(c.total,2)as total ,
        c.impuesto,
        c.estado,
        e.numero_ruc,
        p.email,
        c.nrofactura,
        c.moneda
        from 
        cotizacion c inner join persona p on c.idcliente=p.idpersona 
        inner join usuario u on c.idusuario=u.idusuario 
        inner join empresa e on c.idempresa=e.idempresa

         where
        e.idempresa='$idempresa' 
        order by idcotizacion desc";
        return ejecutarConsulta($sql);  

    }

     

     public function listarDR($ano, $mes, $idempresa)
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
        inner join empresa e on f.idempresa=e.idempresa where  year(f.fecha_emision_01)='$ano' and month(f.fecha_emision_01)='$mes' and f.estado in ('0','3') and e.idempresa='$idempresa'
        order by idfactura desc";
        return ejecutarConsulta($sql);  
    }

     public function listarDRdetallado($idcomp, $idempresa)
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
        where f.idfactura='$idcomp'  and e.idempresa='$idempresa'";
        return ejecutarConsulta($sql);  

    }


    public function ventacabecera($idcotizacion, $idempresa){
        $sql="select 
        c.idcotizacion, 
        c.idcliente, 
        p.razon_social as cliente, 
        p.domicilio_fiscal as direccion, 
        p.tipo_documento, 
        p.numero_documento, 
        p.email, 
        p.telefono1, 
        p.nombre_comercial, 
        c.idusuario, 
        concat(u.nombre,' ',u.apellidos) as usuario, 
        c.serienota, 
        date_format(c.fechaemision,'%d-%m-%Y') as fecha, 
        date_format(c.fechaemision,'%Y-%m-%d') as fecha2,
        date_format(c.fechaemision, '%H:%i:%s') as hora, 
        c.impuesto, 
        c.total, 
        c.estado,
        e.numero_ruc, 
        c.subtotal,
        c.vendedor,
        c.tipocotizacion,
        c.observacion,
        c.moneda,
        c.tipocambio,
        if(c.moneda='USD', c.tipocambio * c.total, c.total) as conversion,
        c.fechavalidez,
        c.nrofactura
        from
          cotizacion c inner join persona p on c.idcliente=p.idpersona inner join empresa e 
          on e.idempresa=c.idempresa inner join  usuario u on c.idusuario=u.idusuario 
          where c.idcotizacion='$idcotizacion' and e.idempresa='$idempresa'";
        return ejecutarConsulta($sql);
    }

    

    public function ventadetalle($idcotizacion, $tipocotizacion){

      if ($tipocotizacion=='productos') {
        $sql="select  
        a.nombre as articulo, 
        a.codigo, 
        format(dac.cantidad,2) as cantidad, 
        dac.precio , 
        format(dac.cantidad * dac.precio,2) as subtotal, 
        a.unidad_medida,
        um.nombreum,
        dac.norden,
        um.abre
        from 
        detalle_articulo_cotizacion dac inner join articulo a on dac.iditem=a.idarticulo inner join umedida um on a.unidad_medida=um.idunidad
        where 
        dac.idcotizacion='$idcotizacion'";
      }else{

         $sql="select  
        s.descripcion as articulo, 
        s.codigo, 
        format(dac.cantidad,2) as cantidad, 
        dac.precio, 
        format(dac.cantidad * dac.precio,2) as subtotal, 
        dac.norden
        from 
        detalle_articulo_cotizacion dac inner join servicios_inmuebles s on dac.iditem=s.id where dac.idcotizacion='$idcotizacion'";

      }
        
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

    public function datosemp($idempresa)
    {

    $sql="select * from empresa where idempresa='$idempresa'";
    return ejecutarConsulta($sql);      
    }

     public function tributo()
    {

    $sql="select * from catalogo5 where estado='1'";
    return ejecutarConsulta($sql);      
    }

    public function afectacionigv()
    {

    $sql="select * from catalogo7";
    return ejecutarConsulta($sql);      
    }

    public function correo()
    {

    $sql="select * from correo";
    return ejecutarConsulta($sql);      
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


      public function tipodecambio($diaa)
      {

           

      }


          public function editar($idcotizacion)
    {
        $sql="select 
        c.idcotizacion, c.idcliente, c.idusuario, substring(c.serienota,6) as numeroc, substring(c.serienota,1,4) as serie,
        c.moneda, date_format(c.fechaemision, '%Y-%m-%d') as fechaemision,  c.tipocotizacion, c.subtotal, c.impuesto, c.total, 
        c.observacion, c.estado, c.tipocambio, date_format(c.fechavalidez, '%Y-%m-%d') as fechavalidez, p.numero_documento as ruc, p.nombre_comercial, p.email, p.domicilio_fiscal, c.serienota, c.estado  
        from  
        cotizacion c  inner join persona p on c.idcliente=p.idpersona  inner join detalle_articulo_cotizacion dc on dc.idcotizacion=c.idcotizacion inner join articulo a on dc.iditem=a.idarticulo  where c.idcotizacion='$idcotizacion'";
        return ejecutarConsultaSimpleFila($sql);
    }



    public function listarDetallecotizacion($idcotizacion)
    {
        $sql="select 
        a.idarticulo, 
        a.nombre as narticulo, 
        dct.cantidad, 
        a.codigo, 
        a.unidad_medida, 
        dct.precio as precioc, 
        dct.valorunitario, 
        c.subtotal, 
        c.impuesto, 
        c.total, 
        dct.valorventa, 
        dct.norden from 
        detalle_articulo_cotizacion dct inner join articulo a on dct.iditem=a.idarticulo  
        inner join cotizacion c on c.idcotizacion=dct.idcotizacion where dct.idcotizacion='$idcotizacion'";
        return ejecutarConsulta($sql);
    }


public function listarnumerofilas($idcotizacion)
    {
        $sql="select  count(dct.iditem) as cantifilas  from 
        detalle_articulo_cotizacion dct inner join articulo a on dct.iditem=a.idarticulo  
        inner join cotizacion c on c.idcotizacion=dct.idcotizacion where dct.idcotizacion='$idcotizacion'";
        return ejecutarConsultaSimpleFila($sql);
    }


   //Implementamos un método para insertar registros para factura
    public function editarcotizacion($idcotizacion, $idempresa, $idusuario, $idcliente, $serienota, 
      $moneda, $fechaemision, $hora, $tipocotizacion, $subtotal, $impuesto, 
      $total, $observacion, $vendedor, $idarticulo, $codigo, $cantidad, 
      $precio_unitario, $numero_cotizacion, $idserie, $descdet, $norden, 
      $fechavalidez, $tcambio, $valorventa, $valorunitario, $igvitem, $igventa, $estado)
    {

          $sw=true;

        $sqleditarcabecera="
            update cotizacion 
            set
            idcliente='$idcliente', 
            moneda='$moneda', 
            fechaemision='$fechaemision $hora', 
            subtotal='$subtotal', 
            impuesto='$impuesto', 
            total='$total', 
            observacion='$observacion', 
            vendedor='$vendedor',
            tipocambio='$tcambio',
            fechavalidez='$fechavalidez',
            estado='$estado'
            where 
            idcotizacion='$idcotizacion'";
        
        ejecutarConsulta($sqleditarcabecera) or $sw = false;
        

        $num_elementos=0;
      
        $deldetalle="delete from detalle_articulo_cotizacion where idcotizacion='$idcotizacion'";
        ejecutarConsulta($deldetalle) or $sw = false;


        while ($num_elementos < count($idarticulo))
        {
            //Guardar en Detalle
        // $sql_detalle = "update  
        // detalle_articulo_cotizacion
        // set 
        // codigo='$codigo[$num_elementos]', 
        // cantidad='$cantidad[$num_elementos]', 
        // precio='$precio_unitario[$num_elementos]',
        // descdet='$descdet[$num_elementos]',
        // norden='$norden[$num_elementos]',
        // valorventa='$valorventa[$num_elementos]',
        // valorunitario='$valorunitario[$num_elementos]',
        // igvvalorventa='$igventa[$num_elementos]',
        // igvitem='$igvitem[$num_elementos]'
        // where 
        // iditem='$idarticulo[$num_elementos]'
        // and
        // idcotizacion='$idcotizacion'";

        $sql_detalle="insert into 
        detalle_articulo_cotizacion
        (
        idcotizacion, 
        iditem, 
        codigo, 
        cantidad, 
        precio,
        descdet,
        norden,
        valorventa,
        valorunitario,
        igvvalorventa,
        igvitem
          ) 
          values 
          (
          '$idcotizacion', 
          '$idarticulo[$num_elementos]',
          '$codigo[$num_elementos]',
          '$cantidad[$num_elementos]',
          '$precio_unitario[$num_elementos]',
          '$descdet[$num_elementos]',
          '$norden[$num_elementos]',
          '$valorventa[$num_elementos]',
          '$valorunitario[$num_elementos]',
          '$igventa[$num_elementos]',
          '$igvitem[$num_elementos]'
        )";

          //$sqlupdatecorreocliente="update persona set email='$email', domicilio_fiscal='$domicilio_fiscal2', razon_social='$RazonSocial', nombre_comercial='$RazonSocial'   where idpersona='$idcliente'";
          //return ejecutarConsulta($sql);

         ejecutarConsulta($sql_detalle) or $sw = false;
         //ejecutarConsulta($sqlupdatecorreocliente) or $sw = false;

      $num_elementos=$num_elementos + 1;
      
      }    
    return $sw; //FIN DE LA FUNCION
    }



    public function estado()
  {
    $sql="select estado from 
    cotizacion where idcotizacion='$idcotizacion'";
    return ejecutarConsulta($sql);    
  }



  public function traercotizacion($idcotizacionI){

        $sql="select 
        date_format(c.fechaemision, '%Y-%m-%d') as fechaemi, 
        date_format(c.fechaemision, '%H:%i:%s') as hora,
        c.moneda, 
        c.tipocambio, 
        p.idpersona, 
        p.tipo_documento,
        p.email,
        p.numero_documento as ruc, 
        p.nombre_comercial, 
        p.domicilio_fiscal, 
        c.subtotal as neta, 
        c.impuesto as igv, 
        c.total,
        c.serienota,
        c.observacion,
        c.tipocotizacion
        from 
        cotizacion c inner join persona p on c.idcliente=p.idpersona where idcotizacion='$idcotizacionI'";
        return ejecutarConsultaSimpleFila($sql);      
    }


    public function listarDetalleCoti($idcotizacion)
    {
        $sql="select 
        dc.id, 
        dc.norden, 
        dc.iditem, 
        a.idarticulo, 
        a.nombre as narticulo, 
        dc.descdet, 
        dc.cantidad, 
        a.codigo, 
        a.unidad_medida, 
        dc.precio as precioc, 
        dc.igvvalorventa, 
        dc.igvitem, 
        dc.valorunitario, 
        dc.valorventa, 
        c.subtotal, 
        c.impuesto, 
        c.total,
        ((a.stock/a.factorc) - (a.stock - dc.cantidad) / a.factorc) as cantidadreal,
        um.abre,
        um.nombreum

        from 
        detalle_articulo_cotizacion dc inner join articulo a on dc.iditem=a.idarticulo inner join cotizacion c on dc.idcotizacion=c.idcotizacion inner join umedida um on um.idunidad=a.unidad_medida
        where 
        dc.idcotizacion='$idcotizacion'";
        return ejecutarConsulta($sql);


        
    }


    public function almacenlista()
    {

    $sql="select * from almacen where idalmacen='2' order by idalmacen";
    return ejecutarConsulta($sql);      
    }



    public function mostrarultimocomprobanteId($idempresa)

  {

    $sql="select 
    c.idcotizacion, e.tipoimpresion
    from 
    cotizacion c inner join empresa e on c.idempresa=e.idempresa  
    where 
    e.idempresa='$idempresa' order by idcotizacion desc limit 1";

    return ejecutarConsultaSimpleFila($sql);    

  }


 
       
    }
?>