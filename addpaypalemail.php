<?php

	//to use session
	session_start();

	//for mysql database connection
	include('dbconfig/dbconfig.php');
	
	if (!isset($_SESSION['authentication'])) {
		echo "<script>window.location.href = 'index.php';</script>";
	}
	
	$currentpage = 'index';

	$customerid = $_SESSION['customerid'];

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<!-- Meta, title, CSS, favicons, etc. -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Xero | Add Paypal</title>

		<!-- Bootstrap -->
		<link href="style/bootstrap.min.css" rel="stylesheet">
		<!-- Font Awesome -->
		<link href="fa/css/font-awesome.min.css" rel="stylesheet">
		<!-- Sweet Alert -->
		<link rel="stylesheet" href="style/sweetalert.css">
		<!-- Custom Style -->
		<link href="style/customstyle.css" rel="stylesheet">
		<!-- Site Logo -->
		<link href = "images/design/logo.png" rel="icon" type="image/png">

	</head>

	<body class="other">

		<?php include '_navigationbar.php'; ?> <!-- navigation bar -->

		<div class="container adjustnavpositon">
			<div class="row">
				<div class="col-md-8 col-sm-8 col-xs-12 col-md-offset-2 col-sm-offset-3 main_form" id="main" style="padding: 20px;">
					<div class="pull-center" style="text-align: center">
							<div class="col-md-8 col-md-offset-2">
								<div id="divpaypal">
								<h3>PayPal Address</h3><hr>
									<form method="post">
										<div class="form-group">
											<input type="email" id="paypalemail" name="paypalemail" class="form-control" required="required" placeholder="Paypal Email Address">
										</div>
										<div class="form-group">
											<input type="password" id="paypalpassword" name="paypalpassword" class="form-control" required="required" placeholder="Paypal Password">
										</div>
										<div class="form-group">
											<input type="submit" name="paypalregister" id="paypalregister" class="btn btn-primary">
										</div>
									</form>
								</div>
							</div>
					</div>
				</div>
			</div>
		</div>

			
	</body>

	<!-- jQuery -->
	<script src="javascripts/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="javascripts/bootstrap.min.js"></script>
	<!-- SweetAlert -->
	<script src="javascripts/sweetalert-dev.js"></script>
	<?php
	if (isset($_POST['paypalregister'])) {
		$paypalemail = $_POST['paypalemail'];
		$paypalpassword = $_POST['paypalpassword'];
		$paypalpassword = md5($paypalpassword);
		$registerpaypalsql = mysql_query("insert into paypalserver(paypalemail, paypalpassword, customerid, balance) values('$paypalemail', '$paypalpassword', '$customerid', 10000)") or die(mysql_error());
		echo "<script>swal({
		title: 'Success!',
		text: 'Your paypal account has been updated!',
		type: 'success',
		timer: 1000,
		showConfirmButton: false
		}, function(){
		window.location.href = 'profile.php';
		});</script>";

	}

	?>
</html>