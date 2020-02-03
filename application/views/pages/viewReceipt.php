<?php
use setasign\Fpdi\Fpdi;
require_once(APPPATH.'/../assets/pdfmerge/TCPDF-master/tcpdf.php');
require_once(APPPATH.'/../assets/pdfmerge/tcpdi/tcpdi.php');
// require_once(APPPATH.'/../assets/pdfmerge/tcpdf_include.php');



ob_start();
date_default_timezone_set('Asia/Manila');
$date = date('m - d - Y');
$pdf = new TCPDI("L", 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setSourceFile(APPPATH.'/../assets/PDF/ortaxorder.pdf');


$tpl = $pdf->importPage(1);
$pdf->SetDisplayMode(100);
$size = $pdf->getTemplateSize($tpl);
$orientation = $size['h'] > $size['w'] ? 'W' : 'L';
// $pdf->setPrintHeader(false);
// $pdf->setPrintFooter(false);
$pdf->addPage($orientation);


// $pdf->Rotate(-90);
$pdf->useTemplate($tpl, null, null, 0, 0, TRUE);


$payor_name = $orData[0]->payor_name;
$payment = showMoney($orData[0]->due_total);

$ownerFullName = $orData[0]->ofull_name;
$location = $orData[0]->barangay;
$tax_dec_no = $orData[0]->tax_dec_no;
$av_land = showMoney($orData[0]->basic);
$av_total = showMoney($orData[0]->total);
$tax_due = showMoney($orData[0]->due_total);
$ipayment_no = $orData[0]->payment_no;
$ipayment = showMoney(Floatval($orData[0]->due_basic) * 2);
// $full_payment = Floatval($orData[0]->$due_basic) * 2;
$total_payment = showMoney($orData[0]->due_total);
$due_date = explode("/",$orData[0]->due_date);




 $penalty_percentage = 2 * Floatval(monthDiff($due_date[0],$due_date[2]));


$pdf->Text(45,41 , "Laguna");
$pdf->Text(125,41  , "San Pablo ");
$pdf->Text(225,41, date("m/d/Y"));
$pdf->Text(227,53, date("y"));



$pdf->setCellPaddings(2, 4, 6, 8);
$txt = ($payor_name == null ? "" : $payor_name);
$pdf->MultiCell(90, 41, $txt, 0, 'L', 1, 2, 70, 44, true);

$pdf->setCellPaddings(2, 4, 6, 8);
$txt = ($paymentwords == null ? "Five Thousand" : $paymentwords);
$pdf->MultiCell(70, 20, $txt, 0, 'L', 1, 2, 182, 44, true);

$pdf->setCellPaddings(2, 4, 6, 8);
$txt = ($payment == null ? "" : $payment);
$pdf->MultiCell(90, 41, $txt, 0, 'L', 1, 2, 258, 44, true);



$pdf->setCellPaddings(2, 4, 6, 8);
$txt = ($ownerFullName == null ? "" : $ownerFullName);
$pdf->MultiCell(40, 40, $txt, 0, 'L', 1, 2, 2, 78, true);

$pdf->setCellPaddings(2, 4, 6, 8);
$txt = ($location == null ? "" : $location);
$pdf->MultiCell(40, 40, $txt, 0, 'L', 1, 2, 35, 78, true);

$pdf->setCellPaddings(2, 4, 6, 8);
$txt = ($lot_no == null ? "" : $lot_no);
$pdf->MultiCell(40, 40, $txt, 0, 'L', 1, 2, 71, 78, true);

$pdf->setCellPaddings(2, 4, 6, 8);
$txt = ($tax_dec_no == null ? "88-12345" : $tax_dec_no);
$pdf->MultiCell(40, 40, $txt, 0, 'L', 1, 2, 91, 78, true);

$pdf->setCellPaddings(2, 4, 6, 8);
$txt = ($av_land == null ? "88-12345" : $av_land);
$pdf->MultiCell(40, 40, $txt, 0, 'L', 1, 2, 115, 78, true);

$pdf->setCellPaddings(2, 4, 6, 8);
$txt = ($av_improvement == null ? "" : $av_improvement);
$pdf->MultiCell(40, 40, $txt, 0, 'L', 1, 2, 135, 78, true);

$pdf->setCellPaddings(2, 4, 6, 8);
$txt = ($av_total == null ? "88-12345" : $av_total);
$pdf->MultiCell(40, 40, $txt, 0, 'L', 1, 2, 154, 78, true);

$pdf->setCellPaddings(2, 4, 6, 8);
$txt = ($tax_due == null ? "" : $tax_due);
$pdf->MultiCell(40, 40, $txt, 0, 'L', 1, 2, 176, 78, true);

if($mode_of_payment != "Annually")
{
  $pdf->setCellPaddings(2, 4, 6, 8);
  $txt = ($ipayment_no == null ? "5" : $ipayment_no);
  $pdf->MultiCell(40, 40, $txt, 0, 'L', 1, 2, 201, 78, true);

  $pdf->setCellPaddings(2, 4, 6, 8);
  $txt = ($ipayment == null ? "88-12345" : $ipayment);
  $pdf->MultiCell(40, 40, $txt, 0, 'L', 1, 2, 211, 78, true);
}
else{
  $pdf->setCellPaddings(2, 4, 6, 8);
  $txt = ($full_payment == null ? "88-12345" : $full_payment);
  $pdf->MultiCell(40, 40, $txt, 0, 'L', 1, 2, 231, 78, true);
}


if($penalty_percentage > 0)
{
  $pdf->setCellPaddings(2, 4, 6, 8);
$txt = ($penalty_percentage == null ? "" : $penalty_percentage);
$pdf->MultiCell(40, 40, $txt, 0, 'L', 1, 2, 255, 78, true);
}


$pdf->setCellPaddings(2, 4, 6, 8);
$txt = ($total_payment == null ? "88-12345" : $total_payment);
$pdf->MultiCell(40, 40, $txt, 0, 'L', 1, 2, 268, 78, true);
// $pdf->Text(7,81  - $min5, 'Basic');
// $pdf->setCellPaddings(2, 4, 6, 8);
// $txt =($basic == null ? '0' : $basic);
// $pdf->MultiCell(40,7, $txt."\n", 1, 'R', 1, 1,60, 76, true, 0, false, true, 21, 'M', true);

// $pdf->Text(7,87 - $min5 , 'S.E.F');
// $pdf->setCellPaddings(2, 4, 6, 8);
// $txt =($sef == null ? '0' : $sef);
// $pdf->MultiCell(40,7, $txt."\n", 1, 'R', 1, 1,60, 82, true, 0, false, true, 21, 'M', true);



//   $pdf->Text(7,92  - $min5, 'Past Penalty');
//   $pdf->setCellPaddings(2, 4, 6, 8);
//   $txt =($pastPenalty == null ? '0' : $pastPenalty);
//   $pdf->MultiCell(40,7, $txt."\n", 1, 'R', 1, 1,60, 87, true, 0, false, true, 21, 'M', true);

 


//  $pdf->Text(7,97 - $min5 , 'Penalty');
// $pdf->setCellPaddings(2, 4, 6, 8);
// $txt =($penalty == null ? '0' : $penalty);
// $pdf->MultiCell(40,7, $txt."\n", 1, 'R', 1, 1,60, 92, true, 0, false, true, 21, 'M', true);




// // $pdf->Text(7,102  - $min5, 'Tinplate/Sticker/Verification');
// // $pdf->setCellPaddings(2, 4, 6, 8);
// // $txt = ($total_tin == null ? '0' : $total_tin);
// // $pdf->MultiCell(40,7, $txt."\n", 1, 'R', 1, 1,60, 98, true, 0, false, true, 21, 'M', true);



// // $pdf->Text(7,108  - $min5, 'Service Unit Fee');
// // $pdf->setCellPaddings(2, 4, 6, 8);
// // $txt = ($total_service == null ? '0' : $total_service);
// // $pdf->MultiCell(40,7, $txt."\n", 1, 'R', 1, 1,60, 104, true, 0, false, true, 21, 'M', true);


// // $pdf->Text(7,113 - $min5 , 'Surcharge & Penalties');
// // $txt = ($total_chg == null ? '0' : $total_chg);
// // // $txt = '0';
// // $pdf->MultiCell(40,7, $txt."\n", 1, 'R', 1, 1,60, 108, true, 0, false, true, 21, 'M', true);


// // $pdf->Text(7,118 - $min5 , 'Others');
// // $pdf->setCellPaddings(2, 4, 6, 8);
// // $txt = ($total_charge == null ? '0' : $total_charge);
// // $pdf->MultiCell(40,7, $txt."\n", 1, 'R', 1, 1,60, 114, true, 0, false, true, 21, 'M', true);



// $pdf->setCellPaddings(2, 4, 6, 8);
// $txt = ($amount == null ? '0' : $amount);
// $pdf->MultiCell(40,7, $txt."\n", 1, 'R', 1, 1,60, 119, true, 0, false, true, 21, 'M', true);

  
// // $pdf->Text(7,$mode_payment == 'CASH' ? 139 : 145, 'x');


// $pdf->setCellPaddings(2, 4, 6, 8);
// $txt = ($numbertowords == null ? '0' : $numbertowords);
// $pdf->MultiCell(60,20, $txt."\n", 0, 'L', 1, 1,35, 128, true, 0, false, true, 24, 'M', true);




//   $pdf->Text(33, 144, $bank1);
//   $pdf->Text(53, 144, $number1);
//   $pdf->Text(72, 144, $date1);
  
//   $pdf->Text(33, 148, $bank2);
//   $pdf->Text(53, 148, $number2);
//   $pdf->Text(72, 148, $date2);
  
//   $pdf->Text(33, 152, $bank3);
//   $pdf->Text(53, 152, $number3);
//   $pdf->Text(72, 152, $date3);



// $pdf->Text(42,161, 'ARJAN B. BABANI');
// $pdf->Text(42,165 , 'CITY TREASURER');



ob_clean();

$pdf->Output('name.pdf', 'I');
exit;

  ?>