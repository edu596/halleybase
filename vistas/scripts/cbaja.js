function init(){
  
$("#formulario").on("submit",function(e)
    {
        regcompras(e);  
    });   

var fecha = new Date();
var ano = fecha.getFullYear();
var mes=fecha.getMonth();
var dia=fecha.getDate();

$("#ano").val(ano);
$("#mes").val(mes+1);
$("#dia").val(dia);
regbajas();
}


function regbajas()
{

	var $ano = $("#ano option:selected").text();
	var $mes = $("#mes option:selected").val();
    var $dia = $("#dia option:selected").val();

    tabla=$('#tbllistado').dataTable(
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
                    url: '../ajax/cbaja.php?op=regbajas&ano='+$ano+'&mes='+$mes+'&dia='+$dia,
                    type : "post",
                    dataType : "json",                      
                    error: function(e){
                    console.log(e.responseText);    
                    }
               },

        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // converting to interger to find total
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Calculando subtotal
            var subtotal = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

                // Calculando igv
            var igv = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

                // Calculando total
            var total = api
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

                var subtotal2=currencyFormat(subtotal);
                var igv2=currencyFormat(igv);
                var total2=currencyFormat(total);
                    
            // Update footer by showing the total with the reference of the column index 
            //$( api.column( 0 ).footer() ).html('Total');
            $( api.column( 4 ).footer() ).html(subtotal2);
            $( api.column( 5 ).footer() ).html(igv2);
            $( api.column( 6 ).footer() ).html(total2);
            },

        "bDestroy": true,
        "iDisplayLength": 5,//Paginación
        "order": [[ 0, "desc" ]]//Ordenar (columna,orden)

    }).DataTable();
}

function currencyFormat (num) {
    return "S/ " + num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
}




function generarbajaxml()
{
    var $ano = $("#ano option:selected").text();
    var $mes = $("#mes option:selected").val();
    var $dia = $("#dia option:selected").val() ;

    bootbox.confirm("¿Está Seguro de generar el archivo XML.?", function(result){
        if(result)
        {
            $.post('../ajax/cbaja.php?op=generarbajaxml&ano='+$ano+'&mes='+$mes+'&dia='+$dia, function(e)
            {
                data=JSON.parse(e);
                bootbox.alert('<label>Se ha creado el archivo XML: </label> <a href="'+data.cabextxml+'" download="'+data.cabxml+'">" ARCHIVO XML: '+data.cabxml+'"</a></br></br> <h1>1.</h1><h4>Si desea enviar el archivo a SUNAT clic en enviar</h4> <button class="btn btn-danger" name="btnenviarxml" onclick="enviarxmlbajafactura(data.nombrea);">ENVIAR</button> </br></br> <h1>2.</h1><h4>Consulte el nro de ticket.</h4> <input class="form-control" id="nticket" name="nticket"> </br> <button class="btn btn-success" name="btnconsultaticket" id="btnconsultaticket" onclick="consultarnticket();">CONSULTAR</button>');
                tabla.ajax.reload();
            }); 
            //refrescartabla();
        }
    })
}




function enviarxmlbajafactura(nroxml)
{
    bootbox.confirm("¿Está Seguro de enviar archivo firmado a SUNAT?", function(result){
        if(result)
        {
            $.post("../ajax/cbaja.php?op=enviarxmlbajafactura&nombrexml="+nroxml, function(e){
                data2=JSON.parse(e);
                //bootbox.alert('El número de ticket es: '+data2.nroticket+'</br><button class="btn btn-danger" name="btnvalticket"  onclick="validarticket(data2.nroticket);"> VALIDAR TICKET </button>');
                bootbox.alert('Sus comprobantes han sido anulados. <br> El número de ticket es: <h1>'+data2.nroticket)+'</h1><br> Su comprobante se estará dando de baja guarde el número de ticket para cualquier consulta.';
                $("#nticket").val(data2.nroticket);
                tabla.ajax.reload();   
            }); 
        }
    })

    tabla=$('#tbllistadoxml').dataTable(
    {
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "bFilter": false,
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [],
        "ajax":
                {
                    url: '../ajax/cbaja.php?op=ultimoarchivoxml&ultimoxml='+nroxml,
                    type : "post",
                    dataType : "json",                      
                    error: function(e){
                    console.log(e.responseText);    
                    }
               }, "bDestroy": true, "iDisplayLength": 5, }).DataTable();
}


function consultarnticket()
{
    numeroticket=$("#nticket").val();
    bootbox.confirm("¿Desea consultar estado ticket?", function(result){
        if(result)
        {
        $.post("../ajax/cbaja.php?op=validarticket&ntikk="+numeroticket, function(e){
            data2=JSON.parse(e);
          //bootbox.alert(numeroticket);
          bootbox.alert(e);

        }); 
        }

    })
}




function detalle(idxml)
{
tabla=$('#tbllistadocomprobante').dataTable(
    {
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        "bFilter": false,
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [],
        "ajax":
                {
                    url: '../ajax/cbaja.php?op=detallecomprobante&idxml='+idxml,
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





 init();