var tabla;
var tabla2;
$idempresa=$("#idempresa").val();
xocdTods="";

function init()
{



$("#formulario").on("submit",function(e)
    {
        
    });  


var fecha = new Date();
var ano = fecha.getFullYear();
$("#ano").val(ano);

var mes = fecha.getMonth() + 1;
var dia = fecha.getDate();


	var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today1 = now.getFullYear()+"-"+(month)+"-01" ;
    var today2 = now.getFullYear()+"-"+(month)+"-"+(day) ;

$("#fecha1").val(today1);
$("#fecha2").val(today2);

    listartcomprobantes();

}


function checkcambioum(){
        var ch1 = document.getElementById("cbox1").checked; 
       //var ch2 = document.getElementById("cbox2").checked; 
}


function checkcambioum2(){
        var ch2 = document.getElementById("cbox2").checked; 

    if (ch2=="true") {
        $("#cbox1").attr("checked", false);
    }
}




function editarcuotas(idcomprobante, tipocomprobante, numerocomp,   fechae, fechaa, 
            cliente,
            total)
  {


    $('#ncomprobante').val(numerocomp);
    $('#fechacomprobante').val(fechaa);
    $('#clientec').val(cliente);
    $('#totalcomp').val(total);

   tabla2=$('#tbllistado2').dataTable(
    {
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
         'bFilter': false,
        dom: 'Bfrtip',//Definimos los elementos del control de tabla

        "language": { 
            'loadingRecords': '&nbsp;',
            'processing': '<i class="fa fa-spinner fa-spin"></i> Procesando datos'

        },

        buttons: [     

                    
                    
                ],
        "ajax":
                {
                    url: '../ajax/cuotas.php?op=buscarcuotas&idcompp='+idcomprobante+'&tipcc='+tipocomprobante,
                    type : "post",
                    dataType : "json",                      
                    error: function(e){
                    console.log(e.responseText);    
                    }
               },

        

        "bDestroy": true,
        "iDisplayLength": 5,//Paginación
        "order": [[ 0, "asc" ]]//Ordenar (columna,orden)

    }).DataTable();
    
    
        $("#modalcuotas").modal('show');
    
  }







function listartcomprobantes() 
{ 

    var $fecha1 = $("#fecha1").val();
    var $fecha2 = $("#fecha2").val();
    var $tipocomp = $("#tcomprobante option:selected").val();
    var $moneda = $("#tmonedaa option:selected").val();

    tabla=$('#tbllistado').dataTable(
    {
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla

        "language": { 
            'loadingRecords': '&nbsp;',
            'processing': '<i class="fa fa-spinner fa-spin"></i> Procesando datos'
        },

        buttons: [     

                    'copyHtml5',
                    'excelHtml5',
                    'pdf'           
                    
                ],
        "ajax":
                {
                    url: '../ajax/cuotas.php?op=listartcomprobantesC&fec1='+$fecha1+'&fec2='+$fecha2+'&mon='+$moneda+'&tipc='+$tipocomp,
                    type : "post",
                    dataType : "json",                      
                    error: function(e){
                    console.log(e.responseText);    
                    }
               },

        

        "bDestroy": true,
        "iDisplayLength": 5,//Paginación
        "order": [[ 1, "desc" ]]//Ordenar (columna,orden)

    }).DataTable();
}




function currencyFormat (num) {
    return "" + num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
}


function cuotapagada(idcuota, idcomprobante, tipocomprobante)
{
     bootbox.confirm("¿Quiere pagar la cuota?", function(result){
        if(result)
        {
          $.post("../ajax/cuotas.php?op=cuotapagada&idc1="+idcuota+
            "&idco1="+idcomprobante+"&tipcoo2="+tipocomprobante, function(r)
          {
            tabla.ajax.reload();
            tabla2.ajax.reload();
          })
        }
    })

}



function cancelarpago(idcuota,  idcomprobante, tipocomprobante)
{
     bootbox.confirm("¿Quiere cancelar el pago?", function(result){
        if(result)
        {
          $.post("../ajax/cuotas.php?op=cancelarpag&idc1="+idcuota+
            "&idco1="+idcomprobante+"&tipcoo2="+tipocomprobante, function(r)
          {
            tabla.ajax.reload();
            tabla2.ajax.reload();
          })
        }
    })

}

init();