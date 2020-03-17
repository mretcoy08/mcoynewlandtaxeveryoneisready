<?php
use setasign\Fpdi\Fpdi;
require_once(APPPATH.'/../assets/pdfmerge/TCPDF-master/tcpdf.php');
require_once(APPPATH.'/../assets/pdfmerge/tcpdi/tcpdi.php');
// require_once(APPPATH.'/../assets/pdfmerge/tcpdf_include.php');
ob_start();
date_default_timezone_set('Asia/Manila');
$date = date('m - d - Y');
$pdf = new TCPDI(PDF_PAGE_ORIENTATION, 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setSourceFile(APPPATH.'/../assets/PDF/tax_order_rpt_1.pdf');
$tpl = $pdf->importPage(1);
$pdf->SetDisplayMode(100);
$size = $pdf->getTemplateSize($tpl);
$orientation = $size['h'] > $size['w'] ? 'P' : 'L';
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->addPage($orientation);
$pdf->useTemplate($tpl, null, null, 0, 0, TRUE);
$pdf->setAutoPageBreak(false,0);
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








//VARIABLES
$lateYear = "";
$currentYear = "";
$advanceYear = "";

$lateYearBasic = "";
$currentYearBasic = "";
$advanceYearBasic = "";

$lateYearPenalty = "";
$currentYearPenalty = "";
$advanceYearDiscount = "";

$lateYearTotal = "";
$currentYearTotal = "";
$advanceYearTotal = "";

$totalBasic = "";
$sef = "";
$grandTotal = "";

$getCurrentYearCount = "";
$garbageFee = 360.00;


//LOGIC
$paymentCount = count($assessed_value);

for($count = 0; $count<$paymentCount; $count++)
{
   if($year[$count][0] == date("Y"))
   {
    $getCurrentYearCount = $count;
    $count = $paymentCount;
   }
}


if($paymentCount > 1)
{
      if($year[0][0] < date("Y"))
      {
            if($year[0][0]+1 != date("Y"))
            {
              $lateYear = $year[0][0]." to ".(date("Y") - 1);
            }
            else
            {
              $lateYear = $year[0][0];
            }
            $i = 0;
            do{
              $lateYearBasic += $basic[$i][0];
              $lateYearTotal += $basic[$i][0];
              $i++;
            }while($year[$i][0] < date("Y"));

            $i = 0;
            do{
              $lateYearPenalty += $penalty[$i][0];
              $lateYearTotal += $penalty[$i][0];
              $i++;
            }while($year[$i][0] < date("Y"));
      }
      
     
      
      if($year[$paymentCount - 1][0] > date("Y"))
      {
            if($year[$paymentCount - 1][0] - 1 != date("Y"))
            {
              $advanceYear = date("Y")+1 ." to ".$year[$paymentCount - 1][0];
            }
            else
            {
              $advanceYear = $year[$paymentCount - 1][0];
            }
            $i = $paymentCount - 1;
            do{
              $advanceYearBasic += $basic[$i][0];
              $advanceYearTotal += $basic[$i][0];
              $i--;
            }while($year[$i][0] > date("Y"));

            $i = $paymentCount - 1;
            do{
              $advanceYearDiscount += $penalty[$i][0];
              $advanceYearTotal += $penalty[$i][0];
              $i--;
            }while($year[$i][0] > date("Y"));
          
      }
}


$full_name = $ownerLocation['full_name'];
$location = $ownerLocation['barangay'];
$tax_dec_no = $ownerLocation['tax_dec_no'];

$currentYear = date("Y");
$currentYearBasic = $basic[0][0];
$currentYearPenalty = $penalty[$getCurrentYearCount][0];
$currentYearTotal = $total[$getCurrentYearCount][0];

$totalBasic = $lateYearTotal + $currentYearTotal + $advanceYearTotal;
$sef = $totalBasic;
$grandTotal = $totalBasic + $sef;


//COORDINATES
$pdf->MultiCell(57,5, $full_name."\n", 0, 'R', 0, 0,65, 31, true, 0, false, true, 25, 'M', true);

// $pdf->Text(75,39,$full_name);

$pdf->MultiCell(46,5, $location."\n", 0, 'R', 0, 0,124, 31, true, 0, false, true, 25, 'M', true);

$pdf->MultiCell(23,5, $tax_dec_no."\n", 0, 'R', 0, 0,170, 31, true, 0, false, true, 8, 'M', true);

$pdf->MultiCell(23,5, showMoney($assessed_value[0][0])."\n", 0, 'R', 0, 0,193.5, 31, true, 0, false, true, 8, 'M', true);






if($year[0][0] < date("Y")){

$pdf->MultiCell(23,5, $lateYear."\n", 0, 'R', 0, 0,218, 31, true, 0, false, true, 8, 'M', true);

$pdf->MultiCell(23,5, $currentYear."\n", 0, 'R', 0, 0,218, 40, true, 0, false, true, 8, 'M', true);

$pdf->MultiCell(23,5, $advanceYear."\n", 0, 'R', 0, 0,218, 49, true, 0, false, true, 8, 'M', true);


$pdf->MultiCell(23,5, showMoney($lateYearBasic)."\n", 0, 'R', 0, 0,241.5, 31, true, 0, false, true, 8, 'M', true);

$pdf->MultiCell(23,5, showMoney($currentYearBasic)."\n", 0, 'R', 0, 0,241.5, 40, true, 0, false, true, 8, 'M', true);

$pdf->MultiCell(23,5, showMoney($advanceYearBasic)."\n", 0, 'R', 0, 0,241.5, 49, true, 0, false, true, 8, 'M', true);

$pdf->MultiCell(23,5, showMoney($lateYearPenalty)."\n", 0, 'R', 0, 0,265, 31, true, 0, false, true, 8, 'M', true);

$pdf->MultiCell(23,5, showMoney($currentYearPenalty)."\n", 0, 'R', 0, 0,265, 40, true, 0, false, true, 8, 'M', true);

$pdf->MultiCell(23,5, showMoney($advanceYearDiscount)."\n", 0, 'R', 0, 0,265, 49, true, 0, false, true, 8, 'M', true);

$pdf->MultiCell(32,5, showMoney($lateYearTotal)."\n", 0, 'R', 0, 0,289, 31, true, 0, false, true, 8, 'M', true);

$pdf->MultiCell(32,5, showMoney($currentYearTotal)."\n", 0, 'R', 0, 0,289, 40, true, 0, false, true, 8, 'M', true);

$pdf->MultiCell(32,5, showMoney($advanceYearTotal)."\n", 0, 'R', 0, 0,289, 49, true, 0, false, true, 8, 'M', true);

$pdf->MultiCell(32,5, showMoney($totalBasic)."\n", 0, 'R', 0, 0,289, 58, true, 0, false, true, 8, 'M', true);

$pdf->MultiCell(32,5, showMoney($sef)."\n", 0, 'R', 0, 0,289, 66, true, 0, false, true, 8, 'M', true);

$pdf->MultiCell(32,5, showMoney($grandTotal)."\n", 0, 'R', 0, 0,289, 75, true, 0, false, true, 8, 'M', true);



}
else if($year[0][0] == date("Y") && $paymentCount > 1)
{
  $pdf->MultiCell(23,5, $currentYear."\n", 0, 'R', 0, 0,218, 31, true, 0, false, true, 8, 'M', true);

  $pdf->MultiCell(23,5, $advanceYear."\n", 0, 'R', 0, 0,218, 40, true, 0, false, true, 8, 'M', true);
  
  $pdf->MultiCell(23,5, showMoney($currentYearBasic)."\n", 0, 'R', 0, 0,241.5, 31, true, 0, false, true, 8, 'M', true);

  $pdf->MultiCell(23,5, showMoney($advanceYearBasic)."\n", 0, 'R', 0, 0,241.5, 40, true, 0, false, true, 8, 'M', true);

  $pdf->MultiCell(23,5, showMoney($currentYearPenalty)."\n", 0, 'R', 0, 0,265, 31, true, 0, false, true, 8, 'M', true);

  $pdf->MultiCell(23,5, showMoney($advanceYearDiscount)."\n", 0, 'R', 0, 0,265, 40, true, 0, false, true, 8, 'M', true);

  $pdf->MultiCell(32,5, showMoney($currentYearTotal)."\n", 0, 'R', 0, 0,289, 31, true, 0, false, true, 8, 'M', true);

  $pdf->MultiCell(32,5, showMoney($advanceYearTotal)."\n", 0, 'R', 0, 0,289, 40, true, 0, false, true, 8, 'M', true);
  $pdf->MultiCell(32,5, showMoney($totalBasic)."\n", 0, 'R', 0, 0,289, 58, true, 0, false, true, 8, 'M', true);

  $pdf->MultiCell(32,5, showMoney($sef)."\n", 0, 'R', 0, 0,289, 66, true, 0, false, true, 8, 'M', true);

  $pdf->MultiCell(32,5, showMoney($grandTotal)."\n", 0, 'R', 0, 0,289, 75, true, 0, false, true, 8, 'M', true);

}
else if($year[0][0] == date("Y"))
{
  $pdf->MultiCell(23,5, $currentYear."\n", 0, 'R', 0, 0,218, 31, true, 0, false, true, 8, 'M', true);
  $pdf->MultiCell(23,5, showMoney($currentYearBasic)."\n", 0, 'R', 0, 0,241.5, 31, true, 0, false, true, 8, 'M', true);
  $pdf->MultiCell(23,5, showMoney($currentYearPenalty)."\n", 0, 'R', 0, 0,265, 31, true, 0, false, true, 8, 'M', true);
  $pdf->MultiCell(32,5, showMoney($currentYearTotal)."\n", 0, 'R', 0, 0,289, 31, true, 0, false, true, 8, 'M', true);
  $pdf->MultiCell(32,5, showMoney($totalBasic)."\n", 0, 'R', 0, 0,289, 58, true, 0, false, true, 8, 'M', true);

  $pdf->MultiCell(32,5, showMoney($sef)."\n", 0, 'R', 0, 0,289, 66, true, 0, false, true, 8, 'M', true);



  $pdf->MultiCell(32,5, showMoney($grandTotal)."\n", 0, 'R', 0, 0,289, 75, true, 0, false, true, 8, 'M', true);

}

// $pdf->MultiCell(32,5, ."\n", 0, 'R', 0, 0,289, 84, true, 0, false, true, 8, 'M', true);

$pdf->MultiCell(32,5, showMoney($garbageFee)."\n", 0, 'R', 0, 0,289, 85, true, 0, false, true, 8, 'M', true);

$pdf->MultiCell(32,5, showMoney($grandTotal + $garbageFee)."\n", 0, 'R', 0, 0,289, 93, true, 0, false, true, 8, 'M', true);





$pdf->Text(92,90, $this->session->userdata('fullname'));
$pdf->Text(92,95, date("m/d/Y"));
// $pdf->Text(7,102  - $min5, 'Tinplate/Sticker/Verification');
// $pdf->setCellPaddings(2, 4, 6, 8);
// $txt = ($total_tin == null ? '0' : $total_tin);
// $pdf->MultiCell(40,7, $txt."\n", 1, 'R', 1, 1,60, 98, true, 0, false, true, 21, 'M', true);





ob_clean();
$pdf->IncludeJS("print();");
$pdf->Output('name.pdf', 'I');

exit;

  ?>