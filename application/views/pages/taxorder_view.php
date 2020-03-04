<?php
use setasign\Fpdi\Fpdi;
require_once(APPPATH.'/../assets/pdfmerge/TCPDF-master/tcpdf.php');
require_once(APPPATH.'/../assets/pdfmerge/tcpdi/tcpdi.php');
// require_once(APPPATH.'/../assets/pdfmerge/tcpdf_include.php');
ob_start();
date_default_timezone_set('Asia/Manila');
$date = date('m - d - Y');
$pdf = new TCPDI(PDF_PAGE_ORIENTATION, 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setSourceFile(APPPATH.'/../assets/PDF/tax_order_rpt.pdf');
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
$currentYearPenalty = $penalty[$getCurrentYearCount][0];
$currentYearTotal = $total[$getCurrentYearCount][0];

$totalBasic = $lateYearTotal + $currentYearTotal + $advanceYearTotal;
$sef = $totalBasic;
$grandTotal = $totalBasic + $sef;


//COORDINATES
$pdf->MultiCell(30,5, $full_name."\n", 0, 'R', 0, 0,74, 35, true, 0, false, true, 20, 'M', true);

// $pdf->Text(75,39,$full_name);

$pdf->MultiCell(30,5, $location."\n", 0, 'R', 0, 0,104, 35, true, 0, false, true, 10, 'M', true);
$pdf->Text(135,39,$tax_dec_no);
$pdf->Text(165,39,showMoney($assessed_value[0][0]));


if($year[0][0] < date("Y")){
$pdf->Text(196,39,$lateYear); 
$pdf->Text(226,39,showMoney($lateYearBasic)); 
$pdf->Text(256,39,showMoney($lateYearPenalty)); 

$pdf->Text(196,39,$lateYear); 
$pdf->Text(226,39,showMoney($lateYearBasic)); 
$pdf->Text(256,39,showMoney($lateYearPenalty)); 
$pdf->Text(286,39,showMoney($lateYearTotal)); 

$pdf->Text(196,50,$currentYear); 
$pdf->Text(226,50,showMoney($basic[0][0]));
$pdf->Text(256,50,showMoney($currentYearPenalty));
$pdf->Text(286,50,showMoney($currentYearTotal)); 

$pdf->Text(196,60,$advanceYear);  
$pdf->Text(226,60,showMoney($advanceYearBasic)); 
$pdf->Text(256,60,showMoney($advanceYearDiscount));
$pdf->Text(286,60,showMoney($advanceYearTotal)); 

$pdf->Text(287,66, showMoney($totalBasic));
$pdf->Text(287,72, showMoney($sef));
$pdf->Text(287,77, showMoney($grandTotal));
}
else if($year[0][0] == date("Y") && $paymentCount > 1)
{
  $pdf->Text(196,39,$currentYear); 
  $pdf->Text(226,39,showMoney($basic[0][0]));
  $pdf->Text(256,39,showMoney($currentYearPenalty));
  $pdf->Text(286,39,showMoney($currentYearTotal)); 

  $pdf->Text(196,50,$advanceYear);  
  $pdf->Text(226,50,showMoney($advanceYearBasic)); 
  $pdf->Text(256,50,showMoney($advanceYearDiscount));
  $pdf->Text(286,50,showMoney($advanceYearTotal)); 

  $pdf->Text(287,66, showMoney($totalBasic));
  $pdf->Text(287,72, showMoney($sef));
  $pdf->Text(287,77, showMoney($grandTotal));
}
else if($year[0][0] == date("Y"))
{
  $pdf->Text(196,39,$currentYear); 
  $pdf->Text(226,39,showMoney($basic[0][0]));
  $pdf->Text(256,39,showMoney($currentYearPenalty));
  $pdf->Text(286,39,showMoney($currentYearTotal)); 

  $pdf->Text(287,66, showMoney($totalBasic));
  $pdf->Text(287,72, showMoney($sef));
  $pdf->Text(287,77, showMoney($grandTotal));

}







$pdf->Text(97,84, $this->session->userdata('fullname'));
$pdf->Text(97,89.5, date("m/d/Y"));
// $pdf->Text(7,102  - $min5, 'Tinplate/Sticker/Verification');
// $pdf->setCellPaddings(2, 4, 6, 8);
// $txt = ($total_tin == null ? '0' : $total_tin);
// $pdf->MultiCell(40,7, $txt."\n", 1, 'R', 1, 1,60, 98, true, 0, false, true, 21, 'M', true);




ob_clean();
$pdf->Output('name.pdf', 'I');
exit;

  ?>