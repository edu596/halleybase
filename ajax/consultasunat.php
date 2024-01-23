<?php
	header('Content-Type: text/plain');

	require ("../modelos/src/autoload.php");
	$cliente = new \Sunat\Sunat(true,true);
	$ruc = ( isset($_REQUEST["nruc"]))? $_REQUEST["nruc"] : false;
	echo $cliente->search( $ruc, true );
?>
