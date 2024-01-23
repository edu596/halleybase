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
$destino=$_POST['destino'];

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

    //Inclusion de la tabla RUTAS
    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($_SESSION['idempresa']);
    $Prutas = $Rrutas->fetch_object();
    $rutadata=$Prutas->rutadata; // ruta de la carpeta DATA
    $rutabaja=$Prutas->rutabaja; // ruta de la carpeta BAJA
    $rutadescargas=$Prutas->rutadescargas; // ruta de la carpeta BAJA


$query = "select 
date_format(fechahoy, '%Y%m%d') as fechaactual, 
date_format(fecha, '%Y-%m-%d') as fecha, 
date_format(fecha, '%Y%m%d') as fechabaja2, 
date_format(fecha, '%Y-%m-%d') as fechabaja, 
right(substring_index(serie,'-',1),3) as serie,
right(substring_index(serie,'-',1),4) as serie2,
right(substring_index(numerodoc,'-',-1),10) as numerodoc2,
tipodocuCliente, 
rucCliente, 
RazonSocial, 
tmoneda, 
subtotal, 
igv, 
total, 
tipocomp as tipocomp, 
numerodoc as numerodoc, 
est, 
comentario_baja  
  from 
  (select
  curdate() as fechahoy, 
fecha_emision_01 as fecha, 
numeracion_08 as serie,
tipodocuCliente, 
rucCliente, 
RazonSocial, 
tipo_moneda_28 as tmoneda, 
total_operaciones_gravadas_monto_18_2 as subtotal, 
sumatoria_igv_22_1 as igv, 
importe_total_venta_27 as total, 
tipo_documento_07 as tipocomp, 
numeracion_08 as numerodoc, 
f.estado as est, 
comentario_baja from factura f inner join persona p on f.idcliente=p.idpersona 
where year(fecha_baja)='$ano' and month(fecha_baja)='$mes' and day(fecha_baja)='$dia' and f.estado='3'
   union all 
   select
curdate() as fechahoy, 
fecha, 
numeroserienota as serie,
tipo_doc_ide as tipodocuCliente, 
numero_doc_ide as rucCliente, 
razon_social as RazonSocial, 
tipo_moneda as tmoneda, 
total_val_venta_og as subtotal, 
sum_igv as igv, 
importe_total as total, 
codigo_nota as tipocomp, 
numeroserienota as numerodoc, 
n.estado as est, 
comentario_baja from notacd n 
where year(fecha_baja)='$ano' and month(fecha_baja)='$mes' and day(fecha_baja)='$dia' and n.estado='3'
) as tabla";  



      //==================================================
      $result = mysqli_query($connect, $query);  
      //==================================================
//==================FACTURA ================================

        $mask = $rutabaja.'*';
        array_map( "unlink", glob( $mask ) );
      $fecha=array();
      $tipocomp=array();
      $numdocu=array();
      $rasoc=array();
      $fechabaja=array();
      $numeroc=array();
      $comen=array();
      $serie=array();
      $numeroc2=array();
            
      $con=0;
      $fecdeldia=date ("Ymd");  
            
      while($row=mysqli_fetch_assoc($result)){
      for($i=0; $i <= count($result); $i++){
           $fecha[$i]=$row["fecha"];
           $fechabaja[$i]=$row["fechabaja"];
           $tipocomp[$i]=$row["tipocomp"];
           $numeroc[$i]=$row["numerodoc"];
           $comen[$i]=$row["comentario_baja"];
           $ruc=$datose->numero_ruc;
           $fbaja2=$row["fechabaja2"];
           $serie[$i]=$row["serie2"];
           $numeroc2[$i]=$row["numerodoc2"];
           $fechaactual=$row["fechaactual"];
           
           $path=$rutabaja.$ruc."-RA-".$fbaja2."-001.cba";
           
           // $cab=$rutadata.$ruc."-".$tipocomp[$i]."-".$numeroc[$i].".cab";
           // $det=$rutadata.$ruc."-".$tipocomp[$i]."-".$numeroc[$i].".det";
           // $tri=$rutadata.$ruc."-".$tipocomp[$i]."-".$numeroc[$i].".tri";
           // $ley=$rutadata.$ruc."-".$tipocomp[$i]."-".$numeroc[$i].".ley";
           // unlink($cab);
           // unlink($det);
           // unlink($tri);
           // unlink($ley);
           $handle=fopen($path, "a");
           //unlink($path);
           fwrite($handle, $fecha[$i]."|".$fechabaja[$i]."|".$tipocomp[$i]."|".$numeroc[$i]."|".$comen[$i]."|\r\n"); 
           fclose($handle);
           
           $i=$i+1;
           $con=$con+1;           
      }
    }
      

