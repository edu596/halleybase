var fecha = new Date();
var ano = fecha.getFullYear();
var mes=fecha.getMonth();
var dia=fecha.getDate();

$("#ano").val(ano);
$("#mes").val(mes+1);
$("#dia").val(dia);

$idempresa=$("#idempresa").val();


listarValidar()


function listarValidar()
{

	var $ano = $("#ano option:selected").text();
    var $mes = $("#mes option:selected").val();
    var $dia = $("#dia option:selected").val();



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
                    url: '../ajax/boleta.php?op=listarValidar&ano='+$ano+'&mes='+$mes+'&dia='+$dia+'&idempresa='+$idempresa,
                    type : "get",
                    dataType : "json",                      
                    error: function(e){
                    console.log(e.responseText);    
                    }
                },
        "bDestroy": true,
        "iDisplayLength": 100,//Paginación
        "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
    }).DataTable();

        // setInterval( function () {
        // tabla.ajax.reload(null, false);
        // }, 50000 );
 }


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

function refrescartabla()
{
tabla.ajax.reload();
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
            $.post("../ajax/boleta.php?op=baja&comentario="+result+"&hora="+cad, {idboleta : idboleta}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            }); 
        }
    }

});
}



function botonmes(valor)
{
            
var $vv='';

switch (valor){

    case '1':
    $vv = valor;
    break

    case '2':
    $vv = valor;
    break

    case '3':
    $vv = valor;
    break

    case '4':
    $vv = valor;
    break

    case '5':
    $vv = valor;
    break

    case '6':
    $vv = valor;
    break

    case '7':
    $vv = valor;
    break

    case '8':
    $vv = valor;
    break

    case '9':
    $vv = valor;
    break

    case '10':
    $vv = valor;
    break

    case '11':
    $vv = valor;
    break

    case '12':
    $vv = valor;
    break

    case '13':
    $vv = valor;
    break

    case '14':
    $vv = valor;
    break

    case '15':
    $vv = valor;
    break

    case '16':
    $vv = valor;
    break

    case '17':
    $vv = valor;
    break

    case '18':
    $vv = valor;
    break

    case '19':
    $vv = valor;
    break

    case '20':
    $vv = valor;
    break

    case '21':
    $vv = valor;
    break

    case '22':
    $vv = valor;
    break

    case '23':
    $vv = valor;
    break

    case '24':
    $vv = valor;
    break

    case '25':
    $vv = valor;
    break

    case '26':
    $vv = valor;
    break

    case '27':
    $vv = valor;
    break

    case '28':
    $vv = valor;
    break

    case '29':
    $vv = valor;
    break

    case '30':
    $vv = valor;
    break

    case '31':
    $vv = valor;
    break

    
    default:
    $vv = '1';

    
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
                    url: '../ajax/boleta.php?op=listarValidar&ano='+$ano+'&mes='+$mes+'&dia='+$vv,
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


        setInterval( function () {
        tabla.ajax.reload(null, false);
        }, 50000 );





//Funcion para enviararchivo xml a SUNAT
function mostrarxml(idboleta)
{

            $.post("../ajax/boleta.php?op=mostrarxml", {idboleta : idboleta}, function(e)
            {
                data=JSON.parse(e);
                
             if (data.rutafirma) {
              var rutacarpeta=data.rutafirma;
              $("#modalxml").attr('src',rutacarpeta);
              $("#modalPreviewXml").modal("show");
              $("#bajaxml").attr('href',rutacarpeta);  
              //bootbox.alert(data.cabextxml);
             }else{
                bootbox.alert(data.cabextxml);
             }   

              

            }
            ); 
}

//Funcion para enviararchivo xml a SUNAT
function mostrarrpta(idboleta)
{

            $.post("../ajax/boleta.php?op=mostrarrpta", {idboleta : idboleta}, function(e)
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
function generarxml(idboleta)
{
    bootbox.confirm("¿Está Seguro de generar el archivo XML.?", function(result){
        if(result)
        {
            $.post("../ajax/boleta.php?op=generarxml", {idboleta : idboleta}, function(e)
            {
                data=JSON.parse(e);
                bootbox.alert('Se ha generardo el archivo XML: <a href="'+data.cabextxml+'" download=" '+data.cabxml+'">" ARCHIVO XML:   '+data.cabxml+'"</a> de clic en el nombre para descargarlo.');
                tabla.ajax.reload();
            }); 
            refrescartabla();
        }
    })
    tabla.ajax.reload();
    refrescartabla();     
}



//Función para enviar respuestas por correo 
function enviarxmlSUNAT(idboleta)
{
    bootbox.confirm("¿Está Seguro de enviar archivo firmado a SUNAT?", function(result){
        if(result)
        {
            $.post("../ajax/boleta.php?op=enviarxmlSUNAT", {idboleta : idboleta}, function(e){
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
function regenerarxml(idboleta)
{
    bootbox.confirm("¿Está Seguro de generar el archivo XML.?", function(result){
        if(result)
        {
            $.post("../ajax/boleta.php?op=regenerarxml", {idboleta : idboleta}, function(e)
            {
                data=JSON.parse(e);
                bootbox.alert('Se ha generardo el archivo XML: <a href="'+data.cabextxml+'" download=" '+data.cabxml+'">" ARCHIVO XML:   '+data.cabxml+'"</a> de clic en el nombre para descargarlo.');
                tabla.ajax.reload();
            }); 
            refrescartabla();
        }
    })
    tabla.ajax.reload();
    refrescartabla();     
}



//Función para enviar respuestas por correo 
function enviarxmlSUNATbajas(idboleta)
{
    bootbox.confirm("¿Está Seguro de enviar archivo firmado a SUNAT?", function(result){
        if(result)
        {
            $.post("../ajax/boleta.php?op=enviarxmlSUNATbajas", {idboleta : idboleta}, function(e){
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

        function tipoenvio()
        {
            if ($("#fenvio").val()=='0')
            {
              envioautomatico();  
            }
        }


function envioautomatico()
{

    var $ano = $("#ano option:selected").text();
    var $mes = $("#mes option:selected").val();
    var $dia = $("#dia option:selected").val();

    var idocu = document.getElementsByName("idoculto[]");
    var stocu = document.getElementsByName("estadoocu[]");
    var chfact = document.getElementsByName("chid[]");

        for (var i = 0; i < idocu.length; i++) {
             var idA=idocu[i].value;
             var ESoc=stocu[i].value;
             var Chhid=chfact[i].checked;

    $.ajax({
        url: '../ajax/boleta.php?op=regenerarxmlEA&anO='+$ano+'&meS='+$mes+'&diA='+$dia+'&idComp='+idA+'&SToc='+ESoc+'&Ch='+Chhid,
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


function consultarcdr(idboleta)
{
    bootbox.confirm("Se consultará si existe el comprobante en SUNAT.", function(result){
        if(result)
        {
            $.post("../ajax/boleta.php?op=consultarcdr", {idboleta : idboleta}, function(e){
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




function cambiartarjetadc(idboleta)
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
            $.post("../ajax/boleta.php?op=cambiartarjetadc_&opcion="+result, {idboleta : idboleta}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            }); 
        }
    }

});
    
}




function montotarjetadc(idboleta)
{
    bootbox.prompt({
    title: "Desea modificar monto de pago con tarjeta",
    inputType: 'number',
    value: ['0'],
    callback: function (result) {
        if(result)
        {
            $.post("../ajax/boleta.php?op=montotarjetadc_&monto="+result, {idboleta : idboleta}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            }); 
        }
    }

});
    
}






function cambiartransferencia(idboleta)
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
            $.post("../ajax/boleta.php?op=cambiartransferencia&opcion="+result, {idboleta : idboleta}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            }); 
        }
    }

});
    
}




function montotransferencia(idboleta)
{
    bootbox.prompt({
    title: "Desea modificar monto de transferencia",
    inputType: 'number',
    value: ['0'],
    callback: function (result) {
        if(result)
        {
            $.post("../ajax/boleta.php?op=montotransferencia&monto="+result, {idboleta : idboleta}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            }); 
        }
    }

});
    
}


    $("#formulariorangos").on("submit",function(e)
    {
        guardarduplicarrangos(e);  
    });


    



function guardarduplicarrangos(e)
{
    e.preventDefault(); //
    var formData = new FormData($("#formulariorangos")[0]);

    $.ajax({
        url: "../ajax/boleta.php?op=guardarrangosfac",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos)
        {                    
              bootbox.alert(datos);  
              if (datos) {
                toastr.success('Se crearon duplicados');  
              }else{
                toastr.danger('Problemas al registrar');  
              }         
              tabla.ajax.reload();
        }

    });
    
    $("#Modalduplicar").modal('hide');

}






function duplicarbr()
{

$("#Modalduplicar").modal('show');
}
