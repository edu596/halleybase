function init(){
  
$("#formulario").on("submit",function(e)
    {
        regbajas(e);  
    });   

var fecha = new Date();
var ano = fecha.getFullYear();
$("#ano").val(ano);
var mes = fecha.getMonth();
$("#mes").val(mes + 1);
var dia = fecha.getDate();
$("#dia").val(dia);
regbajas();
}


function regbajas()
{

	var $ano = $("#ano option:selected").text();
	var $mes = $("#mes option:selected").val();
    var $dia = $("#dia option:selected").val();
    var stad = $("#estadoD option:selected").val();

    tabla=$('#tbllistado').dataTable(
    {
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla

        buttons: [                
                    
                ],
        "ajax":
                {
url: '../ajax/resumend.php?op=resumend&ano='+$ano+'&mes='+$mes+'&dia='+$dia+'&sst='+stad,
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

function currencyFormat (num) {
    return "S/ " + num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
}



function generarbajaxml()
{
    var $ano = $("#ano option:selected").text();
    var $mes = $("#mes option:selected").val();
    var $dia = $("#dia option:selected").val();
    var $sta = $("#estadoD option:selected").val();

    bootbox.confirm("¿Está Seguro de generar el archivo XML.?", function(result){
        if(result)
        {
            $.post('../ajax/resumend.php?op=generarbajaxml&ano='+$ano+'&mes='+$mes+'&dia='+$dia+'&stb='+$sta, function(e)
            {
                data=JSON.parse(e);
                bootbox.alert('<label>Se ha creado el archivo XML: </label> <a href="'+data.cabextxml+'" download="'+data.cabxml+'">" ARCHIVO XML: '+data.cabxml+'"</a></br></br> <h1>1.</h1><h4>Si desea enviar el archivo a SUNAT clic en enviar</h4> <button class="btn btn-danger"  id="btnenviarxml" name="btnenviarxml" onclick="enviarxmlbajaboleta(data.nombrea);">ENVIAR</button> </br></br> <h1>2.</h1><h4>Consulte el nro de ticket.</h4> <input class="form-control" id="nticket" name="nticket"> </br> <button class="btn btn-success" name="btnconsultaticket" id="btnconsultaticket" onclick="consultarnticket();">CONSULTAR</button>');
                //bootbox.alert(e);
                tabla.ajax.reload();
            }); 
        }
    })
}




function enviarxmlbajaboleta(nroxml)
{
    bootbox.confirm("¿Está Seguro de enviar archivo firmado a SUNAT?", function(result){
        if(result)
        {
            $.post("../ajax/resumend.php?op=enviarxmlbajaboleta&nombrexml="+nroxml, function(e){
                data2=JSON.parse(e);
                bootbox.alert('El número de ticket es: <h1>'+data2.nroticket)+'</h1>';
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
                    url: '../ajax/resumend.php?op=ultimoarchivoxml&ultimoxml='+nroxml,
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
        $.post("../ajax/resumend.php?op=validarticket&ntikk="+numeroticket, function(e){
            data2=JSON.parse(e);
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
                    url: '../ajax/resumend.php?op=detallecomprobante&idxml='+idxml,
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