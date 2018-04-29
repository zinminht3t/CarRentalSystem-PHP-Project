<?php
	if (!isset($_GET['carid'])) {
		echo "<script>window.location='mdashboard.php'</script>";
	}

	session_start();
	
	if (!$_SESSION['managerauth']) {
		echo "<script>window.location='../adminlogin.php'</script>";
	}

	include('../dbconfig/dbconfig.php');


	$deletecarid = $_GET['carid'];

	mysql_query("delete from bookings where carid = '$deletecarid'") or die(mysql_error());
	mysql_query("delete from OfficeCars where carid = '$deletecarid'");
	echo "<script>window.location='carmanagement.php'</script>";

?>