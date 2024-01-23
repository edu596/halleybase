var tabla;

//Función que se ejecuta al inicio
function init(){
	
	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

	



	//$("#fecharegistro").prop("disabled",false);
    var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fecharegistroingreso').val(today);

    // $.post("../ajax/insumos.php?op=selectcate", function(r){
    //         $("#categoriai").html(r);
    //         $('#categoriai').selectpicker('refresh');
    // });


    limpiar();
    listar();


}

//Función limpiar
function limpiar()
{
	$("#total").val("");

	 setTimeout(function(){
        document.getElementById('total').focus();
        },100);
	
}

function focusTest(el)
{
   el.select();
}


function foco0()
{
    
       document.getElementById('total').focus();  
    
}


function foco1(e)
{
    if(e.keyCode===13  && !e.shiftKey){
       document.getElementById('btnGuardar').focus();    
    }
}

// function foco2(e)
// {
//     if(e.keyCode===13  && !e.shiftKey){
//        document.getElementById('btnGuardar').focus();  
//     }
// }




//Función cancelarform
function cancelarform()
{
	limpiar();

	
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
		            
		           
		        ],
		"ajax":
				{
					url: '../ajax/ventadiaria.php?op=listar',
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
	
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../ajax/ventadiaria.php?op=guardaryeditar",
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
        },1500); 
	                 
	          //bootbox.alert(datos);	  
	    }

	});
	
	limpiar();
	listar(); 	
	
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



//BLOQUEA ENTER 
document.onkeypress = stopRKey; 



function mayus(e) {
     e.value = e.value.toUpperCase();
}


//Función para desactivar registros
function eliminar(idventa)
{
	bootbox.confirm("¿Está Seguro de eliminar el ingreso?", function(result){
		if(result)
        {
        	$.post("../ajax/ventadiaria.php?op=eliminar", {idventa : idventa}, function(e){
        		bootbox.alert(e);
	            tabla.ajax.reload();
        	});	
        }
	})
	listar();
}


init();