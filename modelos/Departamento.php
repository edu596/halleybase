<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Departamento
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementar un método para listar los registros y mostrar en el select
	public function selectD()
	{
		$sql="select iddepartamento, nombre from departamento";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros y mostrar en el select en el caso 
	//de una modificacion para un cliente
	public function selectID($id)
	{
		$sql="select iddepartamento, nombre from departamento where iddepartamento='$id'";
		return ejecutarConsulta($sql);		
	}
}

?>