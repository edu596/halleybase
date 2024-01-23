<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Distrito
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementar un método para listar los registros y mostrar en el select
	public function selectDI($id)
	{
		$sql="SELECT d.iddistrito, d.nombre FROM ciudad c INNER JOIN distrito d ON c.idciudad=d.idciudad where c.idciudad='$id' and d.idciudad='$id'";
		return ejecutarConsulta($sql);		
	}
}

?>