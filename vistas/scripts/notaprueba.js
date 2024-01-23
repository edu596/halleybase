var tabla;

function listarComprobante()
{
    tabla=$('#tabla').dataTable(
    {

        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [                
                     
                ],
        "ajax":
                {
                    url: '../ajax/notac.php?op=listarComprobanteFactura',
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


function agregarComprobanteFactura(idcomprobante,tipo_documento,numero_documento,razon_social, tipocomp, numerodoc, cantidad, codigo, descripcion, vui, igvi, pvi, subtotal, igv, total)
  {
    
     if (idcomprobante!="")
    {
        $('#idcomprobante').val(idcomprobante);
        $('#numero_documento').val(numero_documento);
        $('#razon_social').val(razon_social);
        $("#myModal").modal('hide');
        
    }
    else
    {
        alert("Error al ingresar el detalle, revisar los datos del cliente");
    }
  }