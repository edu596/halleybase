<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Vendedorsitio
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre , $empresa)
	{
		$sql="insert into vendedorsitio (nombre, idempresa)
		values ('$nombre', '$empresa')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($id, $nombre, $empresa)
	{
		$sql="update vendedorsitio set nombre='$nombre', idempresa='$empresa' where id='$id'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar familias
	public function desactivar($id)
	{
		$sql="update vendedorsitio set estado='0' where id='$id'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($id)
	{
		$sql="update vendedorsitio set estado='1' where id='$id'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($id)
	{
		$sql="select * from vendedorsitio where id='$id'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar($idempresa)
	{
		$sql="select * from vendedorsitio ve inner join empresa e on ve.idempresa=e.idempresa where e.idempresa='$idempresa	'";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select($idempresa)
	{
		$sql="select vs.id, vs.nombre from vendedorsitio vs inner join empresa e on vs.idempresa=e.idempresa  where   e.idempresa='$idempresa'  and vs.estado='1'";
		return ejecutarConsulta($sql);		
	}

	//Llenar combo de series de Factura
	public function llenar(){
    $sql="select nombre from vendedorsitio";
    return ejecutarConsulta($sql); 
	}

    public function updatevendedorsitio($nombre, $id){
    $sql="update vendedorsitio set nombre='$nombre' where id='$id'";
    return ejecutarConsulta($sql);

    }
}

?>