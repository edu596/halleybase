<?php

use Greenter\XMLSecLibs\Sunat\SignedXml;
class Greenter{

	

public function getDatFac($xml){

require __DIR__.'/vendor/autoload.php';

	require_once "../modelos/Consultas.php";	
    $consultas = new consultas();
    $paramcerti = $consultas->paramscerti();
    $datosc = $paramcerti->fetch_object();

//$certi="tecnologos.pem"; //Nombre de certificado
$certi=$datosc->rutacertificado.$datosc->nombrepem; //Nombre de certificado
//$certi=".. c:\sfs\certificado\oecnologos.pem";

$xmlPath = $xml;
$certPath = __DIR__.'/'.$certi; 

$signer = new SignedXml();
$signer->setCertificateFromFile($certPath);
$xmlSigned = $signer->signFromFile($xmlPath);
//file_put_contents($nam.'.xml', $xmlSigned);
file_put_contents($xml, $xmlSigned);
$out = "firmado: ".$xml;
return $out;

}}