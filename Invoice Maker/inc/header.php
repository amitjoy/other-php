		<div id='header'>
			<div class='menu' <?if($meniu=='home'){?> id='current'<?}?> onclick="document.location='index.php'"><img src='style/icons/home.png'/><br>Home</div>
			<div class='menu' <?if($meniu=='add'){?> id='current'<?}?> onclick="document.location='add.php'"><img src='style/icons/add.png'/><br>New Invoice</div>
			<div class='menu' <?if($meniu=='invoices'){?> id='current'<?}?> onclick="document.location='invoices.php'"><img src='style/icons/invoices.png'/><br>All Invoices</div>
			<div class='menu' <?if($meniu=='payments'){?> id='current'<?}?> onclick="document.location='payments.php'"><img src='style/icons/payments.png'/><br>Payments</div>
			<div class='menu' <?if($meniu=='taxes'){?> id='current'<?}?> onclick="document.location='taxes.php'"><img src='style/icons/taxes.png'/><br>Taxes</div>
			<div class='menu' <?if($meniu=='settings'){?> id='current'<?}?> onclick="document.location='settings.php'"><img src='style/icons/settings.png'/><br>Settings</div>
			<div class='menu' onclick="document.location='login/logout.php'"><img src='style/icons/logout.png'/><br>Disconnect</div>
		</div>