//==========================COMPRESION===================================

           /* primero creamos la función que hace la magia ===========================
           * esta funcion recorre carpetas y subcarpetas
           * añadiendo todo archivo que encuentre a su paso
           * recibe el directorio y el zip a utilizar 
           */
    if ($destino=="02") {
          if (!function_exists("agregar_zip")){
          function agregar_zip($dir, $zip) {

            //verificamos si $dir es un directorio
            if (is_dir($dir)) {
              //abrimos el directorio y lo asignamos a $da
              if ($da = opendir($dir)) {
                //leemos del directorio hasta que termine
                while (($archivo = readdir($da)) !== false) {
                  /*Si es un directorio imprimimos la ruta
                   * y llamamos recursivamente esta función
                   * para que verifique dentro del nuevo directorio
                   * por mas directorios o archivos
                   */
                  if (is_dir($dir . $archivo) && $archivo != "." && $archivo != "..") {
                    echo "<strong>Creando directorio: $dir$archivo</strong><br/>";
                    agregar_zip($dir . $archivo . "/", $zip);
                    /*si encuentra un archivo imprimimos la ruta donde se encuentra
                     * y agregamos el archivo al zip junto con su ruta 
                     */
                  } elseif (is_file($dir . $archivo) && $archivo != "." && $archivo != "..") {
                    echo "Agregando archivo: $dir$archivo <br/>";
                    $zip->addFile($dir . $archivo, $dir . $archivo);
                  }
                }
                //cerramos el directorio abierto en el momento
                closedir($da);
              }
            }
          }//fin de la función =================================================
       // }
        
        //creamos una instancia de ZipArchive
        $zip = new ZipArchive();
        /*directorio a comprimir
         * la barra inclinada al final es importante
         * la ruta debe ser relativa no absoluta
         */
        $dir = $rutabaja;
        //ruta donde guardar los archivos zip, ya debe existir
        $rutaFinal = $rutadescargas;

        if(!file_exists($rutaFinal)){
          mkdir($rutaFinal);
        }
        $archivoZip = "baja.zip";
        if ($zip->open($archivoZip, ZIPARCHIVE::CREATE) === true) {

          agregar_zip($dir, $zip);
          $zip->close();
          //Muevo el archivo a una ruta
          //donde no se mezcle los zip con los demas archivos
          rename($archivoZip, "$rutaFinal/$archivoZip");
         
          //Hasta aqui el archivo zip ya esta creado
          //Verifico si el archivo ha sido creado
          if (file_exists($rutaFinal. "/" . $archivoZip)) {
            echo "Proceso Finalizado!! <br/><br/>
                        Descargar: <a href='$rutaFinal/$archivoZip'>$archivoZip</a><br>
                        Volver: <a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a>";
          } else {
            echo "Error, archivo zip no ha sido creado!!";
          }
        
          }
            //$mask = $rutabaja."/*";
            //array_map( "unlink", glob( $mask ) );
        }
      }

      //exec ("explorer.exe ".$rutabaja); 
       //==================================================================== 

        if ($destino=="01") {
          exec ("explorer.exe ".$rutabaja); 
          ?>
               <script>
                      alert("Archivo descargado en carpeta BAJA validar con el FACTURADOR SUNAT")
                      window.setTimeout("history.back(-1)", 800);
               </script>

          <?php
          // }else{
          //  echo "Proceso Finalizado!! <br/><br/>
          //       Descargar: <a href='$rutaFinal/$archivoZip'>$archivoZip</a><br>
          //       Volver: <a href='javascript:history.back(-1);' title='Ir la página anterior'>Volver</a>";
          }

 
}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}
 
}
ob_end_flush();
?>




