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
 
// Company
function addSociete( $nom, $adresse,$logo,$ext_logo )
{
    $x1 = 35;
    $y1 = 8;
    //Positionnement en bas
    $this->Image($logo , 18 ,7, 16 , 16 , $ext_logo);
    $this->SetXY( $x1, $y1 );
    $this->SetFont('Arial','B',14);
    $length = $this->GetStringWidth( $nom );
    $this->Cell( $length, 2, $nom);
    $this->SetXY( $x1, $y1 + 4 );
    $this->SetFont('Arial','',8);
    $length = $this->GetStringWidth( $adresse );
    //Coordonnées de la société
    $lignes = $this->sizeOfText( $adresse, $length) ;
    $this->MultiCell($length, 4, $adresse);
}

function addSocieteNCD( $nom, $adresse,$logo,$ext_logo )
{
    $x1 = 10;
    $y1 = 8;
    
    $this->SetXY( $x1, $y1 );
    $this->SetFont('Arial','B',14);
    $length = $this->GetStringWidth( $nom );
    $this->Cell( $length, 2, $nom);
    $this->SetXY( $x1, $y1 + 4 );
    $this->SetFont('Arial','',8);
    $length = $this->GetStringWidth( $adresse );
    //Coordonnées de la société
    $lignes = $this->sizeOfText( $adresse, $length) ;
    $this->MultiCell($length, 4, $adresse);
}

function addSocieteNCD2( $nom, $adresse,$logo,$ext_logo )
{
     $x1 = 10;
    $y1 =155;
    //Positionnement en bas
    //$this->Image($logo , 18 ,150, 16 , 16 , $ext_logo);
    $this->SetXY( $x1, $y1 );
    $this->SetFont('Arial','B',14);
    $length = $this->GetStringWidth( $nom );
    $this->Cell( $length, 2, $nom);
    $this->SetXY( $x1, $y1 + 4 );
    $this->SetFont('Arial','',8);
    $length = $this->GetStringWidth( $adresse );
    //Coordonnées de la société
    $lignes = $this->sizeOfText( $adresse, $length) ;
    $this->MultiCell($length, 4, $adresse);
}

function ImgQr($logo, $ext_logo )
{
    $x1 = 155;
    $y1 = 40;
    //Positionnement en bas
    $this->Image($logo , 178 , 26 , 20 , 20 , $ext_logo);
    $this->Image($logo , 178 , 172 , 20 , 20 , $ext_logo);
    $this->SetXY( $x1, $y1);
    
}


function ImgQrComprobante($logo, $ext_logo )
{
     $x1 = 155;
    $y1 = 40;
    //Positionnement en bas
    $this->Image($logo , 178 , 26 , 20 , 20 , $ext_logo);
    $this->SetXY( $x1, $y1);
    
}


function ImgQr2($logo,$ext_logo )
{
     $x1 = 34;
    $y1 = 155;
    //Positionnement en bas
    $this->Image($logo , 178 , 26 , 20 , 20 , $ext_logo);
    $this->SetXY( $x1, $y1);
    // $this->SetFont('Arial','B',9);
    // $this->Cell( 0, 0, utf8_decode('Código QR'));
}

function addSociete2( $nom, $adresse,$logo,$ext_logo )
{
    $x1 = 35;
    $y1 =155;
    //Positionnement en bas
    $this->Image($logo , 18 ,154, 16 , 16 , $ext_logo);
    $this->SetXY( $x1, $y1 );
    $this->SetFont('Arial','B',14);
    $length = $this->GetStringWidth( $nom );
    $this->Cell( $length, 2, $nom);
    $this->SetXY( $x1, $y1 + 4 );
    $this->SetFont('Arial','',8);
    $length = $this->GetStringWidth( $adresse );
    //Coordonnées de la société
    $lignes = $this->sizeOfText( $adresse, $length) ;
    $this->MultiCell($length, 4, $adresse);
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

function numFactura( $num, $ruc )
{
    $r1  = $this->w - 80;
    $r2  = $r1 + 70;
    $y1  = 6;
    $y2  = 17 ;
    $mid = $y1 + ($y2 / 2);
    $this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
    //$this->Line( $r1, $mid, $r2, $mid);
    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+1 );
    $this->SetFont( "Arial", "B", 11);
    $this->Cell(10,5, utf8_decode("R.U.C. ").$ruc, 0, 0, "C");

    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+6 );
    $this->SetFont( "Arial", "B", 11);
    $this->Cell(10,5, utf8_decode("FACTURA ELECTRÓNICA"), 0, 0, "C");

    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+11 );
    $this->SetFont( "Arial", "B", 11);
    $this->Cell(10,5,$num, 0,0, "C");
}

function numComprobante( $num, $ruc, $tipodoc )
{
    $r1  = $this->w - 80;
    $r2  = $r1 + 70;
    $y1  = 6;
    $y2  = 17 ;
    $mid = $y1 + ($y2 / 2);
    $this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
    //$this->Line( $r1, $mid, $r2, $mid);
    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+1 );
    $this->SetFont( "Arial", "B", 11);
    $this->Cell(10,5, utf8_decode("R.U.C. ").$ruc, 0, 0, "C");

    if ($tipodoc=='01') {
    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+6 );
    $this->SetFont( "Arial", "B", 11);
    $this->Cell(10,5, utf8_decode("FACTURA ELECTRÓNICA"), 0, 0, "C");
    }elseif ($tipodoc=='03'){
    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+6 );
    $this->SetFont( "Arial", "B", 11);
    $this->Cell(10,5, utf8_decode("BOLETA ELECTRÓNICA"), 0, 0, "C");
    }elseif ($tipodoc='07') {
    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+6 );
    $this->SetFont( "Arial", "B", 11);
    $this->Cell(10,5, utf8_decode("NOTA DE CRÉDITO ELECTRÓNICA"), 0, 0, "C");
    }
    else{
    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+6 );
    $this->SetFont( "Arial", "B", 11);
    $this->Cell(10,5, utf8_decode("NOTA DE DÉBITO ELECTRÓNICA"), 0, 0, "C");
    }
    
    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+11 );
    $this->SetFont( "Arial", "B", 11);
    $this->Cell(10,5,$num, 0,0, "C");
}

