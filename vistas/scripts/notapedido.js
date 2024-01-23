var tabla;
var tablaArti;
$idempresa=$("#idempresa").val(); 


toastr.options = {
                closeButton: false,
                debug: false,
                newestOnTop: false,
                progressBar: false,
                rtl: false,
                positionClass: 'toast-bottom-center',
                preventDuplicates: false,
                onclick: null
            };


//Función que se ejecuta al inicio
function init(){

     

    $("#razon_social").val("VARIOS");
    $("#numero_documento").val("VARIOS");
    
 
    $("#formulario").on("submit",function(e)
    {
        guardaryeditarBoleta(e);  
        
    });


    $("#formularionarticulo").on("submit",function(e)
    {
        guardaryeditararticulo(e);  
    });



// Carga de combo para vendedores =====================
    $.post("../ajax/vendedorsitio.php?op=selectVendedorsitio&idempresa="+$idempresa, function(r){
            $("#vendedorsitio").html(r);
            $('#vendedorsitio').selectpicker('refresh');
    });
// Carga de combo para vendedores ======================

  $.post("../ajax/notapedido.php?op=selectAlmacen", function(r){
            $("#almacenlista").html(r);
            $('#almacenlista').selectpicker('refresh');
    });
    
     cont=0;
     cont2=0;
     conNO=1;
     conNO2=1;
     detalles=0;
     detalles2=0;


     $.post("../ajax/articulo.php?op=selectAlmacen&idempresa="+$idempresa, function(r){
              $("#idalmacennarticulo").html(r);
              $('#idalmacennarticulo').selectpicker('refresh');

  });


  $.post("../ajax/articulo.php?op=selectFamilia", function(r){
              $("#idfamilianarticulo").html(r);
              $('#idfamilianarticulo').selectpicker('refresh');
  });


  $.post("../ajax/factura.php?op=selectunidadmedidanuevopro", function(r){
            $("#umedidanp").html(r);
            $('#umedidanp').selectpicker('refresh');
    });




    mostrarform(false);
    listar();
}


