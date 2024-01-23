var tabla;
$idempresa=$("#idempresa").val();
//Función que se ejecuta al inicio
function init(){
	//mostrarform(true);
	//listar();

	 $("#formulario").on("submit",function(e)
	 {
	 	guardaryeditar(e);	
	 })

	     $.post("../ajax/conexion.php?op=empresa", function(r){
            $("#empresa").html(r);
            $('#empresa').selectpicker('refresh');
    });

	      mostrarform(false);
	      listar();
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
                    url: '../ajax/rutas.php?op=listar&idempresa='+$idempresa,
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
        "iDisplayLength": 5,//Paginación
        "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
    }).DataTable();

    
}

function limpiar()
{
	$("#empresa").val("");
}


//Función cancelarform
function cancelarform()
{
	mostrarform(false);
}


//Función para guardar o editar
function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	//$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/rutas.php?op=guardaryeditar",
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


}




function mostrar(idruta)
{
	$.post("../ajax/rutas.php?op=mostrar",{idruta : idruta}, function(data, status)
	{
	data = JSON.parse(data);	
	mostrarform(true);	
	$("#idruta").val(data.idruta);
	$("#rutadata").val(data.rutadata);
	$("#rutadatalt").val(data.rutadatalt);
	$("#rutafirma").val(data.rutafirma);
	$("#rutaenvio").val(data.rutaenvio);
	$("#rutarpta").val(data.rutarpta);
	$("#rutabaja").val(data.rutabaja);
	$("#rutaresumen").val(data.rutaresumen);
	$("#rutadescargas").val(data.rutadescargas);
	$("#rutaple").val(data.rutaple);
    $("#unziprpta").val(data.unziprpta);
	$("#empresa").val(data.idempresa);
	$("#empresa").selectpicker('refresh');


    $("#rutaarticulos").val(data.rutaarticulos);
    $("#rutalogo").val(data.rutalogo);
    $("#rutausuarios").val(data.rutausuarios);

    $("#salidafacturas").val(data.salidafacturas);
    $("#salidaboletas").val(data.salidaboletas);


	
 	})
}

function mostrarform(flag)
{


    limpiar();
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



function traerruta()
{
    //      Carga de combo para ruta archivos =====================
    $.post("../ajax/cargarcertificado.php?op=traerdatosempresa", function(data, status)
    {
    data = JSON.parse(data);        
            $("#rutadata").val(data.rutarchivos+"sfs/data/");
            $("#rutadatalt").val(data.rutarchivos+"sfs/dataalterna/");
            $("#rutafirma").val(data.rutarchivos+"sfs/firma/");
            $("#rutaenvio").val(data.rutarchivos+"sfs/envio/");
            $("#rutarpta").val(data.rutarchivos+"sfs/rpta/");
            $("#rutabaja").val(data.rutarchivos+"sfs/baja/");
            $("#rutaresumen").val(data.rutarchivos+"sfs/resumen/");
            $("#rutadescargas").val(data.rutarchivos+"sfs/descargas/");
            $("#rutaple").val(data.rutarchivos+"sfs/ple/");
            $("#unziprpta").val(data.rutarchivos+"sfs/unziprpta/");
            $("#rutaarticulos").val(data.rutarchivos+"sfs/articulos/");
            $("#rutalogo").val(data.rutarchivos+"sfs/logo/");
            $("#rutausuarios").val(data.rutarchivos+"sfs/usuarios/");
            $("#salidafacturas").val(data.rutarchivos+"sfs/facturasPDF/");
            $("#salidaboletas").val(data.rutarchivos+"sfs/boletasPDF/");

    });
}

init();