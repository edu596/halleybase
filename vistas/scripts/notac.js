var tabla;
var tipodocu;
var tipo;
$idempresa=$("#idempresa").val();
$iva=$("#iva").val();
//Función que se ejecuta al inicio
function init()
{
    mostrarform(false);
    //listar();
    unotodos();
    limpiar();
    document.getElementById("chk1").checked = true;
 
    $("#formulario").on("submit",function(e)
    {
        guardaryeditarNcredito(e);  
    });

    $("#formulario2").on("submit",function(e)
    {
        guardaryeditarNcredito(e);  
    });


     $.post("../ajax/notacd.php?op=selectSerie", function(r)
        {
        $("#serie").html(r);
        $("#serie").selectpicker('refresh');
        });

        // Carga de departamentos
    $.post("../ajax/notacd.php?op=selectcatalogo9", function(r){
            $("#codigo_nota").html(r);
            $('#codigo_nota').selectpicker('refresh');

        
    });

// Carga de combo para vendedores =====================
    $.post("../ajax/vendedorsitio.php?op=selectVendedorsitio&idempresa="+$idempresa, function(r){
            $("#vendedorsitio").html(r);
            $('#vendedorsitio').selectpicker('refresh');
    });
// Carga de combo para vendedores ======================


$.post("../ajax/factura.php?op=selectAlmacen", function(r){
            $("#almacenlista").html(r);
            $('#almacenlista').selectpicker('refresh');
    });

    cont=0;
    tipo='01';
    conNO=1;


}

//==========================================================================================

//Funcion para actualizar la pagina cada 20 segundos.



//Función mostrar formulario
function mostrarform(flag)
{
   
    limpiar();

    if (flag)
    {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnagregar").hide();
        $("#codtiponota").val("01");
        
        listarComprobante();
        listarArticulos();

 
        $("#btnGuardar").hide();
        $("#btnCancelar").show();
        $("#btnAgregarArt").show();
        $("#detalles").show();
        $("#totales").show();

        var nomcodtipo = $("#codigo_nota option:selected").text();
        $("#nomcodtipo").val(nomcodtipo);
    }
    else
    {
        $("#detallesnc").hide();
        $("#detalles").hide();
        $("#totales").hide();
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
        $("#btnGuardar").hide();


    }
}

function cambiotiponota(){

var codtiponota = $("#codigo_nota option:selected").val();
$("#codtiponota").val(codtiponota);

var nomcodtipo = $("#codigo_nota option:selected").text();
        $("#nomcodtipo").val(nomcodtipo);

switch(codtiponota){
    case '01':
        $("#detallesnc").hide();
        $("#detalles").show();
        $("#totales").show();
        $("#pdescu").hide();
        $("#tiponotaC").val("1");
        $(".filas2").remove();
        cont=0;
        //tipo=1;
        conNO=1;
        document.getElementById('btnAgregarart').style.display = 'none'; 

    break;

    case '02':
        $("#detallesnc").hide();
        $("#detalles").show();
        $("#totales").show();
        $("#pdescu").hide();
        $("#tiponotaC").val("2");
        $(".filas2").remove();
        cont=0;
        //tipo=1;
        conNO=1;
        document.getElementById('btnAgregarart').style.display = 'none'; 

    break;
    case '03':
        $("#detallesnc").hide();
        $("#detalles").show();
        $("#totales").show();
        $("#pdescu").hide();
        $("#tiponotaC").val("3");
        $(".filas2").remove();
        cont=0;
        //tipo=1;
        conNO=1;
        document.getElementById('btnAgregarart').style.display = 'none'; 
        
    break;
    case '04':
        $("#detallesnc").hide();
        $("#detalles").show();
        $("#totales").show();
        $("#pdescu").show();
        $("#tiponotaC").val("4");
        document.getElementById('btnAgregarart').style.display = 'none'; 
    break;
    // case '05':
    //     $("#detallesnc").show();
    //     $("#detalles").show();
    //     $("#totales").show();
    //     $("#tiponotaC").val("5");
    //     document.getElementById('btnAgregarart').style.display = 'inline'; 
    // break;
    case '06':
        $("#detallesnc").hide();
        $("#detalles").show();
        $("#totales").show();
        $("#pdescu").hide();
        $("#tiponotaC").val("6");
        $(".filas2").remove();
        cont=0;
        //tipo=1;
        conNO=1;
        document.getElementById('btnAgregarart').style.display = 'none'; 
    break;
    case '07':
         if ($("#tipo_doc_mod").val()=="04" || $("#tipo_doc_mod").val()=="05" ) {
            alert("No se puede hacer para Facturas o boletas de servicio, solo para facturas y boletas de productos, \n utilice anulacion total.");
            $("#tipo_doc_mod").val()="01";
            $("#codigo_nota").val("01");
        }else{
            $("#detallesnc").show();
            $("#detalles").show();
            $("#totales").show();
            $("#pdescu").hide();
            $("#tiponotaC").val("7");
            document.getElementById('btnAgregarart').style.display = 'inline';     
        }

        
        

    break;
    
}




}


