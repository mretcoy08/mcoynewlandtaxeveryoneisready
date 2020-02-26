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
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
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
$mode_of_payment = $orData[0]->mode_of_payment;
// $full_payment = Floatval($orData[0]->$due_basic) * 2;
$total_payment = showMoney($orData[0]->due_total);
if($mode_of_payment != "Compromise"){
  $due_date = explode("/",$orData[0]->due_date);
}



$paymentwords = numtowords($orData[0]->due_total);

if($mode_of_payment != "Compromise")
{
  $penalty_percentage = 2 * Floatval(monthDiff($due_date[0],$due_date[2]));
}



$pdf->Text(55,30 , "Laguna");
$pdf->Text(100,30  , "San Pablo ");
$pdf->Text(190,30, date("m/d/Y"));
// $pdf->Text(227,53, date("y"));



$pdf->setCellPaddings(2, 4, 6, 8);
$txt = ($payor_name == null ? "" : $payor_name);
$pdf->MultiCell(90, 41, $txt, 0, 'L', 1, 2, 55, 31, true);

$pdf->setCellPaddings(2, 4, 6, 8);
$txt = ($paymentwords == null ? "" : $paymentwords);
$pdf->SetFont('', 'B', 6, '', 'false');
$pdf->MultiCell(60,40, $txt, 0, 'L', 1, 2, 143, 31,true);


$pdf->SetFont('', '', 9, '', 'false');
$pdf->setCellPaddings(2, 4, 6, 8);
$txt = ($payment == null ? "" : $payment);
$pdf->MultiCell(90, 41, $txt, 0, 'L', 1, 2, 205, 30, true);


$pdf->SetFont('', '', 10, '', 'false');
$pdf->setCellPaddings(2, 4, 6, 8);
$txt = ($ownerFullName == null ? "" : $ownerFullName);
$pdf->MultiCell(30, 20, $txt, 0, 'L', 1, 2, 2, 55, true);

$pdf->setCellPaddings(2, 4, 6, 8);
$txt = ($location == null ? "" : $location);
$pdf->MultiCell(35, 25, $txt, 0, 'L', 1, 2, 28, 57, true);

$pdf->setCellPaddings(2, 4, 6, 8);
$txt = ($lot_no == null ? "" : $lot_no);
$pdf->MultiCell(25, 20, $txt, 0, 'L', 1, 2, 56, 57, true);

$pdf->setCellPaddings(2, 4, 6, 8);
$txt = ($tax_dec_no == null ? "88-12345" : $tax_dec_no);
$pdf->MultiCell(30, 20, $txt, 0, 'L', 1, 2, 72, 57, true);

$pdf->setCellPaddings(2, 4, 6, 8);
$txt = ($av_land == null ? "88-12345" : $av_land);
$pdf->MultiCell(30, 20, $txt, 0, 'L', 1, 2, 91, 57, true);

$pdf->setCellPaddings(2, 4, 6, 8);
$txt = ($av_improvement == null ? "" : $av_improvement);
$pdf->MultiCell(30, 20, $txt, 0, 'L', 1, 2, 106, 57, true);

$pdf->setCellPaddings(2, 4, 6, 8);
$txt = ($av_total == null ? "88-12345" : $av_total);
$pdf->MultiCell(40, 40, $txt, 0, 'L', 1, 2, 122, 57, true);

$pdf->setCellPaddings(2, 4, 6, 8);
$txt = ($tax_due == null ? "asdasd" : $tax_due);
$pdf->MultiCell(40, 40, $txt, 0, 'L', 1, 2, 140, 57, true);

if($mode_of_payment != "Annually")
{
  $pdf->setCellPaddings(2, 4, 6, 8);
  $txt = ($ipayment_no == null ? "5" : $ipayment_no);
  $pdf->MultiCell(40, 40, $txt, 0, 'L', 1, 2, 160, 57, true);

  $pdf->setCellPaddings(2, 4, 6, 8);
  $txt = ($ipayment == null ? "88-12345" : $ipayment);
  $pdf->MultiCell(40, 40, $txt, 0, 'L', 1, 2, 168, 57, true);
}
else{
  $pdf->setCellPaddings(2, 4, 6, 8);
  $txt = ($full_payment == null ? "asd" : $full_payment);
  $pdf->MultiCell(40, 40, $txt, 0, 'L', 1, 2, 189, 57, true);
}

if($mode_of_payment != "Compromise")
{

  if($penalty_percentage > 0)
  {
    $pdf->setCellPaddings(2, 4, 6, 8);
  $txt = ($penalty_percentage == null ? "" : $penalty_percentage);
  $pdf->MultiCell(40, 40, $txt, 0, 'L', 1, 2, 203, 57, true);
  }

}




$pdf->setCellPaddings(2, 4, 6, 8);
$txt = ($total_payment == null ? "88-12345" : $total_payment);
$pdf->MultiCell(40, 40, $txt, 0, 'L', 1, 2, 213, 57, true);

ob_clean();

$pdf->Output('name.pdf', 'I');
exit;

  ?>