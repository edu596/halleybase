document.getElementById("rucEmp").focus();

 // $.post("../ajax/enlacebd.php?op=empresa", function(r){
 //        data=JSON.parse(r);
 //      var lista = document.getElementById("empresaConsulta");
 //      for (var i = 0; i < data.length; i++) {
 //        var opt=document.createElement("option");
 //        opt.setAttribute("value",data[i]);
 //        opt.setAttribute("label",data[i]);
 //        lista.appendChild(opt);
 //      }
 //    });

     //Carga de combo para empresa =====================
    // $.post("../ajax/enlacebd.php?op=empresa", function(r){
    //     data=JSON.parse(r);
    //   var lista = document.getElementById("empresa");
    //   for (var i = 0; i < data.length; i++) {
    //     var opt=document.createElement("option");
    //     opt.setAttribute("value",data[i]);
    //     opt.setAttribute("label",data[i]);
    //     lista.appendChild(opt);
    //   }
    // });


 // //Carga de combo para empresa =====================
 //    $.post("../ajax/conexion.php?op=empresa", function(r){
 //            $("#empresa").html(r);
 //            $('#empresa').selectpicker('refresh');
 //    });

 //     //Carga de combo para empresa =====================
 //    $.post("../ajax/conexion.php?op=empresa", function(r){
 //            $("#empresaConsulta").html(r);
 //            $('#empresaConsulta').selectpicker('refresh');
 //    });




function idempresaF()
{

var idempresa=$('#empresaConsulta').val();
$('#idempresa').val(idempresa);
}








$("#frmAcceso").on('submit', function(e)
{
	e.preventDefault();
	logina=$("#logina").val();
	clavea=$("#clavea").val();
	empresa=$("#empresa").val();
  st=$("#EstadoEmpre").val();
	//st=$("#estadot").val();

  UserBd=$("#UserBd").val();
  PasswordBd=$("#PasswordBd").val();
  NombreBaseDatos=$("#NombreBaseDatos").val(); 


    if (st=='0') {

      alert("DEBE CANCELAR EL PAGO DE SUSCRIPCIÓN, CONTACTAR AL 966461459");

    }
    else
    {

      $.post("../ajax/usuario.php?op=verificar", 
          {"logina":logina, "clavea":clavea, "empresa":empresa, "st":st},
          function(data)
          {
            if(data.length != "null")
            {
              $(location).attr("href", "escritorio.php");
            }
            else
            {
              alert("Usuario y/o password incorrectos o no tiene permiso para la empresa seleccionada!");
              $("#logina").val("");
              document.getElementById("logina").focus();  
              $("#clavea").val("");
            }
          }
    );





    }




}
)







function stopRKey(evt) {
var evt = (evt) ? evt : ((event) ? event : null);
var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
if ((evt.keyCode == 13) && (node.type=="text")) {return false;}
}


function focusAgrArt(e)
{
    if(e.keyCode===13  && !e.shiftKey){
       document.getElementById('clavea').focus();  
    }
}

document.onkeypress = stopRKey; 

function focusTest(el)
{
   el.select();
}

function enter(e, field) {
  // Backspace = 8, Enter = 13, ’0′ = 48, ’9′ = 57, ‘.’ = 46
  key = e.keyCode ? e.keyCode : e.which

  if(e.keyCode===13  && !e.shiftKey)
    {
       document.getElementById('serienumero').focus();  
    }

   }

onOff=false;
counter=setInterval(timer, 5000);
count = 0;


function timer()
{
    count++;
    //tabla.ajax.reload(null,false);
} 


//PARA ACTUALIZAR ESTADO 
 onOff = true;
function pause(){
    if (!onOff) {

        onOff=true;
        clearInterval(counter);
        //listar();   
        alert("Temporizador desactivado");
        desactivarTempo();
        mostrarEstado();
        $st=0;
    }else{
        onOff=false;
        alert("Temporizador activado");
        //counter=setInterval(timer, 5000);
        activarTempo();
        mostrarEstado();
        
    }
    }
//PARA ACTUALIZAR ESTADO 


function mostrarEstado()
{
   $.post("../ajax/factura.php?op=datostemporizadopr", function(data)
    {
       data=JSON.parse(data);
       if (data != null){
       $('#idtemporizador').val(data.idtempo);
       $('#estado').val(data.estado);
       $("#tiempo").val(data.tiempo);
       $("#tiempoN").val(data.tiempo);
		    }
        
    });
}







function activarTempo()
{
   $.post("../ajax/factura.php?op=activartempo&st=1&tiempo="+$("#tiempoN").val(), function(data)
    {
    });
}






function desactivarTempo()
{
   $.post("../ajax/factura.php?op=activartempo&st=0&tiempo="+$("#tiempoN").val(), function(data)
    {
    });
}









