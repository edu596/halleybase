var tabla;
	
//Función que se ejecuta al inicio
function init(){

	mostrarform(false);


	fechapagoboleta
	var now = new Date();
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);
    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fechapagoboleta').val(today);
	
	$("#formulario").on("submit",function(e)
	{
		guardaryeditarboletapago(e);	
	})


	$.post("../ajax/sueldoBoleta.php?op=cargarempresas", function(r){
              $("#empresa").html(r);
              $('#empresa').selectpicker('refresh');

             idempre=$("#empresa").val();
  	 		 $.post("../ajax/sueldoBoleta.php?op=cargarempleadosdeempresa&idem="+idempre, function(r){
             $("#idempleado").html(r);
             $('#idempleado').selectpicker('refresh');

    ide=$("#idempleado").val();
	$.post("../ajax/sueldoBoleta.php?op=seleccionempleado&idemple="+ide, function(data, status)
	{


		data = JSON.parse(data);		
        $("#nombreemple").val(data.nombresE);
        $("#apeemple").val(data.apellidosE);
        $("#ocupacione").val(data.ocupacion);
        $("#docide").val(data.dni);
        $("#tiporemun").val(data.tiporemuneracion);
        $("#fechai").val(data.fechaing);
        $("#cuapp").val(data.cusspp);
        

         $("#sueldomensu").val(data.sueldoBruto);
        $("#hextras").val(data.horasT);
        $("#asigfam").val(data.asigFam);
        $("#sobrthr").val(data.trabNoct);


        $("#nombreseg").text(data.nombreSeguro);
        $("#tasaafp").val(data.aoafp);
        $("#tasais").val(data.invsob);
        $("#tasacomi").val(data.comiafp);
        $("#tasasnp").val(data.snp);
        
        calculartbruto();
        calculardctos();
        calculohorastrabajadas();
        calculoessalud();
        
              
  	});

  	});

  	});

    limpiar();
    listar();
    incremetarNum();

    
}


function incremetarNum()
{
    $.post("../ajax/sueldoBoleta.php?op=selectSerie", function(data,status)
        {
        	data=JSON.parse(data);
        $("#idserie").val(data.idnumeracion);
        var idserie=data.idnumeracion;
         $.post("../ajax/sueldoBoleta.php?op=autonumeracion&ser="+idserie, function(r){
         var autosuma=pad(r,0);
//        $("#nboleta").text(n2);
        document.getElementById("nboleta").innerHTML = data.serie +"-"+ autosuma;
        $("#nrobol").val(autosuma);
        $("#nboleta2").val(data.serie +"-"+ autosuma); 
         
         });
        });
}


//Función para poner ceros antes del numero siguiente de la factura

function pad (n, length)
{
    var n= n.toString();
    while(n.length<length)
    n="0" + n;
    return n;
}








function seleccionempleado()
{

	ide=$("#idempleado").val();
	$.post("../ajax/sueldoBoleta.php?op=seleccionempleado&idemple="+ide, function(data, status)
	{
		data = JSON.parse(data);
        $("#nombreemple").val(data.nombresE);
        $("#apeemple").val(data.apellidosE);
        $("#ocupacione").val(data.ocupacion);
        $("#docide").val(data.dni);
        $("#tiporemun").val(data.tiporemuneracion);
        $("#fechai").val(data.fechaing);
        $("#cuapp").val(data.cusspp);
        $("#totalbruto").val();

        $("#sueldomensu").val(data.sueldoBruto);
        $("#hextras").val(data.horasT);
        $("#asigfam").val(data.asigFam);
        $("#sobrthr").val(data.trabNoct);

        $("#nombreseg").text(data.nombreSeguro);
        $("#tasaafp").val(data.aoafp);
        $("#tasais").val(data.invsob);
        $("#tasacomi").val(data.comiafp);
        $("#tasasnp").val(data.snp);
		
		calculartbruto();
		calculardctos();
		calculohorastrabajadas();
		calculoessalud();
              
  	});
}


