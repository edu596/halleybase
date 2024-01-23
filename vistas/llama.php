<?php

$ruta = "https://ruc.com.pe/api/beta/ruc";
$token = "1ea873e5-0e3b-4578-8f91-cf34edd0d671-ce6a2cb3-f59b-45bd-a90b-195045ae49cc";


$ruc = $_POST['ruc'];

$data = array(
    "token"	=> $token,
    "ruc"   => $ruc
);
	
$data_json = json_encode($data);

// Invocamos el servicio a ruc.com.pe
// Ejemplo para JSON
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $ruta);
curl_setopt(
	$ch, CURLOPT_HTTPHEADER, array(
	'Content-Type: application/json',
	)
);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$respuesta  = curl_exec($ch);
curl_close($ch);

//$leer_respuesta = json_decode($respuesta, true);
$leer_respuesta = $respuesta;

if (isset($leer_respuesta['errors'])) {
	//Mostramos los errores si los hay
    echo $leer_respuesta['errors'];
} else {
	//Mostramos la respuesta
	echo ($leer_respuesta);
}

