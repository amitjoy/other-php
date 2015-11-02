<?php
// ------------------------------------------------------------
// GET MEMBERSHIP RATES
// ------------------------------------------------------------
if(isset($_POST['ddl_membership_types']))
{
	// get sent values
	$sent_membership_type = mysqli_real_escape_string($conn, $_POST['ddl_membership_types']);
	list($types_id, $types_label) = explode('|', $sent_membership_type);
	
	// ------------------------------------------------------------
	// DB: get membership rates
	$get_membership_rates = mysqli_query($conn, "SELECT RatesId, RateTitle FROM membership_rates WHERE TypesId = $types_id AND IsEnabled = 1 ORDER BY OrdinalPosition")
	or die('error message');
	// ------------------------------------------------------------
	
	// write rates to dropdownlist
	if(mysqli_num_rows($get_membership_rates) > 0)
	{
		while($row = mysqli_fetch_array($get_membership_rates))
		{
			$value_id = $row["RatesId"];
			$value_label = $row["RateTitle"];
			echo '<option value="'.$value_id.'|'.$value_label.'">'.$value_label.'</option>';
		}
	}
}
?>