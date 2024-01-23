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
$sw=0;
//======================================================

$ano=$_POST['ano'];
$mes=$_POST['mes'];
$tipo=$_POST['tipo'];
$destino=$_POST['destino'];
$idempresa=$_SESSION['idempresa']; 

      

      require "../config/global.php";
      $connect = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
      mysqli_query( $connect, 'SET NAMES "'.DB_ENCODE.'"');
      //Si tenemos un posible error en la conexión lo mostramos
      if (mysqli_connect_errno())
      {
            printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
            exit();
      }


      require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($_SESSION['idempresa']);
    $Prutas = $Rrutas->fetch_object();
    $rutadata=$Prutas->rutadata; // ruta de la carpeta DATA
    $rutabaja=$Prutas->rutabaja; // ruta de la carpeta BAJA
    $rutadescargas=$Prutas->rutadescargas; // ruta de la carpeta descargas



if ($tipo=="ventas") {

$query = "select 
 date_format(fecha_emision_01, '%Y%m00') as periodo,
 date_format(fecha_emision_01, '%Y%m00') as periodo2,
 date_format(fecha_emision_01, '%m') as mes, 
 date_format(fecha_emision_01, '%d/%m/%Y') as fechae, 
 right(substring_index(numeracion_08,'-',1),4) as serie, 
 tipodocuCliente,
 rucCliente, 
 RazonSocial, 
 tipo_moneda_28, 
 format(total_operaciones_gravadas_monto_18_2,2) as baseimp, 
 format(sumatoria_igv_22_1 ,2) as igv, 
 format(importe_total_venta_27, 2) as total, 
 tipo_documento_07 as tipocomp, 
 right(substring_index(numeracion_08,'-',-1),10) as numerodoc, 
 numero_ruc,
 estado,
 icbper, 
 codtrib
from 
(select fecha_emision_01, numeracion_08, p.tipo_documento as tipodocuCliente, p.numero_documento as  rucCliente, p.razon_social as RazonSocial, tipo_moneda_28, 
if(tipo_moneda_28='USD', total_operaciones_gravadas_monto_18_2 * tcambio, total_operaciones_gravadas_monto_18_2) as total_operaciones_gravadas_monto_18_2, if(tipo_moneda_28='USD', sumatoria_igv_22_1 * tcambio, sumatoria_igv_22_1)  as sumatoria_igv_22_1, if(tipo_moneda_28='USD', importe_total_venta_27 * tcambio, importe_total_venta_27) as importe_total_venta_27, tipo_documento_07, f.estado, e.numero_ruc, if(tipo_moneda_28='USD', icbper * tcambio, icbper) as icbper, codigo_tributo_22_3  as codtrib   
  from 
  factura f inner join persona p on f.idcliente=p.idpersona
  inner join empresa e on f.idempresa=e.idempresa
  where year(fecha_emision_01)='$ano' and month(fecha_emision_01)='$mes' and f.estado in('5','3','0','6') and e.idempresa='$idempresa'
  union all 
select fecha_emision_01, numeracion_07,  p.tipo_documento as tipodocuCliente,p.numero_documento as rucCliente, p.razon_social as RazonSocial, tipo_moneda_24,  monto_15_2, sumatoria_igv_18_1, importe_total_23,tipo_documento_06, b.estado, e.numero_ruc, b.icbper, codigo_tributo_18_3 as codtrib
from boleta b inner join persona p on b.idcliente=p.idpersona 
inner join empresa e on b.idempresa=e.idempresa
where year(fecha_emision_01)='$ano' and month(fecha_emision_01)='$mes' and b.estado in('5','3','0','6')  and e.idempresa='$idempresa'

) as tbventa order by fechae";  

 $querynotacd = "select date_format(n.fecha, '%Y%m00') as periodo,
date_format(n.fecha, '%Y%m00') as periodo2,
date_format(n.fecha, '%m') as mes,
date_format(n.fecha, '%d/%m/%Y') as fechae,
n.codigo_nota as tipocomp,  
right(substring_index(n.numeroserienota,'-',1),4) as serie, 
right(substring_index(n.numeroserienota,'-',-1),10) as numerodoc,
n.tipo_doc_ide as tipodocuCliente, 
n.numero_doc_ide as rucCliente, 
n.razon_social as RazonSocial, 
n.sum_ot, 
(n.total_val_venta_og) as baseimp, 
n.total_val_venta_oi, 
n.total_val_venta_oe, 
(n.sum_igv) as igv, 
n.sum_isc, 
n.sum_ot, 
(n.importe_total) as total,
date_format(n.fechacomprobante,'%d/%m/%Y') as fechaoriginal,
n.tipo_doc_mod as tipodocoriginal,
right(substring_index(n.serie_numero,'-',1),4) as serieoriginal,
right(substring_index(n.serie_numero,'-',-1),10) as numerooriginal
from 
notacd n inner join catalogo9 c on n.codtiponota=c.codigo inner join empresa e on n.idempresa=e.idempresa   where year(n.fecha)='$ano' and month(n.fecha)='$mes' and n.estado='5' and e.idempresa='$idempresa'";

  
$queryServicio = "select 
 date_format(fecha_emision_01, '%Y%m00') as periodo,
 date_format(fecha_emision_01, '%Y%m00') as periodo2,
 date_format(fecha_emision_01, '%m') as mes, 
 date_format(fecha_emision_01, '%d/%m/%Y') as fechae, 
 right(substring_index(numeracion_08,'-',1),4) as serie, 
 tipodocuCliente,
 rucCliente, 
 RazonSocial, 
 tipo_moneda_28, 
 total_operaciones_gravadas_monto_18_2 as baseimp, 
 sumatoria_igv_22_1 as igv, 
 importe_total_venta_27 as total, 
 tipo_documento_07 as tipocomp, 
 right(substring_index(numeracion_08,'-',-1),10) as numerodoc, 
 numero_ruc,
 f.estado 
from facturaservicio f inner join persona p on f.idcliente=p.idpersona
  inner join empresa e on f.idempresa=e.idempresa
  where year(fecha_emision_01)='$ano' and month(fecha_emision_01)='$mes' and f.estado in('5','3','0','6','1') and e.idempresa='$idempresa'";

      //==================================================
      $result = mysqli_query($connect, $query);  
      $resultnc = mysqli_query($connect, $querynotacd);  
     // $resultServicio = mysqli_query($connect, $queryServicio);  

      //==================================================


    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($_SESSION['idempresa']);
    $Prutas = $Rrutas->fetch_object();
    $rutaresumen=$Prutas->rutaresumen; // ruta de la carpeta resumen
    $rutadescargas=$Prutas->rutadescargas; // ruta de la carpeta descargas
    $rutaple=$Prutas->rutaple; // ruta de la carpeta PLE
    

      //==================FACTURA & BOLETAS================================
      $periodo2=array();
      $numerodoc=array();
      $cuo=array();
      $nasiento=array();
      $fechae=array();
      $tipocomp=array();
      $serie=array();
      $numerodoc=array();
      $tipodocuCliente=array();
      $rucCliente=array();
      $RazonSocial=array();
      $baseimp=array();
      $igv=array();
      $total=array();
      $estado=array();
      $icbper=array();
      $codtrib=array();

      $fechaoriginal=array();
      $tipodocoriginal=array();
      $serieoriginal=array();
      $numerooriginal=array();
      $fecha2='01/01/0001';
      $ult='1';
      
      $con=0;
      $pledatos=1;
      //====================================================      
  if ($result) {
           $mask = $rutaple."*";
           array_map( "unlink", glob( $mask ) );

      while($row=mysqli_fetch_assoc($result)){
      for($i=0; $i < count($result); $i++){
           $periodo=$row["periodo"];
           $periodo2[$i]=$row["periodo2"];
           $cuo[$i] = $con + 1;
           $numerodoc[$i]=$row["numerodoc"];
           $mes=$row["mes"];
           $n = sprintf("%05d", $con + 1); // PARA 0 A LA IZQUIERDA
           $fechae[$i]=$row["fechae"];
           $tipocomp[$i]=$row["tipocomp"];
           $serie[$i]=$row["serie"];
           $numerodoc[$i]=$row["numerodoc"];
           $tipodocuCliente[$i]=$row["tipodocuCliente"];
           $rucCliente[$i]=$row["rucCliente"];
           $RazonSocial[$i]=$row["RazonSocial"];
           
           $igv[$i]=$row["igv"];
           $total[$i]=$row["total"];
           $nruc=$row["numero_ruc"];
           $estado[$i]=$row["estado"];
           $icbper[$i]=$row["icbper"];
           $codtrib[$i]=$row["codtrib"];
         
           

           if ($tipodocuCliente[$i]=='0') {
              $rucCliente[$i]='0';
           }

           if ($codtrib[$i]=='9997') {
                $baseExo=$row["baseimp"];
                $baseimp[$i]="";
                $baseIna="";
              }else if($codtrib[$i]=='9998'){
                $baseIna=$row["baseimp"];
                $baseimp[$i]="";
                $baseExo="";
              }else{
                $baseimp[$i]=$row["baseimp"];
                $baseIna="";
                $baseExo="";
           }

           if ($estado[$i]=='3') {
              $tipodocuCliente[$i]='0';
              $rucCliente[$i]='0';
              $RazonSocial[$i]='ANULADO';
              $baseimp[$i]='0.00';
              $igv[$i]='0.00';
              $total[$i]='0.00';
              $ult='1';
           }


      $path= $rutaple."LE".$nruc.$periodo."14010000".$pledatos."111.txt";
      $handle=fopen($path, "a");
      fwrite($handle, $periodo2[$i]."|".$cuo[$i]."|M".$mes.$n."|".$fechae[$i]."||".$tipocomp[$i]."|".$serie[$i]."|".$numerodoc[$i]."||".$tipodocuCliente[$i]."|".$rucCliente[$i]."|".$RazonSocial[$i]."||".$baseimp[$i]."||".$igv[$i]."||||".$baseExo."|".$baseIna."||0.00|".$icbper[$i]."|".$total[$i]."|||".$fecha2."|00|-|-||||".$ult."|"."\n"); 
      fclose($handle); 
           $sw=1;
      }
           $con=$con+1;           
      }
 //==================FACTURA & BOLETAS================================

      while($row=mysqli_fetch_assoc($resultnc)){
      for($i=0; $i < count($resultnc); $i++){
           $periodo=$row["periodo"];
           $periodo2[$i]=$row["periodo2"];
           $cuo[$i] = $con + 1;
           $numerodoc[$i]=$row["numerodoc"];
           $mes=$row["mes"];
           $n = sprintf("%05d", $con + 1); // PARA 0 A LA IZQUIERDA
           $fechae[$i]=$row["fechae"];
           $tipocomp[$i]=$row["tipocomp"];
           $serie[$i]=$row["serie"];
           $tipodocuCliente[$i]=$row["tipodocuCliente"];
           $rucCliente[$i]=$row["rucCliente"];
           $RazonSocial[$i]=$row["RazonSocial"];
           $baseimp[$i]=$row["baseimp"];
           $igv[$i]=$row["igv"];
           $total[$i]=$row["total"];
           $fechaoriginal[$i]=$row["fechaoriginal"];
           $tipodocoriginal[$i]=$row["tipodocoriginal"];
           $serieoriginal[$i]=$row["serieoriginal"];
           $numerooriginal[$i]=$row["numerooriginal"];

           if ($tipocomp[$i]=='7') {
             $baseimp[$i]=$baseimp[$i] * -1;
             $igv[$i]= $igv[$i] * -1 ;
             $total[$i]= $total[$i] * -1;
           }

           $path=$rutaple."LE".$nruc.$periodo."14010000".$pledatos."111.txt";
           $handle=fopen($path, "a");
          fwrite($handle,$periodo2[$i]."|".$cuo[$i]."|M".$mes.$n."|".$fechae[$i]."||".$tipocomp[$i]."|".$serie[$i]."|".$numerodoc[$i]."||".$tipodocuCliente[$i]."|".$rucCliente[$i]."|".$RazonSocial[$i]."||".$baseimp[$i]."||".$igv[$i]."||||||||0.00|".$total[$i]."|||".$fechaoriginal[$i]."|".$tipodocoriginal[$i]."|".$serieoriginal[$i]."|".$numerooriginal[$i]."||||1|"."\n"); 
          fclose($handle); 
        
      }
              $con=$con+1;           
      }




    if ($destino=="02") {
// //===========================COMPRESION===================================
//            /* primero creamos la función que hace la magia ===========================
//            * esta funcion recorre carpetas y subcarpetas
//            * añadiendo todo archivo que encuentre a su paso
//            * recibe el directorio y el zip a utilizar 
//            */
//           //if (!function_exists("agregar_zip")){
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
        $dir = $rutaple;
        //ruta donde guardar los archivos zip, ya debe existir
        $rutaFinal = $rutadescargas;

        if(!file_exists($rutaFinal)){
          mkdir($rutaFinal);
        }
        $archivoZip = "ple.zip";
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

          // $mask = $rutaple."*";
          // array_map( "unlink", glob( $mask ) );

}
else
{
              exec ("explorer.exe ".$rutaple); 
               ?>
               <script>
                      window.setTimeout("history.back(-1)", 750);
               </script>
              <?php
}
//===================Fin de compresion de archivos .cab y .det ========================
    

    }
	}
    else  //SI ES COMPRAS
    {



    $query = "
    select 
    c.tipo_documento as tipocomp,
    date_format(fecha, '%Y%m00') as periodo,
    date_format(fecha, '%Y%m00') as periodo2,
    date_format(fecha, '%d/%m/%Y') as fechae, 
    date_format(fecha, '%m') as mes, 
    c.serie, 
    c.numero, 
    c.ruc,
    c.razon_social,
    c.moneda,
    c.subtotal,
    c.igv,
    c.total,
    e.numero_ruc,
    c.estado,
    p.numero_documento as ruc,
    p.razon_social,
    p.tipo_documento
  from 
  compra c inner join  empresa e on c.idempresa=e.idempresa
  inner join persona p on c.idproveedor=p.idpersona
  where year(fecha)='$ano' and month(fecha)='$mes' order by fecha";  

      //==================================================
      $result = mysqli_query($connect, $query);  
      //$resultnc = mysqli_query($connect, $querydetalle);  

      //==================================================


    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($_SESSION['idempresa']);
    $Prutas = $Rrutas->fetch_object();
    $rutaresumen=$Prutas->rutaresumen; // ruta de la carpeta resumen
    $rutadescargas=$Prutas->rutadescargas; // ruta de la carpeta descargas
    $rutaple=$Prutas->rutaple; // ruta de la carpeta PLE
    

      //==================FACTURA & BOLETAS================================
      $periodo2=array();
      $numerodoc=array();
      $cuo=array();
      $nasiento=array();
      $fechae=array();
      $tipocomp=array();
      $serie=array();
      $numerodoc=array();
      $tipodocuCliente=array();
      $rucCliente=array();
      $RazonSocial=array();
      $baseimp=array();
      $igv=array();
      $total=array();
      $estado=array();
      $icbper=array();
      $codtrib=array();

      $fechaoriginal=array();
      $tipodocoriginal=array();
      $serieoriginal=array();
      $numerooriginal=array();
      $fecha2='01/01/0001';
      $ult='1';
      
      $con=0;
      $pledatos=1;
      //====================================================      
  if ($result) {
           $mask = $rutaple."*";
           array_map( "unlink", glob( $mask ) );

      while($row=mysqli_fetch_assoc($result)){
      for($i=0; $i < count($result); $i++){
           $periodo=$row["periodo"];
           $periodo2[$i]=$row["periodo2"];
           $cuo[$i] = $con + 1;
           $numerodoc[$i]=$row["numero"];
           $mes=$row["mes"];
           $n = sprintf("%05d", $con + 1); // PARA 0 A LA IZQUIERDA
           $fechae[$i]=$row["fechae"];
           $tipocomp[$i]=$row["tipocomp"];
           $serie[$i]=$row["serie"];
           $numerodoc[$i]=$row["numerodoc"];
           $tipodocuCliente[$i]="0".$row["tipo_documento"];
           $rucCliente[$i]=$row["ruc"];
           $RazonSocial[$i]=$row["razon_social"];
           $baseExo=$row["subtotal"];
           $igv[$i]=$row["igv"];
           $total[$i]=$row["total"];
           $nruc=$row["numero_ruc"];
           $estado[$i]=$row["estado"];
           
         
           

           if ($tipodocuCliente[$i]=='0') {
              $rucCliente[$i]='0';
           }

          

           if ($estado[$i]=='3') {
              $tipodocuCliente[$i]='0';
              $rucCliente[$i]='0';
              $RazonSocial[$i]='ANULADO';
              $baseimp[$i]='0.00';
              $igv[$i]='0.00';
              $total[$i]='0.00';
              $ult='1';
           }


      $path= $rutaple."LE".$nruc.$periodo."08010000".$pledatos."111.txt";
      $handle=fopen($path, "a");
      fwrite($handle, $periodo2[$i]."|".$cuo[$i]."|M".$mes.$n."|".$fechae[$i]."||".$tipocomp[$i]."|".$serie[$i]."|".$numerodoc[$i]."||".$tipodocuCliente[$i]."|".$rucCliente[$i]."|".$RazonSocial[$i]."||".$baseimp[$i]."||".$igv[$i]."||||".$baseExo."|".$baseIna."||0.00|".$icbper[$i]."|".$total[$i]."|||".$fecha2."|00|-|-||||".$ult."|"."\n"); 
      fclose($handle); 
           $sw=1;
      }
           $con=$con+1;           
      }
 

  if ($destino=="02") {
// //===========================COMPRESION===================================
//            /* primero creamos la función que hace la magia ===========================
//            * esta funcion recorre carpetas y subcarpetas
//            * añadiendo todo archivo que encuentre a su paso
//            * recibe el directorio y el zip a utilizar 
//            */
//           //if (!function_exists("agregar_zip")){
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
        $dir = $rutaple;
        //ruta donde guardar los archivos zip, ya debe existir
        $rutaFinal = $rutadescargas;

        if(!file_exists($rutaFinal)){
          mkdir($rutaFinal);
        }
        $archivoZip = "ple.zip";
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

          // $mask = $rutaple."*";
          // array_map( "unlink", glob( $mask ) );

}
else
{
              exec ("explorer.exe ".$rutaple); 
               ?>
               <script>
                      window.setTimeout("history.back(-1)", 750);
               </script>
              <?php
}
//===================Fin de compresion de archivos .cab y .det ========================

             }
             else
             { 
              $sw=0;
              $pledatos=0;
              }

            if (is_null($result))
            {
               ?>
               <script>
                      alert("No hay datos!");
                      window.setTimeout("history.back(-1)", 750);
               </script>
              <?php

                 }  

}
    
         
     
//====================================================================


       
    //}//FIN RESULT
//} //FIN DE IF
//====================================================================
 
}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}
 
}
ob_end_flush();
?>



