<?
if(!$_SESSION['logged']){die();}
?>
	<form action='newinvoice.php' method='post'>
			<table width='100%' align='center'>
				<tr>
					<td class='prop'>Select Client</td>
					<td>
					<select name='client' id='selected_client' onchange='selectclient()'>
						<option value=''>Select</option>
											<?
						$res=mysql_query("SELECT * FROM `invoices` where client_name!='' group by client_location,client_name")or die(mysql_error());
							while($row=mysql_fetch_array($res)){
					?>
						<option value='<?=$row['id']?>'><?=$row['client_name']?></option>
					<?}?>
					</select>
					</td>
				</tr>					
				<tr>
					<td class='prop'>Client Name</td>
					<td><input type='text' class='settings' name='client_name' id='name'></td>
				</tr>					
				<tr>
					<td class='prop'>Email</td>
					<td><input type='text' class='settings' name='client_email' id='email'></td>
				</tr>					
				<tr>
					<td class='prop'>Phone</td>
					<td><input type='text' class='settings' name='client_phone' id='phone'></td>
				</tr>							
				<tr>
					<td class='prop' valign='top'>Address</td>
					<td><textarea class='settings' name='client_address' id='address'></textarea></td>
				</tr>	
				<tr>
					<td class='prop'>Location</td>
					<td><input type='text' class='settings' name='client_location' id='location'></td>
				</tr>					
				<tr>
					<td class='prop'>Payment Method</td>
					<td><input type='text' class='settings' name='payment_method' id='pmethod'></td>
				</tr>				
				<tr>
					<td colspan='2' align='center'><input type='submit' name='step1' value='Next Step' class='button'></td>
				</tr>
			</table>
	</form>			