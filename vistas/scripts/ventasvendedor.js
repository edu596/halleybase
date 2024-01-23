var fecha = new Date();
var ano = fecha.getFullYear();
//var mes=fecha.getFullMonth();
$("#ano").val(ano);
//$("#mes").val(mes);

$idempresa=$("#idempresa").val();

// Carga de combo para vendedores =====================
    $.post("../ajax/vendedorsitio.php?op=selectVendedorsitio&idempresa="+$idempresa, function(r){
            $("#vendedorsitio").html(r);
            $('#vendedorsitio').selectpicker('refresh');
    });



function listarVentasVendedor()
{

    var $vendedor=$("#vendedorsitio option:selected").val();
    var $ano = $("#ano option:selected").text();
    var $mes = $("#mes option:selected").val();

if ($mes=='00') {
//Si la consulta es por vendedor, año.
$.post('../ajax/ventas.php?op=ventaVendedorFacturaAno&vendedor='+$vendedor+'&ano='+$ano+'&idempresa='+$idempresa, function(dataf,status){
            $("#Tfactura").html(dataf);
    });

$.post('../ajax/ventas.php?op=ventaVendedorBoletaAno&vendedor='+$vendedor+'&ano='+$ano+'&idempresa='+$idempresa, function(datab,status){
            $("#Tboleta").html(datab);
    });



}else{

//Si la consulta es por vendedor, año y mes
  $.post('../ajax/ventas.php?op=ventaVendedorFactura&vendedor='+$vendedor+'&ano='+$ano+'&mes='+$mes+'&idempresa='+$idempresa, function(dataf,status){
            $("#Tfactura").html(dataf);
    });


  $.post('../ajax/ventas.php?op=ventaVendedorBoleta&vendedor='+$vendedor+'&ano='+$ano+'&mes='+$mes+'&idempresa='+$idempresa, function(datab,status){
            $("#Tboleta").html(datab);
    });
}

}


