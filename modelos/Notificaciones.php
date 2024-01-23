<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Notificaciones
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombrenotificacion, $fechacreacion, $fechaaviso, $contador, $selconti, $idpersona)
	{
		$sql="insert into notificaciones (nombrenotificacion, fechacreacion, fechaaviso, contador, continuo, idpersona)
		values ('$nombrenotificacion', '$fechacreacion', '$fechaaviso', '$contador', '$selconti', '$idpersona')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idnotificacion, $nombrenotificacion, $fechacreacion, $fechaaviso, $contador, $selconti, $idpersona)
	{
		$sql="update notificaciones set 
		nombrenotificacion='$nombrenotificacion', 
		fechacreacion='$fechacreacion', 
		fechaaviso='$fechaaviso',
		contador='$contador',
		continuo='$selconti',
		idpersona='$idpersona'
		where idnotificacion='$idnotificacion'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar familias
	public function desactivar($idnotificacion)
	{
		$sql="update notificaciones set estado='0' where idnotificacion='$idnotificacion'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idnotificacion)
	{
		$sql="update notificaciones set estado='1' where idnotificacion='$idnotificacion'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idnotificacion)
	{
		$sql="select * from notificaciones no inner join persona p on no.idpersona=p.idpersona where idnotificacion='$idnotificacion'";
		return ejecutarConsultaSimpleFila($sql);
	}


	

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="select no.idnotificacion, no.nombrenotificacion, no.fechacreacion, no.fechaaviso, 
		p.nombre_comercial, no.estado from notificaciones no inner join persona p on no.idpersona=p.idpersona order by idnotificacion desc";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	


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
    public function llenarNumeroOrden($idnotificacion){
    $sql="select (numero+1) as Nnumero from numeracion where tipo_documento='99' and idnumeracion='$idnotificacion'";
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


    

    public function updateNumeracion($numero, $idnotificacion){
    $sql="update numeracion set numero='$numero' where idnumeracion='$idnotificacion'";
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