function numFactura2( $num ,$ruc )
{
    $r1  = $this->w - 80;
    $r2  = $r1 + 70;
    $y1  = 152;
    $y2  = 17 ;
    $mid = $y1 + ($y2 / 2);
    $this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
    //$this->Line( $r1, $mid, $r2, $mid);
    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+1 );
    $this->SetFont( "Arial", "B", 11);
    $this->Cell(10,5, utf8_decode("R.U.C. ").$ruc, 0, 0, "C");

    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+6 );
    $this->SetFont( "Arial", "B", 11);
    $this->Cell(10,5, utf8_decode("FACTURA ELECTRÓNICA"), 0, 0, "C");

    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+11 );
    $this->SetFont( "Arial", "B", 11);
    $this->Cell(10,5,$num, 0,0, "C");
}

function numNotac( $num, $ruc )
{
    $r1  = $this->w - 80;
    $r2  = $r1 + 70;
    $y1  = 6;
    $y2  = 17 ;
    $mid = $y1 + ($y2 / 2);
    $this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
    //$this->Line( $r1, $mid, $r2, $mid);
    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+1 );
    $this->SetFont( "Arial", "B", 11);
    $this->Cell(10,5, utf8_decode("RUC N° ").$ruc, 0, 0, "C");

    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+6 );
    $this->SetFont( "Arial", "B", 11);
    $this->Cell(10,5, utf8_decode("NOTA DE CRÉDITO"), 0, 0, "C");

    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+11 );
    $this->SetFont( "Arial", "B", 11);
    $this->Cell(10,5,$num, 0,0, "C");
}

function numNotac2( $num, $ruc )
{
    $r1  = $this->w - 80;
    $r2  = $r1 + 70;
    $y1  = 153;
    $y2  = 17 ;
    $mid = $y1 + ($y2 / 2);
    $this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
    //$this->Line( $r1, $mid, $r2, $mid);
    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+1 );
    $this->SetFont( "Arial", "B", 11);
    $this->Cell(10,5, utf8_decode("RUC N° ").$ruc, 0, 0, "C");

    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+6 );
    $this->SetFont( "Arial", "B", 11);
    $this->Cell(10,5, utf8_decode("NOTA DE CRÉDITO"), 0, 0, "C");

    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+11 );
    $this->SetFont( "Arial", "B", 11);
    $this->Cell(10,5,$num, 0,0, "C");
}

function numNotad( $num, $ruc )
{
    $r1  = $this->w - 80;
    $r2  = $r1 + 70;
    $y1  = 6;
    $y2  = 17 ;
    $mid = $y1 + ($y2 / 2);
    $this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
    //$this->Line( $r1, $mid, $r2, $mid);
    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+1 );
    $this->SetFont( "Arial", "B", 11);
    $this->Cell(10,5, utf8_decode("RUC N° ").$ruc, 0, 0, "C");

    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+6 );
    $this->SetFont( "Arial", "B", 11);
    $this->Cell(10,5, utf8_decode("NOTA DE DÉBITO"), 0, 0, "C");

    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+11 );
    $this->SetFont( "Arial", "B", 11);
    $this->Cell(10,5,$num, 0,0, "C");
}

function numNotad2( $num, $ruc )
{
     $r1  = $this->w - 80;
    $r2  = $r1 + 70;
    $y1  = 153;
    $y2  = 17 ;
    $mid = $y1 + ($y2 / 2);
    $this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
    //$this->Line( $r1, $mid, $r2, $mid);
    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+1 );
    $this->SetFont( "Arial", "B", 11);
    $this->Cell(10,5, utf8_decode("RUC N° ").$ruc, 0, 0, "C");

    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+6 );
    $this->SetFont( "Arial", "B", 11);
    $this->Cell(10,5, utf8_decode("NOTA DE DÉBITO"), 0, 0, "C");

    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+11 );
    $this->SetFont( "Arial", "B", 11);
    $this->Cell(10,5,$num, 0,0, "C");
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
function addClientAdresse($fecha,$cliente,$num_documento,$domicilio,$estado,$usuario,$guia)
{
    $r1     = $this->w - 190;
    $r2     = $r1 + 68;
    $y1     = 24;


    $this->SetXY( $r1, $y1+2);
    $this->SetFont( "Arial", "", 8);
    $this->MultiCell( 60, 4, utf8_decode("Fecha         : ").$fecha);

    $this->SetXY( $r1, $y1+6);
    $this->SetFont( "Arial", "", 8);
    $this->MultiCell( 150, 3,utf8_decode("Señor(es)   : ").$cliente);

    $this->SetXY( $r1, $y1+10);
    $this->MultiCell( 150, 3, utf8_decode("RUC           : ").$num_documento);

    $this->SetXY( $r1, $y1+14);
    $this->MultiCell( 150, 3, utf8_decode("Dirección    : ").$domicilio);

    $this->SetXY( $r1, $y1+21);
    $this->MultiCell( 150, 3, utf8_decode("Vendedor    : ").$usuario);
    
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

    

    $this->SetXY( $r1, $y1+25);
    $this->MultiCell( 150, 3, utf8_decode("Estado        : ").$st);

    $this->SetXY( 150, $y1+25);
    $this->MultiCell( 150, 3, utf8_decode("N. Guia     : ").$guia);

    //$this->SetXY( $r1, $y1+22);
    //$this->MultiCell( 150, 3, $esatdo);
}
 

 // Client address
