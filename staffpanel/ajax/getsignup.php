<?php
	$q = $_GET['q'];

	include('../../dbconfig/dbconfig.php');

	$sql="SELECT * FROM Customers WHERE DATE(signuptime) = '$q'";
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
		echo "</tr>";
			}
	else:
		echo "<h3>There is no booking in $q</h3>";
	endif;
?>