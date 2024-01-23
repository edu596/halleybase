var tabla;
var tablaCLiente;
var tablaArti;
var tablaServi;
$idempr=$("#idempresa").val();
$iva=$("#iva").val();
//Función que se ejecuta al inicio
function init(){

    $("#formulario").on("submit",function(e)
    {
        guardaryeditardoccobranza(e);  

    });

     $("#formularioncliente").on("submit",function(e)
    {
        guardaryeditarcliente(e);  
    });

    $("#formularionfactura").on("submit",function(e)
    {
        guardaryeditarnuevafactura(e);  
    });



// Carga de combo para vendedores =====================
    $.post("../ajax/vendedorsitio.php?op=selectVendedorsitio&idempresa="+$idempr, function(r){
            $("#vendedorsitio").html(r);
            $('#vendedorsitio').selectpicker('refresh');
    });


    // Carga tipo de cambio =====================
    $.post("../ajax/factura.php?op=tcambiodia", function(r){
            $("#tcambio").val(r);
    });


    // Carga de combo para tributo =====================
    $.post("../ajax/factura.php?op=selectTributo", function(r){
            $("#nombre_tributo_4_p").html(r);
            $('#nombre_tributo_4_p').selectpicker('refresh');
    });


    cont=0;
    conNO=1;

    contf=0;
    conNOf=1;

    sw=0;
    actCli=0;
    
    mostrarform(false);
    listar();


}







//Función Listar
function listar()
{
    tabla=$('#tbllistado').dataTable(
    {
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [                
                     {
                extend:    'copyHtml5',
                text:      '<i class="fa fa-files-o"></i>',
                titleAttr: 'Copy'
            },
            {
                extend:    'excelHtml5',
                text:      '<i class="fa fa-file-excel-o"></i>',
                titleAttr: 'Excel'
            },
            {
                extend:    'csvHtml5',
                text:      '<i class="fa fa-file-text-o"></i>',
                titleAttr: 'CSV'
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fa fa-file-pdf-o"></i>',
                titleAttr: 'PDF'
            }
                ],
        "ajax":
                {
                    url: '../ajax/doccobranza.php?op=listar',
                    type : "get",
                    dataType : "json",                      
                    error: function(e){
                    console.log(e.responseText);    
                    }
                },

         "rowCallback": 
         function( row, data ) {
        },

        "bDestroy": true,
        "iDisplayLength": 8,//Paginación
        "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
    }).DataTable();
}



function mayus(e) {
     e.value = e.value.toUpperCase();
}



function incrementarNum(){
    var serie=$("#serie option:selected").val();
    $.post("../ajax/doccobranza.php?op=autonumeracion&ser="+serie+'&idempresa='+$idempr, function(r){
       var n2=pad(r,0);
       $("#numero_doccobranza").val(n2);

       var SerieReal = $("#serie option:selected").text();
        $("#SerieReal").val(SerieReal);
    });
    document.getElementById('numero_documento2').focus();
}



function incrementarinicio(){
 $.post("../ajax/doccobranza.php?op=selectSerie", function(r)
        {
        $("#serie").html(r);
        //$("#serie").selectpicker('refresh');
        var serieL=document.getElementById('serie');
        var opt = serieL.value;
        $.post("../ajax/doccobranza.php?op=autonumeracion&ser="+opt+'&idempresa='+$idempr, function(r){
       var n2=pad(r,0);
       $("#numero_doccobranza").val(n2);
       var SerieReal = $("#serie option:selected").text();
        $("#SerieReal").val(SerieReal);
        });
        });

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
    $("#idcliente").val("");
    //$("#numero_documento").val("");
    $("#razon_social").val("");
    $("#razon_social2").val("");
    $("#domicilio_fiscal").val("");
    $("#domicilio_fiscal2").val("");

    $("#cliente").val("");
    $("#numero_documento").val("");
    $("#numero_documento2").val("");
    //$("#serie").val("");
    $("#numero_doccobranza").val("");
     $("#tcambio").val("");
     $("#observacion").val("");
    $("#impuesto").val("0");
    $(".filas").remove();

    $("#subtotal").html("0");
    $("#subtotal_doccobranza").val("");
    $("#igv_").html("0");
    $("#total_igv").val("");
    $("#total").html("0");
    $("#total_final").val("");
    $("#pre_v_u").val("");
    $("#guia_remision_29_2").val("");
    $("#tdescuentoL").val("");

    $("#correocli").val("");
    $("#numero_documento2").focus();
    $("#tipodoccobranza").val("none");
    $("#tipo_doc_cli").val("none");
    $("#tipo_moneda").val("none");

    $("#tarifaS").html("0.00");
    $("#subtotal_servicio").html("0.00");
    $("#subtotal_doccobranza_servicio").val("0.00"); // a base de datos
    
    $("#igv_servicio").html("0.00");
    $("#total_igv_servicio").val("0.00"); // a base de datos
    
    $("#total_servicio").html("0.00");
    $("#total_final_servicio").val("0.00");

    $("tipopago").val("contado");

    document.getElementById("divruc").style.display = "none"; 
    document.getElementById("divdni").style.display = "none"; 

    document.getElementById("divproductos").style.display = "none"; 
    document.getElementById("divservicios").style.display = "none"; 

    document.getElementById("detallesproductoDIV").style.display = "none"; 
    document.getElementById("detallesservicioDIV").style.display = "none"; 

    
     
    //Obtenemos la fecha actual
    $("#fecha_emision").prop("disabled",false);
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);

    var f=new Date();
    cad=f.getHours()+":"+f.getMinutes()+":"+f.getSeconds(); 

    //Para hora y minutos
    //&var today = now.getFullYear()+"-"+(month)+"-"+(day)+" "+(cad) ;
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fecha_emision').val(today);
    $('#fecemifa').val(today);

    document.getElementById("btnAgregarArt").style.backgroundColor= '#35770c';     


    cont=0;
    conNO=1;

    }



