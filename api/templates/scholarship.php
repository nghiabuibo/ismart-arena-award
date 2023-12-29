<?php

$pageLayout = [
	'certificate' => [
		'bg_path' => __DIR__ . '/../assets/pdf/arena-certificate.pdf',
		'dimension' => [1754, 1250]
	],
	'scholarship' => [
		'bg_path' => __DIR__ . '/../assets/pdf/ismart-scholarship.pdf',
		'dimension' => [1754, 1241]
	],
	'scholarship2' => [
		'bg_path' => __DIR__ . '/../assets/pdf/certificate-arena1.pdf',
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
	$scholarship_amount = $entry[6];
	$scholarship2 = $entry[7];
	$date_signed = $entry[8];
	$date_expired = $entry[9];

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
	$pdf->SetFont($mont_b, '', 80, false);
	$pdf->writeHTMLCell($width - 420, 300, 420, 620, $name, 0, 0, false, true, 'C');

	$pdf->SetTextColor(0, 0, 102);
	$pdf->SetFont($mont, '', 40, false);
	$html = $prize_text . ' <span style="font-family: ' . $mont_b . '">' . $prize . '</span>';
	$pdf->writeHTMLCell($width - 420, 300, 420, 750, $html, 0, 0, false, true, 'C');

	$pdf->SetFont($mont, '', 36, false);
	$pdf->writeHTMLCell($width - 280, 300, 0, 1005, $date_signed, 0, 0, false, true, 'C');
	/* End Page 1 */
}

foreach ($entries as $index => $entry) {
	$name = $entry[1];
	$prize_text = $entry[4];
	$prize = $entry[5];
	$scholarship_amount = $entry[6];
	$scholarship2 = $entry[7];
	$date_signed = $entry[8];
	$date_expired = $entry[9];

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

	$pdf->SetTextColor(44, 51, 147);
	$pdf->SetFont($mont_b, '', 80, false);
	$pdf->writeHTMLCell($width, 300, 0, 520, $name, 0, 0, false, true, 'C');

	$pdf->SetFont($mont_b, '', 80, false);
	$pdf->writeHTMLCell($width, 300, 0, 710, $scholarship_amount, 0, 0, false, true, 'C');

	$pdf->SetTextColor(33, 33, 33);
	$pdf->SetFont($mont_i, '', 20, false);
	$pdf->writeHTMLCell(300, 100, 532, 954, $date_signed);
	/* End Page 2 */
}

foreach ($entries as $index => $entry) {
	if ($index >= 1) break;

	$name = $entry[1];
	$prize_text = $entry[4];
	$prize = $entry[5];
	$scholarship_amount = $entry[6];
	$scholarship2 = $entry[7];
	$date_signed = $entry[8];
	$date_expired = $entry[9];

	/* Page 3 */
	$width = $pageLayout['scholarship2']['dimension'][0];
	$height = $pageLayout['scholarship2']['dimension'][1];
	// set the source file
	$pdf->setSourceFile($pageLayout['scholarship2']['bg_path']);

	// add a page
	$pdf->AddPage('L', $pageLayout['scholarship2']['dimension']);

	// import scholarship page 1
	$tplId = $pdf->importPage(1);
	// use the imported page and place it at point 0, 0 with a width equal to layout width (fullpage)
	$pdf->useTemplate($tplId, 0, 0, $width);

	$pdf->SetTextColor(44, 51, 147);
	$pdf->SetFont($mont_b, '', 80, false);
	$pdf->writeHTMLCell($width, 300, 0, 520, $name, 0, 0, false, true, 'C');

	$pdf->SetFont($mont_b, '', 60, false);
	$pdf->writeHTMLCell($width, 300, 0, 750, $scholarship2, 0, 0, false, true, 'C');

	$pdf->SetTextColor(33, 33, 33);
	$pdf->SetFont($mont_i, '', 20, false);
	$pdf->writeHTMLCell(300, 100, 532, 954, $date_signed);
	/* End Page 3 */
}

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output(vn_to_en($name, true) . '_iSmart_Online_Scholarship.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+