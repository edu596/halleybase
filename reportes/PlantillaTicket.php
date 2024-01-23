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
 var $hh;


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
function addSocietenombre($nom, $tlibre, $logo,$ext_logo)
{
    $x1 = 4;
    $y1 = 13;
    $this->Image($logo , 20 , 2, 16 , 14 , $ext_logo); // (x,y, ancho, alto)
    $this->SetXY( $x1, $y1 + 4 );
    $this->SetFont('Courier','B',11);
    $length = $this->GetStringWidth($nom);
    $this->Cell( $length, 2, $nom, 'C');

    $this->SetXY( $x1, $y1 + 8 );
    $this->SetFont('Courier','B',7);
    $length = $this->GetStringWidth($tlibre);
    $this->Cell( $length, 1, $tlibre, 'C');
}


// Company
function addSociete($telefono, $email, $direccion)
{
    $x1 = 4;
    $y1 = 20;
    //Positionnement en bas
    
    //$this->Image($logo , 10 , 15, 25 , 13 , $ext_logo); // (x,y, ancho, alto)
    $this->SetXY( $x1, $y1 );
    $this->SetFont('Courier','',7);
    
    $this->SetXY( $x1, $y1 + 4 );
    $this->MultiCell(100, 3, $telefono);

    $this->SetXY( $x1, $y1 + 7 );
    $this->MultiCell(100, 3, $email);

    $this->SetXY( $x1, $y1 + 10);
    $this->MultiCell(50, 3, $direccion,'','L');
}


function numBoleta( $num , $ruc)
{
    $r1  = $this->w - 45;
    $r2  = $r1 + 35;
    $y1  = 38;
    $y2  = 14;
    //$mid = $y1 + ($y2 / 2);
    //$this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
    //$this->Line( $r1, $mid, $r2, $mid);
    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1 );
    $this->SetFont( "Courier", "B", 8);
    $this->Cell(10,1, utf8_decode("R.U.C. ").$ruc, 0, 0, "C");

    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+4 );
    $this->SetFont( "Courier", "B", 10);
    $this->Cell(10,1, utf8_decode("BOLETA ELECTRÓNICA"), 0, 0, "C");

    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+8 );
    $this->SetFont( "Courier", "B", 10);
    $this->Cell(10,1,$num, 0,0, "C");
    
}


function numfactura( $num , $ruc)
{
    $r1  = $this->w - 45;
    $r2  = $r1 + 35;
    $y1  = 38;
    $y2  = 14;
    //$mid = $y1 + ($y2 / 2);
    //$this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
    //$this->Line( $r1, $mid, $r2, $mid);
    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1 );
    $this->SetFont( "Courier", "B", 8);
    $this->Cell(10,1, utf8_decode("R.U.C. ").$ruc, 0, 0, "C");

    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+4 );
    $this->SetFont( "Courier", "B", 10);
    $this->Cell(10,1, utf8_decode("FACTURA ELECTRÓNICA"), 0, 0, "C");

    $this->SetXY( $r1 + ($r2-$r1)/2 - 5, $y1+8 );
    $this->SetFont( "Courier", "B", 10);
    $this->Cell(10,1,$num, 0,0, "C");
    
}





function addClientAdresse($fecha,$cliente,$domicilio,$num_documento,
    $estado,$usuario, $guia, $tipopago, $nroreferencia, $moneda)
{
    $r1     = $this->w - 55;
    $r2     = $r1 + 20;
    $y1     = 48;

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



    $this->SetXY( $r1, $y1+2);
    $this->SetFont( "Courier", "", 7);

    $this->MultiCell( 60, 4, utf8_decode("Fecha:  ").$fecha);

    $this->SetXY( $r1, $y1+5);
    $this->SetFont( "Courier", "", 7);
    $this->MultiCell( 150, 3,utf8_decode("Señor(es):  ").$cliente);

    $this->SetXY( $r1, $y1+9);
    $this->MultiCell( 150, 3, utf8_decode("Dirección :  ").$domicilio);

    $this->SetXY( $r1, $y1+13);
    $this->MultiCell( 150, 3, utf8_decode("RUC/DNI:  ").$num_documento);

    $this->SetXY( $r1, $y1+16);
    $this->MultiCell( 150, 3, utf8_decode("Estado:  ").$st);

    $this->SetXY( $r1, $y1+19);
    $this->MultiCell( 150, 3, utf8_decode("Moneda: ").$moneda);

    $this->SetXY( $r1, $y1+22);
    $this->MultiCell( 150, 3, utf8_decode("N. Guia: ").$guia);

    $this->SetXY( $r1, $y1+25);
    $this->MultiCell( 150, 3, utf8_decode("Atención:  ").$usuario);

    $this->SetXY( $r1, $y1+28);
    $this->MultiCell( 150, 3, utf8_decode("Tipo de pago: ").$tipopago);
    
}

