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
	$("#nombre_comercial").val("");
	$("#razon_social").val("");
	$("#domicilio_fiscal").val("");
	$("#iddepartamento").val("");
	$("#idciudad").val("");
	$("#iddistrito").val("");
	$("#telefono1").val("");
	$("#telefono2").val("");
	$("#email").val("");
	$("#idpersona").val("");
  $("#ubigeo").val("");

}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#numero_documento").focus();
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
function cancelarform()
{
	limpiar();

//Función cancelarform
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
					url: '../ajax/persona.php?op=listarc',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "asc" ]]//Ordenar (columna,orden)
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
		$("#razon_social").val((data.razon_social));
		$("#nombre_comercial").val((data.nombre_comercial));
		$("#domicilio_fiscal").val(data.domicilio_fiscal);
		$("#telefono1").val(data.telefono1);
		$("#telefono2").val(data.telefono2);
		$("#email").val(data.email);
 		$("#idpersona").val(data.idpersona);

    $("#ubigeo").val(data.ubigeo);

 		$('#iddepartamento').val(data.departamento).change();
 		
    	var iddepartamento=data.departamento;
    	$.post("../ajax/persona.php?op=selectCiudad&id="+iddepartamento, function(r){
			$("#idciudad").html(r);
       		$('#idciudad').selectpicker('refresh');			
			$('#idciudad').val(data.ciudad).change();

			$.post("../ajax/persona.php?op=selectDistrito&id="+data.ciudad, function(r){
       		$("#iddistrito").html(r);
       		$('#iddistrito').selectpicker('refresh');
			$('#iddistrito').val(data.distrito).change();    		
    				}); 
			
			
    	}); 

 	});
}

function llenardistrito(){
var idciudad=$("#idciudad").val();
    	$.post("../ajax/persona.php?op=selectDistrito&id="+idciudad, function(r){

       	$("#iddistrito").html(r);
       	$('#iddistrito').selectpicker('refresh');
    		}); 
}


