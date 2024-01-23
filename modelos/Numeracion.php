<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Numeracion
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($tipo_documento, $serie , $numero )
	{
		$sql="insert into numeracion (tipo_documento, serie, numero)
		values ('$tipo_documento', '$serie', '$numero')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idnumeracion, $tipo_documento, $serie , $numero)
	{
		$sql="update numeracion set tipo_documento='$tipo_documento' , serie='$serie', numero='$numero' where idnumeracion='$idnumeracion'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar familias
	public function desactivar($idnumeracion)
	{
		$sql="update numeracion set estado='0' where idnumeracion='$idnumeracion'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idnumeracion)
	{
		$sql="update numeracion set estado='1' where idnumeracion='$idnumeracion'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idnumeracion)
	{
		$sql="select * from numeracion where idnumeracion='$idnumeracion'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="select * from numeracion n inner join catalogo1 ct1 on n.tipo_documento=ct1.codigo order by ct1.descripcion";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="select * from numeracion where estado='1'";
		return ejecutarConsulta($sql);		
	}



	//Llenar combo de series de Factura
	public function llenarSerieOrden(){
    $sql="select idnumeracion, serie from numeracion where tipo_documento='99'";
    return ejecutarConsulta($sql); 
	}

    //Llenar combo de series de guia remision
	public function llenarSerieGuia(){
    $sql="select idnumeracion, serie from numeracion where tipo_documento='09' or tipo_documento='56' ";
    return ejecutarConsulta($sql);      
    }

    //Llenar combo de series de nota de credito
	public function llenarSerieNcredito($idusuario){
    $sql="select n.idnumeracion, n.serie from numeracion n inner join detalle_usuario_numeracion dn on n.idnumeracion=dn.idnumeracion inner join usuario u on dn.idusuario=u.idusuario where n.tipo_documento='07' and dn.idusuario='$idusuario' group by n.serie ";
    return ejecutarConsulta($sql);  
	}

    public function llenarSerieNdebito($idusuario){
    $sql="select n.idnumeracion, n.serie from numeracion n inner join detalle_usuario_numeracion dn on n.idnumeracion=dn.idnumeracion inner join usuario u on dn.idusuario=u.idusuario where n.tipo_documento='08' and dn.idusuario='$idusuario' group by n.serie";
    return ejecutarConsulta($sql);          
    }

    //Llenar combo de series de Boleta
	public function llenarSerieBoleta($idusuario){
    $sql="select n.idnumeracion, n.serie from numeracion n inner join detalle_usuario_numeracion dn on n.idnumeracion=dn.idnumeracion inner join usuario u on dn.idusuario=u.idusuario where n.tipo_documento='03' and dn.idusuario='$idusuario' group by n.serie";
    return ejecutarConsulta($sql);    // Las series van deacuerdo a las asginaciones que e le de en los permisos de usuario       
    }

    

    //Llenar combo de series de Boleta
	public function llenarSerieNpedido($idusuario){
    $sql="select n.idnumeracion, n.serie from numeracion n inner join detalle_usuario_numeracion dn on n.idnumeracion=dn.idnumeracion inner join usuario u on dn.idusuario=u.idusuario where n.tipo_documento='50' and dn.idusuario='$idusuario' group by n.serie";
    return ejecutarConsulta($sql);    // Las series van deacuerdo a las asginaciones que e le de en los permisos de usuario       
    }


    	//Llenar combo de series de Factura
	public function llenarSerieFactura($idusuario){
    //$sql="select idnumeracion, serie from numeracion where tipo_documento='01'";
    $sql="select n.idnumeracion, n.serie from numeracion n inner join detalle_usuario_numeracion dn on n.idnumeracion=dn.idnumeracion inner join usuario u on dn.idusuario=u.idusuario where n.tipo_documento='01' and dn.idusuario='$idusuario' group by n.serie";
    return ejecutarConsulta($sql); // Las series van deacuerdo a las asginaciones que e le de en los permisos de usuario     
	}


    //Llenar combo de series de cotizacion
    public function llenarSeriecotizacion($idusuario)
    {
    
    $sql="select n.idnumeracion, n.serie from numeracion n inner join detalle_usuario_numeracion dn on n.idnumeracion=dn.idnumeracion inner join usuario u on dn.idusuario=u.idusuario where n.tipo_documento='20' and dn.idusuario='$idusuario' group by n.serie";
    return ejecutarConsulta($sql); // Las series van deacuerdo a las asginaciones que e le de en los permisos de usuario     
    }

    //Llenar combo de series de docu cobranza
    public function llenarSeriedoccobranza($idusuario)
    {
    $sql="select n.idnumeracion, n.serie from numeracion n inner join detalle_usuario_numeracion dn on n.idnumeracion=dn.idnumeracion inner join usuario u on dn.idusuario=u.idusuario where n.tipo_documento='30' and dn.idusuario='$idusuario' group by n.serie";
    return ejecutarConsulta($sql); // Las series van deacuerdo a las asginaciones que e le de en los permisos de usuario     
    }


    //Función para incrementar numero de COTIZACION.
    public function llenarNumerocotizacion($serie){

    $sql="select (n.numero+1) as Nnumero from numeracion n inner join detalle_usuario_numeracion dn on n.idnumeracion=dn.idnumeracion inner join usuario u on dn.idusuario=u.idusuario where n.tipo_documento='20' and n.idnumeracion='$serie' limit 1";    
    return ejecutarConsulta($sql);    // Las series van deacuerdo a las asginaciones que e le de en los permisos de usuario        
    }

      //Función para incrementar numero de doc.cotizacion.
    public function llenarNumerodoccobranza($serie){
    $sql="select (n.numero+1) as Nnumero from numeracion n inner join detalle_usuario_numeracion dn on n.idnumeracion=dn.idnumeracion inner join usuario u on dn.idusuario=u.idusuario where n.tipo_documento='30' and n.idnumeracion='$serie' limit 1";    
    return ejecutarConsulta($sql);    // Las series van deacuerdo a las asginaciones que e le de en los permisos de usuario        
    }

     

    //Función para incrementar numero de factura.
    public function llenarNumeroFactura($serie){
    //$sql="select (numero+1) as Nnumero from numeracion where tipo_documento='01' and idnumeracion='$serie'";

	$sql="select (n.numero+1) as Nnumero from numeracion n inner join detalle_usuario_numeracion dn on n.idnumeracion=dn.idnumeracion inner join usuario u on dn.idusuario=u.idusuario where n.tipo_documento='01' and n.idnumeracion='$serie' limit 1";    
    return ejecutarConsulta($sql);    // Las series van deacuerdo a las asginaciones que e le de en los permisos de usuario        
    }

    //Función para incrementar numero de factura.
    public function llenarNumeroFacturaServicio($serie){
    //$sql="select (numero+1) as Nnumero from numeracion where tipo_documento='01' and idnumeracion='$serie'";

    $sql="select (n.numero+1) as Nnumero from servicios_inmuebles n inner join detalle_usuario_servicios_inmuebles dn on n.idservicios_inmuebles=dn.idservicios_inmuebles inner join usuario u on dn.idusuario=u.idusuario where n.tipo_documento='01' and n.idservicios_inmuebles='$serie' limit 1";    
    return ejecutarConsulta($sql);    // Las series van deacuerdo a las asginaciones que e le de en los permisos de usuario        
    }

    //Función para incrementar numero de boleta.
    public function llenarNumeroBoleta($serie){
    $sql="select (n.numero+1) as Nnumero from numeracion n inner join detalle_usuario_numeracion dn on n.idnumeracion=dn.idnumeracion inner join usuario u on dn.idusuario=u.idusuario where n.tipo_documento='03' and n.idnumeracion='$serie' limit 1";
    return ejecutarConsulta($sql);  // Las series van deacuerdo a las asginaciones que e le de en los permisos de usuario     
    }

    //Función para incrementar numero de boleta.
    public function llenarNumeroNpedido($serie){
    $sql="select (n.numero+1) as Nnumero from numeracion n inner join detalle_usuario_numeracion dn on n.idnumeracion=dn.idnumeracion inner join usuario u on dn.idusuario=u.idusuario where n.tipo_documento='50' and n.idnumeracion='$serie' limit 1";
    return ejecutarConsulta($sql);  // Las series van deacuerdo a las asginaciones que e le de en los permisos de usuario     
    }

    //Función para incrementar numero de ORDEN DE SERVICIO.
    public function llenarNumeroOrden($idnumeracion){
    $sql="select (numero+1) as Nnumero from numeracion where tipo_documento='99' and idnumeracion='$idnumeracion'";
    return ejecutarConsulta($sql);      
    }

    //Función para incrementar numero de guia.
    public function llenarNumeroGuia($serie){
    $sql="select (numero+1) as Nnumero from numeracion where tipo_documento='09' or tipo_documento='56'  and idnumeracion='$serie'";
    return ejecutarConsulta($sql);      
    }

    //Función para incrementar numero de nota de credito.
    public function llenarNumeroNcredito($serie){
    $sql="select (n.numero+1) as Nnumero from numeracion n inner join detalle_usuario_numeracion dn on n.idnumeracion=dn.idnumeracion inner join usuario u on dn.idusuario=u.idusuario where n.tipo_documento='07' and n.idnumeracion='$serie' limit 1";
    return ejecutarConsulta($sql);      
    }


        //Función para incrementar numero de nota de debito.
    public function llenarNumeroNdedito($serie){
    $sql="select (n.numero+1) as Nnumero from numeracion n inner join detalle_usuario_numeracion dn on n.idnumeracion=dn.idnumeracion inner join usuario u on dn.idusuario=u.idusuario where n.tipo_documento='08' and n.idnumeracion='$serie' limit 1";
    return ejecutarConsulta($sql);      
    }


    

    public function updateNumeracion($numero, $idnumeracion){
    $sql="update numeracion set numero='$numero' where idnumeracion='$idnumeracion'";
    return ejecutarConsulta($sql);

    }

    public function listarSeries()
	{
		$sql="select * from numeracion where estado='1'";
		return ejecutarConsulta($sql);		
	}

    public function listarSeriesNuevo()
    {
        $sql="select * from numeracion";
        return ejecutarConsulta($sql);      
    }
}

?>