function addClientAdresseFactura($fecha,$cliente,$domicilio,$num_documento,
    $estado,$usuario, $guia, $tipopago, $letraCuota, $moneda, $montocuota, $feccuota)
{
    $r1     = $this->w - 55;
    $r2     = $r1 + 20;
    $y1     = 48;

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


    $this->SetXY( $r1, $y1+2);
    $this->SetFont( "Courier", "", 7);
    $this->MultiCell( 60, 4, utf8_decode("Fecha:  ").$fecha);

    $this->SetXY( $r1, $y1+5);
    $this->SetFont( "Courier", "", 7);
    $this->MultiCell( 150, 3,utf8_decode("Señor(es):  ").$cliente);

    $this->SetXY( $r1, $y1+9);
    $this->MultiCell( 150, 3, utf8_decode("Dirección :  ").$domicilio);

    $this->SetXY( $r1, $y1+13);
    $this->MultiCell( 150, 3, utf8_decode("RUC/DNI:  ").$num_documento);

    $this->SetXY( $r1, $y1+16);
    $this->MultiCell( 150, 3, utf8_decode("Estado:  ").$st);

    $this->SetXY( $r1, $y1+19);
    $this->MultiCell( 150, 3, utf8_decode("Moneda: ").$moneda);

    $this->SetXY( $r1, $y1+22);
    $this->MultiCell( 150, 3, utf8_decode("N. Guia: ").$guia);

    $this->SetXY( $r1, $y1+25);
    $this->MultiCell( 150, 3, utf8_decode("Atención:  ").$usuario);

    $this->SetXY( $r1, $y1+28);
    $this->MultiCell( 150, 3, utf8_decode("Tipo de pago: ").$tipopago);
    
}


function addCols($tab, $nveces)
{
    global $colonnes;
    global $hh;
    $hh=270 - (12*$nveces);

    $r1  = 2;
    $r2  = $this->w - ($r1 *2) ;
    $y1  = 80; //poSICION Y
    $y2  = $this->h - $hh - $y1; // + reduce el largo del cuadro
     //$this->RoundedRect($r1, $y1, ($r2 - $r1), $y2, 3.5, 'D');
    $this->SetFont( "Courier", "B", 5);

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


function addCadreEurosFrancs($total, $subtotal, $tdescuento, $ipagado, $saldo, $icbper, $nveces)
{
    
    $hh=270 - (12.4*$nveces);
    $r1  =  2;
    $r2  = $r1 + 54;
    $y1  = $this->h - $hh;
    $y2  = $y1+5; //Altura

    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 1, 'D');
    $this->Line( $r1+40,  $y1, $r1+40, $y2); // avant EUROS

    $this->SetFont( "Courier", "B", 8);
    $this->SetXY( $r1 + 5, $y1 );
    $this->Cell(35,4, "TOTAL ", 0, 0, "R");

    $this->SetFont( "Courier", "", 8);
    $this->SetXY( $r1 + 40, $y1 );
    $this->Cell( 14,4, number_format($total,2), '', '', 'C');
}



function addCadreEurosFrancsFactura($total, $subtotal, $tdescuento, $ipagado, $saldo, $icbper, $nveces)
{
    
    $hh=270 - (12.4*$nveces);
    $r1  =  2;
    $r2  = $r1 + 54;
    $y1  = $this->h - $hh;
    $y2  = $y1+12; //Altura

    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 1, 'D');
    $this->Line( $r1+38,  $y1, $r1+38, $y2); // avant EUROS

    $this->SetFont( "Courier", "B", 8);
    $this->SetXY( $r1, $y1 );
    $this->Cell(35,4, "SUBTOTAL:", 0, 0, "R");
    
    
    $this->SetXY( $r1, $y1+3 );
    $this->Cell(35,4, "IGV", 0, 0, "R");

    
    // $this->SetXY( $r1 + 5, $y1+6 );
    // $this->Cell(35,4, "ICBPER. ", 0, 0, "R");

    
    $this->SetXY( $r1, $y1 + 6 );
    $this->Cell(35,4, "TOTAL:", 0, 0, "R");


    // $this->SetFont( "Courier", "", 6);
    // $this->SetXY( $r1 + 40, $y1 );
    // $this->Cell( 14,4, number_format($subtotal,2), '', '', 'C');

    // $this->SetXY( $r1 + 40, $y1+3 );
    // $this->Cell( 14,4, number_format($tdescuento,2), '', '', 'C');
    
    // $this->SetXY( $r1 + 40, $y1+6 );
    // $this->Cell( 14,4, number_format($icbper,2), '', '', 'C');

    $this->SetFont( "Courier", "", 8);
    $this->SetXY( $r1 + 40, $y1 );
    $this->Cell( 14,4, number_format($subtotal,2), '', '', 'C');

    $this->SetXY( $r1 + 40, $y1 + 3 );
    $this->Cell( 14,4, number_format($total - $subtotal,2), '', '', 'C');

    $this->SetXY( $r1 + 40, $y1 + 6);
    $this->Cell( 14,4, number_format($total,2), '', '', 'C');
}


