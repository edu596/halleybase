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

function SetWidths2($w)
{
    //Set the array of column widths
    $this->widths=$w;
}

function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}



function Header()
{

    require_once "../modelos/Compra.php";
    $compra= new Compra();
    $datos = $compra->datosemp($_SESSION['idempresa']);
    $datose = $datos->fetch_object();

$tcom=$_POST['tcomprobante'];
$tmon=$_POST['tmonedaa'];
$f1=$_POST['fecha1'];
$f2=$_POST['fecha2'];

$this->SetFont('Arial','B',10);
$this->Cell(40,6,'',0,0,'C');
$this->Cell(-20,2,utf8_decode($datose->nombre_comercial),0,0,'C'); 

$this->Cell(40,6,'',0,0,'C');
$this->Cell(230,2,'RUC: '.$datose->numero_ruc,0,0,'C'); 
$this->Ln(6);

$this->SetFont('Arial','B',12);
$this->Cell(40,6,'',0,0,'C');
$this->Cell(110,2,utf8_decode('REPORTE DE ESTADOS DE COMPROBANTES').' DEL '.$f1.' AL '.$f2,0,0,'C'); 

$this->Ln(6);
$this->SetFont('Arial','B',10);
 $this->SetTextColor(240, 255, 240);
 $this->SetFillColor(9,139,162,255);
//$this->Cell(-1,6,'',0,0,'C');
$this->Cell(20,10,utf8_decode('Fecha'),1,0,'C',true) ;  
$this->Cell(80,10,utf8_decode('Cliente'),1,0,'C',true) ;  
$this->Cell(20,10,utf8_decode('Número'),1,0,'C',true) ;  
$this->Cell(20,10,utf8_decode('Total'),1,0,'C',true) ;  

$this->Cell(20,10,utf8_decode('SUNAT '),1,0,'C',true) ;  
$this->Cell(20,10,utf8_decode('SISTEMA'),1,0,'C',true) ;  

$this->Ln(10);


// require_once "../modelos/Compra.php";
// $compra= new Compra();
// $datos = $compra->datosemp($_SESSION['idempresa']);
// $datose = $datos->fetch_object();

// $this->SetFont('Arial','B',10);
// $this->Cell(40,6,'',0,0,'C');
// $this->Cell(-20,2,utf8_decode($datose->nombre_comercial),0,0,'C'); 
// $this->SetFont('Arial','B',7);
// $this->Cell(40,10,utf8_decode('01: FACTURA / 03: BOLETA / 07: NOTA DE CRÉDITO / 08: NOTA DE DÉBITO '),0,0,'C'); 

// $this->SetFont('Arial','B',10);
// $this->Cell(40,6,'',0,0,'C');
// $this->Cell(160,2,'RUC: '.$datose->numero_ruc,0,0,'C'); 
// $this->Ln(16);
// $this->SetFont('Arial','B',12);
// $this->Cell(40,6,'',0,0,'C');
// $this->Cell(100,2,'REGISTRO DE VENTAS DEL MES DE '.$mesL.' DEL '.$ano.' T.M. '.$mone,0,0,'C'); 
// $this->Ln(1);
// $this->SetFont('Arial','B',8);
// $this->Cell(5,20,utf8_decode('DÍA'),0,0,'C',0) ;  
// $this->Cell(20,20,utf8_decode('TIP\DOC'),0,0,'C',0) ;  
// $this->Cell(15,20,utf8_decode('NÚMERO'),0,0,'C',0) ;  
// $this->Cell(25,20,utf8_decode('RUC.'),0,0,'C',0) ;  
// $this->Cell(60,20,utf8_decode('CLIENTE.'),0,0,'C',0) ;  
// $this->Cell(15,20,utf8_decode('BASE IMP.'),0,0,'C',0) ;  
// $this->Cell(15,20,utf8_decode('IGV'),0,0,'C',0) ;  
// $this->Cell(10,20,utf8_decode('ICBPER'),0,0,'C',0) ;  
// $this->Cell(25,20,utf8_decode('TOTAL'),0,0,'C',0) ; 
// $this->Ln(12);
 
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
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h);
        //$this->Rect(5,5,1,1);
        //Print the text

        $this->MultiCell($w,5,$data[$i],0,$a);

        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
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
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        //$this->Rect($x,$y,$w,$h);
        //$this->Rect(1,1,1,1);
        //Print the text

        $this->MultiCell($w,5,$data[$i],0,$a,true);

        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);

    }


function Row3($data)
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
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h);
        //$this->Rect(1,1,1,1);
    
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