//Función para desactivar registros
function desactivar(idpersona)
{
	bootbox.confirm("¿Está Seguro de desactivar el CLiente?", function(result){
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
	bootbox.confirm("¿Está Seguro de activar el cliente?", function(result){
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
  function NumCheckrz(e, field) {

  	 if(e.keyCode===13  && !e.shiftKey){
       document.getElementById('razon_social').focus();  
       e.preventDefault(); //No se activará la acción predeterminada del evento
    }
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

//Función para aceptar solo numeros con dos decimales
  function NumChecktel1(e, field) {

  	 if(e.keyCode===13  && !e.shiftKey){
       document.getElementById('telefono2').focus();  
    }
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


//Función para aceptar solo numeros con dos decimales
  function NumChecktel2(e, field) {

  	 if(e.keyCode===13  && !e.shiftKey){
       document.getElementById('email').focus();  
    }
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

function validarCliente(){

    var ndocumento=$("#numero_documento").val();
    $.post("../ajax/persona.php?op=ValidarCliente&ndocumento="+ndocumento,  function(data,status){
    	data = JSON.parse(data);
    	//$('#ndocu').val(data.numero_documento);
    	//var valida=$('#ndocu').val();
    	//var valida=data.numero_documento;
    	if (data) {
    			//alert("Cliente ya existe");
    		 	$("#numero_documento").attr("style", "background-color: #FF94A0");
    		 	//$("#numero_documento").val("");
    		 	document.getElementById("numero_documento").focus();
    		 	}else{
    		 	$("#numero_documento").attr("style", "background-color: #A7FF64");
    		 	}
    	
   }); 
    		
	}


function focusnd(){
	document.getElementById('numero_documento').focus();
  limpiar();
}


function stopRKey(evt) {
var evt = (evt) ? evt : ((event) ? event : null);
var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
if ((evt.keyCode == 13) && (node.type=="text") || (node.type=="number")  )   {return false;}
}


document.onkeypress = stopRKey; 



function focusnombre(e)
{
    if(e.keyCode===13  && !e.shiftKey){
       document.getElementById('apellidos').focus();  
    }
}


function focusapellido(e)
{
    if(e.keyCode===13  && !e.shiftKey){
       document.getElementById('tipo_documento').focus();  
    }
}


function focusrz(e)
{
    if(e.keyCode===13  && !e.shiftKey){
       document.getElementById('nombre_comercial').focus();  
    }
}

function focusnc(e)
{
    if(e.keyCode===13  && !e.shiftKey){
       document.getElementById('domicilio_fiscal').focus();  
    }
}


function focusdf(e)
{
    if(e.keyCode===13  && !e.shiftKey){
       document.getElementById('iddepartamento').focus();  
    }
}

function focusdep(e)
{
    if(e.keyCode===13  && !e.shiftKey){
       document.getElementById('idciudad').focus();  
    }
}

function focusciu(e)
{
    if(e.keyCode===13  && !e.shiftKey){
       document.getElementById('iddistrito').focus();  
    }
}

function focusdist(e)
{
    if(e.keyCode===13  && !e.shiftKey){
       document.getElementById('telefono1').focus();  
    }
}


function focustel1(e)
{
    if(e.keyCode===13  && !e.shiftKey){
       document.getElementById('telefono1').focus();  
    }
}


function focusoctel1()
{
    
       document.getElementById('telefono1').focus();  
    
}


function focusmail(e)
{
    if(e.keyCode===13  && !e.shiftKey){
       document.getElementById('btnGuardar').focus();  
    }
}






init();







function BuscarPersona()
{

  var tpd = $('#tipo_documento').val();
  var numero = $('#numero_documento').val(),
  url_s = "../ajax/factura.php?op=consultaRucSunat&nroucc="+numero;
  parametros = {'action':'getnumero','numero':numero}
  
    if (tpd=='6') {
    $.ajax({
        type: 'POST',
        url: url_s,
        dataType:'json',
        beforeSend: function(){
        },  
        complete:function(data){
        
        },
        success: function(data){
          $('.before-send').fadeOut(500);
          if(!jQuery.isEmptyObject(data.error)){
            alert(data.error);
          }else{
              
              $("#numero_documento").val(data.numeroDocumento);
              $('#razon_social').val(data.nombre);
              $('#nombre_comercial').val(data.nombre);
               $('#domicilio_fiscal').val(data.direccion);
               $('#iddistrito').val(data.distrito);
               $('#idciudad').val(data.provincia);
               $('#iddepartamento').val(data.departamento);
               $('#ubigeo').val(data.ubigeo);
          }
          $.ajaxunblock();
        },
        error: function(data){
            alert("Problemas al tratar de enviar el formulario");
            $.ajaxunblock();
        }
    }); 
  }else if(tpd=='1') {

        $.ajax({
        type: 'POST',
        url: "../ajax/boleta.php?op=consultaDniSunat&nrodni="+numero,
        dataType:'json',
        //data:parametros,

        beforeSend: function(){
        },  
        complete:function(data){
        },
        success: function(data){
          $('.before-send').fadeOut(500);
          if(!jQuery.isEmptyObject(data.error)){
            alert(data.error);
          }else{
              
              $("#numero_documento").val(data.numeroDocumento);
              $('#apellidos').val(data.apellidoPaterno+" "+data.apellidoMaterno);
              $("#nombres").val(data.nombres);
          }
          $.ajaxunblock();
        },
        error: function(data){
            alert("Problemas al tratar de enviar el formulario");
            $.ajaxunblock();
        }
    }); 


  }
}


function agregarPersona(e)
  {
    var documento=$("#numero_documento2").val();
    if(e.keyCode===13  && !e.shiftKey){
   
  var tpd = $('#tipo_documento').val();
  var numero = $('#numero_documento').val(),
  url_s = "../ajax/factura.php?op=consultaRucSunat&nroucc="+numero;
  parametros = {'action':'getnumero','numero':numero}
  
    if (tpd=='6') {
    $.ajax({
        type: 'POST',
        url: url_s,
        dataType:'json',
        beforeSend: function(){
        },  
        complete:function(data){
        
        },
        success: function(data){
          $('.before-send').fadeOut(500);
          if(!jQuery.isEmptyObject(data.error)){
            alert(data.error);
          }else{
              
              $("#numero_documento").val(data.numeroDocumento);
              $('#razon_social').val(data.nombre);
              $('#nombre_comercial').val(data.nombre);
               $('#domicilio_fiscal').val(data.direccion);
               $('#iddistrito').val(data.distrito);
               $('#idciudad').val(data.provincia);
               $('#iddepartamento').val(data.departamento);
               $('#ubigeo').val(data.ubigeo);
          }
          $.ajaxunblock();
        },
        error: function(data){
            alert("Problemas al tratar de enviar el formulario");
            $.ajaxunblock();
        }
    }); 
  }else if(tpd=='1') {

        $.ajax({
        type: 'POST',
        url: "../ajax/boleta.php?op=consultaDniSunat&nrodni="+numero,
        dataType:'json',
        //data:parametros,

        beforeSend: function(){
        },  
        complete:function(data){
        },
        success: function(data){
          $('.before-send').fadeOut(500);
          if(!jQuery.isEmptyObject(data.error)){
            alert(data.error);
          }else{
              
              $("#numero_documento").val(data.numeroDocumento);
              $('#apellidos').val(data.apellidoPaterno+" "+data.apellidoMaterno);
              $("#nombres").val(data.nombres);
          }
          $.ajaxunblock();
        },
        error: function(data){
            alert("Problemas al tratar de enviar el formulario");
            $.ajaxunblock();
        }
    }); 


  }



 }
 
}