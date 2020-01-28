<?php
use setasign\Fpdi\Fpdi;
require_once(APPPATH.'/../assets/pdfmerge/TCPDF-master/tcpdf.php');
require_once(APPPATH.'/../assets/pdfmerge/tcpdi/tcpdi.php');
// require_once(APPPATH.'/../assets/pdfmerge/tcpdf_include.php');

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
// // $charges = (int)$charges_fee;
// $Amt = (int)$Amount;

// $min5 = 5;
// $pdf->Text(55,50  , date('Y-m-d'));

// $pdf->Text(17,58 , 'City Goverment of San Pablo');
// $pdf->Text(77,58, 'Gr A');

// $pdf->setCellPaddings(2, 4, 6, 8);
// $txt = ($payor == null ? '0' : $payor);
// $pdf->MultiCell(90, 50, $txt, 0, 'L', 0, 0, 16, 61, true);

// $pdf->Text(7,81  - $min5, 'Business Tax & MP');
// $pdf->setCellPaddings(2, 4, 6, 8);
// $txt =($buss_tax_mp == null ? '0' : $buss_tax_mp);
// $pdf->MultiCell(40,7, $txt."\n", 0, 'R', 0, 0,60, 76, true, 0, false, true, 21, 'M', true);

// $pdf->Text(7,87 - $min5 , 'Annual Inspection Fee');
// $pdf->setCellPaddings(2, 4, 6, 8);
// $txt =($total_annual_inspection == null ? '0' : $total_annual_inspection);
// $pdf->MultiCell(40,7, $txt."\n", 0, 'R', 0, 0,60, 82, true, 0, false, true, 21, 'M', true);

// $pdf->Text(7,92  - $min5, 'Garbage Fee');
// $pdf->setCellPaddings(2, 4, 6, 8);
// $txt =($garbage_fee == null ? '0' : $garbage_fee);
// $pdf->MultiCell(40,7, $txt."\n", 0, 'R', 0, 0,60, 87, true, 0, false, true, 21, 'M', true);

// $pdf->Text(7,97 - $min5 , 'Health Cert Fee & S.S.F');
// $pdf->setCellPaddings(2, 4, 6, 8);
// $txt =($total_health == null ? '0' : $total_health);
// $pdf->MultiCell(40,7, $txt."\n", 0, 'R', 0, 0,60, 92, true, 0, false, true, 21, 'M', true);

// $pdf->Text(7,102  - $min5, 'Tinplate/Sticker/Verification');
// $pdf->setCellPaddings(2, 4, 6, 8);
// $txt = ($total_tin == null ? '0' : $total_tin);
// $pdf->MultiCell(40,7, $txt."\n", 0, 'R', 0, 0,60, 98, true, 0, false, true, 21, 'M', true);

// $pdf->Text(7,108  - $min5, 'Service Unit Fee');
// $pdf->setCellPaddings(2, 4, 6, 8);
// $txt = ($total_service == null ? '0' : $total_service);
// $pdf->MultiCell(40,7, $txt."\n", 0, 'R', 0, 0,60, 104, true, 0, false, true, 21, 'M', true);

// $pdf->Text(7,113 - $min5 , 'Surcharge & Penalties');
// // $txt = '0';
// $txt = ($total_chg == null ? '0' : $total_chg);

// $pdf->MultiCell(40,7, $txt."\n", 0, 'R', 0, 0,60, 108, true, 0, false, true, 21, 'M', true);

// $pdf->Text(7,118 - $min5 , 'Others');
// $pdf->setCellPaddings(2, 4, 6, 8);
// $txt = ($total_charge == null ? '0' : $total_charge);
// $pdf->MultiCell(40,7, $txt."\n", 0, 'R', 0, 0,60, 114, true, 0, false, true, 21, 'M', true);

// $pdf->setCellPaddings(2, 4, 6, 8);
// $txt = ($Amount == null ? '0' : $Amount);
// $pdf->MultiCell(40,7, $txt."\n", 0, 'R', 0, 0,60, 119, true, 0, false, true, 21, 'M', true);


// $pdf->Text(7,$mode_payment == 'CASH' ? 139 : 145, 'x');

// $pdf->setCellPaddings(2, 4, 6, 8);
// $txt = ($AmountinWords == null ? '0' : $AmountinWords);
// $pdf->MultiCell(60,20, $txt."\n", 0, 'L', 0, 0,35, 128, true, 0, false, true, 24, 'M', true);


// if ($mode_payment == "BANK"){

// $pdf->setCellPaddings(2, 4, 6, 8);
// $pdf->MultiCell(25, 22, ($mode_payment == 'BANK' ? ($Bank == null ? '0' : $Bank ): ''), 0, 'L', 0, 2,32, 147, true);

// $pdf->setCellPaddings(2, 4, 6, 8);
// $pdf->MultiCell(25, 27, ($mode_payment == 'BANK' ? ($Cheque == null ? '0' : $Cheque) : ''), 0, 'L', 0, 2,52, 147, true);

// $pdf->setCellPaddings(2, 4, 6, 8);
// $pdf->MultiCell(25, 27, ($mode_payment == 'BANK' ? ($date == null ? '0' : $date) : ''), 0, 'L', 0, 2,72, 147, true);

// }


// $pdf->Text(42,161, 'ARJAN B. BABANI');
// $pdf->Text(42,165 , 'CITY TREASURER');




// $js = 'print(true);';
// ob_start();
// ob_end_clean();
// $pdf->IncludeJS($js);
// $pdf->Output('name.pdf', 'I');

  ?>