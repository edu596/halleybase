var tabla;

//Función que se ejecuta al inicio
function init(){


	// $.post("../ajax/conceptois.php?op=estado", function(r){
 //            $("#estado").html(r);
 //            $('#estado').selectpicker('refresh');
 //            });
   

	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})
}

//Función limpiar
function limpiar()
{
	$("#nombreconcepto").val("");
	$("#idconcepto").val("");
}
  
//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
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
					url: '../ajax/conceptois.php?op=listar',
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
//Función para guardar o editar

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/conceptois.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          bootbox.alert(datos);	          
	          mostrarform(false);
	          tabla.ajax.reload();
	    }

	});
	limpiar();
}

function mostrar(idconcepto)
{
	$.post("../ajax/conceptois.php?op=mostrar",{idconcepto : idconcepto}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#nombreconcepto").val(data.nombreconcepto);
		$("#idconcepto").val(data.idconcepto);

 	})
}

//Función para desactivar registros
function desactivar(idconcepto)
{
	bootbox.confirm("¿Está Seguro de desactivar?", function(result){
		if(result)
        {
        	$.post("../ajax/conceptois.php?op=desactivar", {idconcepto : idconcepto}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(idconcepto)
{
	bootbox.confirm("¿Está Seguro de activar el concepto?", function(result){
		if(result)
        {
        	$.post("../ajax/conceptois.php?op=activar", {idconcepto : idconcepto}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}


function eliminar(idconcepto)
{
	bootbox.confirm("¿Está Seguro de eliminar el concepto?", function(result){
		if(result)
        {
        	$.post("../ajax/conceptois.php?op=eliminar", {idconcepto : idconcepto}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}



function mayus(e) {
     e.value = e.value.toUpperCase();
}





init();   