function incremetarNum()
{
    var serie=$("#serie option:selected").val();
    $.post("../ajax/notacd.php?op=autonumeracion&ser="+serie+'&idempresa='+$idempresa, function(r){

       var n2=pad(r,0);
       $("#numero_nc").val(n2);

       var SerieReal = $("#serie option:selected").text();
        $("#SerieReal").val(SerieReal);
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
    $("#idnota").val("");
    $("#numero_comprobante").val("");
    $("#razon_social").val("");
    $("#domicilio_fiscal").val("");
    $("#idnumeracion").val("");
    $("#SerieReal").val("");
    $("#serie").val("");
    $("#numero_nc").val("");
    $("#desc_motivo").val("");
    $("#codtiponota").val("");
    $("#tipocomprobante").val("");
    $("#numero_comprobante").val("");
    $("#numero_documento_cliente").val("");
    $("#razon_social").val("");
    $("#domicilio_fiscal").val("");

    $("#subtotal").val("");
    $("#subtotal_factura").val("");
    $("#igv_").val("");
    $("#total_igv").val("");
    $("#total").val("");
    $("#total_final").val("");

    $(".filas").remove();
    $("#subtotal").html("0");
    $("#igv_").html("0");
    $("#total").html("0");

    $("#pdescuento").val("");
    $("#subtotaldesc").val("");
    $("#igvdescu").val("");
    $("#totaldescu").val("");
    
    document.getElementById('btnAgregarart').style.display = 'none'; 

    
 
    //Obtenemos la fecha actual
    $("#fecha_emision").prop("disabled",false);
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var f=new Date();
    cad=f.getHours()+":"+f.getMinutes()+":"+f.getSeconds(); 
    //Para hora y minutos
    //var today = now.getFullYear()+"-"+(month)+"-"+(day)+" "+(cad) ;
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fecha_emision').val(today);

    cont=0;
    }

 



 
//Función cancelarform
function cancelarform()
{
    limpiar();
    detalles=0;
    mostrarform(false);
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
                    url: '../ajax/notacd.php?op=listarNC&idempresa='+$idempresa,
                    type : "get",
                    dataType : "json",                      
                    error: function(e){
                    console.log(e.responseText);    
                    }
                },
        "bDestroy": true,
        "iDisplayLength": 4//,//Paginación
        //"order": [[ 2, "asc" ]]//Ordenar (columna,orden)
    }).DataTable();

// setInterval( function () {
// tabla.ajax.reload(null, false);
// }, 10000 );


}


//Función Listar
function listarDia()
{
    tabla=$('#tbllistado').dataTable(
    {
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [                
                    
                ],
        "ajax":
                {
                    url: '../ajax/notacd.php?op=listarNCDia&idempresa='+$idempresa,
                    type : "get",
                    dataType : "json",                      
                    error: function(e){
                    console.log(e.responseText);    
                    }
                },
        "bDestroy": true,
        "iDisplayLength": 5//,//Paginación
        //"order": [[ 2, "asc" ]]//Ordenar (columna,orden)
    }).DataTable();

// setInterval( function () {
// tabla.ajax.reload(null, false);
// }, 10000 );


}
 


//Función para guardar o editar
 