function capturarhora(){ 
var f=new Date();
cad=f.getHours()+":"+f.getMinutes()+":"+f.getSeconds(); 
$("#hora").val(cad);
//$("#horaf").val(cad);
}


 
//Función mostrar formulario
function mostrarform(flag,sesion)
{


      limpiar();
   if (flag)
    {
     
        incrementarinicio();
        listarArticulos();
        listarServicios()
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnagregar").hide();
        $("#btnGuardarDoccobranza").show();
        $("#btnCancelar").show();
        $("#btnAgregarArt").show();
        $("#numero_documento2").focus();
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

    var mensaje=confirm("¿Desea cancelar el comprobante?")

    if (mensaje){
    limpiar();
    evaluar2();
    detalles=0;
    detallesf=0;
    mostrarform(false);

    }
    
}
 

function agregarCliente(idpersona,razon_social,numero_documento,domicilio_fiscal, tipo_documento)
  {
    
     if (idpersona!="")
    {
        $('#idcliente').val(idpersona);
        $('#numero_documento2').val(numero_documento);
        $('#razon_social2').val(razon_social);
        $('#domicilio_fiscal2').val(domicilio_fiscal);
        $('#tipo_documento_cliente').val(tipo_documento);
        $("#myModalCli").modal('hide');
    }
    else
    {
        alert("Error al ingresar el detalle, revisar los datos del cliente");
    }
  }

//Función ListarClientes
function listarClientes()
{
    
    tablaCLiente=$('#tblaclientes').dataTable(
    {
        "aProcessing": false,//Activamos el procesamiento del datatables
        "bRetrieve ": false,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [                
                     
                ],
        "ajax":
                {
                    url: '../ajax/factura.php?op=listarClientesfactura',
                    type : "get",
                    dataType : "json",                      
                    error: function(e){
                    console.log(e.responseText);    
                    }
                },
        "bDestroy": true,
        "iDisplayLength": 8,//Paginación
        "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
    }).DataTable();

$('#tblaclientes').DataTable().ajax.reload();

} 


//Función ListarArticulos
function listarArticulos()
{
    tablaArti=$('#tblarticulos').dataTable(
    {
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [                
                     
                ],
        "ajax":
                {
                    url: '../ajax/doccobranza.php?op=listarArticulosdoccobranza&idempresaA',
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

    $('#tblarticulos').DataTable().ajax.reload();
}



function listarServicios()
{
    tablaArti=$('#tblservicios').dataTable(
    {
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [                
                     
                ],
        "ajax":
                {
                    url: '../ajax/doccobranza.php?op=listarArticulosservicio&idempresa',
                    type : "get",
                    dataType : "json",                      
                    error: function(e){
                    console.log(e.responseText);    
                    }
                },
        "bDestroy": true,
        "iDisplayLength": 8,//Paginación
        "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
    }).DataTable();

    $('#tblservicios').DataTable().ajax.reload();
}




//Función para guardar o editar
 
function guardaryeditardoccobranza(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
    
    var cant = document.getElementsByName("cantidad[]");
    var prec = document.getElementsByName("valor_unitario[]");
    var stk = document.getElementsByName("stock[]");
    var idcliente =  $('#idcliente').val();

     sw=0;
  
    var mensaje=confirm("¿Desea emitir el documento de cobranza?");
    if (mensaje){

   //========================================================     
   capturarhora();
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../ajax/doccobranza.php?op=guardaryeditardoccobranza",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos)
        {     
               
              bootbox.alert(datos);
              //mostrarultimocomprobante();
              mostrarform(false);
              listar();
        }
        
    });     
           limpiar();
   //========================================================
            sw=0;

        }

    
}


    







function guardaryeditarcliente(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
    //$("#btnGuardarcliente").prop("disabled",true);
    var formData = new FormData($("#formularioncliente")[0]);

    $.ajax({
        url: "../ajax/persona.php?op=guardaryeditarNcliente",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos)
        {                    
              bootbox.alert(datos);           
              tabla.ajax.reload();
              limpiarcliente();
              agregarClientexRucNuevo();
        }

    });
    
     $("#ModalNcliente").modal('hide');
     $("#myModalCli").modal('hide');

}


function guardaryeditarTcambio(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
    //$("#btnGuardarcliente").prop("disabled",true);
    var formData = new FormData($("#formulariotcambio")[0]);

    $.ajax({
        url: "../ajax/factura.php?op=guardaryeditarTcambio",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos)
        {                    
              bootbox.alert(datos);           
              tabla.ajax.reload();
              //limpiarcliente();
              //agregarClientexRucNuevo();
        }

    });
    
     $("#modalTcambio").modal('hide');
}







function agregarClientexRucNuevo()
  {
        
    $.post("../ajax/factura.php?op=listarClientesfacturaxDocNuevos", function(data,status)
    {
       
       data=JSON.parse(data);
       
       if (data != null){
       $('#numero_documento2').val(data.numero_documento);
       $('#idcliente').val(data.idpersona);
       $("#razon_social2").val(data.razon_social);
       $('#domicilio_fiscal2').val(data.domicilio_fiscal);
       $('#correocli').val(data.email);
       $('#tipo_documento_cliente').val(data.tipo_documento);
       document.getElementById("btnAgregarArt").style.backgroundColor= '#367fa9';
       document.getElementById("btnAgregarArt").focus();
        }else{
       $('#idcliente').val("");
       $("#razon_social2").val("No existe");
       $('#domicilio_fiscal2').val("No existe");
       $('#tipo_documento_cliente').val("");
       document.getElementById("btnAgregarArt").style.backgroundColor= '#35770c';     
       document.getElementById("btnAgregarCli").focus();     
       
        }
        
    });


}

function limpiarcliente(){
 //NUEVO CLIENTE
    
    $("#numero_documento").val("");
    $("#razon_social").val("");
    $("#domicilio_fiscal").val("");
    $("#iddepartamento").val("");
    $("#idciudad").val("");
    $("#iddistrito").val("");
    $("#telefono1").val("");
    $("#email").val("");
    $("#nruc").val("");
    $("#numero_documento3").val("");
//=========================
}


function mostrar(idfactura)
{
    $.post("../ajax/factura.php?op=mostrar",{idfactura : idfactura}, function(data, status)
    {
        data = JSON.parse(data);        
        mostrarform(true);
 
         $("#idfactura").val(data.idfactura);
         $("#numero_doccobranza").val(data.numeracion_08);
         $("#numero_documento").val(data.numero_documento);
         $("#razon_social").val(data.cliente);
         $("#domicilio_fiscal").val(data.domicilio_fiscal);
        
         $("#fecha_emision").prop("disabled",true);
         $("#fecha_emision").val(data.fecha);
         $("#subtotal").html(data.total_operaciones_gravadas_monto_18_2);
         $("#igv_").html(data.sumatoria_igv_22_1);
         $("#total").html(data.importe_total_venta_27);

        //Ocultar y mostrar los botones
        $("#btnGuardarDoccobranza").hide();
        $("#btnCancelar").show();
        $("#btnAgregarArt").hide();
    });
 
     $.post("../ajax/factura.php?op=listarDetalle&id="+idfactura,function(r){
             $("#detalles").html(r);
     }); 
}
 
//Función para anular registros
function anular(idfactura)
{
    bootbox.confirm("¿Está Seguro de anular la factura?", function(result){
        if(result)
        {
            $.post("../ajax/factura.php?op=anular", {idfactura : idfactura}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            }); 
        }
    })
}

//Función para enviar respuestas por correo 
function enviarcorreo(idfactura)
{
    bootbox.confirm("¿Está Seguro de enviar correo al cliente?", function(result){
        if(result)
        {
            $.post("../ajax/factura.php?op=enviarcorreo", {idfactura : idfactura}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            }); 
        }
    })
}

