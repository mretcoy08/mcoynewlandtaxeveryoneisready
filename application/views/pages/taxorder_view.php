<?php
use setasign\Fpdi\Fpdi;
require_once(APPPATH.'/../assets/pdfmerge/TCPDF-master/tcpdf.php');
require_once(APPPATH.'/../assets/pdfmerge/tcpdi/tcpdi.php');
// require_once(APPPATH.'/../assets/pdfmerge/tcpdf_include.php');
ob_start();
date_default_timezone_set('Asia/Manila');
$date = date('m - d - Y');
$pdf = new TCPDI(PDF_PAGE_ORIENTATION, 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setSourceFile(APPPATH.'/../assets/PDF/tax_order_of_payment.pdf');
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





$full_name = $ownerLocation['full_name'];
$location = $ownerLocation['barangay'];
$tax_dec_no = $ownerLocation['tax_dec_no'];

$assessed_value1 = $assessed_value[0][0]? showMoney($assessed_value[0][0]) : "";
$assessed_value2 = $assessed_value[1][0]? showMoney($assessed_value[1][0]) : "";
$assessed_value3 = $assessed_value[2][0]? showMoney($assessed_value[2][0]) : "";
$assessed_value4 = $assessed_value[3][0]? showMoney($assessed_value[3][0]) : "";
$assessed_value5 = $assessed_value[4][0]? showMoney($assessed_value[4][0]) : "";
$assessed_value6 = $assessed_value[5][0]? showMoney($assessed_value[5][0]) : "";

$year1 = $year[0][0];
$year2 = $year[1][0];
$year3 = $year[2][0];
$year4 = $year[3][0];
$year5 = $year[4][0];
$year6 = $year[5][0];

$upbasic = $upbasic[0][100] + $upbasic[0][101] + $upbasic[0][102];


$uppenalty = $uppenalty[0][100] + $uppenalty[0][101] + $uppenalty[0][102];


$uptotal = $uptotal[0][100] + $uptotal[0][101] + $uptotal[0][102];




$basic1 = $basic[0][0]? showMoney($basic[0][0]) : "";
$basic2 = $basic[1][0]? showMoney($basic[1][0]) : "";
$basic3 = $basic[2][0]? showMoney($basic[2][0]) : "";
$basic4 = $basic[3][0]? showMoney($basic[3][0]) : "";
$basic5 = $basic[4][0]? showMoney($basic[4][0]) : "";
$basic6 = $basic[5][0]? showMoney($basic[5][0]) : "";

$basic_fee = $upbasic + $uppenalty + $basic[0][0] + $basic[1][0] + $basic[2][0] + $basic[3][0] + $basic[4][0] + $basic[5][0] + $penalty[0][0] + $penalty[1][0] + $penalty[2][0] + $penalty[3][0] + $penalty[4][0] + $penalty[5][0];

$penalty1 = $penalty[0][0]? showMoney($penalty[0][0]) : "";
$penalty2 = $penalty[1][0]? showMoney($penalty[1][0]) : "";
$penalty3 = $penalty[2][0]? showMoney($penalty[2][0]) : "";
$penalty4 = $penalty[3][0]? showMoney($penalty[3][0]) : "";
$penalty5 = $penalty[4][0]? showMoney($penalty[4][0]) : "";
$penalty6 = $penalty[5][0]? showMoney($penalty[5][0]) : "";

$total1 = $total[0][0]? showMoney($total[0][0]) : "";
$total2 = $total[1][0]? showMoney($total[1][0]) : "";
$total3 = $total[2][0]? showMoney($total[2][0]) : "";
$total4 = $total[3][0]? showMoney($total[3][0]) : "";
$total5 = $total[4][0]? showMoney($total[4][0]) : "";
$total6 = $total[5][0]? showMoney($total[5][0]) : "";


$pdf->Text(52,28 , $full_name);
$pdf->Text(115,28 , $location);
$pdf->Text(150,28, $tax_dec_no);

$pdf->Text(180,28, $assessed_value1);
$pdf->Text(180,34, $assessed_value2);
$pdf->Text(180,39, $assessed_value3);
$pdf->Text(180,45, $assessed_value4);
$pdf->Text(180,50, $assessed_value5);
$pdf->Text(180,56, $assessed_value6);



if($upbasic){
  $pdf->Text(212,28, $year1-1);
  $pdf->Text(212,34, $year1);
  $pdf->Text(212,39, $year2);
  $pdf->Text(212,45, $year3);
  $pdf->Text(212,50, $year4);
  $pdf->Text(212,56, $year5);

$pdf->Text(235,28, $upbasic);
$pdf->Text(235,34, $basic1);
$pdf->Text(235,39, $basic2);
$pdf->Text(235,45, $basic3);
$pdf->Text(235,50, $basic4);
$pdf->Text(235,56, $basic5);

$pdf->Text(257,28, $uppenalty);
$pdf->Text(257,34, $penalty1);
$pdf->Text(257,39, $penalty2);
$pdf->Text(257,45, $penalty3);
$pdf->Text(257,50, $penalty4);
$pdf->Text(257,56, $penalty5);

$pdf->Text(295,28, $uptotal);
$pdf->Text(295,34, $total1);
$pdf->Text(295,39, $total2);
$pdf->Text(295,45, $total3);
$pdf->Text(295,50, $total4);
$pdf->Text(295,56, $total5);

}
else{
  $pdf->Text(212,28, $year1);
  $pdf->Text(212,34, $year2);
  $pdf->Text(212,39, $year3);
  $pdf->Text(212,45, $year4);
  $pdf->Text(212,50, $year5);
  $pdf->Text(212,56, $year6);

$pdf->Text(235,28, $basic1);
$pdf->Text(235,34, $basic2);
$pdf->Text(235,39, $basic3);
$pdf->Text(235,45, $basic4);
$pdf->Text(235,50, $basic5);
$pdf->Text(235,56, $basic6);

$pdf->Text(257,28, $penalty1);
$pdf->Text(257,34, $penalty2);
$pdf->Text(257,39, $penalty3);
$pdf->Text(257,45, $penalty4);
$pdf->Text(257,50, $penalty5);
$pdf->Text(257,56, $penalty6);

if($solototal){
  $pdf->Text(295,28, $solototal);
}
else{
  $pdf->Text(295,28, $total1);
}

$pdf->Text(295,34, $total2);
$pdf->Text(295,39, $total3);
$pdf->Text(295,45, $total4);
$pdf->Text(295,50, $total5);
$pdf->Text(295,56, $total6);
}

$pdf->Text(290,62, showMoney($basic_fee));
$pdf->Text(290,68, showMoney($basic_fee));
$pdf->Text(290,73, showMoney(saveMoney($basic_fee) * 2));








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



// $pdf->setCellPaddings(2, 4, 6, 8);
// $txt = ($clearance_fee == null ? '0' : $clearance_fee);
// $pdf->MultiCell(40,7, $txt."\n", 1, 'R', 1, 1,60, 119, true, 0, false, true, 21, 'M', true);

  
// // $pdf->Text(7,$mode_payment == 'CASH' ? 139 : 145, 'x');


// $pdf->setCellPaddings(2, 4, 6, 8);
// $txt = ($clearance_numbertowords == null ? '0' : $clearance_numbertowords);
// $pdf->MultiCell(58,20, $txt."\n", 0, 'L', 1, 1,35, 128, true, 0, false, true, 24, 'M', true);







$pdf->Text(50,77, $this->session->userdata('fullname'));
$pdf->Text(117,77, date("m/d/Y"));
// $pdf->Text(42,165 , 'CITY TREASURER');



ob_clean();
$pdf->Output('name.pdf', 'I');
exit;

  ?>