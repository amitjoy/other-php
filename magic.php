<?php
function MagicSquare($order)
{
	for($row = 0; $row < $order; $row++)
	{
		echo "<tr>";
		for($col = 0; $col < $order; $col++)
		{
			$rowMatrix = ((($order + 1)/2 + $row + $col) % $order);
			$colMatrix = ((($order + 1)/2 + $row + $order - $col -1) % $order)+1;
			echo "<td>".((($rowMatrix * $order) + $colMatrix)). "</td>";
		}
		echo "</tr>";
	}
}
echo "<table border=2 cellpaddding=1 cellspacing=4>";
MagicSquare(4);
echo "</table>";

?>