var tabla;
$idempresa=$("#idempresa").val();
xocdTods="";

function init()
{

$("#formulario").on("submit",function(e)
    {
        regcompras(e);  
    });  


var fecha = new Date();
var ano = fecha.getFullYear();
$("#ano").val(ano);

var mes = fecha.getMonth() + 1;
var dia = fecha.getDate();
$("#ano").val(ano);
$("#mes").val(mes);
$("#dia").val(dia);


    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);


var anoactual=ano+"-01-01";
$("#fecha1").val(anoactual);
var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
$("#fecha2").val(today);


$.post("../ajax/inventarios.php?op=selectAlm", function(r){
            $("#almacenlista").html(r);
            $('#almacenlista').selectpicker('refresh');

});

// alma=$("#almacenlista").val();
// $.post("../ajax/articulo.php?op=comboarticulo&anor="+ano+"&aml="+alma, function(r){
// $("#codigoInterno").html(r);
// $("#codigoInterno").selectpicker('refresh');
// });
// });


$.post("../ajax/articulo.php?op=comboarticulokardex", function(r){
$("#codigoInterno").html(r);
$("#codigoInterno").selectpicker('refresh');
});

regventas();

}



// function cambioano() 
// {
// $.post("../ajax/articulo.php?op=comboarticulokardex", function(r){
// $("#codigoInterno").html(r);
// $("#codigoInterno").selectpicker('refresh');
// });

// }


function actualizarartialma()
{
alma=$("#almacenlista").val();
$.post("../ajax/articulo.php?op=comboarticulo&anor="+ano+"&aml="+alma, function(r){
$("#codigoInterno").html(r);
$("#codigoInterno").selectpicker('refresh');
});


}


let onOff = true;
function selectO(){
    if (!onOff) {

        onOff=true;
        xocdTods="xcod";
        
        resetearvalores();
        
    }else{

        onOff=false;
        
        xocdTods="xtod";
        resetearvalores();
        
        
    }
    }





function mostrarumedidas(){

var codigo = $("#codigoInterno").val();
//var codigo = "RR50";

$.post("../ajax/inventarios.php?op=selectUnidadum1&codaum1="+codigo, function(data,status){
    data=JSON.parse(data);
$("#cbox1").val(data.abre);
$("#umedida1").text(data.nombreum);
});


$.post("../ajax/inventarios.php?op=selectUnidadum2&codaum2="+codigo, function(data,status){
    data=JSON.parse(data);
$("#cbox2").val(data.abre);
$("#umedida2").text(data.nombreum);
});

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






function enviar() {

document.formEnviar.action = "../reportes/RegistroVentas.php";
document.formEnviar.target = "_blank";
document.formEnviar.submit();

document.formEnviar.action = "../reportes/PDF_MC_Table.php";
document.formEnviar.target = "_self";
document.formEnviar.submit(); 

return true;

}

function enviarKardex() {

document.formEnviar.action = "../reportes/kardexArticulo.php";
document.formEnviar.target = "_blank";
document.formEnviar.submit();

document.formEnviar.action = "../reportes/PDF_MC_Table5.php";
document.formEnviar.target = "_self";
document.formEnviar.submit(); 

return true;

}



function regcompras()
{

	var $ano = $("#ano option:selected").text();
	var $mes = $("#mes option:selected").val();
    var $moneda = $("#moneda option:selected").val();

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
                    url: '../ajax/inventarios.php?op=regcompras&ano='+$ano+'&mes='+$mes+'&moneda='+$moneda+'&idempresa='+$idempresa,
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
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

                // Calculando igv
            var igv = api
                .column( 7 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

                // Calculando total
            var total = api
                .column( 8 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );


                var subtotal2=subtotal;
                var igv2=igv;
                var total2=total;
        
                    
            // Update footer by showing the total with the reference of the column index 
            //$( api.column( 0 ).footer() ).html('Total');
            $( api.column( 6 ).footer() ).html(subtotal2);
            $( api.column( 7 ).footer() ).html(igv2);
            $( api.column( 8 ).footer() ).html(total2);
            },

        "bDestroy": true,
        "iDisplayLength": 5,//Paginación
        "order": [[ 0, "asc" ]]//Ordenar (columna,orden)

    }).DataTable();
}





