<?php

define('FPDF_FONTPATH', 'font/');
include_once('pdf/ufpdf.php');

$pdf = new UFPDF();
$pdf->Open();
$pdf->SetTitle("UFPDF is Cool.\nŨƑƤĐƒ ıš ČŏōĹ");
$pdf->SetAuthor('Steven Wittens');
$pdf->AddFont('LucidaSansUnicode', '', 'lsansuni.php');
$pdf->AddPage();
$pdf->SetFont('LucidaSansUnicode', '', 32);
$pdf->Write(12, "Монтаж на алармена с-ма.\n");
$pdf->Write(12, "ŨƑƤĐƒ");
$pdf->Write(12, "ıš ČŏōĹ.\n");
$pdf->Close();
$pdf->Output('unicode.pdf', 'I');

?>