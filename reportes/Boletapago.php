<?php
require('fpdf.php');

define('EURO', chr(128) );
define('EURO_VAL', 6.55957 );

 
class PDF_Invoice extends FPDF
{
// private variables
var $colonnes;
var $format;
var $angle=0;



protected $javascript;
    protected $n_js;

    function IncludeJS($script, $isUTF8=false) {
        if(!$isUTF8)
            $script=utf8_encode($script);
        $this->javascript=$script;
    }

    function _putjavascript() {
        $this->_newobj();
        $this->n_js=$this->n;
        $this->_put('<<');
        $this->_put('/Names [(EmbeddedJS) '.($this->n+1).' 0 R]');
        $this->_put('>>');
        $this->_put('endobj');
        $this->_newobj();
        $this->_put('<<');
        $this->_put('/S /JavaScript');
        $this->_put('/JS '.$this->_textstring($this->javascript));
        $this->_put('>>');
        $this->_put('endobj');
    }

    function _putresources() {
        parent::_putresources();
        if (!empty($this->javascript)) {
            $this->_putjavascript();
        }
    }

    function _putcatalog() {
        parent::_putcatalog();
        if (!empty($this->javascript)) {
            $this->_put('/Names <</JavaScript '.($this->n_js).' 0 R>>');
        }
    }


    






    function AutoPrint($printer='')
    {
        // Open the print dialog
        if($printer)
        {
            $printer = str_replace('\\', '\\\\', $printer);
            $script = "var pp = getPrintParams();";
            $script .= "pp.interactive = pp.constants.interactionLevel.full;";
            $script .= "pp.printerName = '$printer'";
            $script .= "print(pp);";
        }
        else
            $script = 'print(true);';
        $this->IncludeJS($script);
    }
 


// private functions
function RoundedRect($x, $y, $w, $h, $r, $style = '')
{
    $k = $this->k;
    $hp = $this->h;
    if($style=='F')
        $op='f';
    elseif($style=='FD' || $style=='DF')
        $op='B';
    else
        $op='S';
    $MyArc = 4/3 * (sqrt(2) - 1);
    $this->_out(sprintf('%.2F %.2F m',($x+$r)*$k,($hp-$y)*$k ));
    $xc = $x+$w-$r ;
    $yc = $y+$r;
    $this->_out(sprintf('%.2F %.2F l', $xc*$k,($hp-$y)*$k ));
 
    $this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);
    $xc = $x+$w-$r ;
    $yc = $y+$h-$r;
    $this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-$yc)*$k));
    $this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);
    $xc = $x+$r ;
    $yc = $y+$h-$r;
    $this->_out(sprintf('%.2F %.2F l',$xc*$k,($hp-($y+$h))*$k));
    $this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);
    $xc = $x+$r ;
    $yc = $y+$r;
    $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$yc)*$k ));
    $this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
    $this->_out($op);
}
 
function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
{
    $h = $this->h;
    $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1*$this->k, ($h-$y1)*$this->k,
                        $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
}
 
function Rotate($angle, $x=-1, $y=-1)
{
    if($x==-1)
        $x=$this->x;
    if($y==-1)
        $y=$this->y;
    if($this->angle!=0)
        $this->_out('Q');
    $this->angle=$angle;
    if($angle!=0)
    {
        $angle*=M_PI/180;
        $c=cos($angle);
        $s=sin($angle);
        $cx=$x*$this->k;
        $cy=($this->h-$y)*$this->k;
        $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
    }
}
 
function _endpage()
{
    if($this->angle!=0)
    {
        $this->angle=0;
        $this->_out('Q');
    }
    parent::_endpage();
}






// public functions
function sizeOfText( $texte, $largeur )
{
    $index    = 0;
    $nb_lines = 0;
    $loop     = TRUE;
    while ( $loop )
    {
        $pos = strpos($texte, "\n");
        if (!$pos)
        {
            $loop  = FALSE;
            $ligne = $texte;
        }
        else
        {
            $ligne  = substr( $texte, $index, $pos);
            $texte = substr( $texte, $pos+1 );
        }
        $length = floor( $this->GetStringWidth( $ligne ) );
        $res = 1 + floor( $length / $largeur) ;
        $nb_lines += $res;
    }
    return $nb_lines;
}
 


  // cabecera arriba
function addSocietenombre($nom)
{
    $x1 = 10;
    $y1 = 6;
    $this->SetXY( $x1, $y1 + 4 );
    $this->SetFont('Arial','B',12);
    $length = $this->GetStringWidth($nom);
    $this->Cell( $length, 2, $nom, 'C');
}


// Company
function addSociete($nom, $adresse,$logo,$ext_logo )
{
   $x1 = 35;
    $y1 = 10;
    //Positionnement en bas
    $this->Image($logo , 10 , 15, 25 , 13 , $ext_logo); // (x,y, ancho, alto)
    $this->SetXY( $x1, $y1 );
    $this->SetFont('Arial','B',12);
    //$length = $this->GetStringWidth( $nom );
    //$this->Cell( $length, 2, $nom);

    $this->SetXY( $x1, $y1 + 4 );
    $this->SetFont('Arial','B',7);
    $length = $this->GetStringWidth( $adresse );
    //Coordonnées de la société
    $lignes = $this->sizeOfText( $adresse, $length) ;
    $this->MultiCell($length, 3, $adresse);
}


function addSocietedireccion($adresse)
{
    $x1 = 35;
    $y1 = 16;
  
    $this->SetXY( $x1, $y1 + 4 );
    $this->SetFont('Arial','B',7);
    //$length = $this->GetStringWidth($adresse);
    //Coordonnées de la société
    //$lignes = $this->sizeOfText( $adresse, $length) ;
    $this->MultiCell(85, 3, $adresse);
}






function ImgQr($logo,$ext_logo )
{
    $x1 = 155;
    $y1 = 80;
    //Positionnement en bas
    $this->Image($logo , 178 , 34 , 15 , 15 , $ext_logo);
    $this->Image($logo , 178 , 180 , 15 , 15 , $ext_logo);
    
}

function addSocietenombre2($nom)
{
    $x1 = 10;
    $y1 = 150;
    $this->SetXY( $x1, $y1 + 4 );
    $this->SetFont('Arial','B',12);
    $length = $this->GetStringWidth($nom);
    $this->Cell( $length, 2, $nom);
}



function addSociete2( $nom, $adresse,$logo,$ext_logo )
{
    $x1 = 35;
    $y1 =154   ;
    //Positionnement en bas
     $this->Image($logo , 10 ,159, 25 , 13 , $ext_logo);
    $this->SetXY( $x1, $y1 );
    $this->SetFont('Arial','B',12);
    //$length = $this->GetStringWidth( $nom );
    //$this->Cell( $length, 2, $nom);

    $this->SetXY( $x1, $y1 + 4 );
    $this->SetFont('Arial','B',7);
    $length = $this->GetStringWidth( $adresse );
    //Coordonnées de la société
    $lignes = $this->sizeOfText( $adresse, $length) ;
    $this->MultiCell($length, 3, $adresse);
}


