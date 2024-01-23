<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
 
Class Ftpparam
{
    //Implementamos nuestro constructor
    public function __construct()
    {
 
    }
 
    //Implementamos un método para insertar registros
    public function insertar($razonsocial,$ncomercial,$domicilio,$ruc,$tel1,$tel2,$correo,$imagen)
    {
        $sql="insert into
         empresa (nombre_razon_social,
            nombre_comercial,
            domicilio_fiscal,
            numero_ruc,
            telefono1, 
            telefono2, 
            correo, 
            logo,
            )
        values ('$razonsocial','$ncomercial','$domicilio','$ruc','$tel1','$tel2','$correo','$imagen')";
        return ejecutarConsulta($sql);
    }
 
    //Implementamos un método para editar registros
    public function editar($idempresa,$razonsocial,$ncomercial,$domicilio,$ruc,$tel1,$tel2,$correo,$imagen)
    {
        $sql="update empresa 
        set 
        nombre_razon_social='$razonsocial', 
        nombre_comercial='$ncomercial', 
        domicilio_fiscal='$domicilio', 
        numero_ruc='$ruc', 
        telefono1='$tel1', 
        telefono2='$tel2', 
        correo='$correo', 
        logo='$imagen'
        
        where 
        idempresa='$idempresa'";
        return ejecutarConsulta($sql);
    }
 
   
    //Implementar un método para mostrar los datos de un registro a modificar
    public function mostrarParametros()
    {
        $sql="select * from ftpparam";
        return ejecutarConsultaSimpleFila($sql);
    }
 
 
}
 
?>