function seleccionempleadoeditar(idemp)
{

	$.post("../ajax/sueldoBoleta.php?op=seleccionempleado&idemple="+idemp, function(data, status)
	{
		data = JSON.parse(data);
        $("#nombreemple").val(data.nombresE);
        $("#apeemple").val(data.apellidosE);
        $("#ocupacione").val(data.ocupacion);
        $("#docide").val(data.dni);
        $("#tiporemun").val(data.tiporemuneracion);
        $("#fechai").val(data.fechaing);
        $("#cuapp").val(data.cusspp);
        $("#totalbruto").val();

        $("#sueldomensu").val(data.sueldoBruto);
        $("#hextras").val(data.horasT);
        $("#asigfam").val(data.asigFam);
        $("#sobrthr").val(data.trabNoct);

        $("#nombreseg").text(data.nombreSeguro);
        $("#tasaafp").val(data.aoafp);
        $("#tasais").val(data.invsob);
        $("#tasacomi").val(data.comiafp);
        $("#tasasnp").val(data.snp);
		
		calculartbruto();
		calculardctos();
		calculohorastrabajadas();
		calculoessalud();
              
  	});
}


function calculartbruto()
{
	sueldomensual=parseFloat($("#sueldomensu").val());
    horasextras=parseFloat($("#hextras").val());
    asignafam=parseFloat($("#asigfam").val());
    sobreti=parseFloat($("#sobrthr").val());
    
    var concepadi=parseFloat($("#importeconcepto").val());

    if (Number.isNaN(concepadi)) {
    	concepadi=0;
    }
	
	totalbruto=sueldomensual + horasextras + asignafam + sobreti + concepadi;
	$("#totalsbru").val(totalbruto);

	calculardctos();
	calculoessalud();

}


function calculardctos()
{
	importeafp=parseFloat(($("#tasaafp").val() * $("#totalsbru").val())/100);
	$("#importetasa").val(importeafp.toFixed(2));

	importeais=parseFloat(($("#tasais").val() * $("#totalsbru").val())/100);
	$("#importetasais").val(importeais.toFixed(2));

	importecomi=parseFloat(($("#tasacomi").val() * $("#totalsbru").val())/100);
	$("#importetasacomi").val(importecomi.toFixed(2));

	//importe5tt=0;
	//importe5tt=parseFloat(($("#totalsbru").val() * 8)/100 );
	importe5tt=parseFloat($("#importe5t").val());


	importesnpp=parseFloat(($("#tasasnp").val() * $("#totalsbru").val())/100);
	$("#importesnp").val(importesnpp.toFixed(2));

	totaldesc=importeafp + importeais + importecomi + importe5tt + importesnpp;
	$("#totaldescu").val(totaldesc.toFixed(2));
	saldopa=parseFloat($("#totalsbru").val() - $("#totaldescu").val());
	$("#saldopagar").val(saldopa.toFixed(2));

}

function calculohorastrabajadas()
{
	horastraba=$("#cdias").val() * 8;
	$("#choras").val(horastraba);
	hextrascalc=$("#cdias").val() * $("#cchoras").val();
	$("#horasex").val(hextrascalc);
	importeessal=parseFloat(($("#tasaessa").val() * $("#totalsbru").val())/100);
	$("#importeessa").val(importeessal);
}






function calculoessalud()
{
	aporteemp=parseFloat(($("#tasaessa").val() * $("#totalsbru").val())/100);
	$("#importeessa").val(aporteemp.toFixed(2));
	$("#totalessa").val(aporteemp.toFixed(2));
}





function mostrarform(flag , guaedi)

{

  

if (guaedi=='nuevo') {
  if (flag)
  {
    $("#listadoregistros").hide();
    $("#formularioregistros").show();
    $("#btnGuardar").prop("disabled",false);
    $("#btnagregar").hide();
    $("#nboleta").show();
    $("#serie").show();
    $("#datosempleado").show();
  }
  else
  {
    $("#listadoregistros").show();
    $("#formularioregistros").hide();
    $("#btnagregar").show();
    $("#nboleta").hide();
    $("#serie").hide();
  }
  incremetarNum();
  limpiar();

}else{

	if (flag)
  {
    $("#listadoregistros").hide();
    $("#formularioregistros").show();
    $("#btnGuardar").prop("disabled",false);
    $("#btnagregar").hide();
    $("#nboleta").show();
    $("#serie").show();
  }
  else
  {
    $("#listadoregistros").show();
    $("#formularioregistros").hide();
    $("#btnagregar").show();
    $("#nboleta").hide();
    $("#serie").hide();
  }

}




}