function addClientAdresse2($fecha,$cliente,$num_documento,$domicilio,$estado,$usuario,$guia)
{
    $r1     = $this->w - 190;
    $r2     = $r1 + 68;
    $y1     = 170;


    $this->SetXY( $r1, $y1+2);
    $this->SetFont( "Arial", "", 8);
    $this->MultiCell( 60, 4, utf8_decode("Fecha         : ").$fecha);

    $this->SetXY( $r1, $y1+6);
    $this->SetFont( "Arial", "", 8);
    $this->MultiCell( 150, 3,utf8_decode("Señor(es)   : ").$cliente);

    $this->SetXY( $r1, $y1+10);
    $this->MultiCell( 150, 3, utf8_decode("RUC           : ").$num_documento);

    $this->SetXY( $r1, $y1+14);
    $this->MultiCell( 150, 3, utf8_decode("Dirección    : ").$domicilio);

    $this->SetXY( $r1, $y1+21);
    $this->MultiCell( 150, 3, utf8_decode("Vendedor    : ").$usuario);
    
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

    $this->SetXY( $r1, $y1+25);
    $this->MultiCell( 150, 3, utf8_decode("Estado        : ").$st);
    
    $this->SetXY( 150, $y1+25);
    $this->MultiCell( 150, 3, utf8_decode("N. Guia     : ").$guia);

    //$this->SetXY( $r1, $y1+22);
    //$this->MultiCell( 150, 3, $esatdo);
}

function addClientAdresseNC($cliente,$domicilio,$fechanc,$numfac,$fecfactemi, $observacion, $vendedorsitio)
{
    $r1     = $this->w - 200;
    $r2     = $r1 + 68;
    $y1     = 24;


    $this->SetXY( $r1, $y1+2);
    $this->SetFont( "Arial", "", 7);
    $this->MultiCell( 150, 4, utf8_decode("Sr(es)        : ").$cliente);

    $this->SetXY( $r1, $y1+6);
    $this->SetFont( "Arial", "", 7);
    $this->MultiCell( 150, 3,utf8_decode("Direción     : ").$domicilio);

    $this->SetXY( $r1, $y1+10);
    $this->MultiCell( 150, 3, utf8_decode("F. emisión   : ").$fechanc);

    $this->SetXY( $r1, $y1+14);
    $this->MultiCell( 150, 3, utf8_decode("Por lo consiguiente : ").$observacion);

    $this->SetXY( $r1, $y1+17);
    $this->MultiCell( 150, 3, utf8_decode("Vendedor    : ").$vendedorsitio);


    $this->SetXY( 160, $y1+2);
    $this->MultiCell( 150, 3, utf8_decode("Documento que modifica"));

    $this->SetXY( 160, $y1+6);
    $this->MultiCell( 150, 3, utf8_decode("Factura nro    : ").$numfac);

    $this->SetXY( 160, $y1+10);
    $this->MultiCell( 150, 3, utf8_decode("Emisión de comp. que se modifica : ")."\n".$fecfactemi);
   
}

function addClientAdresseND($cliente,$domicilio,$fechanc,$numfac,$fecfactemi, $observacion, $vendedorsitio)
{
    $r1     = $this->w - 200;
    $r2     = $r1 + 68;
    $y1     = 24;


    $this->SetXY( $r1, $y1+2);
    $this->SetFont( "Arial", "", 7);
    $this->MultiCell( 150, 4, utf8_decode("Sr(es)     : ").$cliente);

    $this->SetXY( $r1, $y1+6);
    $this->SetFont( "Arial", "", 7);
    $this->MultiCell( 150, 3,utf8_decode("Direción   : ").$domicilio);

    $this->SetXY( $r1, $y1+10);
    $this->MultiCell( 150, 3, utf8_decode("F. emisión  : ").$fechanc);

    $this->SetXY( $r1, $y1+14);
    $this->MultiCell( 150, 3, utf8_decode("Por lo consiguiente : ").$observacion);

    $this->SetXY( $r1, $y1+17);
    $this->MultiCell( 150, 3, utf8_decode("Vendedor : ").$vendedorsitio);


    $this->SetXY( 160, $y1+2);
    $this->MultiCell( 150, 3, utf8_decode("Documento que modifica"));

    $this->SetXY( 160, $y1+6);
    $this->MultiCell( 150, 3, utf8_decode("Factura nro    : ").$numfac);

    $this->SetXY( 160, $y1+10);
    $this->MultiCell( 150, 3, utf8_decode("Emisión de comp. que se modifica : ")."\n".$fecfactemi);
   
}