//Función para enviar respuestas por correo 
function enviarxmlSUNAT(idfactura)
{
    bootbox.confirm("¿Está Seguro de enviar archivo firmado a SUNAT?", function(result){
        if(result)
        {
            $.post("../ajax/factura.php?op=enviarxmlSUNAT", {idfactura : idfactura}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            }); 
        }
    })
}






//Función para dar de baja registros
function anular(idcobranza)
{

 var f=new Date();
 cad=f.getHours()+":"+f.getMinutes()+":"+f.getSeconds(); 

bootbox.prompt({
    title: "---",
    
    callback: function (result) {
        if(result)
        {
            $.post("../ajax/doccobranza.php?op=anular", {idcobranza : idcobranza}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            }); 
        }
    }

});

}








 
//Declaración de variables necesarias para trabajar con las compras y
//sus detalles
var impuesto=18;
var cont=0;
var detalles=0;
//$("#guardar").hide();
$("#btnGuardarDoccobranza").hide();
$("#tipo_comprobante").change(marcarImpuesto);

 
function marcarImpuesto()
  {
    var tipo_comprobante=$("#tipo_comprobante option:selected").text();
    if (tipo_comprobante=='FACTURA')
    {
        $("#impuesto").val(impuesto); 
    }
    else
    {
        $("#impuesto").val("0"); 
    }
  }


  //Función para aceptar solo numeros con dos decimales
  function NumCheck(e, field) {
  // Backspace = 8, Enter = 13, ’0′ = 48, ’9′ = 57, ‘.’ = 46
  key = e.keyCode ? e.keyCode : e.which

  if(e.keyCode===13  && !e.shiftKey)
    {
       document.getElementById('valor_unitario[]').focus();  
    }


  // backspace
          if (key == 8) return true;
          if (key == 9) return true;
        if (key > 47 && key < 58) {
          if (field.val() === "") return true;
          var existePto = (/[.]/).test(field.val());
          if (existePto === false){
              regexp = /.[0-9]{10}$/;
          }
          else {
            regexp = /.[0-9]{2}$/;
          }
          return !(regexp.test(field.val()));
        }

        if (key == 46) {
          if (field.val() === "") return false;
          regexp = /^[0-9]+$/;
          return regexp.test(field.val());
        }
        return false;
}


function NumCheck2(e, field) {
  // Backspace = 8, Enter = 13, ’0′ = 48, ’9′ = 57, ‘.’ = 46
  key = e.keyCode ? e.keyCode : e.which

  if(e.keyCode===13  && !e.shiftKey)
    {
       document.getElementById('codigob').focus();  
    }

    
  // backspace
          if (key == 8) return true;
          if (key == 9) return true;
        if (key > 47 && key < 58) {
          if (field.value() === "") return true;
          var existePto = (/[.]/).test(field.val());
          if (existePto === false){
              regexp = /.[0-9]{10}$/;
          }
          else {
            regexp = /.[0-9]{2}$/;
          }
          return !(regexp.test(field.val()));
        }

        if (key == 46) {
          if (field.value() === "") return false;
          regexp = /^[0-9]+$/;
          return regexp.test(field.val());
        }
        return false;
}




function agregarDetalleproducto(idarticulo,familia,codigo_proveedor,codigo,nombre,precio_factura,stock,unidad_medida, precio_unitario)
  {

    var cantidad=0;
     if (idarticulo!="")
    {
        var subtotal=cantidad*precio_factura;
        var igv= subtotal * $iva/100;
        var total_fin;
        var contador=1;
        var exo='';
        var op='';
        var rd='';

        
        var fila='<tr class="filas" id="fila'+cont+'">'+
        '<td><i class="fa fa-close" onclick="eliminarDetalle('+(cont) +')" style="color:red;"  data-toggle="tooltip" title="Eliminar item"></i></td>'+
        '<td><span name="numero_orden" id="numero_orden'+cont+'">'+conNO+'</span>'+
        '<input type="hidden" name="numero_orden_item[]" id="numero_orden_item[]" value="'+conNO+'" size="1"></td>'+
        '<td><input type="hidden" name="idarticulo[]" style="font-family: times, serif; font-size:10pt; font-style:italic" value="'+idarticulo+'"> <input type="text" class="form-control" style="display:none;" name="descdet[]" id="descdet[]" onkeyup="mayus(this)" onkeypress="return focusDescdet(event, this)">'+nombre+'</td>'+
        '<td><input type="text"  required="true" class="form-control" name="cantidad[]" id="cantidad[]"  onBlur="modificarSubototalesProductos()" size="2" onkeypress="return NumCheck(event, this)"  font-weight:bold; "></td>'+
        '<td><input type="hidden" name="codigo[]" id="codigo[]" value="'+codigo+'">'+codigo+'</td> <input type="text" name="codigo[]" id="codigo[]" value="'+codigo+'" class="form-control" size="4" style="display:none;">'+
        '<td><input type="hidden" name="unidad_medida[]" id="unidad_medida[]" value="'+unidad_medida+'">'+unidad_medida+'</td>'+
        '<td><input type="text" class="form-control" name="precio_unitario[]" id="precio_unitario[]" value="'+precio_factura+'"   onBlur="modificarSubototalesProductos()" size="5" onkeypress="return NumCheck2(event, this)" font-weight:bold;" onfocus="focusTest(this);" ></td>'+
        '<td><input type="text" class="form-control" name="valor_unitario2[]" id="valor_unitario2[]" size="5"  value="" onBlur="modificarSubototalesProductos()" onfocus="focusTest(this);" ></td>'+
        '<td><span name="subtotal" id="subtotal'+cont+'"></span>'+
        '<input type="hidden" name="subtotalBD[]" id="subtotalBD["'+cont+'"]"></td>'+
        '<td><span name="igvG" id="igvG'+cont+'" style="background-color:#9fde90bf;display:none;"></span>'+
        '<input type="hidden" name="igvBD[]" id="igvBD["'+cont+'"]"><input type="hidden" name="igvBD2[]" id="igvBD2["'+cont+'"]"></td>'+
        '<td><span name="total" id="total'+cont+'" style="background-color:#9fde90bf; display:none;" ></td>'+
        '<td><span name="pvu_" id="pvu_'+cont+'"  style="display:none"  ></span>'+
        '<input  type="hidden" name="pvt[]" id="pvt["'+cont+'"] size="2"></td>'+
        '</tr>'

        var id = document.getElementsByName("idarticulo[]");
        var ntrib = document.getElementsByName("nombre_tributo_4[]");


        for (var i = 0; i < id.length; i++) {
            var idA=id[i];
           
        if (idA.value==idarticulo) { 
        alert("Ya esta ingresado el articulo!");
        fila="";
        cont=cont - 1;
        conNO=conNO -1;
        }else{
        detalles=detalles;
        }} //PARA VALIDACION SI YA ESTA INGRESADO EL ITEM

        detalles=detalles+1;
        cont++;
        conNO++;
        $('#detallesproducto').append(fila);
        $("#myModalArt").modal('hide');

        modificarSubototalesProductos();
        setTimeout(function(){
        document.getElementById('cantidad[]').focus();
        },500);
    
    }
    else
    {
        alert("Error al ingresar el detalle, revisar los datos del artículo");
        cont=0;
    }
  }




