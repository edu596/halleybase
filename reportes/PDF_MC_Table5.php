<?php
require('../fpdf181/fpdf.php');

class PDF_MC_Table extends FPDF
{
var $widths;
var $aligns;

    // $cod = "";
    // $nom = "";
    // $si = 0;
    // $ cc= "";
    // $vi = 0;

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

$ano=$_GET['anoo'];
//$fechas=$_POST['fechas'];
$codigoInterno=$_GET['codigoI'];

    $nom=""; 
    
    $cc = "0";
    $si = "0";
    $vi = "0";
    $um="";


require_once "../modelos/Factura.php";
$factura = new Factura();
$datos = $factura->datosemp($_SESSION['idempresa']);
$datose = $datos->fetch_object();

require_once "../modelos/Articulo.php";
$articulo = new Articulo();
//$rspta = $articulo->kardexArticulo($ano,$codigoInterno, $_SESSION['idempresa']);

$rspta2 = $articulo->saldoinicialV2($ano,$codigoInterno, $_SESSION['idempresa']);
while($reg1= $rspta2->fetch_object())
{ 
    $nom=$reg1->nombre; 

    //$factorc=$reg1->factorc;
    $cc = $reg1->costoi;
    $si = $reg1->saldoi;
    $vi = $reg1->saldoi * $reg1->costoi;
    //$um=$reg1->nombreum;

}
    $cod = "$codigoInterno";
    $nom = "$nom";
    $si = "$si";
    $cc = "$cc";
    $vi = "$vi";

    
    $co2='0';
    $sa2='0';
    $va2='0';


//Seteamos el tipo de letra y creamos el título de la página. No es un encabezado no se repetirá
$this->SetFont('arial','B',8);
$this->Cell(40,6,'',0,0,'C');
$this->Cell(-40,2,utf8_decode($datose->nombre_comercial),0,0,'C'); 
$this->Cell(42,10,'EJERCICIO '.$ano,0,0,'C'); 
$this->SetFont('arial','B',8);
$this->Cell(40,6,'',0,0,'C');
$this->Cell(180,2,'RUC: '.$datose->numero_ruc,0,0,'C'); 
$this->Ln(10);
$this->SetFont('Arial','B',12);
$this->Cell(40,6,'',0,0,'C');
$this->Cell(105,2,utf8_decode('KARDEX POR ARTÍCULO'),0,0,'C'); 
$this->Ln(1);
$this->SetFont('Courier','B',8);
$this->Cell(185,5,utf8_decode('================================'),0,0,'C',0) ; 
$this->Ln(6);


//Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
$this->SetFillColor(232,232,232); 
$this->SetFont('arial','B',9);
$this->Cell(50,6,utf8_decode('Código: ').utf8_decode($cod),0,0,'C',0) ; 
$this->Cell(130,6,utf8_decode('Nombre: ').utf8_decode($nom),0,0,'C',0) ; 
$this->Ln(1);
$this->Cell(60,17,utf8_decode('Saldo inicial: '. number_format($si,2)." UNI MED COMPRA: ".$um),0,0,'C',0);
$this->Cell(80,17,utf8_decode('Costo: '.$cc),0,0,'C',0);
$this->Cell(60,17,utf8_decode('Valor inicial: ').number_format($vi,2),0,0,'C',0);

$this->Ln(1);
$this->SetFont('courier','B',8);
$this->Cell(185,22,utf8_decode('---------------------------------------------------------------------------------------------------------------'),0,0,'C',0) ; 
$this->Ln(1);

$this->SetFont('arial','B',8);
$this->Cell(14,35,utf8_decode('FECHA'),0,0,'C',0) ;  
$this->Cell(15,35,utf8_decode('TIP\DOC'),0,0,'C',0) ;  
$this->Cell(24,35,utf8_decode('NUMERO'),0,0,'C',0) ;  
$this->Cell(20,35,utf8_decode('TRANSAC.'),0,0,'C',0) ;  
$this->Cell(20,35,utf8_decode('CANTIDAD.'),0,0,'C',0) ;  
$this->Cell(25,35,utf8_decode('VALOR UNI'),0,0,'C',0) ;  
$this->Cell(8,35,utf8_decode('UND'),0,0,'C',0) ;  
$this->Cell(8,35,utf8_decode('|'),0,0,'C',0) ;  
$this->Cell(18,35,utf8_decode('SALDO FI.'),0,0,'C',0) ;  
$this->Cell(25,35,utf8_decode('COSTO FINAL'),0,0,'C',0) ;  
$this->Cell(15,35,utf8_decode('VALOR FI.'),0,0,'C',0) ;  

$this->Ln(20);
    
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