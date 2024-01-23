var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

	// Carga de departamentos
	    $.post("../ajax/persona.php?op=selectDepartamento", function(r){
            $("#iddepartamento").html(r);
            $('#iddepartamento').selectpicker('refresh');
    });

}

function llenarCiudad(){
    var iddepartamento=$("#iddepartamento option:selected").val();
    $.post("../ajax/persona.php?op=selectCiudad&id="+iddepartamento, function(r){

       $("#idciudad").html(r);
       $('#idciudad').selectpicker('refresh');
       $("#idciudad").val("");
    }); 
	}


function llenarDistrito(){
    var idciudad=$("#idciudad option:selected").val();
    $.post("../ajax/persona.php?op=selectDistrito&id="+idciudad, function(r){

       $("#iddistrito").html(r);
       $('#iddistrito').selectpicker('refresh');
    }); 
	}

//Función limpiar
function limpiar()
{
	$("#nombres").val("");
	$("#apellidos").val("");
	$("#numero_documento").val("");
	$("#razon_social").val("");
	$("#domicilio_fiscal").val("");
	$("#nombre_comercial").val("");
	$("#ciudad").val("");
	$("#distrito").val("");
	$("#telefono1").val("");
	$("#telefono2").val("");
	$("#email").val("");
	$("#idpersona").val("");

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
					url: '../ajax/persona.php?op=listarp',
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
		url: "../ajax/persona.php?op=guardaryeditar",
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

function mostrar(idpersona)
{
	$.post("../ajax/persona.php?op=mostrar",{idpersona : idpersona}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#nombres").val(data.nombres);
		$("#apellidos").val(data.apellidos);
		$("#tipo_documento").val(data.tipo_documento);
		$("#tipo_documento").selectpicker('refresh');
		$("#numero_documento").val(data.numero_documento)
		$("#razon_social").val(data.razon_social);
		$("#nombre_comercial").val(data.nombre_comercial);
		$("#domicilio_fiscal").val(data.domicilio_fiscal);
		$("#iddepartamento").val(data.iddepartamento);
		$('#iddepartamento').selectpicker('refresh');
		$("#idciudad").val(data.ciudad1);
		$("#iddistrito").val(data.distrito1);
		$("#telefono1").val(data.telefono1);
		$("#telefono2").val(data.telefono2);
		$("#email").val(data.email);
 		$("#idpersona").val(data.idpersona);

 	})
}

//Función para desactivar registros
function desactivar(idpersona)
{
	bootbox.confirm("¿Está Seguro de desactivar el proveedor?", function(result){
		if(result)
        {
        	$.post("../ajax/persona.php?op=desactivar", {idpersona : idpersona}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}

//Función para activar registros
function activar(idpersona)
{
	bootbox.confirm("¿Está Seguro de activar el proveedor?", function(result){
		if(result)
        {
        	$.post("../ajax/persona.php?op=activar", {idpersona : idpersona}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
}





//Función para aceptar solo numeros con dos decimales
  function NumCheck(e, field) {
  // Backspace = 8, Enter = 13, ’0′ = 48, ’9′ = 57, ‘.’ = 46
  key = e.keyCode ? e.keyCode : e.which
  // backspace
          if (key == 8) return true;
          if (key == 9) return true;
        if (key > 47 && key < 58) {
          if (field.val() === "") return true;
          var existePto = (/[.]/).test(field.val());
          if (existePto === false){
              regexp = /.[0-9]{10}$/;
          }
          else {
            regexp = /.[0-9]{2}$/;
          }
          return !(regexp.test(field.val()));
        }

        if (key == 46) {
          if (field.val() === "") return false;
          regexp = /^[0-9]+$/;
          return regexp.test(field.val());
        }
        return false;
}

//=========================
//Funcion para mayusculas
function mayus(e) {
     e.value = e.value.toUpperCase();
}
//=========================

function validarProveedor(){

    var ndocumento=$("#numero_documento").val();
    $.post("../ajax/persona.php?op=ValidarProveedor&ndocumento="+ndocumento,  function(data,status){
    	data = JSON.parse(data);
    	if (data) {
    		 	$("#numero_documento").attr("style", "background-color: #FF94A0");
    		 	document.getElementById("numero_documento").focus();
    		 	}else{
    		 	$("#numero_documento").attr("style", "background-color: #A7FF64");
    		 	}
    	
   }); 
    		
	}






init();