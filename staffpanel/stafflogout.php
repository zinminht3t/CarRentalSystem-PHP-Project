<?php
	session_start();
	$staffid = $_SESSION['staffid'];
	include('../dbconfig/dbconfig.php');
	$sql = mysql_query("update Staffs set lastlogin = NOW() where staffid = '$staffid'");
	session_destroy();
	header("location: ../adminlogin.php");
?>