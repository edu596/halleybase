<?php
use Greenter\Ws\Services\SunatEndpoints;
use Greenter\See;

$see = new See();
$see->setService(SunatEndpoints::WSDL_ENDPOINT);
$see->setCertificate(file_get_contents(__DIR__.'/tecnologos.pem'));
$see->setCredentials('20603504969MODDATOS', 'MODDATOS');

return $see;