function agregarDetalleServicio(id,descripcion,codigo,valor)
  {
    var cantidad=0;
     if (id!="")
    {
        var total_fin;
        var contador=1;
        var fila='<tr class="filas" id="fila'+cont+'">'+
        '<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+(cont) +')">X</button></td>'+
        '<td>  <span name="numero_orden" id="numero_orden'+cont+'">'+conNO+'</span>'+
        '<input type="hidden" name="numero_orden_item[]" id="numero_orden_item[]" value="'+conNO+'" size="1" ></td>'+
        '<td><input type="hidden" name="idserviciobien[]" style="font-family: times, serif; font-size:10pt; font-style:italic" value="'+id+'">'+descripcion+''+
        '</br><textarea name="descdet[]" id="descdet[]" rows="5" cols="70"></textarea> </td>'+
        '<td><input type="hidden" name="codigo[]" id="codigo[]" value="'+codigo+'"><input type="hidden" name="cantidad[]" id="cantidad[]" value="1">'+codigo+'</td> <input type="text" name="codigo[]" id="codigo[]" value="'+codigo+'" class="form-control" size="4" style="display:none;">'+
        '<td><input type="text" class="form-control" name="valor_unitario[]" id="valor_unitario[]" value="'+valor+'"'+
        'onBlur="modificarSubototalesServicio()" size="5" onkeypress="return NumCheck2(event, this)" font-weight:bold;" onfocus="focusTest(this);" >'+
        '<input type="hidden" class="form-control" name="valor_unitario2[]" id="valor_unitario2[]"  value="'+valor+'" onfocus="focusTest(this);"  ><span name="tarifa" id="tarifa'+cont+'" style="display:none;"></span></td>'+
        '<td><span name="subtotal" id="subtotal'+cont+'" ></span>'+
        '<input type="hidden" name="igvvalorventa[]" id="igvvalorventa["'+cont+'"]">'+
        '<span name="igvG" id="igvG'+cont+'" style="background-color:#9fde90bf;display:none;"></span>'+
        '<input type="hidden" name="igvitem[]" id="igvitem["'+cont+'"]">'+
        '<span name="total" id="total'+cont+'" style="background-color:#9fde90bf; display:none;"></span>'+
        '<span name="pvu_" id="pvu_'+cont+'"  style="display:none"></span>'+
        '<input type="hidden" name="vuniitem[]" id="vuniitem["'+cont+'"]>'+
        '<input type="hidden" name="valorventa[]" id="valorventa["'+cont+'"]></td>'+
        '</tr>'
        var id = document.getElementsByName("idserviciobien[]");
        detalles=detalles+1;
        cont++;
        conNO++;
        $('#detallesservicio').append(fila);
        $("#myModalServ").modal('hide');
        modificarSubototalesServicio();
        setTimeout(function(){
        document.getElementById('descdet[]').focus();
        },400);
    
    }
    else
    {
        alert("Error al ingresar el detalle, revisar los datos del artículo");
        cont=0;
    }
  }


