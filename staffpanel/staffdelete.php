<?php
	if (!isset($_GET['staffid'])) {
		echo "<script>window.location='mdashboard.php'</script>";
	}

	session_start();
	
	if (!$_SESSION['managerauth']) {
		echo "<script>window.location='../adminlogin.php'</script>";
	}

	include('../dbconfig/dbconfig.php');


	$deletestaffid = $_GET['staffid'];

	mysql_query("update Staffs set active = 0 where staffid = '$deletestaffid'");
	echo "<script>window.location='staffmanagement.php'</script>";

?>