function addSocietedireccion2($adresse)
{
    $x1 = 35;
    $y1 = 160;
  
    $this->SetXY( $x1, $y1 + 4 );
    $this->SetFont('Arial','B',7);
    //$length = $this->GetStringWidth($adresse);
    //$length = $this->GetStringWidth($adresse);
    //Coordonnées de la société
    //$lignes = $this->sizeOfText( $adresse, $length) ;
    $this->MultiCell(85, 3, $adresse);
}
 
// Label and number of invoice/estimate
function fact_dev($num )
{
    $r1  = $this->w - 63;
    $r2  = $r1 + 50;
    $y1  = 6;
    $y2  = $y1 + 20;
    $mid = ($r1 + $r2 ) / 2;
     
    //$texte  = $ruc.$num;    
    $texte  = $num;    
    $szfont = 12;
    $loop   = 0;
     
    while ( $loop == 0 )
    {
       $this->SetFont( "Arial", "B", $szfont );
       $sz = $this->GetStringWidth( $texte );
       if ( ($r1+$sz) > $r2 )
          $szfont --;
       else
          $loop ++;
    }
 
    $this->SetLineWidth(0.1);
    //$this->SetFillColor(72,209,20);
    $this->SetFillColor(255,255,255);
    $this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 2.5, 'DF');
    $this->SetXY( $r1+1, $y1+2);
    $this->Cell($r2-$r1 -1,5, $texte, 0, 0, "C" );
}

// Label and number of invoice/estimate
function fact_dev2( $libelle, $num )
{
    $r1  = $this->w - 63;
    $r2  = $r1 + 50;
    $y1  = 145;
    $y2  = $y1 -137;
    $mid = ($r1 + $r2 ) / 2;
     
    //$texte  = $libelle  . $num;    
    $texte  = $num;    
    $szfont = 12;
    $loop   = 0;
     
    while ( $loop == 0 )
    {
       $this->SetFont( "Arial", "B", $szfont );
       $sz = $this->GetStringWidth( $texte );
       if ( ($r1+$sz) > $r2 )
          $szfont --;
       else
          $loop ++;
    }
 
    $this->SetLineWidth(0.1);
    //$this->SetFillColor(72,209,20);
    $this->SetFillColor(255,255,255);
    $this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 2.5, 'DF');
    $this->SetXY( $r1+1, $y1+2);
    $this->Cell($r2-$r1 -1,5, $texte, 0, 0, "C" );
}
 
// Estimate
function addDevis( $numdev )
{
    $string = sprintf("DEV%04d",$numdev);
    $this->fact_dev( "Devis", $string );
}
 
// Invoice
function addFacture( $numfact )
{
    $string = sprintf("FA%04d",$numfact);
    $this->fact_dev( "Facture", $string );
}
 
function addDate( $date )
{
    $r1  = $this->w - 61;
    $r2  = $r1 + 49;
    $y1  = 17;
    $y2  = $y1 ;
    $mid = $y1 + ($y2 / 2);
    $this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
    $this->Line( $r1, $mid, $r2, $mid);
    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+3 );
    $this->SetFont( "Arial", "B", 11);
    $this->Cell(10,5, "Fecha", 0, 0, "C");
    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+9 );
    $this->SetFont( "Arial", "", 10);
    $this->Cell(10,5,$date, 0,0, "C");
}

