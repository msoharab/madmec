<?php

require('fpdf/fpdf.php');

$pdf = new FPDF();

$pdf->AddPage();
//$pdf->Image('../images/Border4.png', 5, 5, 200, 290);
//$pdf->Image('../images/logo1.jpg', 15, 10, 40, 20);
$pdf->Image('assets/img/logo.jpg', 15, 10, 180, 20);

$pdf->Cell(100, 3, "");
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->SetTextColor(0, 0, 0);
$pdf->Cell(180, 3, "Quotation", 0, 0, 'R');

$pdf->Ln();

$pdf->Cell(100, 5, "TO,");
$pdf->Ln();
$pdf->Cell(100, 5, "Transmetal");

$pdf->Ln();
$pdf->Cell(150, 5, "Bangalore");

$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial', 'BU', 9);
$pdf->Cell(150, 3, "Kindly Attend: Mr. Manjunath");
//$pdf->SetFont('Arial',9);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(150, 3, "Subject: Quotation");
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial');
$pdf->SetFontSize(8);
$pdf->Cell(150, 3, "Dear Sir/Madam");
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(150, 3, " with reference to the discussion we had with you regarding your requirement, We are pleased to quote for the same.");
$pdf->Ln();
$pdf->Ln();
$pdf->SetFillColor(164, 161, 161);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(10, 5, "SNo", 1, 0, 'C', TRUE);
$pdf->Cell(90, 5, "Particulars", 1, 0, 'C', TRUE);
$pdf->Cell(20, 5, "Quantity", 1, 0, 'C', TRUE);
$pdf->Cell(20, 5, "Unit", 1, 0, 'C', TRUE);
$pdf->Cell(20, 5, "Supply", 1, 0, 'R', TRUE);
$pdf->Cell(20, 5, "Installation", 1, 0, 'R', TRUE);

$pdf->Ln();

$pdf->SetFont('Arial');
$pdf->SetFontSize(8);
$pdf->Cell(10, 8, "1", 1, 0, 'C');
$pdf->Cell(90, 8, "Supply of table top madeout of 25mm thick prelam sparticles Board ", '1', 0, 'L');


$pdf->Cell(20, 8, "23", 1, 0, 'C');
$pdf->Cell(20, 8, "Nos", 1, 0, 'C');
$pdf->Cell(20, 8, "54280.00", 1, 0, 'R');
$pdf->Cell(20, 8, "0.00", 1, 0, 'R');
$pdf->Ln();
$pdf->Cell(140, 4, "Total", 1, 0, 'R');
$pdf->Cell(20, 4, "54280.00", 1, 0, 'R');
$pdf->Cell(20, 4, "0.00", 1, 0, 'R');
$pdf->Ln();
$pdf->Cell(140, 4, "Vat @ 14.5% on Supply ", 1, 0, 'R');
$pdf->Cell(20, 4, "7871.00", 1, 0, 'R');
$pdf->Cell(20, 4, "", 1, 0, 'R');
$pdf->Ln();
$pdf->Cell(140, 4, "Service tax 50% @ 12.36% on labour ", 1, 0, 'R');
$pdf->Cell(20, 4, "", 1, 0, 'R');
$pdf->Cell(20, 4, "", 1, 0, 'R');
$pdf->Ln();
$pdf->Cell(140, 4, "Grand Total ", 1, 0, 'R');
$pdf->Cell(40, 4, "62151.00", 1, 0, 'C');



$pdf->Ln();
$pdf->Ln();

$pdf->Cell(160, 5, "Amount in words: Sixty Two Thousand One Hundred and Forty One Only");
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(160, 5, "Terms and Conditions:");
$pdf->SetFont('Arial');
$pdf->SetFontSize(8);
$pdf->Ln();
$pdf->Cell(160, 5, "Payment : 100% after Completion");
$pdf->Ln();
$pdf->Cell(160, 5, "Completion : Three Weeks from PO date.");
$pdf->Ln();
$pdf->Cell(160, 5, "Cost : The above quoted price valid for one month.");
$pdf->Ln();
$pdf->Cell(160, 5, "Water, Electricity, ladder and lift to be provided by client at free of cost");
$pdf->Ln();

$pdf->Cell(160, 5, "Taxes as applicable");

$pdf->Ln();
$pdf->Cell(160, 5, "Any extra work done will be applied extra ");
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();


$pdf->SetFont('Arial', 'B', 7);
$pdf->Ln();
$pdf->Ln();
$pdf->Cell(160, 6, "Yours truly,");
$pdf->Ln();
$pdf->Cell(160, 5, 'For Integra Office Solution');
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();
$pdf->Ln();


//$pdf->SetX(10);
//$pdf->SetY(-40);
//$pdf->SetFont('Arial','B',8);
//$pdf->SetTextColor(0, 0, 0);
//$pdf->SetFillColor(255,255, 255);
//$pdf->Cell(160,5,"___________________________________________________________________________________________________________________________");
//$pdf->Ln();
//$pdf->Cell(180,5," No,8 12th main Road, Hongasandra, Begur Road, Bommanahalli,Bangalore-560068",0,'','C');
//$pdf->SetFont('Arial','B',10);
//$pdf->Ln();
//$pdf->Cell(180,5," TIN NO :29250827",0,'','R');
$pdf->Output("Quotation.pdf", 'I');
?>


