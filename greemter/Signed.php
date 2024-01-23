<?php

use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;

class Greenter{

public function getDatFac($cab,$det){


require __DIR__.'/vendor/autoload.php';

$see = require __DIR__.'/config.php';
while($row=$cab->fetch_assoc()){ $tp=substr($row['idDoc'],11,2); if($row['porDtrCom']>0){ $opera='1001';}else{$opera='0101';}
// Cliente
$client = new Client();
$client->setTipoDoc($row['tipDocCli'])
    ->setNumDoc($row['docCli'])
    ->setRznSocial($row['razPer']);

// Emisor
$address = new Address();
$address->setUbigueo('150101')
    ->setDepartamento('LIMA')
    ->setProvincia('LIMA')
    ->setDistrito('LA VICTORIA')
    ->setUrbanizacion('SAN PABLO')
    ->setDireccion('JR. GAMARRA NRO. 654 INT. 1001');

$company = new Company();
$company->setRuc('20100302269')
    ->setRazonSocial('INMOBILIARIA E INVERSIONES GUIPOR SA')
    ->setNombreComercial('INMOBILIARIA E INVERSIONES GUIPOR SA')
    ->setAddress($address);

// Venta
$invoice = (new Invoice())
    ->setUblVersion('2.1')
    ->setTipoOperacion($opera) // Catalog. 51
    ->setTipoDoc($tp)
    ->setSerie(substr($row['idDoc'],13,4))
    ->setCorrelativo($row['numDoc'])
    ->setFechaEmision(new DateTime())
    ->setTipoMoneda($row['codMon'])
    ->setClient($client)
    ->setMtoOperGravadas(number_format($row['valCom'],2,'.',''))
    ->setMtoIGV(number_format($row['igvCom'],2,'.',''))
    ->setTotalImpuestos(number_format($row['igvCom'],2,'.',''))
    ->setValorVenta(number_format($row['valCom'],2,'.',''))
    ->setMtoImpVenta(number_format($row['totCom'],2,'.',''))
    ->setCompany($company);
$cont=0;
while($drow=$det->fetch_assoc()){ $dscri=$drow['descri'].$drow['descriPer']; if($dscri==""){ $parra="POR SERVICIO DE ".$drow['idCcp']." PERIODO: ".$drow['mesCro']."-".$drow['anoCro']." ".$drow['cndCom']; } $valu = abs($drow['pago'])/1.18; $igvu = abs($drow['pago'])-round($valu,2); $preu = $valu/$drow['canti']; $prec=abs($drow['pago'])/$drow['canti'];$cont=$cont+1;$item="item".$cont;

$item = (new SaleDetail())
    ->setCodProducto($drow['codig'])
    ->setUnidad($drow['medi'])
    ->setCantidad(number_format($drow['canti'],2,'.',''))
    ->setDescripcion(trim($parra))
    ->setMtoBaseIgv(number_format($valu,2,'.',''))
    ->setPorcentajeIgv(18.00) // 18%
    ->setIgv(number_format($igvu,2,'.',''))
    ->setTipAfeIgv('10')
    ->setTotalImpuestos(number_format($igvu,2,'.',''))
    ->setMtoValorVenta(number_format($valu,2,'.',''))
    ->setMtoValorUnitario(number_format($preu,2,'.',''))
    ->setMtoPrecioUnitario(number_format($prec,2,'.',''));

}
$legend = (new Legend())
    ->setCode('1000')
    ->setValue('SON DOSCIENTOS TREINTA Y SEIS CON 00/100 SOLES');

$invoice->setDetails([$item1])
        ->setLegends([$legend]);
}
$result = $see->send($invoice);

// Guardar XML
file_put_contents($invoice->getName().'.xml',
                  $see->getFactory()->getLastXml());
if (!$result->isSuccess()) {
    var_dump($result->getError());
    exit();
}

// Guardar CDR
file_put_contents('R-'.$invoice->getName().'.zip', $result->getCdrZip());
return $result->getCdrResponse()->getDescription();}}