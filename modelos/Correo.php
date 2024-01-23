<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
 
Class Correo
{
    //Implementamos nuestro constructor
    public function __construct()
    {
 
    }
 
    //Implementamos un método para insertar registros
    public function insertar($nombre, $username, $host, $password, $smtpsecure, $port, $mensaje, $correoavisos)
    {
        $sql="insert into
         correo (nombre,
            username,
            host,
            password,
            smtpsecure, 
            port, 
            mensaje,
            correoavisos
            
            )
        values ('$nombre','$username','$host','$password','$smtpsecure','$port','$mensaje', '$correoavisos')";
        return ejecutarConsulta($sql);
    }
 
    //Implementamos un método para editar registros
    public function editar($idcorreo,$nombre, $username, $host, $password, $smtpsecure, $port, $mensaje, $correoavisos)
    {
        $sql="update correo 
        set 
        nombre='$nombre', 
        username='$username', 
        host='$host', 
        password='$password', 
        smtpsecure='$smtpsecure', 
        port='$port', 
        mensaje='$mensaje',
        correoavisos='$correoavisos'
        where 
        idcorreo='$idcorreo'";
        return ejecutarConsulta($sql);
    }
 
   
    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrar($idcorreo)
    {
        $sql="select
         * 
        from
        correo  
        where 
        idcorreo='$idcorreo'";
        return ejecutarConsultaSimpleFila($sql);
    }
 
 
}
 
?>