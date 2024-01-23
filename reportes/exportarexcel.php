<?php
	require "../config/Conexion.php";

		$empr=$_POST['idempresa'];
		$tope=$_POST['tipoope'];
		$fc1=$_POST['fecha1'];
		$fc2=$_POST['fecha2'];
		$tipc=$_POST['tipoc'];


if (PHP_SAPI == 'cli')
	die('Este ejemplo sólo se puede ejecutar desde un navegador Web');

/** Incluye PHPExcel */
require_once dirname(__FILE__) . '/PHPExcel.php';
// Crear nuevo objeto PHPExcel
$objPHPExcel = new PHPExcel();

// Propiedades del documento
$objPHPExcel->getProperties()->setCreator("Edu.A")
							 ->setLastModifiedBy("Tecnologos")
							 ->setTitle("Hoja de resumen para declaración mensual")
							 ->setSubject("Hoja de resumen para declaración mensual")
							 ->setDescription("Hoja de resumen para declaración mensual")
							 ->setKeywords("@@")
							 ->setCategory("Hoja de resumen para declaración mensual");



// Combino las celdas desde A1 hasta E1
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:E1');

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'REPORTE MENSUAL PARA DECALRACIÓN')

            ->setCellValue('A2', 'EMPRESA')

            ->setCellValue('A3', 'TIPO OPE.')
            ->setCellValue('B3', 'FECHA')
            ->setCellValue('C3', 'COMPROBANTE')
            ->setCellValue('D3', 'SUBTOTAL')
            ->setCellValue('E3', 'IGV')
            ->setCellValue('F3', 'EXO.')
            ->setCellValue('G3', 'TOTAL')

            ->setCellValue('C2', 'MES')
			//->setCellValue('D2', 'CAPITAL')
			->setCellValue('E2', 'AÑO');
			
// Fuente de la primera fila en negrita
$boldArray = array('font' => array('bold' => true,),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER));
	$objPHPExcel->getActiveSheet()->getStyle('A1:G3')->applyFromArray($boldArray);		

	
			
//Ancho de las columnas
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(12);	
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);	
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);	
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);	
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);	
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);		

/*Extraer datos de MYSQL*/
	# conectare la base de datos
    // $con=@mysqli_connect('localhost', 'root', '', 'regcomven');
    // if(!$con){
    //     die("imposible conectarse: ".mysqli_error($con));
    // }
    // if (@mysqli_connect_errno()) {
    //     die("Connect failed: ".mysqli_connect_errno()." : ". mysqli_connect_error());
    // }


     $con = new mysqli(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
      mysqli_query( $con, 'SET NAMES "'.DB_ENCODE.'"');
      //Si tenemos un posible error en la conexión lo mostramos
      if (mysqli_connect_errno())
      {
            printf("Falló conexión a la base de datos: %s\n",mysqli_connect_error());
            exit();
      }

	$sql="select e.nombrecomercial, if(r.tipoope='1','COMPRA','VENTA') as tipoope , r.fechac, r.seriec, r.numeroc, r.observaciones , r.tipoc, r.subtotal, r.igv, r.exonerado, r.total, monthname(r.fechac) as mes, year(r.fechac) as ano from registro r inner join persona p on r.idpersona=p.idpersona inner join empresa e on r.idempresa=e.idempresa where r.idempresa in('$empr') and tipoope in($tope) and  fechac between '$fc1' and '$fc2' and tipoc in ($tipc) order by tipoope ";
	$query=mysqli_query($con,$sql);
	$cel=4;//Numero de fila donde empezara a crear  el reporte

	$sumaSubtotal=0;
	$sumaIgv=0;
	$sumaExone=0;
	$sumaTotal=0;
	while ($row=mysqli_fetch_array($query)){
		$tipooperacion=$row['tipoope'];
		$fechacom=$row['fechac'];
		$numerocomp=$row['seriec'].'-'.$row['numeroc'];
		$subtotal=$row['subtotal'];
		$igv=$row['igv'];
		$exo=$row['exonerado'];
		$total=$row['total'];
		$empresa=$row['nombrecomercial'];
		$mes=$row['mes'];
		$ano=$row['ano'];

		$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B2', $empresa)
             ->setCellValue('D2', $mes)
              ->setCellValue('F2', $ano);
		
			$a="A".$cel;
			$b="B".$cel;
			$c="C".$cel;
			$d="D".$cel;
			$e="E".$cel;
			$f="F".$cel;
			$g="G".$cel;
			// Agregar datos
			$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue($a, $tipooperacion)
            ->setCellValue($b, $fechacom)
            ->setCellValue($c, $numerocomp)
            ->setCellValue($d, $subtotal)
			->setCellValue($e, $igv)
			->setCellValue($f, $exo)
			->setCellValue($g, $total);
			

			
	$cel+=1;
	$sumaSubtotal+=$subtotal;
	$sumaIgv+=$igv;
	$sumaExone+=$exo;
	$sumaTotal+=$total;
	}

	$objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('C'.$cel, "TOTALES")
                ->setCellValue('D'.$cel, number_format($sumaSubtotal,2))
                ->setCellValue('E'.$cel, number_format($sumaIgv,2))
                ->setCellValue('F'.$cel, number_format($sumaExone,2))
                ->setCellValue('G'.$cel, number_format($sumaTotal,2));

                $boldArray = array('font' => array('bold' => true, 'size'=> 14, 'color'=>array('argb' => 'blue')),'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER), 'borders'=>array('allborders'=>array('style'=> PHPExcel_Style_Border::BORDER_THIN,'color'=>array('argb' => 'FFF'))));
	$objPHPExcel->getActiveSheet()->getStyle('C'.$cel.':G'.$cel)->applyFromArray($boldArray);		


/*Fin extracion de datos MYSQL*/
$rango="A3:$g";
$styleArray = array('font' => array( 'name' => 'courier new','size' => 10),
'borders'=>array('allborders'=>array('style'=> PHPExcel_Style_Border::BORDER_THIN,'color'=>array('argb' => 'FFF')))
);
$objPHPExcel->getActiveSheet()->getStyle($rango)->applyFromArray($styleArray);
// Cambiar el nombre de hoja de cálculo
$objPHPExcel->getActiveSheet()->setTitle('Reporte del mes');


// Establecer índice de hoja activa a la primera hoja , por lo que Excel abre esto como la primera hoja
$objPHPExcel->setActiveSheetIndex(0);


// Redirigir la salida al navegador web de un cliente ( Excel5 )
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="reporte.xls"');
header('Cache-Control: max-age=0');
// Si usted está sirviendo a IE 9 , a continuación, puede ser necesaria la siguiente
header('Cache-Control: max-age=1');

// Si usted está sirviendo a IE a través de SSL , a continuación, puede ser necesaria la siguiente
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;