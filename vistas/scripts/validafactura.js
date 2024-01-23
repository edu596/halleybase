var fecha = new Date();
var ano = fecha.getFullYear();
var mes=fecha.getMonth();
var dia=fecha.getDate();

$("#ano").val(ano);
$("#mes").val(mes+1);
$("#dia").val(dia);

$idempresa=$("#idempresa").val();

listarValidarComprobantes();
listarValidar();

//Función Listar
function listarValidar()
{

    var $ano = $("#ano option:selected").text();
    var $mes = $("#mes option:selected").val();
    var $dia = $("#dia option:selected").val();
   // var $dia = "1";


    tabla=$('#tbllistado').dataTable(
    {
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla

        "processing": true,
        "language": { 
            'loadingRecords': '&nbsp;',
            'processing': '<i class="fa fa-spinner fa-spin"></i> Procesando datos'
        },

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
                    url: '../ajax/factura.php?op=listarValidar&ano='+$ano+'&mes='+$mes+'&dia='+$dia+'&idempresa='+$idempresa,
                    type : "get",
                    dataType : "json",                      
                    error: function(e){
                    console.log(e.responseText);    
                    }
                },

         "rowCallback": 
         function( row, data ) {
            //$(row).addClass('selected');
            //$(row).id(0).addClass('selected');
        },

        "bDestroy": true,
        "iDisplayLength": 100,//Paginación
        "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
    }).DataTable();


//Funcion para actualizar la pagina cada 20 segundos.
// setInterval( function () {
// tabla.ajax.reload(null, false);
// }, 50000 );

}


function refrescartabla()
{
tabla.ajax.reload();
}


function enviarcorreo(idfactura)
{

                    mmcliente="";
                    $.post("../ajax/factura.php?op=traercorreocliente&iddff="+idfactura, function(data,status)
                    {
                       data=JSON.parse(data);
                       $("#correo").val(data.email);
                   });
                   mmcliente=$("#correo").val();


    bootbox.confirm("¿Está Seguro desea enviar a "+mmcliente, function(result){
        if(result)
        {
            bootbox.prompt({
            title: "Si es el correo correcto dar clic en ok de lo contrario digitar otro correo:",
            inputType: 'email',
            value: mmcliente,

            callback: function (result) {
            if(result)
            {

            $.post("../ajax/factura.php?op=enviarcorreo&idfact="+idfactura+"&ema="+result, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
                }); 
                }
                console.log(result);
                }
                })
        }
    })

}

//Función para dar de baja registros
function baja(idfactura)
{

 var f=new Date();
 cad=f.getHours()+":"+f.getMinutes()+":"+f.getSeconds(); 

bootbox.prompt({
    title: "Escriba el motivo de baja de la factura de la factura .",
    inputType: 'textarea',
    callback: function (result) {
        if(result)
        {
            $.post("../ajax/factura.php?op=baja&comentario="+result+"&hora="+cad, {idfactura : idfactura}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            }); 
        }
    }

});

}




function botonmes(valor)
{
            
var $dia='';

switch (valor){

    case '1':
    $dia = valor;
    break

    case '2':
    $dia = valor;
    break

    case '3':
    $dia = valor;
    break

    case '4':
    $dia = valor;
    break

    case '5':
    $dia = valor;
    break

    case '6':
    $dia = valor;
    break

    case '7':
    $dia = valor;
    break

    case '8':
    $dia = valor;
    break

    case '9':
    $dia = valor;
    break

    case '10':
    $dia = valor;
    break

    case '11':
    $dia = valor;
    break

    case '12':
    $dia = valor;
    break

    case '13':
    $dia = valor;
    break

    case '14':
    $dia = valor;
    break

    case '15':
    $dia = valor;
    break

    case '16':
    $dia = valor;
    break

    case '17':
    $dia = valor;
    break

    case '18':
    $dia = valor;
    break

    case '19':
    $dia = valor;
    break

    case '20':
    $dia = valor;
    break

    case '21':
    $dia = valor;
    break

    case '22':
    $dia = valor;
    break

    case '23':
    $dia = valor;
    break

    case '24':
    $dia = valor;
    break

    case '25':
    $dia = valor;
    break

    case '26':
    $dia = valor;
    break

    case '27':
    $dia = valor;
    break

    case '28':
    $dia = valor;
    break

    case '29':
    $dia = valor;
    break

    case '30':
    $dia = valor;
    break

    case '31':
    $dia = valor;
    break

    
    default:
    $dia = '1';

    
}


    var $ano = $("#ano").val();
    var $mes = $("#mes").val();

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
                    url: '../ajax/factura.php?op=listarValidar&ano='+$ano+'&mes='+$mes+'&dia='+$dia,
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
        "iDisplayLength": 4,//Paginación
        "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
    }).DataTable();

}



