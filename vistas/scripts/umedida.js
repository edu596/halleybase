var tabla;

//Función que se ejecuta al inicio
function init(){
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
	$("#nombre").val("");
	$("#abre").val("");
	$("#equivalencia").val("");
	$("#idunidadm").val("");
	
}

function stopRKey(evt) {
var evt = (evt) ? evt : ((event) ? event : null);
var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
}



//BLOQUEA ENTER 
document.onkeypress = stopRKey; 

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
		            'copyHtml5',
		            'excelHtml5',
		            'csvHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../ajax/umedida.php?op=listar',
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
		url: "../ajax/umedida.php?op=guardaryeditar",
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

function mostrar(idunidadm)
{
	$.post("../ajax/umedida.php?op=mostrar",{idunidadm : idunidadm}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#idunidadm").val(data.idunidad);
		$("#nombre").val(data.nombreum);
		$("#abre").val(data.abre);
		$("#equivalencia").val(data.equivalencia);

 	})
}

//Función para desactivar registros
function desactivar(idunidadm)
{
	bootbox.confirm("¿Está Seguro de desactivar la unidad de medida?", function(result){
		if(result)
        {
        	$.post("../ajax/umedida.php?op=desactivar", {idunidadm : idunidadm}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(idunidadm)
{
	bootbox.confirm("¿Está Seguro de activar la unidad de medida?", function(result){
		if(result)
        {
        	$.post("../ajax/umedida.php?op=activar", {idunidadm : idunidadm}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}



function eliminar(idunidadm)
{
	bootbox.confirm("¿Está Seguro de eliminar unidad de medida?", function(result){
		if(result)
        {
        	$.post("../ajax/umedida.php?op=eliminar", {idunidadm : idunidadm}, function(e){
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