function contenidoboleta($nombrecomer, $domfis, $numero_ruc, $numbolpag, $sueldobruto, $horasex, $totalhorasEx, $horast, $asigfam, $diast, $totaldiast, $totalbruto, $totaldcto, $sueldopagar, $nombreSeguro, $tiposeguro, $aoafp, $invsob,	$comiafp, $snp, $total5t, $taoafp,	$tinvsob, $tcomiafp, $tsnp, $nombresE, $apellidosE, $fechaingreso, $ocupacion, $tiporemuneracion, $dni, $cusspp, $trabNoct, $mes, $ano, $fechapago, $totalaportee, $valorletras, $conceptoadicional, $importeconcepto, $autogenessa)
{
    
	switch ($mes) {
		case '01':
			$mes='ENERO';
			break;
			case '02':
			$mes='FEBRERO';
			
			case '03':
			$mes='MARZO';
			break;
			case '04':
			$mes='ABRIL';
			break;
			case '05':
			$mes='MAYO';
			break;
			case '06':
			$mes='JUNIO';
			break;
			case '07':
			$mes='JULIO';
			break;
			case '08':
			$mes='AGSOTO';
			break;
			case '09':
			$mes='SEPTIEMBRE';
			break;
			case '10':
			$mes='OCTUBRE';
			break;
			case '11':
			$mes='NOVIEMBRE';
			break;
			case '12':
			$mes='DICIEMBRE';
			break;
			

		
		default:
			# code...
			break;
	}

    $r1  = $this->w - 145;
    $r2  = $r1 + 140;
    $y1  = 5;
    $y2  = 200 ;
    //$this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
    

    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+1 );
    $this->SetFont( "Arial", "B", 14);
    $this->Cell(10,5, $nombrecomer, 0, 0, "C");

    $this->SetXY( $r1 + ($r2-$r1)/2 + 20 , $y1+6 );
    $this->SetFont( "Arial", "", 8);
    $this->Cell(10,5, utf8_decode($domfis)."  R.U.C. N ".$numero_ruc, 0, 0, "R");


    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+12 );
    $this->SetFont( "Arial", "B", 12);
    $this->Cell(10,5, "BOLETA DE PAGO", 0, 0, "C");

    $this->SetXY( $r1 + ($r2-$r1)/2 + 45, $y1+12 );
    $this->SetFont( "Arial", "B", 10);
    $this->Cell(10,5, utf8_decode("N°").$numbolpag , 0, 0, "R");

    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+16 );
    $this->SetFont( "Arial", "", 7);
    $this->Cell(10,5, "D.S. 001-98 / TR", 0, 0, "C");


    $this->SetXY( $r1 + ($r2-$r1)/2 - 65, $y1+20 );
    $this->Cell(10,5, "NOMBRE", 0, 0, "L");
    $this->SetXY( $r1 + ($r2-$r1)/2 - 50, $y1+20 );
    $this->Cell(10,5, utf8_decode($nombresE." ".$apellidosE), 0, 0, "L");

    $this->SetXY( $r1 + ($r2-$r1)/2 - 65, $y1+26 );
    $this->Cell(10,5, utf8_decode("OCUPACIÓN"), 0, 0, "L");
    $this->SetXY( $r1 + ($r2-$r1)/2 - 45, $y1+26 );
    $this->Cell(10,5, utf8_decode($ocupacion), 0, 0, "L");

    $this->SetXY( $r1 + ($r2-$r1)/2 + 30, $y1+26 );
    $this->Cell(10,5, "DNI", 0, 0, "R");
    $this->SetXY( $r1 + ($r2-$r1)/2  + 40, $y1+26 );
    $this->Cell(10,5, utf8_decode($dni), 0, 0, "L");


    $this->SetXY( $r1 + ($r2-$r1)/2 - 65, $y1+32 );
    $this->Cell(10,5, utf8_decode("REMUNERACIÓN"), 0, 0, "L");
    $this->SetXY( $r1 + ($r2-$r1)/2 - 40, $y1+32 );
    $this->Cell(10,5, $tiporemuneracion, 0, 0, "L");

    $this->SetXY( $r1 + ($r2-$r1)/2 - 10, $y1+32 );
    $this->Cell(10,5, utf8_decode("MES DE"), 0, 0, "C");
    $this->SetXY( $r1 + ($r2-$r1)/2 , $y1+32 );
    $this->Cell(10,5, utf8_decode($mes), 0, 0, "C");

    $this->SetXY( $r1 + ($r2-$r1)/2 + 30, $y1+32 );
    $this->Cell(10,5, utf8_decode("AÑO"), 0, 0, "R");
    $this->SetXY( $r1 + ($r2-$r1)/2 + 38, $y1+32 );
    $this->Cell(10,5, $ano, 0, 0, "R");

    $this->SetXY( $r1 + ($r2-$r1)/2 - 65, $y1+38 );
    $this->Cell(10,5, "FECHA DE INGRESO", 0, 0, "L");
    $this->SetXY( $r1 + ($r2-$r1)/2 - 38, $y1+38 );
    $this->Cell(10,5, $fechaingreso, 0, 0, "L");

    $this->SetXY( $r1 + ($r2-$r1)/2 + 15, $y1+38 );
    $this->Cell(10,5, utf8_decode("N AUTOGENEREADO ESSALUD"), 0, 0, "R");

    $this->SetXY( $r1 + ($r2-$r1)/2 + 30, $y1+38 );
    $this->Cell(10,5, utf8_decode($autogenessa), 0, 0, "R");
    

    $this->SetXY( $r1 + ($r2-$r1)/2 + 30, $y1+44 );
    $this->Cell(10,5, utf8_decode("CUSPP N"), 0, 0, "R");
    $this->SetXY( $r1 + ($r2-$r1)/2 + 50, $y1+44 );
    $this->Cell(10,5, utf8_decode($cusspp), 0, 0, "R");

    $this->SetFont( "Arial", "B", 10);
    $this->SetXY( $r1 + ($r2-$r1)/2 -65, $y1+44 );
    $this->Cell(10,5, utf8_decode("REMUNERACIÓN:"), 0, 0, "L");



    $r11  = $this->w - 140;
    $r22  = $r1 + 135;
    $y11  = 55;
    $y22  = 40 ;
    $mid1 = $y11 + ($y22 / 6);
    $mid2 = $y11 + ($y22 / 2);

    $this->RoundedRect($r11, $y11, ($r22 - $r11), $y22, 3.5, 'D');
    $this->Line( $r11, $mid1, $r22, $mid1);
    
    $this->Line(105, 55, 105, 95);
    $this->Line(105, 90 , 139, 90);


    $this->SetFont( "Arial", "B", 12);
    $this->SetXY( $r11 + ($r22-$r11)/2 - 20, $y11+1 );
    $this->Cell(10,5, utf8_decode("CONCEPTO"), 0, 0, "C");

    $this->SetXY( $r11 + ($r22-$r11)/2 + 45, $y11+1 );
    $this->Cell(10,5, utf8_decode("IMPORTE"), 0, 0, "R");

    $this->SetFont( "Arial", "B", 8);
    $this->SetXY( $r11 + ($r22-$r11)/2 - 60, $y11+10 );
    $this->Cell(10,5, utf8_decode("SUELDO MENSUAL"), 0, 0, "L");

    $this->SetXY( $r11 + ($r22-$r11)/2 - 20, $y11+10 );
    $this->Cell(10,5, intval($diast).utf8_decode(" días"), 0, 0, "L");

    $this->SetXY( $r11 + ($r22-$r11)/2 , $y11+10 );
    $this->Cell(10,5, intval($totaldiast)." ".utf8_decode("horas"), 0, 0, "L");

    $this->SetXY( $r11 + ($r22-$r11)/2 + 50 , $y11+10 );
    $this->Cell(10,5, $sueldobruto, 0, 0, "R");


    $this->SetXY( $r11 + ($r22-$r11)/2 - 60, $y11+15 );
    $this->Cell(10,5, utf8_decode("HORAS EXTRAS"), 0, 0, "L");

    $this->SetXY( $r11 + ($r22-$r11)/2 , $y11+15 );
    $this->Cell(10,5, $totalhorasEx." Hs", 0, 0, "R");

    $this->SetXY( $r11 + ($r22-$r11)/2 + 50, $y11+15 );
    $this->Cell(10,5, $horast, 0, 0, "R");

    $this->SetXY( $r11 + ($r22-$r11)/2 - 60, $y11+20 );
    $this->Cell(10,5, utf8_decode("ASIGNACIÓN FAMILIAR"), 0, 0, "L");

    $this->SetXY( $r11 + ($r22-$r11)/2 + 50  , $y11+20 );
    $this->Cell(10,5, $asigfam, 0, 0, "R");

    $this->SetXY( $r11 + ($r22-$r11)/2 - 60, $y11+25 );
    $this->Cell(10,5, utf8_decode("SOBRET. TRAB. NOCT."), 0, 0, "L");

    $this->SetXY( $r11 + ($r22-$r11)/2 + 50  , $y11+25 );
    $this->Cell(10,5, $trabNoct, 0, 0, "R");

    $this->SetXY( $r11 + ($r22-$r11)/2 - 60, $y11+30 );
    $this->Cell(10,5, utf8_decode($conceptoadicional), 0, 0, "L");

    $this->SetXY( $r11 + ($r22-$r11)/2 + 50  , $y11+30 );
    $this->Cell(10,5, $importeconcepto, 0, 0, "R");

    $this->SetXY( $r11 + ($r22-$r11)/2 + 10, $y11+35 );
    $this->Cell(10,5, utf8_decode("TOTAL S/"), 0, 0, "L");

    $this->SetXY( $r11 + ($r22-$r11)/2 + 50, $y11+35 );
    $this->Cell(10,5, $totalbruto, 0, 0, "R");


    $this->SetFont( "Arial", "B", 10);
    $this->SetXY( $r1 + ($r2-$r1)/2 -65, $y1+95 );
    $this->Cell(10,5, utf8_decode("DESCUENTOS:"), 0, 0, "L");

    $this->SetXY( $r1 + ($r2-$r1)/2 - 35, $y1+95 );
    $this->Cell(10,5, utf8_decode($nombreSeguro), 0, 0, "L");

    $r11  = $this->w - 140;
    $r22  = $r1 + 95;
    $y11  = 105;
    $y22  = 40 ;
    $mid1 = $y11 + ($y22 / 6);
    $mid2 = $y11 + ($y22 / 2);

    $this->RoundedRect($r11, $y11, ($r22 - $r11), $y22, 3.5, 'D');
    $this->Line( $r11, $mid1, $r22, $mid1);
    $this->Line(50, 145, 50, 105);
    $this->Line(70, 145, 70, 105);

    $this->SetFont( "Arial", "B", 10);
    $this->SetXY( $r1 + ($r2-$r1)/2 - 55, $y1+101 );
    $this->Cell(10,5, utf8_decode("CONCEPTO"), 0, 0, "L");

    $this->SetXY( $r1 + ($r2-$r1)/2 -23, $y1+101 );
    $this->Cell(10,5, utf8_decode("TASA %"), 0, 0, "L");

    $this->SetXY( $r1 + ($r2-$r1)/2 , $y1+101 );
    $this->Cell(10,5, utf8_decode("IMPORTE"), 0, 0, "L");

    
    $this->SetFont( "Arial", "B", 8);
    $this->SetXY( $r1 + ($r2-$r1)/2 - 65, $y1+111 );
    $this->Cell(10,5, utf8_decode("Aporte Oblig. AFP"), 0, 0, "L");

    $this->SetXY( $r1 + ($r2-$r1)/2 - 65, $y1+116 );
    $this->Cell(10,5, utf8_decode("Invalidez y sobrevi."), 0, 0, "L");

    $this->SetXY( $r1 + ($r2-$r1)/2 - 65, $y1+121 );
    $this->Cell(10,5, utf8_decode("Comisión AFP"), 0, 0, "L");

    $this->SetXY( $r1 + ($r2-$r1)/2 - 65, $y1+126 );
    $this->Cell(10,5, utf8_decode("Retención 5ta categ."), 0, 0, "L");

    $this->SetXY( $r1 + ($r2-$r1)/2 - 65, $y1+132 );
    $this->Cell(10,5, utf8_decode("SIST.NAC.PENSIONES"), 0, 0, "L");

    
    $this->SetXY( $r1 + ($r2-$r1)/2 - 20, $y1+111 );
    $this->Cell(10,5, $aoafp , 0, 0, "L");

	$this->SetXY( $r1 + ($r2-$r1)/2 - 20, $y1+116 );
    $this->Cell(10,5, $invsob , 0, 0, "L");

    $this->SetXY( $r1 + ($r2-$r1)/2 - 20, $y1+121 );
    $this->Cell(10,5, $comiafp , 0, 0, "L");

    $this->SetXY( $r1 + ($r2-$r1)/2 - 20, $y1+126 );
    $this->Cell(10,5, $total5t , 0, 0, "L");

    $this->SetXY( $r1 + ($r2-$r1)/2 - 20, $y1+132 );
    $this->Cell(10,5, $snp , 0, 0, "L");

        
    $this->SetXY( $r1 + ($r2-$r1)/2 , $y1+111 );
    $this->Cell(10,5, $taoafp , 0, 0, "L");

	$this->SetXY( $r1 + ($r2-$r1)/2 , $y1+116 );
    $this->Cell(10,5, $tinvsob , 0, 0, "L");

    $this->SetXY( $r1 + ($r2-$r1)/2, $y1+121);
    $this->Cell(10,5, $tcomiafp , 0, 0, "L");

    $this->SetXY( $r1 + ($r2-$r1)/2 , $y1+126);
    $this->Cell(10,5, $total5t , 0, 0, "L");

    $this->SetXY( $r1 + ($r2-$r1)/2 , $y1+132);
    $this->Cell(10,5, $tsnp , 0, 0, "L");

    
    $this->SetFont( "Arial", "B", 10);
    $this->SetXY( $r1 + ($r2-$r1)/2 + 40 , $y1+110 );
    $this->Cell(5,5, utf8_decode("T. DSCTO"), 0, 0, "R");
    $this->SetXY( $r1 + ($r2-$r1)/2 + 46 , $y1+110 );
    $this->Cell(20,5, $totaldcto, 1, 1, "C");

    $this->SetXY( $r1 + ($r2-$r1)/2 + 40 , $y1+125 );
    $this->Cell(5,5, utf8_decode("T. PAGAR"),0,0,"R");
    $this->SetXY( $r1 + ($r2-$r1)/2 + 46 , $y1+125 );
    $this->Cell(20,5, $sueldopagar, 1, 1, "C");

    
    $this->SetFont( "Arial", "B", 8);
    $this->SetXY( $r1 + ($r2-$r1)/2 -65, $y1+144 );
    $this->Cell(10,5, utf8_decode("FECHA DE PAGO:"), 0, 0, "L");

  $this->SetXY( $r1 + ($r2-$r1)/2 - 35, $y1+144 );
  $fechap = substr($fechapago, 0, 10);
  $numeroDia = date('d', strtotime($fechapago));
  $dia = date('l', strtotime($fechapago));
  $mes = date('F', strtotime($fechapago));
  $anio = date('Y', strtotime($fechapago));
  $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
  $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
  $nombredia = str_replace($dias_EN, $dias_ES, $dia);
  $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
  $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
  $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
  $this->Cell(10,5, utf8_decode($nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio), 0, 0, "L");

    $this->SetFont( "Arial", "B", 10);
    $this->SetXY( $r1 + ($r2-$r1)/2 -65, $y1+153 );
    $this->Cell(10,5, utf8_decode("APORTES DE LA EMPRESA:"), 0, 0, "L");

    $r11  = $this->w - 140;
    $r22  = $r1 + 95;
    $y11  = 163;
    $y22  = 40 ;
    $mid1 = $y11 + ($y22 / 6);
    $mid2 = $y11 + ($y22 / 2);

    $this->RoundedRect($r11, $y11, ($r22 - $r11), $y22, 3.5, 'D');
    $this->Line( $r11, $mid1, $r22, $mid1);
    $this->Line(50, 163, 50, 203);
    $this->Line(70, 163, 70, 203);

    $this->SetFont( "Arial", "B", 10);
    $this->SetXY( $r1 + ($r2-$r1)/2 - 65, $y1+160 );
    $this->Cell(10,5, utf8_decode("CONCEPTO"), 0, 0, "L");

    $this->SetFont( "Arial", "B", 8);
    $this->SetXY( $r1 + ($r2-$r1)/2 - 65, $y1+170 );
    $this->Cell(10,5, utf8_decode("ESSALUD"), 0, 0, "L");

    $this->SetFont( "Arial", "B", 10);
    $this->SetXY( $r1 + ($r2-$r1)/2 - 23, $y1+160 );
    $this->Cell(10,5, utf8_decode("TASA %"), 0, 0, "L");

    $this->SetFont( "Arial", "B", 8);
    $this->SetXY( $r1 + ($r2-$r1)/2 - 23, $y1+170 );
    $this->Cell(10,5, "9.00 %", 0, 0, "L");

    $this->SetFont( "Arial", "B", 10);
    $this->SetXY( $r1 + ($r2-$r1)/2 , $y1+160 );
    $this->Cell(10,5, utf8_decode("IMPORTE"), 0, 0, "L");

    $this->SetFont( "Arial", "B", 8);
    $this->SetXY( $r1 + ($r2-$r1)/2 , $y1+170 );
    $this->Cell(10,5, $totalaportee, 0, 0, "L");


    $this->SetFont( "Arial", "B", 8);
    $this->SetXY( $r1 + ($r2-$r1)/2 +58, $y1+164 );
    $this->Line( 100, $mid1, 140, $mid1);
    $this->Cell(5,5, utf8_decode("RECIBÍ CONFORME"), 0, 0, "R");

    $this->SetFont( "Arial", "B", 8);
    $this->SetXY( $r1 + ($r2-$r1)/2 + 28, $y1+188 );
    $this->Line( 100, 192, 140, 192);
    //$this->Cell(5,5, utf8_decode($nombrecomer), 0, 0, "C");
    $this->MultiCell(40, 3,utf8_decode($nombrecomer), 0,"B");
}