$('#login-button').click(function(){
  $('#login-button').fadeOut("slow",function(){
    $("#container").fadeIn();
    TweenMax.from("#container", .4, { scale: 0, ease:Sine.easeInOut});
    TweenMax.to("#container", .4, { scale: 1, ease:Sine.easeInOut});

    $("#container2, #forgotten-container").fadeOut(800, function(){
    $("#login-button2").fadeIn(800);
     });


  });
});


$('#login-button2').click(function(){
  $('#login-button2').fadeOut("slow",function(){
    $("#container2").fadeIn();
    TweenMax.from("#container2", .4, { scale: 0, ease:Sine.easeInOut});
    TweenMax.to("#container2", .4, { scale: 1, ease:Sine.easeInOut});

     $("#container, #forgotten-container").fadeOut(800, function(){
    $("#login-button").fadeIn(800);
     });


  });
});



$(".close-btn").click(function(){
  TweenMax.from("#container", .4, { scale: 1, ease:Sine.easeInOut});
  TweenMax.to("#container", .4, { left:"0px", scale: 0, ease:Sine.easeInOut});
  $("#container, #forgotten-container").fadeOut(800, function(){
    $("#login-button").fadeIn(800);
  });
});


$(".close-btn2").click(function(){
  TweenMax.from("#container2", .4, { scale: 1, ease:Sine.easeInOut});
  TweenMax.to("#container2", .4, { left:"0px", scale: 0, ease:Sine.easeInOut});
    $("#container2, #forgotten-container").fadeOut(800, function(){
    $("#login-button2").fadeIn(800);
  });
});


function empresa()
{
  empresa=$("#empresaConsulta").val();
   UserBd=$("#UserBd").val();
   // PasswordBd=$("#PasswordBd").val();
   NombreBaseDatos=$("#NombreBaseDatos").val(); 


  //$.post("../ajax/enlacebd.php?op=verificarempresa",{"UserB":UserBd, "PasswordB": PasswordBd, "NombreBaseDatos": NombreBaseDatos});
  $.post("../ajax/enlacebd.php?op=verificarempresa",{"UserB":UserBd,  "NombreBaseDatos": NombreBaseDatos});
}






function BuscarEmpresa()
{
   UserBd="";
   NombreBaseDatos="";
   Nrucc="";
   EstadoEmp="";
  rucEmp=$("#rucEmp").val();
   $.post("../ajax/enlacebd.php?op=BuscarEmpresa&rucEm="+rucEmp, function(data)
    {
       data=JSON.parse(data);
       if (data.length != 0){
       UserBd=data[0]["UserBd"];
       //PasswordBd=data[0]["PasswordBd"];
       NombreBaseDatos=data[0]["NombreBaseDatos"];
       Nrucc=data[0]["ruc"];
       EstadoEmp=data[0]["estado"];

       if (EstadoEmp=='0') {
          alert("DEBE CANCELAR EL PAGO DE SUSCRIPCIÓN, CONTACTAR AL 966461459");

           //$("#rucEmp").val("");
           $("#Nombrempresa").val("");
           $("#EstadoEmpre").val(EstadoEmp);
          document.getElementById("logina").disabled = true;
          document.getElementById("clavea").disabled = true;
          document.getElementById("rucEmp").focus();     

       }else{

       $("#UserBd").val(data[0]["UserBd"]);
       $("#NombreBaseDatos").val(data[0]["NombreBaseDatos"]);
       $("#Nombrempresa").val(data[0]["NombreEmpresa"]);
       $("#empresa").val(data[0]["NombreBaseDatos"]);

       document.getElementById("logina").disabled = false;
       document.getElementById("clavea").disabled = false;

       document.getElementById("logina").focus();     

      //$.post("../ajax/enlacebd.php?op=verificarempresa",{"UserB":UserBd, "PasswordB": PasswordBd, "NombreBaseDatos": NombreBaseDatos});
      $.post("../ajax/enlacebd.php?op=verificarempresa",{"UserB":UserBd, "NombreBaseDatos": NombreBaseDatos, "nruccli": Nrucc});

       }


       



   }else{ 
            alert("Empresa no registrada");
            $("#rucEmp").val("");
             document.getElementById("rucEmp").focus();      
            $("#logina").val("");
                document.getElementById("logina").disabled = true;
                document.getElementById("clavea").disabled = true;
            $("#Nombrempresa").val(data[0]["Empresa no registrada"]);
   }

   

        
    });
}



function focoempresa(e)
{
    if(e.keyCode===13  && !e.shiftKey)
    {
        document.getElementById("logina").focus();
    }
}


$(document).ready(function() {
    $("form").keypress(function(e) {
        if (e.which == 13) {
            return false;
        }
    });
});

