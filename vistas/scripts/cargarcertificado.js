var tabla;

//Función que se ejecuta al inicio
function init(){
	//mostrarform(false);
	mostrar();
	//listar();

	 $("#formulario").on("submit",function(e)
	 {
	 	guardaryeditar(e);	
	 })
}


function traerruta()
{
	// 		Carga de combo para ruta archivos =====================
    $.post("../ajax/cargarcertificado.php?op=traerdatosempresa", function(data, status)
	{
	data = JSON.parse(data);		
            $("#rutacertificado").val(data.rutarchivos+"certificado/");
            $("#numeroruc").val(data.numero_ruc);
            $("#razon_social").val(data.nombre_razon_social);

    });
}


//Función para guardar o editar
function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	//$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/cargarcertificado.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
            bootbox.alert(datos);	 
            mostrar();         
	    }

	});


}


function validarclave()
{
	var formData = new FormData($("#formulario")[0]);
	$.ajax({
		url: "../ajax/cargarcertificado.php?op=validarclave",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,
	    success: function(datos)
	    {                    
            bootbox.alert(datos);	 
            
	    }

	});


}


        	

function mostrar()
{
	$.post("../ajax/cargarcertificado.php?op=mostrar", function(data, status)
	{
	data = JSON.parse(data);		
	
	$("#idcarga").val(data.idcarga);
	$("#numeroruc").val(data.numeroruc);
	$("#razon_social").val(data.razon_social);
	$("#usuarioSol").val(data.usuarioSol);
	$("#claveSol").val(data.claveSol);
	$("#rutacertificado").val(data.rutacertificado);
	$("#rutaserviciosunat").val(data.rutaserviciosunat);
	$("#webserviceguia").val(data.webserviceguia);
	$("#nombrepem").val(data.nombrepem);
	$("#keypfx").val(data.passcerti);

 	})
}


init();