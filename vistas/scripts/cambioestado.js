var tabla;
var tablaArti;
$idempresa=$("#idempresa").val(); 
//Función que se ejecuta al inicio
function init(){
    $("#razon_social").val("VARIOS");
    $("#numero_documento").val("VARIOS");
 
    $("#formulario").on("submit",function(e)
    {
        guardaryeditarCambioestado(e);  
    });

     cont=0;
     conNO=1;
    listarComprobantes();
}

//Función para poner ceros antes del numero siguiente de la factura
function pad (n, length){
    var n= n.toString();
while(n.length<length)
    n="0" + n;
    return n;
}
//Fin de Función    


//Función limpiar
function limpiar()
{
  $(".filas").remove();
  $("#chestado").val("0");
    

}
 
//Función mostrar formulario
function mostrarform(flag)
{

 
}


function listarComprobantes()
{
    tablaArti=$('#tblcomprobantes').dataTable(
    {
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [                 ],
        "ajax":
                {
                    url: '../ajax/notapedido.php?op=listarcomprobantes',
                    type : "get",
                    dataType : "json",                      
                    error: function(e){
                    console.log(e.responseText);    
                    }
                },
        "bDestroy": true,
        "iDisplayLength": 5,//Paginación
        "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
    }).DataTable();
  $('#tblcomprobantes').DataTable().ajax.reload();
}





//Función para guardar o editar
function guardaryeditarCambioestado(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
    var mensaje=confirm("¿Desea guardar y cambiar los estados?");
    if (mensaje){
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../ajax/notapedido.php?op=guardaryeditarCambioestado",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos)
        {                    
              bootbox.alert(datos);
              listarComprobantes();           
        }
    });
    limpiar();

        }
}



 

  function agregarDetalleEstadocliente(idnota, fecha, cliente, nroserie, total, estado)
  {
    $est="";
    if (estado=='1')
    {$est="EMITIDO";
    }else if(estado=='5'){
      $est="PAGADO";
    }else{
      $est="ANULADO";
    }
    var cantidad=0;
     if (idnota!="")
    {
        var contador=1;
        var fila='<tr class="filas" id="fila'+cont+'">'+
        '<td><button type="button" class="btn btn-danger btn-sm" onclick="eliminarDetalle('+(cont) +')">X</button>'+
        '<input type="hidden" name="idnota[]" id="idnota[]" value="'+idnota+'"></td>'+
        '<td><input type="text" class=""  readonly name="fecha[]" id="fecha[]" value="'+fecha+'"></td>'+
        '<td><input type="text"  class="" name="cliente[]" id="cliente[]" value="'+cliente+'" readonly></td>'+
        '<td><input type="text"  class="" name="nroserie[]" id="nroserie[]" value="'+nroserie+'" readonly></td>'+
        '<td><input type="text"  class="" name="total[]" id="total[]" value="'+total+'" readonly></td>'+
        '<td><input type="text"  class="" name="estadoC[]" id="estadoC[]" value="'+$est+'" readonly></td>'+
        '</tr>'
        var id = document.getElementsByName("idnota[]");
        for (var i = 0; i < id.length; i++) {
            var idA=id[i];
        if (idA.value==idnota) { 
        alert("Ya esta ingresado!");
        fila="";
        cont=cont - 1;
        conNO=conNO -1;
        }else{
        detalles=detalles;
        }}

        detalles=detalles+1;
        cont++;
        conNO++;
      
        $('#detalles').append(fila);
//        modificarSubototales();
        //$("#myModalcomprobantes").modal('hide');
        //$('#tblcomprobantes').DataTable().ajax.reload();
        

    }
    else
    {
        alert("Error al ingresar el detalle, revisar los datos del artículo");
        cont=0;
    }
  
  }

 
  function evaluar(){
    if (detalles>0)
    {
    $("#btnGuardar").show();
    //mayor700();
    }else{
    $("#btnGuardar").hide(); 
      cont=0;
    }
 
 }


function evaluar2(){
    if (detalles>0)
    {
      $("#btnGuardar").hide(); 
       cont=0;
    }
  }


 
  function eliminarDetalle(indice){
    $("#fila" + indice).remove();
    calcularTotales();
    detalles=detalles-1;
    conNO=conNO - 1;
    actualizanorden();
    evaluar()
  }

init();