function fechaCastellano($fecha) {
  $fecha = substr($fecha, 0, 10);
  $numeroDia = date('d', strtotime($fecha));
  $dia = date('l', strtotime($fecha));
  $mes = date('F', strtotime($fecha));
  $anio = date('Y', strtotime($fecha));
  $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
  $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
  $nombredia = str_replace($dias_EN, $dias_ES, $dia);
  $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
  $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
  $nombreMes = str_replace($meses_EN, $meses_ES, $mes);


  return $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio;
}


// Simple table
function BasicTable($header, $data)
{
    // Header
    foreach($header as $col)
        $this->Cell(40,7,$col,1);
    $this->Ln();
    // Data
    foreach($data as $row)
    {
        foreach($row as $col)
            $this->Cell(40,6,$col,1);
        $this->Ln();
    }
}

function numBoleta2( $num, $ruc )
{
    $r1  = $this->w - 80;
    $r2  = $r1 + 70;
    $y1  = 160;
    $y2  = 17 ;
    $mid = $y1 + ($y2 / 2);
    $this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
    //$this->Line( $r1, $mid, $r2, $mid);
    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+1 );
    $this->SetFont( "Arial", "B", 11);
    $this->Cell(10,5, utf8_decode("R.U.C. ").$ruc, 0, 0, "C");

    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+6 );
    $this->SetFont( "Arial", "B", 11);
    $this->Cell(10,5, utf8_decode("BOLETA ELECTRÓNICA"), 0, 0, "C");

    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+11 );
    $this->SetFont( "Arial", "B", 11);
    $this->Cell(10,5,$num, 0,0, "C");

      $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+17 );
    $this->SetFont( "Arial", "b", 8);
    $this->Cell(10,5,"COPIA 2", 0,0, "C");

}


