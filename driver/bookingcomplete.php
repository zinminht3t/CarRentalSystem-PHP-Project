<?php
	if (!isset($_GET['bookingid'])) {
		echo "<script>window.location='ddashboard.php'</script>";
	}

	session_start();

	if (!(isset($_SESSION['driverauth']))) {
		echo "<script>window.location='../driverlogin.php'</script>";
	}

	include('../dbconfig/dbconfig.php');
	$completebookingid = $_GET['bookingid'];

	mysql_query("UPDATE Bookings SET confirmstatus = 'completed' where bookingid = '$completebookingid'");
	echo "<script>window.location='ddashboard.php'</script>";
?>