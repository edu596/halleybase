<?php
require('../fpdf181/fpdf.php');

class PDF_MC_Table extends FPDF
{
var $widths;
var $aligns;

function SetWidths($w)
{
    //Set the array of column widths
    $this->widths=$w;
}

function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}

function Row($data)
{
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        //$this->Rect($x,$y,$w,$h);
        $this->Rect(0,0,0,0);
        //Print the text
        $this->MultiCell($w,5,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}



function Header()
{
    //recepcion de variables
    $ndoc=$_POST['nruc'];
    $tipo=$_POST['tipo'];

    $ano=$_POST['anor'];
    $mes=$_POST['mesr'];
    $fpago=$_POST['tipopago'];
    

    require_once "../modelos/Venta.php";
    $venta= new Venta();

    require_once "../modelos/Factura.php";
    $factura= new Factura();
    $datos = $factura->datosemp($_SESSION['idempresa']);
    $datose = $datos->fetch_object();

    //Seteamos el tipo de letra y creamos el título de la página. No es un encabezado no se repetirá
$this->SetFont('courier','B',8);
$this->Cell(40,6,'',0,0,'C');
$this->Cell(-40,2,utf8_decode(htmlspecialchars_decode($datose->nombre_razon_social)),0,0,'C'); 
$this->Cell(42,10,'EJERCICIO '.$ano,0,0,'C'); 


$this->SetFont('courier','B',8);
$this->Cell(40,6,'',0,0,'C');
$this->Cell(180,10,'RUC: '.$datose->numero_ruc,0,0,'C'); 
$this->Ln(10);

$this->SetFont('Arial','B',12);
$this->Cell(40,6,'',0,0,'C');
$this->Cell(100,2,'REPORTE DE VENTAS POR CLIENTE',0,0,'C'); 
$this->Ln(6);

if ($tipo=="RUC") {
    $rspta= $venta->ventasxCliente($ndoc,  $ano, $mes, $fpago);
    while($reg=$rspta->fetch_object())
    {
    $numero_documento=$reg->numero_documento;
    $razon_social=$reg->razon_social;
    $moneda=$reg->moneda;
    $fopago=$reg->tipopago;
    }
}
elseif($tipo=="RUCAG")
{
    $rspta= $venta->ventasxClienteAgrupado($ndoc, $ano, $mes, $fpago);
    while($reg=$rspta->fetch_object())
    {
    $numero_documento=$reg->numero_documento;
    $razon_social=$reg->razon_social;
    $moneda=$reg->moneda;
    $fopago=$reg->tipopago;
    }

}
else
{
  $rspta= $venta->ventasxClienteDni($ndoc, $_SESSION['idempresa']);
$numero_documento="No hay datos";
$razon_social="No hay datos";

while($reg=$rspta->fetch_object())
{
    if (isset($reg)) {

         $numero_documento=$reg->numero_documento;
        $razon_social=$reg->nombres. "  ".$reg->apellidos ;
        $moneda=$reg->moneda;
       
    }
    else
    {
        echo "No existen datos";
        $numero_documento="No hay datos";
        $razon_social="No hay datos";
    }
} 
}

//Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
$this->SetFillColor(232,232,232); 
$this->SetFont('courier','B',10);
$this->Cell(45,6,utf8_decode('RUC/DNI: ').$numero_documento,0,0,'C',0) ; 
$this->Cell(90,6,utf8_decode('NOMBRE: ').utf8_decode(htmlspecialchars_decode($razon_social)),0,0,'C',0) ; 
$this->Cell(80,6,utf8_decode('MONEDA: ').utf8_decode(htmlspecialchars_decode($moneda)),0,0,'C',0) ; 
$this->Ln(1);
$this->Cell(180,14,utf8_decode('FORMA PAGO: ').utf8_decode(htmlspecialchars_decode($fopago)),0,0,'C',0) ; 
//Titulos
$this->Ln(1);
$this->SetFont('courier','B',8);
$this->Cell(20 ,25,utf8_decode('NÚMERO'),0,0,'C',0) ;  
$this->Cell(24,25,utf8_decode('FECHA'),0,0,'C',0) ;  
$this->Cell(13,25,utf8_decode('CÓDIGO'),0,0,'C',0) ;  
$this->Cell(45,25,utf8_decode('NOMBRE'),0,0,'C',0) ;  
$this->Cell(20,25,utf8_decode('CANTIDAD'),0,0,'C',0) ;  
$this->Cell(15,25,utf8_decode('NETO'),0,0,'C',0) ;  
$this->Cell(15,25,utf8_decode('IGV'),0,0,'C',0) ;  
$this->Cell(15,25,utf8_decode('ICBPER'),0,0,'C',0) ;  
$this->Cell(15,25,utf8_decode('TOTAL'),0,0,'C',0) ;    
$this->Ln(11);
$this->SetFillColor(232,232,232); 
$this->SetFont('courier','b',8);
$this->Cell(180,6,utf8_decode('-----------------------------------------------------------------------------------------------------------'),0,0,'C',0) ; 

$this->Ln(6);


}


function Footer()
        {
            $this->AliasNbPages();
            // Posición: a 1,5 cm del final
            $this->SetY(-15);
            // Arial italic 8
            $this->SetFont('Arial','I',8);
            // Número de página
            $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
        }


function Row2($data)
{
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h);
        //$this->Rect(5,5,5,5);
        //Print the text
        $this->MultiCell($w,5,$data[$i],0,$a);
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}
}
?>