function tributocodnon()
{

$("#codigo_tributo_h").val($("#nombre_tributo_4_p").val());
$("#nombre_tributo_h").val($("#nombre_tributo_4_p option:selected").text());
//$(".filas").remove();
 //conNO=1;
    // $("#subtotal").html("0");
    // $("#subtotal_factura").val("");
    // $("#igv_").html("0");
    // $("#total_igv").val("");
    // $("#total").html("0");
    // $("#total_final").val("");
modificarSubototalesServicio();

}





    function modificarSubototalesServicio()
  {
    var noi = document.getElementsByName("numero_orden_item[]");
    var vuni = document.getElementsByName("valor_unitario2[]");
    var puni = document.getElementsByName("valor_unitario[]");
    var igv = document.getElementsByName("igvG");
    var sub = document.getElementsByName("subtotal");
    var tot = document.getElementsByName("total");
    var pvu = document.getElementsByName("pvu_");
    var tari = document.getElementsByName("tarifa");
    
     for (var i = 0; i <vuni.length; i++) {
        var inpNOI=noi[i];
        var inpVuni=vuni[i];
        var inpI=igv[i];
        var inpT=tot[i];
        var inpS=sub[i];
        var inpPVU=pvu[i];
        var inpPuni=puni[i];
        var inpTarifa=tari[i];

         
    if ($("#nombre_tributo_4_p").val()=='1000') {
         inpTarifa.value=inpTarifa.value;
         //inpPVU.value=inpPVU.value;
         inpPVU.value=inpPuni.value / (18/100+1); //Obtener valor unitario 
         document.getElementsByName("valor_unitario2[]")[i].value = redondeo(inpPVU.value,5); //Asignar valor unitario
         inpNOI.value=inpNOI.value; //Nro de orden
         inpI.value=inpI.value; 
         inpS.value=parseFloat(inpPuni.value) / (18/100+1); //Valor Unitario  / 1.18 para obtener el valor unitario
         //inpS.value= inpVuni.value;
         inpI.value= parseFloat(inpS.value) * 18/100;    
         inpIitem = inpPVU.value * 0.18;    
         inpT.value=inpS.value + inpI.value;
         inpTarifa.value=parseFloat(inpPuni.value);
        //document.getElementsByName("valor_unitario[]")[i].value = redondeo(inpPuni.value,5);


     }else{

         inpNOI.value=inpNOI.value; //Nro de orden
         inpI.value=inpI.value; 
         inpS.value=parseFloat(inpPuni.value); //Precio Unitario  
         inpI.value= 0;    
         inpIitem = 0;    
         inpT.value=inpS.value + inpI.value;
         inpTarifa.value=parseFloat(inpPuni.value);

     }

        document.getElementsByName("subtotal")[i].innerHTML = redondeo(inpS.value,2);
        document.getElementsByName("igvG")[i].innerHTML = redondeo(inpI.value,2);
        document.getElementsByName("total")[i].innerHTML = redondeo(inpT.value,2);
        document.getElementsByName("numero_orden")[i].innerHTML = inpNOI.value;
        document.getElementsByName("tarifa")[i].innerHTML = redondeo(inpTarifa.value,2);
        document.getElementsByName("pvu_")[i].innerHTML = redondeo(inpPVU.value,5);
        //Lineas abajo son para enviar el arreglo de inputs ocultos con los valor de IGV, Subtotal, y precio de venta
        //a la tala detalle_fact_art.
         document.getElementsByName("igvvalorventa[]")[i].value = redondeo(inpI.value,2);
         document.getElementsByName("igvitem[]")[i].value = redondeo(inpIitem,2);
        document.getElementsByName("vuniitem[]")[i].value = redondeo(inpPVU.value,5);
        document.getElementsByName("valorventa[]")[i].value = redondeo(inpS.value,2);
        //Fin de comentario

    }
    
    calcularTotalesServicio();
    }



   function calcularTotalesServicio(){
    var sub = document.getElementsByName("subtotal");
    var igv = document.getElementsByName("igvG");
    var tot = document.getElementsByName("total");
    var otros = $("#otross").val();

    var subtotal = 0.0;
    var total_igv=0.0;
    var total = 0.0;
    var noi=0;
    var tariT=0.0;

    for (var i = 0; i <sub.length; i++) {
        subtotal += document.getElementsByName("subtotal")[i].value;
        total_igv+=document.getElementsByName("igvG")[i].value;
        total+=document.getElementsByName("total")[i].value + parseFloat(otros);
        tariT+=document.getElementsByName("tarifa")[i].value;
    }


    
    $("#tarifaS").html(redondeo(tariT,2));
    $("#subtotal_servicio").html(number_format(redondeo(subtotal,2),2));
    $("#subtotal_doccobranza_servicio").val(redondeo(subtotal,2)); // a base de datos
    
    $("#igv_servicio").html(number_format(redondeo(total_igv,2),2));
    $("#total_igv_servicio").val(redondeo(total_igv,4)); // a base de datos

    //otros=parseFloat($("#otross").val());
    $("#total_servicio").html(number_format(redondeo(total,2),2));
    $("#total_final_servicio").val(redondeo(total,2) );

    evaluar();
  }




  function calcularTotalesProducto(){
    //var noi = document.getElementsByName("numero_orden_item");
    var sub = document.getElementsByName("subtotal");
    var igv = document.getElementsByName("igvG");
    var tot = document.getElementsByName("total");
    var pvu = document.getElementsByName("pvu_");
    var tariT = document.getElementsByName("tarifa");

    var subtotal = 0.0;
    var total_igv=0.0;
    var total = 0.0;
    var noi=0.0;
    var pvu=0.0;
    

    var tdcto=0.0;  

    for (var i = 0; i <sub.length; i++) {

        //noi+=document.getElementsByName("numero_orden_item")[i].value;
        subtotal += document.getElementsByName("subtotal")[i].value;
        total_igv+=document.getElementsByName("igvG")[i].value;
        total+=document.getElementsByName("total")[i].value;
        pvu+=document.getElementsByName("pvu_")[i].value;
       
    }


   
    
    $("#subtotal").html(redondeo(subtotal,2));
    $("#subtotal_doccobranza_producto").val(redondeo(subtotal,2)); // a base de datos
    
    $("#igv_").html(redondeo(total_igv,2));
    $("#total_igv_producto").val(redondeo(total_igv,4)); // a base de datos
    
    $("#total").html(number_format(redondeo(total,2),2));
    $("#total_final_producto").val(redondeo(total,2));
    $("#pre_v_u").val(redondeo(pvu,2));
    
    evaluar();
  }


  function modificarSubototalesProductos()
  {
    var noi = document.getElementsByName("numero_orden_item[]");
    var cant = document.getElementsByName("cantidad[]");
    var prec = document.getElementsByName("precio_unitario[]");
    var vuni = document.getElementsByName("valor_unitario2[]");
    var igv = document.getElementsByName("igvG");
    var sub = document.getElementsByName("subtotal");
    var tot = document.getElementsByName("total");
    var pvu = document.getElementsByName("pvu_");
    


     for (var i = 0; i <cant.length; i++) {
        var inpNOI=noi[i];
        var inpC=cant[i];
        var inpP=prec[i];
        var inpS=sub[i];
        var inpVuni=vuni[i];
        var inpI=igv[i];
    
        
        var inpT=tot[i];
        var inpPVU=pvu[i];
         inpC.value=inpC.value;
         inpPVU.value=inpP.value / ($iva/100+1); //Obtener valor unitario 
         document.getElementsByName("valor_unitario2[]")[i].value = redondeo(inpPVU.value,5); //Asignar valor unitario 
         inpNOI.value=inpNOI.value;
         inpI.value=inpI.value;
         inpS.value=(inpC.value * inpVuni.value);
         inpI.value= inpS.value * $iva/100;    
         inpIitem = inpPVU.value * $iva/100;    
         inpT.value=inpS.value + inpI.value;
    
        document.getElementsByName("subtotal")[i].innerHTML = redondeo(inpS.value,2);
        document.getElementsByName("igvG")[i].innerHTML = redondeo(inpI.value,2);
        document.getElementsByName("total")[i].innerHTML = redondeo(inpT.value,2);
        document.getElementsByName("pvu_")[i].innerHTML = redondeo(inpPVU.value,5);
        document.getElementsByName("numero_orden")[i].innerHTML = inpNOI.value;
        //Lineas abajo son para enviar el arreglo de inputs ocultos con los valor de IGV, Subtotal, y precio de venta
        //a la tala detalle_fact_art.
        document.getElementsByName("subtotalBD[]")[i].value = redondeo(inpS.value,2);
        document.getElementsByName("igvBD[]")[i].value = redondeo(inpIitem,2);
        document.getElementsByName("igvBD2[]")[i].value = redondeo(inpI.value,2);
        document.getElementsByName("pvt[]")[i].value = redondeo(inpPVU.value,5);
        //Fin de comentario
        
    }
    
    calcularTotalesProducto();
    }












 
  function evaluar(){
    if (detalles>0)
    {
      $("#btnGuardarDoccobranza").show();

    }
    else
    {
      $("#btnGuardarDoccobranza").hide(); 
      cont=0;
    }
  }

    function evaluar2(){
    if (detalles>0)
    {
      $("#btnGuardarDoccobranza").hide(); 
       cont=0;
    }
    
  }
 
  function eliminarDetalle(indice){
    $("#fila" + indice).remove();
    calcularTotalesServicio();
    detalles=detalles-1;
    conNO=conNO - 1;
    actualizanorden();
    evaluar()
  }

  // function eliminarDetalleservicios(indice){
  //   $("#fila" + indice).remove();
  //   calcularTotales();
  //   detalles=detalles-1;
  //   conNO=conNO - 1;
  //   actualizanorden();
  //   evaluar()
  // }


function redondeo(numero, decimales)
{
var flotante = parseFloat(numero);
var resultado = Math.round(flotante*Math.pow(10,decimales))/Math.pow(10,decimales);
return resultado;
}


