<?php
require "../config/Conexion.php";
Class Venta
{
    //Implementamos nuestro constructor
    public function __construct()
    {
 
    }
  

    public function regventa($ano, $mes, $dia, $idempresa, $tmoneda){
        $sql="select idfactura as id,
        tipo_documento_07 as tipodocu, 
        date_format(fecha_emision_01, '%d/%m/%Y') as fecha, 
        numeracion_08 as documento, 
        format(subtotal,2)as subtotal, 
        format(igv,2) as igv, 
        format(total,2) as total,         estado 
        from 
            (select f.idfactura, f.tipo_documento_07 ,f.fecha_emision_01, f.total_operaciones_gravadas_monto_18_2 as subtotal, f.numeracion_08, f.sumatoria_igv_22_1 as igv, f.importe_total_venta_27 as total, f.estado from factura f inner join empresa e on f.idempresa=e.idempresa  where year(f.fecha_emision_01)='$ano'  and month(f.fecha_emision_01)='$mes' and day(f.fecha_emision_01)='$dia' and f.estado in ('5','6','1') and e.idempresa='$idempresa' and f.tipo_moneda_28='$tmoneda'
            union all 
            
             select b.idboleta, b.tipo_documento_06 ,b.fecha_emision_01, b.monto_15_2 as subtotal, b.numeracion_07, b.sumatoria_igv_18_1 as igv, b.importe_total_23 as total, b.estado from boleta b inner join empresa e on b.idempresa=e.idempresa where year(b.fecha_emision_01)='$ano' and month(b.fecha_emision_01)='$mes' and day(b.fecha_emision_01)='$dia' and b.estado in ('5','6','1') and e.idempresa='$idempresa' and b.tipo_moneda_24='$tmoneda'
             union all 
             select b.idboleta, b.tipo_documento_06 , b.fecha_emision_01, b.monto_15_2 as subtotal, b.numeracion_07, b.sumatoria_igv_18_1 as igv, b.importe_total_23 as total, b.estado from notapedido b inner join empresa e on b.idempresa=e.idempresa where year(b.fecha_emision_01)='$ano' and month(b.fecha_emision_01)='$mes' and day(b.fecha_emision_01)='$dia' and b.estado in ('1') and e.idempresa='$idempresa' and b.tipo_moneda_24='$tmoneda'
             )
              as tabla order by fecha ";
        return ejecutarConsulta($sql);
    }

    public function regventaServicio($ano, $mes, $dia)
    {
        $sql="select idfactura as id,
        tipo_documento_07 as tipodocu, 
        date_format(fecha_emision_01, '%d %h:%i %p') as fecha, 
        numeracion_08 as documento, 
        format(total_operaciones_gravadas_monto_18_2,2)as subtotal, 
        format(sumatoria_igv_22_1,2) as igv, 
        format(importe_total_venta_27,2) as total,         estado 
        from 
        facturaservicio where year(fecha_emision_01)='$ano'  and month(fecha_emision_01)='$mes' and day(fecha_emision_01)='$dia' and estado in ('5','6','1') ";
        return ejecutarConsulta($sql);
    }



     public function cambiarestadosistema($estado, $idcomm, $tipodoc)
    {
        if ($tipodoc=='01') {
            $sql="update factura set estadosistema='$estado' where idfactura='$idcomm'";
        }else{
            $sql="update boleta set estadosistema='$estado' where idboleta='$idcomm'";
        }
        return ejecutarConsulta($sql);
    }



     public function reporteestadosistema($f1, $f2, $tcom, $estsunat, $estsistema)
    {

       if ($tcom=='00') {
          $tcFactura='01';
          $tcBoleta='03';
        }elseif($tcom=='01'){
            $tcFactura='01';
            $tcBoleta='';
        }else{
              $tcFactura='';
              $tcBoleta='03';
        }
        
            $sql="select
                  date_format(fechaemision, '%d-%m-%Y') as fechaemision,
                  cliente, 
                  comprobante,
                  total,
                  DetalleSunat,
                  estado,
                  estadosistema
                  from
                  (select fecha_emision_01 as fechaemision, p.nombre_comercial as cliente, numeracion_08 as comprobante, importe_total_venta_27 as total, f.DetalleSunat, f.estado, f.estadosistema from factura f inner join persona p on f.idcliente=p.idpersona where date_format(fecha_emision_01,'%Y-%m-%d') BETWEEN '$f1' and '$f2' and  f.tipo_documento_07='$tcFactura' and f.estado in($estsunat) and f.estadosistema in($estsistema)
                  union all
                   select fecha_emision_01 as fechaemision, p.nombre_comercial as cliente, numeracion_07 as comprobante, importe_total_23 as total, b.DetalleSunat, b.estado, b.estadosistema from boleta b inner join persona p on b.idcliente=p.idpersona where date_format(fecha_emision_01,'%Y-%m-%d') BETWEEN '$f1' and '$f2' and  b.tipo_documento_06='$tcBoleta' and b.estado in($estsunat) and b.estadosistema in($estsistema))
            as tabla";
        
        return ejecutarConsulta($sql);
    }




    public function regventaagruxdia($ano, $mes, $idempresa, $tmon)
    {
        $sql="select date_format(fecha_emision_01, '%d/%m/%y') as fecha, 
        format(sum(subtotal),2) as subtotal, 
        format(sum(igv),2) as igv, 
        format(sum(total),2) as total
            from 
            (select f.fecha_emision_01, f.total_operaciones_gravadas_monto_18_2 as subtotal, f.numeracion_08, f.sumatoria_igv_22_1 as igv, f.importe_total_venta_27 as total, f.estado 
            from factura f inner join empresa e on f.idempresa=e.idempresa where year(f.fecha_emision_01)='$ano'  and month(f.fecha_emision_01)='$mes'  and f.estado in ('5','6','1') and e.idempresa='$idempresa' and f.tipo_moneda_28='$tmon'
            union all 
            
            select b.fecha_emision_01, b.monto_15_2 as subtotal, b.numeracion_07, b.sumatoria_igv_18_1 as igv, b.importe_total_23 as total, b.estado from boleta b inner join empresa e on b.idempresa=e.idempresa where year(b.fecha_emision_01)='$ano' and month(b.fecha_emision_01)='$mes' and b.estado in ('5','6','1') and e.idempresa='$idempresa' and b.tipo_moneda_24='$tmon'
            union all
            
             select ncd.fecha, if(ncd.codigo_nota='07', ncd.total_val_venta_og *-1, ncd.total_val_venta_og) as subtotal, ncd.numeroserienota, if (ncd.codigo_nota='07', ncd.sum_igv * -1, ncd.sum_igv) as igv, if(ncd.codigo_nota='07',ncd.importe_total * -1, ncd.importe_total) as total, ncd.estado 
             from notacd ncd inner join empresa e on ncd.idempresa=e.idempresa where year(ncd.fecha)='$ano' and month(ncd.fecha)='$mes' and ncd.estado in('5','6','1') and e.idempresa='$idempresa' and ncd.tipo_moneda='$tmon'
             ) 

            as tabla  group by fecha order by fecha";
        return ejecutarConsulta($sql);
    }



    public function regventaagruxdianotap($ano, $mes, $idempresa)
    {
        $sql="
            select 
            date_format(fecha_emision_01, '%d/%m/%y') as fecha, 
            format(sum(importe_total_23),2) as total 
            from 
            notapedido np inner join empresa e on np.idempresa=e.idempresa 
            where 
            year(np.fecha_emision_01)='$ano'  and month(np.fecha_emision_01)='$mes'  and np.estado in ('5','1') and e.idempresa='$idempresa'
              group by fecha order by fecha ";
        return ejecutarConsulta($sql);
    }

   public function regbajas($ano, $mes, $dia, $idempresa)
   {
        $sql="select
        id,
        tipocomp as tipodocu, 
        date_format(fecha_baja, '%Y-%m-%d') as fecha, 
        numer as documento, 
        format(subtotal,2) as subtotal, 
        format(igv,2) as igv, 
        format(total,2) as total, 
        est, 
        comentario_baja 
        from 
          (select
        idfactura as id, 
        tipo_documento_07 as tipocomp, 
        fecha_baja, 
        numeracion_08 as numer,
        total_operaciones_gravadas_monto_18_2 as subtotal, 
        sumatoria_igv_22_1 as igv, 
        importe_total_venta_27 as total, 
        f.estado as est,
        comentario_baja 
        from 
        factura f inner join persona p on f.idcliente=p.idpersona inner join empresa e on f.idempresa=e.idempresa
        where year(fecha_baja)='$ano' and month(fecha_baja)='$mes' and day(fecha_baja)='$dia' and f.estado='3' and e.idempresa='$idempresa' 
        union all
        select
        idnota as id, 
        codigo_nota as tipocomp, 
        n.fecha_baja, 
        numeroserienota as numer,
        total_val_venta_og as subtotal, 
        sum_igv as igv, 
        importe_total as total, 
        n.estado as est,
        comentario_baja
        from 
        notacd n 
        where year(fecha_baja)='$ano' and month(fecha_baja)='$mes' and day(fecha_baja)='$dia' and n.estado='3'
        ) as tabla  
        order by fecha desc";
        return ejecutarConsulta($sql);
    }



    public function bajanc($ano, $mes, $dia, $idempresa)
   {
        $sql="
        select
        nc.idnota as id,
        nc.fecha_baja as fecha, 
        numeroserienota as numer,
        total_val_venta_og as subtotal, 
        sum_igv as igv, 
        importe_total as total, 
        nc.estado as est,
        nc.comentario_baja 
        from 
        notacd nc inner join factura f on nc.idcomprobante=f.idfactura
        inner join persona p on f.idcliente=p.idpersona 
        inner join empresa e on f.idempresa=e.idempresa
        where year(nc.fecha_baja)='$ano' and month(nc.fecha_baja)='$mes' and day(nc.fecha_baja)='$dia' and nc.estado='3' and e.idempresa='$idempresa'  
        order by fecha desc";
        return ejecutarConsulta($sql);
    }


 public function resumend($ano, $mes, $dia, $st)
 {
$sql="
select 
idboleta as id,
date_format(fecha, '%Y-%m-%d') as fechagedoc, 
date_format(curdate(), '%Y-%m-%d') as fechagerres,
tipocomp as tipocomp, 
numerodoc as serienum, 
tipodocuCliente, 
rucCliente, 
tmoneda, 
subtotal, 
igv,
total,
estado, 
comentario_baja  
  from 
  (select
  idboleta, 
fecha_emision_01 as fecha, 
numeracion_07 as serie,
tipodocuCliente, 
rucCliente, 
RazonSocial, 
tipo_moneda_24 as tmoneda, 
monto_15_2 as subtotal, 
sumatoria_igv_18_1 as igv, 
importe_total_23 as total, 
tipo_documento_06 as tipocomp, 
numeracion_07 as numerodoc, 
b.estado, 
comentario_baja 
   from 
   boleta b inner join persona p on b.idcliente=p.idpersona  inner join empresa e on b.idempresa=e.idempresa
where year(fecha_emision_01)='$ano' and month(fecha_emision_01)='$mes' and day(fecha_emision_01)='$dia' 
and b.estado='$st' 
union all
select
  idboleta, 
fecha_emision_01 as fecha, 
numeracion_07 as serie,
tipodocuCliente, 
rucCliente, 
RazonSocial, 
tipo_moneda_24 as tmoneda, 
monto_15_2 as subtotal, 
sumatoria_igv_18_1 as igv, 
importe_total_23 as total, 
tipo_documento_06 as tipocomp, 
numeracion_07 as numerodoc, 
b.estado, 
comentario_baja 
   from 
   boletaservicio b inner join persona p on b.idcliente=p.idpersona  inner join empresa e on b.idempresa=e.idempresa
where year(fecha_emision_01)='$ano' and month(fecha_emision_01)='$mes' and day(fecha_emision_01)='$dia' 
and b.estado='$st'
) as tabla order by fechagedoc";
        return ejecutarConsulta($sql);
    }

public function descargaSUNAT($ano,$mes,$dia){
$sql="select 
date_format(fecha_emision_01, '%d-%m-%y') as fecha, 
substring_index(numeracion_08,'-',1) as serie, 
tipodocuCliente, 
rucCliente, 
RazonSocial, 
tipo_moneda_28, 
total_operaciones_gravadas_monto_18_2 as subtotal, 
sumatoria_igv_22_1 as igv, 
importe_total_venta_27 as total 
from 
(
select 
fecha_emision_01, 
numeracion_08, 
tipodocuCliente, 
rucCliente,
RazonSocial, 
tipo_moneda_28, 
total_operaciones_gravadas_monto_18_2, 
sumatoria_igv_22_1, 
importe_total_venta_27 
from 
factura where year(fecha_emision_01)='$ano' and month(fecha_emision_01)='$mes' and day(fecha_emision_01)='$dia' union all 
 select 
 fecha_emision_01, 
 numeracion_07,  
 tipodocuCliente, 
 rucCliente,
 RazonSocial, 
 tipo_moneda_24,  
 monto_15_2, 
 sumatoria_igv_18_1, 
 importe_total_23 
 from 
 boleta  where year(fecha_emision_01)='$ano' and month(fecha_emision_01)='$mes' and day(fecha_emision_01)='$dia') as tbventa order by fecha";
        return ejecutarConsulta($sql);
    }

    

    public function ventasxClienteTotales($ndocu, $ano , $mes, $fpago){
$sql="select sum(total_operaciones_gravadas_monto_18_2) as subtotal, sum(sumatoria_igv_22_1) as igv, sum(icbper) as icbper  ,sum(importe_total_venta_27) as total 
from 
(select 
f.total_operaciones_gravadas_monto_18_2, f.sumatoria_igv_22_1, f.icbper  , f.importe_total_venta_27
from
factura f inner join persona p on f.idcliente=p.idpersona  inner join empresa e on f.idempresa=e.idempresa 
where 
f.estado in('1','4','5') and  p.numero_documento='$ndocu' and year(f.fecha_emision_01)='$ano' and month(f.fecha_emision_01) in($mes) and f.tipopago='$fpago' 
) as tabla ";
    return ejecutarConsulta($sql);
    }

    public function ventasxClienteTotalesCantidad($ndocu, $ano, $mes, $fpago){
$sql="select sum(cantidad) as tcantidad 
from 
(select dtf.cantidad_item_12 as cantidad from 
factura f inner join persona p on f.idcliente=p.idpersona inner join detalle_fac_art dtf on f.idfactura=dtf.idfactura 
where 
p.numero_documento='$ndocu' and year(f.fecha_emision_01)='$ano' and month(f.fecha_emision_01) in($mes) and f.estado in ('1', '4', '5') and f.tipopago='$fpago'
)
as tabla ";
    return ejecutarConsulta($sql);
    }


    public function regventareporte($ano, $mes, $idempresa, $tmon){
        $sql="select 
        idfactura as id,
        tipo_documento_07 as tipodocu, 
        date_format(fecha_emision_01, '%d') as fecha, 
        numeracion_08 as documento,
        format(subtotal,2)as subtotal, 
        format(igv,2) as igv, 
        format(total,2) as total, 
        estado, 
        numero_documento, 
        razon_social,
        format(icbper,2) as icbper,
        tipofactura,
        tipomoneda,
        tcambio
            from 
            (select f.idfactura, f.tipo_documento_07 ,f.fecha_emision_01,  f.total_operaciones_gravadas_monto_18_2 as subtotal,  f.numeracion_08, f.sumatoria_igv_22_1 as igv, f.importe_total_venta_27 as total, f.estado, p.numero_documento, p.razon_social, f.icbper,f.tipofactura, f.tipo_moneda_28 as tipomoneda, f.tcambio 
            from 
            factura f inner join persona p on f.idcliente=p.idpersona inner join empresa e on f.idempresa=e.idempresa where year(f.fecha_emision_01)='$ano' and month(f.fecha_emision_01)='$mes' and p.tipo_persona='CLIENTE' and f.estado in('5','3','0','6','1','4')  and e.idempresa='$idempresa' and f.tipo_moneda_28='$tmon'
             union all
             
            select  b.idboleta, b.tipo_documento_06 ,b.fecha_emision_01, b.monto_15_2 as subtotal, b.numeracion_07, b.sumatoria_igv_18_1 as igv, b.importe_total_23 as total, b.estado, p.numero_documento , p.razon_social, b.icbper, b.tipoboleta, b.tipo_moneda_24 as tipomoneda, b.tcambio 
            from 
            boleta b inner join persona p on b.idcliente=p.idpersona inner join empresa e on b.idempresa=e.idempresa 
            where 
            year(b.fecha_emision_01)='$ano' and month(b.fecha_emision_01)='$mes' and p.tipo_persona='CLIENTE' and b.estado in('5','3', '0','6','1','4') and e.idempresa='$idempresa' and b.tipo_moneda_24='$tmon'
             union all
             
             select  np.idboleta, np.tipo_documento_06 ,np.fecha_emision_01, np.monto_15_2 as subtotal, np.numeracion_07, np.sumatoria_igv_18_1 as igv, np.importe_total_23 as total, np.estado, p.numero_documento , p.razon_social, np.icbper, np.tiponota, np.tipo_moneda_24 as tipomoneda, np.tcambio 
             from 
             notapedido np inner join persona p on np.idcliente=p.idpersona inner join empresa e on np.idempresa=e.idempresa 
             where 
             year(np.fecha_emision_01)='$ano' and month(np.fecha_emision_01)='$mes' and p.tipo_persona='CLIENTE' and np.estado in('5','3', '0','6','1','1','4') and e.idempresa='$idempresa' and np.tipo_moneda_24='$tmon'

            union all 
             select   ncd.idnota, ncd.codigo_nota, ncd.fecha,  if(ncd.codigo_nota='07', ncd.total_val_venta_og *-1 , ncd.total_val_venta_og) as subtotal, ncd.numeroserienota, if (ncd.codigo_nota='07', ncd.sum_igv * -1, ncd.sum_igv) as igv, if(ncd.codigo_nota='07',ncd.importe_total * -1,ncd.importe_total)  as total, ncd.estado, p.numero_documento , p.razon_social, ncd.icbper, ncd.tiponotacd, ncd.tipo_moneda as tipomoneda, ncd.tcambio 
             from 
             notacd ncd inner join factura f on ncd.idcomprobante=f.idfactura inner join persona p on  f.idcliente=p.idpersona inner join empresa e on ncd.idempresa=e.idempresa 
             where 
             year(ncd.fecha)='$ano' and month(ncd.fecha)='$mes' and p.tipo_persona='CLIENTE' and ncd.estado in('5','3','0','1','4') and e.idempresa='$idempresa' and ncd.tipo_moneda='$tmon'
             ) 
            as tabla order by fecha asc";
        return ejecutarConsulta($sql);
            }





            public function regventareporteFacturaDia($idempresa){
        $sql="select 
        idfactura as id,
        tipo_documento_07 as tipodocu, 
        date_format(fecha_emision_01, '%d') as fecha, 
        numeracion_08 as documento,
        format(subtotal,2)as subtotal, 
        format(igv,2) as igv, 
        format(total,2) as total, 
        estado, 
        numero_documento, 
        razon_social,
        hora,
        tmoneda,
        tcambio
            from 
            (select 
            f.idfactura, 
            f.tipo_documento_07,
            f.fecha_emision_01, 
            if(tipo_moneda_28='USD',f.total_operaciones_gravadas_monto_18_2*f.tcambio,f.total_operaciones_gravadas_monto_18_2) as subtotal,
            f.numeracion_08, 
            if(f.tipo_moneda_28='USD',f.sumatoria_igv_22_1*f.tcambio, f.sumatoria_igv_22_1) as igv, 
            if(f.tipo_moneda_28='USD',f.importe_total_venta_27*f.tcambio,f.importe_total_venta_27) as total, 
            f.estado, 
            p.numero_documento, 
            p.razon_social, 
            date_format(f.fecha_emision_01,'%H  %r') as hora, 
            f.tipo_moneda_28 as tmoneda, 
            f.tcambio
            from 
            factura f inner join persona p on f.idcliente=p.idpersona inner join empresa e on f.idempresa=e.idempresa where 
        date(fecha_emision_01)=current_date  and p.tipo_persona='CLIENTE' and f.estado in('5','3','1','6')  and e.idempresa='$idempresa'
             )
             as tabla order by fecha asc";
        return ejecutarConsulta($sql);
            }



            public function regventareporteFacServturaDia($idempresa){
        $sql="select 
            idfactura as id,
        tipo_documento_07 as tipodocu, 
        date_format(fecha_emision_01, '%d') as fecha, 
        numeracion_08 as documento,
        format(subtotal,2)as subtotal, 
        format(igv,2) as igv, 
        format(total,2) as total, 
        estado, 
        numero_documento, 
        razon_social,
        hora
            from 
            (
             select f.idfactura, f.tipo_documento_07 ,f.fecha_emision_01, f.total_operaciones_gravadas_monto_18_2 as subtotal, f.numeracion_08, f.sumatoria_igv_22_1 as igv, f.importe_total_venta_27 as total, f.estado, p.numero_documento, p.razon_social, date_format(f.fecha_emision_01,'%H  %r') as hora from facturaservicio f inner join persona p on f.idcliente=p.idpersona inner join empresa e on f.idempresa=e.idempresa where
        date(fecha_emision_01)=current_date  and p.tipo_persona='CLIENTE' and f.estado in('5','3','1')  and e.idempresa='$idempresa')
             as tabla order by fecha asc";
        return ejecutarConsulta($sql);
            }




            public function regventareporteBoletaDia($idempresa){
        $sql="select 
        idboleta as id,
        tipo_documento_06 as tipodocu, 
        date_format(fecha_emision_01, '%d') as fecha, 
        numeracion_07 as documento,
        format(subtotal,2)as subtotal, 
        format(igv,2) as igv, 
        format(total,2) as total, 
        estado, 
        numero_documento, 
        razon_social,
        hora
            from 
            (select  
            b.idboleta, 
            b.tipo_documento_06,
            b.fecha_emision_01, 
            if(tipo_moneda_24='USD',b.monto_15_2 * b.tcambio, b.monto_15_2) as subtotal, 
            b.numeracion_07,
            if(tipo_moneda_24='USD',b.sumatoria_igv_18_1 * b.tcambio, b.sumatoria_igv_18_1) as igv, 
            if(tipo_moneda_24='USD',b.importe_total_23 * b.tcambio, b.importe_total_23) as total, 
            b.estado, 
            p.numero_documento, 
            p.razon_social, date_format(b.fecha_emision_01,'%H  %r') as hora from boleta b inner join persona p on b.idcliente=p.idpersona inner join empresa e on b.idempresa=e.idempresa where date(fecha_emision_01)=current_date and p.tipo_persona='CLIENTE' and b.estado in('5','3', '1','4', '6') and e.idempresa='$idempresa'
            ) as tabla order by fecha asc
             ";
        return ejecutarConsulta($sql);
            }



              public function regventareportenpDia($idempresa){
        $sql="select 
        idboleta as id,
        tipo_documento_06 as tipodocu, 
        date_format(fecha_emision_01, '%d') as fecha, 
        numeracion_07 as documento,
        format(subtotal,2)as subtotal, 
        format(igv,2) as igv, 
        format(total,2) as total, 
        estado, 
        numero_documento, 
        razon_social,
        hora
            from 
            (select  np.idboleta, np.tipo_documento_06 ,np.fecha_emision_01, np.monto_15_2 as subtotal, np.numeracion_07, np.sumatoria_igv_18_1 as igv, np.importe_total_23 as total, np.estado, p.numero_documento , p.razon_social, date_format(np.fecha_emision_01,'%H  %r') as hora 
            from notapedido np inner join persona p on np.idcliente=p.idpersona inner join empresa e on np.idempresa=e.idempresa where date(fecha_emision_01)=current_date and p.tipo_persona='CLIENTE' and np.estado in('5','3', '1','4', '6') and e.idempresa='$idempresa'
            ) as tabla order by fecha asc
             ";
        return ejecutarConsulta($sql);
            }



            public function regventareporteBoleServtaDia($idempresa){
        $sql="select 
        idboleta as id,
        tipo_documento_06 as tipodocu, 
        date_format(fecha_emision_01, '%d') as fecha, 
        numeracion_07 as documento,
        format(subtotal,2)as subtotal, 
        format(igv,2) as igv, 
        format(total,2) as total, 
        estado, 
        numero_documento, 
        razon_social,
        hora
            from 
            (select  b.idboleta, b.tipo_documento_06 ,b.fecha_emision_01, b.monto_15_2 as subtotal, b.numeracion_07, b.sumatoria_igv_18_1 as igv, b.importe_total_23 as total, b.estado, p.numero_documento , p.razon_social, date_format(b.fecha_emision_01,'%H  %r') as hora from boletaservicio b inner join persona p on b.idcliente=p.idpersona inner join empresa e on b.idempresa=e.idempresa where date(fecha_emision_01)=current_date and p.tipo_persona='CLIENTE' and b.estado in('5','3', '1') and e.idempresa='$idempresa'
             ) as tabla order by fecha asc
             ";
        return ejecutarConsulta($sql);
            }


    public function regventareportetotales($ano, $mes, $idempresa, $tmoneda){
        $sql="select  sum(subtotal) as subtotal, sum(igv) as igv,  sum(icbper) as icbper , sum(total) as total
         from 
            (select f.idfactura, f.tipo_documento_07 ,f.fecha_emision_01, f.total_operaciones_gravadas_monto_18_2 as subtotal, f.numeracion_08, f.sumatoria_igv_22_1 as igv, f.importe_total_venta_27 as total, f.estado, p.numero_documento, p.razon_social, f.icbper 
            from 
            factura f inner join persona p on f.idcliente=p.idpersona inner join empresa e on f.idempresa=e.idempresa where year(f.fecha_emision_01)='$ano' and month(f.fecha_emision_01)='$mes' and p.tipo_persona='CLIENTE' and f.estado in('5','6','1','4')  and e.idempresa='$idempresa' and f.tipo_moneda_28='$tmoneda'
            union all 
            
            select  b.idboleta, b.tipo_documento_06 ,b.fecha_emision_01, b.monto_15_2 as subtotal, b.numeracion_07, b.sumatoria_igv_18_1 as igv, b.importe_total_23 as total, b.estado, p.numero_documento , p.razon_social, b.icbper from boleta b inner join persona p on b.idcliente=p.idpersona inner join empresa e on b.idempresa=e.idempresa where year(b.fecha_emision_01)='$ano' and month(b.fecha_emision_01)='$mes' and p.tipo_persona='CLIENTE' and b.estado in('5','6','1','4') and e.idempresa='$idempresa' and b.tipo_moneda_24='$tmoneda'
            union all


            select  np.idboleta, np.tipo_documento_06 , np.fecha_emision_01, np.monto_15_2 as subtotal, np.numeracion_07, np.sumatoria_igv_18_1 as igv, np.importe_total_23 as total, np.estado, p.numero_documento , p.razon_social, np.icbper from notapedido np inner join persona p on np.idcliente=p.idpersona inner join empresa e on np.idempresa=e.idempresa where year(np.fecha_emision_01)='$ano' and month(np.fecha_emision_01)='$mes' and p.tipo_persona='CLIENTE' and np.estado in('5','6','1','4') and e.idempresa='$idempresa' and np.tipo_moneda_24='$tmoneda'
            union all

            select   ncd.idnota, ncd.codigo_nota, ncd.fecha, ncd.total_val_venta_og *-1 as subtotal, ncd.numeroserienota, ncd.sum_igv * -1 as igv, ncd.importe_total * -1 as total, ncd.estado, p.numero_documento , p.razon_social, ncd.icbper from notacd ncd inner join factura f on ncd.idcomprobante=f.idfactura inner join persona p on  f.idcliente=p.idpersona inner join empresa e on ncd.idempresa=e.idempresa where year(ncd.fecha)='$ano' and month(ncd.fecha)='$mes' and p.tipo_persona='CLIENTE' and ncd.estado in('5','1','4') and e.idempresa='$idempresa' and ncd.codigo_nota='07' and ncd.difComprobante='01' and ncd.tipo_moneda='$tmoneda'
             union all
             select   ncd.idnota, ncd.codigo_nota, ncd.fecha, ncd.total_val_venta_og *-1 as subtotal, ncd.numeroserienota, ncd.sum_igv * -1 as igv, ncd.importe_total * -1 as total, ncd.estado, p.numero_documento , p.razon_social, ncd.icbper from notacd ncd inner join facturaservicio f on ncd.idcomprobante=f.idfactura inner join persona p on  f.idcliente=p.idpersona inner join empresa e on ncd.idempresa=e.idempresa where year(ncd.fecha)='$ano' and month(ncd.fecha)='$mes' and p.tipo_persona='CLIENTE' and ncd.estado in('5','1','4') and e.idempresa='$idempresa' and ncd.codigo_nota='07' and ncd.difComprobante='04' and ncd.tipo_moneda='$tmoneda'
             union all
             select   ncd.idnota, ncd.codigo_nota, ncd.fecha, ncd.total_val_venta_og *-1 as subtotal, ncd.numeroserienota, ncd.sum_igv * -1 as igv, ncd.importe_total * -1 as total, ncd.estado, p.numero_documento , p.razon_social, ncd.icbper from notacd ncd inner join boleta b on ncd.idcomprobante=b.idboleta inner join persona p on  b.idcliente=p.idpersona inner join empresa e on ncd.idempresa=e.idempresa where year(ncd.fecha)='$ano' and month(ncd.fecha)='$mes' and p.tipo_persona='CLIENTE' and ncd.estado in('5','1','4') and e.idempresa='$idempresa' and ncd.codigo_nota='07' and ncd.difComprobante='03' and ncd.tipo_moneda='$tmoneda'
             union all
             select   ncd.idnota, ncd.codigo_nota, ncd.fecha, ncd.total_val_venta_og *-1 as subtotal, ncd.numeroserienota, ncd.sum_igv * -1 as igv, ncd.importe_total * -1 as total, ncd.estado, p.numero_documento , p.razon_social, ncd.icbper from notacd ncd inner join boletaservicio b on ncd.idcomprobante=b.idboleta inner join persona p on  b.idcliente=p.idpersona inner join empresa e on ncd.idempresa=e.idempresa where year(ncd.fecha)='$ano' and month(ncd.fecha)='$mes' and p.tipo_persona='CLIENTE' and ncd.estado in('5','1','4') and e.idempresa='$idempresa' and ncd.codigo_nota='07' and ncd.difComprobante='05' and ncd.tipo_moneda='$tmoneda'
              union all 
             select   ncd.idnota, ncd.codigo_nota, ncd.fecha, ncd.total_val_venta_og as subtotal, ncd.numeroserienota, ncd.sum_igv  as igv, ncd.importe_total  as total, ncd.estado, p.numero_documento , p.razon_social, ncd.icbper from notacd ncd inner join factura f on ncd.idcomprobante=f.idfactura inner join persona p on  f.idcliente=p.idpersona inner join empresa e on ncd.idempresa=e.idempresa where year(ncd.fecha)='$ano' and month(ncd.fecha)='$mes' and p.tipo_persona='CLIENTE' and ncd.estado in('5','1','4') and e.idempresa='$idempresa' and ncd.codigo_nota='08' and ncd.difComprobante='01' and ncd.tipo_moneda='$tmoneda'
             union all
             select   ncd.idnota, ncd.codigo_nota, ncd.fecha, ncd.total_val_venta_og as subtotal, ncd.numeroserienota, ncd.sum_igv  as igv, ncd.importe_total  as total, ncd.estado, p.numero_documento , p.razon_social, ncd.icbper from notacd ncd inner join facturaservicio f on ncd.idcomprobante=f.idfactura inner join persona p on  f.idcliente=p.idpersona inner join empresa e on ncd.idempresa=e.idempresa where year(ncd.fecha)='$ano' and month(ncd.fecha)='$mes' and p.tipo_persona='CLIENTE' and ncd.estado in('5','1','4') and e.idempresa='$idempresa' and ncd.codigo_nota='08' and ncd.difComprobante='04' and ncd.tipo_moneda='$tmoneda'
              union all
             select   ncd.idnota, ncd.codigo_nota, ncd.fecha, ncd.total_val_venta_og as subtotal, ncd.numeroserienota, ncd.sum_igv  as igv, ncd.importe_total  as total, ncd.estado, p.numero_documento , p.razon_social, ncd.icbper from notacd ncd inner join boleta b on ncd.idcomprobante=b.idboleta inner join persona p on  b.idcliente=p.idpersona inner join empresa e on ncd.idempresa=e.idempresa where year(ncd.fecha)='$ano' and month(ncd.fecha)='$mes' and p.tipo_persona='CLIENTE' and ncd.estado in('5','1','4') and e.idempresa='$idempresa' and ncd.codigo_nota='08' and ncd.difComprobante='03' and ncd.tipo_moneda='$tmoneda'
             union all
             select   ncd.idnota, ncd.codigo_nota, ncd.fecha, ncd.total_val_venta_og as subtotal, ncd.numeroserienota, ncd.sum_igv  as igv, ncd.importe_total  as total, ncd.estado, p.numero_documento , p.razon_social, ncd.icbper from notacd ncd inner join boletaservicio b on ncd.idcomprobante=b.idboleta inner join persona p on  b.idcliente=p.idpersona inner join empresa e on ncd.idempresa=e.idempresa where year(ncd.fecha)='$ano' and month(ncd.fecha)='$mes' and p.tipo_persona='CLIENTE' and ncd.estado in('5','1','4') and e.idempresa='$idempresa' and ncd.codigo_nota='08' and ncd.difComprobante='05' and ncd.tipo_moneda='$tmoneda'
            ) 
            as tabla";
        return ejecutarConsulta($sql);
        }




          public function regventareportetotalesnotap($ano, $mes, $idempresa){
        $sql="select 
            format(sum(importe_total_23),2) as total 
            from 
            notapedido np inner join empresa e on np.idempresa=e.idempresa 
            where 
            year(np.fecha_emision_01)='$ano'  and month(np.fecha_emision_01)='$mes'  and np.estado in ('5','1') and e.idempresa='$idempresa'";
        return ejecutarConsulta($sql);
        }

          public function regventareportetotalesFacturaDia($idempresa){
        $sql="select  sum(subtotal) as subtotal, sum(igv) as igv, sum(total) as total
         from 
            (select 
            if(tipo_moneda_28='USD',f.total_operaciones_gravadas_monto_18_2*f.tcambio,f.total_operaciones_gravadas_monto_18_2) as subtotal,
            if(f.tipo_moneda_28='USD',f.sumatoria_igv_22_1*f.tcambio, f.sumatoria_igv_22_1) as igv,
            if(f.tipo_moneda_28='USD',f.importe_total_venta_27*f.tcambio,f.importe_total_venta_27) as total
            from factura f inner join persona p on f.idcliente=p.idpersona inner join empresa e on f.idempresa=e.idempresa where  date(fecha_emision_01)=current_date  and p.tipo_persona='CLIENTE' and f.estado in('5','1','6')  and e.idempresa='$idempresa'
            )
            as tabla";
        return ejecutarConsulta($sql);
        }


        public function regventareportetotalesFacturaServDia($idempresa){
        $sql="select  sum(subtotal) as subtotal, sum(igv) as igv, sum(total) as total
         from 
            (
            select f.idfactura, f.tipo_documento_07 ,f.fecha_emision_01, f.total_operaciones_gravadas_monto_18_2 as subtotal, f.numeracion_08, f.sumatoria_igv_22_1 as igv, f.importe_total_venta_27 as total, f.estado, p.numero_documento, p.razon_social from facturaservicio f inner join persona p on f.idcliente=p.idpersona inner join empresa e on f.idempresa=e.idempresa where  date(fecha_emision_01)=current_date  and p.tipo_persona='CLIENTE' and f.estado in('5','1')  and e.idempresa='$idempresa')
            as tabla";
        return ejecutarConsulta($sql);
        }

          public function regventareportetotalesBoletaDia($idempresa){
        $sql="select  sum(subtotal) as subtotal, sum(igv) as igv, sum(total) as total
         from 
            (
            select  b.idboleta, b.tipo_documento_06 ,b.fecha_emision_01, b.monto_15_2 as subtotal, b.numeracion_07, b.sumatoria_igv_18_1 as igv, b.importe_total_23 as total, b.estado, p.numero_documento , p.razon_social from boleta b inner join persona p on b.idcliente=p.idpersona inner join empresa e on b.idempresa=e.idempresa where date(b.fecha_emision_01)=current_date and p.tipo_persona='CLIENTE' and b.estado in('5','1','4','6') and e.idempresa='$idempresa'
            )
            as tabla";
        return ejecutarConsulta($sql);
        }



          public function regventareportetotalesnpDia($idempresa){
        $sql="select  sum(subtotal) as subtotal, sum(igv) as igv, sum(total) as total
         from 
            (
            select  np.idboleta, np.tipo_documento_06 , np.fecha_emision_01, np.monto_15_2 as subtotal, np.numeracion_07, np.sumatoria_igv_18_1 as igv, np.importe_total_23 as total, np.estado, p.numero_documento , p.razon_social from notapedido np inner join persona p on np.idcliente=p.idpersona inner join empresa e on np.idempresa=e.idempresa where date(np.fecha_emision_01)=current_date and p.tipo_persona='CLIENTE' and np.estado in('5','1','4','6') and e.idempresa='$idempresa'
            )
            as tabla";
        return ejecutarConsulta($sql);
        }



        public function regventareportetotalesBoletaSerDia($idempresa){
        $sql="select  sum(subtotal) as subtotal, sum(igv) as igv, sum(total) as total
         from 
            (
           select  b.idboleta, b.tipo_documento_06 ,b.fecha_emision_01, b.monto_15_2 as subtotal, b.numeracion_07, b.sumatoria_igv_18_1 as igv, b.importe_total_23 as total, b.estado, p.numero_documento , p.razon_social from boletaservicio b inner join persona p on b.idcliente=p.idpersona inner join empresa e on b.idempresa=e.idempresa where date(b.fecha_emision_01)=current_date and p.tipo_persona='CLIENTE' and b.estado in('5','1') and e.idempresa='$idempresa')
            as tabla";
        return ejecutarConsulta($sql);
        }




        public function regventareportetotalesNotacredito($ano, $mes, $idempresa, $tmoneda){
        $sql="select  sum(subtotal) as subtotal, sum(igv) as igv, sum(icbper) as icbper,  sum(total) as total
         from 
            (
             select   ncd.idnota, ncd.codigo_nota, ncd.fecha, ncd.total_val_venta_og *-1 as subtotal, ncd.numeroserienota, ncd.sum_igv * -1 as igv, ncd.importe_total * -1 as total, ncd.estado, p.numero_documento , p.razon_social, ncd.icbper from notacd ncd inner join factura f on ncd.idcomprobante=f.idfactura inner join persona p on  f.idcliente=p.idpersona inner join empresa e on ncd.idempresa=e.idempresa where year(ncd.fecha)='$ano' and month(ncd.fecha)='$mes' and p.tipo_persona='CLIENTE' and ncd.estado in('5','1','4') and e.idempresa='$idempresa' and ncd.codigo_nota='07' and ncd.difComprobante='01' and ncd.tipo_moneda='$tmoneda'
             union all
             select   ncd.idnota, ncd.codigo_nota, ncd.fecha, ncd.total_val_venta_og *-1 as subtotal, ncd.numeroserienota, ncd.sum_igv * -1 as igv, ncd.importe_total * -1 as total, ncd.estado, p.numero_documento , p.razon_social, ncd.icbper from notacd ncd inner join facturaservicio f on ncd.idcomprobante=f.idfactura inner join persona p on  f.idcliente=p.idpersona inner join empresa e on ncd.idempresa=e.idempresa where year(ncd.fecha)='$ano' and month(ncd.fecha)='$mes' and p.tipo_persona='CLIENTE' and ncd.estado in('5','1','4') and e.idempresa='$idempresa' and ncd.codigo_nota='07' and ncd.difComprobante='04' and ncd.tipo_moneda='$tmoneda'
             union all
             select   ncd.idnota, ncd.codigo_nota, ncd.fecha, ncd.total_val_venta_og *-1 as subtotal, ncd.numeroserienota, ncd.sum_igv * -1 as igv, ncd.importe_total * -1 as total, ncd.estado, p.numero_documento , p.razon_social, ncd.icbper from notacd ncd inner join boleta b on ncd.idcomprobante=b.idboleta inner join persona p on  b.idcliente=p.idpersona inner join empresa e on ncd.idempresa=e.idempresa where year(ncd.fecha)='$ano' and month(ncd.fecha)='$mes' and p.tipo_persona='CLIENTE' and ncd.estado in('5','1','4') and e.idempresa='$idempresa' and ncd.codigo_nota='07' and ncd.difComprobante='03' and ncd.tipo_moneda='$tmoneda'
             union all
             select   ncd.idnota, ncd.codigo_nota, ncd.fecha, ncd.total_val_venta_og *-1 as subtotal, ncd.numeroserienota, ncd.sum_igv * -1 as igv, ncd.importe_total * -1 as total, ncd.estado, p.numero_documento , p.razon_social, ncd.icbper from notacd ncd inner join boletaservicio b on ncd.idcomprobante=b.idboleta inner join persona p on  b.idcliente=p.idpersona inner join empresa e on ncd.idempresa=e.idempresa where year(ncd.fecha)='$ano' and month(ncd.fecha)='$mes' and p.tipo_persona='CLIENTE' and ncd.estado in('5','1','4') and e.idempresa='$idempresa' and ncd.codigo_nota='07' and ncd.difComprobante='05' and ncd.tipo_moneda='$tmoneda'
            ) 
            as tabla";
        return ejecutarConsulta($sql);
        }

        public function regventareportetotalesNotadebito($ano, $mes, $idempresa , $tmoneda){
        $sql="select  sum(subtotal) as subtotal, sum(igv) as igv, sum(icbper) as icbper,  sum(total) as total
         from 
            (
             select   ncd.idnota, ncd.codigo_nota, ncd.fecha, ncd.total_val_venta_og as subtotal, ncd.numeroserienota, ncd.sum_igv  as igv, ncd.importe_total  as total, ncd.estado, p.numero_documento , p.razon_social, ncd.icbper from notacd ncd inner join factura f on ncd.idcomprobante=f.idfactura inner join persona p on  f.idcliente=p.idpersona inner join empresa e on ncd.idempresa=e.idempresa where year(ncd.fecha)='$ano' and month(ncd.fecha)='$mes' and p.tipo_persona='CLIENTE' and ncd.estado in('5','3','0') and e.idempresa='$idempresa' and ncd.codigo_nota='08' and ncd.difComprobante='01' and ncd.tipo_moneda='$tmoneda'
             union all
             select   ncd.idnota, ncd.codigo_nota, ncd.fecha, ncd.total_val_venta_og as subtotal, ncd.numeroserienota, ncd.sum_igv  as igv, ncd.importe_total  as total, ncd.estado, p.numero_documento , p.razon_social , ncd.icbper from notacd ncd inner join facturaservicio f on ncd.idcomprobante=f.idfactura inner join persona p on  f.idcliente=p.idpersona inner join empresa e on ncd.idempresa=e.idempresa where year(ncd.fecha)='$ano' and month(ncd.fecha)='$mes' and p.tipo_persona='CLIENTE' and ncd.estado in('5','3','0') and e.idempresa='$idempresa' and ncd.codigo_nota='08' and ncd.difComprobante='04' and ncd.tipo_moneda='$tmoneda'
              union all
             select   ncd.idnota, ncd.codigo_nota, ncd.fecha, ncd.total_val_venta_og as subtotal, ncd.numeroserienota, ncd.sum_igv  as igv, ncd.importe_total  as total, ncd.estado, p.numero_documento , p.razon_social , ncd.icbper from notacd ncd inner join boleta b on ncd.idcomprobante=b.idboleta inner join persona p on  b.idcliente=p.idpersona inner join empresa e on ncd.idempresa=e.idempresa where year(ncd.fecha)='$ano' and month(ncd.fecha)='$mes' and p.tipo_persona='CLIENTE' and ncd.estado in('5','3','0') and e.idempresa='$idempresa' and ncd.codigo_nota='08' and ncd.difComprobante='03' and ncd.tipo_moneda='$tmoneda'
             union all
             select   ncd.idnota, ncd.codigo_nota, ncd.fecha, ncd.total_val_venta_og as subtotal, ncd.numeroserienota, ncd.sum_igv  as igv, ncd.importe_total  as total, ncd.estado, p.numero_documento , p.razon_social , ncd.icbper from notacd ncd inner join boletaservicio b on ncd.idcomprobante=b.idboleta inner join persona p on  b.idcliente=p.idpersona inner join empresa e on ncd.idempresa=e.idempresa where year(ncd.fecha)='$ano' and month(ncd.fecha)='$mes' and p.tipo_persona='CLIENTE' and ncd.estado in('5','3','0') and e.idempresa='$idempresa' and ncd.codigo_nota='08' and ncd.difComprobante='05' and ncd.tipo_moneda='$tmoneda'
            ) 
            as tabla";
        return ejecutarConsulta($sql);
        }

        public function regventareportetotalesNotapedido($ano, $mes, $idempresa, $tmoneda){
        $sql="select  sum(subtotal) as subtotal, sum(igv) as igv, sum(icbper) as icbper,  sum(total) as total
         from 
            (
            select  np.idboleta, np.tipo_documento_06 , np.fecha_emision_01, np.monto_15_2 as subtotal, np.numeracion_07, np.sumatoria_igv_18_1 as igv, np.importe_total_23 as total, np.estado, p.numero_documento , p.razon_social, np.icbper 
            from 
            notapedido np inner join persona p on np.idcliente=p.idpersona inner join empresa e on np.idempresa=e.idempresa 
            where 
            year(np.fecha_emision_01)='$ano' and month(np.fecha_emision_01)='$mes' and p.tipo_persona='CLIENTE' and np.estado in('1','5') and e.idempresa='$idempresa' and np.tipo_moneda_24='$tmoneda'
            ) 
            as tabla";
        return ejecutarConsulta($sql);
        }

        public function regventareportetotalesProducto($ano, $mes, $idempresa, $tmoneda){
        $sql="select  sum(subtotal) as subtotal, sum(igv) as igv,  sum(icbper) as icbper, sum(total) as total
         from 
            (select f.idfactura, f.tipo_documento_07 ,f.fecha_emision_01, f.total_operaciones_gravadas_monto_18_2 as subtotal, f.numeracion_08, f.sumatoria_igv_22_1 as igv, f.importe_total_venta_27 as total, f.estado, p.numero_documento, p.razon_social, f.icbper 
            from 
            factura f inner join persona p on f.idcliente=p.idpersona inner join empresa e on f.idempresa=e.idempresa where year(f.fecha_emision_01)='$ano' and month(f.fecha_emision_01)='$mes' and p.tipo_persona='CLIENTE' and f.estado in('5','6','1','4')  and e.idempresa='$idempresa' and f.tipofactura='productos' and f.tipo_moneda_28='$tmoneda'
            union all 
            select  b.idboleta, b.tipo_documento_06 ,b.fecha_emision_01, b.monto_15_2 as subtotal, b.numeracion_07, b.sumatoria_igv_18_1 as igv, b.importe_total_23 as total, b.estado, p.numero_documento , p.razon_social, b.icbper 
            from 
            boleta b inner join persona p on b.idcliente=p.idpersona inner join empresa e on b.idempresa=e.idempresa where year(b.fecha_emision_01)='$ano' and month(b.fecha_emision_01)='$mes' and p.tipo_persona='CLIENTE' and b.estado in('5', '6','1','4','6') and e.idempresa='$idempresa' and b.tipoboleta='productos' and b.tipo_moneda_24='$tmoneda'
            ) 
            as tabla";
        return ejecutarConsulta($sql);
        }


        public function regventareportetotalesServicios($ano, $mes, $idempresa, $tmoneda){
        $sql="select  sum(subtotal) as subtotal, sum(igv) as igv,  sum(icbper) as icbper, sum(total) as total
         from 
            (select f.idfactura, f.tipo_documento_07 ,f.fecha_emision_01, f.total_operaciones_gravadas_monto_18_2 as subtotal, f.numeracion_08, f.sumatoria_igv_22_1 as igv, f.importe_total_venta_27 as total, f.estado, p.numero_documento, p.razon_social, f.icbper 
            from 
            factura f inner join persona p on f.idcliente=p.idpersona inner join empresa e on f.idempresa=e.idempresa where year(f.fecha_emision_01)='$ano' and month(f.fecha_emision_01)='$mes' and p.tipo_persona='CLIENTE' and f.estado in('5','6','1','4')  and e.idempresa='$idempresa' and f.tipofactura='servicios' and f.tipo_moneda_28='$tmoneda'
            union all 
            select  b.idboleta, b.tipo_documento_06 ,b.fecha_emision_01, b.monto_15_2 as subtotal, b.numeracion_07, b.sumatoria_igv_18_1 as igv, b.importe_total_23 as total, b.estado, p.numero_documento , p.razon_social, b.icbper 
            from 
            boleta b inner join persona p on b.idcliente=p.idpersona inner join empresa e on b.idempresa=e.idempresa where year(b.fecha_emision_01)='$ano' and month(b.fecha_emision_01)='$mes' and p.tipo_persona='CLIENTE' and b.estado in('5', '6','1','4','6') and e.idempresa='$idempresa' and b.tipoboleta='servicios' and b.tipo_moneda_24='$tmoneda'
            ) 
            as tabla";
        return ejecutarConsulta($sql);
        }


public function regventareporteAnulados($ano, $mes){
        $sql="select 
        idfactura as id,
        tipo_documento_07 as tipodocu, 
        date_format(fecha_emision_01, '%d') as fecha, 
        numeracion_08 as documento,
        format(subtotal,2)as subtotal, 
        format(igv,2) as igv, 
        format(total,2) as total, 
        estado, 
        numero_documento, 
        razon_social
            from 
            (select f.idfactura, f.tipo_documento_07 ,f.fecha_emision_01, f.total_operaciones_gravadas_monto_18_2 as subtotal, f.numeracion_08, f.sumatoria_igv_22_1 as igv, f.importe_total_venta_27 as total, f.estado, p.numero_documento, p.razon_social from factura f inner join persona p on f.idcliente=p.idpersona where year(f.fecha_emision_01)='$ano' and month(f.fecha_emision_01)='$mes' and p.tipo_persona='CLIENTE' and f.estado in('3') 
            union all 
            select  b.idboleta, b.tipo_documento_06 ,b.fecha_emision_01, b.monto_15_2 as subtotal, b.numeracion_07, b.sumatoria_igv_18_1 as igv, b.importe_total_23 as total, b.estado, p.numero_documento , p.razon_social from boleta b inner join persona p on b.idcliente=p.idpersona where year(b.fecha_emision_01)='$ano' and month(b.fecha_emision_01)='$mes' and p.tipo_persona='CLIENTE' and b.estado in('3') ) 
            as tabla order by fecha";
        return ejecutarConsulta($sql);
}


    public function regventareportetotalesAnulados($ano, $mes){
        $sql="select  sum(subtotal) as subtotal, sum(igv) as igv, sum(total) as total  from 
            (select f.idfactura, f.tipo_documento_07 ,f.fecha_emision_01, f.total_operaciones_gravadas_monto_18_2 as subtotal, f.numeracion_08, f.sumatoria_igv_22_1 as igv, f.importe_total_venta_27 as total, f.estado, p.numero_documento, p.razon_social from factura f inner join persona p on f.idcliente=p.idpersona where year(f.fecha_emision_01)='$ano' and month(f.fecha_emision_01)='$mes' and p.tipo_persona='CLIENTE' and f.estado in('3')
            union all 
            select  b.idboleta, b.tipo_documento_06 ,b.fecha_emision_01, b.monto_15_2 as subtotal, b.numeracion_07, b.sumatoria_igv_18_1 as igv, b.importe_total_23 as total, b.estado, p.numero_documento , p.razon_social from boleta b inner join persona p on b.idcliente=p.idpersona where year(b.fecha_emision_01)='$ano' and month(b.fecha_emision_01)='$mes' and p.tipo_persona='CLIENTE' and b.estado in('3') ) 
            as tabla";
        return ejecutarConsulta($sql);
        }


public function ventasxCliente($ndocu, $ano, $mes, $tipopag){
$sql="
select 
numero_documento, 
razon_social, 
numerofac, 
fechaemision,
subtotal, 
igv, 
total, 
estado, 
moneda,
tipopago 
    from 
    (select
    p.numero_documento, p.razon_social, f.numeracion_08 as numerofac, date_format(f.fecha_emision_01, '%d/%m/%Y') as fechaemision, f.total_operaciones_gravadas_monto_18_2 as subtotal, f.sumatoria_igv_22_1 as igv, f.importe_total_venta_27 as total, f.estado, 
         f.tipo_moneda_28 as moneda, f.tipopago
        from
    factura f inner join persona p on f.idcliente=p.idpersona inner join empresa e on f.idempresa=e.idempresa  
    where 
    p.numero_documento='$ndocu'  and year(f.fecha_emision_01)='$ano' and month(f.fecha_emision_01) in($mes)  and f.estado in ('1','4','5') 
    and f.tipopago='$tipopag'

) as tabla order by  numerofac ";
     return ejecutarConsulta($sql);
    }

    public function ventasxClienteAgrupado($ndocu, $ano , $mes, $fpago){
$sql="select 
razon_social, 
fechaemision, 
unidad_medida, 
numerofac, 
numero_documento, 
cantidad, 
format(subtotal,2) as subtotal, 
format(igv,2) as igv,
total,
icbper,
estado,
moneda ,
tipopago
    from 
    (
    select
    p.razon_social, date_format(f.fecha_emision_01, '%d/%m/%Y') as fechaemision, um.abre as unidad_medida, f.numeracion_08 as numerofac, p.numero_documento,  sum(format(df.cantidad_item_12,2)) as cantidad, sum(df.valor_venta_item_21) as subtotal, sum(df.afectacion_igv_item_16_1) as igv, sum((df.valor_venta_item_21 + df.afectacion_igv_item_16_1)) as total, f.icbper, f.estado,
    f.tipo_moneda_28 as moneda, tipopago 
    from
    factura f inner join detalle_fac_art df on f.idfactura=df.idfactura  inner join articulo a on df.idarticulo=a.idarticulo inner join persona p on f.idcliente=p.idpersona inner join umedida um on a.unidad_medida=um.idunidad  
    where 
    f.estado in('1','4','5','6') and  p.numero_documento='$ndocu' and year(f.fecha_emision_01)='$ano' and month(f.fecha_emision_01) in($mes) and f.tipopago='$fpago' group by f.numeracion_08
    )
    as tabla order by numerofac ";
     return ejecutarConsulta($sql);
    }

    public function ventasxClienteDni($ndocu, $idempresa){
$sql="select 
numero_documento, 
nombres, 
apellidos, 
numerobol as numerobol, 
fechaemision, 
codigo, 
nombre, 
cantidad, 
subtotal,  
igv, 
total, 
unidad_medida,
 moneda
 
    from 
    (select  p.numero_documento, p.nombres, p.apellidos, b.numeracion_07 as numerobol, date_format(b.fecha_emision_01, '%d/%m/%Y') as fechaemision, a.codigo, a.nombre ,format(db.cantidad_item_12,2) as cantidad, db.valor_venta_item_32 as subtotal, db.afectacion_igv_item_monto_27_1 as igv, (db.valor_venta_item_32 + db.afectacion_igv_item_monto_27_1) as total, a.unidad_medida, 
    b.tipo_moneda_24 as moneda   
    from 
    boleta b inner join detalle_boleta_producto db on b.idboleta=db.idboleta  inner join articulo a on db.idarticulo=a.idarticulo inner join persona p on b.idcliente=p.idpersona inner join empresa e on b.idempresa=e.idempresa where p.numero_documento='$ndocu' and e.idempresa='$idempresa'   
    Union all
    select  p.numero_documento, p.nombres, p.apellidos, np.numeracion_07 as numerobol, date_format(np.fecha_emision_01, '%d/%m/%Y') as fechaemision, a.codigo, a.nombre ,format(db.cantidad_item_12,2) as cantidad, db.valor_venta_item_32 as subtotal, db.afectacion_igv_item_monto_27_1 as igv, (db.valor_venta_item_32 + db.afectacion_igv_item_monto_27_1) as total, a.unidad_medida, np.tipo_moneda_24 as moneda 
    from 
    notapedido np inner join detalle_boleta_producto db on np.idboleta=db.idboleta  inner join articulo a on db.idarticulo=a.idarticulo inner join persona p on np.idcliente=p.idpersona inner join empresa e on np.idempresa=e.idempresa where p.numero_documento='$ndocu' and e.idempresa='$idempresa') as tabla order by numero_documento ";
     return ejecutarConsulta($sql);
    }

    public function ventasxClienteTotalesDni($ndocu, $idempresa, $fpago){
$sql="select 
sum(monto_15_2) as subtotal, 
sum(sumatoria_igv_18_1) as igv, 
sum(importe_total_23) as total 
from 
(select
b.monto_15_2, 
b.sumatoria_igv_18_1, 
b.importe_total_23 
from
boleta b inner join persona p on b.idcliente=p.idpersona inner join empresa e on b.idempresa=e.idempresa where p.numero_documento='$ndocu' and e.idempresa='$idempresa' and b.tipopago='$fpago'
)as tabla";
    return ejecutarConsulta($sql);
    }

    public function ventasxClienteTotalesDniCantidad($ndocu, $idempresa, $fpago){
$sql="select sum(db.cantidad_item_12) as tcantidad 
from 
boleta b inner join detalle_boleta_producto db on b.idboleta=db.idboleta inner join persona p on b.idcliente=p.idpersona inner join empresa e on b.idempresa=e.idempresa 
where 
p.numero_documento='$ndocu' and e.idempresa='$idempresa' and b.tipopago='$fpago'";
    return ejecutarConsulta($sql);
    }






    public function datosemp()
    {

    $sql="select * from empresa where idempresa='1'";
    return ejecutarConsulta($sql);      
    }

    public function ventacabeceraConsulta($tipodoc, $nruc , $numero)
    
    {
        $sql="select 
        idfactura,
        idcliente, 
        razon_social,
        nombres, 
        domicilio_fiscal, 
        tipo_documento, 
        numero_documento, 
        email, 
        telefono1, 
        idusuario, 
        nombreusuario,  
        tipo_documento_07,
        nombre_comercial, 
        tipo_documento_07,
        usuario,
        numeracion_08, 
        serie, 
        numerofac, 
        fecha, 
        fecha2, 
        sumatoria_igv_22_1,
        totalLetras,
        itotal,   
        tasa_igv, 
        guia_remision_29_2 as guia, 
        estado,
        numero_ruc, 
        tdescuento,
        subtotal,
        vendedorsitio,
        moneda,
        ipagado,
        saldo,
        tipopago,
        nroreferencia,
        icbper
  from 
  (select 
        f.idfactura, 
        f.idcliente, 
        p.razon_social,
        p.nombres,  
        p.domicilio_fiscal, 
        p.tipo_documento, 
        p.numero_documento, 
        p.email, 
        p.telefono1, 
        f.idusuario,
        u.nombre as nombreusuario,  
        p.nombre_comercial, 
        f.tipo_documento_07,
        concat(u.nombre,' ',u.apellidos) as usuario, 
        f.numeracion_08, 
        right(substring_index(f.numeracion_08,'-',1),4) as serie, 
        right(substring_index(f.numeracion_08,'-',-1),10) as numerofac, 
        date_format(f.fecha_emision_01,'%d-%m-%Y') as fecha, 
        date_format(f.fecha_emision_01,'%Y-%m-%d') as fecha2, 
        f.sumatoria_igv_22_1, 
        f.importe_total_venta_27 as totalLetras, 
        f.importe_total_venta_27 as itotal, 
        f.tasa_igv, 
        f.guia_remision_29_2, 
        f.estado,
        e.numero_ruc, 
        f.tdescuento,
        f.total_operaciones_gravadas_monto_18_2 as subtotal,
        f.vendedorsitio,
        f.tipo_moneda_28 as moneda,
        f.ipagado,
        f.saldo,
        f.tipopago,
        f.nroreferencia,
        f.icbper
        
        
    from 
    factura f inner join persona p on f.idcliente=p.idpersona inner join empresa e 
          on e.idempresa=f.idempresa
          inner join
          usuario u on f.idusuario=u.idusuario where  f.tipo_documento_07='$tipodoc' and p.numero_documento='$nruc' and f.numeracion_08='$numero' and f.estado='5'  union all 

         

  select 
    b.idboleta, 
        b.idcliente, 
        p.razon_social, 
        p.nombres, 
        p.domicilio_fiscal, 
        p.tipo_documento,
        p.numero_documento, 
        p.email, 
        p.telefono1, 
        b.idusuario, 
        u.nombre as nombreusuario, 
        p.nombre_comercial, 
        b.tipo_documento_06,
        concat(u.nombre,' ',u.apellidos) as usuario,  
        b.numeracion_07,
        right(substring_index(b.numeracion_07,'-',1),4) as serie, 
        right(substring_index(b.numeracion_07,'-',-1),10) as numerofac,  
        date_format(b.fecha_emision_01,'%d-%m-%Y') as fecha, 
        date_format(b.fecha_emision_01,'%Y-%m-%d') as fecha2, 
        b.sumatoria_igv_18_1, 
        b.importe_total_23 as totalLetras, 
        b.importe_total_23 as itotal,
    b.tasa_igv,
        b.guia_remision_25,  
        b.estado,
        e.numero_ruc,
        b.tdescuento,
        b.monto_15_2 as subtotal,
        b.vendedorsitio,
        b.tipo_moneda_24 as moneda,
        b.ipagado,
        b.saldo,
        b.tipopago,
        b.nroreferencia,
        b.icbper
      
from 
boleta b inner join persona p on b.idcliente=p.idpersona inner join usuario u on 
        b.idusuario=u.idusuario inner join empresa e on b.idempresa=e.idempresa  where b.tipo_documento_06='$tipodoc' and b.numeracion_07='$numero' and b.estado='5'  
       
    ) as tbventa";
        return ejecutarConsulta($sql);
    }



    public function BuscacabeceraConsulta($tipodoc, $numero, $idempresa)
    
    {
        $sql="select 
        idfactura,
        idcliente, 
        razon_social,
        nombres, 
        domicilio_fiscal, 
        tipo_documento, 
        numero_documento, 
        email, 
        telefono1, 
        idusuario, 
        nombreusuario,  
        tipo_documento_07,
        nombre_comercial, 
        tipo_documento_07,
        usuario,
        numeracion_08, 
        serie, 
        numerofac, 
        fecha, 
        fecha2, 
        sumatoria_igv_22_1,
        totalLetras,
        itotal,   
        tasa_igv, 
        guia_remision_29_2 as guia, 
        estado,
        numero_ruc, 
        tdescuento,
        subtotal,
        vendedorsitio
  from 
  (select 
        f.idfactura, 
        f.idcliente, 
        p.razon_social,
        p.nombres,  
        p.domicilio_fiscal, 
        p.tipo_documento, 
        p.numero_documento, 
        p.email, 
        p.telefono1, 
        f.idusuario,
        u.nombre as nombreusuario,  
        p.nombre_comercial, 
        f.tipo_documento_07,
        concat(u.nombre,' ',u.apellidos) as usuario, 
        f.numeracion_08, 
        right(substring_index(f.numeracion_08,'-',1),4) as serie, 
        right(substring_index(f.numeracion_08,'-',-1),10) as numerofac, 
        date_format(f.fecha_emision_01,'%d-%m-%Y') as fecha, 
        date_format(f.fecha_emision_01,'%Y-%m-%d') as fecha2, 
        f.sumatoria_igv_22_1, 
        f.importe_total_venta_27 as totalLetras, 
        f.importe_total_venta_27 as itotal, 
        f.tasa_igv, 
        f.guia_remision_29_2, 
        f.estado,
        e.numero_ruc, 
        f.tdescuento,
        f.total_operaciones_gravadas_monto_18_2 as subtotal,
        f.vendedorsitio
    from 
    factura f inner join persona p on f.idcliente=p.idpersona inner join empresa e 
          on e.idempresa=f.idempresa
          inner join
          usuario u on f.idusuario=u.idusuario where  f.tipo_documento_07='$tipodoc' and f.numeracion_08='$numero' and e.idempresa='$idempresa' union all 

        select 
        f.idfactura, 
        f.idcliente, 
        p.razon_social,
        p.nombres,  
        p.domicilio_fiscal, 
        p.tipo_documento, 
        p.numero_documento, 
        p.email, 
        p.telefono1, 
        f.idusuario,
        u.nombre as nombreusuario,  
        p.nombre_comercial, 
        f.tipo_documento_07,
        concat(u.nombre,' ',u.apellidos) as usuario, 
        f.numeracion_08, 
        right(substring_index(f.numeracion_08,'-',1),4) as serie, 
        right(substring_index(f.numeracion_08,'-',-1),10) as numerofac, 
        date_format(f.fecha_emision_01,'%d-%m-%Y') as fecha, 
        date_format(f.fecha_emision_01,'%Y-%m-%d') as fecha2, 
        f.sumatoria_igv_22_1, 
        f.importe_total_venta_27 as totalLetras, 
        f.importe_total_venta_27 as itotal, 
        f.tasa_igv, 
        f.guia_remision_29_2, 
        f.estado,
        e.numero_ruc, 
        f.tdescuento,
        f.total_operaciones_gravadas_monto_18_2 as subtotal,
        f.vendedorsitio
    from 
    facturaservicio f inner join persona p on f.idcliente=p.idpersona inner join empresa e 
          on e.idempresa=f.idempresa
          inner join
          usuario u on f.idusuario=u.idusuario where  f.tipo_documento_07='$tipodoc' and f.numeracion_08='$numero' and e.idempresa='$idempresa' union all 

  select 
    b.idboleta, 
        b.idcliente, 
        p.razon_social, 
        p.nombres, 
        p.domicilio_fiscal, 
        p.tipo_documento,
        p.numero_documento, 
        p.email, 
        p.telefono1, 
        b.idusuario, 
        u.nombre as nombreusuario, 
        p.nombre_comercial, 
        b.tipo_documento_06,
        concat(u.nombre,' ',u.apellidos) as usuario,  
        b.numeracion_07,
        right(substring_index(b.numeracion_07,'-',1),4) as serie, 
        right(substring_index(b.numeracion_07,'-',-1),10) as numerofac,  
        date_format(b.fecha_emision_01,'%d-%m-%Y') as fecha, 
        date_format(b.fecha_emision_01,'%Y-%m-%d') as fecha2, 
        b.sumatoria_igv_18_1, 
        b.importe_total_23 as totalLetras, 
        b.importe_total_23 as itotal,
    b.tasa_igv,
        b.guia_remision_25,  
        b.estado,
        e.numero_ruc,
        b.tdescuento,
        b.monto_15_2 as subtotal,
        b.vendedorsitio 
from 
boleta b inner join persona p on b.idcliente=p.idpersona inner join usuario u on 
        b.idusuario=u.idusuario inner join empresa e on b.idempresa=e.idempresa  where b.tipo_documento_06='$tipodoc' and b.numeracion_07='$numero' and e.idempresa='$idempresa' union all
        select 
    b.idboleta, 
        b.idcliente, 
        p.razon_social, 
        p.nombres, 
        p.domicilio_fiscal, 
        p.tipo_documento,
        p.numero_documento, 
        p.email, 
        p.telefono1, 
        b.idusuario, 
        u.nombre as nombreusuario, 
        p.nombre_comercial, 
        b.tipo_documento_06,
        concat(u.nombre,' ',u.apellidos) as usuario,  
        b.numeracion_07,
        right(substring_index(b.numeracion_07,'-',1),4) as serie, 
        right(substring_index(b.numeracion_07,'-',-1),10) as numerofac,  
        date_format(b.fecha_emision_01,'%d-%m-%Y') as fecha, 
        date_format(b.fecha_emision_01,'%Y-%m-%d') as fecha2, 
        b.sumatoria_igv_18_1, 
        b.importe_total_23 as totalLetras, 
        b.importe_total_23 as itotal,
    b.tasa_igv,
        b.guia_remision_25,  
        b.estado,
        e.numero_ruc,
        b.tdescuento,
        b.monto_15_2 as subtotal,
        b.vendedorsitio 
from 
boletaservicio b inner join persona p on b.idcliente=p.idpersona inner join usuario u on 
        b.idusuario=u.idusuario inner join empresa e on b.idempresa=e.idempresa  where b.tipo_documento_06='$tipodoc' and b.numeracion_07='$numero' and e.idempresa='$idempresa'
    ) as tbventa";
        return ejecutarConsulta($sql);
    }

    public function ventacabeceraConsultaNCD($tipodoc, $nruc , $numero, $idempresa)
    
    {
        $sql=
        "select 
        idnota,
        idpersona, 
        razon_social, 
        nombres,
        domicilio_fiscal, 
        tipo_documento, 
        numero_documento, 
        email, 
        telefono1, 
        tipo_documento_comp,
        nombre_comercial,
        ncomprobante, 
        numeroserienota,
        codigo_nota,
        observacion,
        femisionfac, 
        serie, 
        numerofac, 
        fecha, 
        fecha2,
        sum_igv,
        totalLetras,
        itotal,   
        estado,
        numero_ruc, 
        subtotal,
        vendedorsitio
        from
        (
        select 
        ncd.idnota,
        p.idpersona, 
        p.razon_social, 
        p.nombres,
        p.domicilio_fiscal, 
        p.tipo_documento, 
        p.numero_documento, 
        p.email, 
        p.telefono1, 
        f.tipo_documento_07 as tipo_documento_comp,
        p.nombre_comercial,
        f.numeracion_08 as ncomprobante, 
        ncd.numeroserienota,
        ncd.codigo_nota,
        ncd.desc_motivo as observacion,
        date_format(f.fecha_emision_01, '%d-%m-%Y') as femisionfac, 
        right(substring_index(ncd.numeroserienota,'-',1),4) as serie, 
        right(substring_index(ncd.numeroserienota,'-',-1),10) as numerofac, 
        date_format(ncd.fecha,'%d-%m-%Y') as fecha, 
        date_format(ncd.fecha,'%Y-%m-%d') as fecha2,
        ncd.sum_igv,
        ncd.importe_total as totalLetras,
        ncd.importe_total as itotal,   
        ncd.estado,
        e.numero_ruc, 
        ncd.total_val_venta_og as subtotal,
        ncd.vendedorsitio
        from
        notacd ncd 
         inner join detalle_notacd_art dncd on ncd.idnota=dncd.idnotacd
         inner join factura f on ncd.idcomprobante=f.idfactura 
         inner join detalle_fac_art df on f.idfactura=df.idfactura 
         inner join articulo a on df.idarticulo=a.idarticulo 
         inner join persona p on f.idcliente=p.idpersona 
         inner join empresa e on f.idempresa=e.idempresa
        where ncd.codigo_nota='$tipodoc' and p.numero_documento='$nruc'  and  ncd.numeroserienota='$numero' and e.idempresa='$idempresa' and ncd.difComprobante='01'
        union all
        select 
        ncd.idnota,
        p.idpersona, 
        p.razon_social, 
        p.nombres,
        p.domicilio_fiscal, 
        p.tipo_documento, 
        p.numero_documento, 
        p.email, 
        p.telefono1, 
        f.tipo_documento_07 as tipo_documento_comp,
        p.nombre_comercial,
        f.numeracion_08 as ncomprobante, 
        ncd.numeroserienota,
        ncd.codigo_nota,
        ncd.desc_motivo as observacion,
        date_format(f.fecha_emision_01, '%d-%m-%Y') as femisionfac, 
        right(substring_index(ncd.numeroserienota,'-',1),4) as serie, 
        right(substring_index(ncd.numeroserienota,'-',-1),10) as numerofac, 
        date_format(ncd.fecha,'%d-%m-%Y') as fecha, 
        date_format(ncd.fecha,'%Y-%m-%d') as fecha2,
        ncd.sum_igv,
        ncd.importe_total as totalLetras,
        ncd.importe_total as itotal,   
        ncd.estado,
        e.numero_ruc, 
        ncd.total_val_venta_og as subtotal,
        ncd.vendedorsitio
        from
        notacd ncd 
         inner join detalle_notacd_art dncd on ncd.idnota=dncd.idnotacd
         inner join facturaservicio f on ncd.idcomprobante=f.idfactura 
         inner join detalle_fac_art_ser df on f.idfactura=df.idfactura 
         inner join servicios_inmuebles a on df.idarticulo=a.id
         inner join persona p on f.idcliente=p.idpersona 
         inner join empresa e on f.idempresa=e.idempresa
        where ncd.codigo_nota='$tipodoc' and p.numero_documento='$nruc'  and  ncd.numeroserienota='$numero' and e.idempresa='$idempresa' and ncd.difComprobante='04'
        union all
        select 
        ncd.idnota,
        p.idpersona, 
        p.razon_social, 
        p.nombres,
        p.domicilio_fiscal, 
        p.tipo_documento, 
        p.numero_documento, 
        p.email, 
        p.telefono1, 
        b.tipo_documento_06 as tipo_documento_comp,
        p.nombre_comercial,
        b.numeracion_07 as ncomprobante, 
        ncd.numeroserienota,
        ncd.codigo_nota,
        ncd.desc_motivo as observacion,
        date_format(b.fecha_emision_01, '%d-%m-%Y') as femisionfac, 
        right(substring_index(ncd.numeroserienota,'-',1),4) as serie, 
        right(substring_index(ncd.numeroserienota,'-',-1),10) as numerofac, 
        date_format(ncd.fecha,'%d-%m-%Y') as fecha, 
        date_format(ncd.fecha,'%Y-%m-%d') as fecha2,
        ncd.sum_igv,
        ncd.importe_total as totalLetras,
        ncd.importe_total as itotal,   
        ncd.estado,
        e.numero_ruc, 
        ncd.total_val_venta_og as subtotal,
        ncd.vendedorsitio
        from
        notacd ncd 
         inner join detalle_notacd_art dncd on ncd.idnota=dncd.idnotacd
         inner join boleta b on ncd.idcomprobante=b.idboleta 
         inner join detalle_boleta_producto db on b.idboleta=db.idboleta 
         inner join articulo a on db.idarticulo=a.idarticulo
         inner join persona p on b.idcliente=p.idpersona 
         inner join empresa e on b.idempresa=e.idempresa
        where ncd.codigo_nota='$tipodoc' and p.numero_documento='$nruc'  and  ncd.numeroserienota='$numero' and e.idempresa='$idempresa' and ncd.difComprobante='03'
                union all
        select 
        ncd.idnota,
        p.idpersona, 
        p.razon_social, 
        p.nombres,
        p.domicilio_fiscal, 
        p.tipo_documento, 
        p.numero_documento, 
        p.email, 
        p.telefono1, 
        b.tipo_documento_06 as tipo_documento_comp,
        p.nombre_comercial,
        b.numeracion_07 as ncomprobante, 
        ncd.numeroserienota,
        ncd.codigo_nota,
        ncd.desc_motivo as observacion,
        date_format(b.fecha_emision_01, '%d-%m-%Y') as femisionfac, 
        right(substring_index(ncd.numeroserienota,'-',1),4) as serie, 
        right(substring_index(ncd.numeroserienota,'-',-1),10) as numerofac, 
        date_format(ncd.fecha,'%d-%m-%Y') as fecha, 
        date_format(ncd.fecha,'%Y-%m-%d') as fecha2,
        ncd.sum_igv,
        ncd.importe_total as totalLetras,
        ncd.importe_total as itotal,   
        ncd.estado,
        e.numero_ruc, 
        ncd.total_val_venta_og as subtotal,
        ncd.vendedorsitio
        from
        notacd ncd 
         inner join detalle_notacd_art dncd on ncd.idnota=dncd.idnotacd
         inner join boletaservicio b on ncd.idcomprobante=b.idboleta 
         inner join detalle_boleta_producto_ser db on b.idboleta=db.idboleta 
         inner join servicios_inmuebles a on db.idarticulo=a.id
         inner join persona p on b.idcliente=p.idpersona 
         inner join empresa e on b.idempresa=e.idempresa
        where ncd.codigo_nota='$tipodoc' and p.numero_documento='$nruc'  and  ncd.numeroserienota='$numero' and e.idempresa='$idempresa' and ncd.difComprobante='05'

        ) as tabla ";
        return ejecutarConsulta($sql);
    }



    public function BuscacabeceraConsultaNCD($tipodoc, $numero, $idempresa)
    
    {
        $sql=
        "select 
        idnota,
        idpersona, 
        razon_social, 
        nombres,
        domicilio_fiscal, 
        tipo_documento, 
        numero_documento, 
        email, 
        telefono1, 
        tipo_documento_comp,
        nombre_comercial,
        ncomprobante, 
        numeroserienota,
        codigo_nota,
        observacion,
        femisionfac, 
        serie, 
        numerofac, 
        fecha, 
        fecha2,
        sum_igv,
        totalLetras,
        itotal,   
        estado,
        numero_ruc, 
        subtotal,
        vendedorsitio
        from
        (
        select 
        ncd.idnota,
        p.idpersona, 
        p.razon_social, 
        p.nombres,
        p.domicilio_fiscal, 
        p.tipo_documento, 
        p.numero_documento, 
        p.email, 
        p.telefono1, 
        f.tipo_documento_07 as tipo_documento_comp,
        p.nombre_comercial,
        f.numeracion_08 as ncomprobante, 
        ncd.numeroserienota,
        ncd.codigo_nota,
        ncd.desc_motivo as observacion,
        date_format(f.fecha_emision_01, '%d-%m-%Y') as femisionfac, 
        right(substring_index(ncd.numeroserienota,'-',1),4) as serie, 
        right(substring_index(ncd.numeroserienota,'-',-1),10) as numerofac, 
        date_format(ncd.fecha,'%d-%m-%Y') as fecha, 
        date_format(ncd.fecha,'%Y-%m-%d') as fecha2,
        ncd.sum_igv,
        ncd.importe_total as totalLetras,
        ncd.importe_total as itotal,   
        ncd.estado,
        e.numero_ruc, 
        ncd.total_val_venta_og as subtotal,
        ncd.vendedorsitio
        from
        notacd ncd 
         inner join detalle_notacd_art dncd on ncd.idnota=dncd.idnotacd
         inner join factura f on ncd.idcomprobante=f.idfactura 
         inner join detalle_fac_art df on f.idfactura=df.idfactura 
         inner join articulo a on df.idarticulo=a.idarticulo 
         inner join persona p on f.idcliente=p.idpersona 
         inner join empresa e on f.idempresa=e.idempresa
        where ncd.codigo_nota='$tipodoc' and ncd.numeroserienota='$numero' and e.idempresa='$idempresa' and ncd.difComprobante='01'
        union all
        select 
        ncd.idnota,
        p.idpersona, 
        p.razon_social, 
        p.nombres,
        p.domicilio_fiscal, 
        p.tipo_documento, 
        p.numero_documento, 
        p.email, 
        p.telefono1, 
        f.tipo_documento_07 as tipo_documento_comp,
        p.nombre_comercial,
        f.numeracion_08 as ncomprobante, 
        ncd.numeroserienota,
        ncd.codigo_nota,
        ncd.desc_motivo as observacion,
        date_format(f.fecha_emision_01, '%d-%m-%Y') as femisionfac, 
        right(substring_index(ncd.numeroserienota,'-',1),4) as serie, 
        right(substring_index(ncd.numeroserienota,'-',-1),10) as numerofac, 
        date_format(ncd.fecha,'%d-%m-%Y') as fecha, 
        date_format(ncd.fecha,'%Y-%m-%d') as fecha2,
        ncd.sum_igv,
        ncd.importe_total as totalLetras,
        ncd.importe_total as itotal,   
        ncd.estado,
        e.numero_ruc, 
        ncd.total_val_venta_og as subtotal,
        ncd.vendedorsitio
        from
        notacd ncd 
         inner join detalle_notacd_art dncd on ncd.idnota=dncd.idnotacd
         inner join facturaservicio f on ncd.idcomprobante=f.idfactura 
         inner join detalle_fac_art_ser df on f.idfactura=df.idfactura 
         inner join servicios_inmuebles a on df.idarticulo=a.id
         inner join persona p on f.idcliente=p.idpersona 
         inner join empresa e on f.idempresa=e.idempresa
        where ncd.codigo_nota='$tipodoc' and  ncd.numeroserienota='$numero' and e.idempresa='$idempresa' and ncd.difComprobante='04'
        union all
        select 
        ncd.idnota,
        p.idpersona, 
        p.razon_social, 
        p.nombres,
        p.domicilio_fiscal, 
        p.tipo_documento, 
        p.numero_documento, 
        p.email, 
        p.telefono1, 
        b.tipo_documento_06 as tipo_documento_comp,
        p.nombre_comercial,
        b.numeracion_07 as ncomprobante, 
        ncd.numeroserienota,
        ncd.codigo_nota,
        ncd.desc_motivo as observacion,
        date_format(b.fecha_emision_01, '%d-%m-%Y') as femisionfac, 
        right(substring_index(ncd.numeroserienota,'-',1),4) as serie, 
        right(substring_index(ncd.numeroserienota,'-',-1),10) as numerofac, 
        date_format(ncd.fecha,'%d-%m-%Y') as fecha, 
        date_format(ncd.fecha,'%Y-%m-%d') as fecha2,
        ncd.sum_igv,
        ncd.importe_total as totalLetras,
        ncd.importe_total as itotal,   
        ncd.estado,
        e.numero_ruc, 
        ncd.total_val_venta_og as subtotal,
        ncd.vendedorsitio
        from
        notacd ncd 
         inner join detalle_notacd_art dncd on ncd.idnota=dncd.idnotacd
         inner join boleta b on ncd.idcomprobante=b.idboleta 
         inner join detalle_boleta_producto db on b.idboleta=db.idboleta 
         inner join articulo a on db.idarticulo=a.idarticulo
         inner join persona p on b.idcliente=p.idpersona 
         inner join empresa e on b.idempresa=e.idempresa
        where ncd.codigo_nota='$tipodoc' and  ncd.numeroserienota='$numero' and e.idempresa='$idempresa' and ncd.difComprobante='03'
                union all
        select 
        ncd.idnota,
        p.idpersona, 
        p.razon_social, 
        p.nombres,
        p.domicilio_fiscal, 
        p.tipo_documento, 
        p.numero_documento, 
        p.email, 
        p.telefono1, 
        b.tipo_documento_06 as tipo_documento_comp,
        p.nombre_comercial,
        b.numeracion_07 as ncomprobante, 
        ncd.numeroserienota,
        ncd.codigo_nota,
        ncd.desc_motivo as observacion,
        date_format(b.fecha_emision_01, '%d-%m-%Y') as femisionfac, 
        right(substring_index(ncd.numeroserienota,'-',1),4) as serie, 
        right(substring_index(ncd.numeroserienota,'-',-1),10) as numerofac, 
        date_format(ncd.fecha,'%d-%m-%Y') as fecha, 
        date_format(ncd.fecha,'%Y-%m-%d') as fecha2,
        ncd.sum_igv,
        ncd.importe_total as totalLetras,
        ncd.importe_total as itotal,   
        ncd.estado,
        e.numero_ruc, 
        ncd.total_val_venta_og as subtotal,
        ncd.vendedorsitio
        from
        notacd ncd 
         inner join detalle_notacd_art dncd on ncd.idnota=dncd.idnotacd
         inner join boletaservicio b on ncd.idcomprobante=b.idboleta 
         inner join detalle_boleta_producto_ser db on b.idboleta=db.idboleta 
         inner join servicios_inmuebles a on db.idarticulo=a.id
         inner join persona p on b.idcliente=p.idpersona 
         inner join empresa e on b.idempresa=e.idempresa
        where ncd.codigo_nota='$tipodoc' and  ncd.numeroserienota='$numero' and e.idempresa='$idempresa' and ncd.difComprobante='05'

        ) as tabla ";
        return ejecutarConsulta($sql);
    }

    public function detalleNota($tipodoc, $nruc, $serienum){
        $sql="select  
        articulo, 
        codigo, 
        cantidad, 
        valor_unitario, 
        importe, 
        precio_venta, 
        valor_venta,
        subtotal,
        igv,
        total,
        observacion,
        numero_doc_ide
        from
        (
        select 
        a.nombre as articulo, 
        a.codigo, 
        format(dfnc.cantidad,2) as cantidad, 
        dfnc.valor_unitario, 
        format((dfnc.cantidad * dfnc.valor_unitario),2) as importe, 
        dfnc.precio_venta, 
        dfnc.valor_venta,
        ncd.total_val_venta_og as subtotal,
        ncd.sum_igv as igv,
        ncd.importe_total as total,
        ncd.desc_motivo as observacion,
        ncd.numero_doc_ide
        from
        detalle_notacd_art dfnc inner join articulo a on dfnc.idarticulo=a.idarticulo inner join notacd ncd on dfnc.idnotacd=ncd.idnota  inner join factura f on ncd.idcomprobante=f.idfactura 
        where ncd.codigo_nota='$tipodoc' and ncd.numero_doc_ide='$nruc'  and ncd.numeroserienota='$serienum' and ncd.difComprobante='01'
        union all 
        select 
        a.descripcion as articulo, 
        a.codigo, 
        format(dfnc.cantidad,2) as cantidad, 
        dfnc.valor_unitario, 
        format((dfnc.cantidad * dfnc.valor_unitario),2) as importe, 
        dfnc.precio_venta, 
        dfnc.valor_venta,
        ncd.total_val_venta_og as subtotal,
        ncd.sum_igv as igv,
        ncd.importe_total as total,
        ncd.desc_motivo as observacion,
        ncd.numero_doc_ide
        from
        detalle_notacd_art dfnc inner join servicios_inmuebles a on dfnc.idarticulo=a.id inner join notacd ncd on dfnc.idnotacd=ncd.idnota  inner join facturaservicio f on ncd.idcomprobante=f.idfactura 
        where ncd.codigo_nota='$tipodoc' and ncd.numero_doc_ide='$nruc'  and ncd.numeroserienota='$serienum' and ncd.difComprobante='04'
        union all 
        select 
        a.nombre as articulo, 
        a.codigo, 
        format(dfnc.cantidad,2) as cantidad, 
        dfnc.valor_unitario, 
        format((dfnc.cantidad * dfnc.valor_unitario),2) as importe, 
        dfnc.precio_venta, 
        dfnc.valor_venta,
        ncd.total_val_venta_og as subtotal,
        ncd.sum_igv as igv,
        ncd.importe_total as total,
        ncd.desc_motivo as observacion,
        ncd.numero_doc_ide
        from
        detalle_notacd_art dfnc inner join articulo a on dfnc.idarticulo=a.idarticulo inner join notacd ncd on dfnc.idnotacd=ncd.idnota  inner join boleta b on ncd.idcomprobante=b.idboleta 
        where ncd.codigo_nota='$tipodoc' and ncd.numero_doc_ide='$nruc'  and ncd.numeroserienota='$serienum' and ncd.difComprobante='03'
        union all 
        select 
        a.descripcion as articulo, 
        a.codigo, 
        format(dfnc.cantidad,2) as cantidad, 
        dfnc.valor_unitario, 
        format((dfnc.cantidad * dfnc.valor_unitario),2) as importe, 
        dfnc.precio_venta, 
        dfnc.valor_venta,
        ncd.total_val_venta_og as subtotal,
        ncd.sum_igv as igv,
        ncd.importe_total as total,
        ncd.desc_motivo as observacion,
        ncd.numero_doc_ide
        from
        detalle_notacd_art dfnc inner join servicios_inmuebles a on dfnc.idarticulo=a.id inner join notacd ncd on dfnc.idnotacd=ncd.idnota  inner join boletaservicio b on ncd.idcomprobante=b.idboleta 
        where ncd.codigo_nota='$tipodoc' and ncd.numero_doc_ide='$nruc'  and ncd.numeroserienota='$serienum' and ncd.difComprobante='05'
        ) 
        as tabla";
        return ejecutarConsulta($sql);
    }



    public function detalleNotaBusca($tipodoc, $serienum){
        $sql="select  
        articulo, 
        codigo, 
        cantidad, 
        valor_unitario, 
        importe, 
        precio_venta, 
        valor_venta,
        subtotal,
        igv,
        total,
        observacion,
        numero_doc_ide
        from
        (
        select 
        a.nombre as articulo, 
        a.codigo, 
        format(dfnc.cantidad,2) as cantidad, 
        dfnc.valor_unitario, 
        format((dfnc.cantidad * dfnc.valor_unitario),2) as importe, 
        dfnc.precio_venta, 
        dfnc.valor_venta,
        ncd.total_val_venta_og as subtotal,
        ncd.sum_igv as igv,
        ncd.importe_total as total,
        ncd.desc_motivo as observacion,
        ncd.numero_doc_ide
        from
        detalle_notacd_art dfnc inner join articulo a on dfnc.idarticulo=a.idarticulo inner join notacd ncd on dfnc.idnotacd=ncd.idnota  inner join factura f on ncd.idcomprobante=f.idfactura 
        where ncd.codigo_nota='$tipodoc' and ncd.numeroserienota='$serienum' and ncd.difComprobante='01'
        union all 
        select 
        a.descripcion as articulo, 
        a.codigo, 
        format(dfnc.cantidad,2) as cantidad, 
        dfnc.valor_unitario, 
        format((dfnc.cantidad * dfnc.valor_unitario),2) as importe, 
        dfnc.precio_venta, 
        dfnc.valor_venta,
        ncd.total_val_venta_og as subtotal,
        ncd.sum_igv as igv,
        ncd.importe_total as total,
        ncd.desc_motivo as observacion,
        ncd.numero_doc_ide
        from
        detalle_notacd_art dfnc inner join servicios_inmuebles a on dfnc.idarticulo=a.id inner join notacd ncd on dfnc.idnotacd=ncd.idnota  inner join facturaservicio f on ncd.idcomprobante=f.idfactura 
        where ncd.codigo_nota='$tipodoc' and ncd.numeroserienota='$serienum' and ncd.difComprobante='04'
        union all 
        select 
        a.nombre as articulo, 
        a.codigo, 
        format(dfnc.cantidad,2) as cantidad, 
        dfnc.valor_unitario, 
        format((dfnc.cantidad * dfnc.valor_unitario),2) as importe, 
        dfnc.precio_venta, 
        dfnc.valor_venta,
        ncd.total_val_venta_og as subtotal,
        ncd.sum_igv as igv,
        ncd.importe_total as total,
        ncd.desc_motivo as observacion,
        ncd.numero_doc_ide
        from
        detalle_notacd_art dfnc inner join articulo a on dfnc.idarticulo=a.idarticulo inner join notacd ncd on dfnc.idnotacd=ncd.idnota  inner join boleta b on ncd.idcomprobante=b.idboleta 
        where ncd.codigo_nota='$tipodoc' and ncd.numeroserienota='$serienum' and ncd.difComprobante='03'
        union all 
        select 
        a.descripcion as articulo, 
        a.codigo, 
        format(dfnc.cantidad,2) as cantidad, 
        dfnc.valor_unitario, 
        format((dfnc.cantidad * dfnc.valor_unitario),2) as importe, 
        dfnc.precio_venta, 
        dfnc.valor_venta,
        ncd.total_val_venta_og as subtotal,
        ncd.sum_igv as igv,
        ncd.importe_total as total,
        ncd.desc_motivo as observacion,
        ncd.numero_doc_ide
        from
        detalle_notacd_art dfnc inner join servicios_inmuebles a on dfnc.idarticulo=a.id inner join notacd ncd on dfnc.idnotacd=ncd.idnota  inner join boletaservicio b on ncd.idcomprobante=b.idboleta 
        where ncd.codigo_nota='$tipodoc' and ncd.numeroserienota='$serienum' and ncd.difComprobante='05'
        ) 
        as tabla";
        return ejecutarConsulta($sql);
    }

    public function ventadetalleConsulta($tipodoc, $numero)
    {
        $sql=
        "select 
        nombre as articulo, 
        codigo, 
        cantidad_item_12, 
        valor_uni_item_14, 
        subtotal, 
        precio_venta_item_15_2, 
        valor_venta_item_21,
        dcto_item,
        descdet
  from 
  (select  
        a.nombre, 
        a.codigo, 
        format(dfa.cantidad_item_12,2) as cantidad_item_12, 
        dfa.valor_uni_item_14, 
        format((dfa.cantidad_item_12 * dfa.valor_uni_item_14),2) as subtotal, 
        dfa.precio_venta_item_15_2, 
        dfa.valor_venta_item_21,
        dfa.dcto_item,
        dfa.descdet
        from 
        detalle_fac_art dfa inner join articulo a on dfa.idarticulo=a.idarticulo inner join factura f on dfa.idfactura=f.idfactura where f.tipo_documento_07='$tipodoc' and  f.numeracion_08='$numero'   union all 

        select  
        a.descripcion as nombre, 
        a.codigo, 
        format(dfa.cantidad_item_12,2) as cantidad_item_12, 
        dfa.valor_uni_item_14, 
        format((dfa.cantidad_item_12 * dfa.valor_uni_item_14),2) as subtotal, 
        dfa.precio_venta_item_15_2, 
        dfa.valor_venta_item_21,
        dfa.dcto_item,
        dfa.descdet
        from 
        detalle_fac_art_ser dfa inner join servicios_inmuebles a on dfa.idarticulo=a.id inner join facturaservicio f on dfa.idfactura=f.idfactura where f.tipo_documento_07='$tipodoc' and  f.numeracion_08='$numero'   union all 
        select  
        a.nombre, 
        a.codigo, 
        format(db.cantidad_item_12,2) as cantidad_item_12, 
        db.valor_uni_item_31, 
        format((db.cantidad_item_12 * db.precio_uni_item_14_2),2) as subtotal,
        db.precio_uni_item_14_2, 
        db.valor_venta_item_32, 
        db.dcto_item, 
        db.descdet
        from
        detalle_boleta_producto db inner join articulo a on db.idarticulo=a.idarticulo inner join boleta b on db.idboleta=b.idboleta  where b.tipo_documento_06='$tipodoc' and  b.numeracion_07='$numero'  union all 
        select  
        a.descripcion as nombre, 
        a.codigo, 
        format(db.cantidad_item_12,2) as cantidad_item_12, 
        db.valor_uni_item_31, 
        format((db.cantidad_item_12 * db.precio_uni_item_14_2),2) as subtotal,
        db.precio_uni_item_14_2, 
        db.valor_venta_item_32, 
        db.dcto_item, 
        db.descdet
        from
        detalle_boleta_producto_ser db inner join servicios_inmuebles a on db.idarticulo=a.id inner join boletaservicio b on db.idboleta=b.idboleta  where b.tipo_documento_06='$tipodoc' and  b.numeracion_07='$numero'
         ) as tbventa";
        return ejecutarConsulta($sql);
    }


    public function insertarnotificacion($codigonotificacion, $nombrenotificacion, $fechacreacion, $fechaaviso, $continuo, $tipocomprobante, $idcliente, $estadonoti)
    {
       $sql="insert into notificaciones (codigonotificacion, nombrenotificacion, fechacreacion, fechaaviso, continuo, tipocomprobante, idpersona, estado)
        values ('$codigonotificacion', '$nombrenotificacion', '$fechacreacion', '$fechaaviso', 
        '$continuo', '$tipocomprobante', '$idcliente','$estadonoti')";
        return ejecutarConsulta($sql);
    }


    



    public function ventasVendedorBoleta($vendedor, $ano, $mes, $idempresa)
    {
       $sql="select format(sum(importe_total_23),2) as totalBoleta from(
       select  importe_total_23 from  boleta b inner join empresa e on b.idempresa=e.idempresa  where b.vendedorsitio='$vendedor' and year(b.fecha_emision_01)='$ano' and month(b.fecha_emision_01)='$mes' and b.estado in('5') and e.idempresa='$idempresa'
       union all
        select  importe_total_23 from  boletaservicio b inner join empresa e on b.idempresa=e.idempresa  where b.vendedorsitio='$vendedor' and year(b.fecha_emision_01)='$ano' and month(b.fecha_emision_01)='$mes' and b.estado in('5') and e.idempresa='$idempresa') as tabla
       ";
        return ejecutarConsulta($sql);  
    }

    public function ventasVendedorBoletaAno($vendedor, $ano, $idempresa)
    {
       $sql="select format(sum(importe_total_23),2) as totalBoleta from (
       select  b.importe_total_23 from boleta b inner join empresa e on b.idempresa=e.idempresa  where b.vendedorsitio='$vendedor' and year(b.fecha_emision_01)='$ano' and b.estado in('5') and e.idempresa='$idempresa'
       union all 
       select  b.importe_total_23  from boletaservicio b inner join empresa e on b.idempresa=e.idempresa  where b.vendedorsitio='$vendedor' and year(b.fecha_emision_01)='$ano' and b.estado in('5') and e.idempresa='$idempresa') as tabla";
        return ejecutarConsulta($sql);  
    }

     public function ventasVendedorFacturaAno($vendedor, $ano, $idempresa)
    {
       $sql="select format(sum(importe_total_venta_27),2) as totalFactura from 
       (select f.importe_total_venta_27  from factura f inner join empresa e on f.idempresa=e.idempresa where f.vendedorsitio='$vendedor' and year(f.fecha_emision_01)='$ano'  and f.estado in('5') and e.idempresa='$idempresa' 
       union all
       select f.importe_total_venta_27  from facturaservicio f inner join empresa e on f.idempresa=e.idempresa where f.vendedorsitio='$vendedor' and year(f.fecha_emision_01)='$ano'  and f.estado in('5') and e.idempresa='$idempresa' ) as tabla
         ";
        return ejecutarConsulta($sql);  
    }


    public function totalVentasVendedorAno($idempresa)
    {
       $sql="select vendedorsitio, sum(total) as totalv from 
            (select f.vendedorsitio, f.importe_total_venta_27 as total from factura f inner join empresa e on f.idempresa=e.idempresa inner join vendedorsitio vs on e.idempresa=vs.idempresa  where year(f.fecha_emision_01)=year(now())  and f.estado in ('5') and e.idempresa='$idempresa'
             union all 
             select b.vendedorsitio, b.importe_total_23 as total from boleta b inner join empresa e on b.idempresa=e.idempresa inner join vendedorsitio vs on e.idempresa=vs.idempresa  where year(b.fecha_emision_01)=year(now())  and b.estado in ('5') and e.idempresa='$idempresa') as tabla group by vendedorsitio order by totalv desc";
        return ejecutarConsulta($sql);  
    }

    public function listarEnvioCorreo()
    {
        $sql="select * from enviocorreo order by id desc";
        return ejecutarConsulta($sql);      
    }


          public function listarValidarComprobantes($estado)
    {
        $sql="select 
        idcomprobante,
        fecha,
        fechabaja,
        idcliente,
        cliente,
        vendedorsitio,
        usuario,
        tipo_documento_07,
        numeracion_08,
        importe_total_venta_27 ,
        sumatoria_igv_22_1,
        estado,
        numero_ruc,
        email,
        diast,
          DetalleSunat  
        from
        (select 
        f.idfactura as idcomprobante,
        date_format(f.fecha_emision_01,'%d/%m/%y') as fecha,
        date_format(curdate(),'%Y%m%d') as fechabaja,
        f.idcliente,
        left(p.razon_social,20) as cliente,
        f.vendedorsitio,
        u.nombre as usuario,
        f.tipo_documento_07,
        f.numeracion_08,
        format(f.importe_total_venta_27,2)as importe_total_venta_27 ,
        f.sumatoria_igv_22_1,
        f.estado,
        e.numero_ruc,
        p.email,
        TIMESTAMPDIFF(DAY,f.fecha_emision_01 ,  curdate()) AS diast,
          f.DetalleSunat 
        from  factura f inner join persona p on f.idcliente=p.idpersona 
        inner join usuario u on f.idusuario=u.idusuario 
        inner join empresa e on f.idempresa=e.idempresa where
        year(fecha_emision_01)=year(current_date()) and month(fecha_emision_01)=month(current_date()) and f.estado='$estado'
                 
        union all

        select 
        b.idboleta as idcomprobante,
        date_format(b.fecha_emision_01,'%d/%m/%y') as fecha,
        date_format(curdate(),'%Y%m%d') as fechabaja,
        b.idcliente,
        left(p.nombres,20) as cliente,
        b.vendedorsitio,
        u.nombre as usuario,
        b.tipo_documento_06,
        b.numeracion_07,
        format(b.importe_total_23,2)as importe_total_23 ,
        b.sumatoria_igv_18_1,
        b.estado,
        e.numero_ruc,
        p.email,
        TIMESTAMPDIFF(DAY,b.fecha_emision_01 ,  curdate()) AS diast,
         b.DetalleSunat 
        from  boleta b inner join persona p on b.idcliente=p.idpersona 
        inner join usuario u on b.idusuario=u.idusuario 
        inner join empresa e on b.idempresa=e.idempresa where
        year(b.fecha_emision_01)=year(current_date()) and month(b.fecha_emision_01)=month(current_date()) and b.estado='$estado'
        )
        as estados  order by fecha desc";
        return ejecutarConsulta($sql);  

    }





    public function generarxml($idcomprobante, $tipodoc, $idempresa)
    {
      $connect = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
      mysqli_query( $connect, 'SET NAMES "'.DB_ENCODE.'"');
      //Si tenemos un posible error en la conexión lo mostramos
      if (mysqli_connect_errno())
      {
            printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
            exit();
      }


if ($tipodoc=='1') 
{


require_once "../modelos/Factura.php";
    $factura = new Factura();
    $datos = $factura->datosemp($idempresa);
    $datose = $datos->fetch_object();
    $configuraciones = $factura->configuraciones($idempresa);
    $configE=$configuraciones->fetch_object();

    $nombrecomercial=$datose->nombre_comercial;

    //Inclusion de la tabla RUTAS
    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($idempresa);
    $Prutas = $Rrutas->fetch_object();
    $rutadata=$Prutas->rutadata; // ruta de la carpeta DATA
    $rutafirma=$Prutas->rutafirma; // ruta de la carpeta FIRMA
    $rutadatalt=$Prutas->rutadatalt; // ruta de la carpeta DATAALTERNA
    $rutaenvio=$Prutas->rutaenvio; // ruta de la carpeta DATAALTERNA

    $query = "select
     date_format(f.fecha_emision_01, '%Y-%m-%d') as fecha, 
     right(substring_index(f.numeracion_08,'-',1),1) as serie,
     date_format(f.fecha_emision_01, '%H:%i:%s') as hora,
     p.tipo_documento as  tipodocuCliente, 
     p.numero_documento, 
     p.razon_social, 
     f.tipo_moneda_28, 
     f.total_operaciones_gravadas_monto_18_2 as subtotal, 
     f.sumatoria_igv_22_1 as igv, 
     f.importe_total_venta_27 as total, 
     f.tipo_documento_07 as tipocomp, 
     f.numeracion_08 as numerodoc, 
     f.estado, 
     f.tdescuento,
     f.codigo_tributo_22_3 as codigotrib,
     f.nombre_tributo_22_4  as nombretrib,
     f.codigo_internacional_22_5 as codigointtrib,
     f.total_operaciones_gravadas_codigo_18_1 as opera,
     e.ubigueo,
      f.icbper
     from 
     factura f inner join persona p on f.idcliente=p.idpersona inner join empresa e on f.idempresa=e.idempresa where idfactura='$idcomprobante' and f.estado in('1','4') order by numerodoc";

    $querydetfac = "select
       f.tipo_documento_07 as tipocomp, 
       f.numeracion_08 as numerodoc,  
       df.cantidad_item_12 as cantidad, 
       a.codigo, 
       a.nombre as descripcion, 
       a.unidad_medida as um,
       replace(format(df.valor_uni_item_14,5),',','') as vui, 
       df.igv_item as igvi, 
       df.precio_venta_item_15_2 as pvi, 
       df.valor_venta_item_21 as vvi,
       df.afectacion_igv_item_16_1 as sutribitem,
       df.numero_orden_item_33 as numorden,

       df.afectacion_igv_item_16_3 as aigv,
       df.afectacion_igv_item_16_4 codtrib,
       df.afectacion_igv_item_16_5 as nomtrib,
       df.afectacion_igv_item_16_6 as coditrib,
       a.codigosunat,
       f.tipo_moneda_28 as moneda,
       a.mticbperu,
       f.icbper

       from
       factura f inner join detalle_fac_art df on f.idfactura=df.idfactura inner join articulo a on df.idarticulo=a.idarticulo
          where f.idfactura='$idcomprobante' and f.estado in ('1','4') order by f.fecha_emision_01";


      $result = mysqli_query($connect, $query);  
      $resultf = mysqli_query($connect, $querydetfac); 

    $nombrecomercial=$datose->nombre_comercial;
    $domiciliofiscal=$datose->domicilio_fiscal;
    $codestablecimiento=$datose->ubigueo;
    $codubigueo=$datose->codubigueo;
    $ciudad=$datose->ciudad;
    $distrito=$datose->distrito;
    $interior=$datose->interior;
    $codigopais=$datose->codigopais;


      //Parametros de salida
      $fecha=array();
      $hora=array();
      $serie=array();
      $tipodocu=array();
      $numdocu=array();
      $rasoc=array();
      $moneda=array();
      $codigotrib=array();
      $nombretrib=array();
      $codigointtrib=array();
      $subtotal=array();
      $igv=array();
      $total=array();
      $tdescu=array();
      $opera=array();
      $ubigueo=array();
     

      $con=0; //COntador de variable
      $icbper="";
            
      while($row=mysqli_fetch_assoc($result)){
      for($i=0; $i <= count($result); $i++){
           $fecha[$i]=$row["fecha"]; //Fecha emision
           $serie[$i]=$row["serie"];
           $tipodocu[$i]=$row["tipodocuCliente"]; //Tipo de documento de cliente ruc o dni
           $numdocu[$i]=$row["numero_documento"]; //NUmero de docuemnto de cliente
           $rasoc[$i]=$row["razon_social"]; //Nombre de cliente
           $moneda[$i]=$row["tipo_moneda_28"];
           $subtotal[$i]=$row["subtotal"];
           $igv[$i]=$row["igv"];
           $total[$i]=$row["total"];
           $tdescu[$i]=$row["tdescuento"];
           $hora[$i]=$row["hora"];
           $tipocomp=$row["tipocomp"];
           $numerodoc=$row["numerodoc"];
           $ruc=$datose->numero_ruc;
           $ubigueo=$datose->ubigueo;
           $opera[$i]=$row["opera"];


           $codigotrib[$i]=$row["codigotrib"];//codigo de tributo de la tabla catalo 5
           $nombretrib[$i]=$row["nombretrib"];//NOmbre de tributo de la tabla catalo 5
           $codigointtrib[$i]=$row["codigointtrib"];//Codigo internacional de la tabla catalo 5


      if ($moneda[$i]=='USD') {
             $Lmoneda="DOLARES AMERICANOS";
           }

            $icbper=$row["icbper"];

             $Lmoneda="NUEVOS SOLES";
       require_once "Letras.php";
       $V=new EnLetras(); 
       $con_letra=strtoupper($V->ValorEnLetras($total[$i], $Lmoneda));


//======================================== FORMATO XML ========================================================
 $domiciliofiscal=$datose->domicilio_fiscal;
//Primera parte
$facturaXML ='<?xml version="1.0" encoding="utf-8"?>
            <Invoice xmlns="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2"
                     xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2"
                     xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"
                     xmlns:ds="http://www.w3.org/2000/09/xmldsig#"
                     xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2">
                <ext:UBLExtensions>
                    <ext:UBLExtension>
                        <ext:ExtensionContent/>
                    </ext:UBLExtension>
                </ext:UBLExtensions>
                <cbc:UBLVersionID>2.1</cbc:UBLVersionID>
                <cbc:CustomizationID>2.0</cbc:CustomizationID>
                <cbc:ID>'.$numerodoc.'</cbc:ID>
                <cbc:IssueDate>'.$fecha[$i].'</cbc:IssueDate>
                <cbc:IssueTime>'.$hora[$i].'</cbc:IssueTime>

                <cbc:InvoiceTypeCode listID="0101">'.$tipocomp.'</cbc:InvoiceTypeCode>

                <cbc:Note languageLocaleID="1000">'.$con_letra.'</cbc:Note>

              <cbc:Note languageLocaleID="2006">Leyenda: Operación sujeta a detracción</cbc:Note>
              <cbc:DocumentCurrencyCode>'.$moneda[$i].'</cbc:DocumentCurrencyCode>

                <cac:Signature>
                    <cbc:ID>'.$ruc.'</cbc:ID>
                    <cbc:Note>SENCON</cbc:Note>
                    <cac:SignatoryParty>
                        <cac:PartyIdentification>
                            <cbc:ID>'.$ruc.'</cbc:ID>
                        </cac:PartyIdentification>
                        <cac:PartyName>
                            <cbc:Name><![CDATA['.$nombrecomercial.']]></cbc:Name>
                        </cac:PartyName>
                    </cac:SignatoryParty>
                    <cac:DigitalSignatureAttachment>
                        <cac:ExternalReference>
                            <cbc:URI>#SIGN-SENCON</cbc:URI>
                        </cac:ExternalReference>
                    </cac:DigitalSignatureAttachment>
                </cac:Signature>

                <cac:AccountingSupplierParty>
                    <cac:Party>
                        <cac:PartyIdentification>
                            <cbc:ID schemeID="6">'.$ruc.'</cbc:ID>
                        </cac:PartyIdentification>
                        <cac:PartyName>
                            <cbc:Name><![CDATA['.$nombrecomercial.']]></cbc:Name>
                        </cac:PartyName>
                        <cac:PartyLegalEntity>
                            <cbc:RegistrationName><![CDATA['.$nombrecomercial.']]></cbc:RegistrationName>
                            <cac:RegistrationAddress>
                                <cbc:AddressTypeCode>'.$codestablecimiento.'</cbc:AddressTypeCode>
                               <cbc:CitySubdivisionName>'.$interior.'</cbc:CitySubdivisionName>
                                <cbc:CityName>'.$ciudad.'</cbc:CityName>
                                  <cbc:CountrySubentity>'.$ciudad.'</cbc:CountrySubentity>
                                    <cbc:CountrySubentityCode>'.$codubigueo.'</cbc:CountrySubentityCode>
                                      <cbc:District>'.$distrito.'</cbc:District> 
                                      <cac:AddressLine>
                                        <cbc:Line><![CDATA['.$domiciliofiscal.']]></cbc:Line>
                                          </cac:AddressLine>    
                                            <cac:Country>
                                              <cbc:IdentificationCode>PE</cbc:IdentificationCode>
                                                </cac:Country>
                            </cac:RegistrationAddress>
                        </cac:PartyLegalEntity>
                    </cac:Party>
                </cac:AccountingSupplierParty>

                <cac:AccountingCustomerParty>
                    <cac:Party>
                        <cac:PartyIdentification>
                            <cbc:ID schemeID="'.$tipodocu[$i].'">'.$numdocu[$i].'</cbc:ID>
                        </cac:PartyIdentification>
                        <cac:PartyLegalEntity>
                            <cbc:RegistrationName><![CDATA['.$rasoc[$i].']]></cbc:RegistrationName>
                        </cac:PartyLegalEntity>
                    </cac:Party>
                </cac:AccountingCustomerParty>';

               /*  $facturaXML.='<cac:PaymentMeans>
                    <cbc:PaymentMeansCode>0</cbc:PaymentMeansCode>
                    <cac:PayeeFinancialAccount>
                        <cbc:ID>-</cbc:ID>
                    </cac:PayeeFinancialAccount>
                </cac:PaymentMeans>

                <cac:PaymentTerms>
                    <cbc:PaymentMeansID>000</cbc:PaymentMeansID>
                    <cbc:PaymentPercent>0.00</cbc:PaymentPercent>
                    <cbc:Amount currencyID="PEN">0.00</cbc:Amount>
                </cac:PaymentTerms>'; */


                $facturaXML.='<cac:TaxTotal>
                    <cbc:TaxAmount currencyID="'.$moneda[$i].'">'.$igv[$i].'</cbc:TaxAmount>
                        <cac:TaxSubtotal>
                        <cbc:TaxableAmount currencyID="'.$moneda[$i].'">'.$subtotal[$i].'</cbc:TaxableAmount>
                        <cbc:TaxAmount currencyID="'.$moneda[$i].'">'.$igv[$i].'</cbc:TaxAmount>
                        <cac:TaxCategory>
                            <cac:TaxScheme>
                                <cbc:ID>'.$codigotrib[$i].'</cbc:ID>
                                <cbc:Name>'.$nombretrib[$i].'</cbc:Name>
                                <cbc:TaxTypeCode>'.$codigointtrib[$i].'</cbc:TaxTypeCode>
                            </cac:TaxScheme>
                        </cac:TaxCategory>
                      </cac:TaxSubtotal>';


            if ($icbper>0) {
             $facturaXML.='
                <cac:TaxSubtotal>
                  <cbc:TaxAmount currencyID="'.$moneda[$i].'">'.$icbper.'</cbc:TaxAmount>
                         <cac:TaxCategory>
                            <cac:TaxScheme>
                               <cbc:ID>7152</cbc:ID>
                               <cbc:Name>ICBPER</cbc:Name>
                               <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>
                            </cac:TaxScheme>
                         </cac:TaxCategory>
                      </cac:TaxSubtotal>';
                              }

              $facturaXML.='
              </cac:TaxTotal>
              <!-- Fin Tributos  Cabecera-->

                <cac:LegalMonetaryTotal>
                    <cbc:LineExtensionAmount currencyID="'.$moneda[$i].'">'.$subtotal[$i].'</cbc:LineExtensionAmount>
                    <cbc:TaxInclusiveAmount currencyID="'.$moneda[$i].'">'.$total[$i].'</cbc:TaxInclusiveAmount>
                    <cbc:AllowanceTotalAmount currencyID="'.$moneda[$i].'">0.00</cbc:AllowanceTotalAmount>
                    <cbc:ChargeTotalAmount currencyID="'.$moneda[$i].'">0.00</cbc:ChargeTotalAmount>  
                    <cbc:PrepaidAmount currencyID="'.$moneda[$i].'">0.00</cbc:PrepaidAmount>  
                    <cbc:PayableAmount currencyID="'.$moneda[$i].'">'.$total[$i].'</cbc:PayableAmount>
                </cac:LegalMonetaryTotal>';
                        }//For cabecera
                        $i=$i+1;
                        $con=$con+1;           
                        }//While cabecera

      $codigo=array();  
      $cantidad=array(); 
      $descripcion=array();  
      $um=array();  
      $vui=array();
      $igvi=array();  
      $pvi=array(); 
      $vvi=array(); 
      $sutribitem=array();  
      $aigv=array(); 
      $codtrib=array();
      $nomtrib=array(); 
      $coditrib=array(); 
      $codigosunat=array(); 
      $numorden=array();  
      $monedaD=array();
       $mticbperu=array();
      $igv_="";
      $igv_=$configE->igv;

  while($rowf=mysqli_fetch_assoc($resultf)){
      for($if=0; $if < count($resultf); $if++){
           $codigo[$if]=$rowf["codigo"];
           $cantidad[$if]=$rowf["cantidad"];
           $descripcion[$if]=$rowf["descripcion"];
           $vui[$if]=$rowf["vui"];
           $sutribitem[$if]=$rowf["sutribitem"];           
           $igvi[$if]=$rowf["igvi"];
           $pvi[$if]=$rowf["pvi"];
           $vvi[$if]=$rowf["vvi"];
           $um[$if]=$rowf["um"];
           $tipocompf=$rowf["tipocomp"];
           $numerodocf=$rowf["numerodoc"];
           $ruc=$datose->numero_ruc;
           $aigv[$if]=$rowf["aigv"];
           $codtrib[$if]=$rowf["codtrib"];
           $nomtrib[$if]=$rowf["nomtrib"];
           $coditrib[$if]=$rowf["coditrib"];
           $codigosunat[$if]=$rowf["codigosunat"];
           $numorden[$if]=$rowf["numorden"];
           $monedaD[$if]=$rowf["moneda"];

           $mticbperu[$if]=$rowf["mticbperu"] ;           
           $icbperD=$rowf["icbper"];

               /* Número de orden del Ítem
                  Cantidad y Unidad de medida por ítem
                  Valor de venta del ítem  */

                $facturaXML.='<cac:InvoiceLine>
                    <cbc:ID>'. $numorden[$if] .'</cbc:ID>
                    <cbc:InvoicedQuantity unitCode="'. $um[$if] .'">'.number_format($cantidad[$if],2,'.','').'</cbc:InvoicedQuantity>
                    <cbc:LineExtensionAmount currencyID="'.$monedaD[$if].'">'.number_format($vvi[$if],2,'.','').'</cbc:LineExtensionAmount>
                    
                    <cac:PricingReference>
                        <cac:AlternativeConditionPrice>
                            <cbc:PriceAmount currencyID="'.$monedaD[$if].'">'.number_format($pvi[$if],2,'.','').'</cbc:PriceAmount>
                            <cbc:PriceTypeCode>01</cbc:PriceTypeCode>
                        </cac:AlternativeConditionPrice>
                    </cac:PricingReference>

                <!-- Inicio Tributos --> 
                    <cac:TaxTotal>
                        <cbc:TaxAmount currencyID="'.$monedaD[$if].'">'.number_format($sutribitem[$if],2,'.','').'</cbc:TaxAmount>                        
                        <cac:TaxSubtotal>
                            <cbc:TaxableAmount currencyID="'.$monedaD[$if].'">'.number_format($vvi[$if],2,'.','').'</cbc:TaxableAmount>
                            <cbc:TaxAmount currencyID="'.$monedaD[$if].'">'.number_format($sutribitem[$if],2,'.','').'</cbc:TaxAmount>
                            <cac:TaxCategory>
                                <cbc:Percent>18.00</cbc:Percent>
                                <cbc:TaxExemptionReasonCode>'.$aigv[$if].'</cbc:TaxExemptionReasonCode>
                                <cac:TaxScheme>
                                    <cbc:ID>'.$codtrib[$if].'</cbc:ID>
                                    <cbc:Name>'.$nomtrib[$if].'</cbc:Name>
                                    <cbc:TaxTypeCode>'.$coditrib[$if].'</cbc:TaxTypeCode>
                                </cac:TaxScheme>
                            </cac:TaxCategory>
                        </cac:TaxSubtotal>';


        if ($codigo[$if]=="ICBPER")
                         {
                        
                $facturaXML.='
                <cac:TaxSubtotal>
                <cbc:TaxAmount currencyID="'. $monedaD[$if] .'">'.$icbperD.'</cbc:TaxAmount>
                    <cbc:BaseUnitMeasure unitCode="'.$um[$if].'">'.number_format($cantidad[$if],0,'.','').'</cbc:BaseUnitMeasure>
                    <cac:TaxCategory>
                    <cbc:PerUnitAmount currencyID="'. $monedaD[$if] .'">'.number_format($mticbperu[$if],2,'.','').'</cbc:PerUnitAmount>
                       <cac:TaxScheme>
                          <cbc:ID>7152</cbc:ID>
                          <cbc:Name>ICBPER</cbc:Name>
                          <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>
                       </cac:TaxScheme>
                    </cac:TaxCategory>
                 </cac:TaxSubtotal>';
                      };


                     $facturaXML.='
                     </cac:TaxTotal>

                    <cac:Item>
                        <cbc:Description><![CDATA['.$descripcion[$if].']]></cbc:Description>
                         <cac:SellersItemIdentification>
                            <cbc:ID>'.$codigo[$if].'</cbc:ID>
                        </cac:SellersItemIdentification>
                    </cac:Item>

                    <cac:Price>
                        <cbc:PriceAmount currencyID="'.$monedaD[$if].'">'.number_format($vui[$if],5,'.','').'</cbc:PriceAmount>
                    </cac:Price>
                </cac:InvoiceLine>';
  
     }//Fin for
     }//Find e while 
   $facturaXML.= '</Invoice>';
//FIN DE CABECERA ===================================================================


// Nos aseguramos de que la cadena que contiene el XML esté en UTF-8
  $facturaXML = mb_convert_encoding($facturaXML, "UTF-8");
  // Grabamos el XML en el servidor como un fichero plano, para
  // poder ser leido por otra aplicación.
  $gestor = fopen($rutafirma.$ruc."-".$tipocomp."-".$numerodoc.".xml", 'w');
  fwrite($gestor, $facturaXML);
  fclose($gestor);

  $cabextxml=$rutafirma.$ruc."-".$tipocomp."-".$numerodoc.".xml";
  $cabxml=$ruc."-".$tipocomp."-".$numerodoc.".xml";
  $nomxml=$ruc."-".$tipocomp."-".$numerodoc;
  $nomxmlruta=$rutafirma.$ruc."-".$tipocomp."-".$numerodoc;

              require_once ("../greemter/Greenter.php");
              $invo = new Greenter();
              $out=$invo->getDatFac($cabextxml);

              $filenaz = $nomxml.".zip";
              $zip = new ZipArchive();
              if($zip->open($filenaz,ZIPARCHIVE::CREATE)===true) {
                //$zip->addEmptyDir("dummy");
                $zip->addFile($cabextxml,$cabxml);
                $zip->close();

                //if(!file_exists($rutaz)){mkdir($rutaz);}
                $imagen = file_get_contents($filenaz);
                $imageData = base64_encode($imagen);
                rename($cabextxml, $rutafirma.$cabxml);
                rename($filenaz, $rutaenvio.$filenaz);
              }
              else
              {
                $out="Error al comprimir archivo";
              }
              
            $rpta = array ('cabextxml'=>$cabextxml,'cabxml'=>$cabxml, 'rutafirma'=>$cabextxml);
            $sqlDetalle="update factura set DetalleSunat='XML firmado' where idfactura='$idcomprobante'";
            ejecutarConsulta($sqlDetalle);

  return $rpta;

    }

    else // SI EL COMPROBANTE ES BOLETA 

    {

     require_once "../modelos/Factura.php";
    $factura = new Factura();
    $datos = $factura->datosemp($idempresa);
    $datose = $datos->fetch_object();

    $configuraciones = $factura->configuraciones($idempresa);
    $configE=$configuraciones->fetch_object();

    

    //Inclusion de la tabla RUTAS
    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($idempresa);
    $Prutas = $Rrutas->fetch_object();
    $rutadata=$Prutas->rutadata; // ruta de la carpeta DATA
    $rutafirma=$Prutas->rutafirma; // ruta de la carpeta FIRMA
    $rutadatalt=$Prutas->rutadatalt; // ruta de la carpeta DATAALTERNA
    $rutaenvio=$Prutas->rutaenvio; // ruta de la carpeta DATAALTERNA

    $query = "select
     date_format(b.fecha_emision_01, '%Y-%m-%d') as fecha, 
     right(substring_index(b.numeracion_07,'-',1),1) as serie,
     date_format(b.fecha_emision_01, '%H:%i:%s') as hora,
     p.tipo_documento as  tipodocuCliente, 
     p.numero_documento, 
     p.razon_social, 
     b.tipo_moneda_24, 
     b.monto_15_2 as subtotal, 
     b.sumatoria_igv_18_1 as igv, 
     b.importe_total_23 as total, 
     b.tipo_documento_06 as tipocomp, 
     b.numeracion_07 as numerodoc, 
     b.estado, 
     b.tdescuento,
     b.codigo_tributo_18_3 as codigotrib,
     b.nombre_tributo_18_4  as nombretrib,
     b.codigo_internacional_18_5 as codigointtrib,
     b.codigo_tipo_15_1 as opera,
     e.ubigueo,
      b.icbper
     from 
     boleta b inner join persona p on b.idcliente=p.idpersona inner join empresa e on b.idempresa=e.idempresa where idboleta='$idcomprobante' and b.estado in('1','4') order by numerodoc";

    $querydetbol = "select
       b.tipo_documento_06 as tipocomp, 
       b.numeracion_07 as numerodoc,  
       db.cantidad_item_12 as cantidad, 
       a.codigo, 
       a.nombre as descripcion, 
       a.unidad_medida as um,
       replace(format(db.valor_uni_item_31,5),',','') as vui, 
       db.igv_item as igvi, 
       db.precio_uni_item_14_2 as pvi, 
       db.valor_venta_item_32 as vvi,
       db.afectacion_igv_item_monto_27_1 as sutribitem,
       db.numero_orden_item_29 as numorden,

       db.afectacion_igv_3 as aigv,
       db.afectacion_igv_4 codtrib,
       db.afectacion_igv_5 as nomtrib,
       db.afectacion_igv_6 as coditrib,
       a.codigosunat,
       b.tipo_moneda_24 as moneda,
        a.mticbperu,
       b.icbper

       from
       boleta b inner join detalle_boleta_producto db on b.idboleta=db.idboleta inner join articulo a on db.idarticulo=a.idarticulo
          where b.idboleta='$idcomprobante' and b.estado in ('1','4') order by b.fecha_emision_01";


      $result = mysqli_query($connect, $query);  
      $resultb = mysqli_query($connect, $querydetbol); 

      $nombrecomercial=$datose->nombre_comercial;
    $domiciliofiscal=$datose->domicilio_fiscal;
    $codestablecimiento=$datose->ubigueo;
    $codubigueo=$datose->codubigueo;
    $ciudad=$datose->ciudad;
    $distrito=$datose->distrito;
    $interior=$datose->interior;
    $codigopais=$datose->codigopais;


      //Parametros de salida
      $fecha=array();
      $hora=array();
      $serie=array();
      $tipodocu=array();
      $numdocu=array();
      $rasoc=array();
      $moneda=array();
      $codigotrib=array();
      $nombretrib=array();
      $codigointtrib=array();
      $subtotal=array();
      $igv=array();
      $total=array();
      $tdescu=array();
      $opera=array();
      $ubigueo=array();

      $con=0; //COntador de variable
        $icbper="";
            
      while($row=mysqli_fetch_assoc($result)){
      for($i=0; $i <= count($result); $i++){
           $fecha[$i]=$row["fecha"]; //Fecha emision
           $serie[$i]=$row["serie"];
           $tipodocu[$i]=$row["tipodocuCliente"]; //Tipo de documento de cliente ruc o dni
           $numdocu[$i]=$row["numero_documento"]; //NUmero de docuemnto de cliente
           $rasoc[$i]=$row["razon_social"]; //Nombre de cliente
           $moneda[$i]=$row["tipo_moneda_24"];
           $subtotal[$i]=$row["subtotal"];
           $igv[$i]=$row["igv"];
           $total[$i]=$row["total"];
           $tdescu[$i]=$row["tdescuento"];
           $hora[$i]=$row["hora"];
           $tipocomp=$row["tipocomp"];
           $numerodoc=$row["numerodoc"];
           $ruc=$datose->numero_ruc;
           $ubigueo=$datose->ubigueo;
           $opera[$i]=$row["opera"];

           $codigotrib[$i]=$row["codigotrib"];//codigo de tributo de la tabla catalo 5
           $nombretrib[$i]=$row["nombretrib"];//NOmbre de tributo de la tabla catalo 5
           $codigointtrib[$i]=$row["codigointtrib"];//Codigo internacional de la tabla catalo 5

           $icbper=$row["icbper"];

             $Lmoneda="NUEVOS SOLES";
       if ($moneda[$i]=='USD') {
             $Lmoneda="DOLARES AMERICANOS";
           }


       require_once "Letras.php";
       $V=new EnLetras(); 
       $con_letra=strtoupper($V->ValorEnLetras($total[$i], $Lmoneda));


//======================================== FORMATO XML ========================================================
 $domiciliofiscal=$datose->domicilio_fiscal;
//Primera parte
$boletaXML ='<?xml version="1.0" encoding="utf-8"?>
            <Invoice xmlns="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2"
                     xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2"
                     xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"
                     xmlns:ds="http://www.w3.org/2000/09/xmldsig#"
                     xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2">
                <ext:UBLExtensions>
                    <ext:UBLExtension>
                        <ext:ExtensionContent/>
                    </ext:UBLExtension>
                </ext:UBLExtensions>
                <cbc:UBLVersionID>2.1</cbc:UBLVersionID>
                <cbc:CustomizationID>2.0</cbc:CustomizationID>
                <cbc:ID>'.$numerodoc.'</cbc:ID>
                <cbc:IssueDate>'.$fecha[$i].'</cbc:IssueDate>
                <cbc:IssueTime>'.$hora[$i].'</cbc:IssueTime>

                <cbc:InvoiceTypeCode listID="0101">'.$tipocomp.'</cbc:InvoiceTypeCode>

                <cbc:Note languageLocaleID="1000">'.$con_letra.'</cbc:Note>

              <cbc:Note languageLocaleID="2006">Leyenda: Operación sujeta a detracción</cbc:Note>
              <cbc:DocumentCurrencyCode>'.$moneda[$i].'</cbc:DocumentCurrencyCode>

             

                <cac:Signature>
                    <cbc:ID>'.$ruc.'</cbc:ID>
                    <cbc:Note>SENCON</cbc:Note>
                    <cac:SignatoryParty>
                        <cac:PartyIdentification>
                            <cbc:ID>'.$ruc.'</cbc:ID>
                        </cac:PartyIdentification>
                        <cac:PartyName>
                            <cbc:Name><![CDATA['.$nombrecomercial.']]></cbc:Name>
                        </cac:PartyName>
                    </cac:SignatoryParty>
                    <cac:DigitalSignatureAttachment>
                        <cac:ExternalReference>
                            <cbc:URI>#SIGN-SENCON</cbc:URI>
                        </cac:ExternalReference>
                    </cac:DigitalSignatureAttachment>
                </cac:Signature>

                <cac:AccountingSupplierParty>
                    <cac:Party>
                        <cac:PartyIdentification>
                            <cbc:ID schemeID="6">'.$ruc.'</cbc:ID>
                        </cac:PartyIdentification>
                        <cac:PartyName>
                            <cbc:Name><![CDATA['.$nombrecomercial.']]></cbc:Name>
                        </cac:PartyName>
                        <cac:PartyLegalEntity>
                            <cbc:RegistrationName><![CDATA['.$nombrecomercial.']]></cbc:RegistrationName>
                            <cac:RegistrationAddress>
                                <cbc:AddressTypeCode>'.$codestablecimiento.'</cbc:AddressTypeCode>
                               <cbc:CitySubdivisionName>'.$interior.'</cbc:CitySubdivisionName>
                                <cbc:CityName>'.$ciudad.'</cbc:CityName>
                                  <cbc:CountrySubentity>'.$ciudad.'</cbc:CountrySubentity>
                                    <cbc:CountrySubentityCode>'.$codubigueo.'</cbc:CountrySubentityCode>
                                      <cbc:District>'.$distrito.'</cbc:District> 
                                      <cac:AddressLine>
                                        <cbc:Line><![CDATA['.$domiciliofiscal.']]></cbc:Line>
                                          </cac:AddressLine>    
                                            <cac:Country>
                                              <cbc:IdentificationCode>PE</cbc:IdentificationCode>
                                                </cac:Country>
                            </cac:RegistrationAddress>
                        </cac:PartyLegalEntity>
                    </cac:Party>
                </cac:AccountingSupplierParty>

                <cac:AccountingCustomerParty>
                    <cac:Party>
                        <cac:PartyIdentification>
                            <cbc:ID schemeID="'.$tipodocu[$i].'">'.$numdocu[$i].'</cbc:ID>
                        </cac:PartyIdentification>
                        <cac:PartyLegalEntity>
                            <cbc:RegistrationName><![CDATA['.$rasoc[$i].']]></cbc:RegistrationName>
                        </cac:PartyLegalEntity>
                    </cac:Party>
                </cac:AccountingCustomerParty>';

               /*  $boletaXML.='<cac:PaymentMeans>
                    <cbc:PaymentMeansCode>0</cbc:PaymentMeansCode>
                    <cac:PayeeFinancialAccount>
                        <cbc:ID>-</cbc:ID>
                    </cac:PayeeFinancialAccount>
                </cac:PaymentMeans>

                <cac:PaymentTerms>
                    <cbc:PaymentMeansID>000</cbc:PaymentMeansID>
                    <cbc:PaymentPercent>0.00</cbc:PaymentPercent>
                    <cbc:Amount currencyID="PEN">0.00</cbc:Amount>
                </cac:PaymentTerms>'; */


                $boletaXML.='<cac:TaxTotal>
                    <cbc:TaxAmount currencyID="'.$moneda[$i].'">'.$igv[$i].'</cbc:TaxAmount>
                        <cac:TaxSubtotal>
                        <cbc:TaxableAmount currencyID="'.$moneda[$i].'">'.$subtotal[$i].'</cbc:TaxableAmount>
                        <cbc:TaxAmount currencyID="'.$moneda[$i].'">'.$igv[$i].'</cbc:TaxAmount>
                        <cac:TaxCategory>
                            <cac:TaxScheme>
                                <cbc:ID>'.$codigotrib[$i].'</cbc:ID>
                                <cbc:Name>'.$nombretrib[$i].'</cbc:Name>
                                <cbc:TaxTypeCode>'.$codigointtrib[$i].'</cbc:TaxTypeCode>
                            </cac:TaxScheme>
                        </cac:TaxCategory>
                     </cac:TaxSubtotal>';


                     if ($icbper>0) {
                        $boletaXML.='
                        <cac:TaxSubtotal>
                  <cbc:TaxAmount currencyID="'.$moneda[$i].'">'.$icbper.'</cbc:TaxAmount>
                         <cac:TaxCategory>
                            <cac:TaxScheme>
                               <cbc:ID>7152</cbc:ID>
                               <cbc:Name>ICBPER</cbc:Name>
                               <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>
                            </cac:TaxScheme>
                         </cac:TaxCategory>
                      </cac:TaxSubtotal>';
                              }

              $boletaXML.='
            <!-- Fin Tributos  Cabecera-->
              </cac:TaxTotal>

                <cac:LegalMonetaryTotal>
                    <cbc:LineExtensionAmount currencyID="'.$moneda[$i].'">'.$subtotal[$i].'</cbc:LineExtensionAmount>
                    <cbc:TaxInclusiveAmount currencyID="'.$moneda[$i].'">'.$total[$i].'</cbc:TaxInclusiveAmount>
                    <cbc:AllowanceTotalAmount currencyID="'.$moneda[$i].'">0.00</cbc:AllowanceTotalAmount>
                    <cbc:ChargeTotalAmount currencyID="'.$moneda[$i].'">0.00</cbc:ChargeTotalAmount>  
                    <cbc:PrepaidAmount currencyID="'.$moneda[$i].'">0.00</cbc:PrepaidAmount>  
                    <cbc:PayableAmount currencyID="'.$moneda[$i].'">'.$total[$i].'</cbc:PayableAmount>
                </cac:LegalMonetaryTotal>';
                        }//For cabecera
                        $i=$i+1;
                        $con=$con+1;           
                        }//While cabecera

      $codigo=array();  
      $cantidad=array(); 
      $descripcion=array();  
      $um=array();  
      $vui=array();
      $igvi=array();  
      $pvi=array(); 
      $vvi=array(); 
      $sutribitem=array();  
      $aigv=array(); 
      $codtrib=array();
      $nomtrib=array(); 
      $coditrib=array(); 
      $codigosunat=array(); 
      $numorden=array();
      $monedaD=array();
       $mticbperu=array();
      $igv_="";
      $igv_=$configE->igv;

  while($rowb=mysqli_fetch_assoc($resultb)){
      for($ib=0; $ib < count($resultb); $ib++){
           $codigo[$ib]=$rowb["codigo"];
           $cantidad[$ib]=$rowb["cantidad"];
           $descripcion[$ib]=$rowb["descripcion"];
           $vui[$ib]=$rowb["vui"];
           $sutribitem[$ib]=$rowb["sutribitem"];           
           $igvi[$ib]=$rowb["igvi"];
           $pvi[$ib]=$rowb["pvi"];
           $vvi[$ib]=$rowb["vvi"];
           $um[$ib]=$rowb["um"];
           $tipocompf=$rowb["tipocomp"];
           $numerodocf=$rowb["numerodoc"];
           $ruc=$datose->numero_ruc;
           $aigv[$ib]=$rowb["aigv"];
           $codtrib[$ib]=$rowb["codtrib"];
           $nomtrib[$ib]=$rowb["nomtrib"];
           $coditrib[$ib]=$rowb["coditrib"];
           $codigosunat[$ib]=$rowb["codigosunat"];
           $numorden[$ib]=$rowb["numorden"];

           $monedaD[$ib]=$rowb["moneda"];
           $mticbperu[$ib]=$rowb["mticbperu"] ;

           $icbperD=$rowb["icbper"];       

               /* Número de orden del Ítem
                  Cantidad y Unidad de medida por ítem
                  Valor de venta del ítem  */

                $boletaXML.='<cac:InvoiceLine>
                    <cbc:ID>'. $numorden[$ib] .'</cbc:ID>
                    <cbc:InvoicedQuantity unitCode="'. $um[$ib] .'">'.number_format($cantidad[$ib],2,'.','').'</cbc:InvoicedQuantity>
                    <cbc:LineExtensionAmount currencyID="'.$monedaD[$ib].'">'.number_format($vvi[$ib],2,'.','').'</cbc:LineExtensionAmount>
                    
                    <cac:PricingReference>
                        <cac:AlternativeConditionPrice>
                            <cbc:PriceAmount currencyID="'.$monedaD[$ib].'">'.number_format($pvi[$ib],2,'.','').'</cbc:PriceAmount>
                            <cbc:PriceTypeCode>01</cbc:PriceTypeCode>
                        </cac:AlternativeConditionPrice>
                    </cac:PricingReference>

                    <cac:TaxTotal>
                        <cbc:TaxAmount currencyID="'.$monedaD[$ib].'">'.number_format($sutribitem[$ib],2,'.','').'</cbc:TaxAmount>                        
                        <cac:TaxSubtotal>
                            <cbc:TaxableAmount currencyID="'.$monedaD[$ib].'">'.number_format($vvi[$ib],2,'.','').'</cbc:TaxableAmount>
                            <cbc:TaxAmount currencyID="'.$monedaD[$ib].'">'.number_format($sutribitem[$ib],2,'.','').'</cbc:TaxAmount>
                            <cac:TaxCategory>
                                <cbc:Percent>18.00</cbc:Percent>
                                <cbc:TaxExemptionReasonCode>'.$aigv[$ib].'</cbc:TaxExemptionReasonCode>
                                <cac:TaxScheme>
                                    <cbc:ID>'.$codtrib[$ib].'</cbc:ID>
                                    <cbc:Name>'.$nomtrib[$ib].'</cbc:Name>
                                    <cbc:TaxTypeCode>'.$coditrib[$ib].'</cbc:TaxTypeCode>
                                </cac:TaxScheme>
                            </cac:TaxCategory>
                        </cac:TaxSubtotal>';

                    if ($codigo[$ib]=="ICBPER")
                         {
                        
                $boletaXML.='

                <cac:TaxSubtotal>
                    <cbc:TaxAmount currencyID="'. $moneda[$ib] .'">'.$icbperD.'</cbc:TaxAmount>
                    <cbc:BaseUnitMeasure unitCode="'. $um[$ib] .'">'.number_format($cantidad[$ib],0,'.','').'</cbc:BaseUnitMeasure>
                    <cac:TaxCategory>
                    <cbc:PerUnitAmount currencyID="'. $moneda[$ib] .'">'.number_format($mticbperu[$ib],2,'.','').'</cbc:PerUnitAmount>
                       <cac:TaxScheme>
                          <cbc:ID>7152</cbc:ID>
                          <cbc:Name>ICBPER</cbc:Name>
                          <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>
                       </cac:TaxScheme>
                    </cac:TaxCategory>
                 </cac:TaxSubtotal>';
                      };


                     $boletaXML.='
                     </cac:TaxTotal>

                    <cac:Item>
                        <cbc:Description><![CDATA['.$descripcion[$ib].']]></cbc:Description>
                        <cac:SellersItemIdentification>
                            <cbc:ID>'.$codigo[$ib].'</cbc:ID>
                        </cac:SellersItemIdentification>
                    </cac:Item>

                    <cac:Price>
                        <cbc:PriceAmount currencyID="'.$monedaD[$ib].'">'.number_format($vui[$ib],5,'.','').'</cbc:PriceAmount>
                    </cac:Price>
                </cac:InvoiceLine>';
  
     }//Fin for
     }//Find e while 
   $boletaXML.= '</Invoice>';
//FIN DE CABECERA ===================================================================


// Nos aseguramos de que la cadena que contiene el XML esté en UTF-8
  $boletaXML = mb_convert_encoding($boletaXML, "UTF-8");
  // Grabamos el XML en el servidor como un fichero plano, para
  // poder ser leido por otra aplicación.
  $gestor = fopen($rutafirma.$ruc."-".$tipocomp."-".$numerodoc.".xml", 'w');
  fwrite($gestor, $boletaXML);
  fclose($gestor);

  $cabextxml=$rutafirma.$ruc."-".$tipocomp."-".$numerodoc.".xml";
  $cabxml=$ruc."-".$tipocomp."-".$numerodoc.".xml";
  $nomxml=$ruc."-".$tipocomp."-".$numerodoc;
  $nomxmlruta=$rutafirma.$ruc."-".$tipocomp."-".$numerodoc;

              require_once ("../greemter/Greenter.php");
              $invo = new Greenter();
              $out=$invo->getDatFac($cabextxml);

              $filenaz = $nomxml.".zip";
              $zip = new ZipArchive();
              if($zip->open($filenaz,ZIPARCHIVE::CREATE)===true) {
                //$zip->addEmptyDir("dummy");
                $zip->addFile($cabextxml,$cabxml);
                $zip->close();

                //if(!file_exists($rutaz)){mkdir($rutaz);}
                $imagen = file_get_contents($filenaz);
                $imageData = base64_encode($imagen);
                rename($cabextxml, $rutafirma.$cabxml);
                rename($filenaz, $rutaenvio.$filenaz);
              }
              else
              {
                $out="Error al comprimir archivo";
              }
              
            $rpta = array ('cabextxml'=>$cabextxml,'cabxml'=>$cabxml, 'rutafirma'=>$cabextxml);
            $sqlDetalle="update boleta set DetalleSunat='XML firmado' where idboleta='$idcomprobante'";
            ejecutarConsulta($sqlDetalle);

  return $rpta;






    }

  } //Fin de funcion




   public function enviarxmlSUNAT($idcomprobante, $tipodoc, $idempresa)
  {
    


    if ($tipodoc=='01') 
    {
        

   require_once "../modelos/Factura.php";
    $factura = new Factura();
    $datos = $factura->correo();
    $correo = $datos->fetch_object();


    require_once "../modelos/Consultas.php";  
    $consultas = new consultas();
    $paramcerti = $consultas->paramscerti();
    $datosc = $paramcerti->fetch_object();

     //Inclusion de la tabla RUTAS
    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($idempresa);
    $Prutas = $Rrutas->fetch_object();
    $rutafirma=$Prutas->rutafirma; // ruta de la carpeta FIRMA
    $rutaenvio=$Prutas->rutaenvio; // ruta de la carpeta FIRMA
    $rutarpta=$Prutas->rutarpta; // ruta de la carpeta FIRMA
    $rutaunzip=$Prutas->unziprpta; // ruta de la carpeta rpta xml

      $connect = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
      mysqli_query( $connect, 'SET NAMES "'.DB_ENCODE.'"');
      //Si tenemos un posible error en la conexión lo mostramos
      if (mysqli_connect_errno())
      {
            printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
            exit();
      }

        $sqlsendmail="select 
        f.idfactura, 
        p.email,  
        p.nombres, 
        p.apellidos, 
        p.nombre_comercial, 
        e.numero_ruc,
        f.tipo_documento_07,
        f.numeracion_08 
        from 
        factura f inner join persona p on 
        f.idcliente=p.idpersona inner join empresa e on 
        f.idempresa=e.idempresa 
        where 
        f.idfactura='$idcomprobante' and e.idempresa='$idempresa' ";

        $result = mysqli_query($connect, $sqlsendmail); 

      $con=0;
      while($row=mysqli_fetch_assoc($result)){
      for($i=0; $i <= count($result); $i++){
           $correocliente=$row["email"];
          }

  //Agregar=====================================================
  // Ruta del directorio donde están los archivos
        $path  = $rutafirma; 
        $files = array_diff(scandir($path), array('.', '..')); 
  //=============================================================
  $factura=$row['numero_ruc']."-".$row['tipo_documento_07']."-".$row['numeracion_08'];

    //Validar si existe el archivo firmado
    foreach($files as $file){
    // Divides en dos el nombre de tu archivo utilizando el . 
    $dataSt = explode(".", $file);
    // Nombre del archivo
    $fileName = $dataSt[0];
    $st="1";
    // Extensión del archivo 
    $fileExtension = $dataSt[1];
    if($factura == $fileName){
        $archivoFactura=$fileName;
        // Realizamos un break para que el ciclo se interrumpa
         break;
      }
    }
    //$url=$rutafirma.$archivoFactura.'.xml';
    $ZipFactura=$rutaenvio.$archivoFactura.'.zip';
    copy($ZipFactura, $archivoFactura.'.zip');
    $ZipFinal=$factura.'.zip';
    //echo $ZipFactura;

    $webservice=$datosc->rutaserviciosunat;
    $usuarioSol=$datosc->usuarioSol;
    $claveSol=$datosc->claveSol;
    $nruc=$datosc->numeroruc;

  //Llamada al WebService=======================================================================
  $service = $webservice; 
  $headers = new CustomHeaders($nruc.$usuarioSol, $claveSol); 
  $client = new SoapClient($service, [ 
    'cache_wsdl' => WSDL_CACHE_NONE, 
    'trace' => TRUE , 
    'soap_version' => SOAP_1_1 ] 
  ); 
  
   try{
   $client->__setSoapHeaders([$headers]); 
   $fcs = $client->__getFunctions();
   $params = array('fileName' => $ZipFinal, 'contentFile' => file_get_contents($ZipFinal) ); 

    //Llamada al WebService=======================================================================
   $status = $client->sendBill($params); // Comando para enviar xml a SUNAT
   $conte  =  $client->__getLastResponse();
   $texto=trim(strip_tags($conte));


   $zip = new ZipArchive();
   if($zip->open("R".$ZipFinal,ZIPARCHIVE::CREATE)===true) {
   $zip->addEmptyDir("dummy");
   $zip->close();}


     $rpt = fopen("R".$ZipFinal, 'w') or die("no se pudo crear archivo");
     fwrite($rpt, base64_decode($texto));
     fclose($rpt);
     rename("R".$ZipFinal, $rutarpta."R".$ZipFinal);
     unlink($ZipFinal);

  $rutarptazip= $rutarpta."R".$ZipFinal;
  $zip = new ZipArchive;
  if ($zip->open($rutarptazip) === TRUE) 
  {
    $zip->extractTo($rutaunzip);
    $zip->close();
  }
   $xmlFinal=$rutaunzip.'R-'.$factura.'.xml';
   $data[0] = "";
   $rpta[0]="";
      $sxe = new SimpleXMLElement($xmlFinal, null, true);
      $urn = $sxe->getNamespaces(true);
      $sxe->registerXPathNamespace('cac', $urn['cbc']);
      $data = $sxe->xpath('//cbc:Description');
      $rpta = $sxe->xpath('//cbc:ResponseCode');
      
      if ($rpta[0]=='0') {
          $msg="Aceptada por SUNAT";
          $sqlCodigo="update factura set CodigoRptaSunat='$rpta[0]', DetalleSunat='$data[0]' where idfactura='$idcomprobante'";
        }else{
          $sqlCodigo="update factura set CodigoRptaSunat='$rpta[0]', DetalleSunat='$data[0]' where idfactura='$idcomprobante'";    
      }

      ejecutarConsulta($sqlCodigo);

  return $data[0];



// Llamada al WebService=======================================================================
   }catch (SoapFault $exception){
   $exception=print_r($client->__getLastResponse());
   }

  }//Fin While

 


}

else // SI ES BOLETA

{

     require_once "../modelos/Factura.php";
    $factura = new Factura();
    $datos = $factura->correo();
    $correo = $datos->fetch_object();


    require_once "../modelos/Consultas.php";  
    $consultas = new consultas();
    $paramcerti = $consultas->paramscerti();
    $datosc = $paramcerti->fetch_object();

     //Inclusion de la tabla RUTAS
    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($idempresa);
    $Prutas = $Rrutas->fetch_object();
    $rutafirma=$Prutas->rutafirma; // ruta de la carpeta FIRMA
    $rutaenvio=$Prutas->rutaenvio; // ruta de la carpeta FIRMA
    $rutarpta=$Prutas->rutarpta; // ruta de la carpeta FIRMA
    $rutaunzip=$Prutas->unziprpta; // ruta de la carpeta rpta xml

      $connect = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
      mysqli_query( $connect, 'SET NAMES "'.DB_ENCODE.'"');
      //Si tenemos un posible error en la conexión lo mostramos
      if (mysqli_connect_errno())
      {
            printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
            exit();
      }

        $sqlsendmail="select 
        b.idboleta, 
        p.email,  
        p.nombres, 
        p.apellidos, 
        p.nombre_comercial, 
        e.numero_ruc,
        b.tipo_documento_06,
        b.numeracion_07 
        from 
        boleta b inner join persona p on 
        b.idcliente=p.idpersona inner join empresa e on 
        b.idempresa=e.idempresa 
        where 
        b.idboleta='$idcomprobante' and e.idempresa='$idempresa' ";

        $result = mysqli_query($connect, $sqlsendmail); 

      $con=0;
      while($row=mysqli_fetch_assoc($result)){
      for($i=0; $i <= count($result); $i++){
           $correocliente=$row["email"];
          }

  //Agregar=====================================================
  // Ruta del directorio donde están los archivos
        $path  = $rutafirma; 
        $files = array_diff(scandir($path), array('.', '..')); 
  //=============================================================
  $boleta=$row['numero_ruc']."-".$row['tipo_documento_06']."-".$row['numeracion_07'];

    //Validar si existe el archivo firmado
    foreach($files as $file){
    // Divides en dos el nombre de tu archivo utilizando el . 
    $dataSt = explode(".", $file);
    // Nombre del archivo
    $fileName = $dataSt[0];
    $st="1";
    // Extensión del archivo 
    $fileExtension = $dataSt[1];
    if($boleta == $fileName){
        $archivoBoleta=$fileName;
        // Realizamos un break para que el ciclo se interrumpa
         break;
      }
    }
    //$url=$rutafirma.$archivoFactura.'.xml';
    $ZipBoleta=$rutaenvio.$archivoBoleta.'.zip';
    copy($ZipBoleta, $archivoBoleta.'.zip');
    $ZipFinal=$boleta.'.zip';
    //echo $ZipFactura;

    $webservice=$datosc->rutaserviciosunat;
    $usuarioSol=$datosc->usuarioSol;
    $claveSol=$datosc->claveSol;
    $nruc=$datosc->numeroruc;

  //Llamada al WebService=======================================================================
  $service = $webservice; 
  $headers = new CustomHeaders($nruc.$usuarioSol, $claveSol); 
  $client = new SoapClient($service, [ 
    'cache_wsdl' => WSDL_CACHE_NONE, 
    'trace' => TRUE , 
    'soap_version' => SOAP_1_1 ] 
  ); 
  
   try{
   $client->__setSoapHeaders([$headers]); 
   $fcs = $client->__getFunctions();
   $params = array('fileName' => $ZipFinal, 'contentFile' => file_get_contents($ZipFinal) ); 

    //Llamada al WebService=======================================================================
   $status = $client->sendBill($params); // Comando para enviar xml a SUNAT
   $conte  =  $client->__getLastResponse();
   $texto=trim(strip_tags($conte));


   $zip = new ZipArchive();
   if($zip->open("R".$ZipFinal,ZIPARCHIVE::CREATE)===true) {
   $zip->addEmptyDir("dummy");
   $zip->close();}


     $rpt = fopen("R".$ZipFinal, 'w') or die("no se pudo crear archivo");
     fwrite($rpt, base64_decode($texto));
     fclose($rpt);
     rename("R".$ZipFinal, $rutarpta."R".$ZipFinal);
     unlink($ZipFinal);

      $rutarptazip= $rutarpta."R".$ZipFinal;
  $zip = new ZipArchive;
  if ($zip->open($rutarptazip) === TRUE) 
  {
    $zip->extractTo($rutaunzip);
    $zip->close();
  }
   $xmlFinal=$rutaunzip.'R-'.$boleta.'.xml';
   $data[0] = "";
   $rpta[0]="";
      $sxe = new SimpleXMLElement($xmlFinal, null, true);
      $urn = $sxe->getNamespaces(true);
      $sxe->registerXPathNamespace('cac', $urn['cbc']);
      $data = $sxe->xpath('//cbc:Description');
      $rpta = $sxe->xpath('//cbc:ResponseCode');
      
      if ($rpta[0]=='0') {
          $msg="Aceptada por SUNAT";
          $sqlCodigo="update boleta set CodigoRptaSunat='$rpta[0]', DetalleSunat='$data[0]' where idboleta='$idcomprobante'";
        }else{
          $sqlCodigo="update boleta set CodigoRptaSunat='$rpta[0]', DetalleSunat='$data[0]' where idboleta='$idcomprobante'";    
      }

      ejecutarConsulta($sqlCodigo);

  return $data[0];


// Llamada al WebService=======================================================================
   }catch (SoapFault $exception){
   $exception=print_r($client->__getLastResponse());
   }

  }//Fin While

 
        }
  }






   public function mostrarxml($idcomprobante, $tipodoc, $idempresa)
  {
    
        $connect = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
      mysqli_query( $connect, 'SET NAMES "'.DB_ENCODE.'"');
      //Si tenemos un posible error en la conexión lo mostramos
      if (mysqli_connect_errno())
      {
            printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
            exit();
      }

    if ($tipodoc=='01') 
    {

    require_once "../modelos/Factura.php";
    $factura = new Factura();
    $datos = $factura->datosemp($idempresa);
    $datose = $datos->fetch_object();

    $nombrecomercial=$datose->nombre_comercial;

    //Inclusion de la tabla RUTAS
    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($idempresa);
    $Prutas = $Rrutas->fetch_object();
    $rutadata=$Prutas->rutadata; // ruta de la carpeta DATA
    $rutafirma=$Prutas->rutafirma; // ruta de la carpeta FIRMA
    $rutadatalt=$Prutas->rutadatalt; // ruta de la carpeta DATAALTERNA
    $rutaenvio=$Prutas->rutaenvio; // ruta de la carpeta rutaenvio
    $rutaunzipxml=$Prutas->unziprpta; // ruta de la carpeta ruta unziprpta

     $query = "select
     f.tipo_documento_07 as tipocomp, 
     f.numeracion_08 as numerodoc 
     from 
     factura f inner join persona p on f.idcliente=p.idpersona inner join empresa e on f.idempresa=e.idempresa where idfactura='$idcomprobante' and f.estado in('1','4','5') order by numerodoc";

     $result = mysqli_query($connect, $query);  


     if ($result) {
      while($row=mysqli_fetch_assoc($result)){
      for($i=0; $i <= count($result); $i++){
           $tipocomp=$row["tipocomp"];
           $numerodoc=$row["numerodoc"];
           $ruc=$datose->numero_ruc;
         }
       }
    $cabextxml=$rutafirma.$ruc."-".$tipocomp."-".$numerodoc.".xml";
    $rpta = array ('rutafirma'=>$cabextxml);

     }else{

      $rpta = array ('rutafirma'=>'Aún no se ha creado el archivo XML.');
     }
      

  return $rpta;

        }


        else // SI ES BOLETA

        {

    require_once "../modelos/Factura.php";
    $factura = new Factura();
    $datos = $factura->datosemp($idempresa);
    $datose = $datos->fetch_object();

    $nombrecomercial=$datose->nombre_comercial;

    //Inclusion de la tabla RUTAS
    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($idempresa);
    $Prutas = $Rrutas->fetch_object();
    $rutadata=$Prutas->rutadata; // ruta de la carpeta DATA
    $rutafirma=$Prutas->rutafirma; // ruta de la carpeta FIRMA
    $rutadatalt=$Prutas->rutadatalt; // ruta de la carpeta DATAALTERNA
    $rutaenvio=$Prutas->rutaenvio; // ruta de la carpeta rutaenvio
    $rutaunzipxml=$Prutas->unziprpta; // ruta de la carpeta ruta unziprpta

     $query = "select
     b.tipo_documento_06 as tipocomp, 
     b.numeracion_07 as numerodoc 
     from 
     boleta b inner join persona p on b.idcliente=p.idpersona inner join empresa e on b.idempresa=e.idempresa where idboleta='$idcomprobante' and b.estado in('1','4','5') order by numerodoc";

     $result = mysqli_query($connect, $query);  


     if ($result) {
      while($row=mysqli_fetch_assoc($result)){
      for($i=0; $i <= count($result); $i++){
           $tipocomp=$row["tipocomp"];
           $numerodoc=$row["numerodoc"];
           $ruc=$datose->numero_ruc;
         }
       }
    $cabextxml=$rutafirma.$ruc."-".$tipocomp."-".$numerodoc.".xml";
    $rpta = array ('rutafirma'=>$cabextxml);

     }else{

      $rpta = array ('rutafirma'=>'Aún no se ha creado el archivo XML.');
     }
  return $rpta;

        }
}






    public function mostrarrpta($idcomprobante, $tipodoc, $idempresa)
  {
    
    $connect = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
      mysqli_query( $connect, 'SET NAMES "'.DB_ENCODE.'"');
      //Si tenemos un posible error en la conexión lo mostramos
      if (mysqli_connect_errno())
      {
            printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
            exit();
      }



    if ($tipodoc=='01') 
      {
    require_once "../modelos/Factura.php";
    $factura = new Factura();
    $datos = $factura->datosemp($idempresa);
    $datose = $datos->fetch_object();

    //Inclusion de la tabla RUTAS
    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($idempresa);
    $Prutas = $Rrutas->fetch_object();
    $rutarpta=$Prutas->rutarpta; // ruta de la carpeta DATA
    $rutaunzipxml=$Prutas->unziprpta; // ruta de la carpeta ruta unziprpta
    

     $query = "select
     f.tipo_documento_07 as tipocomp, 
     f.numeracion_08 as numerodoc 
     from 
     factura f inner join persona p on f.idcliente=p.idpersona inner join empresa e on f.idempresa=e.idempresa where idfactura='$idcomprobante' and f.estado in('5','4') order by numerodoc";

     $result = mysqli_query($connect, $query);  

      $con=0; //COntador de variable
            
      while($row=mysqli_fetch_assoc($result)){
      for($i=0; $i <= count($result); $i++){
           $tipocomp=$row["tipocomp"];
           $numerodoc=$row["numerodoc"];
           $ruc=$datose->numero_ruc;
         }
       }

  $rutarptazip=$rutarpta.'R'.$ruc."-".$tipocomp."-".$numerodoc.".zip";
   $rutaxmlrpta=$rutaunzipxml.'R-'.$ruc."-".$tipocomp."-".$numerodoc.".xml";
   $rpta = array ('rpta'=>$rutarptazip, 'rutaxmlr'=> $rutaxmlrpta);
   return $rpta;

  }


  else

  {

    require_once "../modelos/Factura.php";
    $factura = new Factura();
    $datos = $factura->datosemp($idempresa);
    $datose = $datos->fetch_object();

    //Inclusion de la tabla RUTAS
    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($idempresa);
    $Prutas = $Rrutas->fetch_object();
    $rutarpta=$Prutas->rutarpta; // ruta de la carpeta DATA
    $rutaunzipxml=$Prutas->unziprpta; // ruta de la carpeta ruta unziprpta
    

     $query = "select
     b.tipo_documento_06 as tipocomp, 
     b.numeracion_07 as numerodoc 
     from 
     boleta b inner join persona p on b.idcliente=p.idpersona inner join empresa e on b.idempresa=e.idempresa where idboleta='$idcomprobante' and b.estado in('5','4') order by numerodoc";

     $result = mysqli_query($connect, $query);  

      $con=0; //COntador de variable
            
      while($row=mysqli_fetch_assoc($result)){
      for($i=0; $i <= count($result); $i++){
           $tipocomp=$row["tipocomp"];
           $numerodoc=$row["numerodoc"];
           $ruc=$datose->numero_ruc;
         }
       }

  $rutarptazip=$rutarpta.'R'.$ruc."-".$tipocomp."-".$numerodoc.".zip";
  $rutaxmlrpta=$rutaunzipxml.'R-'.$ruc."-".$tipocomp."-".$numerodoc.".xml";
   $rpta = array ('rpta'=>$rutarptazip, 'rutaxmlr'=> $rutaxmlrpta);
   return $rpta;




  }
}



