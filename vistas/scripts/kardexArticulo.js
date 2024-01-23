var tabla;
 
//Función que se ejecuta al inicio
function init(){

 
    $("#formulario").on("submit",function(e)
    {
        kardexarticulo1(e);  
    });

    document.getElementById('codigoInterno').focus(); 
     
}
 
//Función limpiar
function limpiar()
{
    $("#idproveedor").val("");
    $("#fecha_emision").val("");
    $("#proveedor").val("");
    
    
}
 
//Función mostrar formulario
function mostrarform(flag)
{
    limpiar();
    if (flag)
    {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        //$("#btnGuardar").prop("disabled",false);
        $("#btnagregar").hide();
        listarArticulos();
 
        $("#btnGuardar").hide();
        $("#btnCancelar").show();
        detalles=0;
        $("#btnAgregarArt").show();
    }
    else
    {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
 
}
 
//Función cancelarform
function cancelarform()
{
    limpiar();
    
}
 

 
 

 
function mostrar(idfactura)
{
    $.post("../ajax/factura.php?op=mostrar",{idfactura : idfactura}, function(data, status)
    {
        data = JSON.parse(data);        
        
 
        $("#idfactura").val(data.idfactura);

         $("#numero_factura").val(data.numeracion_08);
         $("#numero_documento").val(data.numero_documento);
         $("#razon_social").val(data.cliente);
         $("#domicilio_fiscal").val(data.domicilio_fiscal);
        
         $("#fecha_emision").prop("disabled",true);
         $("#fecha_emision").val(data.fecha);
         $("#subtotal").html(data.total_operaciones_gravadas_monto_18_2);
         $("#igv_").html(data.sumatoria_igv_22_1);
         $("#total").html(data.importe_total_venta_27);

        //Ocultar y mostrar los botones
        $("#btnGuardar").hide();
        $("#btnCancelar").show();
        $("#btnAgregarArt").hide();
    });
 
     
}
 

 
init();