//Funcioón para registro de ventas en menu VENTAS
function  regventas() //ventasxdia.php
{

     $("#fila0").remove();
    $("#fila1").remove();
    $("#fila2").remove();
    $("#fila3").remove();
    $("#fila4").remove();
    $("#fila5").remove();

    $("#fila6").remove();
    $("#fila7").remove();
    $("#fila8").remove();
    $("#fila9").remove();
    $("#fila10").remove();
    $("#fila11").remove();

    

	var $ano = $("#ano option:selected").text();
	var $mes = $("#mes option:selected").val();
    var $dia = $("#dia option:selected").val();
    var $tmoneda = $("#tmonedaa option:selected").val();
    //Para prodcutos=================================================================================
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
                    url: '../ajax/inventarios.php?op=regventas&ano='+$ano+'&mes='+$mes+'&dia='+$dia+'&idempresa='+$idempresa+'&tmon='+$tmoneda,
                    type : "post",
                    dataType : "json",                      
                    error: function(e){
                    console.log(e.responseText);    
                    }
               },

        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
            var subtotal = api
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            var igv = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

                // Calculando total
            var total = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                var subtotal2=currencyFormat(subtotal);
                var igv2=currencyFormat(igv);
                var total2=currencyFormat(total);
            $( api.column( 2 ).footer() ).html(subtotal2);
            $( api.column( 3 ).footer() ).html(igv2);
            $( api.column( 4 ).footer() ).html(total2);
            },
        "bDestroy": true,
        "iDisplayLength": 5,//Paginación
        "order": [[ 0, "asc" ]]//Ordenar (columna,orden)
    }).DataTable();
//Para prodcutos=================================================================================

//Para servicios=================================================================================
    tabla=$('#tbllistadoservicio').dataTable(
    {
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        buttons: [    

                    'copyHtml5',
                    'excelHtml5',
                    'pdf'            
                ],
        "ajax":
                {
                    url: '../ajax/inventarios.php?op=regventas&ano='+$ano+'&mes='+$mes+'&dia='+$dia+'&idempresa='+$idempresa,
                    type : "post",
                    dataType : "json",                      
                    error: function(e){
                    console.log(e.responseText);    
                    }
               },

        "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
            var subtotal = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
            var igv = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

                // Calculando total
            var total = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                var subtotal2=currencyFormat(subtotal);
                var igv2=currencyFormat(igv);
                var total2=currencyFormat(total);
            $( api.column( 3 ).footer() ).html(subtotal2);
            $( api.column( 4 ).footer() ).html(igv2);
            $( api.column( 5 ).footer() ).html(total2);
            },
        "bDestroy": true,
        "iDisplayLength": 5,//Paginación
        "order": [[ 0, "asc" ]]//Ordenar (columna,orden)
    }).DataTable();
//Para servicios=================================================================================

regventasmes();
}



function regvenagruxdia() 
{ 

    var $ano = $("#ano option:selected").text();
    var $mes = $("#mes option:selected").val();
    var $dia = $("#dia option:selected").val();
    var $tm = $("#tmonedaa option:selected").val();

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
                    url: '../ajax/inventarios.php?op=regvenagruxdia&ano='+$ano+'&mes='+$mes+'&dia='+$dia+'&idempresa='+$idempresa+'&tmn='+$tm,
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
                .column( 1 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

                // Calculando igv
            var igv = api
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

                // Calculando total
            var total = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

                var subtotal2=currencyFormat(subtotal);
                var igv2=currencyFormat(igv);
                var total2=currencyFormat(total);
                    
            // Update footer by showing the total with the reference of the column index 
            //$( api.column( 0 ).footer() ).html('Total');
            $( api.column( 1 ).footer() ).html(subtotal2);
            $( api.column( 2 ).footer() ).html(igv2);
            $( api.column( 3 ).footer() ).html(total2);
            },

        "bDestroy": true,
        "iDisplayLength": 5,//Paginación
        "order": [[ 0, "asc" ]]//Ordenar (columna,orden)

    }).DataTable();
}




function currencyFormat (num) {
    return "" + num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
}


function regcompra(e)
{
    e.preventDefault(); //No se activará la acción predeterminada del evento
    //$("#btnGuardar").prop("disabled",true);
        
    var formData = new FormData($("#formulario")[0]);
 
    $.ajax({
        url: "../ajax/inventarios.php?op=regcompras",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function(datos)
        {                    

              listar();
              
        }

    });

 }



 function calcularkardex() 
{ 
    var $codigo = $("#codigoInterno").val();
    var $ano = $("#ano").val();
    var $xcod = $("#xcodigot").val();
    var almlist = $("#almacenlista").val();

        
    tabla=$('#tbllistadokardex').dataTable(

    {

        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla
        // "processing": true,
        // "language": { 
        //     'loadingRecords': '&nbsp;',
        //     'processing': '<i class="fa fa-spinner fa-spin"></i> Procesando datos.. espere'
        // },
         //"scrollX": true,
        "scrollY":        "200px",
        "scrollCollapse": true,
        "paging":         false,


        buttons: [  

        'copyHtml5',
                    'excelHtml5',
                    'pdf'     

                ],
        "ajax":
                {
                    url: '../ajax/inventarios.php?op=consultakardexcodigo&cod='+$codigo+'&ano='+$ano+'&xct='+$xcod+'&aalml='+almlist,
                    type : "post",
                    dataType : "json",                      
                    error: function(e){
                    console.log(e.responseText);    
                    
                    }
               },

        "bDestroy": true,
        "iDisplayLength": 4,//Paginación
        "order": [[ 0, "asc" ]]//Ordenar (columna,orden)
    }
    ).DataTable();
    
    tabla.ajax.reload();    

}



function cargarumedida(){

}





 init();











 //Función ListarArticulos