function datosEmpresa2( $num )
{
    $r1  = $this->w - 80;
    $r2  = $r1 + 70;
    $y1  = 6;
    $y2  = 20 ;
    $mid = $y1 + ($y2 / 2);
    $this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
    //$this->Line( $r1, $mid, $r2, $mid);
    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+1 );
    $this->SetFont( "Arial", "B", 11);
    $this->Cell(10,5, "RUC 20100088917", 0, 0, "C");

    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+6 );
    $this->SetFont( "Arial", "B", 11);
    $this->Cell(10,5, "FACTURA ELECTRONICA", 0, 0, "C");

    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+11 );
    $this->SetFont( "Arial", "B", 11);
    $this->Cell(10,5,$num, 0,0, "C");
}

function addDate2( $date )
{
    $r1  = $this->w - 61;
    $r2  = $r1 + 49;
    $y1  = 156;
    $y2  = 18 ;
    $mid = $y1 + ($y2 / 2);

    $this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
    $this->Line( $r1, $mid, $r2, $mid);
    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+3 );
    $this->SetFont( "Arial", "B", 11);
    $this->Cell(10,5, "Fecha", 0, 0, "C");
    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+9 );
    $this->SetFont( "Arial", "", 10);
    $this->Cell(10,5,$date, 0,0, "C");
}


 
 
 
 
function addClient( $ref )
{
    $r1  = $this->w - 31;
    $r2  = $r1 + 19;
    $y1  = 17;
    $y2  = $y1;
    $mid = $y1 + ($y2 / 2);
    $this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
    $this->Line( $r1, $mid, $r2, $mid);
    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+3 );
    $this->SetFont( "Arial", "B", 10);
    $this->Cell(10,5, "CLIENT", 0, 0, "C");
    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1 + 9 );
    $this->SetFont( "Arial", "", 10);
    $this->Cell(10,5,$ref, 0,0, "C");
}
 
function addPageNumber( $page )
{
    $r1  = $this->w - 80;
    $r2  = $r1 + 19;
    $y1  = 17;
    $y2  = $y1;
    $mid = $y1 + ($y2 / 2);
    $this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
    $this->Line( $r1, $mid, $r2, $mid);
    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+3 );
    $this->SetFont( "Arial", "B", 10);
    $this->Cell(10,5, "PAGE", 0, 0, "C");
    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1 + 9 );
    $this->SetFont( "Arial", "", 10);
    $this->Cell(10,5,$page, 0,0, "C");
}
 
// Client address
function addClientAdresse($fecha,$cliente,$domicilio,$num_documento,
    $estado,$usuario, $guia, $tipopago, $nroreferencia, $moneda)
{
    $r1     = $this->w - 200;
    $r2     = $r1 + 68;
    $y1     = 26;


    $this->SetXY( $r1, $y1+2);
    $this->SetFont( "Arial", "", 7);
    $this->MultiCell( 60, 4, utf8_decode("Fecha      :  ").$fecha);

    $this->SetXY( $r1, $y1+6);
    $this->SetFont( "Arial", "", 7);
    $this->MultiCell( 150, 3,utf8_decode("Señor(es):  ").$cliente);

    $this->SetXY( $r1, $y1+10);
    $this->MultiCell( 150, 3, utf8_decode("Dirección :  ").$domicilio);

    $this->SetXY( $r1, $y1+14);
    $this->MultiCell( 150, 3, utf8_decode("RUC/DNI :  ").$num_documento);

    $this->SetXY( $r1, $y1+25);
    $this->MultiCell( 150, 3, utf8_decode("Atención:  ").$usuario);

    $this->SetXY( 50, $y1+25);
    $this->MultiCell( 150, 3, utf8_decode("Tipo de pago: ").$tipopago);

    $this->SetXY( 100, $y1+25);
    $this->MultiCell( 150, 3, utf8_decode("Nro referencia: ").$nroreferencia);
    
    $st="";
    if($estado==3){
        $st="Anulado";
        }elseif($estado==1){
        $st="Emitido";
        }elseif($estado==0){
        $st="Con Nota ";
    }
    else
    {
            $st="Cancelado";
    }

    $this->SetXY( $r1, $y1+18);
    $this->MultiCell( 150, 3, utf8_decode("Estado:  ").$st);

    $this->SetXY( 145, $y1+25);
    $this->MultiCell( 150, 3, utf8_decode("Moneda: ").$moneda);

    $this->SetXY( 170, $y1+25);
    $this->MultiCell( 150, 3, utf8_decode("N. Guia: ").$guia);

    //$this->SetXY( $r1, $y1+22);
    //$this->MultiCell( 150, 3, $esatdo);
}
 

 // Client address