function addClientAdresseNC2($cliente,$domicilio,$fechanc,$numfac,$fecfactemi, $observacion, $vendedorsitio)
{
    $r1     = $this->w - 200;
    $r2     = $r1 + 68;
    $y1     = 172;


    $this->SetXY( $r1, $y1+2);
    $this->SetFont( "Arial", "", 7);
    $this->MultiCell( 150, 4, utf8_decode("Sr(es)        : ").$cliente);

    $this->SetXY( $r1, $y1+6);
    $this->SetFont( "Arial", "", 7);
    $this->MultiCell( 150, 3,utf8_decode("Direción     : ").$domicilio);

    $this->SetXY( $r1, $y1+10);
    $this->MultiCell( 150, 3, utf8_decode("F. emisión  : ").$fechanc);

    $this->SetXY( $r1, $y1+14);
    $this->MultiCell( 150, 3, utf8_decode("Por lo consiguiente : ").$observacion);

    $this->SetXY( $r1, $y1+17);
    $this->MultiCell( 150, 3, utf8_decode("Vendedor    : ").$vendedorsitio);


    $this->SetXY( 160, $y1+2);
    $this->MultiCell( 150, 3, utf8_decode("Documento que modifica"));

    $this->SetXY( 160, $y1+6);
    $this->MultiCell( 150, 3, utf8_decode("Factura nro    : ").$numfac);

    $this->SetXY( 160, $y1+10);
    $this->MultiCell( 150, 3, utf8_decode("Emisión de comp. que se modifica : ")."\n".$fecfactemi);
   
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
    $y2  = $this->h - 186 - $y1; // para el largo del cuadro del primer detalle
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

function addCols3( $tab )
{
    global $colonnes;
     
    $r1  = 10;
    $r2  = $this->w - ($r1 * 2) ;
    $y1  = 54;
    $y2  = $this->h - 43 - $y1; // para el largo del cuadro del primer detalle
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

function addColsComprobante( $tab )
{
    global $colonnes;
     
    $r1  = 10;
    $r2  = $this->w - ($r1 * 2) ;
    $y1  = 54;
    $y2  = $this->h - 186 - $y1; // para el largo del cuadro del segundo detalle
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
    $y2  = $this->h - 40 - $y1; // para el largo del cuadro del segundo detalle + -
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

function addColsNC( $tab )
{
    global $colonnes;
     
    $r1  = 10;
    $r2  = $this->w - ($r1 * 2) ;
    $y1  = 44;
    $y2  = $this->h - 200 - $y1; // para el largo del cuadro del segundo detalle
    $this->SetXY( $r1, $y1 );
    $this->Rect( $r1, $y1, $r2, $y2, "D");
    $this->Line( $r1, $y1+5, $r1+$r2, $y1+5);
    $colX = $r1;
    $colonnes = $tab;
    while ( list( $lib, $pos ) = each ($tab) )
    {
        $this->SetXY( $colX, $y1+2 );
        $this->Cell( $pos, 1, $lib, 0, 0, "C");
        $colX += $pos;
        $this->Line( $colX, $y1, $colX, $y1 + $y2);
    }
}

function addColsNC2( $tab )
{
    global $colonnes;
     
    $r1  = 10;
    $r2  = $this->w - ($r1 * 2) ;
    $y1  = 192;
    $y2  = $this->h - 45 - $y1; // para el largo del cuadro del segundo detalle
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

function addLine2NC( $ligne, $tab )
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
 
function addCadreTVAs($monto)
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
    $this->MultiCell(100,3, $monto);
}

function addCadreTVAsComprobante($monto)
{
    $this->SetFont( "Arial", "B", 9);
    $r1  = 10;
    $r2  = $r1 + 120;
    $y1  = $this->h - 185;
    $y2  = $y1+5;
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');

    $this->SetXY( $r1+9, $y1+1);
    $this->Cell(10,3, "IMPORTE TOTAL : ");
    
    $this->SetFont( "Arial", "", 7);
    $this->SetXY( $r1+37, $y1+1);
    $this->MultiCell(100,3, $monto);
}


function addCadreTVAsNC($monto)
{
    $this->SetFont( "Arial", "B", 7);
    $r1  = 10;
    $r2  = $r1 + 120;
    $y1  = $this->h - 199;
    $y2  = $y1+5;
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');

    $this->SetXY( $r1+9, $y1+1);
    $this->Cell(10,3, "IMPORTE TOTAL: ");
    
    $this->SetFont( "Arial", "", 7);
    $this->SetXY( $r1+35, $y1+1);
    $this->MultiCell(100,3, $monto);
}

function addCadreTVAsNC2($monto)
{
    $this->SetFont( "Arial", "B", 7);
    $r1  = 10;
    $r2  = $r1 + 120;
    $y1  = $this->h - 44;
    $y2  = $y1+5;
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');

    $this->SetXY( $r1+9, $y1+1);
    $this->Cell(10,3, "IMPORTE TOTAL: ");
    
    $this->SetFont( "Arial", "", 7);
    $this->SetXY( $r1+35, $y1+1);
    $this->MultiCell(100,3, $monto);
}



function addCadreTVAsND($monto)
{
    $this->SetFont( "Arial", "B", 7);
    $r1  = 10;
    $r2  = $r1 + 120;
    $y1  = $this->h - 208;
    $y2  = $y1+5;
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');

    $this->SetXY( $r1+9, $y1+1);
    $this->Cell(10,3, "IMPORTE ADICIONAL: ");
    
    $this->SetFont( "Arial", "", 7);
    $this->SetXY( $r1+35, $y1+1);
    $this->MultiCell(100,3, $monto);
}


function observSunat($nro, $std, $hs, $webconsul,  $nresolucion)
{
        if ($std=='5') { $esta='aceptada';
    }
    elseif ($std=='3') { $esta='anulada';
    }
     elseif ($std=='1') { $esta='emitida';
    }
    else { $esta='observada';
    }

    $this->SetFont( "Arial", "B", 8);
    $r1  = 10;
    $r2  = $r1 + 120;
    $y1  = $this->h - 179;
    $y2  = $y1+16;
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');

     $this->SetFont( "Arial", "", 8);
    $this->SetXY( $r1+2, $y1+3);
    $this->MultiCell(120,4, utf8_decode("La Factura número, ").$nro." ha sido ".$esta.".");

    $this->SetFont( "Arial", "", 7);
    $this->SetXY( $r1+2, $y1+7);
    $this->MultiCell(116,3, utf8_decode("Autorizado a ser emisor electrónico mediante ".$nresolucion."  Representación impresa de la factura electrónica. Puede verificar su clave SOL. Código de seguridad(Hash): ".trim($hs). "     Consulte su comprobante en ". $webconsul));

    $this->SetFont( "Arial", "", 7);
    //$this->SetTextColor(255,192,203);
    $this->SetXY( $r1+2, $y1+16);
    $this->MultiCell(116,3, utf8_decode("Transcurridos 7 días de recibida la mercadería, no se aceptarán cambios ni devoluciones."));
}

function observSunat2($nro, $std, $hs, $webconsul, $nresolucion)
{
        if ($std=='5') { $esta='aceptada';
    }
    elseif ($std=='3') { $esta='anulada';
    }
     elseif ($std=='1') { $esta='emitida';
    }
    else { $esta='observada';
    }

    $this->SetFont( "Arial", "B", 8);
    $r1  = 10;
    $r2  = $r1 + 120;
    $y1  = $this->h - 33; // alineacion del cuadro de observacion + eleva el cuadro - reduce la elevacion
    $y2  = $y1+16;
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');

    $this->SetFont( "Arial", "", 8);
    $this->SetXY( $r1+2, $y1+3);
    $this->MultiCell(120,4, utf8_decode("La Factura número, ").$nro." ha sido ".$esta.".");

    $this->SetFont( "Arial", "", 7);
    $this->SetXY( $r1+2, $y1+7);
    $this->MultiCell(116,3, utf8_decode("Autorizado a ser emisor electrónico mediante ".$nresolucion."  Representación impresa de la factura electrónica. Puede verificar su clave SOL. Código de seguridad(Hash): ".trim($hs). "     Consulte su comprobante en ". $webconsul));

    $this->SetFont( "Arial", "", 7);
    //$this->SetTextColor(255,192,203);
    $this->SetXY( $r1+2, $y1+16);
    $this->MultiCell(116,3, utf8_decode("Transcurridos 7 días de recibida la mercadería, no se aceptarán cambios ni devoluciones."));
}
    

    function observSunatComprobante($nro, $std, $hs, $tipodoc, $webconsul)
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

    switch ($tipodoc) {
        case '01':
            $comp="Factura";
            break;
            case '03':
            $comp="Boleta";
            break;
            case '07':
            $comp="Nota de crédito";
            break;
            case '08':
            $comp="Nota de débito";
            break;
        
        default:
            # code...
            break;
    }

    $this->SetFont( "Arial", "B", 8);
    $r1  = 10;
    $r2  = $r1 + 120;
    $y1  = $this->h - 179; // alineacion del cuadro de observacion
    $y2  = $y1+16;
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');

    $this->SetXY( $r1+2, $y1+1);
    $this->Cell(10,3, utf8_decode("Observación SUNAT: La ".utf8_decode($comp)." número, ".$nro." ha sido ".$esta."."));
    
    
    $this->SetFont( "Arial", "", 8);
    $this->SetXY( $r1+2, $y1+3);
    $this->MultiCell(120,4, utf8_decode("Incorporado al régimen de buenos contribuyentes: Res. Intendencia N° 0230050168945."));

   $this->SetFont( "Arial", "", 7);
    $this->SetXY( $r1+2, $y1+7);
    $this->MultiCell(116,3, utf8_decode("Autorizado a ser emisor electrónico mediante RS - 155-2017/SUNAT. Representación impresa de la ".$comp." electrónica. Puede verificar usando su clave SOL. Código de seguridad(Hash): ".trim($hs). "     Consulte su comprobante en ". $webconsul));

    $this->SetFont( "Arial", "", 7);
    $this->SetXY( $r1+2, $y1+16);
    $this->MultiCell(116,3, utf8_decode("Transcurridos 7 días de recibida la mercadería, no se aceptarán cambios ni devoluciones."));
}
    


function observSunatNC($nro, $std, $hs, $webconsul)
{
    if ($std=='5') { $esta='aceptada';
    }
    elseif ($std=='3') { $esta='anulada';
    }
     elseif ($std=='1') { $esta='emitida';
    }
    else { $esta='observada';
    }

    $this->SetFont( "Arial", "B", 7);
    $r1  = 10;
    $r2  = $r1 + 120;
    $y1  = $this->h - 193;
    $y2  = $y1+16;
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');

    $this->SetXY( $r1+2, $y1+1);
    $this->Cell(10,3, utf8_decode("Observación SUNAT: La Nota de crédito número, ".$nro." ha sido ".$esta."."));
    
     $this->SetFont( "Arial", "", 8);
    $this->SetXY( $r1+2, $y1+3);
    $this->MultiCell(120,4, utf8_decode("Incorporado al régimen de buenos contribuyentes: Res. Intendencia N° 0230050168945."));

    $this->SetFont( "Arial", "", 6);
    $this->SetXY( $r1+2, $y1+7);
    $this->MultiCell(100,3, utf8_decode("Autorizado a ser emisor electrónico mediante RS - 155-2017/SUNAT. Representación impresa de la factura electrónica. Puede verificar usando su clave SOL. Código de seguridad(Hash): ".trim($hs). "     Consulte su comprobante en ". $webconsul));
  $this->SetFont( "Arial", "", 7);
    //$this->SetTextColor(255,192,203);
    $this->SetXY( $r1+2, $y1+16);
    $this->MultiCell(116,3, utf8_decode("Transcurridos 7 días de recibida la mercadería, no se aceptarán cambios ni devoluciones."));
}


function observSunatNC2($nro, $std, $hs, $webconsul)
{
    if ($std=='5') { $esta='aceptada';
    }
    elseif ($std=='3') { $esta='anulada';
    }
     elseif ($std=='1') { $esta='emitida';
    }
    else { $esta='observada';
    }

    $this->SetFont( "Arial", "B", 7);
    $r1  = 10;
    $r2  = $r1 + 120;
    $y1  = $this->h - 38; // alineacion del cuadro de observacion
    $y2  = $y1+16;
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');

    $this->SetXY( $r1+2, $y1+1);
    $this->Cell(10,3, utf8_decode("Observación SUNAT: La Nota de crédito número, ".$nro." ha sido ".$esta."."));
    
     $this->SetFont( "Arial", "", 8);
    $this->SetXY( $r1+2, $y1+3);
    $this->MultiCell(120,4, utf8_decode("Incorporado al régimen de buenos contribuyentes: Res. Intendencia N° 0230050168945."));

    $this->SetFont( "Arial", "", 6);
    $this->SetXY( $r1+2, $y1+7);
    $this->MultiCell(100,3, utf8_decode("Autorizado a ser emisor electrónico mediante RS - 155-2017/SUNAT. Representación impresa de la factura electrónica. Puede verificar usando su clave SOL. Código de seguridad(Hash): ".trim($hs). "     Consulte su comprobante en ". $webconsul));
  $this->SetFont( "Arial", "", 7);
    //$this->SetTextColor(255,192,203);
    $this->SetXY( $r1+2, $y1+16);
    $this->MultiCell(116,3, utf8_decode("Transcurridos 7 días de recibida la mercadería, no se aceptarán cambios ni devoluciones."));
}


function observSunatND($nro, $std, $hs)
{
    $this->SetFont( "Arial", "B", 7);
    $r1  = 10;
    $r2  = $r1 + 120;
    $y1  = $this->h - 193;
    $y2  = $y1+16;
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');

    $this->SetXY( $r1+2, $y1+1);
    $this->Cell(10,3, utf8_decode("Observación SUNAT: "));
    
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

    $this->SetFont( "Arial", "B", 7);
    $this->SetXY( $r1+2, $y1+3);
    $this->MultiCell(100,5, utf8_decode("La Nota de débito Electrónica número ").$nro." a sido ".$esta.".");

    $this->SetFont( "Arial", "", 6);
    $this->SetXY( $r1+2, $y1+7);
    $this->MultiCell(100,3, utf8_decode("Autorizado a ser emisor electrónico mediante RS - 155-2017/SUNAT. Representación impresa de la factura electrónica. Puede verificar su clave SOL. Código de seguridad(Hash): ".trim($hs)));
}

function observSunatND2($nro, $std, $hs)
{
    $this->SetFont( "Arial", "B", 7);
    $r1  = 10;
    $r2  = $r1 + 120;
    $y1  = $this->h - 193;
    $y2  = $y1+16;
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');

    $this->SetXY( $r1+2, $y1+1);
    $this->Cell(10,3, utf8_decode("Observación SUNAT: "));
    
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

    $this->SetFont( "Arial", "B", 7);
    $this->SetXY( $r1+2, $y1+3);
    $this->MultiCell(100,5, utf8_decode("La Nota de débito Electrónica número ").$nro." a sido ".$esta.".");

    $this->SetFont( "Arial", "", 6);
    $this->SetXY( $r1+2, $y1+7);
    $this->MultiCell(100,3, utf8_decode("Autorizado a ser emisor electrónico mediante RS - 155-2017/SUNAT. Representación impresa de la factura electrónica. Puede verificar su clave SOL. Código de seguridad(Hash): ".trim($hs)));
}





function addCadreTVAs2($monto)
{
    $this->SetFont( "Arial", "B", 7);
    $r1  = 10;
    $r2  = $r1 + 120;
    $y1  = $this->h - 39; // alineacion de importe total el cuadro
    $y2  = $y1+5;
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');

    $this->SetXY( $r1+9, $y1+1);
    $this->Cell(10,3, "IMPORTE TOTAL: ");
    
    $this->SetFont( "Arial", "", 7);
    $this->SetXY( $r1+35, $y1+1);
    $this->MultiCell(100,3, $monto);
 
}
 
function addCadreEurosFrancs($impuesto)
{
    $r1  = $this->w - 70;
    $r2  = $r1 + 60;
    $y1  = $this->h - 185;
    $y2  = $y1+22;
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
    $this->Line( $r1+22,  $y1, $r1+22, $y2); // avant EUROS
    //$this->Line( $r1+20, $y1+4, $r2, $y1+4); // Sous Euros & Francs
    //$this->Line( $r1+38,  $y1, $r1+38, $y2); // Entre Euros & Francs
    $this->SetFont( "Arial", "B", 8);
    $this->SetXY( $r1+22, $y1 );
    $this->Cell(30,4, "TOTALES", 0, 0, "C");
    $this->SetFont( "Arial", "", 8);
    
    $this->SetFont( "Arial", "B", 6);
    $this->SetXY( $r1, $y1+5 );
    $this->Cell(20,4, "Op. Gravada S/", 0, 0, "C");
    $this->SetXY( $r1, $y1+10 );
    $this->Cell(20,4, "I.G.V. S/", 0, 0, "C");
    $this->SetXY( $r1, $y1+15 );
    $this->Cell(20,4, "IMPORTE TOTAL S/", 0, 0, "C");
}

function addComprobante($impuesto)
{
    $r1  = $this->w - 75;
    $r2  = $r1 + 65;
    $y1  = $this->h - 185;
    $y2  = $y1+22;
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
    $this->Line( $r1+22,  $y1, $r1+22, $y2); // avant EUROS
    //$this->Line( $r1+20, $y1+4, $r2, $y1+4); // Sous Euros & Francs
    //$this->Line( $r1+38,  $y1, $r1+38, $y2); // Entre Euros & Francs
    $this->SetFont( "Arial", "B", 9);
    $this->SetXY( $r1+22, $y1 );
    $this->Cell(30,4, "TOTALES S/", 0, 0, "C");
    $this->SetFont( "Arial", "", 8);
    
    $this->SetFont( "Arial", "B", 8);
    $this->SetXY( $r1, $y1+5 );
    $this->Cell(20,4, "Op. Gravada S/", 0, 0, "C");
    $this->SetXY( $r1, $y1+10 );
    $this->Cell(20,4, "I.G.V. S/", 0, 0, "C");
    $this->SetXY( $r1, $y1+15 );
    $this->Cell(20,4, "TOTAL S/", 0, 0, "C");
}

function addCadreEurosFrancsNC()
{
    $r1  = $this->w - 70;
    $r2  = $r1 + 60;
    $y1  = $this->h - 199;
    $y2  = $y1+22;
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
    $this->Line( $r1+22,  $y1, $r1+22, $y2); // avant EUROS
    
    $this->SetFont( "Arial", "B", 8);
    $this->SetXY( $r1+22, $y1 );
    $this->Cell(30,4, "TOTALES", 0, 0, "C");
    $this->SetFont( "Arial", "", 8);
    
    $this->SetFont( "Arial", "B", 6);
    $this->SetXY( $r1, $y1+5 );
    $this->Cell(20,4, "IMPORTE S/", 0, 0, "C");
    $this->SetXY( $r1, $y1+10 );
    $this->Cell(20,4, "I.G.V. S/", 0, 0, "C");
    $this->SetXY( $r1, $y1+15 );
    $this->Cell(20,4, "TOTAL S/", 0, 0, "C");
}

function addCadreEurosFrancsNC2()
{
   $r1  = $this->w - 70;
    $r2  = $r1 + 60;
    $y1  = $this->h - 44;
    $y2  = $y1+22;
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
    $this->Line( $r1+22,  $y1, $r1+22, $y2); // avant EUROS

    $this->SetFont( "Arial", "B", 8);
    $this->SetXY( $r1+22, $y1 );
    $this->Cell(30,4, "TOTALES", 0, 0, "C");

    $this->SetFont( "Arial", "", 8);
    $this->SetFont( "Arial", "B", 6);

    $this->SetXY( $r1, $y1+4 );
    $this->Cell(20,4, "Op. Gravada S/", 0, 0, "C");

    $this->SetXY( $r1, $y1+9 );
    $this->Cell(20,4, "I.G.V.", 0, 0, "C");

    $this->SetXY( $r1, $y1+14 );
    $this->Cell(20,4, "IMPORTE TOTAL S/", 0, 0, "C");
}

function addCadreEurosFrancsND($impuesto)
{
    $r1  = $this->w - 70;
    $r2  = $r1 + 60;
    $y1  = $this->h - 208;
    $y2  = $y1+22;
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
    $this->Line( $r1+20,  $y1, $r1+20, $y2); // avant EUROS
    //$this->Line( $r1+20, $y1+4, $r2, $y1+4); // Sous Euros & Francs
    //$this->Line( $r1+38,  $y1, $r1+38, $y2); // Entre Euros & Francs
    $this->SetFont( "Arial", "B", 8);
    $this->SetXY( $r1+22, $y1 );
    $this->Cell(30,4, "TOTALES", 0, 0, "C");
    $this->SetFont( "Arial", "", 8);
    
    $this->SetFont( "Arial", "B", 6);
    $this->SetXY( $r1, $y1+5 );
    $this->Cell(20,4, "Op. Gravada", 0, 0, "C");
    $this->SetXY( $r1, $y1+10 );
    $this->Cell(20,4, "I.G.V.", 0, 0, "C");
    $this->SetXY( $r1, $y1+15 );
    $this->Cell(20,4, "IMPORTE TOTAL", 0, 0, "C");
}


function addCadreEurosFrancs2($impuesto)
{
    $r1  = $this->w - 70;
    $r2  = $r1 + 60;
    $y1  = $this->h - 39;
    $y2  = $y1+22;
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 2.5, 'D');
    $this->Line( $r1+22,  $y1, $r1+22, $y2); // avant EUROS

    $this->SetFont( "Arial", "B", 8);
    $this->SetXY( $r1+22, $y1 );
    $this->Cell(30,4, "TOTALES", 0, 0, "C");

    $this->SetFont( "Arial", "", 8);
    $this->SetFont( "Arial", "B", 6);

    $this->SetXY( $r1, $y1+4 );
    $this->Cell(20,4, "Op. Gravada S/", 0, 0, "C");

    $this->SetXY( $r1, $y1+9 );
    $this->Cell(20,4, "I.G.V. S/", 0, 0, "C");

    $this->SetXY( $r1, $y1+14 );
    $this->Cell(20,4, "IMPORTE TOTAL S/", 0, 0, "C");
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
function addTVAs( $igv, $total, $moneda )
{
    $this->SetFont('Arial','',9);
 
    $re  = $this->w - 30;
    $rf  = $this->w - 29;
    $y1  = $this->h - 185;
    $this->SetFont( "Arial", "B", 10);
    $this->SetXY( $re, $y1+5 );
    //$this->Cell( 17,4, $moneda.sprintf("%0.2F", $total-($total*$igv/($igv+100))), '', '', 'R');
    $this->Cell( 17,4, number_format($total - $igv,2), '', '', 'R');
    //$this->Cell( 17,4, $total - $igv, '', '', 'R');

    //$this->Cell( 17,4, $moneda.sprintf("%0.2F", $total-($total*$igv/($igv+100))), '', '', 'R');

    $this->SetXY( $re, $y1+10 );
    //$this->Cell( 17,4, $moneda.sprintf("%0.2F", $igv), '', '', 'R');
    $this->Cell( 17,4, number_format($igv,2), '', '', 'R');

    // $this->Cell( 17,4, $moneda.sprintf("%0.2F", ($total*$igv/($igv+100))), '', '', 'R');

    $this->SetXY( $re, $y1+14.8 );
    //$this->Cell( 17,4, $moneda.sprintf("%0.2F", $total), '', '', 'R');
    $this->Cell( 17,4, number_format($total,2), '', '', 'R');
     
}

function addTVAsComprobante( $igv, $total, $moneda )
{
    $this->SetFont('Arial','',9);
 
    $re  = $this->w - 30;
    $rf  = $this->w - 29;
    $y1  = $this->h - 185;
    $this->SetFont( "Arial", "B", 9);
    $this->SetXY( $re, $y1+5 );
    //$this->Cell( 17,4, $moneda.sprintf("%0.2F", $total-($total*$igv/($igv+100))), '', '', 'R');
    $this->Cell( 17,4, number_format($total - $igv,2), '', '', 'R');

    //$this->Cell( 17,4, $moneda.sprintf("%0.2F", $total-($total*$igv/($igv+100))), '', '', 'R');

    $this->SetXY( $re, $y1+10 );
    $this->Cell( 17,4, number_format($igv,2), '', '', 'R');

    // $this->Cell( 17,4, $moneda.sprintf("%0.2F", ($total*$igv/($igv+100))), '', '', 'R');

    $this->SetXY( $re, $y1+14.8 );
    $this->Cell( 17,4, number_format($total,2), '', '', 'R');
     
}

function addTVAsNC( $igv, $total, $moneda )
{
    $this->SetFont('Arial','B',9);
 
    $re  = $this->w - 30;
    $rf  = $this->w - 29;
    $y1  = $this->h - 169;
    
    $this->SetXY( $re, $y1-25 );
    $this->Cell( 5,4, number_format($total - $igv,2), '', '', 'R');
    $this->SetXY( $re, $y1-20 );
    $this->Cell( 4,4, number_format($igv,2), '', '', 'R');
    $this->SetXY( $re, $y1-14 );
    $this->Cell( 5,4, number_format($total,2), '', '', 'R');
     
}

function addTVAsNC2( $igv, $total, $moneda )
{
     $this->SetFont('Arial','',8);
 
    $re  = $this->w - 30;
    $rf  = $this->w - 29;
    $y1  = $this->h - 44;
    $this->SetFont( "Arial", "B", 9);
    $this->SetXY( $re, $y1+5 );
    $this->Cell( 5,4, number_format($total - $igv,2), '', '', 'R');

    //$this->Cell( 17,4, $moneda.sprintf("%0.2F", $total-($total*$igv/($igv+100))), '', '', 'R');

    $this->SetXY( $re, $y1+10 );
    $this->Cell( 5,4, number_format($igv,2), '', '', 'R');

    // $this->Cell( 17,4, $moneda.sprintf("%0.2F", ($total*$igv/($igv+100))), '', '', 'R');

    $this->SetXY( $re, $y1+14.8 );
    $this->Cell( 5,4, number_format($total,2), '', '', 'R');
}

function addTVAsND($total, $moneda )
{
    $this->SetFont('Arial','',9);
 
    $re  = $this->w - 30;
    $rf  = $this->w - 29;
    $y1  = $this->h - 178;
    
    $this->SetXY( $re, $y1-25 );
    $this->Cell( 5,4, $moneda.sprintf("%0.2F", '0' ),'', '', 'R');
    $this->SetXY( $re, $y1-20 );
    $this->Cell( 5,4, $moneda.sprintf("%0.2F", '0' ),'', '', 'R');
    $this->SetXY( $re, $y1-14 );
    $this->Cell( 5,4, $moneda.sprintf("%0.2F", $total), '', '', 'R');
     
}

function addTVAs2( $igv, $total, $moneda )
{
    $this->SetFont('Arial','',8);
 
    $re  = $this->w - 30;
    $rf  = $this->w - 29;
    $y1  = $this->h - 39;
    $this->SetFont( "Arial", "B", 10);
    $this->SetXY( $re, $y1+5 );
    $this->Cell( 17,4, number_format($total - $igv,2), '', '', 'R');

    //$this->Cell( 17,4, $moneda.sprintf("%0.2F", $total-($total*$igv/($igv+100))), '', '', 'R');

    $this->SetXY( $re, $y1+10 );
    $this->Cell( 17,4, number_format($igv,2), '', '', 'R');

    // $this->Cell( 17,4, $moneda.sprintf("%0.2F", ($total*$igv/($igv+100))), '', '', 'R');

    $this->SetXY( $re, $y1+14.8 );
    $this->Cell( 17,4, number_format($total,2), '', '', 'R');
     
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