<?php
	session_start();
	include 'dbconfig/dbconfig.php';
	
	if (!isset($_SESSION['authentication'])) {
		echo "<script>window.location.href = 'index.php';</script>";
	}

	$carno = $_GET['carno'];
	$customerid = $_GET['customerid'];

	$deleteratingsql = mysql_query("delete from carratings where customerid = '$customerid' and carno='$carno'") or die(mysql_error());

	$updateratingavg = mysql_query("UPDATE cars SET carrating = (SELECT AVG(carrating) FROM carratings WHERE carratings.carno = '$carno') WHERE cars.carno = '$carno'") or die(mysql_error());
	echo "<script>window.location.href = 'cars.php';</script>";

?>