public function listarValidarComprobantesSiempre()
    {
        $sql="select 
        idcomprobante,
        fecha,
        fechabaja,
        idcliente,
        cliente,
        vendedorsitio,
        usuario,
        tipo_documento_07,
        numeracion_08,
        importe_total_venta_27 ,
        sumatoria_igv_22_1,
        estado,
        numero_ruc,
        email,
        diast,
        DetalleSunat
        from

        (select 
        f.idfactura as idcomprobante,
        date_format(f.fecha_emision_01,'%d/%m/%y') as fecha,
        date_format(curdate(),'%Y%m%d') as fechabaja,
        f.idcliente,
        left(p.razon_social,20) as cliente,
        f.vendedorsitio,
        u.nombre as usuario,
        f.tipo_documento_07,
        f.numeracion_08,
        format(f.importe_total_venta_27,2)as importe_total_venta_27 ,
        f.sumatoria_igv_22_1,
        f.estado,
        e.numero_ruc,
        p.email,
        TIMESTAMPDIFF(DAY,f.fecha_emision_01 ,  curdate()) AS diast,
        f.DetalleSunat
        from  factura f inner join persona p on f.idcliente=p.idpersona 
        inner join usuario u on f.idusuario=u.idusuario 
        inner join empresa e on f.idempresa=e.idempresa where
        year(fecha_emision_01)=year(current_date()) and month(fecha_emision_01)=month(current_date()) 
                 
        union all

        select 
        b.idboleta as idcomprobante,
        date_format(b.fecha_emision_01,'%d/%m/%y') as fecha,
        date_format(curdate(),'%Y%m%d') as fechabaja,
        b.idcliente,
        left(p.nombres,20) as cliente,
        b.vendedorsitio,
        u.nombre as usuario,
        b.tipo_documento_06,
        b.numeracion_07,
        format(b.importe_total_23,2)as importe_total_23 ,
        b.sumatoria_igv_18_1,
        b.estado,
        e.numero_ruc,
        p.email,
        TIMESTAMPDIFF(DAY,b.fecha_emision_01 ,  curdate()) AS diast,
        b.DetalleSunat
        from  boleta b inner join persona p on b.idcliente=p.idpersona 
        inner join usuario u on b.idusuario=u.idusuario 
        inner join empresa e on b.idempresa=e.idempresa where
        year(b.fecha_emision_01)=year(current_date()) and month(b.fecha_emision_01)=month(current_date()) 
        )
        as estados";
        return ejecutarConsulta($sql);  

    }




    public function bajaComprobante($idcomprobante, $tipodoc, $fecha_baja, $com, $hora)
{
    if ($tipodoc=='01') 
    {

$sw=true;
$connect = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
mysqli_query( $connect, 'SET NAMES "'.DB_ENCODE.'"');
      //Si tenemos un posible error en la conexión lo mostramos
      if (mysqli_connect_errno())
      {
            printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
            exit();
      }

    $query="select dt.idfactura, a.idarticulo, dt.cantidad_item_12,  dt.valor_uni_item_14, a.codigo, a.unidad_medida  from detalle_fac_art dt inner join articulo a on dt.idarticulo=a.idarticulo where idfactura = '$idcomprobante'";
    $resultado = mysqli_query($connect,$query);

    $Idf=array();
    $Ida=array();
    $Ct=array();
    $Cod=array();
    $Vu=array();
    $Um=array();
    $sw=true;

    while ($fila = mysqli_fetch_assoc($resultado)) {
    for($i=0; $i < count($resultado) ; $i++){
        $Idf[$i] = $fila["idfactura"];  
        $Ida[$i] = $fila["idarticulo"];  
        $Ct[$i] = $fila["cantidad_item_12"];  
        $Cod[$i] = $fila["codigo"];  
        $Vu[$i] = $fila["valor_uni_item_14"];  
        $Um[$i] = $fila["unidad_medida"];  

    $sql_update_articulo="update detalle_fac_art de inner join 
    articulo a on de.idarticulo=a.idarticulo 
    set 
    a.saldo_finu=a.saldo_finu + '$Ct[$i]', a.stock=a.stock + '$Ct[$i]', a.ventast=a.ventast - '$Ct[$i]'
    where 
    de.idfactura='$Idf[$i]' and de.idarticulo='$Ida[$i]'";

    $sql_update_articulo_2="update detalle_fac_art de inner join 
    articulo a on de.idarticulo=a.idarticulo 
    set 
    a.valor_finu=(a.saldo_iniu + a.comprast - a.ventast) * a.costo_compra
    where 
    de.idfactura='$Idf[$i]' and de.idarticulo='$Ida[$i]'";
        
        
    //ACTUALIZAR TIPO TRANSACCIon KARDEX
    //Guardar en Kardex
    $sql_kardex="insert into kardex (idcomprobante, idarticulo, transaccion, codigo, fecha, tipo_documento, numero_doc, cantidad, costo_1, unidad_medida, saldo_final, costo_2,valor_final) 
            values 
            ('$idcomprobante', '$Ida[$i]', 
            'ANULADO', 
            '$Cod[$i]',
             '$fecha_baja $hora', 
             '01',
             (select numeracion_08 from factura where idfactura='$Idf[$i]'), 
             '$Ct[$i]', 
             '$Vu[$i]',
             '$Um[$i]',
             0, 0, 0)";
        }
        //Fin de FOR
         ejecutarConsulta($sql_update_articulo) or $sw=false;
         ejecutarConsulta($sql_update_articulo_2) or $sw=false;
         ejecutarConsulta($sql_kardex) or $sw=false; 
        }
        //Fin de WHILE
          $sqlestado="update factura set estado='3', fecha_baja='$fecha_baja $hora', comentario_baja='$com', DetalleSunat='C/Baja',  CodigoRptaSunat='3' where idfactura='$idcomprobante'";
         ejecutarConsulta($sqlestado) or $sw=false;
    return $sw;    
}

else     // SI EL COMPROBANTE ES BOLETA

{

 $sw=true;
   $connect = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
      mysqli_query( $connect, 'SET NAMES "'.DB_ENCODE.'"');
      //Si tenemos un posible error en la conexión lo mostramos
      if (mysqli_connect_errno())
      {
            printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
            exit();
      }
    $query="select dt.idboleta, a.idarticulo, dt.cantidad_item_12, dt.valor_uni_item_31, a.codigo, a.unidad_medida  from detalle_boleta_producto dt inner join articulo a on dt.idarticulo=a.idarticulo  where idboleta='$idcomprobante'";

    $resultado = mysqli_query($connect,$query);
    $Idb=array();
    $Ida=array();
    $Ct=array();
    $Cod=array();
    $Vu=array();
    $Um=array();

    while ($fila = mysqli_fetch_assoc($resultado)) {
    for($i=0; $i < count($resultado) ; $i++){
        $Idb[$i] = $fila["idboleta"];  
        $Ida[$i] = $fila["idarticulo"];
         $Ct[$i] = $fila["cantidad_item_12"];  
        $Cod[$i] = $fila["codigo"];  
        $Vu[$i] = $fila["valor_uni_item_31"];  
        $Um[$i] = $fila["unidad_medida"];    

    $sql_update_articulo="update
     detalle_boleta_producto de inner join articulo a  on de.idarticulo=a.idarticulo set
       a.saldo_finu=a.saldo_finu + '$Ct[$i]', 
       a.stock=a.stock + '$Ct[$i]', 
       a.ventast=a.ventast - '$Ct[$i]'
        where 
        de.idboleta='$Idb[$i]' and de.idarticulo='$Ida[$i]'";

        $sql_update_articulo_2="update
     detalle_boleta_producto de inner join articulo a  on de.idarticulo=a.idarticulo
      set
       a.valor_finu=(a.saldo_iniu + a.comprast - a.ventast) * a.costo_compra 
        where 
        de.idboleta='$Idb[$i]' and de.idarticulo='$Ida[$i]'";

    //ACTUALIZAR TIPO TRANSACCION KARDEX
    //Guardar en Kardex
    $sql_kardex="insert into 
    kardex
     (idcomprobante, 
      idarticulo, 
      transaccion, 
      codigo, 
      fecha, 
      tipo_documento, 
      numero_doc, 
      cantidad, 
      costo_1, 
      unidad_medida, 
      saldo_final, 
      costo_2,valor_final) 
            values 
            ('$idcomprobante', 
          '$Ida[$i]', 
            'ANULADO', 
            '$Cod[$i]',
             '$fecha_baja $hora', 
             '03',
             (select numeracion_07 from boleta where idboleta='$Idb[$i]'), 
              '$Ct[$i]', 
             '$Vu[$i]',
             '$Um[$i]',
             0, 0, 0)";
        }
         ejecutarConsulta($sql_update_articulo) or $sw=false;
         ejecutarConsulta($sql_update_articulo_2) or $sw=false;
         ejecutarConsulta($sql_kardex) or $sw=false; 
        }
        $sqlestado="update  boleta  set  estado='3', fecha_baja='$fecha_baja $hora',  comentario_baja='$com' ,
        DetalleSunat='C/Baja',  CodigoRptaSunat='3'
        where 
        idboleta='$idcomprobante'";
        ejecutarConsulta($sqlestado) or $sw=false; 
  return $sw;  

    }

}