//Función Listar
function listarValidarComprobantes()
{
    var $estadoC = $("#estadoC").val();
    //var $estado = "1";
    tabla=$('#tbllistadoEstado').dataTable(
    {
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [                
                    'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdf'
                ],
        "ajax":
                {
                    url: '../ajax/ventas.php?op=listarValidarComprobantes&estadoFinal='+$estadoC,
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
//Funcion para actualizar la pagina cada 20 segundos.
// setInterval( function () {
// tabla.ajax.reload(null, false);
// }, 5000 );
}


//Funcion para enviararchivo xml a SUNAT
function mostrarxml(idfactura)
{

            $.post("../ajax/factura.php?op=mostrarxml", {idfactura : idfactura}, function(e)
            {
                data=JSON.parse(e);
                
             if (data.rutafirma) {
              var rutacarpeta=data.rutafirma;
              $("#modalxml").attr('src',rutacarpeta);
              $("#modalPreviewXml").modal("show");
              $("#bajaxml").attr('href',rutacarpeta); 
              bootbox.alert(data.cabextxml);
             }else{
                bootbox.alert(data.cabextxml);
             }   

              

            }
            ); 
}



//Funcion para enviararchivo xml a SUNAT
function mostrarrpta(idfactura)
{

            $.post("../ajax/factura.php?op=mostrarrpta", {idfactura : idfactura}, function(e)
            {
                data=JSON.parse(e);
                //bootbox.alert('Se ha generardo el archivo XML: '+data.rpta);
              var rptaS=data.rutaxmlr;
              $("#modalxml").attr('src',rptaS);
              $("#modalPreviewXml").modal("show");
              $("#bajaxml").attr('href',rptaS); 

            }
            ); 
}

//Funcion para enviararchivo xml a SUNAT
function generarxml(idfactura)
{
    bootbox.confirm("¿Está Seguro de generar el archivo XML.?", function(result){
        if(result)
        {
            $.post("../ajax/factura.php?op=generarxml", {idfactura : idfactura}, function(e)
            {
                data=JSON.parse(e);
                bootbox.alert('Se ha generardo el archivo XML: <a href="'+data.cabextxml+'" download=" '+data.cabxml+'">" ARCHIVO XML:   '+data.cabxml+'"</a> de clic en el nombre para descargarlo.');
                tabla.ajax.reload();
            }); 
            refrescartabla();
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
function regenerarxml(idfactura)
{
    bootbox.confirm("¿Está Seguro de generar el archivo XML.?", function(result){
        if(result)
        {
            $.post("../ajax/factura.php?op=regenerarxml", {idfactura : idfactura}, function(e)
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
function enviarxmlSUNATbajas(idfactura)
{
    bootbox.confirm("¿Está Seguro de enviar archivo firmado a SUNAT?", function(result){
        if(result)
        {
            $.post("../ajax/factura.php?op=enviarxmlSUNATbajas", {idfactura : idfactura}, function(e){
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









function envioautomatico(valor)
{

    var $ano = $("#ano option:selected").text();
    var $mes = $("#mes option:selected").val();
    var $dia = $("#dia option:selected").val();
    var opc = $("#opcion option:selected").val();

    var idocu = document.getElementsByName("idoculto[]");
    var stocu = document.getElementsByName("estadoocu[]");
    var chfact = document.getElementsByName("chid[]");

        for (var i = 0; i < idocu.length; i++) {
             var idA=idocu[i].value;
             var ESoc=stocu[i].value;
             var Chhid=chfact[i].checked;

    $.ajax({
        url: '../ajax/factura.php?op=regenerarxmlEA&anO='+$ano+'&meS='+$mes+'&diA='+$dia+'&idComp='+idA+'&SToc='+ESoc+'&Ch='+Chhid+'&opt='+opc,
        type: "POST",
        contentType: false,
        processData: false,
        success: function(datos)
        {                    
            refrescartabla();
        }
    });

     }//Fin de for

}


function tipoenvio()
{
    if ($("#fenvio").val()=='0')
    {
      envioautomatico();  
    }
}






function cambiotipoenvio()
{
    var  tipo=$("#fenvio").val();
    
if (tipo=='1')
    {
      document.getElementById('formaenvio').style.display = 'none';  
    }else{
      document.getElementById('formaenvio').style.display = 'inline';  
    }
}




function refrescartabla()
{
tabla.ajax.reload();
}



function marcartn()
{

    var idocu = document.getElementsByName("idoculto[]");
    var chfact = document.getElementsByName("chid[]");

    if ($("#marcar").val()=='0') {
        for (var i = 0; i < idocu.length; i++) {
             chfact[i].checked=true; }
    }else{
        for (var i = 0; i < idocu.length; i++) {
             chfact[i].checked=false; }
    }
}



//Función para enviar respuestas por correo 
function consultarcdr(idfactura)
{
    bootbox.confirm("Se consultará si existe el comprobante en SUNAT.", function(result){
        if(result)
        {
            $.post("../ajax/factura.php?op=consultarcdr", {idfactura : idfactura}, function(e){
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



function cambiartarjetadc(idfactura)
{

    bootbox.prompt({
    title: "Desea modificar pago con tarjeta",
    inputType: 'select',
    value: ['1'],
    inputOptions: [
    {
        text: 'SI',
        value: '1',
    },
    {
        text: 'NO',
        value: '0',
    },
  
    ],
    

    callback: function (result) {
        if(result)
        {
            $.post("../ajax/factura.php?op=cambiartarjetadc_&opcion="+result, {idfactura : idfactura}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            }); 
        }
    }

});
    
}







function montotarjetadc(idfactura)
{
    bootbox.prompt({
    title: "Desea modificar monto de pago con tarjeta",
    inputType: 'number',
    value: ['0'],
    callback: function (result) {
        if(result)
        {
            $.post("../ajax/factura.php?op=montotarjetadc_&monto="+result, {idfactura : idfactura}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            }); 
        }
    }

});
    
}






function cambiartransferencia(idfactura)
{

    bootbox.prompt({
    title: "Desea modificar pago con transferencia",
    inputType: 'select',
    value: ['1'],
    inputOptions: [
    {
        text: 'SI',
        value: '1',
    },
    {
        text: 'NO',
        value: '0',
    },
  
    ],
    

    callback: function (result) {
        if(result)
        {
            $.post("../ajax/factura.php?op=cambiartransferencia&opcion="+result, {idfactura : idfactura}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            }); 
        }
    }

});
    
}




function montotransferencia(idfactura)
{
    bootbox.prompt({
    title: "Desea modificar monto de transferencia",
    inputType: 'number',
    value: ['0'],
    callback: function (result) {
        if(result)
        {
            $.post("../ajax/factura.php?op=montotransferencia&monto="+result, {idfactura : idfactura}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            }); 
        }
    }

});
    
}