function decimalAdjust(type, value, exp) {
    // Si el exp no está definido o es cero...
    if (typeof exp === 'undefined' || +exp === 0) {
      return Math[type](value);
    }
    value = +value;
    exp = +exp;
    // Si el valor no es un número o el exp no es un entero...
    if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0)) {
      return NaN;
    }
    // Shift
    value = value.toString().split('e');
    value = Math[type](+(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp)));
    // Shift back
    value = value.toString().split('e');
    return +(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp));

  // Decimal round
  if (!Math.round10) {
    Math.round10 = function(value, exp) {
      return decimalAdjust('round', value, exp);
    };
  }
  // Decimal floor
  if (!Math.floor10) {
    Math.floor10 = function(value, exp) {
      return decimalAdjust('floor', value, exp);
    };
  }
  // Decimal ceil
  if (!Math.ceil10) {
    Math.ceil10 = function(value, exp) {
      return decimalAdjust('ceil', value, exp);
    };
  }
}

function round(value, exp) {
  if (typeof exp === 'undefined' || +exp === 0)
    return Math.round(value);
  value = +value;
  exp  = +exp;

  if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0))
    return NaN;
  // Shift
  value = value.toString().split('e');
  value = Math.round(+(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp)));
  // Shift back
  value = value.toString().split('e');
  return +(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp));
}


//Función para el formato de los montos 
function number_format(amount, decimals) {

    amount += ''; // por si pasan un numero en vez de un string
    amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

    decimals = decimals || 0; // por si la variable no fue fue pasada

    // si no es un numero o es igual a cero retorno el mismo cero
    if (isNaN(amount) || amount === 0) 
        return parseFloat(0).toFixed(decimals);

    // si es mayor o menor que cero retorno el valor formateado como numero
    amount = '' + amount.toFixed(decimals);

    var amount_parts = amount.split('.'),
        regexp = /(\d+)(\d{3})/;

    while (regexp.test(amount_parts[0]))
        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

    return amount_parts.join('.');
}


function agregarClientexRuc(e)
  {
    //var data="";
    var documento=$("#numero_documento2").val();
    if(e.keyCode===13  && !e.shiftKey){
    $.post("../ajax/factura.php?op=listarClientesfacturaxDoc&doc="+documento, function(data,status)
    {
       data=JSON.parse(data);
       if (data != null){
       $('#idcliente').val(data.idpersona);
       $("#razon_social2").val(data.razon_social);
       $('#domicilio_fiscal2').val(data.domicilio_fiscal);
       $('#correocli').val(data.email);
       
       // if (data.email=="") {
       //      $('#correocli').css("background-color", "#FBC6AA");
       //      document.getElementById("correocli").focus();
       //  }
       //  else{
       //      document.getElementById("btnAgregarArt").style.backgroundColor= '#367fa9';
       //      document.getElementById("btnAgregarArt").focus();
       // }
       document.getElementById("correocli").focus();
       
        }else{

       $('#idcliente').val("");
       $("#razon_social2").val("No existe");
       $('#domicilio_fiscal2').val("No existe");
       alert("Cliente no registrado 99999");

       $("#ModalNcliente").modal('show');
       $("#nruc").val($("#numero_documento2").val());
       
        }
    });
 }


     if(e.keyCode===11 && !e.shiftKey){
        $.post("../ajax/factura.php?op=listarClientesfacturaxDoc&doc="+documento, function(data,status)
        {
       data=JSON.parse(data);
       $('#idcliente').val(data.idpersona);
       $("#razon_social2").val(data.razon_social);
       $('#domicilio_fiscal2').val(data.domicilio_fiscal);

        if (data.email=="") {
            $('#correocli').css("background-color", "#FBC6AA");
            document.getElementById("correocli").focus();
        }
        else{
            document.getElementById("btnAgregarArt").style.backgroundColor= '#367fa9';
            document.getElementById("btnAgregarArt").focus();
       }
       
        });
        //var boton = document.getElementById("btnAgregarArt");
        //angular.element(boton).triggerHandler('click');
        //document.getElementById("btnAgregarArt").style.backgroundColor= '#367fa9';
         }

}

// function agregarClientexRucChange()
//   {
//     var data="";
//     var documento=$("#numero_documento2").val();
   
//     $.post("../ajax/factura.php?op=listarClientesfacturaxDoc&doc="+documento, function(data,status)
//     {
//        data=JSON.parse(data);
//        if (data != null){
//        $('#idcliente').val(data.idpersona);
//        $("#razon_social2").val(data.razon_social);
//        $('#domicilio_fiscal2').val(data.domicilio_fiscal);
//        $('#correocli').val(data.email);
       
     
//        document.getElementById("correocli").focus();
       
//         }else{
//        $('#idcliente').val("");
//        $("#razon_social2").val("No existe");
//        $('#domicilio_fiscal2').val("No existe");
//        alert("Cliente no registrado");

       
//        $("#ModalNcliente").modal('show');
//        $("#nruc").val($("#numero_documento2").val());
       
//         }
//     });
 

//         if (data.email=="") {
//             $('#correocli').css("background-color", "#FBC6AA");
//             document.getElementById("correocli").focus();
//         }
//         else{
//             document.getElementById("btnAgregarArt").style.backgroundColor= '#367fa9';
//             document.getElementById("btnAgregarArt").focus();
//        }
       

       
// }


function actualizanorden()
{
var total = document.getElementsByName("numero_orden_item[]");
var contNO=0;
 for (var i = 0; i <= total.length; i++) {
        var contNO=total[i];
        contNO.value=i+1;
        
        //Lineas abajo son para enviar el arreglo de inputs con los valor de IGV, Subtotal, y precio de venta
        document.getElementsByName("numero_orden")[i].innerHTML = contNO.value;
        document.getElementsByName("numero_orden_item[]")[i].value = contNO.value;
        //Fin de comentario
    }//Final de for
}






function focusTest(el)
{
   el.select();
}



function stopRKey(evt) {
var evt = (evt) ? evt : ((event) ? event : null);
var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
}

//BLOQUEA ENTER 
document.onkeypress = stopRKey; 

function focusTest(el)
{
   el.select();
}



$(document).ready(function() {
    var table = $('#tbllistado').DataTable();
 
    $('#tbllistado tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            table.$('tr').removeClass('selected');
            $(this).addClass('selected');
        }
    } );

   $('#tbllistado').parents("tr").css("background-color","green") ;
   $('#button').click( function () {
        table.row('.selected').remove().draw( false );
    } );
} );


function focusRsocial(e, field)
{
if(e.keyCode===13  && !e.shiftKey)
    {
       document.getElementById('razon_social').focus();  
    }
 }

 function focusDomi(e, field)
{
if(e.keyCode===13  && !e.shiftKey)
    {
       document.getElementById('domicilio_fiscal').focus();  
    }
 }

  function focustel(e, field)
{
if(e.keyCode===13  && !e.shiftKey)
    {
       document.getElementById('telefono1').focus();  
    }
 }

//Foco para el input cantidad
function focusDescdet(e, field)
{
if(e.keyCode===13  && !e.shiftKey)
    {
       document.getElementById('cantidad[]').focus();  
    }
 }

