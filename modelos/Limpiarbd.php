<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
include('MySqlBackup.php');
 
Class Limpiarbd
{
    //Implementamos nuestro constructor
    public function __construct()
    {
 
    }
 
    //Implementamos un método para insertar registros
    public function limpiarbd($idempresa)
    {
        $sql="delete from detalle_fac_art dfa inner join factura f on dfa.idfactura=f.idfactura inner join empresa e on f.idempresa=e.idempresa where e.idempresa='$idempresa'";
        return ejecutarConsulta($sql);
    }


    public function listar()
    {
        $sql="select * from empresa";
        return ejecutarConsulta($sql);      
    }

  public function copiabdweb()
  {
     //Introduzca aquí la información de su base de datos y el nombre del archivo de copia de seguridad.
$mysqlDatabaseName =DB_NAME;
$mysqlUserName =DB_USERNAME;
$mysqlPassword =DB_PASSWORD;
$mysqlHostName =DB_HOST;
$fecha = date("Ymd-His"); //Obtenemos la fecha y hora para identificar el respaldo
 
$mysqlExportPath =$mysqlDatabaseName.'_'.$fecha.'.sql'; 

//Por favor, no haga ningún cambio en los siguientes puntos
//Exportación de la base de datos y salida del status
$command='mysqldump --opt -h' .$mysqlHostName .' -u' .$mysqlUserName .' --password="' .$mysqlPassword .'" ' .$mysqlDatabaseName .' > ' .$mysqlExportPath;
exec($command,$output=array(),$worked);


$zip = new ZipArchive(); //Objeto de Libreria ZipArchive
    //Construimos el nombre del archivo ZIP Ejemplo: mibase_20160101-081120.zip
    $salida_zip = $mysqlDatabaseName.'_'.$fecha.'.zip';
    
    if($zip->open($salida_zip,ZIPARCHIVE::CREATE)===true) { //Creamos y abrimos el archivo ZIP
        $zip->addFile($mysqlExportPath); //Agregamos el archivo SQL a ZIP
        $zip->close(); //Cerramos el ZIP
        unlink($mysqlExportPath); //Eliminamos el archivo temporal SQL
        //header ("Location: $salida_zip"); // Redireccionamos para descargar el Arcivo ZIP
        } else {
        echo 'Error'; //Enviamos el mensaje de error
    }

    copy("../ajax/".$salida_zip, "../copia/".$salida_zip);
    unlink("../ajax/".$salida_zip); //Eliminamos el archivo temporal SQL
    $rpta = array ('nombrearchivo'=>$salida_zip, 'rutaarchivo'=>"../copia/".$salida_zip);

    return $rpta;
      
  }
  
  
  
  
  

    public function copiabdlocal($rti)
    {
    $db_host = DB_HOST; //Host del Servidor MySQL
    $db_name = DB_NAME; //Nombre de la Base de datos
    $db_user = DB_USERNAME; //Usuario de MySQL
    $db_pass = DB_PASSWORD; //Password de Usuario MySQL
    
    $fecha = date("Ymd-His"); //Obtenemos la fecha y hora para identificar el respaldo
 
    // Construimos el nombre de archivo SQL Ejemplo: mibase_20170101-081120.sql
    $salida_sql = $db_name.'_'.$fecha.'.sql'; 
    
    //Comando para genera respaldo de MySQL, enviamos las variales de conexion y el destino
    //$dump = "C:/xampp/mysql/bin/mysqldump --user=".$db_user." --password=".$db_pass." --host=".$db_host." ".$db_name." > $salida_sql";

    $dump =$rti." --user=".$db_user." --password=".$db_pass." --host=".$db_host." ".$db_name." > $salida_sql";


    system($dump, $output); //Ejecutamos el comando para respaldo
    
    $zip = new ZipArchive(); //Objeto de Libreria ZipArchive
    //Construimos el nombre del archivo ZIP Ejemplo: mibase_20160101-081120.zip
    $salida_zip = $db_name.'_'.$fecha.'.zip';
    
    if($zip->open($salida_zip,ZIPARCHIVE::CREATE)===true) { //Creamos y abrimos el archivo ZIP
        $zip->addFile($salida_sql); //Agregamos el archivo SQL a ZIP
        $zip->close(); //Cerramos el ZIP
        unlink($salida_sql); //Eliminamos el archivo temporal SQL
        //header ("Location: $salida_zip"); // Redireccionamos para descargar el Arcivo ZIP
        } else {
        echo 'Error'; //Enviamos el mensaje de error
    }

    copy("../ajax/".$salida_zip, "../copia/".$salida_zip);
    unlink("../ajax/".$salida_zip); //Eliminamos el archivo temporal SQL
    $rpta = array ('nombrearchivo'=>$salida_zip, 'rutaarchivo'=>"../copia/".$salida_zip);

    return $rpta;

    }

 
 
}
 
?>