<?php
use Greenter\XMLSecLibs\Certificate\X509Certificate;
use Greenter\XMLSecLibs\Certificate\X509ContentType;

require 'vendor/autoload.php';

$pfx = file_get_contents('20603504969.pfx');
$password = 'Camila4720383';

$certificate = new X509Certificate($pfx, $password);
$pem = $certificate->export(X509ContentType::PEM);
    
file_put_contents('tecnologos.pem', $pem);

?>