function guardaryeditarNcredito(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
    //$("#btnGuardar").prop("disabled",true);

     if ($('#numero_nc').val()=="" ){

         alert("Revizar précio!, cantidad o Stock");

     }
     else
     {
    capturarhora();        
    var formData = new FormData($("#formulario")[0]);
    var codtiponota = $("#codigo_nota option:selected").val();
    $("#codtiponota").val(codtiponota);
    $.ajax({
        url: "../ajax/notacd.php?op=guardaryeditarnc&tipodo="+tipo,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos)
        {                    

              bootbox.alert(datos);
              mostrarform(false);
              listarDia();
              //document.getElementById("chk1").checked = true;
        }
    });
            limpiar();

        }

        //unotodos();

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
//=========================
}

 
  //Función para aceptar solo numeros con dos decimales
  function NumCheck(e, field) {
  // Backspace = 8, Enter = 13, ’0′ = 48, ’9′ = 57, ‘.’ = 46
  key = e.keyCode ? e.keyCode : e.which
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



function agregarComprobante(idcomprobante,tdcliente,ndcliente,rzcliente, 
    domcliente,tipocomp, numerodoc, subtotal, igv, total, fecha, fecha2)
  {
    moneda=$("#tipo_moneda").val();
     $(".filas2").remove();
     if (idcomprobante!="")
    {
        
        $('#idcomprobante').val(idcomprobante); //Id de factura
        $('#tipo_documento_cliente').val(tdcliente);
        $('#numero_documento_cliente').val(ndcliente);
        $('#razon_social').val(rzcliente);
        $('#fechacomprobante').val(fecha);
        $('#tipocomprobante').val(tipocomp);
        $('#numero_comprobante').val(numerodoc);

    $("#subtotal").html(number_format(subtotal,2));
    $("#subtotal_comprobante").val(subtotal);
    $("#igv_").html(number_format(igv,2));
    $("#total_igv").val(igv);
    $("#total").html(number_format(total,2));
    $("#total_final").val(total);
    $("#btnGuardar").show();
    $("#fecha_factura").val(fecha2);
    }
    else
    {
        alert("Error al ingresar el detalle, revisar los datos del cliente");
    }

 //========================================================================

    $.post("../ajax/notacd.php?op=detalle&id="+idcomprobante+"&tipo="+tipo,function(r){
        $("#detalles").html(r);
    });

//============================================================================
$("#myModalComprobante").modal('hide');
}


function tipomonn()
{
    listarComprobante();
}



//Función 
function listarComprobante()
{
    moneda=$("#tipo_moneda").val();
    tabla=$('#tblacomprobante').dataTable(
    {
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [                
                     
                ],
        "ajax":
                {
                  
                    url: '../ajax/notacd.php?op=listarComprobante&tipodo='+tipo+'&idempresa='+$idempresa+'&mo='+moneda,
                    //url: '../ajax/notac.php?op=listarComprobante',
                    type : "post",
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


function cambio()
{
    var tipodocu=$("#tipo_doc_mod option:selected").val()
    

    if(tipodocu=="01"){
        tipo='01';
    }else if(tipodocu=="03"){
        tipo='03';
    }else if(tipodocu=="04"){
        tipo='04';
    }else{
        tipo='05';
    }
    $("#hinum").val(tipo);
    listarComprobante();
}

function capturarhora(){ 
var f=new Date();
cad=f.getHours()+":"+f.getMinutes()+":"+f.getSeconds(); 
$("#hora").val(cad);
}


//Función ListarArticulos
function listarArticulos()
{

    tpf=$('#tipofactura').val(); 
    tipoprecio=$('#tipoprecio').val();
    almacen=$('#almacenlista').val(); 
    $iteno=$('#itemno').val(); 
    
    tabla=$('#tblarticulos').dataTable(
    {
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [                
                     
                ],
        "ajax":
                {
                    url: '../ajax/notacd.php?op=listarArticulosNC&tipoprecioaa='+tipoprecio+'&tipof='+tpf+'&itm='+$iteno+'&alm='+almacen,
                    type : "get",
                    dataType : "json",                      
                    error: function(e){
                        console.log(e.responseText);    
                    }
                },
        "bDestroy": true,
        "iDisplayLength": 5,//Paginación
        "order": [[ 5, "desc" ]]//Ordenar (columna,orden)
    }).DataTable();
}

var detalles=0;

function agregarDetalle(idarticulo,familia,codigo_proveedor,codigo,nombre,precio_factura,stock,unidad_medida, precio_unitario, descarti)
  {

    var cantidad=0;
    
     if (idarticulo!="")
    {
        var subtotal=cantidad*precio_factura;
        var igv= subtotal * $iva/100;
        var total_fin;
        var contador=1;
        
        var fila='<tr class="filas2" id="fila'+cont+'">'+
        '<td><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+(cont) +')">X</button></td>'+

        //'<td><input type="text" class="form-control" name="numero_orden[]" id="numero_orden[]" value="'+(cont + 1)+'" size="1" disabled="true" >'+
        '<td><span name="numero_orden" id="numero_orden'+cont+'"></span>'+
        '<input type="hidden" name="numero_orden_item[]" id="numero_orden_item[]" value="'+conNO+'" size="1" ></td>'+
        '<td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'"><input type="hidden" name="descarti[]" id="descarti[]" value="'+descarti+'">'+nombre+'</td>'+
        '<td><input type="hidden" name="codigo_proveedor[]" id="codigo_proveedor[]" value="'+codigo+'">'+codigo+'</td>'+
        '<td><input type="text" name="codigo[]" id="codigo[]" value="'+codigo+'" class="form-control" size="4" style="display:none;" ></td>'+
        '<td><input type="hidden" name="unidad_medida[]" id="unidad_medida[]" value="'+unidad_medida+'">'+unidad_medida+'</td>'+
        '<td><input type="text" class="form-control" name="valor_unitario[]" id="valor_unitario[]" value="'+precio_factura+'" onBlur="modificarSubototales()" size="5" onkeypress="return NumCheck(event, this)" font-weight:bold;" OnFocus="focusTest(this);"></td>'+
        '<td><input type="text" class="form-control" name="valor_unitario2[]" id="valor_unitario2[]" size="5" disabled="true" onBlur="modificarSubototales()"></td>'+
        //'<td><input type="text" class="form-control" name="stock[]" id="stock[]" value="'+stock+'" disabled="true" size="4" ></td>'+
        '<td><input type="text"  autofocus required="true" class="form-control" name="cantidad[]" id="cantidad[]"  onBlur="modificarSubototales()" size="5" onkeypress="return NumCheck(event, this)"  font-weight:bold; "></td>'+
        

        '<td><span name="subtotal" id="subtotal'+cont+'"></span>'+
        '<input type="hidden" name="subtotalBD[]" id="subtotalBD["'+cont+'"]"></td>'+

        '<td><span name="igvG" id="igvG'+cont+'" style="background-color:#9fde90bf;display:none;"></span>'+
        '<input type="hidden" name="igvBD[]" id="igvBD["'+cont+'"]"></td>'+

        '<td><span name="total" id="total'+cont+'" style="background-color:#9fde90bf; display:none;" ></td>'+

        '<td><span name="pvu_" id="pvu_'+cont+'"  style="display:none"  ></span>'+

        '<input  type="hidden" name="pvt[]" id="pvt["'+cont+'"] size="2"></td>'+
        '</tr>'

        var id = document.getElementsByName("idarticulo[]");
        for (var i = 0; i < id.length; i++) {
            var idA=id[i];
        if (idA.value==idarticulo) { 
        alert("Ya esta ingresado el articulo!");
        fila="";
        cont=cont - 1;
        conNO=conNO -1;
        
    }else{
        detalles=detalles;
        }}
        detalles=detalles+1;
        cont++;
        conNO++;
       
        $('#detallesnc').append(fila);
        
        modificarSubototales();
        $("#myModalArt").modal('hide');

        setTimeout(function(){
        document.getElementById('cantidad[]').focus();
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
    var cant = document.getElementsByName("cantidad[]");
    var prec = document.getElementsByName("valor_unitario[]");
    var vuni = document.getElementsByName("valor_unitario2[]");
    //var st = document.getElementsByName("stock[]");
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
        //var inStk=st[i];
            
        //inStk.value=inStk.value;
        inpC.value=inpC.value;


         inpPVU.value=inpP.value / ($iva/100+1);
         document.getElementsByName("valor_unitario2[]")[i].value = redondeo(inpPVU.value,5);
         

         inpNOI.value=inpNOI.value;
         inpI.value=inpI.value;
         inpS.value=(inpC.value * inpVuni.value);
         //inpS.value=((inpC.value * inpP.value)/1.18);
         //inpS.value=(inpC.value * inpP.value);
         //inpI.value=(inpC.value * inpP.value)-((inpC.value * inpP.value)/1.18);    
         inpI.value= inpS.value * $iva/100;    
         inpT.value=inpS.value + inpI.value;
         
         
        
        document.getElementsByName("subtotal")[i].innerHTML = redondeo(inpS.value,2);
        document.getElementsByName("igvG")[i].innerHTML = redondeo(inpI.value,2);
        document.getElementsByName("total")[i].innerHTML = redondeo(inpT.value,2);
        document.getElementsByName("pvu_")[i].innerHTML = redondeo(inpPVU.value,5);

        document.getElementsByName("numero_orden")[i].innerHTML = inpNOI.value;


        //Lineas abajo son para enviar el arreglo de inputs ocultos con los valor de IGV, Subtotal, y precio de venta
        //a la tala detalle_fact_art.
        document.getElementsByName("subtotalBD[]")[i].value = redondeo(inpS.value,2);
        document.getElementsByName("igvBD[]")[i].value = redondeo(inpI.value,2);
        document.getElementsByName("pvt[]")[i].value = redondeo(inpPVU.value,5);
        //Fin de comentario

        //document.getElementsByName("valor_unitario2[]")[i].value = inpPVU.value.toFixed(2);


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

        //     if(inStk.value==0){
        // inStk.style.backgroundColor= '#ffa69e';
        // //document.getElementById("precio_unitario[]").style.backgroundColor= '#ffa69e';
        // }else{
        // inStk.style.backgroundColor= '#fffbfe';
        // //document.getElementById("precio_unitario[]").style.backgroundColor= '#fffbfe';
        //     }
    }
    calcularTotales();
    }


  function calcularTotales(){
    //var noi = document.getElementsByName("numero_orden_item");
    var sub = document.getElementsByName("subtotal");
    var igv = document.getElementsByName("igvG");
    var tot = document.getElementsByName("total");
    var pvu = document.getElementsByName("pvu_");

    var subtotal = 0.0;
    var total_igv=0.0;
    var total = 0.0;
    var noi=0;
    var pvu=0.0;

    for (var i = 0; i <sub.length; i++) {

        //noi+=document.getElementsByName("numero_orden_item")[i].value;
        subtotal += document.getElementsByName("subtotal")[i].value;
        total_igv+=document.getElementsByName("igvG")[i].value;
        total+=document.getElementsByName("total")[i].value;
        pvu+=document.getElementsByName("pvu_")[i].value;

    }


    $("#subtotalNC").html(redondeo(subtotal,2));
    $("#subtotal_facturaNC").val(redondeo(subtotal,2)); // a base de datos
    
    $("#igv_NC").html(redondeo(total_igv,2));
    $("#total_igvNC").val(redondeo(total_igv,4)); // a base de datos
    
    $("#totalNC").html(number_format(redondeo(total,2),2));
    $("#total_finalNC").val(redondeo(total,2));
    $("#pre_v_u").val(redondeo(pvu,2));
    
    evaluar();
  }






  //================== AGREGAR DETALLE PARA BOLETAS =================================
  function agregarDetalleBoletaItem(idarticulo,familia,codigo_proveedor,codigo,nombre,precio_factura,stock,unidad_medida, precio_unitario)
  {

    var cantidad=0;
     if (idarticulo!="")
    {
         var subtotal=cantidad*precio_factura;
        var igv= subtotal * $iva/100;
        var total_fin;
        var contador=1;

        var fila='<tr class="filas" id="fila'+cont+'">'+
        '<td><i class="fa fa-close" onclick="eliminarDetalle('+(cont) +')" style="color:red;"  data-toggle="tooltip" title="Eliminar item"></i></td>'+
        '<td><span name="numero_orden" id="numero_orden'+cont+'" ></span>'+
        '<input type="hidden" name="numero_orden_item_29[]" id="numero_orden_item_29[]" value="'+conNO+'"  ></td>'+
        '<td><input type="hidden" name="idarticulo[]" style="font-family: times, serif; font-size:14pt; font-style:italic" value="'+idarticulo+'">'+nombre+'</td>'+
        '<td><select name="codigotributo[]"  class="form-control"> <option value="1000" ' +op+ ' >IGV</option>   <option value="9997" ' +exo+ '>EXO</option></select></td>'+
        '<td><select name="afectacionigv[]"  class="form-control"> <option value="10"  ' +op+ '  >10-GOO</option>'+
        '<option value="20"  ' +exo+ '>20-EOO</option></select></td>'+
        '<td><input type="text"  class="form-control" required="true" name="cantidad_item_12[]" id="cantidad_item_12[]" value="" onBlur="modificarSubototales()" size="6" onkeypress="return NumCheck(event, this)"  ></td>'+
        '<td><input type="text"  class="form-control" name="descuento[]" id="descuento[]"  onBlur="modificarSubototales()" size="2" onkeypress="return NumCheck(event, this)" >'+
        '<span name="SumDCTO" id="SumDCTO'+cont+'" style="display:none"></span> <input type="hidden"  required="true" class="form-control" name="sumadcto[]" id="sumadcto[]" >  </td>'+
        '<td><input type="hidden" name="codigo_proveedor[]" id="codigo_proveedor[]" value="'+codigo_proveedor+'">'+codigo_proveedor+'</td>'+
        '<td><input type="text" name="codigo[]" id="codigo[]" value="'+codigo+'" class="form-control" style="display:none;" ></td>'+
        '<td><input type="hidden" name="unidad_medida[]" id="unidad_medida[]" value="'+unidad_medida+'">'+unidad_medida+'</td>'+
        '<td><input type="text" class="form-control" name="precio_unitario[]" id="precio_unitario[]" value="'+precio_factura+'" onBlur="modificarSubototales()" size="7" onkeypress="return NumCheck2(event, this)" OnFocus="focusTest(this); return false;"  ></td>'+
        '<td><input type="text" class="form-control" name="valor_unitario[]" id="valor_unitario[]" size="5"  value="'+precioOculto+'"    '+ exo +' onBlur="modificarSubototales()"></td>'+
        '<td><input type="text" class="form-control" name="stock[]" id="stock[]" value="'+stock+'" disabled="true" size="7"></td>'+
        '<td><span name="subtotal" id="subtotal'+cont+'"></span>'+
        '<input type="hidden" name="subtotalBD[]" id="subtotalBD["'+cont+'"]"></td>'+
        '<td><span name="igvG" id="igvG'+cont+'" style="background-color:#9fde90bf; display:none;"></span>'+
        '<input type="hidden" name="igvBD[]" id="igvBD["'+cont+'"]"><input type="hidden" name="igvBD2[]" id="igvBD2["'+cont+'"]"></td>'+
        '<td><span name="total" id="total'+cont+'" style="background-color:#9fde90bf; display:none;" ></td>'+
        '<td><span name="pvu_" id="pvu_'+cont+'"  style="display:none"  ></span>'+
        '<input  type="hidden" name="vvu[]" id="vvu["'+cont+'"] size="2"></td>'+
        '</tr>'
        var id = document.getElementsByName("idarticulo[]");
        for (var i = 0; i < id.length; i++) {
            var idA=id[i];
        if (idA.value==idarticulo) { 
        alert("Ya esta ingresado el articulo!");
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
        modificarSubototales();
        $("#myModalArt").modal('hide');
        //para foco
        setTimeout(function(){
        document.getElementById('cantidad_item_12[]').focus();
        },500);

        $('#tblarticulos').DataTable().ajax.reload();
        $('input[type=search]').val('');

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

    }
    else
    {
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

function actualizanorden(){
var total = document.getElementsByName("numero_orden_item[]");

for (var i = 0; i <=total.length; i++) {
        //var contNO=total[i];
        var contNO=total[i];
        contNO.value=i+1;
        
        //Lineas abajo son para enviar el arreglo de inputs con los valor de IGV, Subtotal, y precio de venta
        document.getElementsByName("numero_orden")[i].innerHTML = contNO.value;
        document.getElementsByName("numero_orden_item[]")[i].value = contNO.value;
        //Fin de comentario
    }//Final de for
}


//PAra el calculo si la nota de crédito es por descuento global
function calDescuento()
{

    var tComp=0;
    var vDescu=0;
    var subtotaldescu=0;
    var igvdescu=0;
    var totaldescu=0;


tComp=$("#total_final").val();
vDescu=$("#pdescuento").val();

subtotaldescu=((tComp*vDescu)/100)/($iva/100+1);
igvdescu=subtotaldescu * $iva/100;
totaldescu=subtotaldescu + igvdescu;
$("#subtotaldesc").val(subtotaldescu.toFixed(2));
$("#igvdescu").val(igvdescu.toFixed(2));
$("#totaldescu").val(totaldescu.toFixed(2));

}


//Función para anular registros
function enviarcorreo(idnota)
{
    bootbox.confirm("¿Está Seguro de enviar correo al cliente?", function(result){
        if(result)
        {
            $.post("../ajax/notacd.php?op=enviarcorreo", {idnota : idnota}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            }); 
        }
    })
}


let onOff = false;
function unotodos(){
    if (!onOff) {
        onOff=true;
        listarDia();
        //clearInterval(counter);
    }else{
        onOff=false;
        listar();
        //counter=setInterval(timer, 5000);
    }
    
}

//Funcion para enviararchivo xml a SUNAT
function generarxml(idnota)
{
    bootbox.confirm("¿Está Seguro de generar el archivo XML.?", function(result){
        if(result)
        {
            $.post("../ajax/notacd.php?op=generarxml", {idnota : idnota}, function(e)
            {
                data=JSON.parse(e);
                bootbox.alert('Se ha generardo el archivo XML: <a href="'+data.cabextxml+'" download=" '+data.cabxml+'">" ARCHIVO XML:   '+data.cabxml+'"</a> de clic en el nombre para descargarlo.');
                tabla.ajax.reload();
            }); 
            refrescartabla();
        }
    })
}


//Función para enviar xml a sunat
function enviarxmlSUNAT(idnota)
{
    bootbox.confirm("¿Está Seguro de enviar archivo firmado a SUNAT?", function(result){
        if(result)
        {
            $.post("../ajax/notacd.php?op=enviarxmlSUNAT", {idnota : idnota}, function(e){
                //data2=JSON.parse(e);
                bootbox.alert(e);
                tabla.ajax.reload();   
            }); 
             refrescartabla();
        }

    })
    tabla.ajax.reload();
    refrescartabla();     
    
}

//Funcion para enviararchivo xml a SUNAT
function mostrarxml(idnota)
{

            $.post("../ajax/notacd.php?op=mostrarxml", {idnota : idnota}, function(e)
            {
                data=JSON.parse(e);
                
             if (data.rutafirma) {
              var rutacarpeta=data.rutafirma;
              $("#modalxml").attr('src',rutacarpeta);
              $("#modalPreviewXml").modal("show"); 
              //bootbox.alert(data.cabextxml);
             }else{
               bootbox.alert(data.cabextxml);
             }   

              

            }
            ); 
}

//Funcion para enviararchivo xml a SUNAT
function mostrarrpta(idnota)
{

            $.post("../ajax/notacd.php?op=mostrarrpta", {idnota : idnota}, function(e)
            {
                data=JSON.parse(e);
                //bootbox.alert('Se ha generardo el archivo XML: '+data.rpta);
              var rptaS=data.rutaxmlr;
              $("#modalxml").attr('src',rptaS);
              $("#modalPreviewXml").modal("show");

            }
            ); 
}






function refrescartabla()
{
tabla.ajax.reload();
}



function baja(idnota)
{

 var f=new Date();
 cad=f.getHours()+":"+f.getMinutes()+":"+f.getSeconds(); 

bootbox.prompt({
    title: "Escriba el motivo de baja de la nota de credito.",
    inputType: 'textarea',
    callback: function (result) {
        if(result)
        {
            $.post("../ajax/notacd.php?op=bajanc&comentario="+result+"&hora="+cad, {idnota : idnota}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            }); 
        }
    }

});

}



init();