<?
require('fpdf.php');
require('html2fpdf.php');




$html='<table width="100%" style="background:red;color:white;"><tr bgcolor="#ff0000"><td><font color="red">test</font></td></tr></table>You can now easily print text mixing different styles: <b>bold</b>, <i>italic</i>,
<u>underlined</u>, or <b><i><u>all at once</u></i></b>!<br><br>You can also insert links on
text, such as <a href="http://www.fpdf.org">www.fpdf.org</a>, or on an image: click on the logo.';



$pdf=new HTML2FPDF();
//Second page
$pdf->AddPage();
$pdf->SetLink($link);

$pdf->SetLeftMargin(15);
$pdf->SetFontSize(14);
$pdf->WriteHTML($html);
$pdf->Output();
?>