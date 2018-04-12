<?php 
App::import('Vendor','xtcpdf');  
$pdf = new XTCPDF(); 
$textfont = 'freesans'; // looks better, finer, and more condensed than 'dejavusans' 


// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('SARL LEPITAPHE');
$pdf->SetTitle($property['Order']['reference']);
$pdf->SetSubject($property['Order']['reference']);

$pdf->xheadercolor = array(255, 255, 255);

// set header and footer fonts

$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', '', 10);

// add a page
$pdf->AddPage();

// set cell padding
$pdf->setCellPaddings(1, 1, 1, 1);

// set cell margins
$pdf->setCellMargins(1, 1, 1, 1);

// set color for background
$pdf->SetFillColor(255, 255, 255);	

// MultiCell($w, $h, $txt, $border=0, $align='J', $fill=0, $ln=1, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=0)


$pdf->Image('http://scanepitaphe.fr/app/webroot/img/logopdf.png',0, 0, 100, 18, 'PNG', '', '', false, 150, 'C', false, false, 1, false, false, false);
$pdf->Ln(20);
// Multicell test
$pdf->MultiCell(55, 45, 'SARL LEPITAPHE'."\n".'12 avenue du plateau des Glières'."\n".'86000 POITIERS'."\n".'FRANCE'."\n".'Tel. 06.59.79.71.58'."\n"."\n"."\n".'Facture : '.$property['Order']['reference'], 1, 'L', 0, 0, '', '', true);
$pdf->MultiCell(55, 45, $property['Order']['created'], 0, 'C', 0, 0, '', '', true);
// $pdf->MultiCell(55, 5, '[RIGHT] '.$txt, 1, 'R', 0, 1, '', '', true);
// $pdf->MultiCell(55, 5, '[CENTER] '.$txt, 1, 'C', 0, 0, '', '', true);
// $pdf->MultiCell(55, 5, '[JUSTIFY] '.$txt."\n", 1, 'J', 1, 2, '' ,'', true);
$pdf->MultiCell(0, 45, $property['Order']['uname'].' '.$property['Order']['ufirstname']."\n".$property['Order']['ustreet']."\n".$property['Order']['uzipcode'].' '.$property['Order']['ucity']."\n".'Tel : '.$property['Order']['uphone']."\n"."\n".'Adresse de livraison :'."\n".$property['Order']['dname'].' '.$property['Order']['dfirstname']."\n".$property['Order']['dstreet']."\n".$property['Order']['dzipcode'].' '.$property['Order']['dcity']."\n".'Tel : '.$property['Order']['dphone'], 1, 'L', 0, 1, '', '', true);



$pdf->Ln(40);

$pdf->MultiCell(110, 45, $property['Order']['listproduct'], 1, 'L', 0, 0, '', '', true);
// $pdf->MultiCell(50, 45, $property['Order']['color'], 1, 'L', 0, 0, '', '', true);
// $pdf->MultiCell(100, 40, $property['Order']['listproduct'], $border=1, $align='L', $fill=0, $ln=2, $x='', $y='', $reseth=true, $stretch=0, $ishtml=false, $autopadding=true, $maxh=40);
$pdf->MultiCell(0, 45, $property['Order']['listprice'], 1, 'L', 0, 1, '', '', true);
$pdf->MultiCell(110, 45, '', 0, 'L', 0, 0, '', '', true);
$pdf->MultiCell(0, 45, 'Livraison : '.$property['Order']['livraison'].'€'."\n".'TVA : '.$property['Order']['tva'].'€'."\n".'TTC : '.$property['Order']['ttc'].'€', 1, 'L', 0, 1, '', '', true);




$pdf->Ln(4);

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -

// set color for background




// - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -


// CUSTOM PADDING

// set color for background


// set font
$pdf->SetFont('helvetica', '', 8);

// set cell padding
$pdf->setCellPaddings(2, 4, 6, 8);



// move pointer to last page
$pdf->lastPage();




// ... 
// etc. 
// see the TCPDF examples 
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
$dir = new Folder();
$dir->create(IMAGES.'orders'.DS.'order_'.$property['Order']['cleref'],0777);
// echo $pdf->Output(IMAGES.'orders'.DS.'order_'.$property['Order']['cleref'].DS.$property['Order']['reference'].'.pdf', 'F');

echo $pdf->Output($property['Order']['reference'].'.pdf', 'D');


// move_uploaded_file($tcpdf->Output($property['Order']['reference'].'.pdf', 'F'), IMAGES.'orders'.DS.'user_'.$property['Order']['user_id'].DS.'order_'.$def['Order']['reference'].'.pdf'
//                 );

// echo $tcpdf->Output($property['Order']['reference'].'.pdf', 'D'); 

?>