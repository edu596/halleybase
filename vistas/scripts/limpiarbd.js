var tabla;
$idempresa=$("#idempresa").val();
//Función que se ejecuta al inicio
function init(){
    
	      mostrarform(false);
	      listar();
          $("#rutainsta").hide();
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
                    url: '../ajax/limpiarbd.php?op=listar',
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
        "iDisplayLength": 5,//Paginación
        "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
    }).DataTable();

    
}



//Función cancelarform
function cancelarform()
{
	mostrarform(false);
}



 //Función borrar los datos de las tablas de la empresa seleccionada
function limpiarbd()
{
 bootbox.confirm("<h3>¿Está Seguro de borrar todos los datos de las tablas? </br> Asegurese de sacar una copia de seguridad de la base de datos de la empresa seleccionada.</h3>", function(result){
        if(result)
        {
            $.post("../ajax/limpiarbd.php?op=limpiarbd", {idempresa : idempresa}, function(e)
            {
            //data = JSON.parse(e);
            bootbox.alert(e);
            }); 
        }
    })


}

//Función borrar los datos de las tablas de la empresa seleccionada
function copiabd()
{

    var checkBox1 = document.getElementById("chk1");
    var checkBox2 = document.getElementById("chk2");
    var tipodt = $("#tipodato").val();
    var rutai=$("#rutainsta").val();

    if (checkBox1.checked == true){

 bootbox.confirm("<h3>¿Está Seguro de hacer una copia de la base de datos? </h3>", function(result){
        if(result)
        {
            $.post("../ajax/limpiarbd.php?op=copiabd&rt="+rutai+"&td="+tipodt,  function(e)
            {
            data = JSON.parse(e)
            bootbox.alert('Se ha generardo a copia de seguridad de nombre: <a href="'+data.rutaarchivo+'" download=" '+data.nombrearchivo+'">"'+data.nombrearchivo+'"</a> de clic en el nombre para descargarlo y guardarlo.');
            }); 
        }
    })

 }else{

    alert("Pendiente");
}

}



function mostrarform(flag)
{

   if (flag)
    {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnagregar").hide();
        $("#btnGuardar").show();
        $("#btnCancelar").show();
        $("#rutadata").focus();
    }
    else
    {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();

    }

}

function selectopt()
{
    var checkBox1 = document.getElementById("chk1");
    var checkBox2 = document.getElementById("chk2");

    if (checkBox1.checked == true){
    checkBox2.checked = false;
    $("#tipoi1").show();
    $("#tipoi2").show();
    $("#tipoi3").show();
    $("#rutainsta").show();
  } else {
   checkBox2.checked = true;
    $("#tipoi1").hide();
    $("#tipoi2").hide();
    $("#tipoi3").hide();
     $("#rutainsta").hide();
  }
}


function selectopt2()
{
    var checkBox1 = document.getElementById("chk1");
    var checkBox2 = document.getElementById("chk2");

    if (checkBox2.checked == true){
    checkBox1.checked = false;
    $("#tipoi1").hide();
    $("#tipoi2").hide();
    $("#tipoi3").hide();
    $("#rutainsta").hide();
  } else {
   checkBox1.checked = true;
    $("#tipoi1").show();
    $("#tipoi2").show();
   $("#tipoi3").show();
    $("#rutainsta").show();
  }
}



function selectinstalacion()
{
    var opt1 = document.getElementById("tipoi1");
    var opt2 = document.getElementById("tipoi2");
    var opt3 = document.getElementById("tipoi3");
   
    if (opt1.checked == true){
    $("#rutainsta").val("C:/xampp/mysql/bin/mysqldump");
    $("#tipodato").val("local");
    }else if(opt3.checked == true){
    $("#rutainsta").val("");
    $("#tipodato").val("web");
     }else{
     $("#rutainsta").val("");
     $("#tipodato").val("mac");
  }
  
  }


init();


    $(document).ajaxSend(function(){
       $(".loader").fadeIn("slow");
         });

    $(document).ajaxComplete(function() {  
       $(".loader").fadeOut("slow");
    });