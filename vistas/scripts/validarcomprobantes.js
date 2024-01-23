var fecha = new Date();
var ano = fecha.getFullYear();
//var mes=fecha.getFullMonth();
$("#ano").val(ano);
//$("#mes").val(mes);

listarValidarComprobantes();

// PARA LA VALIDACIOC ==================================================================




//Función Listar
function listarValidarComprobantes()
{
    var $estadoC = $("#estadoC").val();
    //var $estado = "1";
    tabla=$('#tbllistadoEstado').dataTable(
    {
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "deferLoading": 57,
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
                    dataType : "JSON",                      
                    error: function(e){
                    console.log(e.responseText);
                    tabla.ajax.reload();    
                    }
                },

        "bDestroy": true,
        "iDisplayLength": 20,//Paginación
        "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
    }).DataTable();
}




//Funcion para enviararchivo xml a SUNAT
function generarxml(idcomprobante, tipo_documento_07)
{
    bootbox.confirm("¿Está Seguro de generar el archivo XML.?", function(result){
        if(result)
        {
            $.post("../ajax/ventas.php?op=generarxml", {idcomprobante : idcomprobante,  tipo_documento_07 : tipo_documento_07},  function(e)
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
function enviarxmlSUNAT(idcomprobante, tipo_documento_07)
{
    bootbox.confirm("¿Está Seguro de enviar archivo firmado a SUNAT?", function(result){
        if(result)
        {
            $.post("../ajax/ventas.php?op=enviarxmlSUNAT", {idcomprobante : idcomprobante,  tipo_documento_07 : tipo_documento_07}, function(e)
            {
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
function mostrarxml(idcomprobante, tipo_documento_07)
{

            $.post("../ajax/ventas.php?op=mostrarxml", {idcomprobante : idcomprobante,  tipo_documento_07 : tipo_documento_07}, function(e)
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
function mostrarrpta(idcomprobante, tipo_documento_07)
{

            $.post("../ajax/ventas.php?op=mostrarrpta",  {idcomprobante : idcomprobante,  tipo_documento_07 : tipo_documento_07}, function(e)
            {
                data=JSON.parse(e);
                //bootbox.alert('Se ha generardo el archivo XML: '+data.rpta);
              var rptaS=data.rutaxmlr;
              $("#modalxml").attr('src',rptaS);
              $("#modalPreviewXml").modal("show");

            }
            ); 
}






function bajaComprobante(idcomprobante, tipo_documento_07)
{

    var f=new Date();
    cad=f.getHours()+":"+f.getMinutes()+":"+f.getSeconds(); 

    bootbox.prompt({
    title: "Escriba el motivo de baja.",
    inputType: 'textarea',
    callback: function (result) {
        if(result)
        {
            $.post("../ajax/ventas.php?op=bajaComprobante&comentario="+result+"&hora="+cad, {idcomprobante : idcomprobante,  tipo_documento_07 : tipo_documento_07}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            }); 
        }
    }

});
}

function refrescartabla()
{
tabla.ajax.reload();
}


function enviarcorreo(idfactura, idempresa)
{
    bootbox.confirm("¿Está Seguro de enviar correo al cliente?", function(result){
        if(result)
        {
            $.post("../ajax/ventas.php?op=enviarcorreo", {idfactura : idfactura, idempresa: idempresa}, function(e){
                bootbox.alert(e);
                tabla.ajax.reload();
            }); 
        }
    })
}