function incremetarNum(){
    var serie=$("#serie option:selected").val();
    $.post("../ajax/notapedido.php?op=autonumeracion&ser="+serie, function(r){

       var n2=pad(r,0);
       $("#numero_boleta").val(n2);

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

        document.getElementById("tiponota").disabled = false;
        document.getElementById("fecha_emision_01").disabled = false;
        document.getElementById("tipo_moneda_24").disabled = false;
        document.getElementById("tipo_doc_ide").disabled = false;
        document.getElementById("numero_documento").disabled = false;
        document.getElementById("razon_social").disabled = false;
        document.getElementById("domicilio_fiscal").disabled = false;


    $("#idcliente").val("N");
    $("#idboleta").val("");
    $("#numero_guia").val("");
    $("#cliente").val("");
    $("#numero_boleta").val("");
    $("#impuesto").val("0");
 
    $("#total_boleta").val("");
    $(".filas").remove();
    $(".filas2").remove();
    $("#total").html("0");
    $("#numero_documento").val("");
    document.getElementById("mensaje700").style.display='none';

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
    
    $("#total").val("");
    $("#total_final").val("");
    $("#faltante").val("0.00");
    $("#adelanto").val("0.00");

    $("#estadonota").val("1");
 
    //Obtenemos la fecha actual
    $("#fecha_emision_01").prop("disabled",false);
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fecha_emision_01').val(today);

    document.getElementById("Titulo").style.color="#000000";
    document.getElementById("CuadroT").style.color="#000000";
    //document.getElementById('codigob').focus();  
    
    cont=0;
    conNO=1;
    conNO2=1;
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
        //listarClientes();
        document.getElementById('codigob').focus();  
 
        $("#btnGuardar").hide();
        $("#btnCancelar").show();
        $("#btnAgregarArt").show();
        $("#btnAgregarCli").hide();

        $.post("../ajax/notapedido.php?op=selectSerie", function(r)
        {
        $("#serie").html(r);
        //$("#serie").selectpicker('refresh');

        var serieL=document.getElementById('serie');
        var opt = serieL.value;
        $.post("../ajax/notapedido.php?op=autonumeracion&ser="+opt, function(r){

       var n2=pad(r,0);
       $("#numero_boleta").val(n2);

       var SerieReal = $("#serie option:selected").text();
        $("#SerieReal").val(SerieReal);
        });

        });

        

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

    var mensaje=confirm("¿Desea cancelar Nota de pedido?")

    if (mensaje){
    limpiar();
    evaluar2();
    detalles=0;
    detalles2=0;
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
                    url: '../ajax/notapedido.php?op=listar',
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

        // setInterval( function () {
        // tabla.ajax.reload(null, false);
        // }, 10000 );
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
                    url: '../ajax/notapedido.php?op=listarClientesboleta',
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


//Función ListarArticulos
function listarArticulos()
{   
    tpn=$('#tiponota').val();
    $tipoprecio=$('#tipoprecio').val(); 
    $iteno=$('#itemno').val(); 
    almacen=$('#almacenlista').val(); 
    tablaArti=$('#tblarticulos').dataTable(

    {

        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "searching": true,

        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [                

                ],
        "ajax":

                {

                    url: '../ajax/notapedido.php?op=listarArticulonota&tprecio='+$tipoprecio+'&tb='+tpn+'&itm='+$iteno+'&alm='+almacen,
                    type : "get",
                    dataType : "json",                      
                    error: function(e){
                    console.log(e.responseText);    
                    }
                },

                //Para cambiar el color del stock cuando es 0
                "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    if ( aData[5] == "0.00" )
                    {
                        $('td', nRow).css('background-color', '#fd96a9');
                    }
                    else 
                    {
                        $('td', nRow).css('background-color', '');

                    }
                },

        

        "bDestroy": true,
        "iDisplayLength": 5,//Paginación
        "order": [[ 2, "desc" ]]//Ordenar (columna,orden)
    }).DataTable();
    $('div.dataTables_filter input').focus() // PARA PONER INPUT FOCUS 
    
    $('#tblarticulos').DataTable().ajax.reload();
   $("#tblarticulos [type='search']").focus(); 

}



//Función para guardar o editar
 
function guardaryeditarBoleta(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento

    var cant = document.getElementsByName("cantidad_item_12[]");
    var prec = document.getElementsByName("precio_unitario[]");
    var stk = document.getElementsByName("stock[]");

      var idct=$("#idcotizacion").val();

     sw=0;
     for (var i = 0; i <cant.length; i++) {
        
        var inpC=cant[i];
        var inpP=prec[i];
        var inStk=stk[i];
            
        if (inpP.value==0.00 || inpP.value=="" || inpC.value==0 || inStk.value==0 || $('#numero_boleta').val()=="" ){
           sw=sw+1;
           
        }   
        } 

        if(sw!=0){
            alert("Revizar précio!, cantidad o Stock");
            inpP.focus();
        }else{

    var mensaje=confirm("¿Desea emitir la nota de pedido?");
    if (mensaje){

    //========================================================
    capturarhora();
    var formData = new FormData($("#formulario")[0]);
    $.ajax({
        url: "../ajax/notapedido.php?op=guardaryeditarBoleta",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos)
        {                    
              bootbox.alert(datos);           
              tipoimpresion();
              mostrarform(false);
              listar();
              listarComprobantesClientes(); 
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

}


function tipoimpresion()

{




$.post("../ajax/notapedido.php?op=mostrarultimocomprobanteId", function(data,status)
    {
       data=JSON.parse(data);
       if (data != null) 
       {

        $("#idultimocom").val(data.idboleta);
        }else{
        $("#idultimocom").val("");    
        }
       
        if(data.tipoimpresion=='00'){

          var rutacarpeta='../reportes/exNotapedidoTicket.php?id='+data.idboleta;
              $("#modalCom").attr('src',rutacarpeta);
              $("#modalPreviewXml").modal("show");

        }else if(data.tipoimpresion=='01'){
             var rutacarpeta='../reportes/exNotapedido.php?id='+data.idboleta;
              $("#modalCom").attr('src',rutacarpeta);
              $("#modalPreviewXml").modal("show");

        }else{

          var rutacarpeta='../reportes/exNotapedidocompleto.php?id='+data.idboleta;
              $("#modalCom").attr('src',rutacarpeta);
              $("#modalPreview2").modal("show");


        }
    });



}







function actualizarNum(e){

var numero = $("#numero_boleta").val();
var idnumeracion=$("#serie option:selected").val();
$.post("../ajax/notapedido.php?op=actualizarNumero&Num="+numero+"&Idnumeracion="+idnumeracion, function(r){
});
}

 
function mostrar(idboleta)
{
    $.post("../ajax/notapedido.php?op=mostrar",{idboleta : idboleta}, function(data, status)
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
 
//Función para anular registros
function anular(idboleta)
{
    bootbox.confirm("¿Está Seguro de anular la Nota de pedido?", function(result){
        if(result)
        {
            $.post("../ajax/notapedido.php?op=anular", {idboleta : idboleta}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            }); 
        }
    })
}

function mayus(e) {
     e.value = e.value.toUpperCase();
}


function baja(idboleta)
{

    var f=new Date();
    cad=f.getHours()+":"+f.getMinutes()+":"+f.getSeconds(); 

    bootbox.prompt({
    title: "Escriba el motivo de baja de la Nota.",
    inputType: 'textarea',
    callback: function (result) {
        if(result)
        {
            $.post("../ajax/notapedido.php?op=baja&comentario="+result+"&hora="+cad, {idboleta : idboleta}, function(e){
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
            $.post("../ajax/notapedido.php?op=baja&comentario="+result+"&hora="+cad, {idboleta : idboleta}, function(e){
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


            
  function agregarDetalle(
    idarticulo,
    familia,
    codigo_proveedor,
    codigo,
    nombre,
    precio_factura,
    stock,
    unidad_medida, 
    precio_unitario,
    factorconversion, 
    factorc)
  {

    var cantidad=0;

      nrofila=($("#contaedit").val());
        if (nrofila=="") {
            //cont=0;
            conNO=1;
        }else{
            cont=parseFloat(nrofila);
            conNO=parseFloat(conNO)+parseFloat(nrofila); 
        }


    
     if (idarticulo!="")
    {
        var subtotal=cantidad*precio_factura;
        var igv= subtotal * 0.18;
        //var pvu = document.getElementsByName("pvu_");
        var total_fin;
        var contador=1;
        var fila='<tr class="filas" id="fila'+cont+'">'+
        '<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+(cont) +')">X</button></td>'+

        //'<td><input type="text" class="" name="numero_orden[]" id="numero_orden[]" value="'+(cont + 1)+'" size="1" disabled="true" >'+
        '<td><span name="numero_orden" id="numero_orden'+cont+'" ></span>'+
        '<input type="hidden" name="numero_orden_item_29[]" id="numero_orden_item_29[]" value="'+conNO+'"  ></td>'+

        '<td><input type="hidden" name="idarticulo[]" style="font-family: times, serif; font-size:14pt; font-style:italic" value="'+idarticulo+'">'+nombre+'</td>'+
        '<td><input type="text" class="" name="descdet[]" id="descdet[]" onkeyup="mayus(this)" onkeypress="return focusDescdet(event, this)"></td>'+
        '<td><input type="text"  class="" required="true" name="cantidad_item_12[]" id="cantidad_item_12[]" value="1" onBlur="modificarSubototales()" onkeypress="return NumCheck(event, this)" ></td>'+
        
        
        '<td><input type="hidden" name="unidad_medida[]" id="unidad_medida[]" value="'+unidad_medida+'">'+unidad_medida+'</td>'+
        '<td><input type="text" class="" name="precio_unitario[]" id="precio_unitario[]" value="'+precio_factura+'" onBlur="modificarSubototales()" size="7" onkeypress="return NumCheck2(event, this)" OnFocus="focusTest(this); return false;"  ></td>'+
        '<td><input type="text" class="" name="stock[]" id="stock[]" value="'+stock+'" disabled="true" size="7"></td>'+
        
        '<td><span name="subtotal" id="subtotal'+cont+'" ></span>'+
        '<input type="hidden"  class="" name="subtotalBD[]" id="subtotalBD["'+cont+'"]" onBlur="modificarSubototales()" value="0.00">'+
        '<span name="igvG" id="igvG'+cont+'" style="background-color:#9fde90bf; display:none;"></span>'+
        '<input type="hidden" name="igvBD[]" id="igvBD["'+cont+'"]"><input type="hidden" name="igvBD2[]" id="igvBD2["'+cont+'"]">'+

        '<span name="total" id="total'+cont+'" style="background-color:#9fde90bf; display:none;" ></span>'+

        '<span name="pvu_" id="pvu_'+cont+'"  style="display:none"></span>'+

        '<input type="hidden"  class="" required="true" name="factorc[]" id="factorc[]"   value="'+factorc+'">'+
        '<input type="hidden"  class="" required="true" name="cantidadreal[]" id="cantidadreal[]" >'+
        
        '<input  type="hidden" name="vvu[]" id="vvu["'+cont+'"] size="2"></td>'+
        '</tr>'
        var id = document.getElementsByName("idarticulo[]");
        var can = document.getElementsByName("cantidad_item_12[]");

        

        for (var i = 0; i < id.length; i++) {
            var idA=id[i];
            var cantiS=can[i];
        if (idA.value==idarticulo) { 
        //alert("Ya esta ingresado el articulo!");
        cantiS.value=parseFloat(cantiS.value) + 1;
        fila="";
        cont=cont - 1;
        conNO=conNO -1;
        }else{
        detalles=detalles;
        }}

        detalles=detalles+1;
        if (nrofila=="") {
        cont++;
        conNO++;
        }
      
        $('#detalles').append(fila);




        document.getElementById('numero_documento').focus();
        modificarSubototales();
        actualizanorden();
        toastr.success('Agregado al detalle '+nombre);
        //$("#myModalArt").modal('hide');

        //para foco
        setTimeout(function(){
        document.getElementById('cantidad_item_12[]').focus();
        //$('#cantidad').focus();
        },400);

        //$('#tblarticulos').DataTable().ajax.reload();
        $('input[type=search]').val('');

    }
    else
    {
        alert("Error al ingresar el detalle, revisar los datos del artículo");
        cont=0;
    }
  
  }




  function agregarArticuloxCodigo(e)
  {

    var codigob=$("#codigob").val();
    
    if(e.keyCode===13  && !e.shiftKey){
    $.post("../ajax/notapedido.php?op=listarArticulosboletaxcodigo&codigob="+codigob, function(data,status)
    {
        data=JSON.parse(data);
       
       if (data != null){
        if (data.stock=="0.00") { 
            alert("El stock es 0!");
            $('#codigob').val("");
            }else{
        var contador=1;
        var fila='<tr class="filas" id="fila'+cont+'">'+
        '<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+(cont) +')">X</button></td>'+

        //'<td><input type="text" class="" name="numero_orden[]" id="numero_orden[]" value="'+(cont + 1)+'" size="1" disabled="true" >'+
        '<td><span name="numero_orden" id="numero_orden'+cont+'" ></span>'+
        '<input type="hidden" name="numero_orden_item_29[]" id="numero_orden_item_29[]" value="'+conNO+'"  ></td>'+

        '<td><input type="hidden" name="idarticulo[]" style="font-family: times, serif; font-size:14pt; font-style:italic" value="'+data.idarticulo+'">'+data.nombre+'</td>'+
        '<td><input type="text" class="" name="descdet[]" id="descdet[]" onkeyup="mayus(this)" onkeypress="return focusDescdet(event, this)"></td>'+
        '<td><input type="text"  class="" required="true" name="cantidad_item_12[]" id="cantidad_item_12[]" onBlur="modificarSubototales()"  onkeypress="return NumCheck(event, this)" value="1"></td>'+
        '<td><input type="hidden" name="codigo_proveedor[]" id="codigo_proveedor[]" value="'+data.codigo_proveedor+'">'+data.codigo_proveedor+'</td>'+
        '<td><input type="text" name="codigo[]" id="codigo[]" value="'+data.codigo+'" class="" style="display:none;" ></td>'+
        '<td><input type="hidden" name="unidad_medida[]" id="unidad_medida[]" value="'+data.abre+'">'+data.nombreum+'</td>'+
        '<td><input type="text" class="" name="precio_unitario[]" id="precio_unitario[]" value="'+data.precio_venta+'" onBlur="modificarSubototales()" size="7" onkeypress="return NumCheck2(event, this)" OnFocus="focusTest(this); return false;"  ></td>'+
        '<td><input type="text" class="" name="stock[]" id="stock[]" value="'+data.stock+'" disabled="true" size="7"></td>'+
        
        '<td><span name="subtotal" id="subtotal'+cont+'"  style="display:none;"></span>'+
        '<input type="hidden"  class="" name="subtotalBD[]" id="subtotalBD["'+cont+'"]" onBlur="modificarSubototales()" value="0.00">'+
        '<span name="igvG" id="igvG'+cont+'" style="background-color:#9fde90bf; display:none;"></span>'+
        '<input type="hidden" name="igvBD[]" id="igvBD["'+cont+'"]"><input type="hidden" name="igvBD2[]" id="igvBD2["'+cont+'"]">'+
        '<span name="total" id="total'+cont+'" display:none;" ></span>'+
        '<span name="pvu_" id="pvu_'+cont+'"  style="display:none"></span>'+
        '<input type="hidden"  class="" required="true" name="factorc[]" id="factorc[]" value="'+data.factorc+'">'+
        '<input type="hidden"  class="" required="true" name="cantidadreal[]" id="cantidadreal[]" >'+
        '<input  type="hidden" name="vvu[]" id="vvu["'+cont+'"] size="2"></td>'

        var id = document.getElementsByName("idarticulo[]");
         var can = document.getElementsByName("cantidad_item_12[]");
         
        for (var i = 0; i < id.length; i++) {
            var idA=id[i];
            var cantiS=can[i];
        if (idA.value==data.idarticulo) { 
            cantiS.value=parseFloat(cantiS.value) + 1;
        //alert("Ya esta ingresado el articulo!");
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
        document.getElementById('numero_documento').focus();
        $("#myModalArt").modal('hide');

        //para foco
        $('#codigob').val("");
       document.getElementById("codigob").focus();
       modificarSubototales();

        
            }
        }
        else
        {
       alert("No existe");
       document.getElementById("btnAgregarArt").style.backgroundColor= '#35770c';     
       document.getElementById("codigob").focus();     
       
        }
        //if (data.stock<=8) { alert("El stock esta al limite, verificar!");}
    });
    }
}

    
  function modificarSubototales()
  {
    var noi = document.getElementsByName("numero_orden_item_29[]");
    var cant = document.getElementsByName("cantidad_item_12[]");
    var prec = document.getElementsByName("precio_unitario[]");
    var st = document.getElementsByName("stock[]");
    var stbd = document.getElementsByName("subtotalBD[]");
    var igv = document.getElementsByName("igvG");
    var sub = document.getElementsByName("subtotal");
    var tot = document.getElementsByName("total");
    var fecha = document.getElementsByName("fecha[]");
    var totaldeuda = document.getElementsByName("totaldeuda");
    var tcomp = document.getElementsByName("totalcomp[]");
    var pvu = document.getElementsByName("pvu_");

    var factorc = document.getElementsByName("factorc[]");
    var cantiRe = document.getElementsByName("cantidadreal[]");


    var adelanto = $("#adelanto");
    var faltante = $("#faltante");



     for (var i = 0; i <cant.length; i++) {
        var inpNOI=noi[i];
        var inpC=cant[i];
        var inpP=prec[i];
        var inpS=sub[i];
        var inpI=igv[i];

        var inpT=tot[i];
        var inpPVU=pvu[i];
        var inStk=st[i];
        var inSTbd=stbd[i];

        var factorcc=factorc[i];
        var inpCantiR=cantiRe[i];
            
        inStk.value=inStk.value;
        inSTbd.value=inSTbd.value;
        inpS.value=inpS.value;
        
         //Validar cantidad no sobrepase stock actual
         if(parseFloat(inpC.value) > parseFloat(inStk.value)){

            bootbox.alert("Mensaje, La cantidad supera al stock.");
            }
            else
            {

         inpNOI.value=inpNOI.value;
         inpI.value=inpI.value;
         inpS.value=parseFloat(inpP.value) * inpC.value;
         inpI.value=0.00;    
         inpT.value=inpS.value;// + parseFloat(inpT2.value);
         inpPVU.value=0.00;
         inpIitem = 0.00;
         inpCantiR.value= (inStk.value / factorcc.value)  - ((inStk.value - inpC.value) / factorcc.value);     
         

        document.getElementsByName("subtotalBD[]")[i].value = redondeo(inpS.value,2);
        document.getElementsByName("subtotal")[i].innerHTML = redondeo(inpS.value,2);
        document.getElementsByName("igvG")[i].innerHTML = redondeo(inpI.value,4);
        document.getElementsByName("total")[i].innerHTML = redondeo(inpT.value,2);
        document.getElementsByName("pvu_")[i].innerHTML = redondeo(inpPVU.value,5);

        document.getElementsByName("numero_orden")[i].innerHTML = inpNOI.value;

        //Lineas abajo son para enviar el arreglo de inputs con los valor de IGV, Subtotal, y precio de venta
        //a la tala detalle_fact_art.
        //document.getElementsByName("subtotalBD[]")[i].value = redondeo(inpS.value,2);
        document.getElementsByName("igvBD[]")[i].value = redondeo(inpT.value,4);
        document.getElementsByName("igvBD2[]")[i].value = redondeo(inpT,4);
        document.getElementsByName("vvu[]")[i].value = redondeo(inpT.value,5);
        //Fin de comentario

        }//Final de if

        if(inpP.value==0){
        inpP.style.backgroundColor= '#ffa69e';
        //document.getElementById("precio_unitario[]").style.backgroundColor= '#ffa69e';
        }else{
        inpP.style.backgroundColor= '#fffbfe';
        //document.getElementById("precio_unitario[]").style.backgroundColor= '#fffbfe';
            }

             if(inpC.value==0){
        inpC.style.backgroundColor= '#ffa69e';
        //document.getElementById("precio_unitario[]").style.backgroundColor= '#ffa69e';
        }else{
        inpC.style.backgroundColor= '#fffbfe';
        //document.getElementById("precio_unitario[]").style.backgroundColor= '#fffbfe';
            }

            if(inStk.value==0){
        inStk.style.backgroundColor= '#ffa69e';
        //document.getElementById("precio_unitario[]").style.backgroundColor= '#ffa69e';
        }else{
        inStk.style.backgroundColor= '#fffbfe';
        //document.getElementById("precio_unitario[]").style.backgroundColor= '#fffbfe';
            }

    }//Final de for

      
      for (var i = 0; i < fecha.length; i++) {
      var totalD=totaldeuda[i];
      var totCom=tcomp[i];
      //var totalD2=totaldeuda2[i];
      totalD.value=parseFloat(totCom.value);
      //totalD2.value=10;
      document.getElementsByName("totaldeuda")[i].innerHTML = redondeo(totalD.value,2);
      }


    calcularTotales();
    
}


  function calcularTotales()
  {
    //var noi = document.getElementsByName("numero_orden_item");
    var sub = document.getElementsByName("subtotal");
    var igv = document.getElementsByName("igvG");
    var tot = document.getElementsByName("total");
    var tot2 = document.getElementsByName("totaldeuda");
    var pvu = document.getElementsByName("pvu_");

    var subtotal = 0.0;
    var total_igv=0.0;
    var total = 0.0;
    var totaldeuda = 0.0;
    var noi=0;
    var pvu=0.0;
    //var adelan=number_format($("#adelanto").val(),2);
    //var faltan=number_format($("#faltante").val(),2);

    var adelan=$("#adelanto").val();
    var faltan=$("#faltante").val();


    for (var i = 0; i <sub.length; i++) {
        //noi+=document.getElementsByName("numero_orden_item")[i].value;
        subtotal += document.getElementsByName("subtotal")[i].value;
        total_igv+=document.getElementsByName("igvG")[i].value;
        total+=document.getElementsByName("total")[i].value;
        pvu+=document.getElementsByName("pvu_")[i].value;
    }

        for (var i = 0; i <tot2.length; i++) {
          totaldeuda+=document.getElementsByName("totaldeuda")[i].value;
        }

        faltan=subtotal - parseFloat(adelan);
        porceade=(adelan/subtotal)*100
        document.getElementById('porade').innerHTML = number_format(porceade,2) +" %";
        porcfalt=(faltan/subtotal)*100
        document.getElementById('porfalt').innerHTML = number_format(porcfalt,2) +" %";
    //Para validar si el monto es >= a 700 y poder agregar los datos del cliente.
    var botonE=document.getElementById("btnAgregarCli");

   //botonE.disabled=true;        
    $("#subtotal_boleta").val(redondeo(subtotal,2));
    $("#total_igv").val(redondeo(total_igv,2));
    $("#total").html(number_format(redondeo(subtotal,2),2));

    //$("#adelanto").val(redondeo(subtotal,2));
    $("#faltante").val(faltan);
    $("#total_final").val(redondeo(adelan,2));
    $("#total_d").html(number_format(redondeo(faltan,2),2));
    
    $("#total_g").html(number_format(redondeo(adelan,2),2));
    
    $("#pre_v_u").val(redondeo(pvu,2));

    evaluar();
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


 
  function eliminarDetalle(indice)
  {
    $("#fila" + indice).remove();
    calcularTotales();
    detalles=detalles-1;
    conNO=conNO - 1;
    actualizanorden();
    evaluar()
  }





  function eliminarDetalleP(indice)
  {
    $("#fila" + indice).remove();
    calcularTotales();
    detalles2=detalles2-1;
    conNO2=conNO2 - 1;
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
    
        
       //  $("#tipo_doc_ide").val("0");
       //  $.post("../ajax/persona.php?op=mostrarClienteVarios", function(data,status)
       //  {
       // data=JSON.parse(data);
       // $('#idcliente').val(data.idpersona);
       // $("#numero_documento").val(data.numero_documento)
       // $("#razon_social").val(data.razon_social)
       // $("#domicilio_fiscal").val(data.domicilio_fiscal)
       // });
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


}


function agregarClientexDoc(e)
  {
    

 var dni=$("#numero_documento").val();

    if(e.keyCode===13  && !e.shiftKey){
        $("#razon_social").val("");
        $('#domicilio_fiscal').val("");

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
                $('#suggestions').fadeOut();
                $('#suggestions2').fadeOut();
                $('#suggestions3').fadeOut();

        }else if($('#tipo_doc_ide').val()=='1') {  // SI ES DNI
                $("#razon_social").val("");
                $('#domicilio_fiscal').val("");
                var dni=$("#numero_documento").val();
                //var url = '../ajax/consulta_reniec.php';
                $.post("../ajax/boleta.php?op=consultaDniSunat&nrodni="+dni, function(data,status)
                    {
                      data=JSON.parse(data);
                    if (data != null){
                      
                      document.getElementById('razon_social').focus(); 
                      $('#idcliente').val("N");
                      //$("#numero_documento3").val(data.numeroDocumento);
                      $('#razon_social').val(data.nombre);
                     }else{
                      alert(data);
                      document.getElementById('razon_social').focus(); 
                      $('#idcliente').val("N");
                     }
             });       
                $('#suggestions').fadeOut();
                $('#suggestions2').fadeOut();
                $('#suggestions3').fadeOut();


      } 
      else if($('#tipo_doc_ide').val()=='6')  // SI ES RUC
      {
                $("#razon_social").val("");
                $('#domicilio_fiscal').val("");
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
                $('#suggestions').fadeOut();
                $('#suggestions2').fadeOut();
                $('#suggestions3').fadeOut();
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


function agregarClientexDoc2()
  {
    var dni=$("#numero_documento").val();
    $("#razon_social").val("");
        $('#domicilio_fiscal').val("");

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
                $('#suggestions').fadeOut();
                $('#suggestions2').fadeOut();
                $('#suggestions3').fadeOut();

        }else if($('#tipo_doc_ide').val()=='1') {  // SI ES DNI
                $("#razon_social").val("");
                $('#domicilio_fiscal').val("");
                var dni=$("#numero_documento").val();
                //var url = '../ajax/consulta_reniec.php';
                $.post("../ajax/boleta.php?op=consultaDniSunat&nrodni="+dni, function(data,status)
                    {
                      data=JSON.parse(data);
                    if (data != null){
                      document.getElementById('razon_social').focus(); 
                      $('#idcliente').val("N");
                      //$("#numero_documento3").val(data.numeroDocumento);
                      $('#razon_social').val(data.nombre);
                     }else{
                      alert(data);
                      document.getElementById('razon_social').focus(); 
                      $('#idcliente').val("N");
                     }
             });       
                $('#suggestions').fadeOut();
                $('#suggestions2').fadeOut();
                $('#suggestions3').fadeOut();


      } 
      else if($('#tipo_doc_ide').val()=='6')  // SI ES RUC
      {
                $("#razon_social").val("");
                $('#domicilio_fiscal').val("");
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
                $('#suggestions').fadeOut();
                $('#suggestions2').fadeOut();
                $('#suggestions3').fadeOut();
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

//Función para anular registros
function enviarcorreo(idboleta)
{
    bootbox.confirm("¿Está Seguro de enviar correo al cliente?", function(result){
        if(result)
        {
            $.post("../ajax/notapedido.php?op=enviarcorreo", {idboleta : idboleta}, function(e){
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
        //contNO="";
        var contNO=total[i];
        contNO.value=i+1;
        
        //Lineas abajo son para enviar el arreglo de inputs con los valor de IGV, Subtotal, y precio de venta
        document.getElementsByName("numero_orden")[i].innerHTML = contNO.value;
        document.getElementsByName("numero_orden_item_29[]")[i].value = contNO.value;
        //Fin de comentario
    }//Final de for
}


function actualizanordenP(){
var total = document.getElementsByName("fecha[]");

for (var i = 0; i <=total.length; i++) {
        //var contNO=total[i];
        var contNO2=total[i];
        contNO2.value=i+1;
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


function listarComprobantesClientes()
{
  $dnicliente=$("#numero_documento").val();
    tablaArti=$('#detallesClientesEstado').dataTable(
    {
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [                 ],
        "ajax":
                {
                    url: '../ajax/notapedido.php?op=listarcomprobantesclientesEstado&dnicliente='+$dnicliente,
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
  $('#detallesClientesEstado').DataTable().ajax.reload();
}



 function agregarClientesComprobantes(idnota, fecha, cliente, nroserie, total, estado)
  {
    $est="";
    var cantidad=0;
     if (idnota!="")
    {
        var contador=1;
        var fila2='<tr class="filas2" id="fila2'+cont2+'">'+
        '<td><a onclick="eliminarDetalleComprobante('+(cont2) +')" style="color:red;">X</a>'+
        '<input type="hidden" name="idnota[]" id="idnota[]" value="'+idnota+'"></td>'+
        '<td><input type="text" class=""  readonly name="fecha[]" id="fecha[]" value="'+fecha+'" style="display:none;"><span name="fecha2" id="fecha2'+cont2+'">'+fecha+'</span></td> '+
        '<td><input type="text"  class="" name="cliente[]" id="cliente[]" value="'+cliente+'" readonly style="display:none;"><span name="cliente2" id="cliente2'+cont2+'">'+cliente+'</span></td>'+
        '<td><input type="text"  class="" name="nroserie[]" id="nroserie[]" value="'+nroserie+'" readonly style="display:none;"><span name="nroserie2" id="nroserie2'+cont2+'">'+nroserie+'</span></td>'+
        '<td><input type="text"  class="" name="totalcomp[]" id="totalcomp[]" value="'+total+'" readonly style="display:none;">'+
        '<span name="totaldeuda" id="totaldeuda'+cont2+'">'+total+'</span></td>'+
        '<td><input type="text"  class="" name="estadoC[]" id="estadoC[]" value="'+$est+'" readonly style="display:none;">'+
        '<span name="estadoC" id="estadoC'+cont2+'">CANCELADO</span></td>'+
        '</tr>'
        var id = document.getElementsByName("idnota[]");
        for (var i = 0; i < id.length; i++) {
            var idA=id[i];
        if (idA.value==idnota) { 
        alert("Ya esta ingresado!");
        fila2="";
        cont2=cont2 - 1;
        conNO2=conNO2 -1;
        }else{
        detalles2=detalles2;
        }}
        detalles2=detalles2+1;
        cont2++;
        conNO2++;
       
        $('#detallesClientesEstadoAgregados').append(fila2);
         modificarSubototales();
    }
    else
    {
        alert("Error al ingresar el detalle, revisar los datos del artículo");
        cont2=0;
    }
  }



  function eliminarDetalleComprobante(indice){
    $("#fila2" + indice).remove();
    calcularTotales();
    detalles2=detalles2-1;
    conNO2=conNO2 - 1;
    actualizanordenP();
  }



function refrescartabla()
{
//tablaArti.ajax.reload();
tabla.ajax.reload();
listar();
}




function guardaryeditararticulo(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
    
    var formData = new FormData($("#formularionarticulo")[0]);

    $.ajax({
        url: "../ajax/articulo.php?op=guardarnuevoarticulo",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos)
        {                    
              bootbox.alert(datos);           
              tabla.ajax.reload();
              refrescartabla();
              limpiarnuevoarticulo();
               //agregarClientexRucNuevo();
        }

    });
     
        $("#modalnuevoarticulo").modal('hide');
        
     //$("#myModalCli").modal('hide');

}





 function nuevoarticulo()
 {
    $("#modalnuevoarticulo").modal("show");
  }


  function limpiarnuevoarticulo()
{
$("#nombrenarticulo").val("");
$("#stocknarticulo").val("");
$("#precioventanarticulo").val("");
$("#codigonarticulonarticulo").val("");
$("#descripcionnarticulo").val("");
}



$(function () {
  $('#myModalArt').on('shown.bs.modal', function (e) {
    $('.focus').focus();
  })
});

$(function () {
  $('#modalnuevoarticulo').on('shown.bs.modal', function (e) {
    $('.focus').focus();
  })
});




 function generarcodigonarti()
 {
    //alert("asdasdas");
    var caracteres1 = $("#nombrenarticulo").val();
    var codale = "";
    codale=caracteres1.substring(-3,3);
    var caracteres2 = "ABCDEFGHJKMNPQRTUVWXYZ012346789";
    codale2 = "";
       for (i=0; i<3; i++) {
        var autocodigo="";
        codale2 += caracteres2.charAt(Math.floor(Math.random()*caracteres2.length)); 
    }
        $("#codigonarticulonarticulo").val(codale+codale2);
       
  }




init();











$(function () {

  $('#myModalArt').on('shown.bs.modal', function (e) {
    $("div.dataTables_filter input").focus();
  })
});




function preticket2(idnotap)
{

              var rutacarpeta='../reportes/exNotapedidoTicket.php?id='+idnotap;
              $("#modalComticket").attr('src',rutacarpeta);
              $("#modalPreviewticket").modal("show");

}




function printDiv(nombreDiv) {
     var contenido= document.getElementById(nombreDiv).innerHTML;
     var contenidoOriginal= document.body.innerHTML;

     document.body.innerHTML = contenido;

     window.print();

     document.body.innerHTML = contenidoOriginal;
}




function editarnotav(idboleta)
 {

    $.post("../ajax/notapedido.php?op=editar",{idboleta : idboleta}, function(data, status)
  {
    data = JSON.parse(data); 
    mostrarformedicion(true);
        $("#idboleta").val(data.idboleta);
        $("#numero_boleta").val(data.numeronp);
        $("#fecha_emision_01").val(data.fechaemision);
        $("#tipo_moneda_24").val(data.moneda);
        $("#tipo_doc_ide").val(data.tpcli);
        $("#ambtra").val(data.ambtra);
        $("#numero_documento").val(data.ruc);
        $("#idcliente").val(data.idcliente);
        $("#razon_social").val(data.nombre_comercial);
        $("#domicilio_fiscal").val(data.domicilio_fiscal);
        $("#estadonota").val(data.estado);


      

    })


    $.post("../ajax/notapedido.php?op=listarDetallenota&id="+idboleta,function(r){
        $("#detalles").html(r);

        });


        $.post("../ajax/notapedido.php?op=numerof&id="+idboleta, {idboleta : idboleta} ,function(data2,status)
        {
                data2=JSON.parse(data2);
                $("#contaedit").val(data2.cantifilas);
        });


    detalles=1000000;


        $("#codigo_precio_14_1").val("01");
        $("#afectacion_igv_3").val("10");
        $("#afectacion_igv_4").val("1000");
        $("#afectacion_igv_5").val("IGV");
        $("#afectacion_igv_6").val("VAT");
    
    $("#btnGuardar").show();

 }



 function mostrarformedicion(flag)
{

        //limpiar();
    if (flag)
    {
        
        listarArticulos();
        
        document.getElementById("tiponota").disabled = true;
        //document.getElementById("fecha_emision_01").disabled = true;
        document.getElementById("tipo_moneda_24").disabled = true;
        document.getElementById("tipo_doc_ide").disabled = true;
        document.getElementById("numero_documento").disabled = true;
        document.getElementById("razon_social").disabled = true;
        document.getElementById("domicilio_fiscal").disabled = true;


        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnagregar").hide();
        //$("#btnGuardar").hide();
        $("#btnCancelar").show();
        $("#btnAgregarArt").show();
        //$("#numero_documento2").focus();
    }
    else
    {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
    }
}
