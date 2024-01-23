var tabla;
var tipodocu;
var tipo;
$idempresa=$("#idempresa").val();
$iva=$("#iva").val();
//Función que se ejecuta al inicio
function init(){
    mostrarform(false);
    listar();
 
    $("#formulario").on("submit",function(e)
    {
        guardaryeditarNdebito(e);  
    });


     $.post("../ajax/notacd.php?op=selectSerieDebito", function(r)
        {
        $("#serie").html(r);
        $("#serie").selectpicker('refresh');
        });

        // Carga de motivos
    $.post("../ajax/notacd.php?op=selectcatalogo10", function(r){
            $("#codigo_nota").html(r);
            $('#codigo_nota').selectpicker('refresh');

        
    });

    // Carga de combo para vendedores =====================
    $.post("../ajax/vendedorsitio.php?op=selectVendedorsitio&idempresa="+$idempresa, function(r){
            $("#vendedorsitio").html(r);
            $('#vendedorsitio').selectpicker('refresh');
    });
// Carga de combo para vendedores ======================

    cont=0;
    tipo=1;
}

//==========================================================================================

function cambiotiponota(){

var codtiponota = $("#codigo_nota option:selected").val();
$("#codtiponota").val(codtiponota);

var nomcodtipo = $("#codigo_nota option:selected").text();
 $("#nomcodtipo").val(nomcodtipo);

}


function incremetarNum(){
    var serie=$("#serie option:selected").val();
    $.post("../ajax/notacd.php?op=autonumeracionDebito&ser="+serie+'&idempresa='+$idempresa, function(r){

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
 
    //Obtenemos la fecha actual
    $("#fecha_emision").prop("disabled",false);
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fecha_emision').val(today);
    cont=0;
    }

 
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
 
        $("#btnGuardar").hide();
        $("#btnCancelar").show();
        $("#btnAgregarArt").show();

         var nomcodtipo = $("#codigo_nota option:selected").text();
        $("#nomcodtipo").val(nomcodtipo);
    }
    else
    {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();
        $("#btnGuardar").hide();

    }
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
                    url: '../ajax/notacd.php?op=listarND&idempresa='+$idempresa,
                    type : "get",
                    dataType : "json",                      
                    error: function(e){
                    console.log(e.responseText);    
                    }
                },
        "bDestroy": true,
        "iDisplayLength": 5//,//Paginación
       // "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
    }).DataTable();

        setInterval( function () {
tabla.ajax.reload(null, false);
}, 10000 );

}
 


//Función para guardar o editar
 
// function guardaryeditarNcredito(e)
// {
//     e.preventDefault(); //No se activará la acción predeterminada del evento
//     //$("#btnGuardar").prop("disabled",true);
        
//     var formData = new FormData($("#formulario")[0]);
 
//     $.ajax({
//         url: "../ajax/notacd.php?op=guardaryeditarnc&tipodo="+tipo,
//         type: "POST",
//         data: formData,
//         contentType: false,
//         processData: false,

//         success: function(datos)
//         {                    

//               bootbox.alert(datos);
//               mostrarform(false);
//               listar();
//         }
//     });
//             limpiar();
    
// }


function guardaryeditarNdebito(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
    //$("#btnGuardar").prop("disabled",true);
    capturarhora();
    var formData = new FormData($("#formulario")[0]);
 
    $.ajax({
        url: "../ajax/notacd.php?op=guardaryeditarnd&tipodo="+tipo,
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



function agregarComprobante(idcomprobante,tdcliente,ndcliente,rzcliente, domcliente,tipocomp, numerodoc, subtotal, igv, total,fecha1 ,fecha2)
  {

     if (idcomprobante!="")
    {
        $('#idcomprobante').val(idcomprobante);
        $('#tipo_documento_cliente').val(tdcliente);
        $('#numero_documento_cliente').val(ndcliente);
        $('#razon_social').val(rzcliente);
        //$('#domicilio_fiscal').val(domcliente);

        $('#tipocomprobante').val(tipocomp);
        $('#numero_comprobante').val(numerodoc);

    $("#subtotal").html(number_format(subtotal,2));
    $("#subtotal_comprobante").val(subtotal);
    $("#igv_").html(number_format(igv,2));
    $("#total_igv").val(igv);
    $("#total").html(number_format(total,2));
    $("#total_final").val(total);

    $("#btnGuardar").show();

    $("#fecha1").val(fecha1);
    $("#fecha2").val(fecha2);

    

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
setTimeout(function(){
  $('#desc_motivo').focus();
},400);
//$("#myModalComprobante").hide('2', function(){document.getElementById('desc_motivo').focus();});
//$("#myModalComprobante").modal('hide','400', function(){document.getElementById('desc_motivo').focus();});
}


function foco(){
document.getElementById('desc_motivo').focus();  

}


//Función 
function listarComprobante()
{
    //var tipodocu=$("#tipo_doc_mod option:selected").val();
 
    tabla=$('#tblacomprobante').dataTable(
    {
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [                
                     
                ],
        "ajax":
                {
                  
                    url: '../ajax/notacd.php?op=listarComprobante&tipodo='+tipo+'&idempresa='+$idempresa,
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



function stopRKey(evt) {
var evt = (evt) ? evt : ((event) ? event : null);
var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
}

document.onkeypress = stopRKey; 


function NumCheck(e, field) {
      // Backspace = 8, Enter = 13, ’0' = 48, ’9' = 57, ‘.’ = 46
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
 


function capturarhora(){ 
var f=new Date();
cad=f.getHours()+":"+f.getMinutes()+":"+f.getSeconds(); 
$("#hora2").val(cad);
}

function totalndto(){

var canti=$("#cantidadnd").val();
var vunit=$("#vunitariond").val();

var totalnd=canti * vunit;

$("#totalnd").val(totalnd.toFixed(2));

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




//Funcion para enviararchivo xml a SUNAT
function generarxmlNd(idnota)
{
    bootbox.confirm("¿Está Seguro de generar el archivo XML?", function(result){
        if(result)
        {
            $.post("../ajax/notacd.php?op=generarxmlNd", {idnota : idnota}, function(e)
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
              bootbox.alert(data.cabextxml);
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


init();