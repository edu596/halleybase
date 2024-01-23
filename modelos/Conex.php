<?php
//Incluímos inicialmente la conexión a la base de datos


Class Conex
{
    //Implementamos nuestro constructor
    public function __construct()
    {

    }
                                            
 public function AccesoGeneral($ruc)
    {

      $enlace = new mysqli("localhost", "ago08ted_earoni", "7pDramPW0mxP","ago08ted_acceso");
      $SqlQuery= $enlace->query("select ruc, NombreEmpresa, UserBd, NombreBaseDatos, estado  from accesoempresas where ruc='$ruc'");
     
      //Copy result into a associative array
      $resultArray = $SqlQuery->fetch_all(MYSQLI_ASSOC);
      return $resultArray;
    
  }

    //https://ajaxhispano.com/ask/convertir-mysqli-result-en-json-105008/



     public function listadodb()
    {
      //$enlace = mysql_connect("localhost", "root", "");       
      //$resultado = mysql_query("SHOW DATABASES");

      $enlace = new mysqli("localhost", "ago08ted_earoni", "7pDramPW0mxP");
      $resultado = $enlace->query("SHOW DATABASES");
      $dbs=array();                                      
      //$sqlc=mysqli_fetch_array($resultado,MYSQLI_BOTH);
    //while ($fila = mysql_fetch_row($resultado)) {
      while ($fila = $resultado->fetch_array()) {
        $dbs[] =  $fila[0];
        }
        return $dbs;
    }



    public function verificar($login, $clave, $empresa)
    {
        //$sql="select idusuario, nombre, tipo_documento, num_documento, telefono, email, cargo, imagen, login from usuario where login='$login' and clave='$clave' and condicion='1'";

        $sql="select u.idusuario, u.nombre, u.tipo_documento, u.num_documento, u.telefono, u.email, u.cargo, u.imagen, u.login, e.nombre_razon_social, e.idempresa, co.igv  from usuario u inner join usuario_empresa ue on u.idusuario=ue.idusuario inner join empresa e on ue.idempresa=e.idempresa inner join configuraciones co on e.idempresa=co.idempresa where u.login='$login' and u.clave='$clave' and  e.idempresa='$empresa' and u.condicion='1'";
        return ejecutarConsulta($sql);
    }

     public function onoffTempo($st){
      $sql="update temporizador set estado='$st' where id='1' ";
      return ejecutarConsulta($sql);  
    }

    public function consultatemporizador(){
      $sql="select id as idtempo, tiempo, estado from temporizador where id='1' ";
      return ejecutarConsulta($sql);  
    }


}