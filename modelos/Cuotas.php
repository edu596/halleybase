<?php
require "../config/Conexion.php";
Class Cuotas
{
    //Implementamos nuestro constructor
    public function __construct()
    {
 
    }
  

   

    
    public function listartcomprobantes($f1, $f2, $moneda, $tipocom)
    {
        $sql="select 
            numerocomp,
            date_format(fechae, '%d-%m-%Y') as fechae, 
            date_format(fechae, '%Y-%m-%d') as fechaa, 
            cliente,
            total,
            ncuota,
            cuotaspendientes,
            idcomprobante,
            tipocomprobante,
            cuotaspagadas
from 
(select f.numeracion_08 as numerocomp, f.fecha_emision_01 as fechae,f.fecha_emision_01 as fechaa,  p.nombre_comercial as cliente, f.importe_total_venta_27 as total, f.ccuotas as ncuota, f.cuotaspendientes, idfactura as idcomprobante, tipo_documento_07 as tipocomprobante, f.cuotaspagadas
from factura f
inner join persona p on f.idcliente=p.idpersona 
where f.tipopago='Credito' and date_format(fecha_emision_01,'%Y-%m-%d') BETWEEN '$f1' and '$f2' and f.tipo_moneda_28='$moneda' and tipo_documento_07='$tipocom'
 union all 
 select b.numeracion_07 as numerocomp, b.fecha_emision_01 as fechae, b.fecha_emision_01 as fechaa, p.nombre_comercial as cliente, b.importe_total_23 as total, b.ccuotas as ncuota, b.cuotaspendientes, idboleta as idcomprobante, tipo_documento_06 as tipocomprobante, b.cuotaspagadas
 from boleta b
 inner join persona p on b.idcliente=p.idpersona 
 where b.tipopago='Credito' and  date_format(fecha_emision_01,'%Y-%m-%d') BETWEEN '$f1' and '$f2' and b.tipo_moneda_24='$moneda' and tipo_documento_06='$tipocom')
 as tabla group by numerocomp order by fechae desc ";
        return ejecutarConsulta($sql);
    }




 public function buscarcuotasC($idccpp, $tippcc)
    {
        $sql="select
            idcomprobante,
            tipocomprobante, 
            idcuota,
            ncuota,
            montocuota, 
            estadocuota,
            date_format(fechacuota, '%d-%m-%Y') as fechacuota 
            from 
            cuotas where idcomprobante='$idccpp' and tipocomprobante='$tippcc'";
        return ejecutarConsulta($sql);
    }



public function cuotpagada($idc, $idcomp, $tipodoc)
    {
        

        if($tipodoc=='01'){
        $sql2="update factura set cuotaspagadas=cuotaspagadas + 1, cuotaspendientes=cuotaspendientes - 1 where idfactura='$idcomp'";
        }else{
        $sql2="update boleta set cuotaspagadas=cuotaspagadas + 1, cuotaspendientes=cuotaspendientes - 1 where idboleta='$idcomp'";
        }
        ejecutarConsulta($sql2);

        $sql="update cuotas set estadocuota='1' where idcuota='$idc'";

        return ejecutarConsulta($sql);
    }


    public function cancelacuot($idc, $idcomp, $tipodoc)
    {

         if($tipodoc=='01'){
        $sql2="update factura set cuotaspagadas=cuotaspagadas - 1, cuotaspendientes=cuotaspendientes + 1 where idfactura='$idcomp'";
        }else{
        $sql2="update boleta set cuotaspagadas=cuotaspagadas - 1, cuotaspendientes=cuotaspendientes + 1 where idboleta='$idcomp'";
        }
        ejecutarConsulta($sql2);

        $sql="update cuotas set estadocuota='0' where idcuota='$idc'";
        return ejecutarConsulta($sql);
    }

  


}

?>