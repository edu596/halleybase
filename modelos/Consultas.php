<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";
 
Class Consultas
{
    //Implementamos nuestro constructor
    public function __construct()
    {
 
    }
 
    public function comprasfecha($fecha_inicio,$fecha_fin)
    {
        $sql="select date(i.fecha_hora) as fecha,u.nombre as usuario, p.nombre as proveedor,i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,i.total_compra,i.impuesto,i.estado from ingreso i inner join persona p on i.idproveedor=p.idpersona inner join usuario u on i.idusuario=u.idusuario where date(i.fecha_hora)>='$fecha_inicio' and date(i.fecha_hora)<='$fecha_fin'";
        return ejecutarConsulta($sql);      
    }
 
    public function ventasfechacliente($fecha_inicio,$fecha_fin,$idcliente)
    {        $sql="select date(v.fecha_hora) as fecha,u.nombre as usuario, p.nombre as cliente,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado from venta v inner join persona p on v.idcliente=p.idpersona inner join usuario u on v.idusuario=u.idusuario where date(v.fecha_hora)>='$fecha_inicio' and date(v.fecha_hora)<='$fecha_fin' and v.idcliente='$idcliente'";
        return ejecutarConsulta($sql);      
    }
 
    public function totalcomprahoy($idempresa)
    {
        $sql="select ifnull(sum(total),0) as total_compra from compra c inner join empresa e on c.idempresa=e.idempresa where date(fecha)=current_date and e.idempresa='$idempresa'";
        return ejecutarConsulta($sql);
    }


    


    public function tipodecambio($idempresa)
    {
        $sql="select venta, compra from tcambio   where fecha=curdate() and idempresa='$idempresa' order by idtipocambio desc limit 1";
        return ejecutarConsulta($sql);
    }


    public function ingresosdia($idempresa)
    {
        $sql="select  sum(ic.monto) as tingreso from
         caja c  inner join ingresocaja ic on c.idcaja=ic.idcaja where date(fecha)=current_date and c.idempresa='$idempresa' and c.estado='1' ";
        return ejecutarConsulta($sql);
    }


     public function egresosdia($idempresa)
    {
        $sql="select sum(sc.monto) as tsalida from
         caja c  inner join salidacaja sc on c.idcaja=sc.idcaja where date(fecha)=current_date and c.idempresa='$idempresa' and c.estado='1' ";
        return ejecutarConsulta($sql);
    }
 
    public function totalventahoy()
    {
        //$sql="select ifnull(sum(importe_total_venta_27),0) as total_venta from factura where date(fecha_emision_01)=current_date";
        $sql="select sum(importe_total_venta_27) as total_venta 
        from 
        (select  importe_total_venta_27 
        from 
        factura where date(fecha_emision_01)=current_date and estado in('5','1','6')
        union all
        select importe_total_23 
        from 
        boleta where date(fecha_emision_01)=current_date and estado in('5','1','6')
        union all 
        select importe_total_23 
        from 
        notapedido where date(fecha_emision_01)=current_date and estado in('1')
        ) as tbl1";
        return ejecutarConsulta($sql);
    }

     public function totalventahoyFactura($idempresa)
    {
        //$sql="select ifnull(sum(importe_total_venta_27),0) as total_venta from factura where date(fecha_emision_01)=current_date";
        $sql="select sum(sumafacdia) as total_venta_factura_hoy 
        from 
        (select  if(tipo_moneda_28='USD', importe_total_venta_27 * tcambio ,importe_total_venta_27)  as sumafacdia
        from 
        factura where date(fecha_emision_01)=current_date and estado in('5','1','6','4') and idempresa='$idempresa'
        ) as tbl1   ";
        return ejecutarConsulta($sql);
    }


    public function totalventahoycotizacion($idempresa)
    {
        //$sql="select ifnull(sum(importe_total_venta_27),0) as total_venta from factura where date(fecha_emision_01)=current_date";
        $sql="select sum(sumacotidia) as total_venta_coti_hoy 
        from 
        (select  if(moneda='USD', total * tipocambio ,total)  as sumacotidia
        from 
        cotizacion where date(fechaemision)=current_date and estado in('1') and idempresa='$idempresa'
        ) as tbl1";
        return ejecutarConsulta($sql);
    }


    public function totalventahoyFacturaServicio()
    {
        //$sql="select ifnull(sum(importe_total_venta_27),0) as total_venta from factura where date(fecha_emision_01)=current_date";
        $sql="select sum(importe_total_venta_27) as total_venta_factura_hoy 
        from 
        (select  importe_total_venta_27 
        from 
        facturaservicio where date(fecha_emision_01)=current_date and estado in('5','1','6','4')
        ) as tbl1";
        return ejecutarConsulta($sql);
    }

     public function totalventahoyBoletaServicio()
    {
        $sql="select sum(importe_total_23) as total_venta_boleta_hoy 
        from 
        (select  importe_total_23
        from 
        boletaservicio where date(fecha_emision_01)=current_date and estado in('5','1','6','4')
        ) as tbl1";
        return ejecutarConsulta($sql);
    }

    public function totalventahoyBoleta($idempresa)
    {
        $sql=" select sum(sumaboldia) as total_venta_boleta_hoy 
        from 
        (select  if(tipo_moneda_24='USD', importe_total_23 * tcambio ,importe_total_23)  as sumaboldia
        from 
        boleta where date(fecha_emision_01)=current_date and estado in('5','1','6','4') 
        and idempresa='$idempresa'
        ) as tbl1  ";
        return ejecutarConsulta($sql);
    }


    public function totalventahoyNotapedido($idempresa)
    {
        $sql="select sum(np.importe_total_23) as total_venta_npedido_hoy
        from 
        notapedido np inner join empresa e on np.idempresa=e.idempresa where date(np.fecha_emision_01)=current_date and np.estado in('5','1','6','4') and e.idempresa='$idempresa'";
        return ejecutarConsulta($sql);
    }

    

    public function comprasultimos_10dias($idempresa)
    {
        $sql="select 
        concat(day(c.fecha),'-', month(c.fecha)) as fecha,   
        monthname(c.fecha) as mes,
        sum(c.total) as total
        from 
        compra c inner join empresa e on c.idempresa=e.idempresa group by c.fecha order by c.fecha desc limit 0,5";
        return ejecutarConsulta($sql);
    }


    public function comprasultimos_5meses($idempresa)
    {
        $sql="select concat(day(c.fecha),'-', month(c.fecha)) as fecha,   
        monthname(c.fecha) as mes,
        sum(c.total) as total
        from 
        compra c inner join empresa e on c.idempresa=e.idempresa 
        where fecha between date_sub(now(), interval 5 month)  AND NOW() group by mes order by idcompra";
        return ejecutarConsulta($sql);
    }
 
    public function ventasultimos_12meses($idempresa)
    {
        //$sql="select date_format(fecha_emision_01,'%M') as fecha,sum(importe_total_venta_27) as total from factura group by MonTH(fecha_emision_01) order by fecha_emision_01 DESC limit 0,12";
            $sql="select 
            date_format(fecha_emision_01,'%M') as fecha, 
            sum(importe_total_venta_27) as total 
            from 
            (select 
            f.importe_total_venta_27, f.fecha_emision_01 from factura f inner join empresa e on f.idempresa=e.idempresa where f.estado in('5','6') and e.idempresa='$idempresa' 
            union all 
            select b.importe_total_23, b.fecha_emision_01 from boleta b inner join empresa e on b.idempresa=e.idempresa where b.estado in('5','6') and e.idempresa='$idempresa') 
            as tbl2  
            group by month(fecha_emision_01) order by fecha_emision_01 desc limit 0,12";
        return ejecutarConsulta($sql);
    }


    public function ventasultimos_3meses($idempresa)
    {
            $sql="select 
            date_format(fecha_emision_01,'%M') as fecha, 
            sum(importe_total_venta_27) as total 
            from 
            (select 
      f.importe_total_venta_27, f.fecha_emision_01 from factura f inner join empresa e on f.idempresa=e.idempresa where f.estado in('5','6') and e.idempresa='$idempresa' and fecha_emision_01 between date_sub(now(), interval 3 month)  AND NOW() 
            union all 
            select b.importe_total_23, b.fecha_emision_01 from boleta b inner join empresa e on b.idempresa=e.idempresa where b.estado in('5','6') and e.idempresa='$idempresa' and fecha_emision_01 between date_sub(now(), interval 3 month)  AND NOW()) 
            as tbl2  
            group by month(fecha_emision_01) order by month(fecha_emision_01) asc";
        return ejecutarConsulta($sql);
    }

    public function mostrarempresa()
    {
      $sql="select * from empresa";
      //$listadodb=mysql_query("SHOW DATABASES");
      return ejecutarConsulta($sql);
    }



     public function listadodb()
    {
      $enlace = mysql_connect(DB_HOST, DB_USERNAME, DB_PASSWORD);
      $resultado = mysql_query("SHOW DATABASES");
      $dbs=array();
    while ($fila = mysql_fetch_row($resultado)) {
        $dbs[] =  $fila[0];
        }
        return $dbs;
    }


    public function conectar($login, $clave, $empresa)
    {

        
     $connect = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD, $empresa);
        mysqli_query( $connect, 'SET NAMES "'.DB_ENCODE.'"');

    if (mysqli_connect_errno())
      {
            printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
            exit();
      }

        $sql="select u.idusuario, u.nombre, u.tipo_documento, u.num_documento, u.telefono, u.email, u.cargo, u.imagen, u.login, e.nombre_razon_social, e.idempresa, co.igv  from usuario u inner join usuario_empresa ue on u.idusuario=ue.idusuario inner join empresa e on ue.idempresa=e.idempresa inner join configuraciones co on e.idempresa=co.idempresa where u.login='$login' and u.clave='$clave' and  e.idempresa='$empresa' and u.condicion='1'";

         $resultado = mysqli_query($connect, $sql);

        return ejecutarConsulta($resultado);
        //return ejecutarConsulta($sql);
    }





    public function mostrartipocambio($fechahoy)
    {

        $sql="select idtipocambio, date_format(fecha, '%Y-%m-%d') as fecha, compra, venta from tcambio where fecha='$fechahoy'";
        return ejecutarConsulta($sql);
    }


    public function mostrarcaja($fechahoy, $idempresa)
    {

        if ($fechahoy!=date('Y/m/d')) {
           $sql="select idcaja, date_format(fecha, '%Y-%m-%d') as fecha, montoi, montof, estado from caja c inner join empresa e on c.idempresa=e.idempresa where fecha='$fechahoy' and c.idempresa='$idempresa'";
        }else{

            $sql="select idcaja, date_format(fecha, '%Y-%m-%d') as fecha, montoi, montof, estado from caja c inner join empresa e on c.idempresa=e.idempresa where fecha='$fechahoy' and c.idempresa='$idempresa'";

        }
       
        return ejecutarConsulta($sql);
    }


    public function paramscerti()
    {
    $sql="select * from sunatconfig where idcarga='1'";
    return ejecutarConsulta($sql);      
    }

    public function selectumedida()
    {
    $sql="select * from umedida ";
    return ejecutarConsulta($sql);      
    }


      public function selectumedidadearticulo($idarticulo)
    {
    $sql="select um.abre, um.nombreum 
    from umedida um inner join articulo a on um.idunidad=a.umedidacompra where idarticulo='$idarticulo'";
    return ejecutarConsulta($sql);      
    }



    public function impuestoglobal()
    {
    $sql="select * from configuraciones where idconfiguracion='1' ";
    return ejecutarConsultaSimpleFila($sql);      
    }


     public function consultaestados()
    {
    $sql="select fecha, estado, count(id) as totalestados from ( select fecha_emision_01 as fecha, estado, idfactura as id from factura 
       union all                                                
       select fecha_emision_01 as fecha, estado, idboleta as id from boleta) as estadodocs where month(fecha)=month(CURRENT_date()) group by estado";
        return ejecutarConsulta($sql);
    }


    public function consultaestadoscotizaciones()
    {
    $sql="select fechaemision as fecha, estado, count(idcotizacion) as totalestados from cotizacion where month(fechaemision)=month(current_date())  group by estado";
        return ejecutarConsulta($sql);
    }

    public function consultaestadosdocumentoC()
    {
    $sql="select fechaemision as fecha, estado, count(idccobranza) as totalestados from doccobranza where month(fechaemision)=month(current_date())  group by estado";
        return ejecutarConsulta($sql);
    }



    public function descargarcomprobante($ano, $mes, $dia, $comprobante, $estado, $idempresa)
   {
        $sql="select 
        id,
        tipocomp as tipodocu, 
        date_format(fecha_emision_01, '%Y-%m-%d') as fecha, 
        numer as documento, 
        format(subtotal,2) as subtotal, 
        format(igv,2) as igv, 
        format(total,2) as total  
from 
(
select
        idfactura as id, 
        tipo_documento_07 as tipocomp, 
        fecha_emision_01, 
        numeracion_08 as numer,
        total_operaciones_gravadas_monto_18_2 as subtotal, 
        sumatoria_igv_22_1 as igv, 
        importe_total_venta_27 as total, 
        f.estado as est
        from 
        factura f inner join persona p on f.idcliente=p.idpersona inner join empresa e on f.idempresa=e.idempresa
        where year(fecha_emision_01)='$ano' and month(fecha_emision_01)='$mes' and day(fecha_emision_01)='$dia' and e.idempresa='$idempresa' and tipo_documento_07='$comprobante' and f.estado='$estado' union all 
 select
        idboleta as id, 
        tipo_documento_06 as tipocomp, 
        fecha_emision_01, 
        numeracion_07 as numer,
        monto_15_2 as subtotal, 
        sumatoria_igv_18_1 as igv, 
        importe_total_23 as total, 
        b.estado as est
        from 
        boleta b inner join persona p on b.idcliente=p.idpersona inner join empresa e on b.idempresa=e.idempresa
        where year(fecha_emision_01)='$ano' and month(fecha_emision_01)='$mes' and day(fecha_emision_01)='$dia' and e.idempresa='$idempresa' and tipo_documento_06='$comprobante' and b.estado='$estado') as tbventa order by fecha";
        return ejecutarConsulta($sql);
    }


     public function ventasdiasemana()
    {
    $sql="select   dia,
         sum(VentasDia) as VentasDia
        from 
        (select
       DAYOFWEEK(fecha_emision_01) as dia
       , sum(importe_total_venta_27) as VentasDia
         
      FROM factura
         WHERE YEARWEEK(`fecha_emision_01`, 1) = YEARWEEK(CURDATE(), 1) 
        group by DAYOFWEEK(fecha_emision_01)
         union all
        select 
         DAYOFWEEK(fecha_emision_01) as dia
       , sum(importe_total_23) as VentasDia
      FROM boleta
        WHERE YEARWEEK(`fecha_emision_01`, 1) = YEARWEEK(CURDATE(), 1) 
        group by DAYOFWEEK(fecha_emision_01)
        ) 
        as tbl1  group by dia";
    return ejecutarConsulta($sql);      
    }


   

     public function totalpordia($ano, $mes, $moneda)
    {
    $sql="select 
    sum(importe_total_venta_27) as total , dia, nombredia from
(select 
    importe_total_venta_27, day(fecha_emision_01) as dia, 
 dayname(fecha_emision_01) as nombredia from 
 factura 
 where month(fecha_emision_01)='$mes' 
 and year(fecha_emision_01)='$ano' and tipo_moneda_28='$moneda' and estado in('5','1', '4')
 union all 
 select importe_total_23, day(fecha_emision_01) as dia, 
 dayname(fecha_emision_01) as nombredia from 
 boleta where month(fecha_emision_01)='$mes' 
 and year(fecha_emision_01)='$ano' and tipo_moneda_24='$moneda' and estado in('5','1', '4'))
as tabla group by dia";
    return ejecutarConsulta($sql);      
    }


         public function totalpordianotapedido($ano, $mes)
    {
    $sql="select sum(importe_total_23) as total , dia, nombredia from
(
 select importe_total_23, day(fecha_emision_01) as dia, 
 dayname(fecha_emision_01) as nombredia from notapedido where month(fecha_emision_01)='$mes' 
 and year(fecha_emision_01)='$ano')
as tabla group by dia";
    return ejecutarConsulta($sql);      
    }





    public function totalmesfactura($ano, $mes, $moneda)
    {
    $sql="select sum(importe_total_venta_27) as totalfactura , dia, nombredia from
(select importe_total_venta_27, day(fecha_emision_01) as dia, 
 dayname(fecha_emision_01) as nombredia from factura where month(fecha_emision_01)='$mes' 
 and year(fecha_emision_01)='$ano' and tipo_moneda_28='$moneda' and estado in ('1','5','4'))
    as tabla group by dia";
    return ejecutarConsulta($sql);      
    }


   public function totalmesboleta($ano, $mes, $moneda)
    {
    $sql="select sum(importe_total_23) as totalboleta , dia, nombredia from
(select importe_total_23, day(fecha_emision_01) as dia, 
 dayname(fecha_emision_01) as nombredia from boleta where month(fecha_emision_01)='$mes' 
 and year(fecha_emision_01)='$ano' and tipo_moneda_24='$moneda' and estado in ('1','5','4')) 
as tabla group by dia";
    return ejecutarConsulta($sql);      
    }


    public function registrarxcodigo($idregistro)
    {
        $sql="";
        $sqlValor="select * from  valfinarticulo where id='$idregistro'";
        $regVal=ejecutarConsulta($sqlValor);   

       

        $codVal='';
        $anoVal='';
        $costoiVal='';
        $saldoiVal='';
        $valoriVal='';
        $costofVal='';
        $saldofVal='';
        $valorfVal='';
        $tcomprasVal='';
        $tventasVal='';


        $codReg='';
        $anoReg='';
        

        while($reg= $regVal->fetch_object())
        {
            
            $codVal=$reg->codigoart;
            $anoVal=$reg->ano;

        $costoiVal=$reg->costoi;
        $saldoiVal=$reg->saldoi;
        $valoriVal=$reg->valori;
        $costofVal=$reg->costof;
        $saldofVal=$reg->saldof;
        $valorfVal=$reg->valorf;
        $tcomprasVal=$reg->tcompras;
        $tventasVal=$reg->tventas;


        }

        $sqlRegistro="select * from  reginventariosanos where codigo='$codVal' and ano='$anoVal'";
        $regReg=ejecutarConsulta($sqlRegistro);   


               while($reg2= $regReg->fetch_object())
            {

            $codReg=$reg2->codigo;
            $anoReg=$reg2->ano;                
            }
            
                 if ($codVal==$codReg &&  $anoReg==$anoVal  )  {

                $sql="update reginventariosanos set 
                costoinicial='$costoiVal', 
                saldoinicial='$saldoiVal', 
                valorinicial='$valoriVal', 
                compras='$tcomprasVal', 
                ventas='$tventasVal', 
                saldofinal = '$saldofVal', 
                costo= '$costofVal',
                valorfinal= '$valorfVal'
                where 
                codigo='$codVal' and ano='$anoVal'";
                $msg="Registro actualizado";
                ejecutarConsulta($sql);
        
        }else{
                $sql="insert into reginventariosanos
                 (codigo, denominacion, ano, costoinicial, saldoinicial, valorinicial, costo, 
                 saldofinal, valorfinal, compras, ventas) 
                values 
                ('$codVal',(select nombre from articulo where codigo='$codVal') ,'$anoVal','$costoiVal','$saldoiVal','$valoriVal',
                '$costofVal','$saldofVal','$valorfVal', '$tcomprasVal', '$tventasVal')";
                 ejecutarConsulta($sql);
                $msg="Registro nuevo";
        }

        return $msg;      

    }


        public function validarcaja($fechahoy)
    {

        $sql="select idcaja, fecha from caja order by idcaja desc limit 1";
        $regVal=ejecutarConsulta($sql);   
          while($reg= $regVal->fetch_object())
        {
            $idcaja=$reg->idcaja;
            $fecha=$reg->fecha;
            if ($fecha==$fechahoy) {
                $sqlup="update caja set estado='1' where idcaja='$idcaja'";
            }else{
                $sqlup="update caja set estado='0' where idcaja='$idcaja'";
            }
        }
             return ejecutarConsulta($sqlup);
             
        }



        public function validcaja($fechahoy)
    {

        $sql="select idcaja from caja where fecha='$fechahoy' order by idcaja desc limit 1";
        return ejecutarConsulta($sql);   
                      
        }


            public function totalingresodia($fechahoy)
    {

        //$sql="select sum(ic.monto) as tingreso from ingresocaja ic where ic.fechain='$fechahoy'";
        $sql="select sum(monto_concepto) as tingreso from Ha_Concepto_Movimientos where fecha_movimiento='$fechahoy' and Tipo_Gasto='E'";
        return ejecutarConsulta($sql);   
                      
    }


      public function totalegresodia($fechahoy)
    {

        //$sql="select sum(sc.monto) as tegreso from caja c inner join salidacaja sc on c.idcaja=sc.idcaja where c.fecha='$fechahoy'";
        //$sql="select sum(sc.monto) as tegreso from salidacaja sc  where sc.fechasal='$fechahoy'";
        $sql="select sum(monto_concepto) as tegreso from Ha_Concepto_Movimientos where Fecha_Movimiento='$fechahoy' and Tipo_Gasto='S'";
        return ejecutarConsulta($sql);   
                      
    }


    
}
 
?>