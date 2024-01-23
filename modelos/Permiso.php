<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Permiso
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
	
	public function listar()
	{
		$sql="select * from permiso where not idpermiso in('6','7') ";
		return ejecutarConsulta($sql);		
	}

	public function listarEmpresa()
	{
		$sql="select * from empresa";
		return ejecutarConsulta($sql);		
	}
	
}

?>