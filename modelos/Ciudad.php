<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Ciudad
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementar un método para listar los registros y mostrar en el select
	public function selectC($id)
	{
		$sql="select c.idciudad, c.nombre FROM departamento d INNER JOIN ciudad c ON d.iddepartamento=c.iddepartamento 
		where d.iddepartamento='$id' and c.iddepartamento='$id'";
		return ejecutarConsulta($sql);		
	}
}

?>