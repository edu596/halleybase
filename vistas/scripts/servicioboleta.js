var tabla;
var tablaArti;
$idempresa=$("#idempresa").val();
$iva=$("#iva").val();
//Función que se ejecuta al inicio
function init(){

   

    $("#razon_social").val("VARIOS");
    $("#numero_documento").val("VARIOS");
    
 
    $("#formulario").on("submit",function(e)
    {
        guardaryeditarBoleta(e);  
        
    });

    $("#formularioncliente").on("submit",function(e)
    {
        guardaryeditarcliente(e);  
    });



// Carga de combo para vendedores =====================
    $.post("../ajax/vendedorsitio.php?op=selectVendedorsitio&idempresa="+$idempresa, function(r){
            $("#vendedorsitio").html(r);
            $('#vendedorsitio').selectpicker('refresh');
    });
// Carga de combo para vendedores ======================

// Carga tipo de cambio =====================
    $.post("../ajax/factura.php?op=tcambiodia", function(r){
            $("#tcambio").val(r);
    });
    
     cont=0;
     conNO=1;

    mostrarform(false);
    listar();

}

let count = 0;
//let counter = setInterval(timer,10000);

function timer()
{
    count++;
    tabla.ajax.reload(null,false);
} 

let onOff = true;

function pause(){
    if (!onOff) {
        onOff=true;
        clearInterval(counter);
    }else{
        onOff=false;
        counter=setInterval(timer, 5000);
    }
    
}