function addClientAdresse2($fecha,$cliente,$domicilio,$num_documento,
    $estado,$usuario, $guia, $tipopago, $nroreferencia, $moneda)
{
    $r1     = $this->w - 200; //eje x
    $r2     = $r1 + 68;
    $y1     = 170; // Edicion


    $this->SetXY( $r1, $y1+2);
    $this->SetFont( "Arial", "", 8);
    $this->MultiCell( 60, 4, utf8_decode("Fecha      :  ").$fecha);

    $this->SetXY( $r1, $y1+6);
    $this->SetFont( "Arial", "", 8);
    $this->MultiCell( 150, 3,utf8_decode("Señor(es):  ").$cliente);

    $this->SetXY( $r1, $y1+10);
    $this->MultiCell( 150, 3, utf8_decode("Dirección :  ").$domicilio);

    $this->SetXY( $r1, $y1+14);
    $this->MultiCell( 150, 3, utf8_decode("RUC/DNI :  ").$num_documento);

    $this->SetXY( $r1, $y1+27);
    $this->MultiCell( 150, 3, utf8_decode("Atención:  ").$usuario);

    $this->SetXY( 50, $y1+27);
    $this->MultiCell( 150, 3, utf8_decode("Tipo de pago: ").$tipopago);

    $this->SetXY( 100, $y1+27);
    $this->MultiCell( 150, 3, utf8_decode("Nro referencia: ").$nroreferencia);
    
    $st="";
    if($estado==3){
        $st="Anulado";
        }elseif($estado==1){
        $st="Emitido";
        }elseif($estado==0){
        $st="Con Nota ";
    }
    else
    {
            $st="Cancelado";
    }

    $this->SetXY( $r1, $y1+18);
    $this->MultiCell( 150, 3, utf8_decode("Estado:  ").$st);

    $this->SetXY( 145, $y1+27);
    $this->MultiCell( 150, 3, utf8_decode("Moneda: ").$moneda);

    $this->SetXY( 170, $y1+27);
    $this->MultiCell( 150, 3, utf8_decode("N. Guia: ").$guia);

}


// Mode of payment
function addReglement( $mode )
{
    $r1  = 10;
    $r2  = $r1 + 60;
    $y1  = 80;
    $y2  = $y1+10;
    $mid = $y1 + (($y2-$y1) / 2);
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
    $this->Line( $r1, $mid, $r2, $mid);
    $this->SetXY( $r1 + ($r2-$r1)/2 -5 , $y1+1 );
    $this->SetFont( "Arial", "B", 10);
    $this->Cell(10,4, "CLIENTE", 0, 0, "C");
    $this->SetXY( $r1 + ($r2-$r1)/2 -5 , $y1 + 5 );
    $this->SetFont( "Arial", "", 10);
    $this->Cell(10,5,$mode, 0,0, "C");
}
 
// Expiry date
function addEcheance( $documento,$numero )
{
    $r1  = 80;
    $r2  = $r1 + 40;
    $y1  = 80;
    $y2  = $y1+10;
    $mid = $y1 + (($y2-$y1) / 2);
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
    $this->Line( $r1, $mid, $r2, $mid);
    $this->SetXY( $r1 + ($r2 - $r1)/2 - 5 , $y1+1 );
    $this->SetFont( "Arial", "B", 10);
    $this->Cell(10,4, $numero, 0, 0, "C");
    $this->SetXY( $r1 + ($r2-$r1)/2 - 5 , $y1 + 5 );
    $this->SetFont( "Arial", "", 10);
    $this->Cell(10,5,$numero, 0,0, "C");
}
 
// VAT number
function addNumTVA($tva)
{
    $this->SetFont( "Arial", "B", 10);
    $r1  = $this->w - 80;
    $r2  = $r1 + 70;
    $y1  = 80;
    $y2  = $y1+10;
    $mid = $y1 + (($y2-$y1) / 2);
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
    $this->Line( $r1, $mid, $r2, $mid);
    $this->SetXY( $r1 + 16 , $y1+1 );
    $this->Cell(40, 4, "DIRECCIÓN", '', '', "C");
    $this->SetFont( "Arial", "", 10);
    $this->SetXY( $r1 + 16 , $y1+5 );
    $this->Cell(40, 5, $tva, '', '', "C");
}
 
function addReference($ref)
{
    $this->SetFont( "Arial", "", 10);
    $length = $this->GetStringWidth( "Références : " . $ref );
    $r1  = 10;
    $r2  = $r1 + $length;
    $y1  = 92;
    $y2  = $y1+5;
    $this->SetXY( $r1 , $y1 );
    $this->Cell($length,4, "Références : " . $ref);
}
 
function addCols( $tab )
{
    global $colonnes;
     
    $r1  = 10;
    $r2  = $this->w - ($r1 * 2) ;
    $y1  = 54;
    $y2  = $this->h - 186 - $y1; // + reduce el largo del cuadro
    $this->SetXY( $r1, $y1 );
    $this->Rect( $r1, $y1, $r2, $y2, "D");
    $this->Line( $r1, $y1+6, $r1+$r2, $y1+6);
    $colX = $r1;
    $colonnes = $tab;
    while ( list( $lib, $pos ) = each ($tab) )
    {
        $this->SetXY( $colX, $y1+2 );
        $this->Cell( $pos, 1, $lib, 0, 0, "C");
        $colX += $pos;
        $this->Line( $colX, $y1, $colX, $y1+$y2);
    }
}

function addCols2( $tab )
{
    global $colonnes;
     
    $r1  = 10;
    $r2  = $this->w - ($r1 * 2) ;
    $y1  = 200;
    $y2  = $this->h - 40 - $y1;
    $this->SetXY( $r1, $y1 );
    $this->Rect( $r1, $y1, $r2, $y2, "D");
    $this->Line( $r1, $y1+6, $r1+$r2, $y1+6);
    $colX = $r1;
    $colonnes = $tab;
    while ( list( $lib, $pos ) = each ($tab) )
    {
        $this->SetXY( $colX, $y1+2 );
        $this->Cell( $pos, 1, $lib, 0, 0, "C");
        $colX += $pos;
        $this->Line( $colX, $y1, $colX, $y1+$y2);
    }
} 
 
function addLineFormat( $tab )
{
    global $format, $colonnes;
     
    while ( list( $lib, $pos ) = each ($colonnes) )
    {
        if ( isset( $tab["$lib"] ) )
            $format[ $lib ] = $tab["$lib"];
    }
}

function addLineFormat2( $tab )
{
    global $format, $colonnes;
     
    while ( list( $lib, $pos ) = each ($colonnes) )
    {
        if ( isset( $tab["$lib"] ) )
            $format[ $lib ] = $tab["$lib"];
    }
}
 
function lineVert( $tab )
{
    global $colonnes;
 
    reset( $colonnes );
    $maxSize=0;
    while ( list( $lib, $pos ) = each ($colonnes) )
    {
        $texte = $tab[ $lib ];
        $longCell  = $pos -2;
        $size = $this->sizeOfText( $texte, $longCell );
        if ($size > $maxSize)
            $maxSize = $size;
    }
    return $maxSize;
}
 
