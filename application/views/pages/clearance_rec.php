<?php
use setasign\Fpdi\Fpdi;
require_once(APPPATH.'/../assets/pdfmerge/TCPDF-master/tcpdf.php');
require_once(APPPATH.'/../assets/pdfmerge/tcpdi/tcpdi.php');
// require_once(APPPATH.'/../assets/pdfmerge/tcpdf_include.php');
ob_start();
date_default_timezone_set('Asia/Manila');
$date = date('m - d - Y');
$pdf = new TCPDI(PDF_PAGE_ORIENTATION, 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setSourceFile(APPPATH.'/../assets/PDF/rec.pdf');
$tpl = $pdf->importPage(1);
$pdf->SetDisplayMode(100);
$size = $pdf->getTemplateSize($tpl);
$orientation = $size['h'] > $size['w'] ? 'P' : 'L';
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->addPage($orientation);
$pdf->useTemplate($tpl, null, null, 0, 0, TRUE);

// $ttl_amt_due = (int)$total_amnt_due; 
// $ttl_amt_due = (int)$total_permit_fee; 
// $tinplate = (int)$tinplate_fee;
// $verification = (int)$verification_fee;
// $sticker = (int)$sticker_fee;
// $service = (int)$service_license_fee;
// $total_permit = (int)$total_permit_fee;
// $seminar = (int)$seminar_fee;
// $occupation = (int)$occupation_fee;
// $Amt = (int)$Amount;


$clearance_fee = $clearance_fee;
$clearance_numbertowords = $clearance_numbertowords;





$min5 = 5;
$pdf->Text(55,50  , date('Y-m-d'));

$pdf->Text(17,58 , 'City Goverment of San Pablo');





$pdf->Text(7,86  - $min5, 'Clearance Fee: ');
$pdf->setCellPaddings(2, 4, 6, 8);
$txt =($clearance_fee == null ? '0' : $clearance_fee);
$pdf->MultiCell(40,7, $txt."\n", 1, 'R', 1, 1,60, 76, true, 0, false, true, 21, 'M', true);






// $pdf->Text(7,102  - $min5, 'Tinplate/Sticker/Verification');
// $pdf->setCellPaddings(2, 4, 6, 8);
// $txt = ($total_tin == null ? '0' : $total_tin);
// $pdf->MultiCell(40,7, $txt."\n", 1, 'R', 1, 1,60, 98, true, 0, false, true, 21, 'M', true);



// $pdf->Text(7,108  - $min5, 'Service Unit Fee');
// $pdf->setCellPaddings(2, 4, 6, 8);
// $txt = ($total_service == null ? '0' : $total_service);
// $pdf->MultiCell(40,7, $txt."\n", 1, 'R', 1, 1,60, 104, true, 0, false, true, 21, 'M', true);


// $pdf->Text(7,113 - $min5 , 'Surcharge & Penalties');
// $txt = ($total_chg == null ? '0' : $total_chg);
// // $txt = '0';
// $pdf->MultiCell(40,7, $txt."\n", 1, 'R', 1, 1,60, 108, true, 0, false, true, 21, 'M', true);


// $pdf->Text(7,118 - $min5 , 'Others');
// $pdf->setCellPaddings(2, 4, 6, 8);
// $txt = ($total_charge == null ? '0' : $total_charge);
// $pdf->MultiCell(40,7, $txt."\n", 1, 'R', 1, 1,60, 114, true, 0, false, true, 21, 'M', true);



$pdf->setCellPaddings(2, 4, 6, 8);
$txt = ($clearance_fee == null ? '0' : $clearance_fee);
$pdf->MultiCell(40,7, $txt."\n", 1, 'R', 1, 1,60, 119, true, 0, false, true, 21, 'M', true);

  
// $pdf->Text(7,$mode_payment == 'CASH' ? 139 : 145, 'x');


$pdf->setCellPaddings(2, 4, 6, 8);
$txt = ($clearance_numbertowords == null ? '0' : $clearance_numbertowords);
$pdf->MultiCell(58,20, $txt."\n", 0, 'L', 1, 1,35, 128, true, 0, false, true, 24, 'M', true);







$pdf->Text(42,161, 'ARJAN B. BABANI');
$pdf->Text(42,165 , 'CITY TREASURER');



ob_clean();
$pdf->Output('name.pdf', 'I');
exit;

  ?>