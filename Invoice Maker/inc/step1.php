	<form action='add.php' method='post'>
			<table width='750' align='center'>
				<tr>
					<td class='prop'>Client Name</td>
					<td><input type='text' class='settings' name='client_name' id='suggest13'></td>
					<td class='fieldinfo'>Will be displayed on the top left of the invoice</td>
				</tr>					
				<tr>
					<td class='prop'>Email</td>
					<td><input type='text' class='settings' name='client_email' id='email'></td>
					<td class='fieldinfo'>This will not appear on the invoice, for contact purposes only</td>
				</tr>					
				<tr>
					<td class='prop'>Phone</td>
					<td><input type='text' class='settings' name='client_phone' id='phone'></td>
					<td class='fieldinfo'>This will not appear on the invoice, for contact purposes only</td>
				</tr>							
				<tr>
					<td class='prop' valign='top'>Address</td>
					<td><textarea class='settings' name='client_address' id='address'></textarea></td>
					<td class='fieldinfo'>Client's full address</td>
				</tr>	
				<tr>
					<td class='prop'>Location</td>
					<td><input type='text' class='settings' name='client_location' id='location'></td>
					<td class='fieldinfo'>City, Country , Post Code</td>
				</tr>					
				<tr>
					<td class='prop'>Payment Method</td>
					<td><input type='text' class='settings' name='payment_method' id='pmethod'></td>
					<td class='fieldinfo'>Wire Transfer, Paypal, MoneyBookers...</td>
				</tr>				
				
				<tr>
					<td colspan='3' align='center'><input type='submit' name='step1' value='Next Step' class='button'></td>
				</tr>
			</table>
	</form>			