// add a line to the invoice/estimate
/*    $ligne = array( "REFERENCE"    => $prod["ref"],
                      "DESIGNATION"  => $libelle,
                      "QUANTITE"     => sprintf( "%.2F", $prod["qte"]) ,
                      "P.U. HT"      => sprintf( "%.2F", $prod["px_unit"]),
                      "MONTANT H.T." => sprintf ( "%.2F", $prod["qte"] * $prod["px_unit"]) ,
                      "TVA"          => $prod["tva"] );
*/
function addLine( $ligne, $tab )
{
    global $colonnes, $format;
 
    $ordonnee     = 10;
    $maxSize      = $ligne;
 
    reset( $colonnes );
    while ( list( $lib, $pos ) = each ($colonnes) )
    {
        $longCell  = $pos -2;
        $texte     = $tab[ $lib ];
        $length    = $this->GetStringWidth( $texte );
        $tailleTexte = $this->sizeOfText( $texte, $length );
        $formText  = $format[ $lib ];
        $this->SetXY( $ordonnee, $ligne-1);
        $this->MultiCell( $longCell, 4 , $texte, 0, $formText);
        if ( $maxSize < ($this->GetY()  ) )
            $maxSize = $this->GetY() ;
        $ordonnee += $pos;
    }
    return ( $maxSize - $ligne );
}

function addLine2( $ligne, $tab )
{
    global $colonnes, $format;
 
    $ordonnee     = 10;
    $maxSize      = $ligne;
 
    reset( $colonnes );
    while ( list( $lib, $pos ) = each ($colonnes) )
    {
        $longCell  = $pos -2;
        $texte     = $tab[ $lib ];
        $length    = $this->GetStringWidth( $texte );
        $tailleTexte = $this->sizeOfText( $texte, $length );
        $formText  = $format[ $lib ];
        $this->SetXY( $ordonnee, $ligne-1);
        $this->MultiCell( $longCell, 4 , $texte, 0, $formText);
        if ( $maxSize < ($this->GetY()  ) )
            $maxSize = $this->GetY() ;
        $ordonnee += $pos;
    }
    return ( $maxSize - $ligne );
}

 
function addRemarque($remarque)
{
    $this->SetFont( "Arial", "", 10);
    $length = $this->GetStringWidth( "Remarque : " . $remarque );
    $r1  = 10;
    $r2  = $r1 + $length;
    $y1  = $this->h - 45.5;
    $y2  = $y1+5;
    $this->SetXY( $r1 , $y1 );
    $this->Cell($length,4, "Remarque : " . $remarque);
}
 
function addCadreTVAs($monto, $viewmon)
{
    $this->SetFont( "Arial", "B", 7);
    $r1  = 10;
    $r2  = $r1 + 120;
    $y1  = $this->h - 185;
    $y2  = $y1+5;
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');

    $this->SetXY( $r1+9, $y1+1);
    $this->Cell(10,3, "IMPORTE TOTAL: ");
    
    $this->SetFont( "Arial", "", 7);
    $this->SetXY( $r1+35, $y1+1);
    $this->MultiCell(100,3, $monto.$viewmon);

    

}

function observSunat($nro, $std, $hs, $webconsul, $nresolucion)
{
            if ($std=='5') {
        $esta='aceptada';
    }
    elseif ($std=='3') 
    {
        $esta='anulada';
    }
     elseif ($std=='1') 
    {
        $esta='emitida';
    }
    else
    {
        $esta='observada';
    }
    
    $this->SetFont( "Arial", "B", 8);
    $r1  = 10;
    $r2  = $r1 + 120;
    $y1  = $this->h - 179;
    $y2  = $y1+16;
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');

     $this->SetFont( "Arial", "", 8);
    $this->SetXY( $r1+2, $y1+3);
    $this->MultiCell(120,4, utf8_decode("La Boleta número, ").$nro." ha sido ".$esta.".");

    $this->SetFont( "Arial", "", 7);
    $this->SetXY( $r1+2, $y1+7);
    $this->MultiCell(116,3, utf8_decode("Autorizado a ser emisor electrónico mediante ".$nresolucion."  Representación impresa de la boleta electrónica. Puede verificar su clave SOL. Código de seguridad(Hash): ".trim($hs). "     Consulte su comprobante en ". $webconsul));

    $this->SetFont( "Arial", "", 7);
    //$this->SetTextColor(255,192,203);
    $this->SetXY( $r1+2, $y1+16);
    $this->MultiCell(116,3, utf8_decode("Transcurridos 7 días de recibida la mercadería, no se aceptarán cambios ni devoluciones."));
}



function observSunat2($nro, $std, $hs, $webconsul, $nresolucion)
{
    if ($std=='5') {
        $esta='aceptada';
    }
    elseif ($std=='3') 
    {
        $esta='anulada';
    }
     elseif ($std=='1') 
    {
        $esta='emitida';
    }
    else
    {
        $esta='observada';
    }

    $this->SetFont( "Arial", "B", 8);
    $r1  = 10;
    $r2  = $r1 + 120;
    $y1  = $this->h - 33;//Modificar
    $y2  = $y1+16;
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');

    $this->SetFont( "Arial", "", 8);
    $this->SetXY( $r1+2, $y1+3);
    $this->MultiCell(120,4, utf8_decode("La Boleta número, ").$nro." ha sido ".$esta.".");

    $this->SetFont( "Arial", "", 7);
    $this->SetXY( $r1+2, $y1+7);
    $this->MultiCell(116,3, utf8_decode("Autorizado a ser emisor electrónico mediante ".$nresolucion."  Representación impresa de la boleta electrónica. Puede verificar su clave SOL. Código de seguridad(Hash): ".trim($hs). "     Consulte su comprobante en ". $webconsul));

    $this->SetFont( "Arial", "", 7);
    //$this->SetTextColor(255,192,203);
    $this->SetXY( $r1+2, $y1+16);
    $this->MultiCell(116,3, utf8_decode("Transcurridos 7 días de recibida la mercadería, no se aceptarán cambios ni devoluciones."));

}

function addCadreTVAs2($monto, $viewmon)
{
    $this->SetFont( "Arial", "B", 8);
    $r1  = 10;
    $r2  = $r1 + 120;
    $y1  = $this->h - 39;
    $y2  = $y1+5;
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');

    $this->SetXY( $r1+9, $y1+1);
    $this->Cell(10,3, "IMPORTE TOTAL: ");
    
    $this->SetFont( "Arial", "", 8);
    $this->SetXY( $r1+35, $y1+1);
    $this->MultiCell(100,3, $monto.$viewmon);
 
}
 