function focusemail(e, field) {
    if(e.keyCode===13  && !e.shiftKey){
       document.getElementById('email').focus();  
    }
 }

 function focusguardar(e, field) {
    if(e.keyCode===13  && !e.shiftKey){
       document.getElementById('btnguardarncliente').focus();  
    }
 }

 function focusbotonarticulo(e, field) {
    if(e.keyCode===13  && !e.shiftKey){
         if ($('#correocli').val()=="") {
            $('#correocli').css("background-color", "#FBC6AA");
        }
            else
        {
                $('#correocli').css("background-color", "#FFFFFF");
                document.getElementById("btnAgregarArt").style.backgroundColor= '#367fa9';
                document.getElementById('btnAgregarArt').focus();  
        }
       
    }
 }

 function focusruccliente(){
document.getElementById('numero_documento2').focus();  
 }

 function redirecionescritorio()
 {

    window.location.replace("escritorio.php");
 }




 function seleccionTipoCot() //Para mostrar las tablas segun el tipo de doccobranza
 {
   var tipoC=$('#tipodoccobranza option:selected').val();
   var detallesproductoDIV = document.getElementById('detallesproductoDIV');
   var detallesservicioDIV = document.getElementById('detallesservicioDIV');
   var divproductos = document.getElementById('divproductos');
   var divservicios = document.getElementById('divservicios');

    switch (tipoC){
    case 'servicio':

    detallesservicioDIV.style.display='inline';
    detallesproductoDIV.style.display='none';
    divservicios.style.display='inline';
    divproductos.style.display='none';
     $(".filas").remove();
     cont=0;
        detalles=0;
      actualizanorden();
    evaluar();

    break;

    case 'producto':

    detallesservicioDIV.style.display='none';
    detallesproductoDIV.style.display='inline';
    divservicios.style.display='none';
    divproductos.style.display='inline';
     $(".filas").remove();
        cont=0;
        detalles=0;
      actualizanorden();
      evaluar();

    break;
}

}


     function cambiotipoDoc() //Para mostrar las tablas segun el tipo de doccobranza
 {
   var tipoC=$('#tipo_doc_cli option:selected').val();
   var divruc = document.getElementById('divruc');
   var divdni = document.getElementById('divdni');

    switch (tipoC){
    case 'dni':

    divdni.style.display='inline';
    document.getElementById('numero_documento_dni').focus();  
    divruc.style.display='none';

        $("#numero_documento_dni").val('');
       $('#idcliente').val('');
       $("#razon_social2").val('');
       $('#domicilio_fiscal2').val('');
       $('#correocli').val('');

    break;

    case 'ruc':

    divdni.style.display='none';
    divruc.style.display='inline';
    document.getElementById('numero_documento2').focus();  

        $("#numero_documento_dni").val('');
        $('#idcliente').val('');
       $("#razon_social2").val('');
       $('#domicilio_fiscal2').val('');
       $('#correocli').val('');

    break;


    default:

        }

 }


 function agregarClientexDni(e)
  {

  var dni=$("#numero_documento_dni").val();
    if(e.keyCode===13  && !e.shiftKey){

      $.post("../ajax/boleta.php?op=listarClientesboletaxDoc&doc="+dni, function(data,status)
      {
       data=JSON.parse(data);
       if (data != null){
       $('#idcliente').val(data.idpersona);
       $("#razon_social2").val(data.nombres+" "+data.apellidos);
       $('#domicilio_fiscal2').val(data.domicilio_fiscal);
       $('#correocli').val(data.correo);
        
        }else{ 
       
    var urls = "../ajax/boleta.php?op=consultaDniSunat&nrodni="+dni;
    $.ajax({ 
    type:'POST',
    url:urls,
    dataType:'json',
    success: function(data){ 
      var datos = eval(data);
      if (datos!=null) {
        $('#idcliente').val("N");
        $('#razon_social2').val(data.nombre);
        $("#domicilio_fiscal2").val("");
        document.getElementById('domicilio_fiscal2').focus();
      }else{
       $('#idcliente').val("N");
       $("#razon_social2").val("");
       document.getElementById("razon_social2").placeholder="No Registrado";
       $("#domicilio_fiscal2").val("");
       document.getElementById("domicilio_fiscal2").placeholder="No Registrado";
       document.getElementById('razon_social2').style.Color= '#35770c'; 
       document.getElementById('razon_social2').focus(); 

      }
      }
      });


      } // fin else
      }); 

    }// Fin de enter

        }



function nuevafactura(idcobranza, mm)
        {
        bootbox.confirm("¿Está Seguro de generar nueva factura?", function(result){
        if(result) 
        {
             
             incrementariniciofactura(idcobranza);
             //incrementarNumfactura();
            $("#myModalnfac").modal('show');
        }
    })
}









function incrementariniciofactura(idcobranza)
{
        $.post("../ajax/factura.php?op=selectSerie", function(r)
        {
        $("#seriefactura").html(r);
        //$("#serie").selectpicker('refresh');
        var serieL=document.getElementById('seriefactura');
        var opt = serieL.value;
        $.post("../ajax/factura.php?op=autonumeracion&ser="+opt+'&idempresa=1', function(r){
       var n2=pad(r,0);
       $("#numero_factura").val(n2);
       var SerieReal = $("#seriefactura option:selected").text();
        $("#SerieRealfactura").val(SerieReal);
        });

         $.post("../ajax/doccobranza.php?op=traerdcobranza&iddco="+idcobranza, function(data,status){
        data=JSON.parse(data);
        if (data!=null) {
        //$("#fecha_emision_factura").prop("disabled",false);
        $('#fechadc').val(data.fechaemi);
        $('#horaf').val(data.hora);
        $("#tipo_moneda_factura").val(data.moneda);
        $("#tcambiofactura").val(data.tcambio);
        $("#numero_documento_factura").val(data.ruc);
        $("#razon_socialnfactura").val(data.nombre_comercial);
        $("#correocliente").val(data.email);
        $("#domicilionfactura").val(data.domicilio_fiscal);
        $("#condicionnfactura").val(data.condicion);

        $("#idclientef").val(data.idpersona);
        $("#tipodocucli").val(data.tipo_documento);

            }
            });

        $.post("../ajax/doccobranza.php?op=listarDetalledc&id="+idcobranza,function(r){
             $("#detallefactura").html(r);
        });


        })


       
    }


function incrementarNumfactura()
{
    var serie=$("#seriefactura option:selected").val();
    $.post("../ajax/factura.php?op=autonumeracion&ser="+serie+'&idempresa=1', function(r){

       var n2=pad(r,0);
       //var n2=r;
       $("#numero_factura").val(n2);

       var SerieReal = $("#seriefactura option:selected").text();
        $("#SerieRealfactura").val(SerieReal);
    });
}