function guardaryeditarcliente(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
    //$("#btnGuardarcliente").prop("disabled",true);
    var formData = new FormData($("#formularioncliente")[0]);

    $.ajax({
        url: "../ajax/persona.php?op=guardaryeditarNclienteBoleta",
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


function agregarClientexRucNuevo()
  {
        
    $.post("../ajax/factura.php?op=listarClientesfacturaxDocNuevos", function(data,status)
    {
      data=JSON.parse(data);
       
       if (data != null){
       $('#numero_documento').val(data.numero_documento);
       $('#idcliente').val(data.idpersona);
       $("#razon_social").val(data.razon_social);
       $('#domicilio_fiscal').val(data.domicilio_fiscal);
       $('#tipo_documento_cliente').val(data.tipo_documento);
       document.getElementById("btnAgregarArt").style.backgroundColor= '#367fa9';
       document.getElementById("btnAgregarArt").focus();
        }else{
       $('#idcliente').val("");
       $("#razon_social").val("No existe");
       $('#domicilio_fiscal').val("No existe");
       $('#tipo_documento_cliente').val("");
       document.getElementById("btnAgregarArt").style.backgroundColor= '#35770c';     
       document.getElementById("btnAgregarCli").focus();     
       
        }
        
    });


}

function limpiarcliente(){
 //NUEVO CLIENTE
    
    $("#numero_documento3").val("");
    $("#razon_social3").val("");
    $("#domicilio_fiscal3").val("");
    $("#iddepartamento").val("");
    $("#idciudad").val("");
    $("#iddistrito").val("");
    $("#telefono1").val("");
    $("#email").val("");
    $("#nruc").val("");
    $("#numero_documento3").val("");
//=========================
}


function tributocodnon()
{

$("#codigo_tributo_h").val($("#codigo_tributo_18_3").val());
$("#nombre_tributo_h").val($("#codigo_tributo_18_3 option:selected").text());
$(".filas").remove();
 conNO=1;
 $("#subtotal").html("0");
    $("#subtotal_factura").val("");
    $("#igv_").html("0");
    $("#total_igv").val("");
    $("#total").html("0");
    $("#total_final").val("");
}

function incremetarNum(){
    var serie=$("#serie option:selected").val();
    $.post("../ajax/boleta.php?op=autonumeracion&ser="+serie+'&idempresa='+$idempresa, function(r){

       var n2=pad(r,0);
       $("#numero_servicio").val(n2);

       var SerieReal = $("#serie option:selected").text();
        $("#SerieReal").val(SerieReal);
    });
    document.getElementById('tipo_doc_ide').focus(); 
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
    $("#domicilio_fiscal").val("");
    $("#numero_guia").val("");

    $("#cliente").val("");
    $("#numero_documento").val("");
    //$("#serie").val("");
    $("#numero_servicio").val("");
    $("#impuesto").val("0");
    $(".filas").remove();

    $("#subtotal").html("0");
    $("#subtotal_boleta").val("");
    $("#igv_").html("0");
    $("#total_igv").val("");
    $("#total").html("0");
    $("#total_final").val("");
    $("#pre_v_u").val("");
    $("#guia_remision_29_2").val("");
    $("#correocli").val("");
    $("#numero_documento2").focus();
 
 	$("#tipo_doc_ide").val("0");
      //pARA CARGAR el id del cliente varios
        $.post("../ajax/persona.php?op=mostrarClienteVarios", function(data,status)
        {
       data=JSON.parse(data);
       $('#idcliente').val(data.idpersona);
       $("#numero_documento").val(data.numero_documento);
       $("#razon_social").val(data.razon_social);
       $("#domicilio_fiscal").val(data.domicilio_fiscal);
        });


    //Obtenemos la fecha actual
    $("#fecha_emision").prop("disabled",false);
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fecha_emision').val(today);

    document.getElementById("Titulo").style.color="#000000";
    document.getElementById("CuadroT").style.color="#000000";
    
    cont=0;
    conNO=1;
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
        listarServicios();
        //listarClientes();
 
        $("#btnGuardar").hide();
        $("#btnCancelar").show();
        $("#btnAgregarArt").show();
        $("#btnAgregarCli").hide();

        $.post("../ajax/boleta.php?op=selectSerie", function(r)
        {
        $("#serie").html(r);
        //$("#serie").selectpicker('refresh');

        var serieL=document.getElementById('serie');
        var opt = serieL.value;
        $.post("../ajax/boleta.php?op=autonumeracion&ser="+opt+'&idempresa='+$idempresa, function(r){

       var n2=pad(r,0);
       $("#numero_servicio").val(n2);

       var SerieReal = $("#serie option:selected").text();
        $("#SerieReal").val(SerieReal);
        });

        });

           //alert("SELECCIONE SU USUARIO");

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

    var mensaje=confirm("¿Desea cancelar Boleta?")

    if (mensaje){
    limpiar();
    evaluar2();
    detalles=0;
    mostrarform(false);

    }
    
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
                    url: '../ajax/servicioboleta.php?op=listar&idempresa='+$idempresa,
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

       
 }
 
//Función ListarClientes
function listarClientes()
{
    tabla=$('#tblaclientes').dataTable(
    {
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [                
                     
                ],
        "ajax":
                {
                    url: '../ajax/boleta.php?op=listarClientesboleta',
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
} 


//Función listarServicios
function listarServicios()
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
                    url: '../ajax/servicioboleta.php?op=listarArticulosservicio&idempresa='+$idempresa,
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

    $('#tblarticulos').DataTable().ajax.reload();
}


//Función para guardar o editar
 
function guardaryeditarBoleta(e)
{
  e.preventDefault(); //No se activará la acción predeterminada del evento
   
    var idpersona =  $('#idcliente').val();
    sw=0;
     var mensaje=confirm("¿Desea emitir la boleta de servicio?");
    if (mensaje){

   //========================================================     
   capturarhora();
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../ajax/servicioboleta.php?op=guardaryeditarservicio",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos)
        {                    
              bootbox.alert(datos);           
              mostrarform(false);
              listar();
        }
    });
    limpiar();
    $("#numero_documento").val("");
    $("#razon_social").val("");
    $("#domicilio_fiscal").val("");
    
    //========================================================
             sw=0;
        }
    }



function actualizarNum(e){

var numero = $("#numero_servicio").val();
var idnumeracion=$("#serie option:selected").val();
$.post("../ajax/boleta.php?op=actualizarNumero&Num="+numero+"&Idnumeracion="+idnumeracion, function(r){
});
}

 
function mostrar(idboleta)
{
    $.post("../ajax/boleta.php?op=mostrar",{idboleta : idboleta}, function(data, status)
    {
        data = JSON.parse(data);        
        mostrarform(true);
 
        $("#idboleta").val(data.idboleta);

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
 
     $.post("../ajax/boleta.php?op=listarDetalle&id="+idfactura,function(r){
             $("#detalles").html(r);
     }); 
}
 

function mayus(e) {
     e.value = e.value.toUpperCase();
}


function baja(idboleta)
{

    var f=new Date();
    cad=f.getHours()+":"+f.getMinutes()+":"+f.getSeconds(); 

    bootbox.prompt({
    title: "Escriba el motivo de baja de la boleta.",
    inputType: 'textarea',
    callback: function (result) {
        if(result)
        {
            $.post("../ajax/servicioboleta.php?op=baja&comentario="+result+"&hora="+cad, {idboleta : idboleta}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            }); 
        }
    }

});
}




function accesoTicket(idboleta)
{
    

    var f=new Date();
    cad=f.getHours()+":"+f.getMinutes()+":"+f.getSeconds(); 

    bootbox.prompt({
    title: "Escriba el nro de ticket.",
    inputType: 'textarea',
    callback: function (result) {
        if(result)
        {
            $.post("../ajax/boleta.php?op=baja&comentario="+result+"&hora="+cad, {idboleta : idboleta}, function(e){
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
$("#btnGuardar").hide();
$("#tipo_comprobante").change(marcarImpuesto);
//$("#tipo_comprobante").change(Correlativo);
 
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


function agregarCliente(idpersona,razon_social,numero_documento,domicilio_fiscal, tipo_documento)
  {
    
     if (idpersona!="")
    {
        $('#idcliente').val(idpersona);
        $('#numero_documento').val(numero_documento);
        $('#razon_social').val(razon_social);
        $('#domicilio_fiscal').val(domicilio_fiscal);
        $('#tipo_documento_cliente').val(tipo_documento);
        $("#myModalCli").modal('hide');
    }
    else
    {
        alert("Error al ingresar el detalle, revisar los datos del cliente");
    }
  }

  //Función para aceptar solo numeros con dos decimales
  function NumCheck(e, field) {
      // Backspace = 8, Enter = 13, ’0′ = 48, ’9′ = 57, ‘.’ = 46
  key = e.keyCode ? e.keyCode : e.which

  if(e.keyCode===13  && !e.shiftKey)
    {
       document.getElementById('precio_unitario[]').focus();  
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

 //Función para aceptar solo numeros con dos decimales
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


            
 function agregarDetalle(id,descripcion,codigo,valor)
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
        '<td><input type="hidden" name="codigo[]" id="codigo[]" value="'+codigo+'">'+codigo+'</td> <input type="text" name="codigo[]" id="codigo[]" value="'+codigo+'" class="form-control" size="4" style="display:none;">'+

        '<td><input type="text" class="form-control" name="valor_unitario[]" id="valor_unitario[]" value="'+number_format(redondeo(valor,2),2)+'"'+
        'onBlur="modificarSubototales()"  onkeypress="return NumCheck2(event, this)" font-weight:bold;" >'+
        '<input type="hidden" class="form-control" name="valor_unitario2[]" id="valor_unitario2[]"  value="'+valor+'" ></td>'+
        
        '<td><span name="subtotal" id="subtotal'+cont+'" style="display:none;"></span>'+
        '<input type="hidden" name="subtotalBD[]" id="subtotalBD["'+cont+'"]"></td>'+

        '<td><span name="igvG" id="igvG'+cont+'" style="background-color:#9fde90bf;display:none;"></span>'+
        '<input type="hidden" name="igvBD[]" id="igvBD["'+cont+'"]"><input type="hidden" name="igvBD2[]" id="igvBD2["'+cont+'"]"></td>'+

        '<td><span name="total" id="total'+cont+'" style="background-color:#9fde90bf; display:none;" ></td>'+
        '<span name="pvu_" id="pvu_'+cont+'"  style="display:none"  ></span> '+
        '<input  type="hidden" name="pvt[]" id="pvt["'+cont+'"] size="2"></td>'+
        '</tr>'
        var idser = document.getElementsByName("idserviciobien[]");

        //  for (var i = 0; i < idser.length; i++) {
        //     var idA=idser[i];
           
        // if (idA.value==id) { 
        // alert("Ya esta ingresado el articulo!");
        // fila="";
        // cont=cont - 1;
        // conNO=conNO -1;
        // }else{
        // detalles=detalles;
        // }} //PARA VALIDACION SI YA ESTA INGRESADO EL ITEM


        detalles=detalles+1;
        cont++;
        conNO++;
       
        $('#detalles').append(fila);
       
        $("#myModalArt").modal('hide');

        modificarSubototales();
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



  
    
  function modificarSubototales()
  {
    var noi = document.getElementsByName("numero_orden_item[]");
    var vuni = document.getElementsByName("valor_unitario2[]");
    var puni = document.getElementsByName("valor_unitario[]");
    var igv = document.getElementsByName("igvG");
    var sub = document.getElementsByName("subtotal");
    var tot = document.getElementsByName("total");
    var pvu = document.getElementsByName("pvu_");
    

     for (var i = 0; i <vuni.length; i++) {
        var inpNOI=noi[i];
        var inpVuni=vuni[i];
        var inpI=igv[i];
        var inpT=tot[i];
        var inpS=sub[i];
        var inpPVU=pvu[i];
        var inpPuni=puni[i];
            
         //inpPVU.value=inpVuni.value;

         inpNOI.value=inpNOI.value; //Nro de orden
         inpI.value=inpI.value; 

         inpS.value=inpPuni.value / ($iva/100+1); //Valor Unitario  / 1.18 para obtener el valor unitario
         inpI.value= inpS.value * $iva/100;    
         inpIitem = inpPuni.value * $iva/100;    
         inpT.value=inpS.value + inpI.value;
        
        document.getElementsByName("subtotal")[i].innerHTML = redondeo(inpS.value,2);
        document.getElementsByName("igvG")[i].innerHTML = redondeo(inpI.value,2);
        document.getElementsByName("total")[i].innerHTML = redondeo(inpT.value,2);
        

        document.getElementsByName("numero_orden")[i].innerHTML = inpNOI.value;


        //Lineas abajo son para enviar el arreglo de inputs ocultos con los valor de IGV, Subtotal, y precio de venta
        //a la tala detalle_fact_art.
         document.getElementsByName("subtotalBD[]")[i].value = redondeo(inpS.value,2);
         document.getElementsByName("igvBD[]")[i].value = redondeo(inpIitem,2);
         document.getElementsByName("igvBD2[]")[i].value = redondeo(inpI.value,2);
        document.getElementsByName("pvt[]")[i].value = redondeo(inpS.value,5);
        //Fin de comentario

        
        //document.getElementsByName("valor_unitario2[]")[i].value = redondeo(inpS.value,5);

//     bootbox.alert("Aviso, la cantidad supera al stock actual");

    }
    
    calcularTotales();
    }


  function calcularTotales(){
    //var noi = document.getElementsByName("numero_orden_item");
    var sub = document.getElementsByName("subtotal");
    var igv = document.getElementsByName("igvG");
    var tot = document.getElementsByName("total");
    //var pvu = document.getElementsByName("pvu_");

    var subtotal = 0.0;
    var total_igv=0.0;
    var total = 0.0;
    var noi=0;
    //var pvu=0.0;

    for (var i = 0; i <sub.length; i++) {

        //noi+=document.getElementsByName("numero_orden_item")[i].value;
        subtotal += document.getElementsByName("subtotal")[i].value;
        total_igv+=document.getElementsByName("igvG")[i].value;
        total+=document.getElementsByName("total")[i].value;
        //pvu+=document.getElementsByName("pvu_")[i].value;

    }


    $("#subtotal").html(number_format(redondeo(subtotal,2),2));
    $("#subtotal_boleta").val(redondeo(subtotal,2)); // a base de datos
    
    $("#igv_").html(number_format(redondeo(total_igv,2),2));
    $("#total_igv").val(redondeo(total_igv,4)); // a base de datos
    
    $("#total").html(number_format(redondeo(total,2),2));
    $("#total_final").val(redondeo(total,2));
    //$("#pre_v_u").val(redondeo(pvu,2));
    
    evaluar();
  }
 
  function evaluar(){
    if (detalles>0)
    {
    $("#btnGuardar").show();
    mayor700();
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

  function mayor700(){
      //=============================================
        var total = $("#total_final").val();
        if(total >=700){

        if ( $("#tipo_doc_ide").val() != '1' ) {
        $("#numero_documento").val("");
        document.getElementById("numero_documento").placeholder = "Ingresar DNI";
        document.getElementById("numero_documento").focus();
        $("#razon_social").val("");
        document.getElementById("razon_social").placeholder = "Ingresar Razón Social";
        $("#domicilio_fiscal").val("");
        document.getElementById("domicilio_fiscal").placeholder = "Ingresar domicilio";
        }
        
        $("#tipo_doc_ide").val("1");

        document.getElementById("CuadroT").style.color="#E82C0C";
        document.getElementById("Titulo").style.color="#E82C0C";
        document.getElementById("mensaje700").style.display='inline';
        }
        else // si no es mayor a 700
        {
        document.getElementById("mensaje700").style.display='none';
        document.getElementById("Titulo").style.color="#000000";
        document.getElementById("CuadroT").style.color="#000000";
        
        }
        //=============================================
  }

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







function focusI(){
var tipo=$("#tipo_doc_ide option:selected").val();

if (tipo=="0"){

$.post("../ajax/persona.php?op=mostrarClienteVarios", function(data,status)
    {
       data=JSON.parse(data);
       $('#idcliente').val(data.idpersona);
       $("#numero_documento").val(data.numero_documento)
       $("#razon_social").val(data.razon_social)
       $("#domicilio_fiscal").val(data.domicilio_fiscal)
   });


//document.getElementById('numero_documento').focus(); 
}


if (tipo=='1'){
$("#numero_documento").val("")
$("#razon_social").val("")
$("#domicilio_fiscal").val("")
document.getElementById('numero_documento').focus(); 
document.getElementById('numero_documento').maxLength =8; 
}

if (tipo=='4'){
$("#numero_documento").val("")
$("#razon_social").val("")
$("#domicilio_fiscal").val("")
document.getElementById('numero_documento').focus(); 
document.getElementById('numero_documento').maxLength =15; 
}

if (tipo=='7'){
$("#numero_documento").val("")
$("#razon_social").val("")
$("#domicilio_fiscal").val("")
document.getElementById('numero_documento').focus(); 
document.getElementById('numero_documento').maxLength =15; 
}

if (tipo=='A'){
$("#numero_documento").val("")
$("#razon_social").val("")
$("#domicilio_fiscal").val("")
document.getElementById('numero_documento').focus(); 
document.getElementById('numero_documento').maxLength =15; 
}

if (tipo=='6'){
$("#numero_documento").val("")
$("#razon_social").val("")
$("#domicilio_fiscal").val("")
document.getElementById('numero_documento').focus(); 
document.getElementById('numero_documento').maxLength =11; 
}


}


function agregarClientexDoc(e)
  {
   
var dni=$("#numero_documento").val();
    if(e.keyCode===13  && !e.shiftKey){
      $.post("../ajax/boleta.php?op=listarClientesboletaxDoc&doc="+dni, function(data,status)
      {
       data=JSON.parse(data);
       if (data != null){
       $('#idcliente').val(data.idpersona);
       $("#razon_social").val(data.nombres);
       $('#domicilio_fiscal').val(data.domicilio_fiscal);
       document.getElementById("btnAgregarArt").style.backgroundColor= '#367fa9';
       document.getElementById("mensaje700").style.display='none';
       document.getElementById('btnAgregarArt').focus(); 
        

        }else if($('#tipo_doc_ide').val()=='1') {  // SI ES DNI

      //   var dni=$("#numero_documento").val();
      //   var url = '../ajax/consulta_reniec.php';
      //   $.ajax({ 
      //   type:'POST',
      //   url:url,
      //   data:'dni='+dni,
      //   success: function(datos_dni){ 
      // var datos = eval(datos_dni);
      // if (datos!=null) {
      //   $('#idcliente').val("N");
      //   $('#razon_social').val(datos[1]+" "+datos[2]+" "+datos[3]);
      //   $("#domicilio_fiscal").val("");
      //   document.getElementById('domicilio_fiscal').focus(); 
      //      }
      //      else
      //      {
            $('#idcliente').val("N");
            document.getElementById('razon_social').focus(); 
            //}
     // }});

      } 
      else if($('#tipo_doc_ide').val()=='6')  // SI ES RUC
      {

    var dni=$("#numero_documento").val();
    $.post("../ajax/factura.php?op=listarClientesfacturaxDoc&doc="+dni, function(data,status)
    {
       data=JSON.parse(data);
       if (data != null){
       $('#idcliente').val(data.idpersona);
       $("#razon_social").val(data.razon_social);
       $('#domicilio_fiscal').val(data.domicilio_fiscal);
        }else{
       $('#idcliente').val("");
       $("#razon_social").val("No registrado");
       $('#domicilio_fiscal').val("No registrado");
       alert("Cliente no registrado");
       $("#ModalNcliente").modal('show');
       $("#nruc").val($("#numero_documento").val());
       
        }
    });
 

      }else{

       $('#idcliente').val("N");
       $("#razon_social").val("");
       document.getElementById("razon_social").placeholder="No Registrado";
       $("#domicilio_fiscal").val("");
       document.getElementById("domicilio_fiscal").placeholder="No Registrado";
       document.getElementById("btnAgregarArt").style.backgroundColor= '#35770c';     
       document.getElementById('razon_social').style.Color= '#35770c'; 
       document.getElementById('razon_social').focus(); 

       }});
      
    }

}




//Función para anular registros
function enviarcorreo(idboleta)
{
    bootbox.confirm("¿Está Seguro de enviar correo al cliente?", function(result){
        if(result)
        {
            $.post("../ajax/boleta.php?op=enviarcorreo", {idboleta : idboleta}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            }); 
        }
    })
}




function mayus(e) {
    e.value = e.value.toUpperCase();
}

function focusDir(e)
{
    if(e.keyCode===13  && !e.shiftKey){
       document.getElementById('domicilio_fiscal').focus();  
    }
}

function agregarArt(e)
{
    if(e.keyCode===13  && !e.shiftKey){
       document.getElementById("btnAgregarArt").focus();     
    }
}

function focusAgrArt(e)
{
    if(e.keyCode===13  && !e.shiftKey){
       document.getElementById('btnAgregarArt').focus();  
       document.getElementById("btnAgregarArt").style.backgroundColor= '#35770c';
    }
}

function focusTdoc()
{
    document.getElementById('tipo_doc_ide').focus();  
}

function stopRKey(evt) {
var evt = (evt) ? evt : ((event) ? event : null);
var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
}


//PARA ELIMINAR ENTER
document.onkeypress = stopRKey; 

function capturarhora(){ 
var f=new Date();
cad=f.getHours()+":"+f.getMinutes()+":"+f.getSeconds(); 
$("#hora").val(cad);
}


function actualizanorden(){
var total = document.getElementsByName("numero_orden_item_29[]");

for (var i = 0; i <=total.length; i++) {
        //var contNO=total[i];
        var contNO=total[i];
        contNO.value=i+1;
        
        //Lineas abajo son para enviar el arreglo de inputs con los valor de IGV, Subtotal, y precio de venta
        document.getElementsByName("numero_orden")[i].innerHTML = contNO.value;
        document.getElementsByName("numero_orden_item_29[]")[i].value = contNO.value;
        //Fin de comentario
    }//Final de for
}

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


//Foco para el input cantidad
function focusDescdet(e, field)
{
if(e.keyCode===13  && !e.shiftKey)
    {
       document.getElementById('cantidad_item_12[]').focus();  
    }
 }


function redirecionescritorio()
 {
    window.location.replace("escritorio.php");
 }


 //Función para dar de baja registros
function downFtp(idboleta)
{
 bootbox.confirm("¿Está Seguro de descargar la boleta de servicio?", function(result){
        if(result)
        {
            $.post("../ajax/servicioboleta.php?op=downFtp", {idboleta : idboleta}, function(e)
            {
            data = JSON.parse(e);
            //bootbox.alert('<a href="'+data.cabext+'" download=" '+data.cab+'">" ARCHIVO CABECERA: '+data.cab+'"</a> <br/><br/> <a href="'+data.detext+'" download="'+data.det+'">" ARCHIVO DETALLE: '+data.det+'"</a> <br/><br/> <a href="'+data.leyext+'" download="'+data.ley+'">" ARCHIVO LEYENDA: '+data.ley+'"</a> <br/><br/> <a href="'+data.triext+'" download="'+data.tri+'">" ARCHIVO TRIBUTO: '+data.tri+'"</a> ');
            bootbox.alert('<a href="'+data.cabext+'" download=" '+data.cab+'">" ARCHIVO JSON:   '+data.cab+'"</a>');
            }); 
        }
    })
}



function refrescartabla()
{
tabla.ajax.reload();
}


function agregarClientexDoc2()
  {
   var dni=$("#numero_documento").val();
    
      $.post("../ajax/boleta.php?op=listarClientesboletaxDoc&doc="+dni, function(data,status)
      {
       data=JSON.parse(data);
       if (data != null){
       $('#idcliente').val(data.idpersona);
       $("#razon_social").val(data.nombres);
       $('#domicilio_fiscal').val(data.domicilio_fiscal);
       document.getElementById("btnAgregarArt").style.backgroundColor= '#367fa9';
       document.getElementById("mensaje700").style.display='none';
       document.getElementById('btnAgregarArt').focus(); 
        

        }else if($('#tipo_doc_ide').val()=='1') { 
      //  var dni=$("#numero_documento").val();
      //   var url = '../ajax/consulta_reniec.php';
      //   $.ajax({ 
      //   type:'POST',
      //   url:url,
      //   data:'dni='+dni,
      //   success: function(datos_dni){ 
      // var datos = eval(datos_dni);
      // if (datos!=null) {
         $('#idcliente').val("N");
         document.getElementById('razon_social').focus(); 
      //   $('#razon_social').val(datos[1]+" "+datos[2]+" "+datos[3]);
      //   $("#domicilio_fiscal").val("");
      //   document.getElementById('domicilio_fiscal').focus(); 
      //      }
      // }});


      }
        else if($('#tipo_doc_ide').val()=='6')  // SI ES RUC
      {

    var dni=$("#numero_documento").val();
    $.post("../ajax/factura.php?op=listarClientesfacturaxDoc&doc="+dni, function(data,status)
    {
       data=JSON.parse(data);
       if (data != null){
       $('#idcliente').val(data.idpersona);
       $("#razon_social").val(data.razon_social);
       $('#domicilio_fiscal').val(data.domicilio_fiscal);
        }else{
       $('#idcliente').val("");
       $("#razon_social").val("Registrar");
       $('#domicilio_fiscal').val("Registrar");
       alert("Cliente no registrado");
       //$("#ModalNcliente").modal('show');
       //$("#nruc").val($("#numero_documento2").val());
       
        }
    });

      }else{

       $('#idcliente').val("N");
       $("#razon_social").val("");
       document.getElementById("razon_social").placeholder="No Registrado";
       $("#domicilio_fiscal").val("");
       document.getElementById("domicilio_fiscal").placeholder="No Registrado";
       document.getElementById("btnAgregarArt").style.backgroundColor= '#35770c';     
       document.getElementById('razon_social').style.Color= '#35770c'; 
       document.getElementById('razon_social').focus(); 

       }});
      
    

}

init();