public function regbajasxml($ano, $mes, $dia, $idempresa)
{
      $connect = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
      mysqli_query( $connect, 'SET NAMES "'.DB_ENCODE.'"');
      //Si tenemos un posible error en la conexión lo mostramos
      if (mysqli_connect_errno())
      {
            printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
            exit();
      }
    require_once "../modelos/Factura.php";
    $factura = new Factura();
    $datos = $factura->datosemp($idempresa);
    $datose = $datos->fetch_object();
    //Inclusion de la tabla RUTAS
    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($idempresa);
    $Prutas = $Rrutas->fetch_object();

    $rutadata=$Prutas->rutadata; // ruta de la carpeta DATA
    $rutafirma=$Prutas->rutafirma; // ruta de la carpeta FIRMA
    $rutadatalt=$Prutas->rutadatalt; // ruta de la carpeta DATAALTERNA
    $rutaenvio=$Prutas->rutaenvio; // ruta de la carpeta DATAALTERNA

$query = "select 
date_format(fecha, '%Y%m%d') as fechabaja2, 
date_format(fecha, '%Y-%m-%d') as fechabaja,
idfactura,
tipodoc
  from 
  (
  select
fecha_emision_01 as fecha,
idfactura,
tipo_documento_07 as tipodoc
from factura f inner join persona p on f.idcliente=p.idpersona 
where year(fecha_baja)='$ano' and month(fecha_baja)='$mes' and day(fecha_baja)='$dia' and f.estado='3'
     union all 
     select
fecha as fecha,
idnota,
codtiponota as tipodoc
from notacd n 
where year(fecha_baja)='$ano' and month(fecha_baja)='$mes' and day(fecha_baja)='$dia' and n.estado='3'
) as tabla";

$result = mysqli_query($connect, $query);

      $rzonsocial=$datose->nombre_razon_social;
      $domiciliofiscal=$datose->domicilio_fiscal;
      $ruc=$datose->numero_ruc;

      $fecha=array();
      $rowbaja=mysqli_fetch_assoc($result);
           $fechaba=$rowbaja["fechabaja2"];
           $fechaba2=$rowbaja["fechabaja"];
           $idfactura=$rowbaja["idfactura"];
           $tipodoc=$rowbaja["tipodoc"];

$sqlnumerp="select numero from tempnumeracionxml where fecha='$fechaba' and comprobante='$tipodoc'";

$result2 = mysqli_query($connect, $sqlnumerp);

$numero='';
while($rowba=mysqli_fetch_assoc($result2)){
       $numero=$rowba["numero"] + 1;
       }
if ($numero==""){$numero='1';}

        $sqlnumer="insert into tempnumeracionxml (fecha, numero, comprobante) values ('$fechaba', '$numero', '01' )";
        //$idnumer=ejecutarConsulta($sqlnumer);
        $idnumer=ejecutarConsulta_retornarID($sqlnumer);


//PARA LLENAR DETALLE DE COMPROBANTES    
    $result2 = mysqli_query($connect, $query);
    $idfacturad=array();
    $tipodocd=array();
    while($rowdetalle=mysqli_fetch_assoc($result2)){
        for($i=0; $i < count($result); $i++){
            $idfacturad[$i]=$rowdetalle["idfactura"];
            $tipodocd[$i]=$rowdetalle["tipodoc"];

        $sqldetalle="insert into detalle_tablaxml_comprobante (idtablaxml, idcomprobante, tipocomprobante, estado)
         values ('$idnumer', '$idfacturad[$i]', '$tipodocd[$i]', '1' )";
        $dettxmlcom=ejecutarConsulta($sqldetalle);
    }
    $i=$i + 1;
    }
//PARA LLENAR DETALLE DE COMPROBANTES





$resumenbajaXML ='<?xml version="1.0" encoding="utf-8"?>
            <VoidedDocuments xmlns="urn:sunat:names:specification:ubl:peru:schema:xsd:VoidedDocuments-1"
                 xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2"
                 xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"
                 xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2"
                 xmlns:sac="urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1"
                 xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
    <ext:UBLExtensions>
        <ext:UBLExtension>
            <ext:ExtensionContent/>
        </ext:UBLExtension>
    </ext:UBLExtensions>
    
    <cbc:UBLVersionID>2.0</cbc:UBLVersionID>
    <cbc:CustomizationID>1.0</cbc:CustomizationID>

    <cbc:ID>RA-'.$fechaba.'-'.$numero.'</cbc:ID>
    <cbc:ReferenceDate>'.$fechaba2.'</cbc:ReferenceDate>
    <cbc:IssueDate>'.$fechaba2.'</cbc:IssueDate>
    
    <cac:Signature>
        <cbc:ID>'.$ruc.'</cbc:ID>
        <cbc:Note>BYTECNOLOGOS</cbc:Note>
        <cac:SignatoryParty>
            <cac:PartyIdentification>
                <cbc:ID>'.$ruc.'</cbc:ID>
            </cac:PartyIdentification>
            <cac:PartyName>
                <cbc:Name><![CDATA['.$rzonsocial.']]></cbc:Name>
            </cac:PartyName>
        </cac:SignatoryParty>
        <cac:DigitalSignatureAttachment>
            <cac:ExternalReference>
                <cbc:URI>#SIGN-TECNOLOGOS</cbc:URI>
            </cac:ExternalReference>
        </cac:DigitalSignatureAttachment>
    </cac:Signature>
    
    <cac:AccountingSupplierParty>
        <cbc:CustomerAssignedAccountID>'.$ruc.'</cbc:CustomerAssignedAccountID>
        <cbc:AdditionalAccountID>6</cbc:AdditionalAccountID>
        <cac:Party>
            <cac:PartyLegalEntity>
                <cbc:RegistrationName><![CDATA['.$rzonsocial.']]></cbc:RegistrationName>
            </cac:PartyLegalEntity>
        </cac:Party>
    </cac:AccountingSupplierParty>';


$query2 = "select 
date_format(fechahoy, '%Y%m%d') as fechaactual, 
date_format(fecha, '%Y-%m-%d') as fecha, 
date_format(fecha, '%Y%m%d') as fechabaja2, 
date_format(fecha, '%Y-%m-%d') as fechabaja, 
right(substring_index(serie,'-',1),3) as serie,
right(substring_index(serie,'-',1),4) as serie2,
right(substring_index(numerodoc,'-',-1),10) as numerodoc2,
tipodocuCliente, 
rucCliente, 
RazonSocial, 
tmoneda, 
subtotal, 
igv, 
total, 
tipocomp as tipocomp, 
numerodoc, 
est, 
comentario_baja  
  from 
  (select
curdate() as fechahoy, 
fecha_emision_01 as fecha, 
numeracion_08 as serie,
tipodocuCliente, 
rucCliente, 
RazonSocial, 
tipo_moneda_28 as tmoneda, 
total_operaciones_gravadas_monto_18_2 as subtotal, 
sumatoria_igv_22_1 as igv, 
importe_total_venta_27 as total, 
tipo_documento_07 as tipocomp, 
numeracion_08 as numerodoc, 
f.estado as est, 
comentario_baja 
from 
factura f inner join persona p on f.idcliente=p.idpersona 
where year(fecha_baja)='$ano' and month(fecha_baja)='$mes' and day(fecha_baja)='$dia' and f.estado='3'
   
   union all 
   select
curdate() as fechahoy, 
fecha_baja as fecha, 
numeroserienota as serie,
tipo_doc_ide, 
numero_doc_ide, 
razon_social, 
tipo_moneda as tmoneda, 
total_val_venta_og as subtotal, 
sum_igv as igv, 
importe_total as total, 
codigo_nota as tipocomp, 
numeroserienota as numerodoc, 
n.estado as est, 
comentario_baja 
from 
notacd n
where year(fecha_baja)='$ano' and month(fecha_baja)='$mes' and day(fecha_baja)='$dia' and n.estado='3'
) as tabla";
$result2 = mysqli_query($connect, $query2);
  
      //Parametros de salida
      $fecha=array();
      $tipocomp=array();
      $numdocu=array();
      $rasoc=array();
      $fechabaja=array();
      $numeroc=array();
      $comen=array();
      $serie=array();
      $numeroc2=array();
      $fbaja2='';
      $fechaactual='';

      $con=1; //Contador de variable

      while($row=mysqli_fetch_assoc($result2)){
      for($i=0; $i < count($result2); $i++){
           $fecha[$i]=$row["fecha"];
           $fechabaja[$i]=$row["fechabaja"];
           $tipocomp[$i]=$row["tipocomp"];
           $numeroc[$i]=$row["numerodoc"];
           $comen[$i]=$row["comentario_baja"];
           $fbaja2=$row["fechabaja2"];
           $serie[$i]=$row["serie2"];
           $numeroc2[$i]=$row["numerodoc2"];
           $fechaactual=$row["fechaactual"];

   $resumenbajaXML.='
   <sac:VoidedDocumentsLine>
        <cbc:LineID>'.$con.'</cbc:LineID>
        <cbc:DocumentTypeCode>'.$tipocomp[$i].'</cbc:DocumentTypeCode>
        <sac:DocumentSerialID>'.$serie[$i].'</sac:DocumentSerialID>
        <sac:DocumentNumberID>'.$numeroc2[$i].'</sac:DocumentNumberID>
        <sac:VoidReasonDescription><![CDATA['.$comen[$i].']]></sac:VoidReasonDescription>
    </sac:VoidedDocumentsLine>';
          $con++;
       }
   }
$resumenbajaXML.='
</VoidedDocuments>';

  // Nos aseguramos de que la cadena que contiene el XML esté en UTF-8
  $resumenbajaXML = mb_convert_encoding($resumenbajaXML, "UTF-8");
  // Grabamos el XML en el servidor como un fichero plano, para
  // poder ser leido por otra aplicación.
  $gestor = fopen($rutafirma.$ruc."-RA-".$fbaja2."-".$numero.".xml", 'w');
  fwrite($gestor, $resumenbajaXML);
  fclose($gestor);
  $cabextxml=$rutafirma.$ruc."-RA-".$fbaja2."-".$numero.".xml";
  $cabxml=$ruc."-RA-".$fbaja2."-".$numero.".xml";
  $nomxml=$ruc."-RA-".$fbaja2."-".$numero;
  $nomxml2="-RA-".$fbaja2."-".$numero;
  $nomxmlruta=$rutafirma.$ruc."-RA-".$fbaja2."-".$numero;
              require_once ("../greemter/Greenter.php");
              $invo = new Greenter();
              $out=$invo->getDatFac($cabextxml);
              $filenaz = $nomxml.".zip";
              $zip = new ZipArchive();

              if($zip->open($filenaz,ZIPARCHIVE::CREATE)===true) {
                $zip->addFile($cabextxml,$cabxml);
                $zip->close();
                $imagen = file_get_contents($filenaz);
                $imageData = base64_encode($imagen);
                rename($cabextxml, $rutafirma.$cabxml);
                rename($filenaz, $rutaenvio.$filenaz);
              }
              else
              {
                $out="Error al comprimir archivo";
              }
        $rpta = array ('cabextxml'=>$cabextxml,'cabxml'=>$cabxml, 'rutafirma'=>$cabextxml, 'nombrea'=>$nomxml);
        $sqlresu="update  tempnumeracionxml set nombrebaja='$nomxml' where fecha='$fechaba2' and numero='$numero'";
        ejecutarConsulta($sqlresu);

         return $rpta;
    }





