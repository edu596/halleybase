var tabla;

//Función que se ejecuta al inicio
function init(){
	
	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

	  $("#formnewcate").on("submit",function(e)
	  {
	    guardaryeditarCategoria(e); 
	  })

	  $("#formularioutilidad").on("submit",function(e)
	  {
	    guardarutilidad(e); 
	  })



	//$("#fecharegistro").prop("disabled",false);
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fecharegistro').val(today);

     $('#fecha1').val(today);
      $('#fecha2').val(today);
      $('#fechagasto').val(today);
       $('#fechaingreso').val(today);


    $.post("../ajax/insumos.php?op=selectcate", function(r){
            $("#categoriai").html(r);
            $('#categoriai').selectpicker('refresh');
    });


    limpiar();
    listar();
    listarutilidad();


}

//Función limpiar
function limpiar()
{
	$("#descripcion").val("");
	$("#monto").val("");
	 setTimeout(function(){
        document.getElementById('descripcion').focus();
        },100);
	
}

function focusTest(el)
{
   el.select();
}


function foco0()
{
    
       document.getElementById('descripcion').focus();  
    
}


function foco1(e)
{
    if(e.keyCode===13  && !e.shiftKey){
       document.getElementById('monto').focus();  
    }
}

function foco2(e)
{
    if(e.keyCode===13  && !e.shiftKey){
       document.getElementById('btnGuardar').focus();  
    }
}




//Función cancelarform
function cancelarform()
{
	limpiar();

	
}

//Función Listar
function listar()
{

	fechahoy=$('#fecharegistro').val();
	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            
		            'excelHtml5',
		           
		            'pdf'
		        ],
		"ajax":
				{
					url: '../ajax/insumos.php?op=listar&hh='+fechahoy,
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


 

function calcularutilidad()
{
	fecha1=$("#fecha1").val();
	fecha2=$("#fecha2").val();
	tabla=$('#tbllistadouti').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            
		            
		        ],
		"ajax":
				{
					url: '../ajax/insumos.php?op=calcularutilidad&f1='+fecha1+'&f2='+fecha2,
					type : "get",
					dataType : "json",						
					error: function(e){
						//console.log(e.responseText);
							
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
	setTimeout(function(){
				       listarutilidad(); 
				        },500); 
}


function recalcularutilidad(idutilidad)
{
	
	tabla=$('#tbllistadouti').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            
		            
		        ],
		"ajax":
				{
					url: '../ajax/insumos.php?op=recalcularutilidad&iduti='+idutilidad,
					type : "get",
					dataType : "json",						
					error: function(e){
						//console.log(e.responseText);
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
	
						setTimeout(function(){
				       listarutilidad();
				        },500); 	
	
}


function listarutilidad()
{
	tabla=$('#tbllistadouti').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    buttons: [		          
		            
		          ],
		"ajax":
				{
					url: '../ajax/insumos.php?op=listarutilidad',
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



	function guardaryeditar(e)
	{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/insumos.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    { 
	    	document.getElementById("mensaje").style.visibility = "visible";
	    $("#mensaje").text(datos);
	    setTimeout(function(){
        document.getElementById("mensaje").style.visibility = "hidden"; 
        listar();     
        },1500); 
	                 
	          //bootbox.alert(datos);	  
	    }

	});
	
	limpiar();
		
	
}



function guardaryeditarCategoria(e)
{
  e.preventDefault(); //No se activará la acción predeterminada del evento
  var formData = new FormData($("#formnewcate")[0]);
  $.ajax({
    url: "../ajax/insumos.php?op=guardaryeditarcate",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function(datos)
      {                    
            bootbox.alert(datos);           
            actcategoria();
     }

  });
  $("#ModalNcategoria").modal('hide');

}


function actcategoria(){
$.post("../ajax/insumos.php?op=selectcate", function(r){
            $("#categoriai").html(r);
            $('#categoriai').selectpicker('refresh');
    });

}



function stopRKey(evt) {
var evt = (evt) ? evt : ((event) ? event : null);
var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
}


//Función para aceptar solo numeros con dos decimales
  function NumCheck(e, field) {
  // Backspace = 8, Enter = 13, ’0′ = 48, ’9′ = 57, ‘.’ = 46
  key = e.keyCode ? e.keyCode : e.which

  if(e.keyCode===13  && !e.shiftKey)
    {
       document.getElementById('btnGuardar').focus();  
    }


  // backspace
          if (key == 8) return true;
          if (key == 9) return true;
        if (key > 44 && key < 58) {
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



//BLOQUEA ENTER 
document.onkeypress = stopRKey; 

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




function mayus(e) {
     e.value = e.value.toUpperCase();
}


//Función para desactivar registros
function eliminar(idinsumo)
{
	bootbox.confirm("¿Está Seguro de eliminar el insumo?", function(result){
		if(result)
        {
        	$.post("../ajax/insumos.php?op=eliminar", {idinsumo : idinsumo}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
	listar();
}

function eliminarutilidad(idutilidad)
{
	bootbox.confirm("¿Está Seguro de eliminar?", function(result){
		if(result)
        {
        	$.post("../ajax/insumos.php?op=eliminarutilidad", {idutilidad : idutilidad}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
	listarutilidad();
}

function aprobarutilidad(idutilidad)
{
	bootbox.confirm("¿Está Seguro de aprobar?", function(result){
		if(result)
        {
        	$.post("../ajax/insumos.php?op=aprobarutilidad", {idutilidad : idutilidad}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
	listarutilidad();
}

         

function reporteutilidad(idutilidad)
{
     var rutacarpeta='../reportes/reportegastosvsingresossemanal.php?id='+idutilidad;
              $("#modalCom").attr('src',rutacarpeta);
              $("#modalPreview").modal("show");
}




init();