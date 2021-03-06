<?php
error_reporting(E_ALL & ~E_NOTICE);
  ini_set('display_errors', 0);
  ini_set('log_errors', 1);
//============================================================+
// File name   : example_001.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 001 for TCPDF class
//               Default Header and Footer
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Default Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */


// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('Informe de Indicador');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' ', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 9, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print

$html = <<<EOD
<h1>Informe y análisis de resultados de Indicadores</h1>
I. INFORMACIÓN GENERAL<br><br>
<table>
	<tr>
		<td>Nombre unidad:</td>
		<td>$unidad->descripcion  $datos->desc_subUn</td>
	</tr>
	<tr>
		<td>Fecha del Informe:</td>
		<td>$datos->fecha</td>
	</tr>
	<tr>
		<td>Nombre del responsable:</td>
		<td>$resp</td>
	</tr>
</table>

<br><br>
II. INFORMACIÓN MEDICIÓN DEL INDICADOR <br><br>
<table border="1">
	<tr>
		<td>Código característica:</td>
		<td>$datos->codigo</td>
	</tr>
	<tr>
		<td>Nombre del Indicador:</td>
		<td>$datos->indicadorDesc</td>
	</tr>
	<tr>
		<td>Fórmula del Indicador:</td>
		<td>$datos->formula1 / $datos->formula2</td>
	</tr>
	<tr>
		<td>Resultado:</td>
		<td>$datos2->denominadores / $datos2->numeradores = $datos2->res %</td>
	</tr>
	<tr>
		<td>Umbral de cumplimiento:</td>
		<td>$datos->umbralDesc</td>
	</tr>
	<tr>
		<td>Periodo:</td>
		<td>$datos->periodoDet</td>
	</tr>
</table>
<br><br>
<div>
III. ANÁLISIS Y COMENTARIOS DE LOS RESULTADOS:
 <p>$datos->comentarios</p>
</div>

PLAN DE MEJORA:
<div>
<p>$datos->plan</p>
</div>

<div style="text-align: center;">
<p>$resp</p>
<p>ENCARGADO DE CALIDAD</p>
</div>
EOD;


// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
