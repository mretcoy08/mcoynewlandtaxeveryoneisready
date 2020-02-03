<?php
use setasign\Fpdi\Fpdi;
require_once(APPPATH.'/../assets/pdfmerge/TCPDF-master/tcpdf.php');
require_once(APPPATH.'/../assets/pdfmerge/tcpdi/tcpdi.php');
// require_once(APPPATH.'/../assets/pdfmerge/tcpdf_include.php');
ob_start();
date_default_timezone_set('Asia/Manila');
$date = date('m - d - Y');
$pdf = new TCPDI(PDF_PAGE_ORIENTATION, 'mm', PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setSourceFile(APPPATH.'/../assets/PDF/clearance_template.pdf');
$tpl = $pdf->importPage(1);
$pdf->SetDisplayMode(100);
$size = $pdf->getTemplateSize($tpl);
$orientation = $size['h'] > $size['w'] ? 'P' : 'L';
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->addPage($orientation);
$pdf->useTemplate($tpl, null, null, 0, 0, TRUE);
$pdf->setFillColor(0,0,0,0);




$pin = $landData[0]->pin;
$arp = $landData[0]->tax_dec_no;
$location = $landData[0]->barangay;
$assessed_value = $landData[0]->assessed_value;
$or_number = $paymentData[0]->or_number;
$date_of_payment = $paymentData[0]->or_date;
$amount_paid = showMoney($paymentData[0]->due_total);
$basic = showMoney(Floatval($assessed_value)*.01);
$sef = showMoney(Floatval($assessed_value)*.01);
$amount = $purposeData['payment'];

$certification_fee = $purposeData['certification_fee'];
$or_num = $purposeData['or_number'];
$clearancedate = $purposeData['or_date'];




$purpose = $purposeData['purpose'];
$request = $purposeData['request'];




// $owner1 = $owner[0]['full_name'];
// $owner2 = $owner[1]['full_name'];
// $owner3 = $owner[2]['full_name'];
// $owner4 = $owner[3]['full_name'];
// $owner5 = $owner[4]['full_name'];
// $owner6 = $owner[5]['full_name'];
// $owner7 = $owner[6]['full_name'];
// $owner8 = $owner[7]['full_name'];
// $owner9 = $owner[8]['full_name'];
// $owner10 = $owner[9]['full_name'];
// $owner11 = $owner[10]['full_name'];


$pdf->Text(150,36,date("F d, Y"));

$count = count($ownerData);
// $pdf->setCellPaddings(2, 4, 6, 8);
$txt ="";
for($i=0;$i<$count;$i++){

   
$txt .= $ownerData[$i]->full_name .", ";

}

$pdf->setCellPaddings(2, 2, 2, 8);
 $txt = ($txt == null ? '' : $txt);
$pdf->MultiCell(55,20, $txt."\n", 0, 'L', 1, 1,130, 63, true, 0, false, true, 19, 'M', true);


$day = date("d");
$month = date("F");
$year = date("Y");



$pdf->Text(35,74, $pin);  
$pdf->Text(135,74, $arp);

$pdf->setCellPaddings(2, 4, 6, 8);
 $txt = ($location == null ? '' : $location);
$pdf->MultiCell(70,20, $txt."\n", 0, 'L', 1, 1,35, 80, true, 0, false, true, 19, 'M', true);

$pdf->Text(143,79,$assessed_value);

$pdf->Text(82,96,$basic);
$pdf->Text(146,96,$sef);

$pdf->Text(82,110,$basic);
$pdf->Text(146,110,$sef);

$pdf->Text(157,115,$or_number);

$pdf->Text(55,120,$amount_paid);


$pdf->Text(15,126,$or_num);
$pdf->Text(65,126,$clearancedate);

$pdf->setCellPaddings(2, 4, 6, 8);
$txt = $request;
$pdf->MultiCell(50,20, $txt."\n", 0, 'L', 1, 1,125, 136, true, 0, false, true, 19, 'M', true);





//Purpose of request (CLEARANCE)
switch($purpose){

   case "1":
      $pdf->Text(91,153,"X");
   break;
   case "2":
      $pdf->Text(91,165,"X");
   break;
   case "3":
      $pdf->Text(91,176,"X");
   break;
   case "4":
      $pdf->Text(91,188,"X");
   break;
   case "5":
      $pdf->Text(91,199,"X");
   break;
}



//OR Number
$pdf->Text(35,240,$or_num);
//Date
$pdf->Text(35,245,$clearancedate);
//AMOUNT
$pdf->Text(35,250,$amount);
//remarks
// $pdf->Text(35,255,);






ob_clean();
$pdf->IncludeJS("print();");
$pdf->Output('name.pdf', 'I');
exit;

  ?>