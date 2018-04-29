<?php
	if (!isset($_GET['driverid'])) {
		echo "<script>window.location='mdashboard.php'</script>";
	}

	session_start();
	
	if (!$_SESSION['managerauth']) {
		echo "<script>window.location='../adminlogin.php'</script>";
	}

	include('../dbconfig/dbconfig.php');


	$deletedriverid = $_GET['driverid'];

	mysql_query("Update Drivers set Active = 0 where driverid = '$deletedriverid'");
	echo "<script>window.location='drivermanagement.php'</script>";

?>