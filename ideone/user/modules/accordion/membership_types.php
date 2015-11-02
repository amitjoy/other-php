<?php
// ------------------------------------------------------------
// GET MEMBERSHIP TYPES
// ------------------------------------------------------------
$get_membership_types = mysqli_query($conn, "SELECT TypesId, Type FROM membership_types WHERE IsEnabled = 1 ORDER BY OrdinalPosition")
or die('error message');

if(mysqli_num_rows($get_membership_types) > 0)
{
	while($row = mysqli_fetch_array($get_membership_types))
	{
		$value_id = $row["TypesId"];
		$value_label = $row["Type"];
		echo '<option value="'.$value_id.'|'.$value_label.'">'.$value_label.'</option>';
	}
}
?>