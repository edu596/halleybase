<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Insumos
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($tipodato, $fecharegistro, $categoriai, $descripcion, $monto)
	{
		if ($tipodato=='gasto') {
			$sql="insert into insumos (tipodato, idcategoriai, fecharegistro, descripcion, gasto)
		values ('$tipodato', '$categoriai' ,'$fecharegistro', '$descripcion', '$monto')";
		}else{
			$sql="insert into insumos (tipodato, idcategoriai, fecharegistro, descripcion, ingreso)
		values ('$tipodato', '$categoriai' ,'$fecharegistro', '$descripcion', '$monto')";
		}
		
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idinsumo, $descripcion, $monto)
	{
		$sql="update insumos set descripcion='$descripcion' , monto='$monto' where idinsumo='$idinsumo'";
		return ejecutarConsulta($sql);
	}

 
	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idinsumo)
	{
		$sql="select * from insumos where idinsumo='$idinsumo'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar($fecha)
	{
		$sql="select * from insumos ins inner join categoriainsumos ci on ins.idcategoriai=ci.idcategoriai where
        date(fecharegistro)='$fecha' order by idinsumo desc";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{ 
		$sql="select * from insumos";
		return ejecutarConsulta($sql);		
	} 

	public function selectcategoria()
    {
    $sql="select * from categoriainsumos order by idcategoriai desc ";
    return ejecutarConsulta($sql);      
    }

    	public function insertarcategoria($descripcion)
	{
		$sql="insert into categoriainsumos (descripcionc, estado)
		values ('$descripcion', '1')";
		return ejecutarConsulta($sql);
	}

		public function eliminar($idinsumo)
	{
		$sql="delete from insumos where idinsumo='$idinsumo'";
		return ejecutarConsulta($sql);
	}



	public function categoriaagrupadogastos($fecha)
	{
		$sql="select ci.descripcionc, sum(gasto) as totalg from insumos ins inner join categoriainsumos ci on ins.idcategoriai=ci.idcategoriai  where
        date(fecharegistro)='$fecha' and tipodato='gasto'  group by descripcionc order by descripcionc ";
		return ejecutarConsulta($sql);
	}


	public function categoriaagrupadoingresos($fecha)
	{
		$sql="select ci.descripcionc, sum(ingreso) as totalg from insumos ins inner join categoriainsumos ci on ins.idcategoriai=ci.idcategoriai  where
        date(fecharegistro)='$fecha' and tipodato='ingreso' and not descripcionc in('tarjeta','efectivo total') group by descripcionc order by descripcionc ";
		return ejecutarConsulta($sql);
	}

	public function categoriaagrupadogastosDet($categoria, $fecha)
	{
		$sql="select ci.descripcionc,   ins.descripcion, gasto as totalgd from insumos ins inner join categoriainsumos ci on ins.idcategoriai=ci.idcategoriai  where
        date(fecharegistro)='$fecha'  and descripcionc='$categoria' and tipodato='gasto' order by descripcionc";
		return ejecutarConsulta($sql);
	}

		public function categoriaagrupadoingresosDet($categoria, $fecha)
	{
		$sql="select ci.descripcionc,   ins.descripcion, ingreso as totalgd from insumos ins inner join categoriainsumos ci on ins.idcategoriai=ci.idcategoriai  where
        date(fecharegistro)='$fecha'  and descripcionc='$categoria' and tipodato='ingreso' and not descripcionc in('tarjeta','efectivo total') order by descripcionc";
		return ejecutarConsulta($sql);
	}

	public function totalxcategoria($categoria, $fecha)
	{
		$sql="select  sum(ins.gasto) as totalxcate from insumos ins inner join categoriainsumos ci on ins.idcategoriai=ci.idcategoriai  where
        date(fecharegistro)='$fecha'  and descripcionc='$categoria' and tipodato='gasto' order by descripcionc";
		return ejecutarConsulta($sql);
	}

		public function totalxcategoriaingreso($categoria, $fecha)
	{
		$sql="select  sum(ins.ingreso) as totalxcate from insumos ins inner join categoriainsumos ci on ins.idcategoriai=ci.idcategoriai  where
        date(fecharegistro)='$fecha'  and descripcionc='$categoria' and tipodato='ingreso' and not descripcionc in('tarjeta','efectivo total') order by descripcionc";
		return ejecutarConsulta($sql);
	}

		public function totalxcategoriaingresos($categoria)
	{
		$sql="select  sum(ins.ingreso) as totalxcate from insumos ins inner join categoriainsumos ci on ins.idcategoriai=ci.idcategoriai  where
        date(fecharegistro)=current_date  and descripcionc='$categoria' and tipodato='gasto' order by descripcionc";
		return ejecutarConsulta($sql);
	}

		public function totalxcategoriageneral($fecha)
	{
		$sql="select  sum(ins.gasto) as totalxcategeneral from insumos ins inner join categoriainsumos ci on ins.idcategoriai=ci.idcategoriai  where
        date(fecharegistro)='$fecha' and tipodato='gasto' ";
		return ejecutarConsulta($sql);
	}

		public function totalxcategoriageneralIngreso($fecha)
	{
		$sql="select  sum(ins.ingreso) as totalxcategeneral from insumos ins inner join categoriainsumos ci on ins.idcategoriai=ci.idcategoriai  where
        date(fecharegistro)='$fecha' and tipodato='ingreso' and not descripcionc in('tarjeta','efectivo total') ";
		return ejecutarConsulta($sql);
	}

	public function totalingresotarjeta($fecha)
	{
		$sql="select  sum(ins.ingreso) as totaltarje from insumos ins inner join categoriainsumos ci on ins.idcategoriai=ci.idcategoriai  where
        date(fecharegistro)='$fecha' and tipodato='ingreso' and  descripcionc='tarjeta' ";
		return ejecutarConsulta($sql);
	}

		public function totalingresoefectivototal($fecha)
	{
			$sql="select  sum(ins.ingreso) as efectivot from insumos ins inner join categoriainsumos ci on ins.idcategoriai=ci.idcategoriai  where
	        date(fecharegistro)='$fecha' and tipodato='ingreso' and  descripcionc='EFECTIVO TOTAL' ";
		return ejecutarConsulta($sql);
	}


	public function datosemp()
    { 

    $sql="select * from empresa";
    return ejecutarConsulta($sql);      
    }







    public function calcularuti($fecha1, $fecha2)
	{

		$connect = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
        mysqli_query( $connect, 'SET NAMES "'.DB_ENCODE.'"');

         if (mysqli_connect_errno())
      {
            printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
            exit();
      }	

		$totalutilidad="select 
		sum(gasto) as totalgastos, 
		sum(ingreso) as totalingresos, 
		(sum(ingreso)-sum(gasto)) as utilidad, 
		((sum(ingreso)-sum(gasto))/sum(ingreso)*100) as porcentaje  
		from 
		insumos ins inner join categoriainsumos ci on ins.idcategoriai=ci.idcategoriai 
		 where  
		 fecharegistro between '$fecha1' and  '$fecha2' and not descripcionc in('tarjeta','efectivo total')";
		$result1 = mysqli_query($connect, $totalutilidad); 

		while($row=mysqli_fetch_assoc($result1)){
	      for($i=0; $i <= count($result1); $i++){
           $totalgastos1=$row["totalgastos"];
            $totalingresos1=$row["totalingresos"];
             $utilid=$row["utilidad"];
              $porc=$row["porcentaje"];  
          } 
      } 
 

          $sqlins="insert into utilidadgi (fecha1, fecha2, totalgastos, totalventas, utilidad, porcentaje) 
          values ('$fecha1', '$fecha2', '$totalgastos1','$totalingresos1', '$utilid', '$porc')";
          ejecutarConsulta($sqlins);


          $sql="select 
          idutilidad, 
          date_format(fecha1, '%d-%m-%Y') as fecha1,
          date_format(fecha2, '%d-%m-%Y') as fecha2, 
          totalgastos, 
          totalventas,
          utilidad,
          porcentaje,
          estado
          from utilidadgi order by idutilidad desc";
		 return ejecutarConsulta($sql);

	}


	 public function recalcularuti($idutilidad)
	{

		$connect = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
        mysqli_query( $connect, 'SET NAMES "'.DB_ENCODE.'"');

         if (mysqli_connect_errno())
      {
            printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
            exit();
      }	

       $sql="select fecha1, fecha2
            from utilidadgi where idutilidad='$idutilidad'";
		 $result1 = mysqli_query($connect, $sql); 

		while($row=mysqli_fetch_assoc($result1)){
	      for($i=0; $i <= count($result1); $i++){
           $fecha1=$row["fecha1"];
            $fecha2=$row["fecha2"];
          } 
      }

		$totalutilidad="select 
		sum(gasto) as totalgastos, 
		sum(ingreso) as totalingresos, 
		(sum(ingreso)-sum(gasto)) as utilidad, 
		((sum(ingreso)-sum(gasto))/sum(ingreso)*100) as porcentaje  
		from 
		insumos ins inner join categoriainsumos ci on ins.idcategoriai=ci.idcategoriai 
		 where  
		 fecharegistro between '$fecha1' and  '$fecha2' and not descripcionc in('tarjeta','efectivo total')";
		$result1 = mysqli_query($connect, $totalutilidad); 

		while($row=mysqli_fetch_assoc($result1)){
	      for($i=0; $i <= count($result1); $i++){
           $totalgastos1=$row["totalgastos"];
            $totalingresos1=$row["totalingresos"];
             $utilid=$row["utilidad"];
              $porc=$row["porcentaje"];  
          } 
      } 
 

          $sqlins="update utilidadgi set fecha1='$fecha1', fecha2='$fecha2', totalgastos='$totalgastos1', totalventas='$totalingresos1', utilidad='$utilid', porcentaje='$porc' where idutilidad='$idutilidad' 
         ";
          ejecutarConsulta($sqlins);


          $sql="select 
          idutilidad, 
          date_format(fecha1, '%d-%m-%Y') as fecha1,
          date_format(fecha2, '%d-%m-%Y') as fecha2, 
          totalgastos, 
          totalventas,
          utilidad,
          porcentaje,
          estado
          from utilidadgi order by idutilidad desc";
		 return ejecutarConsulta($sql);

	}




		public function eliminarutilidad($idutilidad)
	{
		$sql="delete from utilidadgi where idutilidad='$idutilidad'";
		return ejecutarConsulta($sql);
	}

	public function listarutilidad()
	{
		$sql="select 
		idutilidad, 
		date_format(fecha1, '%d-%m-%Y') as fecha1,
        date_format(fecha2, '%d-%m-%Y') as fecha2, 
        totalgastos, 
        totalventas,
        utilidad,
        porcentaje,
        estado
        from utilidadgi order by idutilidad desc";
		return ejecutarConsulta($sql);
	}

		public function aprobarutilidad($idutilidad)
	{
		$sql="update utilidadgi set estado='1' where idutilidad='$idutilidad'";
		return ejecutarConsulta($sql);
	}


	  public function totaldetallado($idutilidad)
	{

          $sql="select fecha1, fecha2
            from utilidadgi where idutilidad='$idutilidad'";
		 return ejecutarConsulta($sql);

	}

	 public function detalladogastos($fecha1,$fecha2)
	{

          $sql="select ci.descripcionc,   ins.descripcion, monto as totalgd from insumos ins inner join categoriainsumos ci on ins.idcategoriai=ci.idcategoriai  where
         fecharegistro between '$fecha1'and '$fecha2' order by descripcionc";
		 return ejecutarConsulta($sql);

	}

	 public function totaldetallado_($idutilidad)
	{

          $sql="select Lcase(dayname(fechadia), gasto, ingreso
            from 
            (select fecharegistro, monto   where idutilidad='$idutilidad'";
		 return ejecutarConsulta($sql);

	}


	 public function mostrarfechas($idutilidad)
	{

          $sql="select date_format(fecha1,'%d-%m-%Y') as fecha1,
          				date_format(fecha2,'%d-%m-%Y') as fecha2
            from 
            utilidadgi where idutilidad='$idutilidad'";
		 return ejecutarConsulta($sql);

	}

	 public function reporteutilidad($idutilidad)
	{

		$connect = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
        mysqli_query( $connect, 'SET NAMES "'.DB_ENCODE.'"');

         if (mysqli_connect_errno())
      {
            printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
            exit();
      }	

          $sql="select fecha1, fecha2
            from utilidadgi where idutilidad='$idutilidad'";
		 $result1 = mysqli_query($connect, $sql); 

		while($row=mysqli_fetch_assoc($result1)){
	      for($i=0; $i <= count($result1); $i++){
           $fecha1=$row["fecha1"];
            $fecha2=$row["fecha2"];
          } 
      }

       $sqlruti="select 
       date_format(fecharegistro, '%d-%m-%Y') as fechadia,
        
       CONCAT(
       ELT
       (WEEKDAY(fecharegistro)+1, 
    	'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado', 'Domingo'),' ', date_format(fecharegistro, '%d')) as diasemana,   
       sum(gasto) as tgasto, 
       sum(ingreso) as tingreso,
       (sum(ingreso)-sum(gasto)) as utilidad,
       concat(format((((sum(ingreso)-sum(gasto))/sum(ingreso))*100),2),' %') as porcentaje
       from insumos ins inner join categoriainsumos ci on
       ins.idcategoriai=ci.idcategoriai 
       where fecharegistro between '$fecha1' and '$fecha2' and not descripcionc in('tarjeta','efectivo total') group by  fechadia";

       return ejecutarConsulta($sqlruti);

	}


	public function reporteutilidadtotal($idutilidad)
	{

		$connect = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
        mysqli_query( $connect, 'SET NAMES "'.DB_ENCODE.'"');

         if (mysqli_connect_errno())
      {
            printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
            exit();
      }	

          $sql="select fecha1, fecha2
            from utilidadgi where idutilidad='$idutilidad'";
		 $result1 = mysqli_query($connect, $sql); 

		while($row=mysqli_fetch_assoc($result1)){
	      for($i=0; $i <= count($result1); $i++){
           $fecha1=$row["fecha1"];
            $fecha2=$row["fecha2"];
          } 
      }

       $sqlruti="select 
      
       sum(gasto) as totalgasto, 
       sum(ingreso) as totalingreso,
       (sum(ingreso)-sum(gasto)) as totalutilidad,
       ((sum(ingreso)-sum(gasto))/sum(ingreso)*100) as porcentaje 
       from insumos ins inner join categoriainsumos ci on ins.idcategoriai=ci.idcategoriai
        where 
        fecharegistro between '$fecha1' and '$fecha2' and not descripcionc in('tarjeta','efectivo total')";

       return ejecutarConsulta($sqlruti);

	}


	public function detalladodatosingresos($idutilidad)
	{

		$connect = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
        mysqli_query( $connect, 'SET NAMES "'.DB_ENCODE.'"');

         if (mysqli_connect_errno())
      {
            printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
            exit();
      }	

          $sql="select fecha1, fecha2
            from utilidadgi where idutilidad='$idutilidad'";
		 $result1 = mysqli_query($connect, $sql); 

		while($row=mysqli_fetch_assoc($result1)){
	      for($i=0; $i <= count($result1); $i++){
            $fecha1=$row["fecha1"];
            $fecha2=$row["fecha2"];
          } 
      }

       $sqlruti="select 
       date_format(fecharegistro, '%d-%m-%Y') as fechadia,   
       tipodato, 
      descripcionc,
      descripcion,
     ingreso
       from insumos ins inner join categoriainsumos ci on
       ins.idcategoriai=ci.idcategoriai where fecharegistro between '$fecha1' and '$fecha2' and not descripcionc in('tarjeta','efectivo total') and tipodato='ingreso' order by fechadia";

       return ejecutarConsulta($sqlruti);

	}

	public function detalladodatosingresostotal($idutilidad)
	{

		$connect = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
        mysqli_query( $connect, 'SET NAMES "'.DB_ENCODE.'"');

         if (mysqli_connect_errno())
      {
            printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
            exit();
      }	

          $sql="select fecha1, fecha2
            from utilidadgi";
		 $result1 = mysqli_query($connect, $sql); 

		while($row=mysqli_fetch_assoc($result1)){
	      for($i=0; $i <= count($result1); $i++){
            $fecha1=$row["fecha1"];
            $fecha2=$row["fecha2"];
          } 
      }

       $sqlruti="select 
     sum(ingreso) as totalingdeta
       from insumos ins inner join categoriainsumos ci on
       ins.idcategoriai=ci.idcategoriai where fecharegistro between '$fecha1' and '$fecha2' and not ci.descripcionc in('tarjeta','efectivo total') and tipodato='ingreso'";

       return ejecutarConsulta($sqlruti);

	}


		public function detalladodatosgastos($idutilidad)
	{

		$connect = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
        mysqli_query( $connect, 'SET NAMES "'.DB_ENCODE.'"');

         if (mysqli_connect_errno())
      {
            printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
            exit();
      }	

          $sql="select fecha1, fecha2
            from utilidadgi where idutilidad='$idutilidad'";
		 $result1 = mysqli_query($connect, $sql); 

		while($row=mysqli_fetch_assoc($result1)){
	      for($i=0; $i <= count($result1); $i++){
            $fecha1=$row["fecha1"];
            $fecha2=$row["fecha2"];
          } 
      }

       $sqlruti="select 
       date_format(fecharegistro, '%d-%m-%Y') as fechadia,   
       tipodato, 
      descripcionc,
      descripcion,
     gasto
       from insumos ins inner join categoriainsumos ci on
       ins.idcategoriai=ci.idcategoriai where fecharegistro between '$fecha1' and '$fecha2' and not ci.descripcionc='tarjeta' and tipodato='gasto' order by fechadia";

       return ejecutarConsulta($sqlruti);

	}





	public function detalladodatosgastototal($idutilidad)
	{

		$connect = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
        mysqli_query( $connect, 'SET NAMES "'.DB_ENCODE.'"');

         if (mysqli_connect_errno())
      {
            printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
            exit();
      }	

          $sql="select fecha1, fecha2
            from utilidadgi where idutilidad='$idutilidad'";
		 $result1 = mysqli_query($connect, $sql); 

		while($row=mysqli_fetch_assoc($result1)){
	      for($i=0; $i <= count($result1); $i++){
            $fecha1=$row["fecha1"];
            $fecha2=$row["fecha2"];
          } 
      }

       $sqlruti="select 
     sum(gasto) as totalingdeta
       from insumos ins inner join categoriainsumos ci on
       ins.idcategoriai=ci.idcategoriai where fecharegistro between '$fecha1' and '$fecha2' and not ci.descripcionc='tarjeta' and tipodato='gasto'";

       return ejecutarConsulta($sqlruti);

	}

	public function detalladodatosingresotarjetadetalle($idutilidad)
	{

		$connect = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
        mysqli_query( $connect, 'SET NAMES "'.DB_ENCODE.'"');

         if (mysqli_connect_errno())
      {
            printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
            exit();
      }	

          $sql="select fecha1, fecha2
            from utilidadgi where idutilidad='$idutilidad'";
		 $result1 = mysqli_query($connect, $sql); 

		while($row=mysqli_fetch_assoc($result1)){
	      for($i=0; $i <= count($result1); $i++){
            $fecha1=$row["fecha1"];
            $fecha2=$row["fecha2"];
          } 
      }

       $sqlruti="select 
       date_format(fecharegistro, '%d-%m-%Y') as fechadia,   
       tipodato, 
      descripcionc,
      descripcion,
     ingreso
       from insumos ins inner join categoriainsumos ci on
       ins.idcategoriai=ci.idcategoriai where fecharegistro between '$fecha1' and '$fecha2' and  ci.descripcionc='tarjeta' and tipodato='ingreso' order by fechadia";

       return ejecutarConsulta($sqlruti);

	}


	public function detalladodatosingresostotaltarjeta($idutilidad)
	{

		$connect = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
        mysqli_query( $connect, 'SET NAMES "'.DB_ENCODE.'"');

         if (mysqli_connect_errno())
      {
            printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
            exit();
      }	

          $sql="select fecha1, fecha2
            from utilidadgi where idutilidad='$idutilidad'";
		 $result1 = mysqli_query($connect, $sql); 

		while($row=mysqli_fetch_assoc($result1)){
	      for($i=0; $i <= count($result1); $i++){
            $fecha1=$row["fecha1"];
            $fecha2=$row["fecha2"];
          } 
      }

       $sqlruti="select 
     sum(ingreso) as totaltarjtotal
       from insumos ins inner join categoriainsumos ci on
       ins.idcategoriai=ci.idcategoriai where fecharegistro between '$fecha1' and '$fecha2' and  ci.descripcionc='tarjeta' and tipodato='ingreso'";

       return ejecutarConsulta($sqlruti);

	}



	 public function detalladomensual($mes)
	{


       $sqlmes="select 
       date_format(fecharegistro, '%d-%m-%Y') as fechadia, 
       
       sum(gasto) as tgasto, 
       sum(ingreso) as tingreso,
       (sum(ingreso)-sum(gasto)) as utilidad,
       concat(format((((sum(ingreso)-sum(gasto))/sum(ingreso))*100),2),' %') as porcentaje
       from insumos ins inner join categoriainsumos ci on
       ins.idcategoriai=ci.idcategoriai 
       where month(fecharegistro)='$mes'and not descripcionc in('tarjeta','efectivo total') group by  fechadia";

       return ejecutarConsulta($sqlmes);

	}

	 public function detalladomensualtotal($mes)
	{


       $sqlmestotal="select 
       
       
       sum(gasto) as tgasto, 
       sum(ingreso) as tingreso,
       (sum(ingreso)-sum(gasto)) as utilidad
       
       from insumos ins inner join categoriainsumos ci on
       ins.idcategoriai=ci.idcategoriai 
       where month(fecharegistro)='$mes'and not descripcionc in('tarjeta','efectivo total') ";

       return ejecutarConsulta($sqlmestotal);

	}



	
}

?>