public function validarticket($nroticket, $idempresa)
  {

    require_once "../modelos/Factura.php";
    $factura = new Factura();
    $datos = $factura->correo();
    $correo = $datos->fetch_object();


    require_once "../modelos/Consultas.php";  
    $consultas = new consultas();
    $paramcerti = $consultas->paramscerti();
    $datosc = $paramcerti->fetch_object();

     //Inclusion de la tabla RUTAS
    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($idempresa);
    $Prutas = $Rrutas->fetch_object();
    $rutafirma=$Prutas->rutafirma; // ruta de la carpeta FIRMA
    $rutaenvio=$Prutas->rutaenvio; // ruta de la carpeta FIRMA
    $rutarpta=$Prutas->rutarpta; // ruta de la carpeta FIRMA
    $rutaunzip=$Prutas->unziprpta; // ruta de la carpeta rpta xml

          $webservice=$datosc->rutaserviciosunat;
          $usuarioSol=$datosc->usuarioSol;
          $claveSol=$datosc->claveSol;
          $nruc=$datosc->numeroruc;

     $connect = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
      mysqli_query( $connect, 'SET NAMES "'.DB_ENCODE.'"');
      //Si tenemos un posible error en la conexión lo mostramos
      if (mysqli_connect_errno())
      {
            printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
            exit();
      }

        $sqlbaja="select nombrebaja from tempnumeracionxml  where 
        numticket='$nroticket'";

        $result = mysqli_query($connect, $sqlbaja); 
        while($row=mysqli_fetch_assoc($result)){
          $nombrecombaja=$row['nombrebaja'].".zip";
          $nombrecombaja2=$row['nombrebaja'];

  //Llamada al WebService=======================================================================
    $service = $webservice;
    $headers = new CustomHeaders($nruc.$usuarioSol, $claveSol); 
    $client = new SoapClient($service, [ 
    'cache_wsdl' => WSDL_CACHE_NONE, 
    'trace' => TRUE , 
    'soap_version' => SOAP_1_1 ] 
  );
  try{
   $client->__setSoapHeaders([$headers]); 
   $fcs = $client->__getFunctions();

    //Llamada al WebService=======================================================================
   $status = $client->getStatus(array("ticket"=>$nroticket)); // Comando para enviar xml a SUNAT
    $conte  =  $client->__getLastResponse();
    $texto=trim(strip_tags($conte));

   $zip = new ZipArchive();
   if($zip->open("R".$nombrecombaja,ZIPARCHIVE::CREATE)===true) {
   $zip->addEmptyDir("dummy");
   $zip->close();}


     $rpt = fopen("R".$nombrecombaja, 'w') or die("no se pudo crear archivo");
     fwrite($rpt, base64_decode($texto));
     fclose($rpt);
     rename("R".$nombrecombaja, $rutarpta."R".$nombrecombaja);
     unlink("R".$nombrecombaja);

  $rutarptazip= $rutarpta."R".$nombrecombaja;
  $zip = new ZipArchive;
  if ($zip->open($rutarptazip) === TRUE) 
  {
    $zip->extractTo($rutaunzip);
    $zip->close();
  }
   $xmlFinal=$rutaunzip.'R-'.$nombrecombaja2.'.xml';
   $data[0] = "";
   $rpta[0]="";
      $sxe = new SimpleXMLElement($xmlFinal, null, true);
      $urn = $sxe->getNamespaces(true);
      $sxe->registerXPathNamespace('cac', $urn['cbc']);
      $data = $sxe->xpath('//cbc:Description');
      $rpta = $sxe->xpath('//cbc:ResponseCode');
      $nomarchi = $sxe->xpath('//cbc:ReferenceID');
      return $data[0]." ".$nomarchi[0];


         }catch (SoapFault $exception){
         $exception=print_r($client->__getLastResponse());
         }
    }

  }




  public function validarticketboleta($nroticket, $idempresa)
  {

    require_once "../modelos/Factura.php";
    $factura = new Factura();
    $datos = $factura->correo();
    $correo = $datos->fetch_object();


    require_once "../modelos/Consultas.php";  
    $consultas = new consultas();
    $paramcerti = $consultas->paramscerti();
    $datosc = $paramcerti->fetch_object();

     //Inclusion de la tabla RUTAS
    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($idempresa);
    $Prutas = $Rrutas->fetch_object();
    $rutafirma=$Prutas->rutafirma; // ruta de la carpeta FIRMA
    $rutaenvio=$Prutas->rutaenvio; // ruta de la carpeta FIRMA
    $rutarpta=$Prutas->rutarpta; // ruta de la carpeta FIRMA
    $rutaunzip=$Prutas->unziprpta; // ruta de la carpeta rpta xml

          $webservice=$datosc->rutaserviciosunat;
          $usuarioSol=$datosc->usuarioSol;
          $claveSol=$datosc->claveSol;
          $nruc=$datosc->numeroruc;

     $connect = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
      mysqli_query( $connect, 'SET NAMES "'.DB_ENCODE.'"');
      //Si tenemos un posible error en la conexión lo mostramos
      if (mysqli_connect_errno())
      {
            printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
            exit();
      }

        $sqlbaja="select nombrebaja from tempnumeracionxml  where 
        numticket='$nroticket'";

        $result = mysqli_query($connect, $sqlbaja); 
        while($row=mysqli_fetch_assoc($result)){
          $nombrecombaja=$row['nombrebaja'].".zip";
          $nombrecombaja2=$row['nombrebaja'];

  //Llamada al WebService=======================================================================
    $service = $webservice;
    $headers = new CustomHeaders($nruc.$usuarioSol, $claveSol); 
    $client = new SoapClient($service, [ 
    'cache_wsdl' => WSDL_CACHE_NONE, 
    'trace' => TRUE , 
    'soap_version' => SOAP_1_1 ] 
  );
  try{
   $client->__setSoapHeaders([$headers]); 
   $fcs = $client->__getFunctions();

    //Llamada al WebService=======================================================================
   $status = $client->getStatus(array("ticket"=>$nroticket)); // Comando para enviar xml a SUNAT
    $conte  =  $client->__getLastResponse();
    $texto=trim(strip_tags($conte));

   $zip = new ZipArchive();
   if($zip->open("R".$nombrecombaja,ZIPARCHIVE::CREATE)===true) {
   $zip->addEmptyDir("dummy");
   $zip->close();}


     $rpt = fopen("R".$nombrecombaja, 'w') or die("no se pudo crear archivo");
     fwrite($rpt, base64_decode($texto));
     fclose($rpt);
     rename("R".$nombrecombaja, $rutarpta."R".$nombrecombaja);
     unlink("R".$nombrecombaja);

  $rutarptazip= $rutarpta."R".$nombrecombaja;
  $zip = new ZipArchive;
  if ($zip->open($rutarptazip) === TRUE) 
  {
    $zip->extractTo($rutaunzip);
    $zip->close();
  }
   $xmlFinal=$rutaunzip.'R-'.$nombrecombaja2.'.xml';
   $data[0] = "";
   $rpta[0]="";
      $sxe = new SimpleXMLElement($xmlFinal, null, true);
      $urn = $sxe->getNamespaces(true);
      $sxe->registerXPathNamespace('cac', $urn['cbc']);
      $data = $sxe->xpath('//cbc:Description');
      $rpta = $sxe->xpath('//cbc:ResponseCode');
      $nomarchi = $sxe->xpath('//cbc:ReferenceID');
      return $data[0]." ".$nomarchi[0];


         }catch (SoapFault $exception){
         $exception=print_r($client->__getLastResponse());
         }
    }

  }




    public function regbajasxmlnc($ano, $mes, $dia, $idempresa)
{
      $connect = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
      mysqli_query( $connect, 'SET NAMES "'.DB_ENCODE.'"');
      //Si tenemos un posible error en la conexión lo mostramos
      if (mysqli_connect_errno())
      {
            printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
            exit();
      }
    require_once "../modelos/Factura.php";
    $factura = new Factura();
    $datos = $factura->datosemp($idempresa);
    $datose = $datos->fetch_object();
    //Inclusion de la tabla RUTAS
    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($idempresa);
    $Prutas = $Rrutas->fetch_object();

    $rutadata=$Prutas->rutadata; // ruta de la carpeta DATA
    $rutafirma=$Prutas->rutafirma; // ruta de la carpeta FIRMA
    $rutadatalt=$Prutas->rutadatalt; // ruta de la carpeta DATAALTERNA
    $rutaenvio=$Prutas->rutaenvio; // ruta de la carpeta DATAALTERNA

$query = "select 
date_format(fecha, '%Y%m%d') as fechabaja2, 
date_format(fecha, '%Y-%m-%d') as fechabaja,
idnota

  from 
  (
  select
fecha,
idnota

from notacd nc 
inner join  factura f on nc.idcomprobante=f.idfactura
inner join  persona p on f.idcliente=p.idpersona 
where year(nc.fecha_baja)='$ano' and month(nc.fecha_baja)='$mes' and day(nc.fecha_baja)='$dia' and nc.estado='3'
) as tabla";

$result = mysqli_query($connect, $query);

      $rzonsocial=$datose->nombre_razon_social;
      $domiciliofiscal=$datose->domicilio_fiscal;
      $ruc=$datose->numero_ruc;

      $fecha=array();
      $rowbaja=mysqli_fetch_assoc($result);
           $fechaba=$rowbaja["fechabaja2"];
           $fechaba2=$rowbaja["fechabaja"];
           $idnota=$rowbaja["idnota"];
           $tipodoc="07";

$sqlnumerp="select numero from tempnumeracionxml where fecha='$fechaba' and comprobante='$tipodoc'";

$result2 = mysqli_query($connect, $sqlnumerp);

$numero='';
while($rowba=mysqli_fetch_assoc($result2)){
       $numero=$rowba["numero"] + 1;
       }
if ($numero==""){$numero='1';}

        $sqlnumer="insert into tempnumeracionxml (fecha, numero, comprobante) values ('$fechaba', '$numero', '07' )";
        //$idnumer=ejecutarConsulta($sqlnumer);
        $idnumer=ejecutarConsulta_retornarID($sqlnumer);


//PARA LLENAR DETALLE DE COMPROBANTES    
    $result2 = mysqli_query($connect, $query);
    $idfacturad=array();
    $tipodocd="";
    while($rowdetalle=mysqli_fetch_assoc($result2)){
        for($i=0; $i < count($result); $i++){
            $idnota[$i]=$rowdetalle["idnota"];
            $tipodocd="07";

        $sqldetalle="insert into detalle_tablaxml_comprobante (idtablaxml, idcomprobante, tipocomprobante, estado)
         values ('$idnumer', '$idnota[$i]', '$tipodocd', '1' )";
        $dettxmlcom=ejecutarConsulta($sqldetalle);
    }
    $i=$i + 1;
    }
//PARA LLENAR DETALLE DE COMPROBANTES

$resumenbajaXML ='<?xml version="1.0" encoding="utf-8"?>
            <VoidedDocuments xmlns="urn:sunat:names:specification:ubl:peru:schema:xsd:VoidedDocuments-1"
                 xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2"
                 xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"
                 xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2"
                 xmlns:sac="urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1"
                 xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
    <ext:UBLExtensions>
        <ext:UBLExtension>
            <ext:ExtensionContent/>
        </ext:UBLExtension>
    </ext:UBLExtensions>
    
    <cbc:UBLVersionID>2.0</cbc:UBLVersionID>
    <cbc:CustomizationID>1.0</cbc:CustomizationID>

    <cbc:ID>RA-'.$fechaba.'-'.$numero.'</cbc:ID>
    <cbc:ReferenceDate>'.$fechaba2.'</cbc:ReferenceDate>
    <cbc:IssueDate>'.$fechaba2.'</cbc:IssueDate>
    
    <cac:Signature>
        <cbc:ID>'.$ruc.'</cbc:ID>
        <cbc:Note>BYTECNOLOGOS</cbc:Note>
        <cac:SignatoryParty>
            <cac:PartyIdentification>
                <cbc:ID>'.$ruc.'</cbc:ID>
            </cac:PartyIdentification>
            <cac:PartyName>
                <cbc:Name><![CDATA['.$rzonsocial.']]></cbc:Name>
            </cac:PartyName>
        </cac:SignatoryParty>
        <cac:DigitalSignatureAttachment>
            <cac:ExternalReference>
                <cbc:URI>#SIGN-TECNOLOGOS</cbc:URI>
            </cac:ExternalReference>
        </cac:DigitalSignatureAttachment>
    </cac:Signature>
    
    <cac:AccountingSupplierParty>
        <cbc:CustomerAssignedAccountID>'.$ruc.'</cbc:CustomerAssignedAccountID>
        <cbc:AdditionalAccountID>6</cbc:AdditionalAccountID>
        <cac:Party>
            <cac:PartyLegalEntity>
                <cbc:RegistrationName><![CDATA['.$rzonsocial.']]></cbc:RegistrationName>
            </cac:PartyLegalEntity>
        </cac:Party>
    </cac:AccountingSupplierParty>';


$query2 = "select 
date_format(fechahoy, '%Y%m%d') as fechaactual, 
date_format(fecha, '%Y-%m-%d') as fecha, 
date_format(fecha, '%Y%m%d') as fechabaja2, 
date_format(fecha, '%Y-%m-%d') as fechabaja, 
right(substring_index(serie,'-',1),3) as serie,
right(substring_index(serie,'-',1),4) as serie2,
right(substring_index(numerodoc,'-',-1),10) as numerodoc2,
tipodocuCliente, 
rucCliente, 
RazonSocial, 
tmoneda, 
subtotal, 
igv, 
total, 

numerodoc, 
est, 
comentario_baja  
  from 
  (select
curdate() as fechahoy, 
fecha, 
numeroserienota as serie,
tipodocuCliente, 
rucCliente, 
RazonSocial, 
tipo_moneda as tmoneda, 
total_val_venta_og as subtotal, 
sum_igv as igv, 
importe_total as total, 

numeroserienota as numerodoc, 
nc.estado as est, 
nc.comentario_baja 
from 
notacd nc inner join factura f on nc.idcomprobante=f.idfactura
inner join persona p on f.idcliente=p.idpersona 
where year(nc.fecha_baja)='$ano' and month(nc.fecha_baja)='$mes' and day(nc.fecha_baja)='$dia' and nc.estado='3'
) as tabla";
$result2 = mysqli_query($connect, $query2);
  
      //Parametros de salida
      $fecha=array();
      $tipocomp="";
      $numdocu=array();
      $rasoc=array();
      $fechabaja=array();
      $numeroc=array();
      $comen=array();
      $serie=array();
      $numeroc2=array();
      $fbaja2='';
      $fechaactual='';

      $con=1; //Contador de variable

      while($row=mysqli_fetch_assoc($result2)){
      for($i=0; $i < count($result2); $i++){
           $fecha[$i]=$row["fecha"];
           $fechabaja[$i]=$row["fechabaja"];
           $tipocomp="07";
           $numeroc[$i]=$row["numerodoc"];
           $comen[$i]=$row["comentario_baja"];
           $fbaja2=$row["fechabaja2"];
           $serie[$i]=$row["serie2"];
           $numeroc2[$i]=$row["numerodoc2"];
           $fechaactual=$row["fechaactual"];

   $resumenbajaXML.='
   <sac:VoidedDocumentsLine>
        <cbc:LineID>'.$con.'</cbc:LineID>
        <cbc:DocumentTypeCode>'.$tipocomp.'</cbc:DocumentTypeCode>
        <sac:DocumentSerialID>'.$serie[$i].'</sac:DocumentSerialID>
        <sac:DocumentNumberID>'.$numeroc2[$i].'</sac:DocumentNumberID>
        <sac:VoidReasonDescription><![CDATA['.$comen[$i].']]></sac:VoidReasonDescription>
    </sac:VoidedDocumentsLine>';
          $con++;
       }
   }
$resumenbajaXML.='
</VoidedDocuments>';

  // Nos aseguramos de que la cadena que contiene el XML esté en UTF-8
  $resumenbajaXML = mb_convert_encoding($resumenbajaXML, "UTF-8");
  // Grabamos el XML en el servidor como un fichero plano, para
  // poder ser leido por otra aplicación.
  $gestor = fopen($rutafirma.$ruc."-RA-".$fbaja2."-".$numero.".xml", 'w');
  fwrite($gestor, $resumenbajaXML);
  fclose($gestor);
  $cabextxml=$rutafirma.$ruc."-RA-".$fbaja2."-".$numero.".xml";
  $cabxml=$ruc."-RA-".$fbaja2."-".$numero.".xml";
  $nomxml=$ruc."-RA-".$fbaja2."-".$numero;
  $nomxml2="-RA-".$fbaja2."-".$numero;
  $nomxmlruta=$rutafirma.$ruc."-RA-".$fbaja2."-".$numero;
              require_once ("../greemter/Greenter.php");
              $invo = new Greenter();
              $out=$invo->getDatFac($cabextxml);
              $filenaz = $nomxml.".zip";
              $zip = new ZipArchive();

              if($zip->open($filenaz,ZIPARCHIVE::CREATE)===true) {
                $zip->addFile($cabextxml,$cabxml);
                $zip->close();
                $imagen = file_get_contents($filenaz);
                $imageData = base64_encode($imagen);
                rename($cabextxml, $rutafirma.$cabxml);
                rename($filenaz, $rutaenvio.$filenaz);
              }
              else
              {
                $out="Error al comprimir archivo";
              }
        $rpta = array ('cabextxml'=>$cabextxml,'cabxml'=>$cabxml, 'rutafirma'=>$cabextxml, 'nombrea'=>$nomxml);
        $sqlresu="update  tempnumeracionxml set nombrebaja='$nomxml' where fecha='$fechaba2' and numero='$numero'";
        ejecutarConsulta($sqlresu);

         return $rpta;
    }

