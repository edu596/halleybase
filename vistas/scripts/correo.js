var tabla;

//Función que se ejecuta al inicio
function init(){
	//mostrarform(true);
	mostrar("1");
	//listar();

	 $("#formulario").on("submit",function(e)
	 {
	 	guardaryeditar(e);	
	 })
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
		url: "../ajax/correo.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
            bootbox.alert(datos);	          
//			var int = self.setInterval("refresh()",1000);
	    }

	});


}




function mostrar(idcorreo)
{
	$.post("../ajax/correo.php?op=mostrar",{idcorreo : idcorreo}, function(data, status)
	{
		data = JSON.parse(data);		

	$("#idcorreo").val(data.idcorreo);
	$("#nombre").val(data.nombre);
	$("#username").val(data.username);
	$("#host").val(data.host);
	$("#password").val(data.password);
	$("#smtpsecure").val(data.smtpsecure);
	$("#port").val(data.port);
	$("#mensaje").val(data.mensaje);
	$("#correoavisos").val(data.correoavisos);
 	})
}


init();