function guardaryeditarnuevafactura(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
    
     sw=0;

   var mensaje=confirm("¿Desea emitir la factura?");
   if (mensaje){
   //========================================================     
  // capturarhora();
    var formData = new FormData($("#formularionfactura")[0]);
    $.ajax({
        url: "../ajax/factura.php?op=guardaryeditarfacturadc",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos)
        {     
               
              bootbox.alert(datos);
              mostrarultimocomprobante();
              mostrarform(false);
              //listar();
              refrescartabla();
        }
        
    });     
           limpiar();
           //mostrarultimocomprobante();
   //========================================================
            sw=0;

       }

    }

    function mostrarultimocomprobante()
{

$.post("../ajax/factura.php?op=mostrarultimocomprobante", function(data,status)
    {
       data=JSON.parse(data);
       if (data != null) 
       {
        $("#idultimocom").val(data.numeracion_08);
        }else{
        $("#idultimocom").val("");    
        }
             
              $("#myModalnfac").modal("hide");
              $("#modalPreview").modal("show");
              //$("#ultimocomprobante").val(data.numeracion_08);
              document.getElementById("ultimocomprobante").innerHTML = data.numeracion_08;
              document.getElementById("ultimocomprobantecorreo").innerHTML = data.email;
              document.getElementById('estadofact').style.background='white';   
              document.getElementById("estadofact").style.color='black';
              document.getElementById("estadofact").innerHTML = "Documento Emitido";
    }); // codigo igual hasta aqui.
}


function preticket()
{
$.post("../ajax/factura.php?op=mostrarultimocomprobanteId", function(data,status)
    {
       data=JSON.parse(data);
       if (data != null) 
       {
        $("#idultimocom").val(data.idfactura);
        }else{
        $("#idultimocom").val("");    
        }
              var rutacarpeta='../reportes/exTicketFactura.php?id='+data.idfactura;
              $("#modalCom").attr('src',rutacarpeta);
              $("#modalPreview2").modal("show");
    }); // codigo igual hasta aqui.
            
}


function preticket2(idfactura)
{

              var rutacarpeta='../reportes/exTicketFactura.php?id='+idfactura;
              $("#modalCom").attr('src',rutacarpeta);
              $("#modalPreview2").modal("show");
            
}


function prea42copias()
{
$.post("../ajax/factura.php?op=mostrarultimocomprobanteId", function(data,status)
    {
       data=JSON.parse(data);
       if (data != null) 
       {
        $("#idultimocom").val(data.idfactura);
        }else{
        $("#idultimocom").val("");    
        }
              var rutacarpeta='../reportes/exFactura.php?id='+data.idfactura;
              $("#modalCom").attr('src',rutacarpeta);

              $("#modalPreview2").modal("show");
    }); // codigo igual hasta aqui.
            
}


function prea42copias2(idfactura)
{
              var rutacarpeta='../reportes/exFactura.php?id='+idfactura;
              $("#modalCom").attr('src',rutacarpeta);
              $("#modalPreview2").modal("show");
            
}


function prea4completo()
{
$.post("../ajax/factura.php?op=mostrarultimocomprobanteId", function(data,status)
    {
       data=JSON.parse(data);
       if (data != null) 
       {
        $("#idultimocom").val(data.idfactura);
        }else{
        $("#idultimocom").val("");    
        }
              var rutacarpeta='../reportes/exFacturaCompleto.php?id='+data.idfactura;
              $("#modalCom").attr('src',rutacarpeta);
              $("#modalPreview2").modal("show");
    }); // codigo igual hasta aqui.
            
}


function prea4completo2(idfactura)
{
              var rutacarpeta='../reportes/exFacturaCompleto.php?id='+idfactura;
              $("#modalCom").attr('src',rutacarpeta);
              $("#modalPreview2").modal("show");
            
}




function tipodecambiosunat()
{
    if ($("#tipo_moneda").val()=="USD") {
    fechatcf=$("#fecha_emision").val();
    $.post("../ajax/factura.php?op=tcambiog&feccf="+fechatcf, function(data, status)
    {
     data=JSON.parse(data);
     $("#tcambio").val(data.venta);
    });
    }else{
       $("#tcambio").val("0"); 
    }
}


function contadocredito()
  {
    opttp=$("#tipopago").val();
    var x = document.getElementById("tipopagodiv");
    if (opttp=="Credito")
    {
        x.style.display = "block";
        $("#ccuotas").val("1");
        focusnroreferencia();
        
    }else{
        x.style.display = "none";
        $("#montocuota").val("0");
        $("#ccuotas").val("0");
        //focusnroreferencia();
        document.getElementById("divmontocuotas").innerHTML="";
        document.getElementById("divfechaspago").innerHTML="";
        document.getElementById("ccuotas").readOnly = false; 
    }

  }


  function focusnroreferencia()
{
    countmes=30;
    ncuota= $("#ccuotas").val();
    totalcompCu=$("#total_final_factura").val();
    document.getElementById("totalcomp").innerHTML = "TOTAL COMPROBANTE "+totalcompCu;
        $("#modalcuotas").modal("show");
        toFi=$("#total_final_factura").val();
        for (var i=1; i<=ncuota; i++)
        {

    countmes=countmes + 30;
    fechahoy = new Date();
    dia = fechahoy.getDate();
    mes = ("0" + fechahoy.getMonth() + 1).slice(-2);// +1 porque los meses empiezan en 0
    anio = fechahoy.getFullYear();
    fechahoy.setDate(fechahoy.getDate() + countmes);
    today=fechahoy.getFullYear() + "-" + ("0"+fechahoy.getMonth()).slice(-2) + "-" + ("0"+fechahoy.getDate()).slice(-2);

        var input = document.createElement("input");
        input.setAttribute('type', 'text');
        input.setAttribute('id', 'montocuotacre[]');
        input.setAttribute('name', 'montocuotacre[]');
        input.setAttribute('size', '4');
        input.setAttribute('value', (toFi/ncuota).toFixed(2));
        var parent = document.getElementById("divmontocuotas");
        parent.appendChild(input);

        var input = document.createElement("input");
        input.setAttribute('type', 'hidden');
        input.setAttribute('id', 'ncuotahiden[]');
        input.setAttribute('name', 'ncuotahiden[]');
        input.setAttribute('value', i);
        var parent = document.getElementById("divmontocuotas");
        parent.appendChild(input);

        var date = document.createElement("input");
        date.setAttribute('type', 'date');
        date.setAttribute('id', 'fechapago[]');
        date.setAttribute('name', 'fechapago[]');
        input.setAttribute('size', '4');
        date.setAttribute('value', today);
        var parent = document.getElementById("divfechaspago");
        parent.appendChild(date);

        document.getElementById("ccuotas").readOnly = true; 

        }

    }


    function borrarcuotas()
{

$("#ccuotas").val("");
document.getElementById("divmontocuotas").innerHTML="";
document.getElementById("divfechaspago").innerHTML="";
document.getElementById("ccuotas").readOnly = false; 


}









init();
