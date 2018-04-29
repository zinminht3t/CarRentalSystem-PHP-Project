<?php
	session_start();
	include 'dbconfig/dbconfig.php';
	
	if (!isset($_SESSION['authentication'])) {
		echo "<script>window.location.href = 'index.php';</script>";
	}
	
	$driverid = $_GET['driverid'];
	$customerid = $_GET['customerid'];

	$deleteratingsql = mysql_query("delete from driverratings where customerid = '$customerid' and driverid='$driverid'") or die(mysql_error());

	$updateratingavg = mysql_query("UPDATE drivers SET driverrating = (SELECT AVG(driverrating) FROM driverratings WHERE driverratings.driverid = '$driverid') WHERE drivers.driverid = '$driverid'") or die(mysql_error());
	
	echo "<script>window.location.href = 'drivers.php';</script>";

?>