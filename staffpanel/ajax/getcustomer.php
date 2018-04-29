<?php
	$q = $_GET['q'];
	$monthyear = explode("-", $q);
	$month = $monthyear[0];
	$year = $monthyear[1];

	include('../../dbconfig/dbconfig.php');

	$sql="SELECT Customers.*, COUNT(Customers.customerid) AS bookingcount FROM Customers, Bookings WHERE Customers.customerid = Bookings.customerid AND YEAR(Bookings.pickuptime) = '$year' AND MONTH(Bookings.pickuptime) = '$month' GROUP BY Customers.customerid ORDER BY bookingcount DESC";
	$getcustomersql = mysql_query($sql);
	$rownocustomer = mysql_num_rows($getcustomersql);

	if($rownocustomer > 0):

	echo "
	<thead>
		<tr>
			<td></td>
			<td>Customer Name</td>
			<td>Username</td>
			<td>Email</td>
			<td>Gender</td>
			<td>DOB</td>
			<td>Booking Count</td>
		</tr>
	</thead>
	<tbody>";
			while ($rowgetcustomer = mysql_fetch_assoc($getcustomersql)) {
	echo"
		<tr>
			<td><img src='../images/customerphoto/".$rowgetcustomer['customerphoto']."' alt='' width='30px' height='30px'></td>";
			echo "<td>".$rowgetcustomer['customername']."</td>";
			echo "<td>".$rowgetcustomer['customerusername']."</td>";
			echo "<td>".$rowgetcustomer['customeremail']."</td>";
			echo "<td>".$rowgetcustomer['customergender']."</td>";
			echo "<td>".$rowgetcustomer['customerdob']."</td>";
			echo "<td>".$rowgetcustomer['bookingcount']."</td>";
		echo "</tr>";
			}
	else:
		$monthName = date("F", mktime(0, 0, 0, $month, 10));
		echo "<h3>There is no booking in $monthName  $year</h3>";


	endif;
?>