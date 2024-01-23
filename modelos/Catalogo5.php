<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Catalogo5
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($codigo, $descripcion , $unece5153 )
	{
		$sql="insert into catalogo5 (codigo, descripcion, unece5153)
		values ('$codigo', '$descripcion', '$unece5153')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id, $codigo, $descripcion, $unece5153)
	{
		$sql="update catalogo5 set codigo='$codigo', descripcion='$descripcion' , unece5153='$unece5153' where id='$id'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar familias
	public function desactivar($id)
	{
		$sql="update catalogo5 set estado='0' where id='$id'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($id)
	{
		$sql="update catalogo5 set estado='1' where id='$id'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id)
	{
		$sql="select * from catalogo5 where id='$id'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="select * from catalogo5";
		return ejecutarConsulta($sql);		
	}
	
}

?>