<?php
	$q = intval($_GET['q']);

	include('../../dbconfig/dbconfig.php');

	$sql="SELECT Cars.*, COUNT(Cars.carno) AS ordercount FROM Bookings, Cars, OfficeCars WHERE Bookings.carid = OfficeCars.carid AND Cars.carno = OfficeCars.carno AND YEAR(Bookings.pickuptime) = '".$q."' GROUP BY Cars.carno ORDER BY ordercount DESC";
	$getallcarsql = mysql_query($sql);
	$rownocar = mysql_num_rows($getallcarsql);

	if($rownocar > 0):

	echo "
	<thead>
		<tr>
			<td></td>
			<td>Car Name</td>
			<td>Transmission</td>
			<td>Type</td>
			<td>Class</td>
			<td>Capacity</td>
			<td>Airbag</td>
			<td>Rating</td>
			<td id='desc'>Description</td>
			<td>Cost</td>
			<td>Hire Count</td>
		</tr>
	</thead>
	<tbody>";
			while ($rowgetallcars = mysql_fetch_assoc($getallcarsql)) {
	echo"
		<tr>
			<td><img src='../images/carphoto/".$rowgetallcars['carphoto']."' alt='' width='30px' height='30px'></td>";
			echo "<td>".$rowgetallcars['carname']."</td>";
			echo "<td>".$rowgetallcars['cartransmission']."</td>";
			echo "<td>".$rowgetallcars['cartype']."</td>";
			echo "<td>".$rowgetallcars['carclass']."</td>";
			echo "<td>".$rowgetallcars['carcapacity']."</td>";
			echo "<td>".$rowgetallcars['carairbag']."</td>";
			echo "<td>".$rowgetallcars['carrating']."</td>";
			echo "<td>".$rowgetallcars['carotherdescription']."</td>";
			echo "<td>".$rowgetallcars['carcost']."</td>";
			echo "<td>".$rowgetallcars['ordercount']."</td>";
		echo "</tr>";
			}
	else:
		echo "<h3>There is no booking in $q</h3>";


	endif;
?>