function listarArticulos()
{
    $tipoprecio=$('#tipoprecio').val(); 
    tablaArti=$('#tblarticulos').dataTable(
    {
        retrieve: true,
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla

        "language": { 
            'loadingRecords': '&nbsp;',
            'processing': '<i class="fa fa-spinner fa-spin"></i> Procesando datos'
        },


        buttons: [                
                ],
        "ajax":
                {
                    url: '../ajax/factura.php?op=listarArticulosfacturaItem&tipoprecio='+$tipoprecio,
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
        "order": [[ 0, "desc" ]]//Ordenar (columna,orden)

    }
    ).DataTable();

$('#tblarticulos').DataTable().ajax.reload();

//controlastock();
}



function consultacomprobantes()
{

    var $ano = $("#ano option:selected").text();
    var $mes = $("#mes option:selected").val();
    var $dia = $("#dia option:selected").val();
    var $comprobante = $("#comprobante option:selected").val();
    var $estado = $("#estadoC option:selected").val();

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
                    'csvHtml5',
                    'pdf'
                ],
        "ajax":
                {
                    url: '../ajax/inventarios.php?op=descargarcomprobante&ano='+$ano+'&mes='+$mes+'&dia='+$dia+'&comprobante='+$comprobante+'&estado='+$estado,
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


function separator(numb) {
    var str = numb.toString().split(".");
    str[0] = str[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return str.join(".");
}



function regventasmes() // FORMULARIO DE REGISTRO DE VENTA X DÍA
{
    $("#fila0").remove();
    $("#fila1").remove();
    $("#fila2").remove();
    $("#fila3").remove();
    $("#fila4").remove();
    $("#fila5").remove();

    $("#fila6").remove();
    $("#fila7").remove();
    $("#fila8").remove();
    $("#fila9").remove();
    $("#fila10").remove();
    $("#fila11").remove();


    var $ano = $("#ano option:selected").text();
    var $mes = $("#mes option:selected").val();
    var $dia = $("#dia option:selected").val();
    var $tmoneda = $("#tmonedaa option:selected").val();
    //Para prodcutos=================================================================================


$.post("../ajax/inventarios.php?op=totalpordiames&ano="+$ano+'&mes='+$mes+'&mmon='+$tmoneda, function(data, status){

data=JSON.parse(data);
t1=0;t2=0;t3=0;t4=0;t5=0;t6=0;t7=0;t8=0;t9=0;t10=0;t11=0;t12=0;t13=0;t14=0;t15=0;t16=0;t17=0;t18=0;t19=0;
t20=0;t21=0;t22=0;t23=0;t24=0;t25=0;t26=0;t27=0;t28=0;t29=0;t30=0;t31=0;
   $.each(data["aaData"], function(i, item) {
    //alert(item[1]);
    diaventa=item[1];

    nombredia=item[2];
    

    switch (diaventa){
        case '1':
           t1=item[0]; 
        break;
        case '2':
           t2=item[0]; 
        break;
        case '3':
           t3=item[0]; 
        break;
        case '4':
           t4=item[0]; 
        break;
        case '5':
           t5=item[0]; 
        break;
        case '6':
           t6=item[0]; 
        break;
        case '7':
           t7=item[0]; 
        break;
        case '8':
           t8=item[0]; 
        break;
        case '9':
           t9=item[0]; 
        break;
        case '10':
           t10=item[0]; 
        break;
        case '11':
           t11=item[0]; 
        break;
        case '12':
           t12=item[0]; 
        break;
        case '13':
           t13=item[0]; 
        break;
        case '14':
           t14=item[0]; 
        break;
        case '15':
           t15=item[0]; 
        break;
        case '16':
           t16=item[0]; 
        break;
        case '17':
           t17=item[0]; 
        break;
        case '18':
           t18=item[0]; 
        break;
        case '19':
           t19=item[0]; 
        break;
        case '20':
           t20=item[0]; 
        break;
        case '21':
           t21=item[0]; 
        break;
        case '22':
           t22=item[0]; 
        break;
        case '23':
           t23=item[0]; 
        break;
        case '24':
           t24=item[0]; 
        break;
        case '25':
           t25=item[0]; 
        break;
        case '26':
           t26=item[0]; 
        break;
        case '27':
           t27=item[0]; 
        break;
        case '28':
           t28=item[0]; 
        break;
        case '29':
           t29=item[0]; 
        break;
        case '30':
           t30=item[0]; 
        break;
        case '31':
           t31=item[0]; 
        break;
    }
    });

   resutot=parseFloat(t1)+parseFloat(t2)+parseFloat(t3)+parseFloat(t4)+parseFloat(t5)+parseFloat(t6)+parseFloat(t7)+parseFloat(t8)+parseFloat(t9)+parseFloat(t10)+parseFloat(t11)+parseFloat(t12)+parseFloat(t13)+parseFloat(t14)+parseFloat(t15)+parseFloat(t16)+parseFloat(t17)+parseFloat(t18)+parseFloat(t19)+parseFloat(t20)+parseFloat(t21)+parseFloat(t22)+parseFloat(t23)+parseFloat(t24)+parseFloat(t25)+parseFloat(t26)+parseFloat(t27)+parseFloat(t28)+parseFloat(t29)+parseFloat(t30)+parseFloat(t31);

        
$.post("../ajax/inventarios.php?op=totalmesfactura&ano="+$ano+'&mes='+$mes+'&mmon='+$tmoneda, function(data, status){
data=JSON.parse(data);
tf1=0;tf2=0;tf3=0;tf4=0;tf5=0;tf6=0;tf7=0;tf8=0;tf9=0;tf10=0;tf11=0;tf12=0;tf13=0;tf14=0;tf15=0;tf16=0;tf17=0;tf18=0;tf19=0;
tf20=0;tf21=0;tf22=0;tf23=0;tf24=0;tf25=0;tf26=0;tf27=0;tf28=0;tf29=0;tf30=0;tf31=0;
   $.each(data["aaData"], function(i, item) {
    //alert(item[1]);
    diaventa=item[1];
    switch (diaventa){
        case '1':
           tf1=item[0]; 
        break;
        case '2':
           tf2=item[0]; 
        break;
        case '3':
           tf3=item[0]; 
        break;
        case '4':
           tf4=item[0]; 
        break;
        case '5':
           tf5=item[0]; 
        break;
        case '6':
           tf6=item[0]; 
        break;
        case '7':
           tf7=item[0]; 
        break;
        case '8':
           tf8=item[0]; 
        break;
        case '9':
           tf9=item[0]; 
        break;
        case '10':
           tf10=item[0]; 
        break;
        case '11':
           tf11=item[0]; 
        break;
        case '12':
           tf12=item[0]; 
        break;
        case '13':
           tf13=item[0]; 
        break;
        case '14':
           tf14=item[0]; 
        break;
        case '15':
           tf15=item[0]; 
        break;
        case '16':
           tf16=item[0]; 
        break;
        case '17':
           tf17=item[0]; 
        break;
        case '18':
           tf18=item[0]; 
        break;
        case '19':
           tf19=item[0]; 
        break;
        case '20':
           tf20=item[0]; 
        break;
        case '21':
           tf21=item[0]; 
        break;
        case '22':
           tf22=item[0]; 
        break;
        case '23':
           tf23=item[0]; 
        break;
        case '24':
           tf24=item[0]; 
        break;
        case '25':
           tf25=item[0]; 
        break;
        case '26':
           tf26=item[0]; 
        break;
        case '27':
           tf27=item[0]; 
        break;
        case '28':
           tf28=item[0]; 
        break;
        case '29':
           tf29=item[0]; 
        break;
        case '30':
           tf30=item[0]; 
        break;
        case '31':
           tf31=item[0]; 
        break;
    }

    //resufac=parseFloat(item[0]);
    });
   //resufac++
   resufac=parseFloat(tf1)+parseFloat(tf2)+parseFloat(tf3)+parseFloat(tf4)+parseFloat(tf5)+parseFloat(tf6)+parseFloat(tf7)+parseFloat(tf8)+parseFloat(tf9)+parseFloat(tf10)+parseFloat(tf11)+parseFloat(tf12)+parseFloat(tf13)+parseFloat(tf14)+parseFloat(tf15)+parseFloat(tf16)+parseFloat(tf17)+parseFloat(tf18)+parseFloat(tf19)+parseFloat(tf20)+parseFloat(tf21)+parseFloat(tf22)+parseFloat(tf23)+parseFloat(tf24)+parseFloat(tf25)+parseFloat(tf26)+parseFloat(tf27)+parseFloat(tf28)+parseFloat(tf29)+parseFloat(tf30)+parseFloat(tf31);



   $.post("../ajax/inventarios.php?op=totalmesboleta&ano="+$ano+'&mes='+$mes+'&mmon='+$tmoneda, function(data, status){
data=JSON.parse(data);
tb1=0;tb2=0;tb3=0;tb4=0;tb5=0;tb6=0;tb7=0;tb8=0;tb9=0;tb10=0;tb11=0;tb12=0;tb13=0;tb14=0;tb15=0;tb16=0;tb17=0;tb18=0;tb19=0;
tb20=0;tb21=0;tb22=0;tb23=0;tb24=0;tb25=0;tb26=0;tb27=0;tb28=0;tb29=0;tb30=0;tb31=0;
   $.each(data["aaData"], function(i, item) {
    //alert(item[1]);
    diaventa=item[1];
   

    switch (diaventa){
        case '1':
           tb1=item[0]; 
        break;
        case '2':
           tb2=item[0]; 
        break;
        case '3':
           tb3=item[0]; 
        break;
        case '4':
           tb4=item[0]; 
        break;
        case '5':
           tb5=item[0]; 
        break;
        case '6':
           tb6=item[0]; 
        break;
        case '7':
           tb7=item[0]; 
        break;
        case '8':
           tb8=item[0]; 
        break;
        case '9':
           tb9=item[0]; 
        break;
        case '10':
           tb10=item[0]; 
        break;
        case '11':
           tb11=item[0]; 
        break;
        case '12':
           tb12=item[0]; 
        break;
        case '13':
           tb13=item[0]; 
        break;
        case '14':
           tb14=item[0]; 
        break;
        case '15':
           tb15=item[0]; 
        break;
        case '16':
           tb16=item[0]; 
        break;
        case '17':
           tb17=item[0]; 
        break;
        case '18':
           tb18=item[0]; 
        break;
        case '19':
           tb19=item[0]; 
        break;
        case '20':
           tb20=item[0]; 
        break;
        case '21':
           tb21=item[0]; 
        break;
        case '22':
           tb22=item[0]; 
        break;
        case '23':
           tb23=item[0]; 
        break;
        case '24':
           tb24=item[0]; 
        break;
        case '25':
           tb25=item[0]; 
        break;
        case '26':
           tb26=item[0]; 
        break;
        case '27':
           tb27=item[0]; 
        break;
        case '28':
           tb28=item[0]; 
        break;
        case '29':
           tb29=item[0]; 
        break;
        case '30':
           tb30=item[0]; 
        break;
        case '31':
           tb31=item[0]; 
        break;
    }
    });

   resubol=parseFloat(tb1)+parseFloat(tb2)+parseFloat(tb3)+parseFloat(tb4)+parseFloat(tb5)+parseFloat(tb6)+parseFloat(tb7)+parseFloat(tb8)+parseFloat(tb9)+parseFloat(tb10)+parseFloat(tb11)+parseFloat(tb12)+parseFloat(tb13)+parseFloat(tb14)+parseFloat(tb15)+parseFloat(tb16)+parseFloat(tb17)+parseFloat(tb18)+parseFloat(tb19)+parseFloat(tb20)+parseFloat(tb21)+parseFloat(tb22)+parseFloat(tb23)+parseFloat(tb24)+parseFloat(tb25)+parseFloat(tb26)+parseFloat(tb27)+parseFloat(tb28)+parseFloat(tb29)+parseFloat(tb30)+parseFloat(tb31);


   var $mes2 = $("#mes option:selected").text();

$('#tbllistadoventaxdia').append(
    '<tr id="fila0" style="font-family: Arial; font-size: 0.7em; font-size: 1.5em;">'+  
    '<th colspan="7">MES: '+$mes2+'</th></tr>');

$('#tbllistadoventaxdia').append(
    '<tr id="fila1"><th style="font-family: Arial; font-size: 0.7em; font-size: 0.7em; background-color: #fec5bb;">'+
    'DIA 01  <br>T. FACTURA: '+separator(tf1)+'<br>T. BOLETA: '+separator(tb1)+' <br>TOTAL DIA: '+separator(t1)+'</th>'+
    '<th style="font-family: Arial; font-size: 0.7em; background-color: #ffe5d9;">DIA 02 <br>T. FACTURA: '+separator(tf2)+'<br>T. BOLETA: '+separator(tb2)+' <br>TOTAL DIA: '+separator(t2)+'</th>'+
    '<th style="font-family: Arial; font-size: 0.7em; background-color: #fec5bb; ">DIA 03 <br>T. FACTURA: '+separator(tf3)+'<br>T. BOLETA: '+separator(tb3)+' <br>TOTAL DIA: '+separator(t3)+'</th>'+
    '<th style="font-family: Arial; font-size: 0.7em; background-color: #ffe5d9; ">DIA 04 <br>T. FACTURA: '+separator(tf4)+'<br>T. BOLETA: '+separator(tb4)+' <br>TOTAL DIA: '+separator(t4)+'</th>'+
    '<th style="font-family: Arial; font-size: 0.7em; background-color: #fec5bb; ">DIA 05 <br>T. FACTURA: '+separator(tf5)+'<br>T. BOLETA: '+separator(tb5)+' <br>TOTAL DIA: '+separator(t5)+'</th>'+
    '<th style="font-family: Arial; font-size: 0.7em; background-color: #ffe5d9; ">DIA 06 <br>T. FACTURA: '+separator(tf6)+'<br>T. BOLETA: '+separator(tb6)+' <br>TOTAL DIA: '+separator(t6)+'</th>'+
    '<th style="font-family: Arial; font-size: 0.7em; background-color: #fec5bb; ">DIA 07 <br>T. FACTURA: '+separator(tf7)+'<br>T. BOLETA: '+separator(tb7)+' <br>TOTAL DIA: '+separator(t7)+'</th></tr>');

$('#tbllistadoventaxdia').append(
'<tr id="fila2"><th style="font-family: Arial; font-size: 0.7em; background-color: #fec5bb; ">DIA 08  <br>T. FACTURA: '+separator(tf8)+'<br>T. BOLETA: '+separator(tb8)+' <br>TOTAL DIA: '+separator(t8)+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #ffe5d9; ">DIA 09  <br>T. FACTURA: '+separator(tf9)+'<br>T. BOLETA: '+separator(tb9)+' <br>TOTAL DIA: '+separator(t9)+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #fec5bb; ">DIA 10 <br>T. FACTURA: '+separator(tf10)+'<br>T. BOLETA: '+separator(tb10)+' <br>TOTAL DIA: '+separator(t10)+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #ffe5d9; ">DIA 11 <br>T. FACTURA: '+separator(tf11)+'<br>T. BOLETA: '+separator(tb11)+' <br>TOTAL DIA: '+separator(t11)+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #fec5bb; ">DIA 12 <br>T. FACTURA: '+separator(tf12)+'<br>T. BOLETA: '+separator(tb12)+' <br>TOTAL DIA: '+separator(t12)+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #ffe5d9; ">DIA 13 <br>T. FACTURA: '+separator(tf13)+'<br>T. BOLETA: '+separator(tb13)+' <br>TOTAL DIA: '+separator(t13)+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #fec5bb; ">DIA 14 <br>T. FACTURA: '+separator(tf14)+'<br>T. BOLETA: '+separator(tb14)+' <br>TOTAL DIA: '+separator(t14)+'</th></tr>');

$('#tbllistadoventaxdia').append(
'<tr id="fila3"><th style="font-family: Arial; font-size: 0.7em; background-color: #fec5bb; ">DIA 15  <br>T. FACTURA: '+separator(tf15)+'<br>T. BOLETA: '+separator(tb15)+' <br>TOTAL DIA: '+separator(t15)+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #ffe5d9; ">DIA 16  <br>T. FACTURA: '+separator(tf16)+'<br>T. BOLETA: '+separator(tb16)+' <br>TOTAL DIA: '+separator(t16)+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #fec5bb; ">DIA 17 <br>T. FACTURA: '+separator(tf17)+'<br>T. BOLETA: '+separator(tb17)+' <br>TOTAL DIA: '+separator(t17)+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #ffe5d9; ">DIA 18 <br>T. FACTURA: '+separator(tf18)+'<br>T. BOLETA: '+separator(tb18)+' <br>TOTAL DIA: '+separator(t18)+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #fec5bb; ">DIA 19 <br>T. FACTURA: '+separator(tf19)+'<br>T. BOLETA: '+separator(tb19)+' <br>TOTAL DIA: '+separator(t19)+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #ffe5d9; ">DIA 20 <br>T. FACTURA: '+separator(tf20)+'<br>T. BOLETA: '+separator(tb20)+' <br>TOTAL DIA: '+separator(t20)+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #fec5bb; ">DIA 21 <br>T. FACTURA: '+separator(tf21)+'<br>T. BOLETA: '+separator(tb21)+' <br>TOTAL DIA: '+separator(t21)+'</th></tr>');

$('#tbllistadoventaxdia').append(
'<tr id="fila4"><th style="font-family: Arial; font-size: 0.7em; background-color: #fec5bb; ">DIA 22  <br>T. FACTURA: '+separator(tf22)+'<br>T. BOLETA: '+separator(tb22)+' <br>TOTAL DIA: '+separator(t22)+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #ffe5d9; ">DIA 23  <br>T. FACTURA: '+separator(tf23)+'<br>T. BOLETA: '+separator(tb23)+' <br>TOTAL DIA: '+separator(t23)+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #fec5bb; ">DIA 24 <br>T. FACTURA: '+separator(tf24)+'<br>T. BOLETA: '+separator(tb24)+' <br>TOTAL DIA: '+separator(t24)+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #ffe5d9; ">DIA 25 <br>T. FACTURA: '+separator(tf25)+'<br>T. BOLETA: '+separator(tb25)+' <br>TOTAL DIA: '+separator(t25)+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #fec5bb; ">DIA 26 <br>T. FACTURA: '+separator(tf26)+'<br>T. BOLETA: '+separator(tb26)+' <br>TOTAL DIA: '+separator(t26)+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #ffe5d9; ">DIA 27 <br>T. FACTURA: '+separator(tf27)+'<br>T. BOLETA: '+separator(tb27)+' <br>TOTAL DIA: '+separator(t27)+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #fec5bb; ">DIA 28 <br>T. FACTURA: '+separator(tf28)+'<br>T. BOLETA: '+separator(tb28)+' <br>TOTAL DIA: '+separator(t28)+'</th></tr>');

$('#tbllistadoventaxdia').append(
'<tr id="fila5"><th style="font-family: Arial; font-size: 0.7em; background-color: #fec5bb; ">DIA 29  <br>T. FACTURA: '+separator(tf29)+'<br>T. BOLETA: '+separator(tb29)+' <br>TOTAL DIA: '+separator(t29)+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #ffe5d9; ">DIA 30  <br>T. FACTURA: '+separator(tf30)+'<br>T. BOLETA: '+separator(tb30)+' <br>TOTAL DIA: '+separator(t30)+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #fec5bb; ">DIA 31 <br>T. FACTURA: '+separator(tf31)+'<br>T. BOLETA: '+separator(tb31)+' <br>TOTAL DIA: '+separator(t31)+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #ffe5d9; ">RESUMEN <br>T. FACTURA: '+separator(resufac)+'<br>T. BOLETA: '+separator(resubol)+' <br>TOTAL MES: '+separator(resutot)+'</th></tr>');






$.post("../ajax/inventarios.php?op=totalpordiamesnotaped&ano="+$ano+'&mes='+$mes, function(data, status){

data=JSON.parse(data);
np1=0;np2=0;np3=0;np4=0;np5=0;np6=0;np7=0;np8=0;np9=0;np10=0;np11=0;np12=0;np13=0;np14=0;np15=0;np16=0;np17=0;np18=0;np19=0;
np20=0;np21=0;np22=0;np23=0;np24=0;np25=0;np26=0;np27=0;np28=0;np29=0;np30=0;np31=0;
   $.each(data["aaData"], function(i, item) {
diaventa=item[1];

    switch (diaventa){
        case '1':
           np1=item[0]; 
        break;
        case '2':
           np2=item[0]; 
        break;
        case '3':
           np3=item[0]; 
        break;
        case '4':
           np4=item[0]; 
        break;
        case '5':
           np5=item[0]; 
        break;
        case '6':
           np6=item[0]; 
        break;
        case '7':
           np7=item[0]; 
        break;
        case '8':
           np8=item[0]; 
        break;
        case '9':
           np9=item[0]; 
        break;
        case '10':
           np10=item[0]; 
        break;
        case '11':
           np11=item[0]; 
        break;
        case '12':
           np12=item[0]; 
        break;
        case '13':
           np13=item[0]; 
        break;
        case '14':
           np14=item[0]; 
        break;
        case '15':
           np15=item[0]; 
        break;
        case '16':
           np16=item[0]; 
        break;
        case '17':
           np17=item[0]; 
        break;
        case '18':
           np18=item[0]; 
        break;
        case '19':
           np19=item[0]; 
        break;
        case '20':
           np20=item[0]; 
        break;
        case '21':
           np21=item[0]; 
        break;
        case '22':
           np22=item[0]; 
        break;
        case '23':
           np23=item[0]; 
        break;
        case '24':
           np24=item[0]; 
        break;
        case '25':
           np25=item[0]; 
        break;
        case '26':
           np26=item[0]; 
        break;
        case '27':
           np27=item[0]; 
        break;
        case '28':
           np28=item[0]; 
        break;
        case '29':
           np29=item[0]; 
        break;
        case '30':
           np30=item[0]; 
        break;
        case '31':
           np31=item[0]; 
        break;
    }
    });

resutotnp=parseFloat(np1)+parseFloat(np2)+parseFloat(np3)+parseFloat(np4)+parseFloat(np5)+parseFloat(np6)+parseFloat(np7)+parseFloat(np8)+parseFloat(np9)+parseFloat(np10)+parseFloat(np11)+parseFloat(np12)+parseFloat(np13)+parseFloat(np14)+parseFloat(np15)+parseFloat(np16)+parseFloat(np17)+parseFloat(np18)+parseFloat(np19)+parseFloat(np20)+parseFloat(np21)+parseFloat(np22)+parseFloat(np23)+parseFloat(np24)+parseFloat(np25)+parseFloat(np26)+parseFloat(np27)+parseFloat(np28)+parseFloat(np29)+parseFloat(np30)+parseFloat(np31);
var $mes2 = $("#mes option:selected").text();

$('#tbllistadoventaxdianotapedido').append(
    '<tr id="fila6"  style="font-family: Arial; font-size: 0.7em; font-size: 1.5em;"><th colspan="7">MES: '+$mes2+'</th></tr>');

$('#tbllistadoventaxdianotapedido').append(
   '<tr id="fila7"><th style="font-family: Arial; font-size: 0.7em; font-size: 0.7em; background-color: #fec5bb; ">DIA 01 <br> TOTAL DIA: '+np1+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #ffe5d9; ">DIA 02  <br> TOTAL DIA: '+np2+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #fec5bb; ">DIA 03 <br> TOTAL DIA: '+np3+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #ffe5d9; ">DIA 04  <br> TOTAL DIA: '+np4+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #fec5bb; ">DIA 05  <br> TOTAL DIA: '+np5+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #ffe5d9; ">DIA 06  <br> TOTAL DIA: '+np6+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #fec5bb; ">DIA 07  <br>  TOTAL DIA: '+np7+'</th></tr>');

 $('#tbllistadoventaxdianotapedido').append(
 '<tr id="fila8"><th style="font-family: Arial; font-size: 0.7em; background-color: #fec5bb; ">DIA 08 <br> TOTAL DIA: '+np8+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #ffe5d9; ">DIA 09  <br> TOTAL DIA: '+np9+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #fec5bb; ">DIA 10 <br> TOTAL DIA: '+np10+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #ffe5d9; ">DIA 11 <br> TOTAL DIA: '+np11+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #fec5bb; ">DIA 12 <br> TOTAL DIA: '+np12+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #ffe5d9; ">DIA 13 <br> TOTAL DIA: '+np13+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #fec5bb; ">DIA 14 <br> TOTAL DIA: '+np14+'</th></tr>');

 $('#tbllistadoventaxdianotapedido').append(
 '<tr id="fila9"><th style="font-family: Arial; font-size: 0.7em; background-color: #fec5bb; ">DIA 15  <br>TOTAL DIA: '+np15+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #ffe5d9; ">DIA 16  <br>TOTAL DIA: '+np16+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #fec5bb; ">DIA 17 <br>TOTAL DIA: '+np17+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #ffe5d9; ">DIA 18 <br>TOTAL DIA: '+np18+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #fec5bb; ">DIA 19 <br>TOTAL DIA: '+np19+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #ffe5d9; ">DIA 20 <br>TOTAL DIA: '+np20+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #fec5bb; ">DIA 21 <br>TOTAL DIA: '+np21+'</th></tr>');

 $('#tbllistadoventaxdianotapedido').append(
 '<tr id="fila10"><th style="font-family: Arial; font-size: 0.7em; background-color: #fec5bb; ">DIA 22  <br>TOTAL DIA: '+np22+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #ffe5d9; ">DIA 23  <br>TOTAL DIA: '+np23+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #fec5bb; ">DIA 24 <br>TOTAL DIA: '+np24+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #ffe5d9; ">DIA 25 <br>TOTAL DIA: '+np25+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #fec5bb; ">DIA 26 <br>TOTAL DIA: '+np26+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #ffe5d9; ">DIA 27 <br>TOTAL DIA: '+np27+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #fec5bb; ">DIA 28 <br>TOTAL DIA: '+np28+'</th></tr>');

 $('#tbllistadoventaxdianotapedido').append(
 '<tr id="fila11"><th style="font-family: Arial; font-size: 0.7em; background-color: #fec5bb; ">DIA 29  <br>TOTAL DIA: '+np29+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #ffe5d9; ">DIA 30  <br>TOTAL DIA: '+np30+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #fec5bb; ">DIA 31 <br>TOTAL DIA: '+np31+'</th><th style="font-family: Arial; font-size: 0.7em; background-color: #ffe5d9; ">RESUMEN <br>TOTAL MES: '+resutotnp+'</th></tr>');

});

});

});

});







}






function calcularkardexentrefechas() 
{ 
    var $fecha1 = $("#fecha1").val();
    var $fecha2 = $("#fecha2").val();
    var xcodigo = $("#codigoInterno").val();
    tabla=$('#tbllistadokardex').dataTable(
    {

        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla

        "processing": true,
        "language": { 
            'loadingRecords': '&nbsp;',
            'processing': '<i class="fa fa-spinner fa-spin"></i> Procesando datos.. espere'
        },

        buttons: [ ],
        "ajax":
                {
                    url: '../ajax/inventarios.php?op=kardexporfechas&f1='+$fecha1+'&f2='+$fecha2+'&Opc='+xocdTods+'&xcd='+xcodigo,
                    type : "post",
                    dataType : "json",                      
                    error: function(e){
                    console.log(e.responseText);    
                    
                    }
               },

        "bDestroy": true,
        "iDisplayLength": 5,//Paginación
        "order": [[ 0, "asc" ]]//Ordenar (columna,orden)
    }
    ).DataTable();
    
    tabla.ajax.reload();    
}


function mostraractual() 
{ 
    var $fecha1 = $("#fecha1").val();
    var $fecha2 = $("#fecha2").val();

    tabla=$('#tbllistadokardex').dataTable(
    {

        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla

        "processing": true,
        "language": { 
            'loadingRecords': '&nbsp;',
            'processing': '<i class="fa fa-spinner fa-spin"></i> Procesando datos.. espere'
        },

        buttons: [ ],
        "ajax":
                {
                    url: "../ajax/inventarios.php?op=mostraractual&f1_="+$fecha1+"&f2_="+$fecha2,
                    type : "post",
                    dataType : "json",                      
                    error: function(e){
                    console.log(e.responseText);    
                    
                    }
               },

        "bDestroy": true,
        "iDisplayLength": 5,//Paginación
        "order": [[ 0, "asc" ]]//Ordenar (columna,orden)
    }
    ).DataTable();
    
    tabla.ajax.reload();    
}



function resetearvalores() 
{ 

    var $codigo = $("#codigoInterno").val();
    var $ano = $("#ano").val();

    tabla=$('#tbllistadokardex').dataTable(
    {
        "aProcessing": true,//Activamos el procesamiento del datatables
        "aServerSide": true,//Paginación y filtrado realizados por el servidor
        dom: 'Bfrtip',//Definimos los elementos del control de tabla

        buttons: [     

                ],
        "ajax":
                {
                    url: '../ajax/inventarios.php?op=resetearvalores&cod='+$codigo+'&ano='+$ano,
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
    
    tabla.ajax.reload();
}


function guardarregistro(idregistro)
{
  var $fecha1 = $("#fecha1").val();
  var $fecha2 = $("#fecha2").val();

  $.post("../ajax/inventarios.php?op=registrarxcodigo&idregval="+idregistro, function(r)
  {
    alert(r);
  })
}