public function enviarxmlbajafactura($nombrexml, $idempresa)
  {
    require_once "../modelos/Factura.php";
    $factura = new Factura();

    require_once "../modelos/Consultas.php";  
    $consultas = new consultas();
    $paramcerti = $consultas->paramscerti();
    $datosc = $paramcerti->fetch_object();

     //Inclusion de la tabla RUTAS
    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($idempresa);
    $Prutas = $Rrutas->fetch_object();
    $rutafirma=$Prutas->rutafirma; // ruta de la carpeta FIRMA
    $rutaenvio=$Prutas->rutaenvio; // ruta de la carpeta ENVIO
    $rutarpta=$Prutas->rutarpta; // ruta de la carpeta RESPUESTA
    $rutaunzip=$Prutas->unziprpta; // ruta de la carpeta rpta xml

    $nruc=$datosc->numeroruc;

    $ZipFactura=$rutaenvio.$nombrexml.'.zip';
    copy($ZipFactura, $nombrexml.'.zip');
    $ZipFinal=$nombrexml.'.zip';
    
     $webservice=$datosc->rutaserviciosunat;
     $usuarioSol=$datosc->usuarioSol;
     $claveSol=$datosc->claveSol;
    

//   //Llamada al WebService=======================================================================
   $service = $webservice; 
   $headers = new CustomHeaders($nruc.$usuarioSol, $claveSol); 
   $client = new SoapClient(
   $webservice, ['cache_wsdl' => WSDL_CACHE_NONE, 'trace' => TRUE , 'soap_version' => SOAP_1_1 ] ); 
  
   try{
   $client->__setSoapHeaders([$headers]); 
   $fcs = $client->__getFunctions();
   $params = array('fileName' => $ZipFinal, 'contentFile' => file_get_contents($ZipFinal) ); 

    //Llamada al WebService=======================================================================
   $status = $client->sendSummary($params); // Comando para enviar xml a SUNAT
   $conte  =  $client->__getLastResponse();
   $nroticket=trim(strip_tags($conte));
   unlink($ZipFinal);

   // // Llamada al WebService=======================================================================
   }catch (SoapFault $exception){
   $exception=print_r($client->__getLastResponse());
   }
        $rpta = array ('nroticket'=>$nroticket);

        $sqlresu="update tempnumeracionxml set numticket='$nroticket' where nombrebaja='$nombrexml'";
        ejecutarConsulta($sqlresu);

   //return $data[0];
    return $rpta;

  }