function addCadreEurosFrancs()
{
    $r1  = $this->w - 70;
    $r2  = $r1 + 60;
    $y1  = $this->h - 185;
    $y2  = $y1+22; //Altura
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
    $this->Line( $r1+35,  $y1, $r1+35, $y2); // avant EUROS

    $this->SetFont( "Arial", "B", 8);
    $this->SetXY( $r1+32, $y1 );
    $this->Cell(30,4, "TOTALES", 0, 0, "C");
    
    $this->SetFont( "Arial", "B", 8);
    $this->SetXY( $r1, $y1+5 );
    $this->Cell(35,4, "Total descuento. ", 0, 0, "C");

    $this->SetFont( "Arial", "B", 8);
    $this->SetXY( $r1, $y1+10 );
    $this->Cell(35,4, "ICBPER. ", 0, 0, "C");

    $this->SetFont( "Arial", "B", 8);
    $this->SetXY( $r1, $y1+15 );
    $this->Cell(35,4, "Total ", 0, 0, "C");

    // $this->SetFont( "Arial", "B", 8);
    // $this->SetXY( $r1, $y1+15 );
    // $this->Cell(35,4, "Importe pagado S/", 0, 0, "C");

    // $this->SetFont( "Arial", "B", 8);
    // $this->SetXY( $r1, $y1+20 );
    // $this->Cell(35,4, "Saldo/vuelto S/", 0, 0, "C");
}

function addCadreEurosFrancs2()
{
    $r1  = $this->w - 70;
    $r2  = $r1 + 60;
    $y1  = $this->h - 39;
    $y2  = $y1+22; //Altura
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
    $this->Line( $r1+35,  $y1, $r1+35, $y2); // avant EUROS

    $this->SetFont( "Arial", "B", 8);
    $this->SetXY( $r1+32, $y1 );
    $this->Cell(30,4, "TOTALES", 0, 0, "C");

     $this->SetFont( "Arial", "B", 8);
    $this->SetXY( $r1, $y1+5 );
    $this->Cell(35,4, "Total descuento. ", 0, 0, "C");

    $this->SetFont( "Arial", "B", 8);
    $this->SetXY( $r1, $y1+10 );
    $this->Cell(35,4, "ICBPER. ", 0, 0, "C");

    $this->SetFont( "Arial", "B", 8);
    $this->SetXY( $r1, $y1+15 );
    $this->Cell(35,4, "Total ", 0, 0, "C");

    // $this->SetFont( "Arial", "B", 8);
    // $this->SetXY( $r1, $y1+15 );
    // $this->Cell(35,4, "Importe pagado S/", 0, 0, "C");

    // $this->SetFont( "Arial", "B", 8);
    // $this->SetXY( $r1, $y1+20 );
    // $this->Cell(35,4, "Saldo/vuelto S/", 0, 0, "C");
}



 
// remplit les cadres TVA / Totaux et la remarque
// params  = array( "RemiseGlobale" => [0|1],
//                      "remise_tva"     => [1|2...],  // {la remise s'applique sur ce code TVA}
//                      "remise"         => value,     // {montant de la remise}
//                      "remise_percent" => percent,   // {pourcentage de remise sur ce montant de TVA}
//                  "FraisPort"     => [0|1],
//                      "portTTC"        => value,     // montant des frais de ports TTC
//                                                     // par defaut la TVA = 19.6 %
//                      "portHT"         => value,     // montant des frais de ports HT
//                      "portTVA"        => tva_value, // valeur de la TVA a appliquer sur le montant HT
//                  "AccompteExige" => [0|1],
//                      "accompte"         => value    // montant de l'acompte (TTC)
//                      "accompte_percent" => percent  // pourcentage d'acompte (TTC)
//                  "Remarque" => "texte"              // texte
// tab_tva = array( "1"       => 19.6,
//                  "2"       => 5.5, ... );
// invoice = array( "px_unit" => value,
//                  "qte"     => qte,
//                  "tva"     => code_tva );
function addTVAs($total, $moneda, $tdescuento, $ipagado, $saldo, $icbper )
{
    $this->SetFont('Arial','',8);
 
    $re  = $this->w - 30;
    $rf  = $this->w - 29;
    $y1  = $this->h - 185;

    $this->SetFont( "Arial", "B", 10);
    $this->SetXY( $re, $y1+5 );
    $this->Cell( 14,4, number_format($tdescuento,2), '', '', 'R');

    $this->SetFont( "Arial", "B", 10);
    $this->SetXY( $re, $y1+10 );
    $this->Cell( 14,4, number_format($icbper,2), '', '', 'R');

    $this->SetFont( "Arial", "B", 10);
    $this->SetXY( $re, $y1+15 );
    $this->Cell( 14,4, number_format($total,2), '', '', 'R');

    // $this->SetXY( $re, $y1+15 );
    // //$this->Cell( 17,4, $moneda.sprintf("%0.2F", $total), '', '', 'R');
    // $this->Cell( 14,4, number_format($ipagado,2), '', '', 'R');

    // $this->SetXY( $re, $y1+20 );
    // //$this->Cell( 17,4, $moneda.sprintf("%0.2F", $total), '', '', 'R');
    // $this->Cell( 14,4, number_format($saldo,2), '', '', 'R');
     
}

function addTVAs2($total, $moneda, $tdescuento, $ipagado, $saldo , $icbper )
{
    $this->SetFont('Arial','',8);
 
    $re  = $this->w - 30;
    $rf  = $this->w - 29;
    $y1  = $this->h - 39;
    $this->SetFont( "Arial", "B", 10);
    

     $this->SetFont( "Arial", "B", 10);
    $this->SetXY( $re, $y1+5 );
    $this->Cell( 14,4, number_format($tdescuento,2), '', '', 'R');

    $this->SetFont( "Arial", "B", 10);
    $this->SetXY( $re, $y1+10 );
    $this->Cell( 14,4, number_format($icbper,2), '', '', 'R');

    $this->SetFont( "Arial", "B", 10);
    $this->SetXY( $re, $y1+15 );
    $this->Cell( 14,4, number_format($total,2), '', '', 'R');

    // $this->SetXY( $re, $y1+15 );
    // //$this->Cell( 17,4, $moneda.sprintf("%0.2F", $total), '', '', 'R');
    // $this->Cell( 14,4, number_format($ipagado,2), '', '', 'R');

    // $this->SetXY( $re, $y1+20 );
    // //$this->Cell( 17,4, $moneda.sprintf("%0.2F", $total), '', '', 'R');
    // $this->Cell( 14,4, number_format($saldo,2), '', '', 'R');

     
}
 
// add a watermark (temporary estimate, DUPLICATA...)
// call this method first
function temporaire( $texte )
{
    $this->SetFont('Arial','B',50);
    $this->SetTextColor(203,203,203);
    $this->Rotate(45,55,190);
    $this->Text(55,190,$texte);
    $this->Rotate(0);
    $this->SetTextColor(0,0,0);
}

function RotatedText($st, $x, $y, $txt, $angle)
{

    if ($st=='3' || $st=='0') {
    $this->SetFont('Arial','B',50);
    $this->SetTextColor(255,192,203);
    $this->Rotate($angle,$x,$y);
    $this->Text($x,$y,$txt);
    $this->Rotate(0);
    }
    
}

 
}
?>