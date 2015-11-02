<?php
require('../inc/pdf/invoice.php');
if(!$_SESSION['logged']){die();}
$id	=	$_GET['id'];

$res=mysql_query("select * from invoices where id='".$_GET['id']."'")or die(mysql_error());
$info=mysql_fetch_array($res);

$pdf = new PDF_Invoice( 'P', 'mm', 'letter' );
$pdf->AddPage();
$pdf->Image('../style/images/logo.png',75,15,50);
	
$pdf->addSociete( $cfg['name'],$cfg['name']."\n".$cfg['website']."\n".$cfg['lang_bank'].": ".$cfg['bank_name']."\n".$cfg['lang_bank_account'].": ".$cfg['bank_account']."\n".$cfg['address'] );
$pdf->fact_dev( $cfg['name'] );
if($cfg['watermark']){
	$pdf->temporaire( $cfg['watermark'] );
}
$pdf->addDate(date('d/m/Y',$info['date']));
$pdf->addClient("#".$info['id']);
$pdf->addPageNumber("1");
$pdf->addClientAdresse($info['client_name']."\n".$info['client_address']."\n".$info['client_location']);
$pdf->addReglement($info['payment_method']);
$pdf->addEcheance(date('d/m/Y',$info['date']));

						$rex=mysql_query("SELECT SUM(amount) as total FROM payments WHERE invoice='".$info['id']."'")or die(mysql_error());
							$r=mysql_fetch_array($rex);
							
								if($r['total']<$info['total'] && $r['total']>0){
									$p=$cfg['lang_partial'];
								}elseif($r['total']==0){
									$p=$cfg['lang_unpaid'];
								}elseif($r['total']>$info['total']){
									$p=$cfg['lang_paid'];
								}elseif($r['total']==$info['total']){
									$p=$cfg['lang_paid'];
								}
								
$pdf->addNumTVA($p);
$cols=array( "ID"    					=> 13,
             $cfg['lang_description']   => 92,
             $cfg['lang_qty']      		=> 15,
             $cfg['lang_netprice']     	=> 20,
             $cfg['lang_taxes']     	=> 20,
             $cfg['lang_amount']      	=> 30);
$pdf->addCols( $cols);
$cols=array( "ID"    					=> "L",
             $cfg['lang_description']   => "L",
             $cfg['lang_qty']      		=> "C",
             $cfg['lang_netprice']     	=> "C",
             $cfg['lang_taxes']      	=> "C",
             $cfg['lang_amount']       	=> "R");
$pdf->addLineFormat( $cols);
$pdf->addLineFormat($cols);

$y    = 109;

$res=mysql_query("select * from products where invoice='".$info['id']."' order by id asc")or die(mysql_error());
$i=1;
while($rand=mysql_fetch_array($res)){
			unset($tx);
				$tx		=array();
				$taxprod=0;
				$tx=explode(',',$rand['taxes']);
					foreach($tx as $tax){
						$pos1 = stripos($tax,'%' );
							$tm=str_replace('%','',$tax);
							if ($pos1 !== false) {
								$taxprod+=($tm*$rand['price']*$rand['qty'])/100;
							}else{
								$taxprod+=$tm;
							}
					}

$line = array( "ID"   		 				=> $i,
               $cfg['lang_description']  	=> $rand['title']."\n".$rand['description'],
               $cfg['lang_qty']      		=> $rand['qty'],
			   $cfg['lang_netprice'] 		=> ($rand['price']*$rand['qty']).' '.$info['currency'],
			   $cfg['lang_taxes'] 			=> $taxprod.' '.$info['currency'],
               $cfg['lang_amount']    		=> ($rand['price']*$rand['qty'])+$taxprod. " ".$info['currency']);
$size = $pdf->addLine( $y, $line );
$y   += $size + 2;

			$totals+=$rand['qty']*$rand['price'];
			$taxes+=$taxprod;

$i++;}
        
$pdf->addTVAs( $totals, $taxes, $i);
$pdf->addCadreEurosFrancs();
if($cfg['footer']){
	$pdf->footerNote($cfg['footer']);
}
$pdf->Output('../inc/invoices/'.$_GET['id'].".pdf",'F');
?>