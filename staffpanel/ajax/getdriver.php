<?php
	$q = $_GET['q'];
	$monthyear = explode("-", $q);
	$month = $monthyear[0];
	$year = $monthyear[1];

	include('../../dbconfig/dbconfig.php');

	$sql="SELECT Drivers.*, COUNT(Drivers.driverid) AS bookingcount FROM Drivers, Bookings WHERE Drivers.driverid = Bookings.driverid AND YEAR(Bookings.pickuptime) = '$year' AND MONTH(Bookings.pickuptime) = '$month' AND Drivers.driverid != 'nodriver' GROUP BY Drivers.driverid ORDER BY bookingcount DESC";
	$getdriversql = mysql_query($sql);
	$rownodriver = mysql_num_rows($getdriversql);

	if($rownodriver > 0):

	echo "
	<thead>
		<tr>
			<td></td>
			<td>Driver Name</td>
			<td>Username</td>
			<td>Email</td>
			<td>Gender</td>
			<td>Age</td>
			<td>Rating</td>
			<td>Experience</td>
			<td>Booking Count</td>
		</tr>
	</thead>
	<tbody>";
			while ($rowgetdriver = mysql_fetch_assoc($getdriversql)) {
	echo"
		<tr>
			<td><img src='../images/driverphoto/".$rowgetdriver['driverphoto']."' alt='' width='30px' height='30px'></td>";
			echo "<td>".$rowgetdriver['drivername']."</td>";
			echo "<td>".$rowgetdriver['driverusername']."</td>";
			echo "<td>".$rowgetdriver['driveremail']."</td>";
			echo "<td>".$rowgetdriver['drivergender']."</td>";
			echo "<td>".$rowgetdriver['driverage']."</td>";
			echo "<td>".$rowgetdriver['driverrating']."</td>";
			echo "<td>".$rowgetdriver['driverexperience']."</td>";
			echo "<td>".$rowgetdriver['bookingcount']."</td>";
		echo "</tr>";
			}
	else:
		$monthName = date("F", mktime(0, 0, 0, $month, 10));
		echo "<h3>There is no booking in $monthName  $year</h3>";


	endif;
?>