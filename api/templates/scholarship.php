<?php

$pageLayout = [
	'certificate' => [
		'bg_path' => __DIR__ . '/../assets/pdf/arena-certificate.pdf',
		'dimension' => [1754, 1250]
	],
	'scholarship' => [
		'bg_path' => __DIR__ . '/../assets/pdf/ismart-scholarship.pdf',
		'dimension' => [1754, 1241]
	]
];

use setasign\Fpdi\Tcpdf\Fpdi;

$pdf = new Fpdi('L', 'px', $pageLayout['scholarship']['dimension'], true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('iSmart Online');
$pdf->SetTitle('iSmart Online Scholarship');
$pdf->SetSubject('iSmart Online');
$pdf->SetKeywords('iSmart Online, Scholarship');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
	require_once(dirname(__FILE__) . '/lang/eng.php');
	$pdf->setLanguageArray($l);
}



// ---------------------------------------------------------

// convert TTF font to TCPDF format and store it on the fonts folder
$mont = TCPDF_FONTS::addTTFfont(__DIR__ . '/../assets/fonts/Montserrat-Regular_0.ttf', 'TrueTypeUnicode', '', 96);
$mont_b = TCPDF_FONTS::addTTFfont(__DIR__ . '/../assets/fonts/Montserrat-Bold.ttf', 'TrueTypeUnicode', '', 96);
$mont_i = TCPDF_FONTS::addTTFfont(__DIR__ . '/../assets/fonts/Montserrat-Italic.ttf', 'TrueTypeUnicode', '', 96);

foreach ($entries as $index => $entry) {
	$name = $entry[1];
	$prize_text = $entry[4];
	$prize = $entry[5];
	$date_signed = $entry[8];

	/* Page 1 */
	$width = $pageLayout['certificate']['dimension'][0];
	$height = $pageLayout['certificate']['dimension'][1];
	// set the source file
	$pdf->setSourceFile($pageLayout['certificate']['bg_path']);

	// add a page
	$pdf->AddPage('L', $pageLayout['certificate']['dimension']);

	// import certificate page 1
	$tplId = $pdf->importPage(1);
	// use the imported page and place it at point 0, 0 with a width equal to layout width (fullpage)
	$pdf->useTemplate($tplId, 0, 0, $width);

	$pdf->SetTextColor(240, 74, 36);
	$pdf->SetFont($mont_b, '', 90, false);
	$pdf->writeHTMLCell($width, 300, 0, 555, $name, 0, 0, false, true, 'C');

	$pdf->SetTextColor(33, 29, 29);
	$pdf->SetFont($mont, '', 36, false);
	$html = $prize_text . ' <span style="font-family: ' . $mont_b . '">' . $prize . '</span>';
	$pdf->writeHTMLCell($width, 300, 0, 690, $html, 0, 0, false, true, 'C');

	$pdf->SetFont($mont_i, '', 32, false);
	$pdf->writeHTMLCell($width, 300, 205, 920, $date_signed, 0, 0, false, true, 'L');
	/* End Page 1 */
}

foreach ($entries as $index => $entry) {
	$name = $entry[1];
	$prize_text = $entry[4];
	$prize = $entry[5];
	$scholarship_amount = $entry[6];
	$date_signed = $entry[8];
	$date_expired = $entry[11];

	/* Page 2 */
	$width = $pageLayout['scholarship']['dimension'][0];
	$height = $pageLayout['scholarship']['dimension'][1];
	// set the source file
	$pdf->setSourceFile($pageLayout['scholarship']['bg_path']);

	// add a page
	$pdf->AddPage('L', $pageLayout['scholarship']['dimension']);

	// import scholarship page 1
	$tplId = $pdf->importPage(1);
	// use the imported page and place it at point 0, 0 with a width equal to layout width (fullpage)
	$pdf->useTemplate($tplId, 0, 0, $width);

	$pdf->SetTextColor(240, 74, 36);
	$pdf->SetFont($mont_b, '', 90, false);
	$pdf->writeHTMLCell($width, 300, 0, 520, $name, 0, 0, false, true, 'C');

	$pdf->SetTextColor(33, 29, 29);
	$pdf->SetFont($mont_b, '', 32, false);
	$pdf->writeHTMLCell($width, 300, 0, 665, "ĐÃ XUẤT SẮC NHẬN ĐƯỢC BỌC BỔNG $scholarship_amount", 0, 0, false, true, 'C');

	$pdf->SetFont($mont, '', 28, false);
	$pdf->writeHTMLCell($width, 300, 0, 715, "Has been excellently award the scholarship with the amount of $scholarship_amount", 0, 0, false, true, 'C');

	$pdf->SetFont($mont_i, '', 30, false);
	$pdf->writeHTMLCell($width, 300, 285, 835, $date_signed, 0, 0, false, true, 'L');

	$pdf->SetTextColor(255, 255, 255);
	$pdf->SetFont($mont_b, '', 20, false);
	$pdf->writeHTMLCell($width, 80, 1378, 1110, $date_expired, 0, 0, false, true, 'L');

	$pdf->SetFont($mont_i, '', 18, false);
	$pdf->writeHTMLCell($width, 14, 1295, 1138, $date_expired, 0, 0, false, true, 'L');
	/* End Page 2 */
}

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output(vn_to_en($name, true) . '_iSmart_Online_Scholarship.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+