public function enviarxmlbajanotacredito($nombrexml, $idempresa)
  {
    require_once "../modelos/Factura.php";
    $factura = new Factura();

    require_once "../modelos/Consultas.php";  
    $consultas = new consultas();
    $paramcerti = $consultas->paramscerti();
    $datosc = $paramcerti->fetch_object();

     //Inclusion de la tabla RUTAS
    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($idempresa);
    $Prutas = $Rrutas->fetch_object();
    $rutafirma=$Prutas->rutafirma; // ruta de la carpeta FIRMA
    $rutaenvio=$Prutas->rutaenvio; // ruta de la carpeta ENVIO
    $rutarpta=$Prutas->rutarpta; // ruta de la carpeta RESPUESTA
    $rutaunzip=$Prutas->unziprpta; // ruta de la carpeta rpta xml

    $nruc=$datosc->numeroruc;

    $ZipFactura=$rutaenvio.$nombrexml.'.zip';
    copy($ZipFactura, $nombrexml.'.zip');
    $ZipFinal=$nombrexml.'.zip';
    
     $webservice=$datosc->rutaserviciosunat;
     $usuarioSol=$datosc->usuarioSol;
     $claveSol=$datosc->claveSol;
    

//   //Llamada al WebService=======================================================================
   $service = $webservice; 
   $headers = new CustomHeaders($nruc.$usuarioSol, $claveSol); 
   $client = new SoapClient(
   $webservice, ['cache_wsdl' => WSDL_CACHE_NONE, 'trace' => TRUE , 'soap_version' => SOAP_1_1 ] ); 
  
   try{
   $client->__setSoapHeaders([$headers]); 
   $fcs = $client->__getFunctions();
   $params = array('fileName' => $ZipFinal, 'contentFile' => file_get_contents($ZipFinal) ); 

    //Llamada al WebService=======================================================================
   $status = $client->sendSummary($params); // Comando para enviar xml a SUNAT
   $conte  =  $client->__getLastResponse();
   $nroticket=trim(strip_tags($conte));
   unlink($ZipFinal);

   // // Llamada al WebService=======================================================================
   }catch (SoapFault $exception){
   $exception=print_r($client->__getLastResponse());
   }
        $rpta = array ('nroticket'=>$nroticket);

        $sqlresu="update tempnumeracionxml set numticket='$nroticket' where nombrebaja='$nombrexml'";
        ejecutarConsulta($sqlresu);

   //return $data[0];
    return $rpta;

  }



  public function regbajasxmlBoleta($ano, $mes, $dia, $st, $idempresa)
    {


      $connect = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
      mysqli_query( $connect, 'SET NAMES "'.DB_ENCODE.'"');
      //Si tenemos un posible error en la conexión lo mostramos
      if (mysqli_connect_errno())
      {
            printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
            exit();
      }

    require_once "../modelos/Factura.php";
    $factura = new Factura();
    $datos = $factura->datosemp($idempresa);
    $datose = $datos->fetch_object();

    //Inclusion de la tabla RUTAS
    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();

    $Rrutas = $rutas->mostrar2($idempresa);
    $Prutas = $Rrutas->fetch_object();

    $rutadata=$Prutas->rutadata; // ruta de la carpeta DATA
    $rutafirma=$Prutas->rutafirma; // ruta de la carpeta FIRMA
    $rutadatalt=$Prutas->rutadatalt; // ruta de la carpeta DATAALTERNA
    $rutaenvio=$Prutas->rutaenvio; // ruta de la carpeta DATAALTERNA

$query = "select 
date_format(fecha, '%Y%m%d') as fechabaja2, 
date_format(fecha, '%Y-%m-%d') as fechabaja,
idboleta,
tipodoc
  from 
  (
  select
fecha_emision_01 as fecha,
idboleta,
tipo_documento_06 as tipodoc
from boleta b inner join persona p on b.idcliente=p.idpersona 
where year(fecha_emision_01)='$ano' and month(fecha_emision_01)='$mes' 
and day(fecha_emision_01)='$dia' and b.estado='$st'
) as tabla";
$result = mysqli_query($connect, $query);

      $rzonsocial=$datose->nombre_razon_social;
      $domiciliofiscal=$datose->domicilio_fiscal;
      $ruc=$datose->numero_ruc;

      //Parametros de salida
      $fecha=array();
      $rowbaja=mysqli_fetch_assoc($result);
           $fechaba=$rowbaja["fechabaja2"];
           $fechaba2=$rowbaja["fechabaja"];
           $idboleta=$rowbaja["idboleta"];
           $tipodoc=$rowbaja["tipodoc"];

$sqlnumerp="select numero from tempnumeracionxml where fecha='$fechaba' and comprobante='$tipodoc'";
$result2 = mysqli_query($connect, $sqlnumerp);

$numero='';
while($rowba=mysqli_fetch_assoc($result2)){
       $numero=$rowba["numero"] + 1;
       }

if ($numero=="") { $numero='1';}
$sqlnumer="insert into tempnumeracionxml (fecha, numero, comprobante) values ('$fechaba', '$numero', '03' )";
$idnumer=ejecutarConsulta_retornarID($sqlnumer);

//PARA LLENAR DETALLE DE COMPROBANTES    
    $result2 = mysqli_query($connect, $query);
    $idboletad=array();
    $tipodocd=array();
    while($rowdetalle=mysqli_fetch_assoc($result2)){
        for($i=0; $i < count($result); $i++){
            $idboletad[$i]=$rowdetalle["idboleta"];
            $tipodocd[$i]=$rowdetalle["tipodoc"];

        $sqldetalle="insert into detalle_tablaxml_comprobante (idtablaxml, idcomprobante, tipocomprobante, estado)
         values ('$idnumer', '$idboletad[$i]', '$tipodocd[$i]', '1' )";
        $dettxmlcom=ejecutarConsulta($sqldetalle);
    }
    $i=$i + 1;
    }
//PARA LLENAR DETALLE DE COMPROBANTES
                                               
$resumenbajaXML ='<?xml version="1.0" encoding="utf-8"?>
<SummaryDocuments
        xmlns="urn:sunat:names:specification:ubl:peru:schema:xsd:SummaryDocuments-1"
        xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2"
        xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"
        xmlns:ds="http://www.w3.org/2000/09/xmldsig#"
        xmlns:ext="urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2"
        xmlns:sac="urn:sunat:names:specification:ubl:peru:schema:xsd:SunatAggregateComponents-1"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"> 
    <ext:UBLExtensions>
        <ext:UBLExtension>
            <ext:ExtensionContent/>
        </ext:UBLExtension>
    </ext:UBLExtensions>
    
    <cbc:UBLVersionID>2.0</cbc:UBLVersionID>
    <cbc:CustomizationID>1.1</cbc:CustomizationID>

    <cbc:ID>RC-'.$fechaba.'-'.$numero.'</cbc:ID>
    <cbc:ReferenceDate>'.$fechaba2.'</cbc:ReferenceDate>
    <cbc:IssueDate>'.$fechaba2.'</cbc:IssueDate>
    
    <cac:Signature>
        <cbc:ID>'.$ruc.'</cbc:ID>
        <cbc:Note>ESTRELLA </cbc:Note>
        <cac:SignatoryParty>
            <cac:PartyIdentification>
                <cbc:ID>'.$ruc.'</cbc:ID>
            </cac:PartyIdentification>
            <cac:PartyName>
                <cbc:Name><![CDATA['.$rzonsocial.']]></cbc:Name>
            </cac:PartyName>
        </cac:SignatoryParty>
        <cac:DigitalSignatureAttachment>
            <cac:ExternalReference>
                <cbc:URI>#SIGN-ESTRELLA</cbc:URI>
            </cac:ExternalReference>
        </cac:DigitalSignatureAttachment>
    </cac:Signature>
    
    <cac:AccountingSupplierParty>
        <cbc:CustomerAssignedAccountID>'.$ruc.'</cbc:CustomerAssignedAccountID>
        <cbc:AdditionalAccountID>6</cbc:AdditionalAccountID>
        <cac:Party>
            <cac:PartyLegalEntity>
                <cbc:RegistrationName><![CDATA['.$rzonsocial.']]></cbc:RegistrationName>
            </cac:PartyLegalEntity>
        </cac:Party>
    </cac:AccountingSupplierParty>';


    $query2 = "select 
date_format(fechahoy, '%Y%m%d') as fechaactual, 
date_format(fecha, '%Y-%m-%d') as fecha, 
date_format(fecha, '%Y%m%d') as fechabaja2, 
date_format(fecha, '%Y-%m-%d') as fechabaja, 
numerodoc as numerodoc2,
tipodocuCliente, 
rucCliente, 
RazonSocial, 
tmoneda, 
subtotal, 
igv, 
total, 
tipocomp, 
numerodoc, 
est, 
comentario_baja  
  from 
  (
select
curdate() as fechahoy, 
fecha_emision_01 as fecha, 
tipodocuCliente, 
rucCliente, 
RazonSocial, 
tipo_moneda_24 as tmoneda, 
monto_15_2 as subtotal, 
sumatoria_igv_18_1 as igv, 
importe_total_23 as total, 
tipo_documento_06 as tipocomp, 
numeracion_07 as numerodoc, 
b.estado as est, 
comentario_baja 
from 
boleta b inner join persona p on b.idcliente=p.idpersona 
where year(fecha_emision_01)='$ano' and month(fecha_emision_01)='$mes' 
and day(fecha_emision_01)='$dia' and b.estado='$st'
) as tabla";
$result2 = mysqli_query($connect, $query2);
  
      //Parametros de salida
      $fecha=array();      $tipocomp=array();      $numdocu=array();      $rasoc=array();      $fechabaja=array(); $doccliente=array();      $comen=array();      $numeroc2=array();     $fbaja2='';      $tipodcliente=array();
      $estadodoc=array();      $itotal=array();      $tmoneda=array();      $subtotal=array();      $igv=array();

      $con=1; //Contador de variable

      while($row=mysqli_fetch_assoc($result2)){
      for($i=0; $i < count($result2); $i++){
           $fecha[$i]=$row["fecha"];
           $fechabaja[$i]=$row["fechabaja"];
           $tipocomp[$i]=$row["tipocomp"];
           $doccliente[$i]=$row["rucCliente"];
           $comen[$i]=$row["comentario_baja"];
           $fbaja2=$row["fechabaja2"];
           $fechaactual=$row["fechaactual"];
           $numeroc2[$i]=$row["numerodoc2"];
           $fechaactual=$row["fechaactual"];
           $tipodcliente[$i]=$row["tipodocuCliente"];
           $estadodoc[$i]=$row["est"];
           $itotal[$i]=$row["total"];
           $tmoneda[$i]=$row["tmoneda"];
           $subtotal[$i]=$row["subtotal"];
           $igv[$i]=$row["igv"];

   $resumenbajaXML.='
   <sac:SummaryDocumentsLine>

   <cbc:LineID>'.$con.'</cbc:LineID>
    <cbc:DocumentTypeCode>'.$tipocomp[$i].'</cbc:DocumentTypeCode>
    <cbc:ID>'.$numeroc2[$i].'</cbc:ID>
    <cac:AccountingCustomerParty>
      <cbc:CustomerAssignedAccountID>'.$doccliente[$i].'</cbc:CustomerAssignedAccountID>
      <cbc:AdditionalAccountID>'.$tipodcliente[$i].'</cbc:AdditionalAccountID>
    </cac:AccountingCustomerParty>
    <!--  Documento que modifica -->
  
    <!--  Datos de Percepcion - PER -->
  <!-- PER -->
  
    <cac:Status>
      <cbc:ConditionCode>'.$estadodoc[$i].'</cbc:ConditionCode>
    </cac:Status>
    <!--Total Importe Total-->
    <sac:TotalAmount currencyID="'.$tmoneda[$i].'">'.$itotal[$i].'</sac:TotalAmount>
  
    <!--Total Venta Operaciones Gravadas - 01 -->
    <sac:BillingPayment>
      <cbc:PaidAmount currencyID="'.$tmoneda[$i].'">'.$subtotal[$i].'</cbc:PaidAmount>
      <cbc:InstructionID>01</cbc:InstructionID>
    </sac:BillingPayment>
  <!-- fin 01 -->
  
    <!--Total Venta Operaciones Exoneradas - 02 -->
  <!-- fin 02 -->
    
    <!--Total Venta Operaciones Inafectas - 03 -->
  <!-- fin 03 -->
  
    <!--Total Venta Operaciones Gratuitas - 05 -->
  <!-- fin 05 -->
  
    <!--Total SUMATORIO OTROS CARGOS - Cargos-->
  <!-- fin Cargos -->
  
    <!-- TOTAL ISC-->
    <cac:TaxTotal>
      <cbc:TaxAmount currencyID="'.$tmoneda[$i].'">0</cbc:TaxAmount>
      <cac:TaxSubtotal>
        <cbc:TaxAmount currencyID="'.$tmoneda[$i].'">0</cbc:TaxAmount>
        <cac:TaxCategory>
          <cac:TaxScheme>
            <cbc:ID>2000</cbc:ID>
            <cbc:Name>ISC</cbc:Name>
            <cbc:TaxTypeCode>EXC</cbc:TaxTypeCode>
          </cac:TaxScheme>
        </cac:TaxCategory>
      </cac:TaxSubtotal>
    </cac:TaxTotal>
    <!-- TOTAL IGV-->
    <cac:TaxTotal>
      <cbc:TaxAmount currencyID="'.$tmoneda[$i].'">'.$igv[$i].'</cbc:TaxAmount>
      <cac:TaxSubtotal>
        <cbc:TaxAmount currencyID="'.$tmoneda[$i].'">'.$igv[$i].'</cbc:TaxAmount>
        <cac:TaxCategory>
          <cac:TaxScheme>
            <cbc:ID>1000</cbc:ID>
            <cbc:Name>IGV</cbc:Name>
            <cbc:TaxTypeCode>VAT</cbc:TaxTypeCode>
          </cac:TaxScheme>
        </cac:TaxCategory>
      </cac:TaxSubtotal>
    </cac:TaxTotal>
    <!--Total OTROS TRIBUTOS-->
    <cac:TaxTotal>
      <cbc:TaxAmount currencyID="'.$tmoneda[$i].'">0</cbc:TaxAmount>
      <cac:TaxSubtotal>
        <cbc:TaxAmount currencyID="'.$tmoneda[$i].'">0</cbc:TaxAmount>
        <cac:TaxCategory>
          <cac:TaxScheme>
            <cbc:ID>9999</cbc:ID>
            <cbc:Name>OTROS</cbc:Name>
            <cbc:TaxTypeCode>OTH</cbc:TaxTypeCode>
          </cac:TaxScheme>
        </cac:TaxCategory>
      </cac:TaxSubtotal>
    </cac:TaxTotal>
  </sac:SummaryDocumentsLine>';
          $con++;

       }
   }

$resumenbajaXML.='
</SummaryDocuments>';
  // Nos aseguramos de que la cadena que contiene el XML esté en UTF-8
  $resumenbajaXML = mb_convert_encoding($resumenbajaXML, "UTF-8");
  // Grabamos el XML en el servidor como un fichero plano, para
  // poder ser leido por otra aplicación.
  $gestor = fopen($rutafirma.$ruc."-RC-".$fbaja2."-".$numero.".xml", 'w');
  fwrite($gestor, $resumenbajaXML);
  fclose($gestor);


  $cabextxml=$rutafirma.$ruc."-RC-".$fbaja2."-".$numero.".xml";
  $cabxml=$ruc."-RC-".$fbaja2."-".$numero.".xml";
  $nomxml=$ruc."-RC-".$fbaja2."-".$numero;
  $nomxml2="-RC-".$fbaja2."-".$numero;
  $nomxmlruta=$rutafirma.$ruc."-RC-".$fbaja2."-".$numero;


              require_once ("../greemter/Greenter.php");
              $invo = new Greenter();
              $out=$invo->getDatFac($cabextxml);
              $filenaz = $nomxml.".zip";
              $zip = new ZipArchive();

              if($zip->open($filenaz,ZIPARCHIVE::CREATE)===true) {
                $zip->addFile($cabextxml,$cabxml);
                $zip->close();
                $imagen = file_get_contents($filenaz);
                $imageData = base64_encode($imagen);
                rename($cabextxml, $rutafirma.$cabxml);
                rename($filenaz, $rutaenvio.$filenaz);
              }
              else
              {
                $out="Error al comprimir archivo";
              }

              $rpta = array ('cabextxml'=>$cabextxml,'cabxml'=>$cabxml, 'rutafirma'=>$cabextxml, 'nombrea'=>$nomxml);
              //$rpta = array ('cabextxml'=>"cabextxml");

        $sqlresu="update  tempnumeracionxml set nombrebaja='$nomxml' where fecha='$fechaba2' and numero='$numero'";
        ejecutarConsulta($sqlresu);


        $sqlupdEstado="update boleta set estado='5' where idboleta='$fechaba2' and numero='$numero'";
        ejecutarConsulta($sqlresu);


         return $rpta;
    }












     public function enviarxmlbajaBoleta($nombrexml,$idempresa)
  {
    require_once "../modelos/Factura.php";
    $factura = new Factura();

    require_once "../modelos/Consultas.php";  
    $consultas = new consultas();
    $paramcerti = $consultas->paramscerti();
    $datosc = $paramcerti->fetch_object();

     //Inclusion de la tabla RUTAS
    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($idempresa);
    $Prutas = $Rrutas->fetch_object();
    $rutaenvio=$Prutas->rutaenvio; // ruta de la carpeta ENVIO
    $nruc=$datosc->numeroruc;

    $ZipBoleta=$rutaenvio.$nombrexml.'.zip';
    copy($ZipBoleta, $nombrexml.'.zip');
    $ZipFinal=$nombrexml.'.zip';
    
     $webservice=$datosc->rutaserviciosunat;
     $usuarioSol=$datosc->usuarioSol;
     $claveSol=$datosc->claveSol;
    

//   //Llamada al WebService=======================================================================
   $service = $webservice; 
   $headers = new CustomHeaders($nruc.$usuarioSol, $claveSol); 
   $client = new SoapClient(
   $webservice, ['cache_wsdl' => WSDL_CACHE_NONE, 'trace' => TRUE , 'soap_version' => SOAP_1_1 ] ); 
  
   try{
   $client->__setSoapHeaders([$headers]); 
   $fcs = $client->__getFunctions();
   $params = array('fileName' => $ZipFinal, 'contentFile' => file_get_contents($ZipFinal) ); 

    //Llamada al WebService=======================================================================
   $status = $client->sendSummary($params); // Comando para enviar xml a SUNAT
   $conte  =  $client->__getLastResponse();
   $nroticket=trim(strip_tags($conte));
   unlink($ZipFinal);

   // // Llamada al WebService=======================================================================
   }catch (SoapFault $exception){
   $exception=print_r($client->__getLastResponse());
   }
        $rpta = array ('nroticket'=>$nroticket);
        $sqlresu="update  tempnumeracionxml set numticket='$nroticket' where nombrebaja='$nombrexml'";
        ejecutarConsulta($sqlresu);
   //return $data[0];
    return $rpta;

  }




  public function ultimoarchivoxml($ultimoxml)
    {
       $sql="select id , fecha, numticket, nombrebaja from tempnumeracionxml where nombrebaja='$ultimoxml'";
        return ejecutarConsulta($sql);  
    }


    public function ultimoarchivoxmlnotacredito($ultimoxml)
    {
       $sql="select id , fecha, numticket, nombrebaja from tempnumeracionxml where nombrebaja='$ultimoxml'";
        return ejecutarConsulta($sql);  
    }


    public function detallecomprobantes($idxml)
    {
       $sql="select f.numeracion_08 as numerof, date_format(f.fecha_emision_01, '%d-%m-%Y') as fechaemision, f.importe_total_venta_27 as total from tempnumeracionxml t inner join detalle_tablaxml_comprobante dt on t.id=dt.idtablaxml inner join factura f on f.idfactura=dt.idcomprobante where t.id='$idxml'";
        return ejecutarConsulta($sql);  
    }