function addCadreTVAsF($monto, $viewmon, $nveces)
{
    
    $hh=257 - (12.4*$nveces);
    $this->SetFont( "Courier", "B", 6);
    $r1  = 2;
    $r2  = $r1 + 54;
    $y1  = $this->h - $hh;
    $y2  = $y1+6;
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 1, 'D');

    $this->SetXY( $r1, $y1);
    $this->Cell(10,3, "IMPORTE TOTAL: ");
    
    $this->SetFont( "Courier", "", 6);
    $this->SetXY( $r1, $y1+3);
    $this->MultiCell(50,3, $monto.$viewmon);
}


function observSunatF($nro, $std, $hs, $webconsul, $nresolucion, $nveces)
{
    $hh=250 - (12.4*$nveces);
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
    
    $this->SetFont( "Courier", "B", 6);
    $r1  = 2;
    $r2  = $r1 + 54;
    $y1  = $this->h - $hh; //Posicion Y
    $y2  = $y1+20; //Alto cuadro
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 1, 'D');

    $this->SetFont( "Courier", "", 6);
    $this->SetXY( $r1+2, $y1);
    $this->MultiCell(50,4, utf8_decode("La Boleta número, ").$nro." ha sido ".$esta.".");

    $this->SetFont( "Courier", "", 6);
    $this->SetXY( $r1+2, $y1+3);
    $this->MultiCell(50,2, utf8_decode("Autorizado a ser emisor electrónico mediante ".$nresolucion."  Representación impresa de la boleta electrónica. Puede verificar su clave SOL. Código de seguridad(Hash): ".trim($hs). " Consulte su comprobante en ". $webconsul));

    // $this->SetFont( "Courier", "", 6);
    // $this->SetXY( $r1+2, $y1+9);
    // $this->MultiCell(116,2, utf8_decode("No se acepta cambio ni devoluciones de dinero."));
}

function ImgQrF($logo,$ext_logo, $nveces )
{
    $hh=229 - (12.4*$nveces);
      $this->SetFont( "Courier", "B", 6);
    $r1  = 20;
    $r2  = $r1 + 50;
    $y1  = $this->h - $hh; //Posicion Y
    $y2  = $y1+20; //Alto cuadro
    //Positionnement en bas
    $this->Image($logo , $r1 , $y1 , 20 , 20 , $ext_logo);
    $this->SetFont( "Courier", "", 6);
    $this->SetXY( 5, $y1+20);
    $this->Cell(50,4, utf8_decode("::.GRACIAS POR SU COMPRA.::"),'','','C');
}



function addCadreTVAs($monto, $viewmon, $nveces)
{
    
    $hh=264 - (12.4*$nveces);
    $this->SetFont( "Courier", "B", 6);
    $r1  = 2;
    $r2  = $r1 + 54;
    $y1  = $this->h - $hh;
    $y2  = $y1+6;
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 1, 'D');

    $this->SetXY( $r1, $y1);
    $this->Cell(10,3, "IMPORTE TOTAL: ");
    
    $this->SetFont( "Courier", "", 6);
    $this->SetXY( $r1, $y1+3);
    $this->MultiCell(50,3, $monto.$viewmon);
}