function cargarempleadocombo()
{
	idempre=$("#empresa").val();
  	$.post("../ajax/sueldoBoleta.php?op=cargarempleadosdeempresa&idem="+idempre, function(r){
              $("#idempleado").html(r);
              $('#idempleado').selectpicker('refresh');

              seleccionempleado();
  	});


}



function cancelarform()
{
  limpiar();
  mostrarform(false);
}




//Función limpiar
function limpiar()
{
	$("#idboletaPago").val("");
	//$("#nrobol").val("");
	//$("#idserie").val("");
	//$("#nboleta2").val("");
	$("#mes").val("01");
	$("#ano").val("2021");
	$("#cdias").val("");
	$("#choras").val("");
	$("#cchoras").val("1.00");
	$("#horasT").val("");
	$("#horasex").val("");
	$("#importe5t").val("0");
	$("#saldopagar").val("0");
	$("#importeconcepto").val("0");
	$("#conceptoadicional").val("");
    
	
		calculartbruto();
        calculardctos();
        calculohorastrabajadas();
        calculoessalud();
	
	 
}



function focusTest(el)
{
   el.select();
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
		            
		            'excelHtml5',
		           
		            'pdf'
		        ],
		"ajax":
				{
					url: '../ajax/sueldoBoleta.php?op=listarboletapago',
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





	function guardaryeditarboletapago(e)
	{
	e.preventDefault();    //No se activará la acción predeterminada del evento
	
	var mensaje=confirm("¿Desea crear la boleta de pago?");
    if (mensaje){

	var formData = new FormData($("#formulario")[0]);
	$.ajax({
		url: "../ajax/sueldoBoleta.php?op=guardareditarboletapago",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    { 
	          bootbox.alert(datos);	 
	          
			  refrescartabla();
			  mostrarform(false);
	    }

	});
		}
		limpiar();
	
	
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

function editarboleta(idboletaPago)
{
	$.post("../ajax/sueldoBoleta.php?op=mostrarbolpago",{idboletaPago : idboletaPago}, function(data, status)
	{

		data = JSON.parse(data);		
		mostrarform(true, 'editar');

		

		$("#idboletaPago").val(data.idboletapago);

		$("#empresa").val(data.idempresa);
		$('#empresa').selectpicker('refresh');

		//$("#idempleado").val(data.idempleado);
		//$('#idempleado').selectpicker('refresh');

		seleccionempleadoeditar(data.idempleado);
		$("#datosempleado").hide();

	
		$("#mes").val(data.mes);
		$("#ano").val(data.ano);
		$("#cdias").val(data.diast);
		$("#choras").val(data.totaldiast);
		$("#cchoras").val(data.horasEx);
		$("#horasex").val(data.totalhorasEx);

		$("#importe5t").val(data.total5t);
		$("#totaldescu").val(data.totaldcto);
		$("#saldopagar").val(data.sueldopagar);

		$("#fechapagoboleta").val(data.fechapago);

		$("#saldopagar").val(data.sueldopagar);
		$("#totalessa").val(data.totalaportee);

		$("#totalessa").val(data.totalaportee);

		 document.getElementById("nboleta").innerHTML = data.nroboleta;
        $("#nboleta2").val(data.nroboleta);

        $("#conceptoadicional").val(data.conceptoadicional);
        $("#importeconcepto").val(data.importeconcepto);

	
 	})
}




function mayus(e) {
     e.value = e.value.toUpperCase();
}


//Función para desactivar registros
function eliminar(idboletaPago)
{
	bootbox.confirm("¿Está Seguro de eliminar la boleta de pago?", function(result){
		if(result)
        {
        	$.post("../ajax/sueldoBoleta.php?op=eliminarboleta", {idboletaPago : idboletaPago}, function(e){
        		bootbox.alert(e);
        		refrescartabla();
        		listar();
        	});	
        }
	})
	
	
}


function refrescartabla()
{
tabla.ajax.reload();
}


function previoprint(idboletap)
{

              var rutacarpeta='../reportes/sueldoboletaprint.php?id='+idboletap;
              $("#modalCom").attr('src',rutacarpeta);
              $("#modalPreview2").modal("show");
}


init();