public function ultimoarchivoxmlBoleta($ultimoxml)
    {
       $sql="select id , fecha, numticket, nombrebaja from tempnumeracionxml where nombrebaja='$ultimoxml'";
        return ejecutarConsulta($sql);  
    }

    

    public function detallecomprobantesboleta($idxml)
    {
       $sql="select 
       b.numeracion_07 as numerob, 
       date_format(b.fecha_emision_01, '%d-%m-%Y') as fechaemision, 
       b.importe_total_23 as total 
       from 
       tempnumeracionxml t inner join detalle_tablaxml_comprobante dt on t.id=dt.idtablaxml inner join boleta b on b.idboleta=dt.idcomprobante where t.id='$idxml'";
        return ejecutarConsulta($sql);  
    }


    public function listarcomprobantes($fec1, $fec2, $tipocte, $Estd, $estsiste)
    {

        if ($tipocte=='00') {
          $tcFactura='01';
          $tcBoleta='03';
        }elseif($tipocte=='01'){
            $tcFactura='01';
            $tcBoleta='';
        }else{
              $tcFactura='';
              $tcBoleta='03';
        }




        $sql="select 
        idcomprobante,
        fecha,
        fechabaja,
        idcliente,
        cliente,
        vendedorsitio,
        usuario,
        tipo_documento_07,
        numeracion_08,
        importe_total_venta_27 ,
        sumatoria_igv_22_1,
        estado,
        numero_ruc,
        email,
        diast,
        DetalleSunat,
        moneda,
        valordolsol,
        tcambio,
        tarjetadc,
        transferencia,
        montotarjetadc,
        montotransferencia,
        estadosistema
        from

        (select 
        f.idfactura as idcomprobante,
        date_format(f.fecha_emision_01,'%d/%m/%y') as fecha,
        date_format(curdate(),'%Y%m%d') as fechabaja,
        f.idcliente,
        left(p.razon_social,20) as cliente,
        f.vendedorsitio,
        u.nombre as usuario,
        f.tipo_documento_07,
        f.numeracion_08,
        format(f.importe_total_venta_27,2)as importe_total_venta_27 ,
        f.sumatoria_igv_22_1,
        f.estado,
        e.numero_ruc,
        p.email,
        TIMESTAMPDIFF(DAY,f.fecha_emision_01 ,  curdate()) AS diast,
        f.DetalleSunat,
        f.tipo_moneda_28 as moneda,
        (f.tcambio * f.importe_total_venta_27) as valordolsol,
        f.tcambio,
        f.tarjetadc,
        f.transferencia,
        f.montotarjetadc,
        f.montotransferencia,
        f.estadosistema
        from  factura f inner join persona p on f.idcliente=p.idpersona 
        inner join usuario u on f.idusuario=u.idusuario 
        inner join empresa e on f.idempresa=e.idempresa where
        date_format(fecha_emision_01,'%Y-%m-%d') BETWEEN '$fec1' and '$fec2' 
        and f.tipo_documento_07='$tcFactura' and f.estado in ($Estd) and f.estadosistema in ($estsiste)
                 
        union all

        select 
        b.idboleta as idcomprobante,
        date_format(b.fecha_emision_01,'%d/%m/%y') as fecha,
        date_format(curdate(),'%Y%m%d') as fechabaja,
        b.idcliente,
        left(p.nombres,20) as cliente,
        b.vendedorsitio,
        u.nombre as usuario,
        b.tipo_documento_06,
        b.numeracion_07,
        format(b.importe_total_23,2)as importe_total_23 ,
        b.sumatoria_igv_18_1,
        b.estado,
        e.numero_ruc,
        p.email,
        TIMESTAMPDIFF(DAY,b.fecha_emision_01 ,  curdate()) AS diast,
        b.DetalleSunat,
        b.tipo_moneda_24 as moneda,
        (b.tcambio * b.importe_total_23) as valordolsol,
        b.tcambio,
        b.tarjetadc,
        b.transferencia,
        b.montotarjetadc,
        b.montotransferencia,
        b.estadosistema
        from  boleta b inner join persona p on b.idcliente=p.idpersona 
        inner join usuario u on b.idusuario=u.idusuario 
        inner join empresa e on b.idempresa=e.idempresa where
        date_format(fecha_emision_01,'%Y-%m-%d') BETWEEN '$fec1' and '$fec2' and b.tipo_documento_06='$tcBoleta' and b.estado in ($Estd) and b.estadosistema in ($estsiste)
        )
        as estados";
        return ejecutarConsulta($sql);  

    }



    public function mostrarxmlfactura($idfactura, $idempresa)
    {
      $connect = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
      mysqli_query( $connect, 'SET NAMES "'.DB_ENCODE.'"');
      //Si tenemos un posible error en la conexión lo mostramos
      if (mysqli_connect_errno())
      {
            printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
            exit();
      }

    require_once "../modelos/Factura.php";
    $factura = new Factura();
    $datos = $factura->datosemp($idempresa);
    $datose = $datos->fetch_object();

    $nombrecomercial=$datose->nombre_razon_social;

    //Inclusion de la tabla RUTAS
    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($idempresa);
    $Prutas = $Rrutas->fetch_object();
    $rutadata=$Prutas->rutadata; // ruta de la carpeta DATA
    $rutafirma=$Prutas->rutafirma; // ruta de la carpeta FIRMA
    $rutadatalt=$Prutas->rutadatalt; // ruta de la carpeta DATAALTERNA
    $rutaenvio=$Prutas->rutaenvio; // ruta de la carpeta rutaenvio
    $rutaunzipxml=$Prutas->unziprpta; // ruta de la carpeta ruta unziprpta

     $query = "select
     f.tipo_documento_07 as tipocomp, 
     f.numeracion_08 as numerodoc 
     from 
     factura f inner join persona p on f.idcliente=p.idpersona inner join empresa e on f.idempresa=e.idempresa where idfactura='$idfactura' and f.estado in('1','4','5') order by numerodoc";

     $result = mysqli_query($connect, $query);  


     if ($result) {
      while($row=mysqli_fetch_assoc($result)){
      for($i=0; $i <= count($result); $i++){
           $tipocomp=$row["tipocomp"];
           $numerodoc=$row["numerodoc"];
           $ruc=$datose->numero_ruc;
         }
       }
    $cabextxml=$rutafirma.$ruc."-".$tipocomp."-".$numerodoc.".xml";
    //$filexml=simplexml_load_file($cabextxml);
    $rpta = array ('rutafirma'=>($cabextxml));
     }else{
      $rpta = array ('rutafirma'=>'Aún no se ha creado el archivo XML.');
     }
  return $rpta;

    }




    public function mostrarxmlboleta($idboleta, $idempresa)
    {
      $connect = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
      mysqli_query( $connect, 'SET NAMES "'.DB_ENCODE.'"');
      //Si tenemos un posible error en la conexión lo mostramos
      if (mysqli_connect_errno())
      {
            printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
            exit();
      }

    require_once "../modelos/Boleta.php";
    $boleta = new Boleta();
    $datos = $boleta->datosemp($idempresa);
    $datose = $datos->fetch_object();

    $nombrecomercial=$datose->nombre_razon_social;

    //Inclusion de la tabla RUTAS
    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($idempresa);
    $Prutas = $Rrutas->fetch_object();
    $rutadata=$Prutas->rutadata; // ruta de la carpeta DATA
    $rutafirma=$Prutas->rutafirma; // ruta de la carpeta FIRMA
    $rutadatalt=$Prutas->rutadatalt; // ruta de la carpeta DATAALTERNA
    $rutaenvio=$Prutas->rutaenvio; // ruta de la carpeta rutaenvio
    $rutaunzipxml=$Prutas->unziprpta; // ruta de la carpeta ruta unziprpta

     $query = "select
     b.tipo_documento_06 as tipocomp, 
     b.numeracion_07 as numerodoc 
     from 
     boleta b inner join persona p on b.idcliente=p.idpersona inner join empresa e on b.idempresa=e.idempresa where idboleta='$idboleta'  order by numerodoc";

     $result = mysqli_query($connect, $query);  


     if ($result) {
      while($row=mysqli_fetch_assoc($result)){
      for($i=0; $i <= count($result); $i++){
           $tipocomp=$row["tipocomp"];
           $numerodoc=$row["numerodoc"];
           $ruc=$datose->numero_ruc;
         }
       }
    $cabextxml=$rutafirma.$ruc."-".$tipocomp."-".$numerodoc.".xml";
    $rpta = array ('rutafirma'=>$cabextxml);

     }else{

      $rpta = array ('rutafirma'=>'');
     }
      

  return $rpta;
    }



    public function mostrarrptafactura($idfactura, $idempresa)
    {
      $connect = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
      mysqli_query( $connect, 'SET NAMES "'.DB_ENCODE.'"');
      //Si tenemos un posible error en la conexión lo mostramos
      if (mysqli_connect_errno())
      {
            printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
            exit();
      }

    require_once "../modelos/Factura.php";
    $factura = new Factura();
    $datos = $factura->datosemp($idempresa);
    $datose = $datos->fetch_object();

    //Inclusion de la tabla RUTAS
    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($idempresa);
    $Prutas = $Rrutas->fetch_object();
    $rutarpta=$Prutas->rutarpta; // ruta de la carpeta DATA
    $rutaunzipxml=$Prutas->unziprpta; // ruta de la carpeta ruta unziprpta
    

     $query = "select
     f.tipo_documento_07 as tipocomp, 
     f.numeracion_08 as numerodoc 
     from 
     factura f inner join persona p on f.idcliente=p.idpersona inner join empresa e on f.idempresa=e.idempresa where idfactura='$idfactura' and f.estado in('5','4') order by numerodoc";

     $result = mysqli_query($connect, $query);  

      $con=0; //COntador de variable
            
      while($row=mysqli_fetch_assoc($result)){
      for($i=0; $i <= count($result); $i++){
           $tipocomp=$row["tipocomp"];
           $numerodoc=$row["numerodoc"];
           $ruc=$datose->numero_ruc;
         }
       }

  $rutarptazip=$rutarpta.'R'.$ruc."-".$tipocomp."-".$numerodoc.".zip";
   $rutaxmlrpta=$rutaunzipxml.'R-'.$ruc."-".$tipocomp."-".$numerodoc.".xml";
   $rpta = array ('rpta'=>$rutarptazip, 'rutaxmlr'=> $rutaxmlrpta);
   return $rpta;
  }



  public function mostrarrptaboleta($idboleta, $idempresa)
    {
      $connect = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
      mysqli_query( $connect, 'SET NAMES "'.DB_ENCODE.'"');
      //Si tenemos un posible error en la conexión lo mostramos
      if (mysqli_connect_errno())
      {
            printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
            exit();
      }

    require_once "../modelos/Boleta.php";
    $boleta = new Boleta();
    $datos = $boleta->datosemp($idempresa);
    $datose = $datos->fetch_object();

    //Inclusion de la tabla RUTAS
    require_once "../modelos/Rutas.php";
    $rutas = new Rutas();
    $Rrutas = $rutas->mostrar2($idempresa);
    $Prutas = $Rrutas->fetch_object();
    $rutarpta=$Prutas->rutarpta; // ruta de la carpeta DATA
    $rutaunzipxml=$Prutas->unziprpta; // ruta de la carpeta ruta unziprpta
    

     $query = "select
     b.tipo_documento_06 as tipocomp, 
     b.numeracion_07 as numerodoc 
     from 
     boleta b inner join persona p on b.idcliente=p.idpersona inner join empresa e on b.idempresa=e.idempresa where idboleta='$idboleta' order by numerodoc";

     $result = mysqli_query($connect, $query);  

      $con=0; //COntador de variable
            
      while($row=mysqli_fetch_assoc($result)){
      for($i=0; $i <= count($result); $i++){
           $tipocomp=$row["tipocomp"];
           $numerodoc=$row["numerodoc"];
           $ruc=$datose->numero_ruc;
         }
       }

  $rutarptazip=$rutarpta.'R'.$ruc."-".$tipocomp."-".$numerodoc.".zip";
   $rutaxmlrpta=$rutaunzipxml.'R-'.$ruc."-".$tipocomp."-".$numerodoc.".xml";
   $rpta = array ('rpta'=>$rutarptazip, 'rutaxmlr'=> $rutaxmlrpta);
   return $rpta;
  }



  public function notificaciones($fecnot)
    {

      
       $sql="select 
       n.idnotificacion, 
       n.nombrenotificacion, 
       date_format(n.fechaaviso, '%d/%m/%Y') as fechaaviso, 
       date_format(n.fechaaviso + 1, '%d/%m/%Y') as proxfechaaviso,
       date_format(date_add(n.fechaaviso, interval 1 month), '%d/%m/%Y') as proxfechaaviso,  
       n.continuo, 
       if(n.tipocomprobante='01', 'FACTURA', 'BOLETA') as tipocomprobante, 
       n.estado, 
       p.nombre_comercial,
       n.contador
        from notificaciones n inner join persona p 
       on n.idpersona=p.idpersona
       where fechaaviso='$fecnot' and n.estado='1' and n.contador >0";
        // $sql2="update notificaciones set contador=if(contador=0, 0, contador - 1) where date(fechaaviso)=current_date()";
        // ejecutarConsulta($sql2);
       
       return ejecutarConsulta($sql);
    }


    public function editarnotificacion()
    {
       //$sql="update notificaciones set  fechaaviso=if(contador=0, date_add(fechaaviso, interval 1 month), fechaaviso)";
        //return ejecutarConsulta($sql);
    }


    public function avanzar($idnotificacion)
    {
        $sql="update notificaciones set  fechaaviso=date_add(fechaaviso, interval 1 month)
         where 
         idnotificacion='$idnotificacion' ";
        return ejecutarConsulta($sql);
    }




    public function ComprobantesPendientesA()
    {

       $sql="select 
       fechaC,
       estadoC,
       sumaC,
       (case 
        when tdocu='03' then 'BOLETA'
        when tdocu='01' then 'FACTURA'
       else 'NOT CRED'
        end
       ) as tdocu
       from 
       (select   
        date_format(fecha_emision_01, '%d-%m-%Y') as fechaC, 
        (case
        when estado='1' then 'EMITIDO'
        else 'FIRMADO'
        end) as estadoC,
        count(estado) as sumaC,
        tipo_documento_06 as tdocu
        from 
        boleta 
        where estado in('4','1') and year(fecha_emision_01)=year(CURRENT_DATE())
        and month(fecha_emision_01)=month(CURRENT_DATE())
        group by fechaC, estadoC
        union all 
        select   
        date_format(fecha_emision_01, '%d-%m-%Y') as fechaC, 
        (case
        when estado='1' then 'EMITIDO'
        
        else 'FIRMADO'
        end) as estadoC,
        count(estado) as sumaC,+
        tipo_documento_07 as tdocu
        from 
        factura 
        where estado in('4','1') and year(fecha_emision_01)=year(CURRENT_DATE())
        and month(fecha_emision_01)=month(CURRENT_DATE())
        group by fechaC, estadoC
        ) as 
        tabla   group by  fechaC, estadoC, tdocu";

       return ejecutarConsulta($sql);
    }


    function enviarcorreopendientes()
    {

    require_once "../modelos/Factura.php";
    $factura = new Factura();
    $datos = $factura->correo();
    $correo = $datos->fetch_object();

     $connect = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
      mysqli_query( $connect, 'SET NAMES "'.DB_ENCODE.'"');
      //Si tenemos un posible error en la conexión lo mostramos
      if (mysqli_connect_errno())
      {
            printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
            exit();
      }



        $sql="select 
       fechaC,
       ncomprobante
       from 
       (select   
        date_format(fecha_emision_01, '%d-%m-%y') as fechaC, 
        numeracion_07 as ncomprobante
        from 
        boleta 
        where estado in('4','1') and year(fecha_emision_01)=year(CURRENT_DATE())
        and month(fecha_emision_01)=month(CURRENT_DATE())
        
        union all 


        select   
        date_format(fecha_emision_01, '%d-%m-%y') as fechaC, 
        numeracion_08 as ncomprobante
        from 
        factura 
        where estado in('4','1') and year(fecha_emision_01)=year(CURRENT_DATE())
        and month(fecha_emision_01)=month(CURRENT_DATE())
        ) 
        as 
        tabla order by fechaC ";


      $result = mysqli_query($connect, $sql); 
      $lista=array();
      $fechaco=array();
      $cont=0;
      while($row=mysqli_fetch_assoc($result)){
      for($i=0; $i < count($result); $i++){
           $lista[]=$row["ncomprobante"];
           $fechaco[]=$row["fechaC"];
           //$cont++;
          }
      }

$email_message="";
  // FUNCION PARA ENVIO DE CORREO CON LA FACTURA AL CLIENTE .
  require '../correo/PHPMailer/class.phpmailer.php';
  require '../correo/PHPMailer/class.smtp.php';
  $mail = new PHPMailer;
  $mail->isSMTP();  
  //$mail -> SMTPDebug  =  2 ;                       // Establecer el correo electrónico para utilizar SMTP
  $mail->Host = $correo->host;             // Especificar el servidor de correo a utilizar 
  $mail->SMTPAuth = true;                  // Habilitar la autenticacion con SMTP
  $mail->Username = $correo->username ;    // Correo electronico saliente ejemplo: tucorreo@gmail.com
  //$clavehash=hash("SHA256",$correo->password);
  $mail->Password = $correo->password;     // Tu contraseña de gmail
  $mail->SMTPSecure = $correo->smtpsecure;                  // Habilitar encriptacion, `ssl` es aceptada
  $mail->Port = $correo->port;                          // Puerto TCP  para conectarse 
  $mail->setFrom($correo->username, utf8_decode($correo->nombre));//Introduzca la dirección de la que debe aparecer el correo electrónico. Puede utilizar cualquier dirección que el servidor SMTP acepte como válida. El segundo parámetro opcional para esta función es el nombre que se mostrará como el remitente en lugar de la dirección de correo electrónico en sí.
  $mail->addReplyTo($correo->username, utf8_decode($correo->nombre));//Introduzca la dirección de la que debe responder. El segundo parámetro opcional para esta función es el nombre que se mostrará para responder
  
  $mail->addAddress($correo->correoavisos);   // Agregar quien recibe el e-mail enviado
  $message = file_get_contents('../correo/email_template.html');
  $message = str_replace('{{first_name}}', utf8_decode($correo->nombre),"1");
  $message = str_replace('{{message}}', "2", "2");
  $message = str_replace('{{customer_email}}', $correo->username, "3");
  $mail->isHTML(true);  // Establecer el formato de correo electrónico en HTML
$email_message .= "<table class='table table-striped table-hover table-bordered'>";
     $email_message .= "<thead  style='background-color:#35770c; color: #fff;'>";
     $email_message .= "<th> Comprobante </th> <th> Fecha </th>";
     $email_message .= "</thead>";
     $email_message .= "<tbody>";
   foreach ($lista as $fila) {
    foreach ($fechaco as $fechacc) {
        
    }
    //$email_message .="<tr>";
    $email_message .= "<tr><th>".$fila."</th>  <th>".$fechacc."</th></tr>";
    //$email_message .="</tr>";
   }
   $email_message .= "</tbody>";
   $email_message .= "</table>";
  //$email_message = "Los comprobantes son: <br/> \n";//.$verif_code;

  $mail->Subject = $correo->username;
  $mail->msgHTML("<h3>Tiene pendiente los siguientes comprobantes:</h3> \n".$email_message);
  $mail->send();
    }



       public function recalcular($fecha)
    {
        $sql="select idcaja from caja where fecha='$fecha' order by idcaja desc limit 1";
        $regVal=ejecutarConsulta($sql);   
          while($reg= $regVal->fetch_object())
        {
            $idcaja=$reg->idcaja;
            $sqlingreso="select sum(monto) as tingreso from ingresocaja where idcaja='$idcaja'";
              $tingre=ejecutarConsulta($sqlingreso);
              $regti= $tingre->fetch_object();
                   $ttii=$regti->tingreso;
            $sqlegreso="select sum(monto) as tegreso from salidacaja where idcaja='$idcaja'";
            $tegre=ejecutarConsulta($sqlegreso);
              $regte= $tegre->fetch_object();
                   $ttss=$regte->tegreso;
        }

          $sqlupdate="update caja set montoi=montoi + '$ttii', montof=montoi - '$ttss' where idcaja='$idcaja'";
        return ejecutarConsulta($sqlupdate);
    }






    public function ventadetalleventas($fecha1, $fecha2, $mes){
        $sql="select 
          sum(subtotal) as tventas

            from 
            (select 
              total_operaciones_gravadas_monto_18_2 as subtotal
            from 
            factura f where date_format(fecha_emision_01, '%Y-%m-%d') BETWEEN '$fecha1' and '$fecha2'  or  month(fecha_emision_01)='$mes' and  estado in('5','6','1','4')  and year(fecha_emision_01)=year(now())
             union all
             
            select  monto_15_2 as subtotal
            from 
            boleta 
            where 
           date_format(fecha_emision_01, '%Y-%m-%d') BETWEEN '$fecha1' and '$fecha2'  or  month(fecha_emision_01)='$mes' and  estado in('5','6','1','4')  and year(fecha_emision_01)=year(now())
             union all
             
             select  monto_15_2 as subtotal 
             from 
             notapedido 
             where 
             date_format(fecha_emision_01, '%Y-%m-%d') BETWEEN '$fecha1' and '$fecha2'  or  month(fecha_emision_01)='$mes' and  estado in('5','6','1','4')  and year(fecha_emision_01)=year(now())
             ) 
            as tabla";
        return ejecutarConsulta($sql);
            }



public function totalingresos($fecha1, $fecha2, $mes){
        $sql="select 
        c.nombreconcepto as concepto, 
        sum(i.monto) as totaling 
        from ingresocaja i inner join conceptois c on i.idconceptois=c.idconcepto where  date_format(i.fechain, '%Y-%m-%d') BETWEEN '$fecha1' and '$fecha2'  or  month(i.fechain)='$mes'  and year(i.fechain)=year(now()) group by  c.nombreconcepto";
        return ejecutarConsulta($sql);
            }


}

?>