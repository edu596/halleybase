function datosDescarga(){

$.post("../ajax/ventasSunat.php?op=cargaDatos&año"+idfac,function(r){
	$("#mensaje").html(r);
});

}



