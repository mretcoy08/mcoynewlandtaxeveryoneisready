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

$pdf->setFillColor(0,0,0,0);
$pdf->addpage();
$pdf->deletePage(1);

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

$payor = $data_collection['first_name']." ".$data_collection['middle_name']." ".$data_collection['last_name'];
$basic = $data_record['due_basic'];
$sef = $data_record['due_sef'];
$penalty = $data_record['due_penalty'];
$discount = $data_record['due_discount'];


$pastpenalty = $data_record['past_penalty'];

$bank1 = $data_record['bank1'];
$number1 = $data_record['number1'];
$amount1 = $data_record['amount1'];
$date1 = $data_record['date1'];

$bank2 = $data_record['bank2'];
$number2 = $data_record['number2'];
$amount2 = $data_record['amount2'];
$date2 = $data_record['date2'];

$bank3 = $data_record['bank3'];
$number3 = $data_record['number3'];
$amount3 = $data_record['amount3'];
$date3 = $data_record['date3'];

$amount = $data_collection['total_payment'];

$numbertowords = $data_record['numbertowords'];


$min5 = 5;
$pdf->Text(55,50  , date('Y-m-d'));

$pdf->Text(17,58 , 'City Goverment of San Pablo');



$pdf->setCellPaddings(2, 4, 6, 8);
$txt = ($payor == null ? '0' : $payor);
$pdf->MultiCell(90, 50, $txt, 0, 'L', 1, 2, 16, 61, true);

$pdf->Text(7,81  - $min5, 'Basic');
$pdf->setCellPaddings(2, 4, 6, 8);
$txt =($basic == null ? '0' : $basic);
$pdf->MultiCell(40,7, $txt."\n", 0, 'R', 1, 1,60, 76, true, 0, false, true, 21, 'M', true);

$pdf->Text(7,87 - $min5 , 'S.E.F');
$pdf->setCellPaddings(2, 4, 6, 8);
$txt =($sef == null ? '0' : $sef);
$pdf->MultiCell(40,7, $txt."\n", 0, 'R', 1, 1,60, 82, true, 0, false, true, 21, 'M', true);



  $pdf->Text(7,92  - $min5, 'Past Penalty');
  $pdf->setCellPaddings(2, 4, 6, 8);
  $txt =($pastpenalty == null ? '0' : $pastpenalty);
  $pdf->MultiCell(40,7, $txt."\n", 0, 'R', 1, 1,60, 87, true, 0, false, true, 21, 'M', true);

 


 $pdf->Text(7,97 - $min5 , 'Penalty');
$pdf->setCellPaddings(2, 4, 6, 8);
$txt =($penalty == null ? '0' : $penalty);
$pdf->MultiCell(40,7, $txt."\n", 0, 'R', 1, 1,60, 92, true, 0, false, true, 21, 'M', true);




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
$txt = ($amount == null ? '0' : $amount);
$pdf->MultiCell(40,7, $txt."\n", 0, 'R', 1, 1,60, 119, true, 0, false, true, 21, 'M', true);

  
// $pdf->Text(7,$mode_payment == 'CASH' ? 139 : 145, 'x');


$pdf->setCellPaddings(2, 4, 6, 8);
$txt = ($numbertowords == null ? '0' : $numbertowords);
$pdf->MultiCell(60,20, $txt."\n", 0, 'L', 1, 1,35, 128, true, 0, false, true, 24, 'M', true);




  $pdf->Text(33, 144, $bank1);
  $pdf->Text(53, 144, $number1);
  $pdf->Text(72, 144, $date1);
  
  $pdf->Text(33, 148, $bank2);
  $pdf->Text(53, 148, $number2);
  $pdf->Text(72, 148, $date2);
  
  $pdf->Text(33, 152, $bank3);
  $pdf->Text(53, 152, $number3);
  $pdf->Text(72, 152, $date3);



$pdf->Text(42,161, 'ARJAN B. BABANI');
$pdf->Text(42,165 , 'CITY TREASURER');



ob_clean();
$pdf->IncludeJS("print();");
$pdf->Output('name.pdf', 'I');
exit;

  ?>