function observSunat($nro, $std, $hs, $webconsul, $nresolucion, $nveces)
{
    $hh=257 - (12.4*$nveces);
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
    
    $this->SetFont( "Courier", "B", 6);
    $r1  = 2;
    $r2  = $r1 + 54;
    $y1  = $this->h - $hh; //Posicion Y
    $y2  = $y1+20; //Alto cuadro
    $this->RoundedRect($r1, $y1, ($r2 - $r1), ($y2-$y1), 1, 'D');

    $this->SetFont( "Courier", "", 6);
    $this->SetXY( $r1+2, $y1);
    $this->MultiCell(50,4, utf8_decode("La Boleta número, ").$nro." ha sido ".$esta.".");

    $this->SetFont( "Courier", "", 6);
    $this->SetXY( $r1+2, $y1+3);
    $this->MultiCell(50,2, utf8_decode("Autorizado a ser emisor electrónico mediante ".$nresolucion."  Representación impresa de la boleta electrónica. Puede verificar su clave SOL. Código de seguridad(Hash): ".trim($hs). " Consulte su comprobante en ". $webconsul));

    // $this->SetFont( "Courier", "", 6);
    // $this->SetXY( $r1+2, $y1+9);
    // $this->MultiCell(116,2, utf8_decode("No se acepta cambio ni devoluciones de dinero."));
}

function ImgQr($logo,$ext_logo, $nveces )
{
    $hh=236 - (12.4*$nveces);
      $this->SetFont( "Courier", "B", 6);
    $r1  = 20;
    $r2  = $r1 + 50;
    $y1  = $this->h - $hh; //Posicion Y
    $y2  = $y1+20; //Alto cuadro
    //Positionnement en bas
    $this->Image($logo , $r1 , $y1 , 20 , 20 , $ext_logo);
    $this->SetFont( "Courier", "", 6);
    $this->SetXY( 5, $y1+20);
    $this->Cell(50,4, utf8_decode("::.GRACIAS POR SU COMPRA.::"),'','','C');
}







function addLineFormat($tab)
{
    global $format, $colonnes;
    //$colonnes = $tab;
    while ( list( $lib, $pos ) = each ($colonnes) )
    {
        if ( isset( $tab["$lib"] ) )
            $format[ $lib ] = $tab["$lib"];
    }
}


function addLine($ligne, $tab )
{
    global $colonnes, $format;
    $ordonnee     = 1;
    $maxSize      = $ligne;
    reset( $colonnes );
    while ( list( $lib, $pos ) = each ($colonnes) )
    {
        $longCell  = $pos;
        $texte     = $tab[ $lib ];
        $length    = $this->GetStringWidth( $texte );
        $tailleTexte = $this->sizeOfText( $texte, $length );
        $formText  = $format[ $lib ];
        
        $this->SetFont( "Courier", "", 6);
        $this->SetXY( $ordonnee, $ligne-1);
        $this->MultiCell( $longCell, 2 , $texte, 0, $formText);
        if ( $maxSize < ($this->GetY()  ) )
            $maxSize = $this->GetY() ;
        $ordonnee += $pos;
    }
    return ( $maxSize - $ligne );
}


function addTVAs($total, $moneda, $tdescuento, $ipagado, $saldo, $icbper )
{
    $this->SetFont('Courier','',8);
 
    $re  = $this->w - 30;
    $rf  = $this->w - 29;
    $y1  = $this->h - 199;

    $this->SetFont( "Courier", "B", 6);
    $this->SetXY( $re, $y1+5 );
    $this->Cell( 14,4, number_format($tdescuento,2), '', '', 'R');

    $this->SetFont( "Courier", "B", 6);
    $this->SetXY( $re, $y1+10 );
    $this->Cell( 14,4, number_format($icbper,2), '', '', 'R');

    $this->SetFont( "Courier", "B", 6);
    $this->SetXY( $re, $y1+15 );
    $this->Cell( 14,4, number_format($total,2), '', '', 'R');

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

 
function addRemarque($remarque)
{
    $this->SetFont( "Courier", "", 10);
    $length = $this->GetStringWidth( "Remarque : " . $remarque );
    $r1  = 10;
    $r2  = $r1 + $length;
    $y1  = $this->h - 45.5;
    $y2  = $y1+5;
    $this->SetXY( $r1 , $y1 );
    $this->Cell($length,4, "Remarque : " . $remarque);
}
 




function temporaire( $texte )
{
    $this->SetFont('Courier','B',50);
    $this->SetTextColor(203,203,203);
    $this->Rotate(45,55,190);
    $this->Text(55,190,$texte);
    $this->Rotate(0);
    $this->SetTextColor(0,0,0);
}

function RotatedText($st, $x, $y, $txt, $angle)
{

    if ($st=='3' || $st=='0') {
    $this->SetFont('Courier','B',50);
    $this->SetTextColor(255,192,203);
    $this->Rotate($angle,$x,$y);
    $this->Text($x,$y,$txt);
    $this->Rotate(0);
    }
    
}

 
}
?>